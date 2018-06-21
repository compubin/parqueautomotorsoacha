
 @extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> {{ $title }} </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li  class="active"> Configuration  </li>
  </ol>
</section>
<div class="page-content row">
  <div class="page-content-wrapper no-margin">
		<div class="sbox"  >
			<div class="sbox-title" >   
				<h3> {{ $title }}</h3>
			</div>
			<div class="sbox-content">
				
			<ul class="nav nav-tabs m-b" style="margin-bottom: 20px;">
			  <li ><a href="{{ url('root/config#info')}}" >Site Info </a></li>
			  <li ><a href="{{ url('root/config#login')}}" > Login & Security   </a></li>
			  <li class="active" ><a href="{{ url('root/email')}}" > Email Template   </a></li>
			</ul>

			 {!! Form::open(array('url'=>'root/save_email', 'class'=>'form-vertical row')) !!}

<div class="tab-content">
	<div class="tab-pane active m-t " id="info">

			<div class="col-sm-6 animated fadeInRight">
			<fieldset>
				<legend> {{ Lang::get('core.registernew') }} </legend>
				<div class="form-group">
					<label for="ipt" class=" control-label"> {{ Lang::get('core.tab_email') }} </label>		
					<textarea rows="20" name="regEmail" class="form-control input-sm  markItUp">{{ $regEmail }}</textarea>	
				</div>  
						

				<div class="form-group">   
					<button class="btn btn-primary" type="submit"> {{ Lang::get('core.sb_savechanges') }}</button>	 
				</div>
			</fieldset>	
				
			</div> 


			<div class="col-sm-6 animated fadeInRight">
			<fieldset>
				<legend> {{ Lang::get('core.forgotpassword') }} </legend>
				
				<div class="form-group">
					<label for="ipt" class=" control-label ">{{ Lang::get('core.tab_email') }} </label>					
					<textarea rows="20" name="resetEmail" class="form-control input-sm markItUp">{{ $resetEmail }}</textarea>					 
				</div> 

				<div class="form-group">
					<button class="btn btn-primary" type="submit">{{ Lang::get('core.sb_savechanges') }}</button>
				</div>
			</fieldset>	 
				 
			</div>
			<div class="clr"></div>	  
		</div>
	</div>
		
			   {!! Form::close() !!}
			</div>	
		</div>
	</div>		
</div>


@stop





