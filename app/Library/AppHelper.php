<?php
class AppHelper {

	public function __construct()
	{

		$this->data = json_decode(file_get_contents(base_path().'/resources/views/core/posts/config.json'),true);
	}

	/* Display Logged  Users Pics */
	public static function avatar( $width =75 , $id = '')
	{
		$avatar = '<img alt="" src="http://www.gravatar.com/avatar/'.md5(session('eid')).'" class="img-circle" width="'.$width.'" />';
		if($id =='') {
			$id = session('uid');
		}
		$Q = DB::table("tb_users")->where("id",'=',$id)->get();
		if(count($Q)>=1) 
		{
			$row = $Q[0];
			$files =  './uploads/users/'.$row->avatar ;
			if($row->avatar !='' ) 	
			{
				if( file_exists($files))
				{
					return  '<img src="'.asset('uploads/users').'/'.$row->avatar.'" border="0" width="'.$width.'" class="img-circle" />';
				} 
				else {
					return $avatar;
				}	
			} 
			else {
				return $avatar;
			}
		}	
	}

	public static function slug($str, $separator = 'dash', $lowercase = FALSE)
	{
		if ($separator == 'dash')
		{
			$search		= '_'; 	$replace	= '-';
		}
		else
		{
			$search		= '-';	$replace	= '_';
		}	
		$trans = array(
					'&\#\d+?;'				=> '',
					'&\S+?;'				=> '',
					'\s+'					=> $replace,
					'[^a-z0-9\-\._]'		=> '',
					$replace.'+'			=> $replace,
					$replace.'$'			=> $replace,
					'^'.$replace			=> $replace,
					'\.+$'					=> ''
			  );	
		$str = strip_tags($str);	
		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}	
		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}		
		return trim(stripslashes(strtolower($str)));
	}	
	static public function showNotification()
	{
		$status = Session::get('status');

		if(Session::has('message')): ?>	  
		<script type="text/javascript">
            $(document).ready(function(){
		        $.toast({
		            heading: '<?php echo session('status');?>',
		            text: '<?php echo session('message');?>',
		            position: 'top-right',		           
		            icon: '<?php echo $status;?>',
		            hideAfter: 3000,
		            stack: 6
		        });

	        });

		</script>		
		<?php endif;	
	}	
	public static function langOption()
	{
		$path = base_path().'/resources/lang/';
		$lang = scandir($path);

		$t = array();
		foreach($lang as $value) {
			if($value === '.' || $value === '..') {continue;} 
				if(is_dir($path . $value))
				{
					$fp = file_get_contents($path . $value.'/info.json');
					$fp = json_decode($fp,true);
					$t[] =  $fp ;
				}	
			
		}	
		return $t;
	}
	public static function themeOption()
	{
		
		$path = base_path().'/resources/views/layouts/';
		$lang = scandir($path);
		$t = array();
		foreach($lang as $value) {
			if($value === '.' || $value === '..' || $value === 'themes' ) {continue;} 
				if(is_dir($path . $value))
				{
					$fp = file_get_contents($path .$value.'/info.json');
					$fp = json_decode($fp,true);
					$t[] =  $fp ;
				}	
			
		}	
		return $t;
	}		
	public static function backendOption()
	{
		
		$path = base_path().'/resources/views/layouts/themes/';
		$lang = scandir($path);
		$t = array();
		foreach($lang as $value) {
			if($value === '.' || $value === '..' ) {continue;} 
				if(is_dir($path . $value))
				{
					$fp = file_get_contents($path .$value.'/info.json');
					$fp = json_decode($fp,true);
					$t[] =  $fp ;
				}	
			
		}	
		return $t;
	}	
	static function latestpost(  )
	{
		$sql = Post::latestposts();
		$content = '
		
		<ul class="widgeul"> ';
		foreach($sql as $row) :
		$content .='<li>
		<b><a href="'. url('post/view/'.$row->pageID.'/'.$row->alias).'"> '. $row->title .'</a></b><br />
		<span> '. date("M j, Y " , strtotime($row->created)) .' </span>
		</li>';
		endforeach ;
		$content .='</ul>';

		return $content;
	}
	public static function cloudtags()
	{
		$tags = array();	
		$keywords = array();
		$word = '';
		$data = \DB::table('tb_pages')->where('pagetype','post')->get();
		foreach($data as $row)
		{
			$clouds = explode(',',$row->labels);
			foreach($clouds as $cld)
			{
				$cld = strtolower($cld);
				if (isset($tags[$cld]) )
				{
					$tags[$cld] += 1;
				} else {
					$tags[$cld] = 1;
				}
				//$tags[$cld] = trim($cld);
			}
		}

		ksort($tags);
		foreach($tags as $tag=>$size)
		{
			//$size += 12;
			$word .= "<a href='".url('post/label/'.trim($tag))."'><span class='cloudtags' ><i class='fa fa-tag'></i> ".ucwords($tag)." (".$size.") </span></a> ";
		}

		return $word;
	}	


	static function formatContent( $content )
	{
	    // character(s) to escape
	    $x = '`~!#^*()-_+={}[]:\'"<>.';
	    $content = preg_replace_callback('#(?<!\\\)!!([^\n]+?)!!#', function($m) use($x) {
	        $s = htmlentities($m[1], ENT_NOQUOTES);
	        return  self::__fnc($s, $x);
	    }, $content);
	    $content = preg_replace_callback('#\<php\>(.+?)\<\/php\>#s', function($m) use($x) {		  
		    $attr['code'] = $m[0];
		    return  view("Acore.secure.code", $attr);
		  }, $content);
	    $content = preg_replace_callback('#\<pre\>(.+?)\<\/pre\>#s',create_function(
		    '$matches',
		    'return "<pre class=\"prettyprint lang-php\">".htmlentities($matches[1])."</pre>";'
		  ), $content);	

	    $sortcodes = preg_match_all('#\[sc:.*\](.+?)\[\/sc\]#Ui', $content,$matches);
	    if(count($matches[0]))
	    {
	    	foreach($matches[0] as $code)
	    	{
	    		$sortcode = self::sortcode($code );	
	    		$result = ucwords($sortcode['code']).'Helper|'.$sortcode['params']['fnc'].'|'.$sortcode['params']['id'];
	    		$result = self::__fnc($result);
	    		$content = str_replace( $code ,$result, $content)	;
	    	}
	    }
	
	    return $content;
	} 

	static function sortcode( $content){

	    preg_match_all('/\[sc:([a-zA-Z0-9-_: |=\.]+)]/', $content, $shortcodes);

	    if ($shortcodes == NULL) {
           return $content;
        }

        $array = array();
        // Tidy up
        foreach ($shortcodes[1] as $key => $shortcode) {
            if (strstr($shortcode, ' ')) {
                $code = substr($shortcode, 0, strpos($shortcode, ' '));
                $tmp = explode('|', str_replace($code . ' ', '', $shortcode));
                $params = array();
                if (count($tmp)) {
                    foreach ($tmp as $param) {
                        $pair = explode('=', $param);
                        $params[$pair[0]] = $pair[1];
                    }
                }
                $array = array('code' => $code, 'params' => $params);
            }
            else {
                $array = array('code' => $shortcode, 'params' => array());
            }
            
            $shortcode_array[$shortcodes[0][$key]] = $array;
        }   

        if (count($shortcode_array)) {
         	
            foreach ($shortcode_array as $search => $shortcode) {
                $shortcode_model = $shortcode['code'];
            	$text = ' Code = '.$shortcode['code'];
            	$array = ['code'=> $shortcode['code'] , 'params'=> $shortcode['params'] ];
            }
            
            $array =  $array;
        }  

        return $array;

	}	
    static function __fnc( $args){

            $c = explode("|",$args);
            if(file_exists( app_path() .'/Library/'.$c[0].'.php') && !class_exists($c[0]))
            {
            	include( app_path() .'/Library/'.$c[0].'.php');
            	
            }        
            if(isset($c[0]) && class_exists($c[0]) )
            {
                $args = explode(':',$c[2]);
                if(count($args)>=2)
                {
                    $value = call_user_func( array($c[0],$c[1]), $args);    
                } else {
                    $value = call_user_func( array($c[0],$c[1]), str_replace(":","','",$c[2]));     
                }
                
            } else {
                    $value = '<pre>Class Doest Not Exists</pre>';
            }

            return $value;

    } 	
	public static function navigation( $position ='top',$active = '1')
	{
		$data = array();  
		$menu = self::nestedMenu(0,$position ,$active);		
		foreach ($menu as $row) 
		{
			$child_level = array();
			$p = json_decode($row->access_data,true);
			
			
			if($row->allow_guest == 1)
			{
				$is_allow = 1;
			} else {
				$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
			}
			if($is_allow ==1) 
			{
				
				$menus2 = self::nestedMenu($row->menu_id , $position ,$active );
				if(count($menus2) > 0 )
				{	 
					$level2 = array();							 
					foreach ($menus2 as $row2) 
					{
						$p = json_decode($row2->access_data,true);
						if($row2->allow_guest == 1)
						{
							$is_allow = 1;
						} else {
							$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
						}						
									
						if($is_allow ==1)  
						{						
					
							$menu2 = array(
									'menu_id'		=> $row2->menu_id,
									'module'		=> $row2->module,
									'menu_type'		=> $row2->menu_type,
									'url'			=> $row2->url,
									'menu_name'		=> $row2->menu_name,
									'menu_lang'		=> json_decode($row2->menu_lang,true),
									'menu_icons'	=> $row2->menu_icons,
									'childs'		=> array()
								);	
												
							$menus3 = self::nestedMenu($row2->menu_id , $position , $active);
							if(count($menus3) > 0 )
							{
								$child_level_3 = array();
								foreach ($menus3 as $row3) 
								{
									$p = json_decode($row3->access_data,true);
									if($row3->allow_guest == 1)
									{
										$is_allow = 1;
									} else {
										$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
									}										
									if($is_allow ==1)  
									{								
										$menu3 = array(
												'menu_id'		=> $row3->menu_id,
												'module'		=> $row3->module,
												'menu_type'		=> $row3->menu_type,
												'url'			=> $row3->url,												
												'menu_name'		=> $row3->menu_name,
												'menu_lang'		=> json_decode($row3->menu_lang,true),
												'menu_icons'	=> $row3->menu_icons,
												'childs'		=> array()
											);	
										$child_level_3[] = $menu3;	
									}					
								}
								$menu2['childs'] = $child_level_3;
							}
							$level2[] = $menu2 ;
						}	
					
					}
					$child_level = $level2;
						
				}
				
				$level = array(
						'menu_id'		=> $row->menu_id,
						'module'		=> $row->module,
						'menu_type'		=> $row->menu_type,
						'url'			=> $row->url,						
						'menu_name'		=> $row->menu_name,
						'menu_lang'		=> json_decode($row->menu_lang,true),
						'menu_icons'	=> $row->menu_icons,
						'childs'		=> $child_level
					);			
				
				$data[] = $level;	
			}	
				
		}	
		return $data;
	}
	
	public static function nestedMenu($parent=0,$position ='top',$active = '1')
	{
		$group_sql = " AND tb_menu_access.group_id ='".Session::get('gid')."' ";
		$active 	=  ($active =='all' ? "" : "AND active ='1' ");
		$Q = DB::select("
		SELECT 
			tb_menu.*
		FROM tb_menu WHERE parent_id ='". $parent ."' ".$active." AND position ='{$position}'
		 ORDER BY ordering			
		");					
		return $Q;					
	}

	public static function records( $request , $note )
	{
		$data = array(
			'module'	=> $request->segment(1),
			'task'		=> $request->segment(2),
			'user_id'	=> \Session::get('uid'),
			'ipaddress'	=> $request->getClientIp(),
			'note'		=> $note
		);		
		\DB::table( 'tb_logs')->insert($data);	
	}

	public static function validation() {

		$data = [ 
			array("id"=>"required" , "text" =>"required") ,
			array("id"=>"email" , "text" =>"email") ,
			array("id"=>"alpha" , "text" =>"alpha") ,
			array("id"=>"num" , "text" =>"num") ,
			array("id"=>"alphanum" , "text" =>"alphanum") 
		];
		header('Content-Type: application/json');
		return json_encode($data);
	}

	public static function formbuilder( $config )
	{
		
		$form = [] ;
		foreach($config as $key=>$par)
		{
			$par = array_merge(['field' => $key] , $par) ;
			$form[$key] = [ 'title'=> $par['title'] , 'form' => self::__input( $par['type'] , '' , $par)];
		}
		return $form ;
		echo '<pre>'; print_r($form); echo '</pre>';exit;
	}
	
	static public function get_time_ago( $time )
	{
	    $time_difference = time() - $time;

	    if( $time_difference < 1 ) { return 'few second ago'; }
	    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'min',
	                1                       =>  'sec'
	    );

	    foreach( $condition as $secs => $str )
	    {
	        $d = $time_difference / $secs;

	        if( $d >= 1 )
	        {
	            $t = round( $d );
	            return ' ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
	        }
	    }
	}	
	static public function live_editor_cms(  ) {


	}

	static public function onlineUsers() {
		$sql = \DB::select(" 
					SELECT 
						id , first_name , last_name , last_activity 
					FROM tb_users
					WHERE last_activity > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 14400 MINUTE))
					
					ORDER BY last_activity DESC LIMIT 20
		 		");

		return $sql;
	}

  static function storeNote( $args )
  {
      $args =  array_merge( array(
        'url'       => '' ,
        'userid'    => '0' ,
        'title'     => '' ,
        'note'      => '' ,
        'created'   => date("Y-m-d H:i:s") ,
        'icon'      => 'fa fa-envelope',
        'is_read'   => 0   
        ), $args ); 


        \DB::table('tb_notification')->insert($args);   
  }		
  static public function is_module_installed( $name ) 
  {
  	$res = \DB::table('tb_module')->where('module_name',$name)->get();
  	if(count($res)){
  		return true;
  	} 
  	else {
  		return false;
  	}
  }

	static public function load_module_plugins( $name ) 
	{
		$helper = ucwords($name).'Helper';
		if(file_exists( app_path() .'/Library/'.$helper.'.php') && !class_exists($helper))
		{
			include( app_path() .'/Library/'.$helper.'.php');		
		}
	}
	static public function autoload_library( ) 
	{
		$path = app_path() .'/Library/';
		$library = scandir($path);
		foreach($library as $filename) {
			if($filename === '.' || $filename === '..' ) {continue;} 
			$class = str_replace(".php",'',$filename);
			if( !class_exists($class))
		    {
		    	echo $class.' is not loaded <br />';
		    	//include( $path .$filename);		    	
		    }	
			
		}
	}

  public static function  render( $id ){
    $rest = \DB::table('tb_module')->where('module_name',$id)->get();
    if(count($rest))
    {
      	return  \App::call('App\\Http\\Controllers\\'.ucwords($id).'Controller@display');
     	
      
    } else {

      return '<pre>Class & Function not found!</pre>';

    }
  }	


	public static function  widgets( $id= null )
	{
		$group_id = session('gid');
		$rest = \DB::select("
					SELECT * FROM tb_widgets WHERE FIND_IN_SET($group_id ,access)  AND status ='active'
				");
		return $rest;
	}	  
}
