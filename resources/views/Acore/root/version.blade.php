@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> Sximo 5 Version  <label class="badge badge-primary"> {{ ucwords($version['Version']) }} </label> </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('root')}}"> Root </a></li>
    <li  class="active"> Version Check </li>
  </ol>
</section>
<div class="page-content row">
	<div class="page-content-wrapper no-margin">
		<div class="sbox  "  >
			<div class="sbox-title"> <h3> Current Version Info </h3></div>
			<div class="sbox-content">



				<div class="row">
					<div class="col-md-4">

          				<div class="form-horizontal ">
			
							<div class="form-group">
								<div class="col-md-4">
									CodeName
								</div>
								<div class="col-md-8">
									 {{ ucwords($version['Codename']) }}
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-4">
									Version
								</div>
								<div class="col-md-8">
									 {{ ucwords($version['Version']) }}
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									Build Date
								</div>
								<div class="col-md-8">
									 {{ $version['Build'] }}
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									
								</div>
								<div class="col-md-8">
									  <a href="javascript://ajax" class= "btn btn-primary btn-sm autoupdate "><i class="fa fa-recycle"></i> Check for updates  .</a> 
								</div>
							</div>																				
	
			    		</div>
			      
	

					</div>
					<div class="col-md-8">
		              	<div class="version-result " >
		              		<div class=" available"  style="display: none" >
		              			<div class="spanel">
		              				<div class="panel-title"><h4></h4></div>
		              				<div class="panel-body ">
		              				<div class="authen-update" >
			              				 {!! Form::open(array('url'=>'root/version', 'class'=>'form-horizontal well','files' => true , 'parsley-validate'=>'','novalidate'=>' ' ,'id'=>'doUpdate')) !!}

			              				<p> Please make sure you have an account at Sximo5.NET </p>
			                    		<div class="form-group">
			                    			<div class="col-md-3">
			                    				Email Address
			                    			</div>
			                    			<div class="col-md-9">
			                    				<input name="email" class="form-control input-sm" required="true" type="text" />
			                    			</div>
			                    		</div>
			                    		<div class="form-group">
			                    			<div class="col-md-3">
			                    				Password
			                    			</div>
			                    			<div class="col-md-9">
			                    				<input name="password" class="form-control input-sm"  required="true" type="password"  />
			                    			</div>
			                    		</div>		                    		
			                    		

			                    		<div class="form-group">
			                    			<div class="col-md-3">
			                    				
			                    			</div>
			                    			<div class="col-md-9">
			                    				<button class="btn btn-primary btn-sm"> Download Update(s) & Install Now </button>
			                    			</div>
			                    		</div>		
			                    		<input type="hidden" name="codename" id="" value="">		
			                    		<input type="hidden" name="version" value="2.0.1">
			                    		<input type="hidden" name="build" value="">
			                    		<input type="hidden" name="process" value="">
										 {!! Form::close() !!}	
										</div>
										<div class="progress-update">
											<p>Downloading New Update</p>
											<p>Update Downloaded And Saved</p>
											<p>Installing ..... Please dont navigate this page ... </p>
											<div class="well progress-result">

											</div>
										</div>

									</div>
								</div>	
							 </div>	
								<div class="failed-update" style="display: none; padding: 50px 0; text-align: center;" >
								<i class="fa fa-thumbs-o-up fa-5x"></i>
									<p> There's nothing to update(s) </p>
								</div>	


	              			
		              	</div> 
		            </div>
		        </div>    
				
			</div>	
		</div>
	</div>		
</div>

<script type="text/javascript">
$(function(){
	$('.autoupdate').on('click',function(){
		$.get('{{ url("root/version?check") }}',function( callback ) {
			if(callback.status =='success'){
				$('.available').show();
				$(' .available .panel-title h4').text(callback.message + ' To : ' + callback.version );
				 $('.authen-update').show();
				  $('.progress-update').hide();
			} else {
				  $('.failed-update').show()
			}
		})
	})	

	var form = $('#doUpdate'); 
    form.parsley();
    form.submit(function()
    {         
      if (form.parsley().isValid())
      {      
        var options = { 
          dataType:      'json', 
          beforeSubmit : function() {
          		 $('.failed-update').hide()
	         	 $('.authen-update').hide();
	         	 $('.progress-update').show();
	         	  $('.progress-result').html('');
          },
          success: function( data ) {
	          if(data.status == 'success')
	          {     
	         	 $('.progress-result').html(data.message);
	         	 $.get('{{ url("root/log") }}',function(){})
	          	
	          } else {
	          	$('.ajaxLoading').hide();
	            notyMessageError(data.message);
	          
	           
	          }
          }  
        }  
        $(this).ajaxSubmit(options); 
        return false;                 
	} 
	else {
		notyMessageError('Error ajax wile submiting !');
		return false;
	}      
	});	
})
</script> 

@endsection