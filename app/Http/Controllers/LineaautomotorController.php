<?php namespace App\Http\Controllers;

use App\Models\Lineaautomotor;
use App\Library\CrudEngine;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class LineaautomotorController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'lineaautomotor';
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();
		$this->model = new Lineaautomotor();
		$this->crudengine = new CrudEngine();			
	}

	public function index( Request $request )
	{
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');

		$config = $this->model->connector( $this->module,'id');
		$access = $this->model->getAccess( $config['id'] , session('gid') );
		if(!in_array('list',$access))
			return redirect('dashboard')->with('status', 'error')->with('message','You dont Have access to the page !');
			
		$table 	= $this->crudengine->table( $config['table'])->builder( $config )->button( implode(',',$access) )->render();
		$this->data = array(
			'module'	=> $this->module ,
			'title'		=> $config['title'],
			'note'		=> $config['note'],
			'table'		=> $table
		);	
		return view('lineaautomotor.index',$this->data);
	}	
}