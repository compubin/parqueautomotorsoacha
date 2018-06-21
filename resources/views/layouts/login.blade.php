<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>{{ config('sximo.cnf_appname')  }}</title>
<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">
<!-- Bootstrap Core CSS -->
<link href="{{ asset('assets/template')}}/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="{{ asset('assets/template')}}/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="{{ asset('assets/template')}}/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="{{ asset('assets/template')}}/css/colors/blue.css" id="theme"  rel="stylesheet">

<!-- jQuery -->
<script src="{{ asset('assets')}}/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
  <div class="login-box login-sidebar">
    <div class="white-box">
    	@yield('content')	
    </div>
  </div>
</section>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('')}}assets/template/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ asset('assets')}}/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bower_components/parsley.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('')}}assets/template/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('')}}assets/template/js/custom.js"></script>
    <!-- Sidebar menu plugin JavaScript -->
    <script src="{{ asset('')}}assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--Slimscroll JavaScript For custom scroll-->
    <script src="{{ asset('')}}assets/template/js/jquery.slimscroll.js"></script>
</body>
</html>
