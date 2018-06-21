<?php namespace App\Http\Controllers\Acore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Library\ZipHelpers;
use App\Library\SximoHelpers;
use App\Library\CrudEngine;
use DispatchesJobs, ValidatesRequests;
use Validator, Input, Redirect ;
use Illuminate\Support\Facades\Auth;

class RootController extends Controller
{

	function __construct(  Request $request  )
	{
		parent::__construct();
		$this->middleware(function ($request, $next) {           
            if(session('gid') !='1')
                return redirect('dashboard')
                ->with('message','You Dont Have Access to Page !')->with('status','error');            
            return $next($request);
        });		
		$this->CrudEngine = new CrudEngine();
	}

	function index() {
		return view('Acore.root.dashboard');		
	}
	function menu(  Request $request , $id = null )
	{
		$pos = (!is_null($request->input('pos')) ? $request->input('pos') : 'sidebar' );
		$row = \DB::table('tb_menu')->where('menu_id',$id)->get();
		if(count($row)>=1)
		{
			
			$rows = $row[0];
			$this->data['row'] =  (array) $rows;	
			$this->data['menu_lang'] = json_decode($rows->menu_lang,true);   		
		} else {
			$this->data['row'] = array(
					'menu_id'	=> '',
					'parent_id'	=> '',
					'menu_name'	=> '',
					'menu_type'	=> '',
					'url'	=> '',
					'module'	=> '',
					'position'	=> '',
					'menu_icons'	=> '',
					'active'	=> '',
					'allow_guest'	=> '',
					'access_data'	=> '',

				); 
			$this->data['menu_lang'] = array();    
		}
		$this->data['menus']		= \AppHelper::navigation( $pos ,'all');
		$this->data['groups'] 		= \DB::table('tb_groups')->get();
		$this->data['modules'] 		= \DB::table('tb_module')->get();	
		$this->data['pages'] 		= \DB::table('tb_pages')->where('pagetype','page')->get();			
		$this->data['title']		= 'Menu Management';	
		$this->data['active'] 		= $pos;								
		return view('Acore.root.index',$this->data);	
	}
	public function menu_icon( Request $request ,$id = null  )
	{
		return view('Acore.root.menu.icons');

	}	
	function save_menu( Request $request, $id =0)
	{
		

		$rules = array(
			'menu_name'	=> 'required',	
			'active'	=> 'required',	
			'position'	=> 'required',
			'menu_type'	=> 'required'	
		);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$pos = $request->input('position');	
			$data = array(
				'menu_name'		=> $request->input('menu_name'),
				'module'		=> $request->input('module'),
				'position'		=> $request->input('position'),
				'menu_icons'	=> $request->input('menu_icons'),
				'active'		=> $request->input('active'),
				'menu_type'		=> $request->input('menu_type'),
				'url'			=> $request->input('url'),

			);
			if(config('sximo.cnf_multilang') ==1)
			{
				$lang = \SiteHelpers::langOption();
				$language =array();
				foreach($lang as $l)
				{
					if($l['folder'] !='en'){
						$menu_lang = (isset($_POST['language_title'][$l['folder']]) ? $_POST['language_title'][$l['folder']] : '');  
						$language['title'][$l['folder']] = $menu_lang;        
					}    
				}					
				$data['menu_lang'] = json_encode($language);  
			}									
			$arr = array();
			$groups = \DB::table('tb_groups')->get();
			foreach($groups as $g)
			{
				$arr[$g->group_id] = (isset($_POST['groups'][$g->group_id]) ? "1" : "0" );	
			}
			$data['access_data'] = json_encode($arr);		
			$data['allow_guest'] = $request->input('allow_guest');
			
			if($request->input('menu_id') =='')
			{
				\DB::table('tb_menu')->insert($data);
			} 
			else {
				\DB::table('tb_menu')->where('menu_id', $request->input('menu_id'))->update($data);
			}
			
			return redirect('root/menu?pos='.$pos)
				->with('message', 'Data Has Been Save Successfull')->with('status','success');

		} else {
			$pos = $request->input('position');	
			return redirect('root/menu?pos='.$pos)
				->with('message', 'The following errors occurred')->with('status','error')->withErrors($validator)->withInput();			
		}	
	
	}	
	function save_order( Request $request, $id =0)
	{
		$rules = array(
			'reorder'	=> 'required'
		);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$menus = json_decode($request->input('reorder'),true);			
			$child = array();
			$a=0;
			foreach($menus as $m)
			{			
				if(isset($m['children']))
				{
					$b=0;
					foreach($m['children'] as $l)					
					{
						if(isset($l['children']))
						{
							$c=0;
							foreach($l['children'] as $l2)
							{
								$level3[] = $l2['id'];
								\DB::table('tb_menu')->where('menu_id','=',$l2['id'])
									->update(array('parent_id'=> $l['id'],'ordering'=>$c));
								$c++;	
							}		
						}
						\DB::table('tb_menu')->where('menu_id','=', $l['id'])
							->update(array('parent_id'=> $m['id'],'ordering'=>$b));	
						$b++;
					}							
				}
				\DB::table('tb_menu')->where('menu_id','=', $m['id'])
					->update(array('parent_id'=>'0','ordering'=>$a));
				$a++;		
			}
			return redirect('root/menu')
				->with('message', 'Data Has Been Save Successfull')->with('status','success');
		} else {
			return redirect('root/menu')
				->with('message', 'The following errors occurred')->with('status','error');

		}		
	}
	public function delete_menu(Request $request,$id)
	{
		// delete multipe rows 
		
		$menus = \DB::table('tb_menu')->where('parent_id','=',$id)->get();
		foreach($menus as $row)
		{
			$this->model->destroy($row->menu_id);
		}
		
		\DB::table('tb_menu')->where('menu_id', $id)->delete();
		return redirect('root/menu?pos='.$request->input('pos'))
				->with('message', 'Successfully deleted row!')->with('status','success');

	}	

	function api(  Request $request  )
	{
		$output	= $this->CrudEngine->table('tb_restapi')
			->url('root/api')
			->relation('apiuser','tb_users','id','email')
			->forms('modules','select',['lookup'=> 'tb_module:module_name:module_title','multiple'=>true])
			->forms('apikey','hidden')->forms('created','hidden')
			->validation('modules','required')
			->validation('apiuser','required')
			->call_action('before_save',function(){
				if (isset($_POST['id']))
				{
					$id = (isset($_POST['id']) ? $_POST['id'] : '');
					if ($id =='')
					{
						$x = \SiteHelpers::encryptID(rand(10000,10000000));
						$x .= "-".\SiteHelpers::encryptID(rand(10000,10000000));
						$data['apikey'] = $x;
						$data['created'] = date("Y-m-d");	
						return $data;
					}
				}
							
			})
			->button('create,update,delete')
			->theme('datatable')
			->render();	
		$this->data['table']	= $output;							
		$this->data['title']	= 'Rest API Generator';															
		return view('Acore.root.api',$this->data);	
	}

	function activity(  Request $request  )
	{
		$this->data['table']	= $this->CrudEngine->table('tb_logs')
									->url('root/activity')
									->display('logdate,ipaddress,user_id,module,task,note')
									->relation('user_id','tb_users','id','username')
									->button('delete')
									->theme('datatable')
									->render();	
		$this->data['title']	= 'Users Activities';															
		return view('Acore.root.activity',$this->data);	
	}
	function folder(  Request $request  )
	{
		if(!is_dir(public_path().'/uploads/userfiles/')) mkdir(public_path().'/uploads/userfiles/',0777);
		$groupID = session('gid');
		if($groupID ==1 or $groupID ==2 ) 
		{
			$this->data['folder'] = 'uploads/'; 
		} else {
			$folder = session('uid');
			if(!is_dir('./uploads/userfiles/'.$folder )) mkdir('./uploads/userfiles/'.$folder ,0777);
			$this->data['folder'] = 'uploads/userfiles/'.$folder ; 
			
		}
		$this->data['title']	= 'Media Management';	
		if(!is_null($request->get('cmd')))
		{
			return view('Acore.root.folder.connector',$this->data);

		} else {
			return view('Acore.root.folder.filemanager',$this->data);
		}
									
	}

	function code(  Request $request  )
	{
		$this->data['title']	= 'Source Code Management';								
		return view('Acore.root.code',$this->data);	
	}
    function code_source( Request $request)
    {

        $_POST['dir'] = urldecode($_POST['dir']);
        $root = base_path();
        $res = '';
       

        if( file_exists($root . $_POST['dir']) ) {
            $files = scandir($root . $_POST['dir']);
            natcasesort($files);
            if( count($files) > 2 ) { /* The 2 accounts for . and .. */
                $res .=  "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
                // All dirs
                foreach( $files as $file ) {
                    if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
                         $res .=  "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
                    }
                }
                // All files
                foreach( $files as $file ) {
                    if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
                        $ext = preg_replace('/^.*\./', '', $file);
                         $res .=  "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
                    }
                }
                 $res .=  "</ul>";   
            }

            return $res;
        } else {

            return 'Folder is not exists';
        }
    }    


    function code_edit( Request $request)
    {
        $path = $request->input('path');
        $file = base_path().'/'.$path;
        if(file_exists($file)) {
            return array(
                    'path'  =>  $path ,
                    'content'   => htmlentities(file_get_contents($file))
                );           
        } 
        else {
            return 'error';        
        }
       
    }  

    function code_Save( Request $request )
    {
       
    	$content = $request->input('content_html');
        $filename = base_path().'/'. $request->input('path');
        if(file_exists($filename))
        {
           $fp=fopen($filename,"w+"); 
            fwrite($fp,$content); 
            fclose($fp); 
            return response()->json(['status' => 'success' ,'message'=>  'File has been changed']);
       // Return return json_encode(array());
        } else {
           return response()->json(['status' => 'error' ,'message'=> 'Error while saving changes']);  
        }
       

    }         

	function config(  Request $request  )
	{
		$this->data['title']	= 'General Settings';
		$this->data['groups']	= \DB::table('tb_groups')->get();								
		return view('Acore.root.config',$this->data);	
	}

	function email(  Request $request  )
	{
		$regEmail = base_path()."/resources/views/user/emails/registration.blade.php";
		$resetEmail = base_path()."/resources/views/user/emails/auth/reminder.blade.php";
		$this->data = array(
			'title'			=> 'Email Templates',
			'regEmail' 		=> file_get_contents($regEmail),
			'resetEmail'	=> 	file_get_contents($resetEmail)
		);	
		return view('Acore.root.email',$this->data);			
	}
	function save_email( Request $request)
	{
		
		//print_r($_POST);exit;
		$rules = array(
			'regEmail'		=> 'required|min:10',
			'resetEmail'		=> 'required|min:10',				
		);	
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) 
		{
			$regEmailFile = base_path()."/resources/views/user/emails/registration.blade.php";
			$resetEmailFile = base_path()."/resources/views/user/emails/auth/reminder.blade.php";			
			
			$fp=fopen($regEmailFile,"w+"); 				
			fwrite($fp,$_POST['regEmail']); 
			fclose($fp);	
			
			$fp=fopen($resetEmailFile,"w+"); 				
			fwrite($fp,$_POST['resetEmail']); 
			fclose($fp);
			
			return redirect('root/email')->with('message', 'Email Has Been Updated')->with('status','success');	
			
		}	else {

			return redirect('root/email')->with('message', 'The following errors occurred')->with('status','success')
			->withErrors($validator)->withInput();
		}
	
	}


	public function save_config( Request $request )
	{
           
		$rules = array(
			'cnf_appname'=>'required|min:2',
			'cnf_appdesc'=>'required|min:2',
			'cnf_comname'=>'required|min:2',
			'cnf_email'=>'required|email',
		);
		$validator = Validator::make($request->all(), $rules);	
		if (!$validator->fails()) 
		{
			$logo = '';
			if(!is_null( $request->file('logo')))
			{

				$file =  $request->file('logo'); 
			 	$destinationPath = public_path().'/uploads/images/'; 
				$filename = $file->getClientOriginalName();
				$extension =$file->getClientOriginalExtension(); //if you need extension of the file
				$logo = 'backend-logo.'.$extension;
				$uploadSuccess = $file->move($destinationPath, $logo);
			}

$val  =		"<?php \n"; 
$val  .= 	"return [\n";
	$val  .= 	"'cnf_appname' 			=> '".$request->input('cnf_appname')."',\n";
	$val  .= 	"'cnf_appdesc' 			=> '".$request->input('cnf_appdesc')."',\n";
	$val  .= 	"'cnf_comname' 			=> '".$request->input('cnf_comname')."',\n";
	$val  .= 	"'cnf_email' 			=> '".$request->input('cnf_email')."',\n";
	$val  .= 	"'cnf_metakey' 			=> '".$request->input('cnf_metakey')."',\n";
	$val  .= 	"'cnf_metadesc' 		=> '".$request->input('cnf_metadesc')."',\n";
	$val  .= 	"'cnf_group' 			=> '".$request->input('cnf_group')."',\n";
	$val  .= 	"'cnf_activation' 		=> '".$request->input('cnf_activation')."',\n";
	$val  .= 	"'cnf_multilang' 		=> '".(!is_null($request->input('cnf_multilang')) ? 1 : 0 )."',\n";
	$val  .= 	"'cnf_lang' 			=> '".$request->input('cnf_lang')."',\n";
	$val  .= 	"'cnf_regist' 			=> '".(!is_null($request->input('cnf_regist')) ? 'true':'false')."',\n";
	$val  .= 	"'cnf_front' 			=> '".(!is_null($request->input('cnf_front')) ? 'true':'false')."',\n";
	$val  .= 	"'cnf_recaptcha' 		=> '".(!is_null($request->input('cnf_recaptcha')) ? 'true':'false')."',\n";
	$val  .= 	"'cnf_theme' 			=> '".$request->input('cnf_theme')."',\n";
	$val  .= 	"'cnf_backend' 			=> '".$request->input('cnf_backend')."',\n";
	$val  .= 	"'cnf_recaptchapublickey' => '".$request->input('cnf_recaptchapublickey')."',\n";
	$val  .= 	"'cnf_recaptchaprivatekey' => '".$request->input('cnf_recaptchaprivatekey')."',\n";
	$val  .= 	"'cnf_mode' 			=> '".(!is_null($request->input('cnf_mode')) ? 'production' : 'development' )."',\n";
	$val  .= 	"'cnf_logo' 			=> '".($logo !=''  ? $logo : config('sximo.cnf_logo'))."',\n";
	$val  .= 	"'cnf_allowip' 			=> '".$request->input('cnf_allowip')."',\n";
	$val  .= 	"'cnf_restrictip' 		=> '".$request->input('cnf_restrictip')."',\n";
	$val  .= 	"'cnf_mail' 			=> '".$request->input('cnf_mail')."',\n";
	$val  .= 	"'cnf_maps' 			=> '".$request->input('cnf_maps')."',\n";
	$val  .= 	"'cnf_date' 			=> '".(!is_null($request->input('cnf_date')) ? $request->input('cnf_date') : 'Y-m-d' )."',\n";
$val  .= 	"];\n";
	
			$filename = base_path().'/config/sximo.php';
			$fp=fopen($filename,"w+"); 
			fwrite($fp,$val); 
			fclose($fp); 
			return redirect('root/config')->with('message','Setting Has Been Save Successful')->with('status','success');
		} else {
			return redirect('root/config')->with('message', 'The following errors occurred')->with('status','success')
			->withErrors($validator)->withInput();
		}			
	
	}	

	public function log()
	{
		
		$dir = base_path()."/storage/logs";	
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
			{
				//removedir($file);
			} else {

				unlink($file);
			}
		}

		$dir = base_path()."/storage/framework/views";	
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
			{
				//removedir($file);
			} else {
				
				unlink($file);
			}
		}		

		return response()->json(array(
			'status'	=>__('core.note_t_success'),
			'message'	=>  __('core.note_success_action')
		));	
	}

	public function widgets() {

		$output	= $this->CrudEngine->table('tb_widgets')
			->url('root/widgets')
			->display('name,access,template,status')
			->forms('access','select',['lookup'=> 'tb_groups:group_id:name','multiple'=>true])
			->validation_array(['name'=>'required','template'=>'required','access'=>'required','status'=>'required'])
			->format(['access'=>'lookup|tb_groups:group_id:name'])
			->call_action('after_delete',function( $data ){
				

			})
			->render();	

		$this->data['table']	= $output;							
		$this->data['title']	= 'Widget Managements';															
		return view('Acore.root.widgets',$this->data);

	}


	public function version( Request $request ) {


		$path = base_path()."/resources/views/Acore/root/version.json";
		$curr_version = file_get_contents($path) or die ('ERROR');
		$curr_version = json_decode($curr_version,true);


		if(isset($_POST['process']))
		{
			$version = $request->input('version');
			$email = $request->input('email');
			$password = $request->input('password');
			$uname = $email.'|'.$password ;	
			$temp = public_path()."/uploads/zip/". $version.'.zip';
			if ( !is_file(  $temp )) 
			{
				$message =  '';
				$getVersions = file_get_contents('http://sximo5.net/upgrade?codename=ultimate') or die ('ERROR');
				$newUpdate = file_get_contents('http://sximo5.net/upgrade/download?codename=ultimate&uname='.$uname);
				$test = json_decode($newUpdate,true);
				if(count($test) >=1 ){
					$result = json_decode($newUpdate,true);
					return response()->json(['status'=>'error','message'=> $result['message']]);	
				} else {					
					$dlHandler = fopen($temp, 'w');
					if ( !fwrite($dlHandler, $newUpdate) ) { echo '<p>Could not save new update. Operation aborted.</p>'; exit(); }
					fclose($dlHandler);

					$getVersions =json_decode($getVersions,true) ;
					if(\SximoHelpers::upgrade( $temp))
					{
						$message .= ' Update successfull ! <p> <b> Sximo Updated to version : </b> '. $getVersions['Version'] .'</p>' ;
						$change_version = 
						$fp=fopen($path,"w+"); 				
						fwrite($fp, json_encode($getVersions)); 
						fclose($fp);	
					} 				
					unlink($temp);
					
					return response()->json(['status'=>'success','message'=>$message]);
				}	

			}
			return response()->json(['status'=>'error','message'=>'Everything is Updated !']);
		}
		

		$check = (!is_null($request->input('check')) ? true : false );


		if($check){

			
			ini_set('max_execution_time',60);
			//Check For An Update
			$getVersions = file_get_contents('http://sximo5.net/upgrade?codename=ultimate') or die ('ERROR');
			
			if ($getVersions != '')
			{
				$checkVersion =  json_decode($getVersions,true);
			}
			
			if(strtotime($checkVersion['Build']) > strtotime( $curr_version['Build'] ))
			{
				return response()->json(['status'=>'success','message'=>'Updates Available !','version'=> '2.0.1']);
			} 
			else {
				return response()->json(['status'=>'error','message'=>'No Updates Available']);
			}


		} else {
			$this->data['version'] = $curr_version;
			return view('Acore.root.version',$this->data);
		}	

	}


}	