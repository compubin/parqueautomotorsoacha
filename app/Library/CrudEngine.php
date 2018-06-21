<?php
namespace App\Library;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Http\Request;
use DispatchesJobs, ValidatesRequests;
use Validator, Input, Redirect ;

class CrudEngine {

    protected 		$title;
    protected 		$id 			= null;
    protected 		$table;
    protected 		$where 			= array();
    protected 		$orWhere 		= array();
    protected 		$whereBetween 	= array();
    protected 		$whereIn 		= array();
    protected 		$whereNotIn 	= array();
    protected 		$whereNull 		= array();
    protected 		$whereNotNull 	= array();
    protected 		$whereDate 		= array();
    protected 		$whereMonth 	= array();
    protected 		$whereDay 		= array();
    protected 		$whereYear	 	= array();
    protected 		$join 			= null;
    protected 		$leftjoin;
    protected 		$relation;
    protected 		$query;
    protected 		$query_join;
    protected 		$remove 		= array();
    protected 		$remove_form 		= array();
    protected 		$pagination 	= '';
    protected 		$per_page 		= 10;
    protected 		$limit 			= 10;
    protected 		$page 			= 1;
    protected 		$order_by 		= '';
    protected 		$order_type		= 'desc';
    protected 		$group_by		= '' ;
    protected 		$rows 			= array();
    protected 		$row 			= array();
    protected 		$label 			= array();
    protected 		$format 		= array();
    protected 		$round_params 	= array();
    protected 		$tablefields 	= array();
    protected 		$tabletitle 	= array();
    protected 		$viewdetail 	= array();
    protected 		$viewgrid 		= array();
    protected 		$display 		= array();
    protected 		$display_view 	= array();
    protected 		$display_form 	= array();
    protected 		$layout 		= array();
    protected 		$form_layout 	= array();
    protected 		$view_layout 	= array();
    protected 		$form_view 		= 'form-horizontal';
    protected 		$to_display 	= array();
    protected 		$to_display_view = array();
    protected 		$fields 		= array();
    protected 		$to_relation 	= array();
    protected 		$to_forms 		= array();
    protected 		$to_subforms 	= array();
    protected 		$to_posts 		= array();
    protected 		$to_validation 	= array();
    protected 		$to_layout 		= array();
    protected 		$key ;
    protected 		$template 		='default';
    protected 		$to_template 	= array();
    protected 		$method		 	= ['form'=>'native','view'=>'native'];
    protected 		$_columns ;
    protected 		$statement ;
    protected 		$url ;
    protected 		$results ; // contain data rows from database
    protected 		$total 			= 0;
    protected      	$subdetail;
    protected      	$subform		= array();
    protected 		$theme 			= 'datatable';
    protected 		$before_save 	= null;
    protected 		$after_save 	= null;
    protected 		$call_action 	= null;
    protected 		$append_data 	= array();
    protected 		$search 		= '';
    protected 		$data 			= array();
    protected 		$global 		= 1;
    protected 		$build_via 		= 'manual';



    function __construct() {
        $this->button 		= ['view'=>'view','create'=>'create','copy'=>'copy','update'=>'update','delete'=>'delete','export'=>'export','print'=>'print'];
    }
    public function url( $url  )
    {
        $this->url =   $url ;
        return $this;
    }
    public function title( $title  )
    {
        $this->title =   $title ;
        return $this;
    }
    public function table(  $table )
    {
        $this->table =   $table ;
        return $this;
    }
    public function filter(  $id )
    {
        $this->id =   $id ;
        return $this;
    }
    /*
    * Builer Compatibility
    */
    public function builder(  $params )
    {
        if($params['layout'] =='default')
            $params['layout'] = 'form';

        $this->title 		= $params['title'];
        $this->label 		= $params['labels'];
        $fields = explode(',', $params['display']);
        foreach ($fields as $field)
        {
            $this->display[trim($field)]	= trim($field)  ;
        }
        $fields = explode(',', $params['display_view']);
        foreach ($fields as $field)
        {
            $this->display_view[trim($field)]	= trim($field)  ;
        }
        $this->subform(
            $params['sf']['title'],
            $params['sf']['table'],
            $params['sf']['key'],
            $params['sf']['relation'],
            $params['sf']['form']
        );
        $this->theme( $params['theme'] );
        $this->format( $params['format'] );
        $this->forms_array( $params['forms'] );
        $this->remove_form( $params['remove_form'] );
        $this->method( $params['method'] );
        $this->validation_array( $params['validation'] );
        $this->layout( $params['layout'] , $params['layout_field'] , $params['layout_view'] );
        $this->order_by($params['order']['by'] ,$params['order']['type']);
        $this->limit($params['order']['page'])	;
        if(count($params['custom_template']))
        {
            $this->template($params['custom_template']);
            $this->theme ='default';
        }
        if(count($params['join'])){
            foreach($params['join'] as $k=>$v)
            {
                $this->join($v['join'],$k,$v['master']);
            }
        }
        $this->form_ordering= $params['forms'];
        $this->build_via = 'builder';
        return $this;
    }

    public function where(  $field , $operator , $condition )
    {
        $this->where[ $field ] = ['operator'=> $operator , 'condition'=> $condition] ;
        return $this;
    }
    public function orWhere(  $field , $operator , $condition )
    {
        $this->orWhere[ $field ] = ['operator'=> $operator , 'condition'=> $condition] ;
        return $this;
    }
    public function whereBetween(  $field , $condition )
    {
        $this->orWhere[ $field ] = $condition  ;
        return $this;
    }
    public function whereIn(  $field , $condition )
    {
        $this->whereIn[ $field ] = $condition ;
        return $this;
    }
    public function whereNotIn(  $field , $condition )
    {
        $this->whereIn[ $field ] = $condition ;
        return $this;
    }
    public function whereNull(  $field )
    {
        $this->whereNull[ $field ] =  $field ;
        return $this;
    }
    public function whereNotNull(  $field  )
    {
        $this->whereNotNull[ $field ] =   $field ;
        return $this;
    }
    public function whereDate(  $field ,  $condition  )
    {
        $this->whereDate[ $field ] =   $condition  ;
        return $this;
    }
    public function whereMonth(  $field  , $condition )
    {
        $this->whereMonth[ $field ] =   $condition  ;
        return $this;
    }
    public function whereDay(  $field , $condition )
    {
        $this->whereDay[ $field ] =   $condition  ;
        return $this;
    }
    public function whereYear(  $field , $condition )
    {
        $this->whereYear[ $field ] =   $condition  ;
        return $this;
    }
    public function group_by(  $field )
    {
        $this->group_by = $field ;
        return $this;
    }

    public function join(  $key_join , $table_join , $key_master , $join_type ='LEFT')
    {
        $joins = [
            'table_join'	=> $table_join ,
            'key_join'		=> $key_join,
            'key_master'	=> $key_master ,
            'join_type'		=> $join_type
        ];
        $query 			= "  ".strtoupper($join_type)." JOIN ".$table_join." ON ".$table_join.".".$key_join." = 
						  ".$this->table.".".$key_master ;
        $this->query_join 	.= $query ;
        $this->join[ $table_join ] = $joins ;
        return $this;
    }
    public function relation(  $key_join , $table_join , $key_master , $display_name  )
    {
        $relation = array(
            'table_join'	=> $table_join ,
            'key_join'		=> $key_join,
            'key_master'	=> $key_master ,
            'display_name'	=> $display_name
        );

        $this->relation[ ] =  $relation ;
        return $this;
    }
    public function details(  $table , $key_join , $table_master , $key_join_master  )
    {
        $query = " LEFT JOIN {$table} ON {$table}.{$key_join} = {$table_master}.{$key_join_master} ";
        $this->join .= $query ;
        return $this;
    }
    public function limit( $limit )
    {
        $this->limit = $limit ;
        if(isset($_GET['rows']) )
            $this->limit = $_GET['rows'];

        return $this;
    }
    public function order_by( $field , $type ='asc' )
    {
        $this->order_by = $field ;
        $this->order_type = $type ;
        if(isset($_GET['order']) && isset($_GET['sort']) )
        {
            $this->order_by = $_GET['order'];
            $this->order_type = $_GET['sort'];
        }

        return $this;
    }
    public function _build_statement( )
    {
        $this->query = " SELECT * FROM " . $this->table;
        if($this->query_join !='')
            $this->query = $this->query . $this->query_join ;

        $this->query ;
        return $this;
    }
    public function display( $fields )
    {
        if ($fields !='')
        {
            $fields = explode(',',$fields);
            foreach ($fields as $field)
            {
                $this->display[trim($field)]	= trim($field)  ;
            }
        }
        return $this;
    }

    public function display_view(  $fields ='' )
    {
        if ($fields !='')
        {
            $fields = explode(',',$fields);
            foreach ($fields as $field)
            {
                $this->display_view[$field]	= $field  ;
            }
        }
        return $this;
    }
    public function display_form(  $fields ='' )
    {
        if ($fields !='')
        {
            $fields = explode(',',$fields);
            foreach ($fields as $field)
            {
                $this->display_form[$field]	= $field  ;
            }
        }
        return $this;
    }
    /*
        For Single Form

    */
    public function forms( $field , $type , $params = array() )
    {
        $this->to_forms[$field] = array( 'type' => $type , 'params'=> $params);
        $this->to_posts[$field] = array( 'type' => $type , 'params'=> $params);
        return $this ;
    }
    /*
        For Array Forms

    */
    public function forms_array( $array = array())
    {
        if(count($array))
        {
            foreach($array as $key=>$value )
            {
                $this->to_forms[$key] = array(
                    'type' => $value['type'] ,
                    'params'=> isset($value['options']) ? $value['options'] : array()
                );
                $this->to_posts[$key] = array(
                    'type' => $value['type'] ,
                    'params'=> isset($value['options']) ? $value['options'] : array()
                );
            }
        }
        return $this ;
    }

    public function validation( $field , $pattern = 'required' )
    {
        $this->to_validation[$field] = $pattern ;
        return $this ;
    }
    /*

        Usange ->validation_array(['field'=>'validation'])
    */
    public function validation_array( $array = array() )
    {
        if(count($array))
        {
            foreach($array as $key=>$pattern )
            {
                $this->to_validation[$key] = $pattern ;
            }
        }
        return $this ;
    }
    public function label( $args =  array())
    {
        if (is_array($args) && count($args)>=1) {
            $this->label = $args ;
        }
        return $this ;
    }
    public function format( $args )
    {
        if (is_array($args)) {
            $format = array();
            foreach ($args as $key=>$val)
            {
                $this->format[$key] = explode("|",$val);
            }
        }
        return $this;
    }
    public function remove( $args = '')
    {
        if ($args !='') {
            $this->remove = explode(',', $args );
        }
        return $this ;
    }
    public function remove_form( $args = '')
    {
        if ($args !='') {
            $this->remove_form = explode(',', $args );
        }
        return $this ;
    }

    public function layout( $type = 'def', $args = array() , $view = '')
    {
        if($type != 'def')
            $this->layout[ $type] = $args ;
        if($view !='')
            $this->form_view = $view  ;

        return $this ;
    }
    public function form_layout( $type = 'def', $args = array())
    {
        $this->form_layout[ $type] = $args ;
        return $this ;
    }
    public function view_layout( $type = 'def', $args = array())
    {
        $this->view_layout[ $type] = $args ;
        return $this ;
    }
    public function subdetail( $key  )
    {
        $this->subdetail[ $key] = $key ;
        return $this ;
    }
    public function subform( $title , $table , $key , $relation , $forms  )
    {
        if($title !== null)
        {
            $this->subform = array(
                'title'	=> $title ,
                'table'	=> $table ,
                'key'	=> $key ,
                'relation'	=> $relation ,
                'forms'	=> $forms
            );
            $field = array();
            foreach( $forms as $key=> $form)
            {
                $field[ $key ] = array(
                    'title'		=> $form[0],
                    'type'		=> $form[1],
                    'validation'=> (isset($form[2]) ? $form[2] : ''),
                    'param'		=>  (isset($form[3]) ? $form[3] : array())
                ) ;
            }
            $this->subform['form'] = $field;
        }
        return $this ;
    }
    function append_paginate()
    {
        $sort 	= (isset($_GET['sort']) 	? $_GET['sort'] : '');
        $order 	= (isset($_GET['order']) 	? $_GET['order'] : '');
        $rows 	= (isset($_GET['rows']) 	? $_GET['rows'] : '');
        $search 	= (isset($_GET['search']) ? $_GET['search'] : '');

        $appends = array();
        if($sort!='') 	$appends['sort'] = $sort;
        if($order!='') 	$appends['order'] = $order;
        if($rows!='') 	$appends['rows'] = $rows;
        if($search!='') $appends['search'] = $search;

        return $appends;
    }
    /* Append custom data from users */
    function append_data( $data )
    {
        $this->append_data = $data;
        return $this ;
    }
    /*
        Fucntion Describe
        This function is for grab data form database
    */
    public function execute( )
    {
        if($this->theme =='datatable')
            $datatable_posts = $this->datatable_post();

        $result =  \DB::table($this->table)->select('*', "{$this->table}.{$this->key}");

        // Custom Joins
        # validate if is a task or is a datatable
        if($this->format && empty($_GET['task']))
        {
            foreach ($this->format AS $foreignKey => $value)
            {
                $dataRelation = explode(':', $value[1]);
                $table = $dataRelation[0];
                $primaryKey = $dataRelation[1];
                $result = $result->leftJoin($table , $this->table.'.'.$foreignKey , '=' , $table.'.'. $primaryKey);
            }
        }

        // If Join Table
        if($this->join)
        {
            foreach($this->join as $alias => $join)
            {
                if($join['join_type'] =='left') {
                    $result = $result->leftJoin($join['table_join'] , $this->table.'.'.$join['key_master'] , '=' , $join['table_join'].'.'. $join['key_join']);
                }
                else if($join['join_type'] =='right') {
                    $result = $result->rightJoin($join['table_join'] , $this->table.'.'.$join['key_master'] , '=' , $join['table_join'].'.'. $join['key_join']);
                }
                else {
                    $result = $result->join($join['table_join'] , $this->table.'.'.$join['key_master'] , '=' , $join['table_join'].'.'. $join['key_join']);
                }
            }
        }

        // If where condition  exists
        if(count($this->where))
        {
            foreach($this->where as $key => $value)
            {
                $result = $result->where( $key , $value['operator'] , $value['condition']);
            }
        }

        // If or where condition  exists
        if(  count($this->orWhere ))
        {
            foreach($this->orWhere as $key => $value)
            {
                $result = $result->orWhere( $key , $value['operator'] , $value['condition'] );
            }
        }
        // If where between  exists
        if(  count($this->whereBetween ))
        {
            foreach($this->whereBetween as $key => $value)
            {
                $result = $result->whereBetween( $key , $value['condition'] );
            }
        }

        if(  count($this->whereNotIn ))
        {
            foreach($this->whereNotIn as $key => $value)
            {
                $result = $result->whereNotIn( $key , $value['condition'] );
            }
        }
        if(  count($this->whereNull ))
        {
            foreach($this->whereNull as $key )
            {
                $result = $result->whereNull( $key );
            }
        }
        if(  count($this->whereNotNull ))
        {
            foreach($this->whereNotNull as $key )
            {
                $result = $result->whereNotNull( $key );
            }
        }
        if(  count($this->whereDate ))
        {
            foreach($this->whereDate as $key => $val )
            {
                $result = $result->whereDate( $key , $val );
            }
        }
        if(  count($this->whereMonth ))
        {
            foreach($this->whereMonth as $key => $val )
            {
                $result = $result->whereMonth( $key , $val );
            }
        }
        if(  count($this->whereDay ))
        {
            foreach($this->whereDay as $key => $val )
            {
                $result = $result->whereDay($key,$val);
            }
        }
        if(  count($this->whereYear ))
        {
            foreach($this->whereYear as $key => $val )
            {
                $result = $result->whereYear( $key , $val );
            }
        }
        // If order_by exists
        if(  $this->order_by !='' )
        {
            $result = $result->orderBy( $this->order_by , $this->order_type );
        }
        // If view or update or create
        if( $this->id !== null )
        {
            $result = $result->where($this->key, $this->id );
        }
        if( isset($_GET['task']) &&  ( $_GET['task'] =='view' || $_GET['task'] =='update' || $_GET['task'] =='create' )	)
        {
            $id = ( isset( $_GET['id']) ? $_GET['id'] : '');
            $result = $result->where($this->key, $id );
        }
        // If lookup from master detail view
        if( isset($_GET['task']) &&  ( $_GET['task'] =='sub' )	)
        {
            $result = $result->where( $_GET['relation'] , $_GET['id'] );
        }
        if( isset($_GET['search']) &&  $_GET['search'] !=''	|| $this->search !='')
        {
            $search = (isset($_GET['search']) ? $_GET['search'] : $this->search );

                foreach($this->to_display as $key => $val)
                {
//                Fixed query on join tables
                    $foreignKey = explode('.', $key)[1];


                    // validate if is a task or is a datatable
                    if(!empty($this->to_forms[$foreignKey]['params']['lookup_table']) && empty($_GET['task']))
                    {
                        $table = $this->to_forms[$foreignKey]['params']['lookup_table'];
                        // varios campos separados por -
                        $value = explode('-', $this->to_forms[$foreignKey]['params']['lookup_value']);

                        foreach ($value AS $sSey => $sValue)
                        {
                            $result = $result->orWhere( "{$table}.{$sValue}",  'LIKE', '%'. $search .'%' );
                        }
                    }
                    else
                    {
                        $result = $result->orWhere( $key,  'LIKE', '%'. $search .'%' );
                    }
                }
        }

        if($this->global == 0)
        {
            if(array_key_exists('EntryBy', $this->fields))
                $result = $result->where('EntryBy' ,  session('uid'));
        }
        // If order_by exists
        if(  $this->group_by !='' )
        {
            $result = $result->groupBy( $this->group_by );
        }
        // intercept process if export
        if(isset($_GET['task']) && ($_GET['task'] =='export'  or $_GET['task'] =='print'))
        {
            $result = $result->get();
            $this->results = $result ;
            return $this;
        }
        // end instercept proccess

        if(isset($_GET['rows']) )
            $this->limit = $_GET['rows'];

        // Result + Pagination Limit
        if($this->theme  == 'datatable')
        {
            $start = (isset( $_POST['start'] ) &&  $_POST['start'] !=0 ?   $_POST['start'] : 0 );
            $total =  $result->get();
            $this->total = count($total);
            $datatable =  $result->skip( $start )->take( $this->limit )->get();
            $result = $datatable ;

        } else {
            $result = $result->paginate( $this->limit );
        }
        $this->results = $result ;
        return $this;

    }
    public function before_save(  $action  = null )
    {
        $this->before_save = $action;
        return $this;
    }
    public function after_save( $action = null  )
    {
        $this->after_save = $action;
        return $this;
    }

    public function call_action( $state , $action = null  )
    {
        $this->call_action[$state] = $action;
        return $this;
    }
    public function _prepare_statement( $table )
    {
        $cols = array();
        $query = "DESCRIBE ".$table ;
        foreach (\DB::select($query) as $key)
        {
            if (preg_match('/^([A-Za-z]+)\((.+)\)/u', $key->Type, $matches))
            {
                $type 	= strtolower($matches[1]);
                $lenght =  str_replace('(','',$matches[2]);
                $lenght =  str_replace(')','',$lenght);
            }
            else
            {
                $type = strtolower($key->Type);
                $lenght =  null;
            }

            $cols[] = [	'Field' => $key->Field , 'Type'	=> $type ,	'Lenght'=> 	$lenght , 'Table' => $table];

        }
        return $cols ;
    }

    public function _prepare_columns( )
    {
        $this->exec_label();
        $joined = array();
        $cols = $this->_prepare_statement( $this->table );
        if ($this->join !== null)
        {
            foreach($this->join as $table => $join )
            {

                $joined = $this->_prepare_statement( $table );
            }
        }
        $cols = array_merge( $cols , $joined );
        // generate key and store the key on $this variable as `$this->key`
        self::_key();

        // generate columns and store the columns on $this as  `$this->columns`
        self::_get_column_data( $cols );
        return $this;
    }
    public function _key(  )
    {
        //  show columns from members where extra like '%auto_increment%'"
        $query = "SHOW columns FROM `".$this->table."` WHERE extra LIKE '%auto_increment%'";
        $primaryKey = '';
        foreach (\DB::select($query) as $key)
        {
            $primaryKey = $key->Field;
        }
        $this->key = $primaryKey;
        return $this;
    }
    public function _get_column_data( $cols )
    {
        $columns 	= array();
        $grids 		= array();
        $fields 	= array();
        $row 		= array();
        foreach($cols as $r)
        {
            $label = (array_key_exists($r['Field'], $this->label) || isset($this->label[$r['Field']]) ? $this->label[$r['Field']] : str_replace("_"," ",$r['Field']));

            $type = self::_set_field_Type(  $r['Type']  );
            $columns[] = (object) array('Field'=> $r['Field'],'Table'=> $r['Table'],'Type'=> $type ,'Lenght'=> 	$r['Lenght'] ,'Label'=> $label );
        }
        foreach ($columns  as $column)
        {
            $label = (array_key_exists($column->Field, $this->label) || isset($this->label[$column->Field]) ? $this->label[$column->Field] : $column->Field);

            $row[$column->Field] = '';

            if(!in_array( $column->Field , $this->remove))
                $grids[ $column->Table.'.'.$column->Field ] = ucwords($label) ;

            if(!in_array( $column->Field , $this->remove))
                $fields[ $column->Field ] = ucwords($label) ;
        }
        foreach($this->remove as $unset)
        {
            unset($this->to_display[$unset]);
        }
        $this->to_display 		= $grids;
        $this->to_display_view 	= $grids;
        $this->fields 			= $fields;
        $this->grids 			= $grids;
        $this->row 				= $row;
        $this->columns 			= $columns;
        return $this;
    }
    public function template ( $template  )
    {
        $this->to_template = $template;
        return $this;
    }
    public function method ( $args  )
    {
        foreach($args as $key=>$val)
        {
            $this->method[$key] = $val ;
        }
        return $this;
    }
    public function theme ( $theme  )
    {
        $this->theme = $theme;
        return $this;
    }
    public function exec_relation()
    {
        if (count($this->relation))
        {
            $relation = array();
            foreach ($this->relation as $pars  )
            {
                $relation[ $pars['key_join'] ] = $pars;
            }
            $this->to_relation = $relation;
        }
        return $this ;
    }
    public function exec_label()
    {
        return $this;
    }
    public function exec_display()
    {
        $this->to_display_dt = $this->to_display ;
        // If selected to display is exists
        if (count($this->display) >=1 ) {
            $display = array();
            foreach($this->display as $key)
            {
                $key_field = $key ;
                if (strpos($key_field, ".") !== false)
                {
                    $key_field = $key_field;
                } else {
                    $key_field = $this->table .'.'.$key ;
                }
                if (array_key_exists($key_field , $this->grids))
                {
                    $display[$key_field]	= ucwords($this->grids[ $key_field ]) ;
                }
            }
            $this->to_display = $display ;
            $this->to_display_dt = $this->to_display_dt ;
        }
        return $this;
    }
    public function exec_display_view()
    {
        $this->to_display_view = $this->grids ;
        if (count($this->display_view) >=1 ) {
            $display = array();
            foreach($this->display_view as $key)
            {
                $key_field = $key ;
                if (strpos($key_field, ".") !== false)
                {
                    $key_field = $key_field;
                } else {
                    $key_field = $this->table .'.'.$key ;
                }

                if (array_key_exists($key_field , $this->grids))
                {
                    $display[$key_field]	= ucwords($this->grids[ $key_field ]) ;
                }
            }
            $this->to_display_view = $display ;
        }
        return $this;
    }
    public function exec_forms()
    {
        $forms = array();
        $javascript = array();
        $posts = array();
        $row = array();
        if(isset($_GET['task']) && isset($_GET['id']))
        {
            $row = (array) $this->results[0] ;
        }
        else {
            $row =  $this->row;
        }
        foreach($this->columns as $key => $par)
        {
            if( $par->Table == $this->table )
            {
                $validation = (array_key_exists( $par->Field , $this->to_validation) ? $this->to_validation[$par->Field] :'');
                $field 	= $par->Field;
                $type 	= $par->Type;

                $value 	= (isset( $row[$par->Field]) ? $row[$par->Field] : '') ;
                $params = array(
                    'field'		=> $par->Field ,
                    'label'		=> $par->Label ,
                    'lenght'	=> $par->Lenght ,
                    'validation'=> $validation,
                );
                if (array_key_exists( $field , $this->to_forms))
                {
                    $type = $this->to_forms[ $field ]['type'];
                    $params =  array_merge($params ,$this->to_forms[ $field ]['params']) ;
                }

                if ( array_key_exists( $field , $this->to_relation ))
                {
                    $type 	= 'select';
                    $params['lookup'] 	=   $this->to_relation[ $field]['table_join'].':'.
                        $this->to_relation[ $field]['key_master'].':'.
                        $this->to_relation[ $field]['display_name'];
                }
                $posts[ $field ] = array( 'type' => $type , 'params'=> $params);

                if($this->key != $key) {
                    $forms[ $par->Field ] = array(
                        'title' =>  ucwords($par->Label),
                        'type'	 =>  $type,
                        'form'=> $this->_set_field_Form( $type , $value , $params ));
                }

                if($type =='select' )
                {
                    $lookup = '';
                    if(isset($params['opt_type']) && $params['opt_type'] =='external')
                    {
                        $lookup = $params['lookup_table'].':'.$params['lookup_key'].':'.$params['lookup_value'];

                        if(isset($params['lookup_dependency_key']) && $params['lookup_dependency_key'] != '')
                        {
                            $lookup .= "&parent={$params['lookup_dependency_key']}:";
                        }
                    }

                    if(isset($params['lookup']) && $params['lookup'] !='')
                    {
                        $lookup = $params['lookup'];
                    }
                    if($lookup !=''){
                        $javascript[$field]  = $lookup;
                    }
                }
            }
        }
        if($this->build_via =='builder')
        {
            $re_order = [];
            foreach($this->form_ordering as $k=>$v)
            {
                if(array_key_exists($k, $forms))
                    $re_order[$k] = $forms[$k];
            }
            $forms = $re_order;
        }
        if(count($this->remove_form))
        {
            foreach($this->remove_form as $unset)
            {
                unset($forms[$unset]);
                unset($posts[$unset]);

            }
        }
        unset($forms['EntryBy']);
        unset($posts['EntryBy']);

        $this->to_forms 		= $forms ;
        $this->to_posts 		= $posts ;
        $this->to_javascript 	= $javascript ;
        $this->row 				= $row ;
        return $this;
    }
    public function exec_subforms()
    {
        $posts = array();
        $row = array();
        $subform = [] ;
        $fields = [] ;
        if(count($this->subform))
        {
            $parent_id = (isset($_GET['id']) ? $_GET['id'] : '' );
            $result = \DB::table( $this->subform['table']  )->where( $this->subform['relation'] , $parent_id )->get();

            if(count($result))
            {
                $forms = array();
                foreach($result as $row)
                {
                    foreach($this->subform['forms'] as $key=> $form)
                    {
                        $param = (isset($form[3])? $form[3] : array());
                        $params = array_merge(array(
                            'field'		=> 'sub_'.$key.'[]',
                            'label'		=> ucwords( $form[0] ) ,
                            'lenght'	=> '' ,
                            'validation'=> $form[2],
                        ),$param);
                        $forms[ $key ] = array(
                            'title' =>  ucwords( $form[0] ),
                            'type'	 =>  $form[1] ,
                            'form'=> $this->_set_field_Form( $form[1] , $row->{ $key } , $params )
                        );
                        $fields[ $key ] = $form[0];
                    }

                    $subform[] = $forms;
                }
            }
            else {
                $forms = array();
                foreach($this->subform['forms'] as $key=>$form)
                {
                    $param = (isset($form[3])? $form[3] : array());
                    $params = array_merge(array(
                        'field'		=> 'sub_'.$key.'[]',
                        'label'		=> ucwords( $form[0] ) ,
                        'lenght'	=> '' ,
                        'validation'=> $form[2],
                    ),$param);
                    $forms[ $key ] = array(
                        'title' =>  ucwords( $form[0] ),
                        'type'	 =>  $form[1] ,
                        'form'=> $this->_set_field_Form( $form[1] , '' , $params )
                    );
                    $fields[  $key ] = $form[0];

                }

                $subform[] = $forms;
            }

            $this->to_subforms = [ 'key'=> $this->subform['key'] ,  'relation'=> $this->subform['relation']  ,'field'=> $fields, 'form'=> $subform] ;
        }
    }

    public function exec_rows()
    {
        $this->execute();
        $rows = array();
        foreach ($this->results as $row)
        {
            $data = array();
            foreach ($this->grids as $key => $val )
            {
                $field = explode('.',$key);
                if ( array_key_exists($field[1],$this->format) ) {
                    $data[  $key ] =  self::formatRows( $row->{$field[1]} , $this->format[$field[1]] , $row);
                }
                else {
                    if (count( $this->to_relation ))
                    {
                        if ( array_key_exists( $field[1] , $this->to_relation ))
                        {
                            $format = array( 'lookup' , $this->to_relation[  $field[1] ]['table_join'] .':'.
                                $this->to_relation[  $field[1] ]['key_master']. ':'.
                                $this->to_relation[  $field[1] ]['display_name']);
                            $data[ $key ] =  self::formatRows( $row->{  $field[1] } ,$format , $row);
                        }
                        else {
                            $data[  $key  ] = $row->{$field[1]};
                        }
                    }
                    else {
                        $data[  $key  ] = $row->{$field[1]};
                    }
                }
            }
            $rows[] = $data;
        }
        $this->rows = $rows ;
        $task = (isset($_GET['task']) ? $_GET['task'] : '');
        if($this->theme !='datatable' &&  $task !='export' && $task !='print'){
            $this->paginate = $this->results->appends( $this->append_paginate()) ;
            $this->pagination = $this->results;
        }

        return $this;
    }
    public function exec_layout( )
    {
        if(count($this->layout))
        {
            $this->to_layout = $this->layout;
        }
        if(count($this->view_layout))
        {
            $this->view_layout = $this->view_layout;
        }
        return $this;
    }
    public function exec_template( )
    {
        $this->template = [
            'table'	=> 'CrudEngine.'.$this->theme.'.table',
            'view'	=> 'CrudEngine.'.$this->theme.'.view',
            'form'	=> 'CrudEngine.'.$this->theme.'.form',
            'sub'	=> 'CrudEngine.'.$this->theme.'.sub',
            'js'	=> 'CrudEngine.'.$this->theme.'.js',
        ];
        return $this;
    }
    public function button( $action )
    {
        if ($action !='')
        {
            $this->button =[];

            $action = explode(',',$action);
            foreach ($action as $field)
            {
                $this->button[trim($field)]	= trim($field)  ;
            }
        }
        if(!isset($this->button['global']))
        {
            $this->global = 0;
        }
        return $this;
    }

    public function actionId() {

        $id =($this->title !='' ? str_replace(' ','-',$this->title) : 'CrudEngineID');
        $this->actionId = preg_replace("/[^A-Za-z0-9 ]/", '', $id);
        return $this ;

    }
    public function prepare_data()
    {
        $this->actionId();

        $id = $this->actionId ;

        $file = [
            'form'		=> 'form',
            'view'		=> 'view',
            'update'	=> 'update'
        ];
        $this->_build_statement();
        $this->_prepare_columns();
        $this->exec_relation();
        $this->exec_label();
        $this->exec_display();
        $this->exec_display_view();

        $this->exec_layout();
        $this->exec_template();


        $this->data = array(
            'title'		=> ($this->title !='' ? str_replace('-',' ',$this->title) : 'CrudEngine'),
            'fields'	=> $this->to_display ,
            'views'		=> $this->to_display_view ,
            'this_table'=> $this->table ,
            'this_key'	=> $this->key ,
            'key_value'	=> (isset($_GET['id']) ? $_GET['id'] : '') ,
            'url'		=> ($this->url =='' ? \Request::segment(1) : $this->url),
            'class'		=> \Request::segment(1),
            'button'	=> $this->button ,
            'actionId'	=> 'CrudEngine-'.$id,
            'order_by'	=> ($this->order_by !='' ? $this->order_by: $this->key ),
            'order_type'=> $this->order_type,
            'method'	=> $this->method ,
            'validation'		=> count($this->to_validation),
            'perpage'	=> $this->limit
        );
        return $this ;
    }
    public function callback( $operator ='' ){

        $this->prepare_data();

        if($operator =='rows')
        {
            $this->exec_rows();
            return $this->rows ;
        }
        else if( $operator == 'api') {
            $this->exec_rows();

            $control = [
                "total"			=> $this->results->total(),
                "per_page"		=> $this->results->perPage(),
                "current_page"	=> $this->results->currentPage(),
                "last_page"		=> $this->results->lastPage(),
                "next_page_url"	=> $this->results->nextPageUrl(),
                "prev_page_url"	=> $this->results->previousPageUrl(),
            ];

            $result = [
                'fields'	=> $this->data['fields'] ,
                'views'		=> $this->data['views'] ,
                'data'		=> $this->rows ,
                'total'		=> $this->results->total(),
                'control'	=> $control
            ];
            return $result ;
        }
        else if( $operator == 'array') {
            $this->exec_rows();
            $result = [
                'this_key'		=> $this->data['this_key'] ,
                'this_table'		=> $this->data['this_table'] ,
                'fields'	=> $this->data['fields'] ,
                'views'		=> $this->data['views'] ,
                'rows'		=> $this->rows ,
                'paginator'		=> $this->paginate,
            ];
            return $result ;
        }
        else {
            return $this->data;
        }
    }
    public function render( $type = 'crud' )
    {


        $this->prepare_data();
        $datas = $this->data ;
        $datas['type'] = $type;

        foreach($this->to_layout as $temp => $pars )
        {
            $this->template['form'] = 'CrudEngine.'.$this->theme.'.'.$temp;
            $datas['layout'] = $pars;
        }

        foreach($this->view_layout as $temp => $pars )
        {
            $this->template['view'] = 'CrudEngine.'.$this->theme.'.view_'.$temp;
            $datas['layout'] = $pars;
        }

        if(count($this->to_template))
        {
            $this->template =  array_merge(  $this->template , $this->to_template);
        }
        if(count($this->append_data))
        {
            $datas = array_merge($datas , $this->append_data);
        }

        if($type == 'view')
        {
            unset($datas['paginator']);
            return $datas;
        }
        if($type == 'json')
        {
            unset($datas['paginator']);
            header('Content-Type: application/json');
            return json_encode($datas);
        }
        if(isset($_GET['task']) &&  $_GET['task'] =='download')
        {
            echo view('CrudEngine.utilities.csv',$datas);
            exit;
        }
        if(!\Request::ajax())
        {

            if(isset($_GET)){
                $direct_access = '';
                foreach($_GET as $get_key=> $get_value)
                {
                    $direct_access .= ''.$get_key.':'.$get_value.'|';
                }
                if($direct_access !=''){
                    $direct_access = '?direct='.substr($direct_access,0,strlen($direct_access)-1);
                    $datas['url'] = $datas['url'] . $direct_access ;
                }
            }


            $task = (isset($_GET['task']) ? $_GET['task'] : 'default');
            switch($task) {
                default:

                    if($this->theme !='datatable'){
                        $this->exec_rows();
                        $datas['rows']		= $this->rows;
                        $datas['paginator']	= $this->paginate;
                        $datas['template'] 	= $this->template['table'];
                    }
                    return view( 'CrudEngine.'.$this->theme.'.initialize', $datas );
                    break;
                case 'print':
                    $this->exec_rows();
                    $datas['rows'] = $this->rows;
                    echo view('CrudEngine.utilities.print', $datas );
                    exit;
                    break;
                case 'export':
                    $this->exec_rows();
                    $datas['rows'] = $this->rows;
                    echo view('CrudEngine.utilities.csv', $datas );
                    exit;
                    break;
            }
        }
        else {

            $this->exec_rows();

            $datas['rows']		= $this->rows;
            if($this->theme !='datatable')
                $datas['paginator']	= $this->paginate;

            $post = (isset($_POST['task']) ? $_POST['task'] : 'default');

            switch($post) {
                default :
                    $this->datatable_action( $datas );
                    break;
                case 'insert' :
                case 'update' :
                    $this->exec_forms();
                    $this->save();
                    break;
                case 'copy' :
                    $this->copy();
                    break;

                case 'delete' :
                    $this->delete();
                    break;

                case 'search' :
                    $this->search();
                    break;
            }



            $task = (isset($_GET['task']) ? $_GET['task'] : 'default');

            if(isset($_GET['direct'])){
                $value ='';
                $val = explode('|',$_GET['direct']);
                $array = [];
                foreach($val as $v){
                    $value .= str_replace(':','=',$v).'&';
                    $k = explode(':',$v);
                    if(isset($k[0]) && isset($k[1])){
                        $array [$k[0]] = $k[1] ;
                    }


                }
                $datas['direct'] =  $value;
                $datas['direct_array'] =  $array;

            }

            switch($task) {

                default:
                    echo view( $this->template['table'] , $datas );
                    exit;
                    break;

                case 'view' :
                    $datas['row'] = $datas['rows'][0];
                    $datas['subdetail'] = $this->subdetail ;
                    echo view(  $this->template['view'] , $datas );
                    exit;
                    break;

                case 'create' :
                case 'update' :
                    $this->exec_forms();
                    $key_value = $this->row[$this->key];

                    $datas['key_value' ] 	= ($_GET['task'] == 'create' ? '' : $key_value);
                    $datas['task_value' ] 	= ($_GET['task'] == 'create' ? 'insert' : 'update');
                    $datas['forms'] = $this->to_forms;
                    $datas['javascript'] = $this->to_javascript;
                    $datas['form_view'] = $this->form_view;
                    $datas['row'] = $this->row;

                    $this->exec_subforms();
                    $datas['subforms'] = $this->to_subforms;
                    echo view(  $this->template['form'] , $datas );
                    exit;
                    break;
                case 'delete':
                    break;
                case 'sub':
                    unset($datas['paginator']);
                    echo view(  $this->template['sub'] , $datas );
                    exit;
                    break;
                case 'remove_file' :
                    $file = $_GET['file'];
                    if(file_exists('./'.$file) && $file !='')
                    {
                        unlink( './'.$file);
                        header('Content-Type: application/json');
                        echo json_encode(array('status'=>'success','message'=>' Image/files removed successfull '));
                    }
                    else {
                        header('Content-Type: application/json');
                        echo json_encode(array('status'=>'error','message'=>' Image/files not found ! '));
                    }
                    exit;
                    break;
                case 'combo' :
                    echo $this->comboselect();
                    exit;
                    break;
            }
        }

    }

    public function save( ){
        $rules = array();
        if (count($this->to_validation))
        {
            foreach ($this->to_validation as $key => $val)
            {
                $rules[$key] = $val ;
                /* If validation contain unique field from table database */
                if (strpos($val, 'unique') !== false) {
                    if($_POST[ $this->key ] !='' )
                    {
                        unset($rules[$key]);
                    }

                }
            }

        }
        $validator = Validator::make($_POST, $rules);
        if ($validator->passes()) {
            $id = (isset($_POST[ $this->key ]) ? $_POST[ $this->key ] : '') ;
            $data = $this->_set_post_value();


            if( isset($this->call_action['before_save']))
            {
                $callback_return = call_user_func($this->call_action['before_save'], $_POST);
                if(!empty($callback_return) && is_array($callback_return))
                {
                    $data = array_merge($data , $callback_return );
                }
            }
            if( $id !='')
            {
                // If primary key value posted , then its update
                // Set Auto Field if exists field Created
                if(isset($this->column['Created']))
                    $data['Created'] = date("Y-m-d H:i:s");

                unset($data[ $this->key ]);
                \DB::table( $this->table )->where( $this->key , $id  )->update( $data );
                /* Insertn Logs Activities */
                $activity_note = "Row(s) ID <b>".$id."</b> Has Been Updated";
                $this->activity(['module'=> $this->title ,'task'=>'update','note'=> $activity_note ]);
            }
            else {
                // Set Auto Field if exists field Created
                if(isset($this->column['Created']))
                    $data['Updated'] = date("Y-m-d H:i:s");
                // Global features
                if($this->global == 0){
                    if(array_key_exists('EntryBy', $this->fields))
                        $data['EntryBy'] = session('uid');
                }

                // If primary key value is empty , then its insert
                unset($data[ $this->key ]);
                $id = \DB::table( $this->table )->insertGetId( $data );
                /* Insertn Logs Activities */
                $activity_note = "Row(s) ID <b>".$id."</b> Has Been Added";
                $this->activity(['module'=> $this->title ,'task'=>'Insert','note'=> $activity_note ]);
            }
            // proccess subform if any
            $this->save_sub() ;

            if( isset($this->call_action['after_save'])){
                $data[ $this->key] = $id ;
                $callback_return = call_user_func($this->call_action['after_save'], $data);
            }

            // Now action after save
            echo json_encode(array('status'=>'success','message'=>' Post have been saved successfull !','after' =>  $_POST['data-after-task'] ,'id'=> $id ));
        }
        else {
            $message = $this->validateListError(  $validator->getMessageBag()->toArray() );
            echo json_encode(array('status'=>'error','message'=> $message ));
        }
        exit;
    }
    public function save_sub( $id = 0 )
    {
        if(count($this->subform))
        {
            $sub_id 	= $this->subform['key'] ;
            $relation 	= $this->subform['relation'] ;
            $table 		= $this->subform['table'] ;

            if(isset($_POST[ 'sub_key' ]) && isset( $_POST[ 'sub_relation' ] ))
            {
                $total = $_POST['sub_counter'];

                $currentRow = \DB::table( $this->subform['table'] )
                    ->where( $relation , $_POST[ $this->key ] )
                    ->get();
                if (count($currentRow))
                {
                    $pkeys = array();
                    for($i=0; $i<count($total);$i++)
                        $pkeys[] = $_POST['sub_'.$sub_id][$i];

                    foreach ($currentRow as $row)
                    {
                        if(!in_array($row->{$sub_id} , $pkeys))
                            \DB::table( $table )->where($sub_id, $row->{$sub_id})->delete();
                    }
                }
                for($i = 0; $i < count($total) ; $i++)
                {
                    $data = array();
                    foreach ($this->subform['form'] as $field=>$par )
                    {
                        if ($field != $sub_id)
                            $data[ $field ] = $_POST['sub_'.$field][$i];
                    }
                    $data[ $relation ] = $id;
                    $sub_value =   $_POST['sub_'.$sub_id][$i];
                    if($sub_value =='')
                    {
                        // Insert New record
                        \DB::table( $table )->insert( $data );
                    }
                    else {
                        // Update current record
                        \DB::table( $table )->where( $sub_id , $sub_value)->update( $data );
                    }
                }
            }
        }
    }
    public function copy()
    {

        foreach(\DB::select("SHOW COLUMNS FROM ".$this->table) as $column)
        {
            if( $column->Field != $this->key)
                $columns[] = $column->Field;
        }

        if(count($_POST['ids']) >=1)
        {
            $toCopy = implode(",",$_POST['ids']);
            $sql = "INSERT INTO ".$this->table." (".implode(",", $columns).") ";
            $sql .= " SELECT ".implode(",", $columns)." FROM ".$this->table." WHERE ".$this->key." IN (".$toCopy.")";
            \DB::select($sql);
            header('Content-Type: application/json');
            echo json_encode(array('status'=>'success','message'=>' Row(s) copied successfull !'));
        }
        exit;
        //echo json_encode(array('status'=>'success','message'=>' Post have been saved successfull !'));

    }
    public function delete( )
    {
        // execute action before delete if any
        if( isset($this->call_action['before_delete']))
            call_user_func($this->call_action['before_delete'], $_POST);
        if(count($_POST['ids']) >=1)
        {
            \DB::table( $this->table )->whereIn( $this->key , $_POST['ids'])->delete();

            /* Insertn Logs Activities */
            $activity_note = "Row(s) ID <b>".implode(",", $_POST['ids'])."</b> Has Been Deleted";
            $this->activity(['module'=> $this->title ,'task'=>'Insert','note'=> $activity_note ]);
        }
        // execute action after delete if any
        if( isset($this->call_action['after_delete']))
            call_user_func($this->call_action['after_delete'], $_POST);

        header('Content-Type: application/json');
        echo json_encode(array('status'=>'success','message'=>' Row(s) have been deleted successfull !'));
        exit;
    }

    function wild_save( $id , $post , $replace = array() ) {

        $this->_build_statement();
        $this->_prepare_columns();

        $data = array();
        foreach($this->row as $key=>$val ){
            if(isset($post[$key]))
            {
                $data[$key] =$post[$key] ;
            }
        }
        if(count($replace)){
            $data = array_merge($data, $replace);
        }
        if( $id =='')
        {
            if(isset($this->row['Created']))
                $data['Created'] = date("Y-m-d H:i:s");

            $id = \DB::table( $this->table )->insertGetId($data);
        }
        else {
            if(isset($this->row['Updated']))
                $data['Updated'] = date("Y-m-d H:i:s");

            \DB::table( $this->table )->where($this->key , $id )->update($data);
        }
        return ['status'=>'success','id'=> $id ];
    }
    function wild_row( $id , $key = null ) {

        $this->_build_statement();
        $this->_prepare_columns();

        if( $key != null  ) {
            $this->key = $key ;
        }

        if($id !=''){
            $res = \DB::table($this->table)->where($this->key,$id)->get();
            if(count($res)>=1) {
                $row = (array) $res[0];
                return array_merge($this->row , $row);
            }

        }
        return $this->row ;
    }
    function wild_rows( $id , $key = null ) {

        $this->_build_statement();
        $this->_prepare_columns();

        if( $key != null  ) {
            $this->key = $key ;
        }

        $res = \DB::table($this->table)->where($this->key,$id)->get();
        return $res ;
    }

    function wild_delete( $id , $key = null) {
        $this->_build_statement();
        $this->_prepare_columns();
        if( $key != null  ) {
            $this->key = $key ;
        }
        \DB::table($this->table)->where( $this->key , $id )->delete();
    }

    function comboselect()
    {

        $param  = explode(':', $_GET['filter']);
        $table  = $param[0];
        $limit  = array();
        $parent = array();

        if(isset($_GET['limit']))
        {
            $limit = explode(':', $_GET['limit']);
        }

        if(isset($_GET['parent']))
        {
            $parent = explode(':', $_GET['parent']);
        }

        $result = \DB::table($table);

        if(count($parent) >= 2)
            $result = $result->where($parent[0], $parent[1]);
        if(count($limit) >= 2)
            $result = $result->where($limit[0], $limit[1], $limit[2]);


        $rows =  $result->get();
        $items = array();

        $fields = explode("-",$param[2]);
        $items = array();
        foreach($rows as $row)
        {
            $value = "";
            foreach($fields as $val)
            {
                $value .= $row->{$val}." ";
            }
            $items[] = array($row->{$param['1']} , $value);

        }

        header('Content-Type: application/json');
        echo json_encode($items);
        exit;


    }

    public static function activity( $data  )
    {

        $data = array(
            'module'	=> $data['module'],
            'task'		=> $data['task'],
            'user_id'	=> session('uid'),
            'ipaddress'	=> (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'localhost'),
            'note'		=> $data['note'],
        );
        \DB::table( 'tb_logs')->insert($data);
    }
    public function search( )
    {
        $on_search  = explode("|",$_GET['search'] );
        if(count($on_search) ==1)
        {
            // Single search to all fields
            $search ='';
            foreach($this->to_display as $key=>$val)
            {
                $search .= " AND {$key}  LIKE '%".$_GET['on_search']."%%' ";
            }
            header('Content-Type: application/json');
            echo json_encode(array('status'=>'success','params'=> $search ));
            exit;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('status'=>'success','message'=> 'Nothing to search !'));
            exit;
        }
    }
    public static function formatRows( $value ,$attr , $row = null )
    {
        $format_as = (isset($attr['0']) ?  $attr['0'] : '');
        $format_value = (isset($attr['1']) ?  $attr['1'] : '');

        preg_match('~{([^{]*)}~i',$format_value, $match);
        if(isset($match[1]))
        {
            $real_value = $row->{$match[1]};
            $format_value	= str_replace($match[0],$real_value,$format_value);
        }
        if($format_as =='image')
        {
            // FORMAT AS IMAGE
            $vals = '';
            $values = explode(',',$value);
            foreach($values as $val)
            {
                if($val != '')
                {
                    if(file_exists('.'.$format_value . $val))
                        $vals .= '<a href="'.url( $format_value . $val).'" target="_blank" class="previewImage"><img src="'.asset( $format_value . $val ).'" border="0" width="50" class="img-circle" style="margin-right:2px;" /></a>';
                }
            }
            $value = $vals;
        } elseif($format_as =='link') {
            // FORMAT AS LINK
            if (strpos($format_value, 'http://') !== true) {
                $format_value = url($format_value);
            }
            $append = '';
            if(isset($attr[2]))
                $append = 'onclick="SximoModal(this.href); return false;"';
            $value = '<a href="'.$format_value.'" '.$append.'>'.$value.'</a>';
        } elseif($format_as =='mailto') {
            // FORMAT AS LINK
            $value = '<a href="'.$format_value.':'.$value.'">'.$value.'</a>';
        } elseif($format_as =='number') {
            // Format as Number or Currency
            if($format_value !='')
            {
                $opt = explode(":",$format_value);
                $value = $opt[0] .' '. number_format($value,2,",",".");
            }
            else {
                $value =  number_format($value);
            }
        } else if($format_as =='date') {
            // FORMAT AS DATE
            if($format_value =='')
            {
                if(config('sximo.cnf_date') !='' )
                {
                    $value = date("".config('sximo.cnf_date')."",strtotime($value));
                }
            } else {
                $value = date("$format_value",strtotime($value));
            }

        }  else if($format_as == 'file') {
            // FORMAT AS FILES DOWNLOAD
            $vals = '';
            $values = explode(',',$value);
            foreach($values as $val)
            {

                if(file_exists('.'.$format_value . $val))
                    $vals .= '<a href="'.asset($format_value. $val ).'"> '.$val.' </a><br />';
            }
            $value = $vals ;
        } else if( $format_as =='lookup' or $format_as =='database') {
            // Database Lookup

            if($value != '')
            {
                $fields = explode(":",$format_value);
                if(count($fields)>=2)
                {
                    $field_table  =  str_replace('-',',',$fields[2]);
                    $field_toShow =  explode("-",$fields[2]);

                    $Q = \DB::select(" SELECT * FROM ".$fields[0]." WHERE ".$fields[1]." IN(".$value.") ");
                    if(count($Q) >= 1 )
                    {
                        $value = '';
                        foreach($Q as $qv)
                        {
                            $sub_val = '';
                            foreach($field_toShow as $fld)
                            {
                                $sub_val .= $qv->{$fld}.' ';
                            }
                            $value .= $sub_val.', ';

                        }
                        $value = substr($value,0,-2);
                    }
                }
            }
        }  else if($format_as == 'checkbox' or $format_as =='radio') {
            // FORMAT AS RADIO/CHECKBOX VALUES

            $values = explode(',',$format_value);
            if(count($values)>=1)
            {
                for($i=0; $i<count($values); $i++)
                {
                    $val = explode(':',$values[$i]);
                    if(trim($val[0]) == $value) $value = $val[1];
                }

            } else {

                $value = '';
            }

        } elseif ($format_as =='function'){

            $val = $attr[3];

            foreach($row as $k=>$i)
            {
                if (preg_match("/$k/",$val))
                    $val = str_replace($k,$i,$val);
            }
            $val = $val;
            if(isset($attr[1]) && class_exists($attr[1]) )
            {

                $args = explode(':',$val);
                //$value = $args;
                if(count($args)>=2)
                {
                    $value = call_user_func( array($attr[1],$attr[2]) , $args )  ;
                } else {
                    $value = call_user_func( array($attr[1],$attr[2]), $val);
                }

            } else {
                $value = 'Class Doest Not Exists';
            }


        }  else {

        }
        return $value;
    }
    function _set_post_value( )
    {
        $data = array();
        foreach($this->to_posts as $key=> $val)
        {
            $type = $val['type'];
            $params = $val['params'];
            $value = ( isset($_POST[ $key]) ? $_POST[ $key ] : '');

            if( $type =='editor' || $type =='textarea')
            {
                $data[ $key ] = $value ;
            }
            elseif( $type == 'date')
            {
                $data[ $key ] = date("Y-m-d",strtotime($value));
            }
            elseif( $type == 'time')
            {
                $data[ $key ] = date("H:i:s",strtotime($value));
            }
            elseif( $type == 'datetime' )
            {
                $data[ $key ] = date("Y-m-d H:i:s",strtotime($value));
            }
            elseif( $type == 'password' )
            {
                if($value =='')
                {
                    unset( $data[$key]);
                }
                else
                {
                    $data[ $key ] = \Hash::make($value);
                }
            }
            elseif( $type == 'upload' || $type == 'image' || $type == 'file' )
            {
                $files = '';
                if(isset($_POST['curr'.$key]))
                {
                    $curr =  '';
                    for($i=0; $i<count($_POST['curr'.$key]);$i++)
                    {
                        $files .= $_POST['curr'.$key][$i].',';
                    }
                }

                if(isset($_FILES[$key]["name"]))
                {
                    $path 			= $params['path'];
                    $directory 		= public_path(). $path;
                    if(!is_dir( $directory ))
                    {
                        mkdir( $directory , 0777);

                    }
                    if(isset($params['image_multiple']) && $params['image_multiple'] =='1')
                        $multiple = true ;
                    if(isset($params['multiple']) && $params['multiple'] ==true )
                        $multiple = true;

                    if( isset($multiple) && $multiple ==true ) {

                        foreach($_FILES[$key]['tmp_name'] as $k => $tmp_name ){
                            $file_name = $_FILES[$key]['name'][$k];
                            $file_tmp =$_FILES[$key]['tmp_name'][$k];
                            if($file_name !='')
                            {
                                move_uploaded_file($file_tmp,$directory.'/'.$file_name);
                                $files .= $file_name.',';
                            }
                        }
                        if($files !='')	$files = substr($files,0,strlen($files)-1);
                        $data[$key] = $files;

                    }
                    else {

                        $path 			= $params['path'];
                        $directory 		= public_path(). $path;
                        $file 			= basename($_FILES[$key]["name"]);
                        $extension 		= pathinfo($file,PATHINFO_EXTENSION);
                        $check 			= getimagesize($_FILES[$key]["tmp_name"]);
                        $rand 			= rand(1000,100000000);
                        $newfilename 	= strtotime(date('Y-m-d H:i:s')).'.'.$extension;


                        if(move_uploaded_file( $_FILES[$key]["tmp_name"] , $directory . $newfilename ))
                        {
                            $data[$key] = $newfilename;
                        }

                    }
                }

            }
            elseif( $type == 'select' )
            {
                if( is_array($value) && count($value))
                {
                    $data[$key] = implode(",", $value);
                }
                else {
                    $data[ $key ] = $value ;
                }
            }
            elseif( $type == 'checkbox' )
            {
                if( is_array($value) && count($value) )
                {
                    $data[$key] = implode(",", $value);
                }
                else{
                    $data[$key] = '';
                }
            }
            else{
                $data[ $key ] = $value ;
            }
        }
        return $data;
    }
    function _set_field_Form( $type , $value , $param )
    {

        $validation = '';
        if($param['validation'] !='')
            $validation = (count(explode('|', $param['validation'])) ? 'required' : '');

        /* Sximo Bridge */
        if($type =='text_datetime') $type ='datetime';
        if($type =='text_date') 	$type ='date';
        if($type =='textarea_editor') 	$type ='editor';
        /* Sximo Bridge */

        $attribute = (isset($param['attribute']) ? $param['attribute'] : '');
        $tooltip = (isset($param['tooltip']) ? $param['tooltip'] : '');

        $tooltip =  ($tooltip !='' ? '<p class="form-tips"><span class="text-danger"> * </span> '.$tooltip ."</p>" : '' );
        switch ($type)
        {
            default:
            case 'text':
                if(isset($param['prefix']) && $param['prefix'] !='' or isset($param['sufix']) && $param['sufix'] !='')
                {
                    $form ='<div class="input-group">';
                    if($param['prefix'] !='')
                        $form .= ' <span class="input-group-addon">'.$param['prefix'].'</span>';

                    $form .= '<input type="text" id="'.$param['field'].'" name="'.$param['field'].'" value="'. $value .'" class="input-sm form-control" '.$validation.' '.$attribute.' /> ';

                    if($param['sufix'] !='')
                        $form .= ' <span class="input-group-addon">'.$param['sufix'].'</span>';

                    $form .= '</div>'.$tooltip;
                } else {
                    $form = '<input type="text" id="'.$param['field'].'" name="'.$param['field'].'" value="'. $value .'" class="input-sm form-control" '.$validation.' '.$attribute.' /> '.$tooltip;
                }
                break;
            case 'password':
                $form = '
            	<label> Type Password (*) <small><i> Leave blank if no changes </i></small></label>
            	<input type="password" name="'.$param['field'].'" value="" class="input-sm form-control"  />
            	<label> Confirm Password </label>
            	<input type="password" name="confirm_'.$param['field'].'" value="" class="input-sm form-control"  />

            	';
                break;
            case 'timestamp':
                $form = '<input type="text" id="'.$param['field'].'" name="'.$param['field'].'" value="'. $value .'" class="input-sm form-control CrudEngineDateTime"  '.$validation.' '.$attribute.' />';
                break;
            case 'date':
                $form = '
            	<div class="input-group"  style="width:250px !important" >				  
				  <input type="text" class="form-control input-sm CrudEngineDate" id="'.$param['field'].'" name="'.$param['field'].'" value="'. $value .'" '.$validation.'  '.$attribute.'/>
				  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
				</div>

            	';
                break;
            case 'time':
                $form = '
            	<div class="input-group"  style="width:250px !important" >				  
				  <input type="text" class="form-control input-sm CrudEngineTime" id="'.$param['field'].'" name="'.$param['field'].'" value="'. $value .'" '.$validation.'  width="150"/>
				  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-clock-o"></i></span>
				</div>
				';
                break;
            case 'year':
                $form = '
            	<div class="input-group"  style="width:250px !important" >				  
				  <input type="text" class="form-control input-sm CrudEngineYear" id="'.$param['field'].'" name="'.$param['field'].'" value="'. $value .'" '.$validation.' '.$attribute.' />
				  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar-check-o"></i></span>
				</div>
				';
                break;
            case 'datetime':
                $form = '
            	<div class="input-group"  style="width:250px !important" >				  
				  <input type="text" class="form-control input-sm CrudEngineDateTime" id="'.$param['field'].'" name="'.$param['field'].'" value="'. $value .'" '.$validation.' '.$attribute.' />
				  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar-o"></i></span>
				</div>
				';
                break;
            case 'editor':
                $form = '<textarea name="'.$param['field'].'" id="'.$param['field'].'" class=" input-sm form-control CrudEngineEditor" '.$validation.' '.$attribute.' >'. $value .'</textarea>';
                break;
            case 'textarea':
                $form = '<textarea name="'.$param['field'].'" id="'.$param['field'].'" class=" input-sm form-control" '.$attribute.' '.$validation.'>'. $value .'</textarea>';
                break;
            case 'radio':
                $form ='';
                $options = explode(',',str_replace("'","",$param['lenght']));
                if(isset($param['lookup_query']))
                {
                    $options = explode(',',$param['lookup_query']);
                }
                foreach($options as $opt)
                {
                    $f = $opt ; $v = $opt ;
                    if (strpos($opt, ':') !== false) {
                        $opt = explode(":",$opt);
                        $f = $opt[0] ; $v = $opt[1];
                    }
                    $checked = ($value == $f ? 'checked' : '');
                    $form .= '
            					<input '.$validation.' type="radio" name="'.$param['field'].'" value="'.$f.'" '.$checked.' class="minimal-green"> '. ucwords($v);
                }
                break;
            case 'checkbox':
                $form ='';
                $options = explode(',',str_replace("'","",$param['lenght']));
                if(isset($param['lookup_query']))
                {
                    $options = explode(',',$param['lookup_query']);
                }
                $value = explode(',', $value);
                foreach($options as $opt)
                {
                    $checked = (in_array($opt , $value ) ? 'checked' : '');
                    $form .= '<input type="checkbox" '.$validation.' name="'.$param['field'].'[]" value="'.$opt.'" '.$checked.' class="minimal-green" > '. ucwords($opt) .' ';
                }
                break;
            case 'select';
                /* Sximo Bridge */

                if(isset($param['opt_type']) && $param['opt_type'] =='external')
                {
                    $param['lookup'] =  $param['lookup_table'].':'.$param['lookup_key'].':'.$param['lookup_value'];
                }
                if(isset($param['opt_type']) && $param['opt_type'] =='datalist')
                {
                    $param['options'] =  $param['lookup_query'];
                }
                /* End Sximo Bridge */
                $is_multiple = (isset($param['multiple']) && $param['multiple'] == true ? 'true' : 'false');
                if(isset($param['select_multiple']) && $param['select_multiple'] == true){
                    $is_multiple ='true';
                }
                $value = ($is_multiple =='true' ? explode(',', $value) : $value );
                $mark =''; $is_m ='';
                $select = '<option value=""> -- Select --</option>';
                if(isset($param['options']))
                {
                    $options = explode(',',$param['options']);
                    foreach($options as $opt)
                    {
                        $opt = explode(":",$opt);
                        $f = $opt[0] ; $v = $opt[1] ;
                        $selected = ($value == $f ? 'selected' : '');
                        if($is_multiple =='true' )
                            $selected = (in_array($f , $value) ? 'selected' : '');

                        $select .= '<option value="'.$f.'" '.$selected.'>'.$v.'</option>';
                    }
                }
                // This is for lookup options
                if (isset($param['lookup']) )
                {

                    $select .= '';

                }
                if($is_multiple =='true' )
                {
                    $mark = '[]';
                    $is_m = 'multiple';
                }
                $form = '<select id="'.$param['field'].'" name="'.$param['field']. $mark .'" '.$is_m.' '.$validation.' class="input-sm form-control select2" >'.$select.'</select>';
                break;
            case 'upload';
            case 'image';
            case 'file';



                if(isset($param['upload_type']))
                    $type = $param['upload_type'] ;

                $path = (isset($param['path']) ? $param['path'] : '/uploads/');
                $files = '';
                $values = explode(",",$value);
                $i = 0;
                if(count($values) && $value !='')
                {
                    foreach($values as $file) {
                        if($type =='image'):
                            $show = '<img src="'. asset( $param['path'] . $file ) .'" style="width:100px;" />';
                        else :
                            $show =  '<i class="fa fa-file"></i><br />'. $file ;
                        endif;

                        if(file_exists('.'.$path.'/'.$file) && $path !=''){
                            $files .= '
							<li id="cr-'.$i.'" class="">							
								<a href="'. asset($param['path'] . $file) .'" target="_blank" >'. $show .'</a> 
								<span class=" removeMultiFiles" rel="#cr-'. $i.'" url="'.$param['path']. $file .'">
								<i class="fa fa-times  btn btn-xs btn-danger"></i></span>
								<input type="hidden" name="curr'.$param['field'].'[]" value="'. $file .'"/>
							</li>';
                        }
                        ++$i;
                    }
                }
                $is_multiple = (isset($param['multiple']) && $param['multiple'] == true ? 'true' : 'false');
                if(isset($param['image_multiple']) && $param['image_multiple'] =='1')
                {
                    $is_multiple = 'true' ;
                }

                if($is_multiple =='true')
                {

                    $form = '
					<a href="javascript:void(0)" class="btn btn-xs btn-primary pull-right" onclick="appendFormFiles(\''.$param['field'].'\')"><i class="fa fa-plus"></i></a>
					<div class="'.$param['field'].'Upl">	
					 	<input  type=\'file\' name=\''.$param['field'].'[]\'  />			
					</div>';
                } else {
                    $form = '<input type="file" name="'.$param['field'].'" ><br />';
                }

                $form .= '
				<ul class="uploadedLists " >
					'.$files.'	
				</ul>
				';




                break;
        }
        return $form;

    }

    function _set_field_Type( $type )
    {
        switch($type)
        {
            default:
            case 'char':
            case 'varchar':
            case 'binary':
            case 'varbinary':
            case 'smallint':
            case 'mediumint':
            case 'int':
            case 'bigint':
            case 'serial':
                $type = 'text';
                break;
            case 'date';
                $type = 'date';
                break;
            case 'time';
                $type = 'time';
                break;
            case 'year';
                $type = 'year';
                break;
            case 'datetime';
                $type = 'datetime';
                break;
            case 'timestamp';
                $type = 'timestamp';
                break;
            case 'enum';
                $type = 'radio';
                break;
            case 'set';
                $type = 'checkbox';
                break;
            case 'text';
            case 'blob':
            case 'tinytext':
            case 'mediumtext':
            case 'longtext':
                $type = 'textarea';
                break;
            case 'select';
                $type = 'select';
                break;
        }
        return $type;
    }


    public function datatable_action( ) {

        if(isset($_POST['draw']))
        {
            $array = [];
            foreach($this->rows as $row)
            {
                $values = array();
                $values =[];
                $values['rowId'] = $row[$this->table.'.'.$this->key];
                $values['checkbox'] = "<input type='checkbox' class='ids minimal-green' name='ids[]' value='{$values['rowId']}' />";
                foreach($this->to_display as $key=>$val)
                {
                    $field = explode(".",$key);
                    $values[$field[1]] = $row[$key];

                }
                $url = ($this->url =='' ? \Request::segment(1) : $this->url);
                $actionId = 'CrudEngine-'.$this->actionId ;
                if($this->method['form'] =='modal')
                {
                    $onclickForm = 'onclick="CrudEngineModal(\''.url($url).'?task=update&id='.$row[$this->table.'.'.$this->key].'\', this.href ); return false;"';
                } else {
                    $onclickForm = 'onclick="CrudEngine_ViewDetail(\'#'.$actionId.'\', \''.url($url).'?task=update&id='.$row[$this->table.'.'.$this->key].'\' ); return false;"';
                }

                if($this->method['view'] =='modal')
                {
                    $onclickView = 'onclick="CrudEngineModal(\''.url($url).'?task=view&id='.$row[$this->table.'.'.$this->key].'\', this.href ); return false;"';
                } else {
                    $onclickView = 'onclick="CrudEngine_ViewDetail(\'#'.$actionId.'\', \''.url($url).'?task=view&id='.$row[$this->table.'.'.$this->key].'\' ); return false;"';
                }

                $action = '';

                if(isset($this->button['view']))
                    $action .= '<li><a href="javascript://ajax" '.$onclickView.' 
							> '.__('core.btn_view').'</a></li>';

                if(isset($this->button['update']))
                    $action .= '<li><a href="javascript://ajax"  '.$onclickForm.'
						    onclick=""> '.__('core.btn_edit').'</a></li> ';

                if(isset($this->button['update']) || isset($this->button['view']))
                {
                    $button ='<div class="dropdown pull-right"><button class="btn btn-primary btn-xs  dropdown-toggle" data-toggle="dropdown">
					         Action 
					        </button>
					            <ul class="dropdown-menu text-right">
					            ';
                    $button .= $action ;
                    $button .'</ul></div> ' ;
                    $values['action'] = $button ;
                } else {
                    $values['action'] = '';
                }


                $array[] = $values;
            }

            $data = array(
                'draw'				=> (isset($_POST['draw']) ? intval($_POST['draw'] ) : 0),
                'recordsTotal'		=> $this->total ,
                'recordsFiltered'	=> $this->total,
                'data'				=> $array

            );
            header('Content-Type: application/json');
            echo json_encode( $data );
            exit;
        }
    }
    public function datatable_post()
    {
        $cols = array();
        $values['rowId'] = $this->key;
        foreach($this->to_display as $key=>$val)
        {
            $field = explode(".",$key);
            $cols[] = array('db'=> $field[0],'dt'=> $field[1] );
        }
        $dpost =  DataTable::simple($_POST,$cols);
        // For Datatable Needs
        if(isset($dpost['limit']) && $dpost['limit'] !='')
        {
            $this->limit 	= $dpost['limit'];
            $this->page 	= $dpost['page'];
        }
        // For Datatable Needs
        if(isset($dpost['order']) && count($dpost['limit']))
        {
            $this->order_by 	= $dpost['order']['sort'];
            $this->order_type 	= $dpost['order']['by'];
        }
        if(isset($_POST['search']) && $_POST['search']['value'] !='' )
        {
            $this->search 	= $_POST['search']['value'];
        }
        return $this ;
    }


    function validateListError( $rules )
    {
        // $errMsg = ' Errors : ' ;
        $errMsg = ' <ul>';
        foreach($rules as $key=>$val)
        {
            $errMsg .= '<li>'.$key.' : '.$val[0].'</li>';
        }
        $errMsg .= '</li>';
        return $errMsg;
    }
}