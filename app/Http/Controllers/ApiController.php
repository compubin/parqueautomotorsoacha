<?php namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sximo;
use App\Library\CrudEngine;
use Validator, Input, Redirect ; 

class ApiController extends Controller {

	public function __construct( Request $request)
	{
		parent::__construct();
		if (!app()->runningInConsole()) {
			$this->model = new Sximo();	
			$this->crudengine = new CrudEngine();
			$this->config = $this->model->connector( $request->input('c'));	
			$this->controller = $request->input('c');
			$this->check = $this->authentication( $request);
		}			
	}

	public function index( Request $request ) 
	{	
		if(is_array($this->check))
			return response()->json($this->check);

		$result 	= $this->crudengine->table( $this->config['table'])->theme('default')->callback('api');			
		$result['control']['next_page_url'] = $result['control']['next_page_url'] .'&c='.$this->controller;
		return response()->json($result);
	
	}
	public function show( Request $request , $id ) 
	{
		if(is_array($this->check))
			return response()->json($this->check);

		$result 	= $this->crudengine->table( $this->config['table'])->filter($id)->theme('default')->callback('api');	
		unset($result['total']);unset($result['control']);		
		return response()->json($result);			
	}
	public function update( Request $request , $id ) 
	{	
		if(is_array($this->check))
			return response()->json($this->check);

		$rules = $this->config['validation'];
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = array();
			foreach($this->config['forms'] as $key=>$val)
			{
				if(!is_null($request->input( $key )))
				{
					$data[ $this->config['table'].'.'.$key ] = $request->input($key);	
				}	
			}
			if(count($data))
				\DB::table( $this->config['table'])->where($this->config['key'], $id )->update($data);
			return response()->json(['status'=>'success','message'=>'row updated succesfully']);
		} 
		else {
			return response()->json(['status'=>'error','message'=>'Operation Failed !']);
		}
	}
	public function store( Request $request ) 
	{
		if(is_array($this->check))
			return response()->json($this->check);

		$rules = $this->config['validation'];
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = array();
			foreach($this->config['forms'] as $key=>$val)
			{
				if(!is_null($request->input( $key )))
				{
					$data[ $this->config['table'].'.'.$key ] = $request->input($key);	
				}	
			}
			if(count($data))
				\DB::table( $this->config['table'])->insert($data);
			return response()->json(['status'=>'success','message'=>'row added succesfully']);
		} 
		else {
			return response()->json(['status'=>'error','message'=>'Operation Failed']);
		}	
	}
	public function destroy( Request $request , $id ) 
	{
		if(is_array($this->check))
			return response()->json($this->check);	
		
		\DB::table($this->config['table'])->where( $this->config['key'],$id)->delete();
		return response()->json(['status'=>'success','message'=>'row deleted succesfully']);
			
	}	
	public static function authentication( $request )
	{

		if(is_null($request->input('c'))) 
				return array(array('status'=>'error','message'=>' Please Define Module Name to accessed '),400);		
					
			if(!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW']))
			{
		        return array([
		            'error' => true,
		            'message' => 'Not authenticated',
		            'code' => 401], 401
		        );		
			} else {
				
				$user = $_SERVER['PHP_AUTH_USER'];
				$key = $_SERVER['PHP_AUTH_PW'];
				
				$auth = \DB::table('tb_restapi')
						->join('tb_users', 'tb_users.id', '=', 'tb_restapi.apiuser')
						->where('tb_restapi.apikey',$key)->where("tb_users.email",$user)->get();

				
				if(count($auth) <=0 )
				{
					 return array([
						'error' => true,
						'message' => 'Invalid authenticated params !',
						'code' => 401], 401
					);	
				}  else {
				
					$row = $auth[0];
					$modules = explode(',',str_replace(" ","",$row->modules));
					if(!in_array($request->input('c'), $modules))
					{				
						 return array([
							'error' => true,
							'message' => 'You Dont Have Authorization Access!',
							'code' => 401], 401
						);				
					} 		
				
				}
			}			
	}		

}