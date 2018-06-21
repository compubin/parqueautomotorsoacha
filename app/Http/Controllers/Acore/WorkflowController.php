<?php namespace App\Http\Controllers;

use App\Models\Chat;
use App\Library\CrudEngine;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class WorkflowController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'chat';
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();
		$this->model = new Chat();
		$this->crudengine = new CrudEngine();			
	}


	public function index( Request $request )
	{
		return view('Acore.workflow.index',$this->data);	
	}

	public function show( Request $request  , $task ) {

		switch($task){

			case 'room';
				$id = $request->input('id');
				$this->data['conversation']	= $this->model->conversation($id);
				return view('chat.conversation', $this->data);	

			break;

			case 'new':
				$this->data['users'] = '';
				return view('chat.users',$this->data);
				break;
		}
		
	}

	public function store( $request) {


		$data = array(
			'chat_id'	=> $request->input('chat_id'),
			'message'	=> $request->input('msg'),
			'user_id'	=> session('uid'),
			'posted'	=> date("Y-m-d H:i:s")
		);
		\DB::table('chat_messages')->insert($data);


		$detail = $this->model->chat_detail($request->input('chat_id'));
		foreach($detail as $d)
		{
			/* send Notification */
			foreach($d['users'] as $user){
				if($user['id'] != session('uid'))
				{
					$data = array(
						'userid'	=> $user['id'],
						'title'		=> 'chat',
						'url'		=> 'chat?start='.$request->input('chat_id'),
						'note'		=> 'New Message',
						'postedBy'	=> session('uid'),
						'is_read'	=> '0'
					); 
					\AppHelper::storeNote( $data );				
				}
			}	
		}
		return response()->json(['status'=>'success']);
		
	}
}