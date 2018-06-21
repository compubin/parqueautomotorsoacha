<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator, Input, Redirect ; 

class Sximo extends Model {
	public function __construct() 
	{
		parent::__construct();		 
	}		
    static function getComboselect( $params , $limit =null, $parent = null)
    {   
        $limit = explode(':',$limit);
        $parent = explode(':',$parent);

        if(count($limit) >=3)
        {
            $table = $params[0]; 
            $condition = $limit[0]." `".$limit[1]."` ".$limit[2]." '".$limit[3]."' "; 
            if(count($parent)>=2 )
            {
            	$row =  \DB::table($table)->where($parent[0],$parent[1])->get();
            	 $row =  \DB::select( "SELECT * FROM ".$table." ".$condition ." AND ".$parent[0]." = '".$parent[1]."'");
            } else  {
	           $row =  \DB::select( "SELECT * FROM ".$table." ".$condition);
            }        
        }else{

            $table = $params[0]; 
            if(count($parent)>=2 )
            {
            	$row =  \DB::table($table)->where($parent[0],$parent[1])->get();
            } else  {
	            $row =  \DB::table($table)->get();
            }	           
        }

        return $row;
    }	

	public static function getColoumnInfo( $result )
	{
		$pdo = \DB::getPdo();
		$res = $pdo->query($result);
		$i =0;	$coll=array();	
		while ($i < $res->columnCount()) 
		{
			$info = $res->getColumnMeta($i);			
			$coll[] = $info;
			$i++;
		}
		return $coll;	
	
	}	


	function isAccess( $id , $task , $gid )
	{
		
		$row = \DB::table('tb_groups_access')->where('module_id', $id)->where('group_id', $gid )->get();
		
		if(count($row) >= 1)
		{
			$row = $row[0];
			if($row->access_data !='')
			{
				$data = json_decode($row->access_data,true);
				return $data[$task];	
			} else {
				return  0;
			}	

				
			
		} else {
			return 0;
		}			
	
	}

	function validAccess( $id , $gid = 0)
	{
		
		$row = \DB::table('tb_groups_accesss')->where('module_id', $id)->where('group_id', $gid )->get();
		
		if(count($row) >= 1)
		{
			$row = $row[0];
			if($row->access_data !='')
			{
				$data = json_decode($row->access_data,true);
			} else {
				$data = array();
			}	
			return $data;		
			
		} else {
			return false;
		}			
	
	}	

	public function getAccess( $id , $gid = 0 )
	{
		$rows = \DB::table('tb_groups_access')->where('module_id', $id)
				->where('group_id', $gid )->get();

		$access = array();		
		if(count($rows) >= 1)
		{
			$rows = $rows[0]->access_data;
			$data = json_decode($rows,true);
			foreach($data as $key=> $val)
			{
				if($val =='1')
				{
					$access[] = $key;
				} 
			}		
		}
		return $access;		

	}

	static function getColumnTable( $table )
	{	  
        $columns = array();
	    foreach(\DB::select("SHOW COLUMNS FROM $table") as $column)
        {
           //print_r($column);
		    $columns[$column->Field] = '';
        }
	  

        return $columns;
	}	

	static function getTableList( $db ) 
	{
	 	$t = array(); 
		$dbname = 'Tables_in_'.$db ; 
		foreach(\DB::select("SHOW TABLES FROM `{$db}`") as $table)
        {
		    $t[$table->$dbname] = $table->$dbname;
        }	
		return $t;
	}	
	
	static function getTableField( $table ) 
	{
        $columns = array();
	    foreach(\DB::select("SHOW COLUMNS FROM $table") as $column)
		    $columns[$column->Field] = $column->Field;
        return $columns;
	}	

	static function connector( $id , $lang = 'en')
	{	
		$row =  \DB::table('tb_module')->where('module_name', $id)->get();
		$data = array();
		foreach($row as $r)
		{
			$langs = (json_decode($r->module_lang,true));
			$config = \SiteHelpers::CF_decode_json($r->module_config);
			$field = array();
			$display = [];
			$display_view = [];	
			$labels = [];
			$format = [];
			$table = [];
			$template = ['default',[]];
			$remove_form = '';

			usort($config['grid'], "SiteHelpers::_sort");
			foreach($config['grid'] as $key=>$val)
			{
				$field[$val['field']] =$val;
				$field_lang = [ $val['field'] => $val['language'] ];
				$labels[ $val['field'] ] =  \SiteHelpers::infoLang( $val['label'],$field_lang, $val['field'] );;
				// Field to Display 
				if($val['view'] =='1' )
					$display[] =  $val['field'];					
				if($val['detail'] =='1' )
						$display_View[] =  $val['field']; 				
				if($val['format_as'] !='' &&  $val['format_value'] !='')
					$format[ $val['field'] ] =  $val['format_as'].'|'.$val['format_value']; 									
			}
			// Forms 
			$forms = [];
			$validation = [] ;
			usort($config['forms'], "SiteHelpers::_sort");
			foreach($config['forms'] as $key=>$val)
			{				
				if($val['view'] =='1' )
				{
					$forms[ $val['field'] ] =  array( 'type'=> $val['type'] , 'options' =>  $val['option'] ); 
					if($val['required'] != '0' and $val['required'] != '')
					{
						$validation[ $val['field'] ] =  $val['required']; 	
					}					
					$form_group[] =['group'=> $val['form_group'],'field'=> $val['field']] ;
				}
				else {
					$remove_form .= $val['field'].',';
				}
				
			}
		
			$layout = (isset($config['form_layout']['format']) ? $config['form_layout']['format'] : 'default');
			$layout_view = (isset($config['form_layout']['display']) ? $config['form_layout']['display'] : 'form-horizontal');
			$layout_field = array();
			if(isset($config['form_layout']))
			{
				$form_column = (isset($config['form_column']) ? $config['form_column'] : 1);
				$form_title	 = explode(',', $config['form_layout']['title'] );
				for($i=0; $i < $form_column; $i++)
				{
					$fields = '';
					foreach($form_group as $group)
					{
						if($group['group'] == $i)
							$fields .= $group['field'].',';
					}
					$layout_field[$form_title[$i]] = substr($fields,0,strlen($fields)-1);
				}

			}	
			$data['layout'] 		= $layout;
			$data['layout_field'] 	= $layout_field;
			$data['layout_view'] 	= $layout_view;
			/* Start Subform Configuration */
			$data['sf'] = ['title' => null,'table'	=> null, 'key'=> null,'relation'=> null,'form' => null ];
			if(isset($config['subform']))
			{
				$form = [];
				foreach($config['subform']['data'] as $key=>$val)
				{
					$attribute = array();
					if($val[2] !='')
					{
						$conf = explode(',',$val[2]);
						foreach($conf as $cf)
						{
							$attrs = explode('|',$cf);
							$attribute[$attrs[0]] = $attrs[1];							
						}
					}
					$form[$key]	= [ $val[0] , $val[1] ,$val[3] , $attribute];
				}
				$data['sf'] = [
								'title'		=> $config['subform']['title'],
								'table'		=> $config['subform']['table'],
								'key'		=> $config['subform']['master_key'],
								'relation'	=> $config['subform']['key'],
								'form'		=>	$form
							  ];
			}
			/* End Subform Configuration */	
			$data['theme']	= ( $r->module_type =='' or $r->module_type =='native') ? 'datatable' : $r->module_type ;
			$data['order'] 	= [
							'by'	=> (isset($config['setting']['orderby']) ? $config['setting']['orderby'] : $r->module_db_key),
							'type'	=> (isset($config['setting']['ordertype']) ? $config['setting']['ordertype'] : 'asc'  ),
							'page'	=> (isset($config['setting']['perpage']) ? $config['setting']['perpage'] : '10'  )
						  ];

			$data['method'] 	= [
						'form'	=> (isset($config['setting']['form-method']) ? $config['setting']['form-method'] : 'native'),
						'view'	=> (isset($config['setting']['view-method']) ? $config['setting']['view-method'] : 'native'  )	
					  ];
			$data['id']				= $r->module_id; 
			$data['title'] 			= \SiteHelpers::infoLang($r->module_title,$langs,'title'); 
			$data['note'] 			= \SiteHelpers::infoLang($r->module_note,$langs,'note'); 
			$data['table'] 			= $r->module_db; 
			$data['key'] 			= $r->module_db_key;
			$data['field'] 			= $field;
			$data['display'] 		= implode(',',$display);
			$data['display_view'] 	= implode(',',$display_View);	
			$data['format']	 		= $format;
			$data['forms']	 		= $forms;
			$data['remove_form']	 = substr($remove_form, 0, strlen($remove_form)-1);
			$data['labels'] 		= $labels;
			$data['validation'] 		= $validation ;
			$custom_template 		= (isset($config['template']) && $config['template'] =='custom' ? 'custom' : 'system');
			$data['custom_template'] = [];
			if($custom_template =='custom') {

				$data['custom_template'] = [
					'table' 	=> $r->module_name.'.table',
					'form' 		=> $r->module_name.'.form',
					'view' 		=> $r->module_name.'.view'
				];	
			}
			$data['join'] =  $config['join_table'];
		}
		return $data;
	
	} 

	static function last_activity() {

		$sql = \DB::select(" 
					SELECT 
						id , first_name , last_name , last_activity 
					FROM tb_users
					WHERE last_activity > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 14400 MINUTE))
					
					ORDER BY last_activity DESC LIMIT 20
		 		");

		return $sql;
	}	

	static public function cms_dashboard (){
		$page_view = \DB::table('tb_pages')->where('pagetype','page')->orderby('views','DESC')->limit(5)->get();
		$post_view = \DB::table('tb_pages')->where('pagetype','post')->orderby('views','DESC')->limit(5)->get();


		$data = array(
			'page_view' => $page_view ,
			'post_view' => $post_view 
		);
		return $data;
	}

	static public function users_dashboard (){
		$users = \DB::select("
			SELECT 
			COUNT(*) AS Total ,
			SUM(CASE WHEN `status` = 'Active' THEN 1 ELSE 0 END ) AS Active , 
			SUM(CASE WHEN `status` = 'Unconfirmed' THEN 1 ELSE 0 END ) AS Unconfirmed ,
			SUM(CASE WHEN `status` = 'Banned' THEN 1 ELSE 0 END ) AS Banned 
			FROM tb_users

		")[0];
		return $users;
	}
	static public function users_registration_history (){
		$result = \DB::select("
			SELECT 
				SUM(CASE WHEN MONTH(created_at) = '1' THEN 1 ELSE 0 END ) AS January ,
				SUM(CASE WHEN MONTH(created_at) = '2' THEN 1 ELSE 0 END ) AS Febuary ,
				SUM(CASE WHEN MONTH(created_at) = '3' THEN 1 ELSE 0 END ) AS March,
				SUM(CASE WHEN MONTH(created_at) = '4' THEN 1 ELSE 0 END ) AS April,
				SUM(CASE WHEN MONTH(created_at) = '5' THEN 1 ELSE 0 END ) AS May,
				SUM(CASE WHEN MONTH(created_at) = '6' THEN 1 ELSE 0 END ) AS June,
				SUM(CASE WHEN MONTH(created_at) = '7' THEN 1 ELSE 0 END ) AS July,
				SUM(CASE WHEN MONTH(created_at) = '8' THEN 1 ELSE 0 END ) AS August,
				SUM(CASE WHEN MONTH(created_at) = '9' THEN 1 ELSE 0 END ) AS September, 
				SUM(CASE WHEN MONTH(created_at) = '10' THEN 1 ELSE 0 END ) AS October,
				SUM(CASE WHEN MONTH(created_at) = '11' THEN 1 ELSE 0 END ) AS November,
				SUM(CASE WHEN MONTH(created_at) = '12' THEN 1 ELSE 0 END ) AS December
				FROM tb_users
				WHERE YEAR(created_at) ='".date('Y')."'

		")[0];

		return $result ;
	}

	public function logs( $request , $id )
	{
		 $key = with(new static)->primaryKey;
		if($request->input( $key)  =='')
		{
			$note = 'New Data with ID '.$id.' Has been Inserted !';
		} 
		else {
			$note = 'Data with ID '.$id.' Has been Updated !';
		}
		$data = array(
			'module'	=> $request->segment(1),
			'task'		=> $request->segment(2),
			'user_id'	=> \Session::get('uid'),
			'ipaddress'	=> $request->getClientIp(),
			'note'		=> $note
		);
		\DB::table('tb_logs')->insert($data);
	}

	public static function notif_msg( $id ){

		$result = \DB::table('tb_notification')->where('userid',$id)
					->where('is_read','0')
					->orderBy('created','desc')
					->get();


		$count_msg = 0; $count_sys = 0;
		$content_msg = []; $content_sys= [];
		foreach($result as $row)
		{

			if($row->postedBy =='' or $row->postedBy == 0)
			{
				$image = '<img src="'.asset('uploads/images/system.png').'" border="0" width="20" class="img-circle" />';
			} else {
				$image = \SiteHelpers::avatar('30', $row->postedBy);
			}
			$msg = array(
					'url'	=> url($row->url),
					'title'	=> $row->title ,
					'icon'	=> $row->icon,
					'image'	=> $image,
					'text'	=> substr($row->note,0,100),
					'date'	=> \AppHelper::get_time_ago(strtotime($row->created))
				);

			if($row->title =='chat'){
				$count_msg = ++$count_msg;
				$content_msg[] = $msg;
			} 
			else {
				$count_sys = ++$count_sys;
				$content_sys[] = $msg;

			}
		}	

		$data = array(
			'count_msg' 	=>  $count_msg  ,
			'count_sys' 	=>  $count_sys  ,
			'content_msg' 	=>  $content_msg  ,
			'content_sys' 	=>  $content_sys  ,
		);
		return $data;
	}	
}
