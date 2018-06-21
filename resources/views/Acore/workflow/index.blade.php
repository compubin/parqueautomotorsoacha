@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> Workflow <small> Process Automation </small> </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li  class="active"> Workflow   </li>
  </ol>
</section>
<div class="page-content row">
  <div class="page-content-wrapper no-margin">
		<div class="sbox "  >
			<div class="sbox-title">
				<h3> My Assigned Jobs / Todo </h3>
			</div>
			<div class="sbox-content">
				{!! $table !!}
			</div>	
		</div>
	</div>		
</div>
  
@endsection