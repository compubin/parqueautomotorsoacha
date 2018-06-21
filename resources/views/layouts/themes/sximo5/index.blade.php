<?php

  $set_theme = session('set_theme');
  if($set_theme =='') {
    $set_theme = 'violet-theme.css';
  }

   
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Language" content="th">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title> {{ config('sximo.cnf_appname')}} </title>

<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">
<link href="{{ asset('sximo5/sximo5.min.css')}}" rel="stylesheet">
<link href="{{ asset('sximo5/js/plugins/iCheck/skins/square/green.css')}}" rel="stylesheet">
<link href="{{ asset('sximo5/js/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
<link href="{{ asset('sximo5/js/plugins/toast/css/jquery.toast.css')}}" rel="stylesheet">
<!-- Icon CSS -->   
<link href="{{ asset('sximo5/fonts/icomoon.css')}}" rel="stylesheet">
<link href="{{ asset('sximo5/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}" rel="stylesheet">
<link href="{{ asset('sximo5/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{ asset('sximo5/js/plugins/jquery.steps/jquery.steps.css') }}" rel="stylesheet">
<!-- Sximo 5 Main CSS -->
<link href="{{ asset('sximo5/css/sximo.css')}}" rel="stylesheet">
<link href="{{ asset('sximo5/'.$set_theme)}}" rel="stylesheet" id="switch-theme">
<link href="{{ asset('sximo5/app.css')}}" rel="stylesheet">


<script type="text/javascript" src="{{ asset('sximo5/sximo5.min.js') }}"></script>

 
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/datatable/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/datatable/media/js/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/datatable/sximo.datatables.js') }}"></script>
<script>var CrudEngineLibrary = '<?php echo asset("CrudEngine");?>';</script>
<script src="{{ asset('CrudEngine/CrudEngine.js') }}" ></script>


<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->         


</head>

<body class="sxim-init" >

  <div id="wrapper">
  
        @include('layouts.themes.sximo5.sidebar')
        <div class="gray-bg " id="page-wrapper">
          
            @include('layouts.themes.sximo5.header')

             @yield('content') 
            
        </div>
        @include('layouts.themes.sximo5.sidebar_right')
        
    </div>


    <div class="footer fixed">
        <div class="pull-right">
           
        </div>
        <div>
            <strong>Copyright</strong> &copy; 2014-<?php echo date('Y');?> .<b> {{ config('sximo.cnf_comname')}}</b> </div>
    </div>      

<div class="modal fade" id="sximo-modal" tabindex="-1" role="dialog">
<div class="modal-dialog  ">
  <div class="modal-content">
    <div class="modal-header bg-default">
        
        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
    </div>
    <div class="modal-body" id="sximo-modal-content">

    </div>

  </div>
</div>


</div>
<script type="text/javascript" src="{{ asset('sximo5/js/sximo.js') }}"></script>
{{ SiteHelpers::showNotification() }} 
<script type="text/javascript">
jQuery(document).ready(function ($) {
   scrollmenu()
   outlook()
  $('#sidemenu').sximMenu();
  $('.sidebar-toggle').on('click',function(){
    $('.sidebar-right').toggle();
  })  

  loadNotification();
  setInterval(function(){ 
   // loadNotification()
  }, 10000);  
}); 
;  
  
function loadNotification(){
    $.get('{{ url("loadNotif") }}',function(data){
    $('.notif-alert').html(data.count_msg + data.count_sys);
    $('.count_msg').html(data.count_msg);
    $('.count_sys').html(data.count_sys);
    var msg_text = '';
    $.each( data.content_msg, function( key, val ) {     
      msg_text += '<li><a href="'+val.url+'"><div class="message-center"><div class="user-img">'+val.image+'</div><div class="note-content"><span class="mail-desc">'+val.text+'</span> <br /><span class="time">'+val.date+'</span> </div></div><div class="clr"></div></a></li>' ;
    });
     $('#chat_msg').html(msg_text);
    var sys_text = '';
    $.each( data.content_sys, function( key, val ) {     
      sys_text += '<li><a href="'+val.url+'"><div class="message-center"><div class="user-img">'+val.image+'</div><div class="note-content"><span class="mail-desc">'+val.text+'</span> <br /> <span class="time">'+val.date+'</span> </div></div><div class="clr"></div></a></li>' ;
    });
      $('#system_msg').html(sys_text);
    }); 
    $('ul.switch-theme li a').on('click', function(event) {
        theme = $(this).data('theme') ;
        url_theme = '{!! asset("sximo5") !!}/'+ theme ;
         $('#switch-theme').attr('href',url_theme);
        
        $.get('{{ url("set_theme") }}/'+ theme ,function(){
          
        })       
    });      
}  
</script>

</body>
</html>
