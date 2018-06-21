<?php namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Library\CrudEngine;
use App\User;
class DashboardController extends Controller {

	public function __construct()
	{
		parent::__construct();
		
        $this->data = array(
            'pageTitle' => config('sximo.cnf_appaname'),
            'pageNote'  =>  'Welcome to Dashboard',
            
        );
        $this->CrudEngine = new CrudEngine();			
	}

	public function index( Request $request )
	{
		$info =	User::find(\Auth::user()->id);	
		$my_widget = json_decode($info->config,true);
		$widgets = array();
		if(isset($my_widget['widgets'])){
			$widgets = $my_widget['widgets'];
		} 

		$config_widgets = \AppHelper::widgets();
		$show_widget =array();
		$selected_widget = array();
		foreach( $config_widgets as $row )
		{
			if(in_array($row->widget_id, $widgets))
			{
				$show_widget[] = $row ;
				$selected_widget[] = $row->widget_id ;
			}
		}
		
		$this->data['my_widget']= $show_widget;
		$this->data['selected_widget']= $selected_widget;
		$this->data['widgets']= $config_widgets;
		return view('dashboard.index',$this->data);
	}	


	public function sortcut( Request $request )
	{
		return view('dashboard',$this->data);
	}	

	public function store( Request $request  ){

		$info =	User::find(\Auth::user()->id);	
		$my_widget = json_decode($info->config,true);
		$data = array();
		if (count($my_widget)<=0) {
			$my_widget = array();	
		}
		$widgets = $request->input('widget');
		for ($i=0; $i<count($widgets); $i++){
			$data[] = $widgets[$i];
		}
		$config = array_merge($my_widget ,['widgets'=> $data]);
		\DB::table('tb_users')->where('id',session('uid'))->update(['config'=> json_encode($config)]);
		return response()->json(['status'=>'success']);



	}


	public function show( Request $request , $task ) {

		switch ($task) {
			case 'dropzone':
				return $this->dropzone( $request );
				break;
			case 'note':
				return $this->note( $request );
				break;			
			default:
				# code...
				break;
		}

	}

	function dropzone(  Request $request  )
	{
		if(!is_dir(public_path().'/uploads/userfiles/')) 
			mkdir(public_path().'/uploads/userfiles/',0777);
		$groupID = session('gid');
		if($groupID ==1 ) 
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
			return view('dashboard.dropzone',$this->data);
		}			
				
									
	}

	function note(  Request $request  )
	{
		$output	= $this->CrudEngine->table('tb_notes')
			->where("user_id",'=',session('uid'))
			->url('dashboard/note')->theme('default')
			->template([
					'table'	=>'dashboard.note.view',
					'form'	=>'dashboard.note.form'
					])
			->render();
			//->callback('api');	
		//dd($output);	
		$this->data['output'] = $output;	
		return view('dashboard.note.index',$this->data);
	}	
}