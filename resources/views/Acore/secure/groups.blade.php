@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> {{ $title }} </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('secure')}}"> CMS </a></li>
    <li  class="active"> {{ $title }} </li>
  </ol>
</section>
<div class="page-content row">
	<div class="page-content-wrapper no-margin">
		<div class="sbox"  >
			<div class="sbox-title" >   
				<h3> All Records </h3>
			</div>
			<div class="sbox-content">
				<ul class="nav nav-tabs " style="margin-bottom:10px;">
					<li ><a href="{{ url('secure/users')}}"><i class="fa fa-user-plus"></i> Users  </a></li>
					<li class="active"><a href="{{ url('secure/groups')}}"><i class="fa fa-user"></i> Groups </a></li>
					<li ><a href="{{ url('secure/blast')}}"><i class="fa fa-envelope"></i> Blast Email </a></li>
				</ul>
			
				{!! $table !!}	
			</div>	
		</div>
	</div>		
</div>
  
@endsection