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
				<h3> {{ $title }} </h3>
			</div>
			<div class="sbox-content clearfix">
		
<ul class="nav nav-tabs m-b" style="margin-bottom: 20px;">
  <li class="active"><a href="#info" data-toggle="tab">Site Info </a></li>
  <li ><a href="#login" data-toggle="tab"> Login & Security   </a></li>
  <li ><a href="{{ url('root/email')}}" > Email Template   </a></li>
</ul>

{!! Form::open(array('url'=>'root/save_config/', 'class'=>'form-horizontal ', 'files' => true)) !!}

<div class="tab-content">
	<div class="tab-pane active m-t " id="info">

	<div class="col-sm-6 animated fadeInRight ">
	  <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_appname') }} </label>
		<div class="col-md-8">
		<input name="cnf_appname" type="text" id="cnf_appname" class="form-control input-sm " required  value="{{ config('sximo.cnf_appname') }}" />  
		 </div> 
	  </div>  
	  
	  <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_appdesc') }} </label>
		<div class="col-md-8">
		<input name="cnf_appdesc" type="text" id="cnf_appdesc" class="form-control input-sm" value="{{ config('sximo.cnf_appdesc') }}" /> 
		 </div> 
	  </div>  
	  
	  <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_comname') }} </label>
		<div class="col-md-8">
		<input name="cnf_comname" type="text" id="cnf_comname" class="form-control input-sm" value="{{ config('sximo.cnf_comname')  }}" />  
		 </div> 
	  </div>      

	  <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_emailsys') }} </label>
		<div class="col-md-8">
		<input name="cnf_email" type="text" id="cnf_email" class="form-control input-sm" value="{{config('sximo.cnf_email') }}" /> 
		 </div> 
	  </div>   
	  <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.fr_multilanguage') }} <br />  </label>
		<div class="col-md-8">
			<div class="">
				<input name="cnf_multilang" type="checkbox" id="cnf_multilang" value="1" class="minimal-green" 
				@if(config('sximo.cnf_multilang') ==1) checked @endif
				  /> <label> {{ Lang::get('core.fr_enable') }} </label>
			</div>	
		 </div> 
	  </div> 
	     
	   <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_mainlanguage') }} </label>
		<div class="col-md-8">

				<select class="form-control input-sm" name="cnf_lang">

				@foreach(AppHelper::langOption() as $lang)
					<option value="{{  $lang['folder'] }}"
					@if(config('sximo.cnf_lang') ==$lang['folder']) selected @endif
					>{{  $lang['name'] }}</option>
				@endforeach
			</select>
		 </div> 
	  </div>   
	      

	   <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_fronttemplate') }}</label>
		<div class="col-md-8">
				
				<select class="form-control input-sm" name="cnf_theme" required="true">
				<option value=""> Select Frontend Template</option>

				@foreach(AppHelper::themeOption() as $t)
					<option value="{{  $t['folder'] }}"
					@if(config('sximo.cnf_theme') ==$t['folder']) selected @endif
					>{{  $t['name'] }}</option>
				@endforeach
			</select>
		 </div> 
	  </div> 


	   <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4"> Backend Template </label>
		<div class="col-md-8">
				
				<select class="form-control input-sm" name="cnf_backend" required="true">
				<option value="minimal"> Select Backend Template</option>
				@foreach(AppHelper::backendOption() as $t)
					<option value="{{  $t['folder'] }}"
					@if(config('sximo.cnf_backend') ==$t['folder']) selected @endif
					>{{  $t['name'] }}</option>
				@endforeach
			</select>
		 </div> 
	  </div> 


	  <div class="form-group hide">
	    <label for="ipt" class=" control-label col-md-4"> Development Mode ?   </label>
		<div class="col-md-8">
			<div class="checkbox">
				<input name="cnf_mode" type="checkbox" id="cnf_mode" value="1"
				@if (config('sximo.cnf_mode') =='production') checked @endif
				  />  Production
			</div>
			<small> If you need to debug mode , please unchecked this option </small>	
		 </div> 
	  </div> 		  
	  
	  <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
		<div class="col-md-8">
			<button class="btn btn-primary" type="submit">{{ Lang::get('core.sb_savechanges') }} </button>
		 </div> 
	  </div> 
	</div>

	<div class="col-sm-6 animated fadeInRight ">

	  
	  <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.fr_dateformat') }} </label>
		<div class="col-md-8">
			<select class="form-control input-sm" name="cnf_date">
			<?php $dates = array(
					'Y-m-d'=>' ( Y-m-d ) . Example : '.date('Y-m-d'),
					'Y/m/d'=>' ( Y/m/d ) . Example : '.date('Y/m/d'),
					'd-m-y'=>' ( D-M-Y ) . Example : '.date('d-m-y'),
					'd/m/y'=>' ( D/M/Y ) . Example : '.date('d/m/y'),
					'm-d-y'=>' ( m-d-Y ) . Example : '.date('m-d-Y'),
					'm/d/y'=>' ( m/d/Y ) . Example : '.date('m/d/Y'),
				  );
			foreach($dates as $key=>$val) {?>
				<option value="{{  $key }}"
				@if(config('sximo.cnf_date') ==$key) selected @endif
				>{{  $val }}</option>

			<?php } ?>
			</select>
		 </div> 
	  </div>  			

	  <div class="form-group">
	    <label for="ipt" class=" control-label col-md-4">Metakey </label>
		<div class="col-md-8">
			<textarea class="form-control input-sm" name="cnf_metakey">{{config('sximo.cnf_metakey') }}</textarea>
		 </div> 
	  </div> 

	   <div class="form-group">
	    <label  class=" control-label col-md-4">Meta Description</label>
		<div class="col-md-8">
			<textarea class="form-control input-sm"  name="cnf_metadesc">{{ config('sximo.cnf_metadesc') }}</textarea>
		 </div> 
	  </div>  

	   <div class="form-group">
	    <label  class=" control-label col-md-4">{{ Lang::get('core.fr_backendlogo') }}</label>
		<div class="col-md-8">
			<input type="file" name="logo">
			<p> <i>Please use image dimension 155px * 30px </i> </p>
			<div style="padding:5px;  width:auto;">
			 	@if(file_exists(public_path().'/uploads/images/'.config('sximo.cnf_logo')) && config('sximo.cnf_logo') !='')
			 	<img src="{{ asset('uploads/images/'.config('sximo.cnf_logo'))}}" alt="{{ config('sximo.cnf_appname') }}" />
			 	@else
				<img src="{{ asset('uploads/images/logo.png')}}" alt="{{ config('sximo.cnf_appname') }}" />
				@endif	
			</div>				
		 </div> 
	  </div>  		  

	</div>  

	</div>


	<div class="tab-pane  m-t" id="login">

			<div class="col-sm-6">
				

		 		  <div class="form-group">
					<label for="ipt" class=" control-label col-sm-4">  {{ Lang::get('core.fr_emailsys') }}  </label>	
					<div class="col-sm-8 ">
							
							<div class="">
								<input type="radio" name="cnf_mail" value="phpmail"   @if(config('sximo.cnf_mail') =='phpmail') checked @endif class="minimal-red"  /> 
								<label>PHP MAIL System</label>
							</div>
							
							<div class="">
								<input type="radio" name="cnf_mail" value="swift"   @if(config('sximo.cnf_mail') =='swift') checked @endif class="minimal-red"  /> 
								<label>SWIFT Mail ( Required Configuration )</label>
							</div>			
					</div>
				</div>					
		  
				  <div class="form-group">
					<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_registrationdefault') }}  </label>	
					<div class="col-sm-8">
							<div >
								
								<select class="form-control" name="cnf_group">
									@foreach($groups as $group)
									<option value="{{ $group->group_id }}"
									 @if(config('sximo.cnf_group') == $group->group_id ) selected @endif
									>{{ $group->name }}</option>
									@endforeach
								</select>
								
							</div>				
					</div>	
							
				  </div> 

				  <div class="form-group">
					<label for="ipt" class=" control-label col-sm-4">{{ Lang::get('core.fr_registration') }} </label>	
					<div class="col-sm-8 " >
						<div class=" radio-success">
							
							<div class="">
							<input type="radio" name="cnf_activation" value="auto" @if(config('sximo.cnf_activation') =='auto') checked @endif  class="minimal-red"  /> 
							<label>{{ Lang::get('core.fr_registrationauto') }}</label>
							</div>
							
							<div class=" ">
								<input type="radio" name="cnf_activation" value="manual" @if(config('sximo.cnf_activation') =='manual') checked @endif   class="minimal-red" /> 
								<label>{{ Lang::get('core.fr_registrationmanual') }}</label>
							</div>								
							<div class=" ">
								<input type="radio" name="cnf_activation" value="confirmation" @if(config('sximo.cnf_activation') =='confirmation') checked @endif  class="minimal-red"  />
								<label>{{ Lang::get('core.fr_registrationemail') }}</label>
							</div>
						</div>						
									
					</div>	
							
				  </div> 
				  
		 		  <div class="form-group">
					<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_allowregistration') }} </label>	
					<div class="col-sm-8">
						<div class="">
							<input type="checkbox" name="cnf_regist" value="true"  @if(config('sximo.cnf_regist') =='true') checked @endif class="minimal-red"  /> 
							<label>{{ Lang::get('core.fr_enable') }}</label>
						</div>			
					</div>
				</div>	
				
		 		<div class="form-group">
					<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_allowfrontend') }} </label>	
					<div class="col-sm-8">
						<div class="">
							<input type="checkbox" name="cnf_front" value="false" @if(config('sximo.cnf_front') =='true') checked @endif class="minimal-red"  /> 
							<label>{{ Lang::get('core.fr_enable') }}</label>
						</div>			
					</div>
				</div>			
				
		 		<div class="form-group">
					<label for="ipt" class=" control-label col-sm-4">Google reCaptcha </label>	
					<div class="col-sm-8">
						<div class="">
						
							<input type="checkbox" name="cnf_recaptcha" value="false" @if(config('sximo.cnf_recaptcha') =='true') checked @endif class="minimal-red"  />  {{ Lang::get('core.fr_enable') }}
							<br /><br />

							<label> Site key</label>
							<input type="text" name="cnf_recaptchapublickey" value="{{ config('sximo.cnf_recaptchapublickey') }}" class="input-sm form-control"  /> 
							<label> Secret key</label>
							<input type="text" name="cnf_recaptchaprivatekey" value="{{ config('sximo.cnf_recaptchaprivatekey') }}" class="input-sm form-control"  /> 
							
						</div>	
												
					</div>
				</div>	

		 		<div class="form-group">
					<label for="ipt" class=" control-label col-sm-4"> Google Maps API Key </label>	
					<div class="col-sm-8">
						<div class="">
							<input type="text" name="cnf_maps" value="{{ config('sximo.cnf_maps') }}" class="input-sm form-control"  /> 
							<small><i>* This is required if you use google Maps form .</i></small>
						</div>	
												
					</div>
				</div>		
				

			  	<div class="form-group">
					<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
					<div class="col-md-8">
						<button class="btn btn-primary" type="submit"> {{ Lang::get('core.sb_savechanges') }}</button>
				 	</div>
			  	</div>	  
			
		 	</div>

			<div class="col-sm-6">	
				<div class="form-vertical">
					<div class="form-group">
						<label> {{ Lang::get('core.fr_restrictip') }} </label>	
						
						<p><small><i>
							
							{{ Lang::get('core.fr_restrictipsmall') }}  <br />
							{{ Lang::get('core.fr_restrictipexam') }} : <code> 192.116.134 , 194.111.606.21 </code>
						</i></small></p>
						<textarea rows="5" class="form-control" name="cnf_restrictip">{{ config('sximo.cnf_restrictip') }}</textarea>
					</div>
					
					<div class="form-group">
						<label> {{ Lang::get('core.fr_allowip') }} </label>	
						<p><small><i>
							
							{{ Lang::get('core.fr_allowipsmall') }}  <br />
							{{ Lang::get('core.fr_allowipexam') }} : <code> 192.116.134 , 194.111.606.21 </code>
						</i></small></p>							
						<textarea rows="5" class="form-control" name="cnf_allowip">{{ config('sximo.cnf_allowip') }}</textarea>
					</div>

					<p> {{ Lang::get('core.fr_ipnote') }} </p>
				</div>
			</div>

	</div>

</div>


{!! Form::close() !!}	
			</div>	
		</div>
	</div>		
</div>
               

@stop