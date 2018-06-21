@extends('layouts.themes.sximo5.login')

@section('content')

		<div class="text-center">
	    @if(file_exists(public_path().'/uploads/images/'.config('sximo.cnf_logo') ) && config('sximo.cnf_logo') !='')
	        <img src="{{ asset('uploads/images/'.config('sximo.cnf_logo')) }}" alt="{{ config('sximo.cnf_appname') }}"  />
	    @else
	    <h3 class="text-center"> {{ config('sximo.cnf_appname') }} </h3>
	    @endif
	    </div>
	<p class="text-center"> {{ config('sximo.cnf_appdesc') }}  </p> 
	<hr />
				
	
 {!! Form::open(array('url'=>'user/create', 'class'=>'form-signup','parsley-validate'=>'','novalidate'=>' ','id'=>'register-form' )) !!}
	    	@if(Session::has('message'))
				{!! Session::get('message') !!}
			@endif
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>

	<div class="form-group has-feedback">
	  {!! Form::text('username', null, array('class'=>'form-control input-sm','required'=>'true','placeholder'=> __('core.username').' ID')) !!}
		
	</div>	
	<div class="form-group has-feedback row">
		<div class="col-md-6">
		  {!! Form::text('firstname', null, array('class'=>'form-control input-sm','required'=>'true' ,'placeholder'=> __('core.firstname') )) !!}
		</div>
		<div class="col-md-6">
		 {!! Form::text('lastname', null, array('class'=>'form-control input-sm', 'required'=>'' ,'placeholder'=> __('core.lastname')  )) !!}
			
		</div>	
	</div>
	<div class="form-group has-feedback">
	 {!! Form::text('email', null, array('class'=>'form-control input-sm', 'required'=>'true'  ,'placeholder'=> __('core.email'))) !!}
	</div>

	<div class="form-group has-feedback row">
		<div class="col-md-6">
	 		{!! Form::password('password', array('class'=>'form-control input-sm','required'=>'true'  ,'placeholder'=> __('core.password'))) !!}
			
		</div>
		<div class="col-md-6">
			{!! Form::password('password_confirmation', array('class'=>'form-control input-sm','required'=>'true'  ,'placeholder'=> __('core.repassword'))) !!}
			
		</div>	
	</div>

		@if(config('sximo.cnf_recaptcha') =='true') 
		<div class="form-group has-feedback  animated fadeInLeft delayp1">
			<label class="text-left"> Are u human ? </label>	
			<div class="g-recaptcha" data-sitekey="6Le2bjQUAAAAABascn2t0WsRjZbmL6EnxFJUU1H_"></div>
			
			<div class="clr"></div>
		</div>	
	 	@endif						

      <div class="row form-actions">
        <div class="col-sm-12">
          <button type="submit" style="width:100%;" class="btn btn-primary pull-right"><i class="icon-user-plus"></i> @lang('core.signup')	</button>
       </div>
      </div>
	  <p style="padding:10px 0" class="text-center">
	  <a href="{{ URL::to('user/login')}}"> @lang('core.signin')   </a> | <a href="{{ URL::to('')}}"> @lang('core.backtosite')   </a> 
   		</p>
 {!! Form::close() !!}

<script type="text/javascript">
	$(document).ready(function(){
		$('#register-form').parsley();
	})
</script>		
@stop
