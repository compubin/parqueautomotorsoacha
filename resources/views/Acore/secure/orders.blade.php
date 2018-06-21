@extends('layouts.app')

@section('content')
<div class="page-content row"> 
	<div class="page-content-wrapper m-t">
		<div class="sbox"  >
			<div class="sbox-title" >   
				<h3> {!! $title !!} </h3>
			</div>
			<div class="sbox-content">
				{!! $table !!}	
			</div>	
		</div>
	</div>		
</div>
  
@endsection