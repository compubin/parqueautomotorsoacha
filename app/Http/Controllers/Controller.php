<?php namespace App\Http\Controllers;
use Mail;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Validator, Input, Redirect ;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController {

	use DispatchesJobs, ValidatesRequests;

	protected $user_id ;
	protected $users ;

	public function __construct()
	{
		
		$this->middleware('ipblocked');

        $driver             = config('database.default');
        $database           = config('database.connections');
       
        $this->db           = $database[$driver]['database'];
        $this->dbuser       = $database[$driver]['username'];
        $this->dbpass       = $database[$driver]['password'];
        $this->dbhost       = $database[$driver]['host']; 

        // Load Sximo Config
        $sximo 	= config('sximo');
        $this->config = $sximo ;
        $this->data['sximoconfig'] = $sximo ;  
	} 	


	function getComboselect( Request $request)
	{

		if($request->ajax() == true && \Auth::check() == true)
		{
			$param = explode(':',$request->input('filter'));
			$parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
			$limit = (!is_null($request->input('limit')) ? $request->input('limit') : null);
			$rows = $this->model->getComboselect($param,$limit,$parent);
			$items = array();
		
			$fields = explode("|",$param[2]);
			
			foreach($rows as $row) 
			{
				$value = "";
				foreach($fields as $item=>$val)
				{
					if($val != "") $value .= $row->{$val}." ";
				}
				$items[] = array($row->{$param['1']} , $value); 	
	
			}
			
			return json_encode($items); 	
		} else {
			return json_encode(array('OMG'=>" Ops .. Cant access the page !"));
		}	
	}

	public function getCombotable( Request $request)
	{
		if(Request::ajax() == true && Auth::check() == true)
		{				
			$rows = $this->model->getTableList($this->db);
			$items = array();
			foreach($rows as $row) $items[] = array($row , $row); 	
			return json_encode($items); 	
		} else {
			return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
		}				
	}		
	
	public function getCombotablefield( Request $request)
	{
		if($request->input('table') =='') return json_encode(array());	
		if(Request::ajax() == true && Auth::check() == true)
		{	

				
			$items = array();
			$table = $request->input('table');
			if($table !='')
			{
				$rows = $this->model->getTableField($request->input('table'));			
				foreach($rows as $row) 
					$items[] = array($row , $row); 				 	
			} 
			return json_encode($items);	
		} else {
			return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
		}					
	}

	function validateListError( $rules )
    {
        $errMsg = \Lang::get('core.note_error') ;
        $errMsg .= '<hr /> <ul>';
        foreach($rules as $key=>$val)
        {
            $errMsg .= '<li>'.$key.' : '.$val[0].'</li>';
        }
        $errMsg .= '</li>'; 
        return $errMsg;
    }
	public  function display( Request $request )
	{

		$config = $this->model->connector( $this->module,'id');
		$access = $this->model->getAccess( $config['id'] , session('gid') );
		
		$mode = 'CrudEngine.default.public_table';	
		$data 	= $this->crudengine->table( $config['table'])
					->builder( $config )->button( implode(',',$access) )
					->theme('default');

		if(!is_null($request->input('view'))) 
		{			
			$data = $data->where($config['key'],'=',$request->input('view'));
		} 				
		$arguments = $data->callback('array');
		$arguments['mode'] = (!is_null($request->input('view')) ? 'view' : 'list');					
		return view('CrudEngine.default.public_table', $arguments);		
	}

}

