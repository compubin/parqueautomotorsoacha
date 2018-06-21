<div class="row  ">
    <nav style="margin-bottom: 0;" role="navigation" class="navbar navbar-fixed-top ">
    <div class="navbar-header">
         <a href="javascript:void(0)" class="navbar-minimalize minimalize-btn  ">
            <i class="fa fa-bars"></i> 
         </a>        
    </div>
     <ul class="nav navbar-top-links navbar-right">
        @if(config('sximo.cnf_multilang') ==1)
        <li class="dropdown tasks-menu">
          <?php 
          $flag ='en';
          $langname = 'English'; 
          foreach(SiteHelpers::langOption() as $lang):
            if($lang['folder'] == session('lang') or $lang['folder'] == config('sximo.cnf_lang')) {
              $flag = $lang['folder'];
              $langname = $lang['name']; 
            }
            
          endforeach;?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <img class="flag-lang" src="{{ asset('sximo5/images/flags/'.$flag.'.png') }}" width="16" height="12" alt="lang" /> {{ strtoupper($flag) }}
            <span class="hidden-xs">
            
            </span>
          </a>

           <ul class="dropdown-menu dropdown-menu-right icons-right">
            @foreach(SiteHelpers::langOption() as $lang)
              <li><a href="{{ url('lang/'.$lang['folder'])}}"><img class="flag-lang" src="{{ asset('sximo5/images/flags/'. $lang['folder'].'.png')}}" width="16" height="11" alt="lang"  /> {{  $lang['name'] }}</a></li>
            @endforeach 
          </ul>

        </li> 
        @endif 

        <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning notif-alert">0</span>
            </a>
            <ul class="dropdown-menu notif_system ">
              <li class="header"> </li>
              <li>
                <ul class="menu" id="notification-menu">
                    
                </ul>  
               <li>

               <li class="dropdown-submenu child-menu">
                  <a tabindex="-1" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-comments"></i> Messages <span class="sup label label-green count_msg">0</span> </a>
                  <ul class="dropdown-menu " id="chat_msg">
                  
                  </ul>
                </li>
                <li class="dropdown-submenu child-menu">
                  <a tabindex="-1" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i> System <span class="sup label label-green count_sys">0</span> </a>
                  <ul class="dropdown-menu " id="system_msg">
                    
                  </ul>
                </li>  

              <li><a href="{{ url('notification')}}">View all</a></li>
            </ul>
          </li>    
          @if(Auth::user()->group_id == 1 or Auth::user()->group_id ==2 )
        <li class="dropdown user">
             <a href="#" class="dropdown-toggle tips" data-toggle="dropdown" title="@lang('core.m_controlpanel')">
                 <i class="fa fa-sliders"></i>  <span> Control Panel</span>
            </a>
            <ul class="dropdown-menu navbar-mega-menu animated " style="display: none;">
                 @if(Auth::user()->group_id == 1  )
                 
                <li class="col-sm-3">
                    <ul>
                        <li class="dropdown-header">  @lang('core.m_panel') </li>
                        <li class="divider"></li>
                         <li><a href="{{ url('root/config') }}#info"><i class="fa fa-sliders"></i> General Settings</a> </li>  
                         <li><a href="{{ url('root/config') }}#email"><i class="fa fa-lock"></i> Login &amp; Security</a> </li> 
                         <li><a href="{{ url('root/email') }}"><i class="fa fa-envelope"></i> Email Templates</a> </li>             
                        <li class="divider"></li>
                        <li ><a href="{{ url('secure/about')}}"> <i class="fa fa-info-circle"></i> About Sximo 5</a></li> 
                        <li ><a href="http://sximo5.net/docs/ultimate-sximo-5" target="_blank"> <i class="fa fa-question-circle"></i>Help </a></li>
                        

                    </ul>
                </li>
                @endif                         
                <li class="col-sm-3">
                    <ul>
                        <li class="dropdown-header">  @lang('core.m_admin') </li>
                        <li class="divider"></li>
                        <li ><a href="{{ url('secure')}}"> <i class="fa fa-dashboard"></i> Dashboard <br /></a> </li>    
                        <li ><a href="{{ url('secure/users')}}"> <i class="fa fa-user-circle-o"></i> @lang('core.m_users') <br /></a> </li> 
                        <li ><a href="{{ url('secure/groups')}}"> <i class="fa fa-user-plus"></i> @lang('core.m_groups') </a> </li>
                        <li><a href="{{ url('secure/blast')}}"> <i class="fa fa-envelope"></i>  @lang('core.m_blastemail') </a></li> 
                        <li><a href="{{ url('secure/pages')}}"> <i class="fa fa-text-width"></i>  @lang('core.m_pagecms')  </a></li>
                        <li ><a href="{{ url('secure/posts')}}"> <i class="fa fa-text-height"></i> Blog /  Post</a></li>

                    </ul>
                </li>
                
                @if(Auth::user()->group_id == 1  )
                <li class="col-sm-3">
                    <ul>
                        <li class="dropdown-header"> Superadmin </li> 
                        <li class="divider"></li>       
                        <li><a href="{{ url('builder')}}"><i class="fa fa-free-code-camp"></i> @lang('core.m_codebuilder')  </a> </li>
                        <li><a href="{{ url('root/api')}}"><i class="fa fa-random"></i> RestAPI Generator </a> </li> 
                        <li><a href="{{ url('root/database')}}"><i class="fa fa-database"></i> PHP MyAdmin Lite </a> </li>
                        <li><a href="{{ url('root/form')}}"><i class="fa fa-tasks"></i> Form Builder </a> </li>
                        <li><a href="{{ url('root/folder')}}"><i class="fa fa-cloud-upload"></i> Dropzone Media </a> </li>
                        <li><a href="{{ url('root/widgets')}}"><i class="fa fa-bars"></i> Widgets Management </a> </li> 
                                          
                    </ul>
                </li> 
                <li class="col-sm-3">
                    <ul>
                        <li class="dropdown-header"> Utility </li> 
                        <li class="divider"></li>
                          <li><a href="{{ url('root/menu')}}"><i class="fa fa-sitemap"></i>  @lang('core.m_menu')</a> </li>              
                          <li> <a href="{{ url('root/code')}}"><i class="fa fa-file-code-o"></i> @lang('core.m_sourceeditor') </a>  </li> 
                           <li><a href="{{ url('root/activity')}}"><i class="fa fa-archive"></i> @lang('core.m_logs')</a></li>
                          
                            <li> <a href="{{ url('root/version')}}" ><i class="fa fa-recycle"></i> Version & Update </a> </li>
                             <li> <a href="{{ url('root/log')}}" class="clearCache"><i class="fa fa-trash-o"></i> @lang('core.m_clearcache')</a> </li>
                           
                    </ul>
                </li>
                @endif    
                                         


            </ul>
        </li>   
        @endif          
        <li><a href="{{ url('user/logout')}}"><i class="fa fa-power-off "></i>  @lang('core.m_logout')</a></li>
         <li class="pull-right" >
          <a href="javascript://ajax" class="sidebar-toggle"><i class="fa fa-bars"></i></a>
         </li>  
                   
    </ul>   
    </nav>   
     
</div>  