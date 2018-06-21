@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> {{ $title }} </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('root')}}"> Core  </a></li>
    <li  class="active"> {{ $title }} </li>
  </ol>
</section>
<div class="page-content row">
  <div class="page-content-wrapper no-margin">
    <div class="sbox"  >
      <div class="sbox-title" >   
        <h3> All Media </h3>
      </div>
      <div class="sbox-content" style="padding: 0;">
          
          <div id="elfinder" style="min-height: 600px;"></div>  
        
      </div>  
    </div>
  </div>    
</div>


<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo5/css/jquery-ui.css') }}" />
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/elfinder/js/elfinder.min.js') }}"></script>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo5/js/plugins/elfinder/css/elfinder.min.css')}}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo5/js/plugins/elfinder/css/theme.css')}}" />




<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        var elf = $('#elfinder').elfinder({
            url : '{{ url("root/folder/") }}'  ,// connector URL (REQUIRED)
			height:500, 
        }).elfinder('instance');            
    });
</script>
@stop