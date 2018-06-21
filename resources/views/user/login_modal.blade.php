<div style="padding: 0 40px">
		<div class="text-center">
	    @if(file_exists(public_path().'/uploads/images/'.config('sximo.cnf_logo') ) && config('sximo.cnf_logo') !='')
	        <img src="{{ asset('uploads/images/'.config('sximo.cnf_logo')) }}" alt="{{ config('sximo.cnf_appname') }}"  />
	    @else
	    <h3 class="text-center"> {{ config('sximo.cnf_appname') }} </h3>
	    @endif
	    </div>
	    <p class="text-center"> {{ config('sximo.cnf_appdesc') }}  </p> 
		<div class="ajaxLoading"></div>
		<p class="message alert alert-danger " style="display:none;"></p>	
 
	    	@if(Session::has('status'))
	    		@if(session('status') =='success')
	    			<p class="alert alert-success">
						{!! Session::get('message') !!}
					</p>
				@else
					<p class="alert alert-danger">
						{!! Session::get('message') !!}
					</p>
				@endif		
			@endif

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>		
		

	<div class="tab-content" >
		<div class="tab-pane active m-t" id="tab-sign-in">
 		{!! Form::open(array('url'=>'user/signin', 'class'=>'form-vertical','id'=>'LoginAjax' , 'parsley-validate'=>'','novalidate'=>' ')) !!}
			<div class="form-group has-feedback animated fadeInLeft delayp1">
				<input type="text" name="email" placeholder="{{ __('core.email') }}" class="form-control" required="email" />
			</div>
			
			<div class="form-group has-feedback  animated fadeInRight delayp1">
				<input type="password" name="password" placeholder="{{ __('core.password') }}" class="form-control" required="true" />
			</div>

			<div class="form-group has-feedback  animated fadeInRight delayp1">
				<label>@lang('core.remember') ?	</label>
				<input type="checkbox" name="remember" value="1" />
			</div>


			@if(config('sximo.cnf_recaptcha') =='true') 
			<div class="form-group has-feedback  animated fadeInLeft delayp1">
				<label class="text-left"> Are u human ? </label>	
				<div class="g-recaptcha" data-sitekey="6Le2bjQUAAAAABascn2t0WsRjZbmL6EnxFJUU1H_"></div>
				
				<div class="clr"></div>
			</div>	
		 	@endif	

		 	




			<div class="form-group  has-feedback text-center  animated fadeInLeft delayp1" style=" margin-bottom:20px;" >
				 	 
					<button type="submit" class="btn btn-primary btn-sm btn-block" ><i class="fa fa-sign-in"></i> {{ __('core.signin') }}</button>
				       
					<p class="text-center">
					<br />
						<a href="javascript:void(0)" class="forgot"> @lang('core.forgotpassword') ? </a> 
					</p>
				
			 	<div class="clr"></div>
				
			</div>	
			<div class="animated fadeInUp delayp1">
		<div class="form-group has-feedback text-center">
			@if($socialize['google']['client_id'] !='' || $socialize['twitter']['client_id'] !='' || $socialize['facebook'] ['client_id'] !='') 
			<br />
			<p class="text-muted text-center"><b> {{ __('core.loginsocial') }} </b>	  </p>
			
			<div style="padding:15px 0;">
				@if($socialize['facebook']['client_id'] !='') 
				<a href="{{ url('user/socialize/facebook')}}" class="btn btn-success"><i class="icon-facebook"></i> Facebook </a>
				@endif
				@if($socialize['google']['client_id'] !='') 
				<a href="{{ url('user/socialize/google')}}" class="btn btn-danger"><i class="icon-google"></i> Google </a>
				@endif
				@if($socialize['twitter']['client_id'] !='') 
				<a href="{{ url('user/socialize/twitter')}}" class="btn btn-info"><i class="icon-twitter"></i> Twitter </a>
				@endif
			</div>
			@endif
		</div>			
		   	</div>	
		   </form>			
		</div>
	
	

	<div class="tab-pane  m-t" id="tab-forgot" style="display: none">	

		
		{!! Form::open(array('url'=>'user/request', 'class'=>'form-vertical', 'parsley-validate'=>'','novalidate'=>' ')) !!}
		   <div class="form-group has-feedback">
		   <div class="">
				<label>{{ __('core.enteremailforgot') }}</label>
				<input type="text" name="credit_email" placeholder="{{ __('core.email') }}" class="form-control" required/>
			</div> 	
			</div>
			<div class="form-group has-feedback">    
				<a href="javascript:;" class="forgot btn btn-warning"> Cancel </a>     
		      <button type="submit" class="btn btn-default pull-right"> {{ __('core.sb_submit') }} </button>        
		  </div>
		  
		  <div class="clr"></div>

		  
		</form>

	
	</div>


	</div>  
</div>


<script type="text/javascript">
	$(document).ready(function(){

		$('.forgot').on('click',function(){
			$('#tab-forgot').toggle();
			$('#tab-sign-in').toggle();
		})
		var form = $('#LoginAjax'); 
		form.parsley();
		form.submit(function(){
			
			if(form.parsley().isValid()){			
				var options = { 
					dataType:      'json', 
					beforeSubmit :  showRequest,
					success:       showResponse  
				}  
				$(this).ajaxSubmit(options); 
				return false;
							
			} else {
				return false;
			}		
		
		});

	});

function showRequest()
{
	$('.ajaxLoading').show();		
}  
function showResponse(data)  {		
	
	if(data.status == 'success')
	{
		window.location.href = data.url;	
		$('.ajaxLoading').hide();
	} else {
		$('.message').html(data.message)	
		$('.ajaxLoading').hide();
		$('.message').show(data.message)	
		return false;
	}	
}	
</script>

