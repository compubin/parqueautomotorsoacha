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
				<h3> All Records </h3>
			</div>
			<div class="sbox-content">
				{!! $table !!}	
			</div>	
		</div>
	</div>		
</div>
  
@endsection