 {!! Form::open(array('url'=>'page/submit', 'class'=>'','files' => true , 'parsley-validate'=>'','novalidate'=>' ' ,'id'=>'formField')) !!}
 	@if(Session::has('status') && session('status') =='success')
 		@if(session('status') =='success')
	 		<p class="alert alert-success text-center">
	 		{{ session('message') }}
	 		</p> 		
 		@else
	 		<p class="alert alert-error text-center">
	 		{{ session('message') }}
	 		</p>
	 	@endif	
 	@endif

	<div class="form-horizontal">
	@foreach($preview as $form)
		<div class="form-group ">
			<label class="text-right col-md-3"> {{ $form['title']}} </label>			
	       	<div class="col-md-9">
	       		{!! $form['form'] !!} 
	       	</div>       
		</div>
	@endforeach	
		<div class="form-group ">	
			<label class="text-right col-md-3">  </label>	
			<div class="col-md-9">			
	       		<button class="btn btn-primary"> Submit Form </button>      
	       	</div>
		</div>
	</div>
	<input type="hidden" name="form_builder_id" value="{{ $form_builder_id }}">
{!! Form::close() !!}