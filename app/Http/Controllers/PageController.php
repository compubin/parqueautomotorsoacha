<?php  namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Markdown;
use App\Models\Sximo;
use Mail;
use Validator, Input, Redirect ; 

class PageController extends Controller {

	public function __construct()
	{
		parent::__construct();
	}	
	public function index( Request $request) 
	{
        \App::setLocale(\Session::get('lang'));

		if(config('sximo.cnf_front') =='false' && $request->segment(1) =='' ) :
			return redirect('dashboard');
		endif; 	

		$page = $request->segment(1);
		\DB::table('tb_pages')->where('alias',$page)->update(array('views'=> \DB::raw('views+1')));

		
		if($page !='') {
			$sql = \DB::table('tb_pages')->where('alias','=',$page)->where('status','=','enable')->get();
			$row = $sql[0];
			if(file_exists(base_path().'/resources/views/layouts/'.config('sximo.cnf_theme').'/template/'.$row->filename.'.blade.php') && $row->filename !='')
			{
				$page_template = 'layouts.'.config('sximo.cnf_theme').'.template.'.$row->filename;
			} else {
				$page_template = 'layouts.'.config('sximo.cnf_theme').'.template.page';
			}	
			$this->data['pages'] = $page_template;				
			$this->data['title'] = $row->title ;
			$this->data['subtitle'] = $row->sinopsis ;
			$this->data['pageID'] = $row->pageID ;
			$this->data['content'] = \AppHelper::formatContent($row->note);
			$this->data['note'] = $row->note;
			$page = 'layouts.'.config('sximo.cnf_theme').'.index';
			if($row->template =='frontend'){
				$page = 'layouts.'.config('sximo.cnf_theme').'.index';
			}
			else {
				return view($page_template, $this->data);
				
			}	
			return view( $page, $this->data);			
		}
		else {
			$sql = \DB::table('tb_pages')->where('default','1')->get();
			if(count($sql)>=1)
			{
				$row = $sql[0];
				$this->data['title'] = $row->title ;
				$this->data['subtitle'] = $row->sinopsis ;
				if(file_exists(base_path().'/resources/views/layouts/'.config('sximo.cnf_theme').'/template/'.$row->filename.'.blade.php') && $row->filename !='')
				{
					$page_template = 'layouts.'.config('sximo.cnf_theme').'.template.'.$row->filename;
				} else {
					$page_template = 'layouts.'.config('sximo.cnf_theme').'.template.page';
				}				
				$this->data['pages'] = $page_template;
				$this->data['pageID'] = $row->pageID ;
				$this->data['content'] = \AppHelper::formatContent($row->note);
				$this->data['note'] = $row->note;
				$page = 'layouts.'.config('sximo.cnf_theme').'.index';


				return view( $page, $this->data);	

			} else {
				return 'Please Set Default Page';
			}	
		}
	}
	public  function  contact( Request $request)
	{
		$rules = array(
				'name'		=>'required',
				'subject'	=>'required',
				'message'	=>'required|min:20',
				'email'	=>'required|email'			
		);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) 
		{			
			$data = array('name'=>$request->input('name'),'sender'=>$request->input('sender'),'subject'=>$request->input('subject'),'notes'=>$request->input('message')); 
			$message = view('emails.contact', $data); 		
			$data['to'] = config('sximo.cnf_email');			
			if(config('sximo.cnf_mail') =='swift')
			{ 
				Mail::send('user.emails.contact', $data, function ($message) use ($data) {
		    		$message->to($data['to'])->subject($data['subject']);
		    	});	
			} 
			else {

				$headers  	= 'MIME-Version: 1.0' . "\r\n";
				$headers 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers 	.= 'From: '.$request->input('name').' <'.$request->input('sender').'>' . "\r\n";
					mail($data['to'],$data['subject'], $message, $headers);		
			}
			return redirect()->back()->with(['message'=>'Thank You , Your message has been sent !','status'=>'success']);	
				
		} else {
			return redirect()->back()->with(['message'=>'The following errors occurred','status'=>'error'])->withErrors($validator)->withInput();
		}		
	}	
	public function posts( Request $request , $read = '') 
	{
		$posts = \DB::table('tb_pages')
					->select('tb_pages.*','tb_users.username',\DB::raw('COUNT(commentID) AS comments'))
					->leftJoin('tb_users','tb_users.id','tb_pages.userid')
					->leftJoin('tb_comments','tb_comments.pageID','tb_pages.pageID')
					->groupBy('tb_pages.pageID')
					->where('pagetype','post');
					if($read !='') {
						$posts = $posts->where('alias', $read )->get(); 
					} 
		else {

			$posts = $posts->paginate(12);
		}					

		$this->data['title']		= 'Post Articles';
		$this->data['posts']		= $posts;
		$this->data['pages']		= 'secure.posts.posts';
		base_path().'/resources/views/layouts/'.config('sximo.cnf_theme').'/blog/index.blade.php';

		if(file_exists(base_path().'/resources/views/layouts/'.config('sximo.cnf_theme').'/blog/index.blade.php'))
		{
			$this->data['pages'] = 'layouts.'.config('sximo.cnf_theme').'.blog.index';
		}	

		if($read !=''){
			if(file_exists(base_path().'/resources/views/layouts/'.config('sximo.cnf_theme').'/blog/view.blade.php'))
			{
				if(count($posts))
				{
					$this->data['posts'] = $posts[0];
					$this->data['comments']	= \DB::table('tb_comments')
												->select('tb_comments.*','username','avatar','email')
												->leftJoin('tb_users','tb_users.id','tb_comments.UserID')
												->where('PageID',$this->data['posts']->pageID)
												->get();
					\DB::table('tb_pages')->where('pageID',$this->data['posts']->pageID)->update(array('views'=> \DB::raw('views+1')));						
				} else {
					return redirect('posts');
				}	
				$this->data['title']		= $this->data['posts']->title;
				$this->data['pages'] = 'layouts.'.config('sximo.cnf_theme').'.blog.view';

			}	
		}	
		$page = 'layouts.'.config('sximo.cnf_theme').'.index';
		return view( $page , $this->data);	
	}
	public function comment( Request $request)
	{
		$rules = array(
			'comments'	=> 'required'
		);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {

			$data = array(
					'userID'		=> \Session::get('uid'),
					'posted'		=> date('Y-m-d H:i:s') ,
					'comments'		=> $request->input('comments'),
					'pageID'		=> $request->input('pageID')
				);

			\DB::table('tb_comments')->insert($data);
			return redirect('posts/'.$request->input('alias'))
        		->with(['message'=>'Thank You , Your comment has been sent !','status'=>'success']);
		} else {
			return redirect('posts/'.$request->input('alias'))
				->with(['message'=>'The following errors occurred','status'=>'error']);	
		}
	}

	public function remove( Request $request, $pageID , $alias , $commentID )
	{
		if($commentID !='')
		{
			\DB::table('tb_comments')->where('commentID',$commentID)->delete();
			return redirect('posts/'.$alias)
				->with(['message'=>'Comment has been deleted !','status'=>'success']);
       
		} else {
			return redirect('posts/'.$alias)
				->with(['message'=>'Failed to remove comment !','status'=>'error']);
		}
	}

	public function notification()
	{	
		$result = \DB::table('tb_notification')
					->where('userid',session('uid'))
					->where('is_read','0')
					->orderBy('created','desc')->limit(5)->get();

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
					$image = \AppHelper::avatar('20', $row->postedBy);
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

	public function loadNotif(  Request $request )
	{	
		return response()->json(Sximo::notif_msg(session('uid')));


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


	public function  lang( Request $request , $lang='en')
	{
		session(['lang'=> $lang]);
		return  back();
	}

	public function submit( Request $request )
	{
		$formID = $request->input('form_builder_id');
		$rows = \DB::table('tb_forms')->where('formID',$formID)->get();
		if(count($rows))
		{
			$row = $rows[0];
			$forms = json_decode($row->configuration,true);
			$content = array();
			$validation = array();
			foreach($forms as $key=>$val)
			{
				$content[$key] = (isset($_POST[$key]) ? $_POST[$key] : ''); 
				if($val['validation'] !='')
				{
					$validation[$key] = $val['validation'];
				}
			}
			
			$validator = Validator::make($request->all(), $validation);	
			if (!$validator->passes()) 
					return redirect()->back()->with(['status'=>'error','message'=>'Please fill required input !'])
							->withErrors($validator)->withInput();


			
			if($row->method =='email')
			{
				// Send To Email
				$data = array(
					'email'		=> $row->email ,
					'content'	=> $content ,
					'subject'	=> "[ " .config('sximo.cnf_appname')." ] New Submited Form ",
					'title'		=> $row->name 			
				);
			
				if( config('sximo.cnf_mail') =='swift' )
				{ 				
					\Mail::send('Acore.root.form.email', $data, function ( $message ) use ( $data ) {
			    		$message->to($data['email'])->subject($data['subject']);
			    	});		

				}  else {

					$message 	 = view('Acore.root.form.email', $data);
					$headers  	 = 'MIME-Version: 1.0' . "\r\n";
					$headers 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers 	.= 'From: '. config('sximo.cnf_appname'). ' <'.config('sximo.cnf_email').'>' . "\r\n";
						mail($data['email'], $data['subject'], $message, $headers);	
				}
				
				return redirect()->back()->with(['status'=>'success','message'=> $row->success ]);

			} else {
				// Insert into database 
				\DB::table($row->tablename)->insert($content);
				return redirect()->back()->with(['status'=>'success','message'=>  $row->success  ]);
			
			}
		} else {

			return redirect()->back()->with(['status'=>'error','message'=>'Cant process the form !']);
		}


	}

	public function set_theme( $id ){
		session(['set_theme'=> $id ]);
		return response()->json(['status'=>'success']);
	}

}	