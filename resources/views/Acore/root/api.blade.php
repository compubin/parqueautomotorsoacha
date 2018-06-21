@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> {{ $title }} </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('root')}}"> Core </a></li>
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
			<div class="infobox infobox-success fade in">
			  <button type="button" class="close" data-dismiss="alert"> x </button>  
			   <p><strong> Tips : </strong> You can use PostMan Tools for testing your API Modules .For more information on how to use REST API,  Visit <a href="http://sximo5.net/docs/ultimate-sximo-5?view=224" target="_blank"> REST API DOCS </a> </p>	
			</div>


				{!! $table !!}	
			</div>	
		</div>
	</div>		
</div>
  
@endsection