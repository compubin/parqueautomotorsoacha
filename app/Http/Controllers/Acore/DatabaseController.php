<?php namespace App\Http\Controllers\Acore;
use App\Http\Controllers\Controller;
use App\Library\ZipHelpers;
use App\Library\SximoHelpers;
use App\Models\Sximo;
use Illuminate\Http\Request;
use Validator, Input, Redirect; 



class DatabaseController extends Controller {

	public function __construct()
	{       
        parent::__construct();
        $this->middleware(function ($request, $next) {           
            if(session('gid') !='1')
                return redirect('dashboard')
                ->with('message','You Dont Have Access to Page !')->with('status','error');            
            return $next($request);
        });

        $driver             = config('database.default');
        $database           = config('database.connections');
       
        $this->db           = $database[$driver]['database'];
        $this->dbuser       = $database[$driver]['username'];
        $this->dbpass       = $database[$driver]['password'];
        $this->dbhost       = $database[$driver]['host']; 
       
        $this->data = array_merge(array(
            'title' =>  'PHP MyAdmin',
            'note'  =>  'Manage DataBase Table ',
            
        ),$this->data)  ;         
	}
   	public function index( Request $request )
	{
		if($request->ajax() == true)
		{
			$task = (!is_null($request->input('task')) ?  $request->input('task') : '' );
			switch($task)
			{
				default :
					return $this->config( $request  );
					break ;

				case 'editfield':
					return $this->getEditField( $request  );
					break ;

				case 'removefield':
					return $this->getRemoveField( $request  );
					break ;	

				case 'query':
					return $this->getQuery( $request  );					
					break;	

										
			}

		}
		else {

			$this->data['tables'] = Sximo::getTableList($this->db);    
			return view('Acore.root.database.index',$this->data);
		}		
	} 

    public function config( $request  )
    {
    	$table = (!is_null($request->input('table')) ? $request->input('table') : null );

        $columns = array();
        $info = \DB::select("SHOW TABLE STATUS FROM `" . $this->db . "` WHERE `name` = '" . $table . "'");
        if(count($info)>=1)
        {
            $info = $info[0];
        }
        if($table != null)
        {
            foreach(\DB::select("SHOW FULL COLUMNS FROM `$table`") as $column)
            {
                $columns[] = $column;
            }
        }   
        $this->data['default'] = array('NULL','USER_DEFINED','CURRENT_TIMESTAMP');
        $this->data['tbtypes'] = array('bigint','binary','bit','blob','bool','boolean','char','date','datetime','decimal','double','enum','float','int','longblob','longtext','mediumblob','mediuminit','mediumtext','numerice','real','set','smallint','text','time','timestamp','tinyblob','tinyint','tinytext','varbinary','varchar','year');
        
        $this->data['engine'] = array('MyISAM','InnoDB');
        $this->data['info'] = $info;
                
        $this->data['columns'] = $columns;
        $this->data['table'] = $table;
        $this->data['action'] = ($table ==null ? 'root/database?task=create&table='.$table : 'root/database?task=tableinfo&table='.$table ) ;
        return view('Acore.root.database.config',$this->data);
    }

    public function destroy(Request $request)
    {
        //print_r($_POST);exit;
        if(!is_null($request->input('id')) && count($request->input('id')) >=1 )
        {
            $ids = $request->input('id');
            for($i=0; $i<count($ids);$i++)
            {
                $table = $ids[$i];
                $sql = 'DROP TABLE IF EXISTS `' . $table . '`';
                \DB::select($sql);   
            }
            return redirect('root/database')->with('message', 'Table(s) has been deleted')->with('status','success');  
        } 
        return redirect('root/database')->with('message','error','No Table(s) deleted !')->with('status','error');  

    } 

	public function store ( Request $request )
    {
    	$task = (!is_null($request->input('task')) ?  $request->input('task') : '' );
	    switch($task)
	    {
	    	default:
	    		return $this->postTableinfo( $request );
	    		break;
	    		
	    	case 'savefield':	
	    		return $this->postSavefield( $request );
	    		break;

	    	case 'tableinfo':	
	    		return $this->postTableinfo( $request );
	    		break;

	    	case 'create':	
	    		return $this->postTable( $request );
	    		break;	

	    	case 'query':	
	    		return $this->postQuery( $request );
	    		break;		

	    }
	    

    }  


    public function postTable( $request  )
    {
        $table  = $request->input('table_name');
        $engine = $request->input('engine');

        $comma = ",";
        $sql = "CREATE TABLE `" . $table . "` (\n";
        $posts = $request->input('fields');
        for($i=0; $i<count($posts);$i++)
        {
            $field      = $request->input('fields')[$i];
            if(!empty($field ))
            {
                $type       = $request->input('types')[$i];
                $lenght     = self::lenght($type,$request->input('lenghts')[$i]);
                $default    = $request->input('defaults')[$i];
                $null       = (isset($request->input('null')[$i]) ? 'NOT NULL' : '') ;
                $ai         = (isset($request->input('ai')[$i]) ? 'AUTO_INCREMENT' : '') ;   

                if ($null != "" and $ai =='AUTO_INCREMENT') {
                    $default = '';  
                } elseif ($null == "" && $default !='') {

                    $default = "DEFAULT '".$default."'";
                } else {     
                    if($null == 'NOT NULL')   
                    {
                        $default = " ";
                    }  else {
                        $default = " DEFAULT NULL ";
                    }           
                    
                }

                    $sql .= " `$field` $type $lenght  $null $default $ai ". ",\n";  
            }

        }
        $primarykey         = $request->input('key');
        if(count(   $primarykey ) >=1 )
        {
            $ai = array();
            for($i=0; $i<count($posts);$i++)
            {
                if(isset($request->input('key')[$i]) )
                {
                    $ai[] = $request->input('fields')[$i]; 
                }
            }   
            
            $sql .= 'PRIMARY KEY (`'.implode('`,`', $ai).'`)'. "\n";    
        }
       
        $sql .= ") ENGINE=$engine DEFAULT CHARSET=utf8 ";

        //if($table == null) 
    //  {
            try {

                \DB::select( $sql );

            }catch(Exception $e){

                 echo "<pre>";
                    echo $e;
                    echo "</pre>";
                    exit;
                return response()->json(array('status'=>'error','message'=> $e));
            }

            return response()->json(array('status'=>'success','message'=>''));

            
        //} else {
        //  return Response::json(array('status'=>'success','message'=>''));
    //  }    
    }

      

    public function postTableinfo( $request  )
    {
        $table =  $request->input('table'); 
        $info = \DB::select("SHOW TABLE STATUS FROM `" . $this->db . "` WHERE `name` = '" . $table . "'");
        if(count($info)>=1)
        {
            $info = $info[0];

            $table_name = trim($request->input('table_name'));
            $engine = trim($request->input('engine'));

            if($table_name != $info->Name )
            {
                $sql = "RENAME TABLE `" . $info->Name . "` TO  `" . $table_name . "`";  
                try {

                    \DB::select( $sql );

                }catch(Exception $e){
                    return response()->json(array('status'=>'error','message'=> $e));
                }               
            }
            if($engine != $info->Engine )
            {
                 
                  $sql = "ALTER TABLE `" . $table_name . "` ENGINE = " . $engine;
                try {

                    \DB::select( $sql );

                }catch(Exception $e){
                    return response()->json(array('status'=>'error','message'=> $e));
                }                 
            }   
            return response()->json(array('status'=>'success','message'=> ''));       

        }   


    }

    public function getRemovefield( $request )
    {
    	$table =  $request->input('table'); 
    	$field =  $request->input('field'); 
        $sql = "ALTER TABLE `" . $table . "` DROP COLUMN `" . $field . "`";
        try {

            \DB::statement( $sql );

        }catch(Exception $e){
            return response()->json(array('status'=>'error','message'=> $e));
        }

        return response()->json(array('status'=>'success','message'=>''));
    }

    public function getEditField( $request )
    {
    	$table =  $request->input('table'); 
        $fields = $_GET;
        foreach($fields as $key=>$val)
        {
            $this->data[$key] = $val; 
        }

        $this->data['table'] = $table;
        $this->data['tbtypes'] = array('bigint','binary','bit','blob','bool','boolean','char','date','datetime','decimal','double','enum','float','int','longblob','longtext','mediumblob','mediuminit','mediumtext','numerice','real','set','smallint','text','time','timestamp','tinyblob','tinyint','tinytext','varbinary','varchar','year');

        return view('Acore.root.database.field',$this->data);
    }
    public function postSavefield( $request )
    {
    	$table = $request->input('table');
        extract($_POST);

        $type       = $request->input('type');
        $lenght     = self::lenght($type,$request->input('lenght'));
        $default    = $request->input('default');
        $null       = (!is_null($request->input('null')) ? 'NOT NULL' : '') ;
        $ai         = (!is_null($request->input('ai')) ? 'AUTO_INCREMENT' : '') ;    

        if ($null != "" and $ai =='AUTO_INCREMENT') {
            $default = '';  
        } elseif ($null == "" && $default !='') {

                $default = "DEFAULT '".$default."'";
        } else {     
            if($null == 'NOT NULL')   
            {
                $default = "";
            }  else {
                $default = " DEFAULT NULL ";
            }           
            
        }
        $currentfield = $request->input('currentfield');
        if( $currentfield !='')
        {
            if($currentfield == $field )
            {
                $sql = " ALTER TABLE `" . $table . "` MODIFY COLUMN `$field` $type  $lenght   $null $default $ai ";
            }   else {
                $sql = " ALTER TABLE `" . $table . "` CHANGE  `$currentfield` `$field`  $type $lenght   $null $default $ai ";
            }

        } else {
               $sql = " ALTER TABLE `" . $table . "` ADD COLUMN `$field` $type  $lenght   $null $default $ai ";
        }

        

        try {

            \DB::statement( $sql );

        }catch(Exception $e){
            return response()->json(array('status'=>'error','message'=> $e));
        }

        return response()->json(array('status'=>'success','message'=>''));
    }   

    static function lenght( $type , $lenght)
    {
        if($lenght == '')
        {
            switch (strtolower(trim( $type))) {
                default ;
                    $lenght = '';
                    break;
                case 'bit':
                   $lenght = '(1)';
                    break;
                case 'tinyint':
                    $lenght = '(4)';
                    break;
                case 'smallint':
                    $lenght = '(6)';
                    break;
                case 'mediumint':
                   $lenght = '(9)';
                    break;
                case 'int':
                    $lenght = '(11)';
                    break;
                case 'bigint':
                   $lenght = '(20)';
                    break;
                case 'decimal':
                    $lenght = '(10,0)';
                    break;
                case 'char':
                    $lenght = '(50)';
                    break;
                case 'varchar':
                   $lenght = '(255)';
                    break;
                case 'binary':
                    $lenght = '(50)';
                    break;
                case 'varbinary':
                    $lenght = '(255)';
                    break;
                case 'year':
                    $lenght = '(4)';
                    break;

            }
            return $lenght;
        } else {
             return "( $lenght )" ;
        }       
    }

    public function getQuery()
    {
        
        return view('Acore.root.database.editor');
    }   

    public function postQuery( $request)
    {

        $sql = $request->input('statement');
        preg_match_all( '/[\s]*(CREATE|DROP|TRUNCATE)(.*);/Usi',$sql, $sql_table );
        preg_match_all( '/[\s]*(INSERT|UPDATE|DELETE)(.*)[\s\)]+;/Usi',$sql, $sql_row );        
        
        
        try {
            
              $res = \DB::select( $sql );
                    
            
        }catch(Exception $e){
            
            return response()->json(array('status'=>'error','message'=> $e));
        }

        return response()->json(array('status'=>'success','message'=>''));
    }             



}