<?php namespace App\Http\Controllers\Acore;

use App\Http\Controllers\Controller;
use App\Library\CrudEngine;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class TemplateController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();
		$this->crudengine = new CrudEngine();			
	}


	public function index( Request $request )
	{
		return view('Acore.template.index',$this->data);	
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


}