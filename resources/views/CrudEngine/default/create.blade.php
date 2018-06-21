<div class="sximo_tools">
	<a href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Save & New </a>
	<a href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Save & Edit </a>
	<a href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save & Return </a>
	<a href="javascript:void(0)" class="btn btn-primary btn-sm " onclick="ajaxClose('#{{ $actionId}}')" ><i class="fa fa-arrow-left"></i> Return </a>
</div>	

 {!! Form::open(array('url'=> $url, 'class'=>'form-horizontal','files' => true , 'id' =>'sClassForm' , 'parsley-validate'=>'','novalidate'=>' ')) !!}

@foreach($forms as $key=>$val)

	@if($key == $tablekey)
		<input type="hidden" name="{{ $key }}" value="" />
	@else
	<div class="form-group row " >
		<label for="Name" class=" control-label col-md-4 "> {{ $val['title'] }}</label>
		<div class="col-md-8">
			@if(array_key_exists($key, $forms))
				{!! $val[ 'form'] !!}
			@endif
		</div> 
	</div>
	@endif

@endforeach	
<div class="form-group row " >
	<label for="Name" class=" control-label col-md-4 "></label>
	<div class="col-md-8">
		<button class="btn btn-sm btn-primary" type="submit" name="submit_form"> Save & Return </button>
	</div> 
</div>
<input type="hidden" name="task" value="insert" />
{!! Form::close() !!}

<script type="text/javascript">

	$(function(){
		var form = $('#sClassForm'); 
        form.parsley();

        form.submit(function()
        {         
          if (form.parsley().isValid())
          {      
            var options = { 
              dataType:      'json', 
              beforeSubmit : function() {
               // $('.ajaxLoading').show(); 
              },
              success: function( data ) {
		          if(data.status == 'success')
		          {
		            notyMessage(data.message);
		          //  $('.ajaxLoading').hide();$('#sximo-modal').modal('hide'); 
		          } else {
		            notyMessageError(data.message);
		            //$('.ajaxLoading').hide();return false;
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
