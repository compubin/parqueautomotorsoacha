<div class="sidebar-right">
    <div class="header">
        <ul class="mysetting clearfix">
            <li class="active"><a data-toggle="tab" href="#message" aria-expanded="true">
                Message
            </a></li>
            <li class=""><a data-toggle="tab" href="#jobs" aria-expanded="false">
                To Do
            </a></li>
            <li class=""><a data-toggle="tab" href="#setting" aria-expanded="false">
                <i class="fa fa-gear"></i>
            </a></li>
        </ul>
    </div>  
    <div class="tab-content">
        <div class="tab-pane active" id="message">
            <div class="title">
              <small> Friend , Community and Social</small>
            </div>

            <div class="inner">
            @if(AppHelper::is_module_installed('chat'))
                <h3> Last Seen Uses  <a href="{{ url('chat')}}" class="pull-right btn btn-default btn-xs"><i class="fa fa-comments"></i> Chats </a> </h3>
                <ul>
                @foreach(AppHelper::onlineUsers() as $user)
                <li class="clearfix">
                  <a href="">{!! SiteHelpers::avatar('20',$user->id) !!} {{ $user->last_name }} 
                    <span>{{ AppHelper::get_time_ago($user->last_activity)}}</span>
                  </a>
                </li>
                @endforeach
                </ul>

            @else
               <p class="text-center">Please Install Module Plugin <br /> <b class="label label-primary"> Chats </b></p>           
            @endif                
            </div>
        </div>  
        <div class="tab-pane " id="jobs">
            <div class="title">
              <small>  Assigned Todo Tasks </small>
            </div>
            <div class="inner">
            <ul>
            @if(AppHelper::is_module_installed('basecamp'))
               <?php AppHelper::load_module_plugins('basecamp');?>

                    @foreach(BasecampHelper::widget() as $todo)
                    <li class="clearfix">                   
                        <a href="{!! url('basecamp/todo?id='.$todo->set_id.'&todo_id='.$todo->todo_id) !!}">  <i class="fa fa-check-square"></i> {{ $todo->subject }}
                        <span>{{ AppHelper::get_time_ago(strtotime($todo->Created))}}</span>
                        </a>
                    </li>
                    @endforeach  
            @else
                <p class="text-center">Please Install Module Plugin <br /> <b class="label label-primary"> Basecamp </b></p>         
            @endif  
            </ul>  
            </div> 
        </div>
        <div class="tab-pane " id="setting">
            <div class="title">
                <h3> Settings </h3>
              <small> My Personal Setting </small>

            </div> 
            <div class="inner">
                <ul class="switch-theme">
   
                    <li><a href="javascript://ajax" data-theme="light-theme.css"><b class="box-theme-color light"></b> Light Theme </a></li>                
                    <li><a href="javascript://ajax" data-theme="blue-theme.css"><b class="box-theme-color blue"></b> Blue Theme </a></li>                
                    <li><a href="javascript://ajax" data-theme="violet-theme.css"><b class="box-theme-color violet"></b> Violet Theme </a></li> 
                    <li><a href="javascript://ajax" data-theme="black-theme.css"><b class="box-theme-color black"></b> Black Theme </a></li>               
                                                                
                </ul>
            </div>    
        </div>  
    </div>    
</div>