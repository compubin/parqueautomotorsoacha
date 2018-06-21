<?php namespace App\Http\Controllers\Acore;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Sximo;
use App\Library\CrudEngine;
use DispatchesJobs, ValidatesRequests;
use Validator, Input, Redirect ;
use Illuminate\Support\Facades\Auth;

class SecureController extends Controller
{

    function __construct(  Request $request  )
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if(session('gid') !='1' and session('gid') !='2')
                return redirect('dashboard')
                    ->with('message','You Dont Have Access to Page !')->with('status','error');
            return $next($request);
        });
        $this->CrudEngine = new CrudEngine();
    }
    function index(  Request $request  )
    {
        $this->data['last_activity'] = Sximo::last_activity();
        $this->data['dashboard'] = Sximo::cms_dashboard();
        $users = Sximo::users_dashboard();

        $pie = (object) array(
            'Active'		=> ceil(($users->Active / $users->Total ) * 100),
            'Unconfirmed'	=> ceil(($users->Unconfirmed / $users->Total ) * 100),
            'Banned'		=> ceil(($users->Banned / $users->Total ) * 100),
        );
        $this->data['pie'] = $pie ;
        $this->data['users'] = $users ;
        $this->data['chart'] = Sximo::users_registration_history();
        return view('Acore.secure.dashboard',$this->data);
    }
    function users(  Request $request  )
    {
        $output =  $this->CrudEngine->table('tb_users')
            ->title('Users')
            ->url('secure/users')
            ->join('group_id','tb_groups', 'group_id' )
            ->display('username ,first_name,last_name , email , group_id')
            ->relation('group_id','tb_groups','group_id','name')
            ->format(['avatar'=>'image|/uploads/users/'])
            ->forms('avatar','image',['path'=>'/uploads/users/','type'=>'image'])
            ->forms('password','password')
            ->forms('active','select',['options'=>'0:Inactive,1:Active,2:Banned'])
            ->validation('username','required|unique:tb_users')
            ->validation('email','required|email|unique:tb_users')
            ->validation('first_name','required')
            ->template(['form'=>'Acore.secure.edit_user'])
            ->where('tb_groups.level','>',session('level'))
            ->render();
        $this->data['table']	= $output ;
        $this->data['title']	= __('core.m_users');

        return view('Acore.secure.users',$this->data);
    }

    function groups(  Request $request  )
    {
        $this->data['table'] =  $this->CrudEngine->table('tb_groups')
            ->title(' Groups Management')
            ->url('secure/groups')
            ->display('name,level')
            ->theme('datatable')
            ->order_by('level','ASC')
            ->validation('name','required')
            ->validation('level','required')
            ->render();
        $this->data['title']	= __('core.m_groups');
        return view('Acore.secure.groups',$this->data);
    }

    function pages(  Request $request  )
    {
        $groups = \DB::table('tb_groups')->get();
        $output =  $this->CrudEngine->table('tb_pages')
            ->where('pagetype','=','page')
            ->url('secure/pages')
            ->title(' Pages Management')
            ->display('title,alias,status,created,default')
            ->button('create,update,delete')
            ->forms('access','select',['lookup'=>'tb_groups:group_id:name','multiple'=>true])
            ->forms('default','radio',['options'=>'0:No,1:Yes'])
            ->template(['form'=>'Acore.secure.edit_page'])
            ->call_action('before_save',function($post) {
                $data = array();
                if(isset($post['pageID']))
                {
                    if (isset($post['alias']) && $post['alias'] !='')
                    {
                        $data['alias'] = \AppHelper::slug( $post['alias'] );
                    }
                    else{
                        $data['alias'] = \AppHelper::slug( $post['title'] );
                    }
                    $data['updated'] = date('Y-m-d H:i:s');
                    if($post['pageID'] =='')
                        $data['created'] = date('Y-m-d H:i:s');

                    if(isset($_POST['default']) && $_POST['default'] == 1)
                        \DB::table('tb_pages')->update(['default'=>'0']);

                } else {
                    $data['Created'] = date('Y-m-d H:i:s');
                }
                return $data;
            })
            ->call_action('after_save',function($post){
                $this->route_render();
            })
            ->call_action('after_delete',function($post){
                $this->route_render();
            });

        if(!is_null($request->input('mode')))
            $output = 	$output->template(['form'=>'Acore.secure.edit_page_quick']);

        $output = $output->theme('datatable')
            ->render();


        $this->data['table']	= $output ;
        $this->data['title']	= 'Pages Management';
        return view('Acore.secure.pages',$this->data);
    }

    function live_editor_page(  Request $request  )
    {

    }

    function posts(  Request $request  )
    {
        $output =  $this->CrudEngine->table('tb_pages')
            ->where('pagetype','=','post')
            ->url('secure/posts')
            ->title(' Blog Post Management')
            ->display('created,title,alias,status')
            ->forms('note','editor')
            ->forms('access','select',['lookup'=>'tb_groups:group_id:name','multiple'=>true])
            ->forms('image','upload',['path'=>'/uploads/images/'])
            ->display('title,alias,created,tags,status')
            ->template(['form'=>'Acore.secure.edit_post'])
            ->call_action('before_save',function($post){
                $data = '';
                if(isset($post['pageID']))
                {
                    if (isset($post['alias']) && $post['alias'] !='')
                    {
                        $data['alias'] = \AppHelper::slug( $post['alias'] );
                    }
                    else{
                        $data['alias'] = \AppHelper::slug( $post['title'] );
                    }
                    $data['updated'] = date('Y-m-d H:i:s');
                }
                return $data;
            })
            ->render();
        $this->data['table']	= $output ;
        $this->data['title']	= 'Blog/Post Management';
        return view('Acore.secure.posts',$this->data);
    }

    function blast( )
    {

        $this->data['groups']	= \DB::table('tb_groups')->get();
        $this->data['title']	= __('core.t_blastemail');
        return view('Acore.secure.blast',$this->data);
    }

    function doblast( Request $request)
    {

        $rules = array(
            'subject'		=> 'required',
            'message'		=> 'required|min:10',
            'groups'		=> 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes())
        {
            $data = array();
            if(!is_null($request->input('groups')))
            {
                $count = 0;
                $groups = $request->input('groups');
                for($i=0; $i<count($groups); $i++)
                {
                    if($request->input('uStatus') == 'all')
                    {

                        $users = \DB::table('tb_users')->where('group_id','=',$groups[$i])->get();
                    } else {
                        $users = \DB::table('tb_users')->where('active','=',$request->input('uStatus'))->where('group_id','=',$groups[$i])->get();
                    }


                    foreach($users as $row)
                    {
                        $data['note'] 	= $request->input('message');
                        $data['row']		= $row;
                        $data['to']			= $row->email;
                        $data['subject']	= $request->input('subject');
                        $data['cnf_appname'] = config('sximo.cnf_appname');


                        if(config('sximo.cnf_mail') && config('sximo.cnf_mail') =='swift')
                        {
                            \Mail::send('core.users.email', $data, function ($message) use ($data) {
                                $message->to($data['to'])->subject($data['subject']);
                            });

                        } else {
                            $message = view('core.users.email',$data);
                            $headers  = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            $headers .= 'From: '.$this->config['cnf_appname'].' <'.$this->config['cnf_email'].'>' . "\r\n";
                            mail($data['to'], $data['subject'], $message, $headers);

                        }

                        ++$count;
                    }

                }
                return redirect('secure/blast')->with('messagetext','Total '.$count.' Message has been sent')->with('msgstatus','success');

            }
            return redirect('secure/blast')->with('messagetext','No Message has been sent')->with('msgstatus','info');


        } else {

            return redirect('secure/blast')->with('messagetext', 'The following errors occurred')->with('msgstatus','error')
                ->withErrors($validator)->withInput();

        }
    }
    function route_render()
    {
        $rows = \DB::table('tb_pages')->where('pageID','!=','1')->where('pagetype','page')->get();
        $val  =	"<?php \n";
        foreach($rows as $row)
        {

            $slug = $row->alias;
            $val .= "Route::get('{$slug}', 'PageController@index');\n";
        }
        $val .= 	"?>";
        $filename = base_path().'/routes/pages.php';
        $fp=fopen($filename,"w+");
        fwrite($fp,$val);
        fclose($fp);


    }

    function notification(  Request $request  )
    {
        // Set all notification to `read` state
        if(!\Auth::check())
            return redirect('dashboard');

        \DB::table('tb_notification')->where('userid',session('gid'))->update(['is_read'=>'1']);
        $this->data['table'] =  $this->CrudEngine->table('tb_notification')
            ->title('My Notification')
            ->display('auditID,created,title,note')
            ->display_view('url,title,note,created')
            ->button('view,delete')
            ->format(['title'=>'link|{url}|modal'])
            ->theme('datatable')
            ->render();
        $this->data['title']	= 'My Notification';
        return view('Acore.secure.notification',$this->data);
    }

    public function loadNotif(  Request $request )
    {
        $result = \DB::table('tb_notification')->where('userid',\Session::get('uid'))->where('is_read','0')->orderBy('created','desc')->limit(5)->get();

        $data = array();
        $i = 0;
        foreach($result as $row)
        {
            if(++$i <=10 )
            {
                if($row->postedBy =='' or $row->postedBy == 0)
                {
                    $image = '<img src="'.asset('uploads/images/system.png').'" border="0" width="20" class="img-circle" />';
                } else {
                    $image = \SiteHelpers::avatar('30', $row->postedBy);
                }
                $data[] = array(
                    'url'	=> $row->url,
                    'title'	=> $row->title ,
                    'icon'	=> $row->icon,
                    'image'	=> $image,
                    'text'	=> substr($row->note,0,100),
                    'date'	=> date("d/m/y",strtotime($row->created))
                );
            }
        }
        $data = array(
            'total'	=> count($result) ,
            'note'	=> $data
        );
        return response()->json($data);
    }

    public function content( Request $request , $task ) {

        $output =  $this->CrudEngine->table('tb_contents')
            ->title('Content')
            ->url('secure/content/'.$task)
            ->display('Title,ShortCode')
            ->validation('Title','required')

            ->append_data(['cms_type'=>$task])
            ->call_action('before_save',function(  ){
                $task = $_POST['Type'];
                $data['Contents'] = $this->save_content( $task  );
                return $data;
            })
            ->call_action('after_save',function( $data ){
                $task = $_POST['Type'];
                $ShortCode = "[sc:cms fnc=".$task."|id=".$data['CmsID']." ] [/sc]";
                \DB::table('tb_contents')->where('CmsID',$data['CmsID'])->update(['ShortCode'=> $ShortCode ]);
            })->button('create,update,delete');

        switch($task)
        {
            default :
                return view('Acore.secure.content.home',$this->data);
                break;

            case 'testimonial':
                $output = $output->where('Type','=' ,$task)->template(['form'=>'Acore.secure.content.form_testimonial']);
                break;

            case 'gallery':
                $output = $output->where('Type','=' ,$task)->template(['form'=>'Acore.secure.content.form_gallery']);
                break;

            case 'browse':
                return view('Acore.secure.content.browse');
                break;

            case 'faq':
                $output = $output->where('Type','=' ,$task)->template(['form'=>'Acore.secure.content.form_faq']);
                break;

            case 'portpolio':
                $output = $output->where('Type','=', $task)->template(['form'=>'Acore.secure.content.form_portpolio']);
                break;
        }
        $this->data['table'] 	= $output->theme('default')->render();
        $this->data['cms_type'] 	= $task;
        return view('Acore.secure.content.index',$this->data);


    }

    public function save_content( $task )
    {

        if($task =='faq')
        {
            $total = $_POST['question'];
            $content = array();
            for($i=0; $i<count($total); $i++)
            {
                if(  $_POST['question'][$i] != ''  &&  $_POST['answer'][$i] != '') {
                    $content[] = array(
                        'question'	=> $_POST['question'][$i],
                        'answer'	=> $_POST['answer'][$i],

                    );
                }
            }
        }


        if($task =='gallery')
        {
            $content = array();
            if(isset($_POST['name']))
            {
                $total = $_POST['name'];
                for($i=0; $i<count($total); $i++)
                {
                    if(  $_POST['name'][$i] != '' ) {
                        $content[] = array(
                            'name'		=> $_POST['name'][$i],
                            'image'		=> $_POST['image'][$i],
                            'caption'	=> $_POST['caption'][$i],

                        );
                    }
                }
            }
        }

        if($task =='testimonial')
        {
            $total = $_POST['written'];
            $content = array();
            for($i=0; $i<count($total); $i++)
            {
                if(  $_POST['written'][$i] != ''  &&  $_POST['note'][$i] != '') {
                    $content[] = array(
                        'note'	=> $_POST['note'][$i],
                        'written'	=> $_POST['written'][$i],

                    );
                }
            }
        }

        return json_encode($content);

    }

    public function about( Request $request)
    {
        return view('Acore.secure.about');
    }
}