
	
	{!! Form::open(array('url'=>'builder/duplicate/'.$row->module_id, 'class'=>'form-horizontal ','id'=>'fClone')) !!}
		<input  type='text' name='module_id' id='module_id'  value='{{ $row->module_id }}'  style="display:none; " />
		<div class="form-group">
			<label for="ipt" class=" control-label col-md-4">Name / Title </label>
			<div class="col-md-8">	
			 Old Title :<b> {{	 $row->module_title }} </b><br />
			<input  type='text' name='module_title' id='module_title' class="form-control " placeholder="new title" required value='' required="true"  /> 
		 	</div> 
		</div>  

		

		<div class="form-group">
		<label for="ipt" class=" control-label col-md-4">Module Note</label>
		<div class="col-md-8">
		Old Note : <b> {{ $row->module_note }}</b><br />
			<input  type='text' name='module_note' id='module_note'  value='' placeholder="new note" class="form-control " required="true"  />
		 </div> 
		</div>    	

		<div class="form-group">
		<label for="ipt" class=" control-label col-md-4">Class Controller </label>
		<div class="col-md-8">
		Old Controller : <b> {{ $row->module_name }}</b><br />
		<input  type='text' name='module_name' id='module_name'  class="form-control " placeholder="new controller" required value=''  required="true"  />
		 </div> 
		</div>  

		<div class="form-group">
			<label for="ipt" class=" control-label col-md-4"></label>
			<div class="col-md-8">

				<button type="submit" name="submit" class="btn btn-primary"><i class="icon-copy4"></i> Submit </button>
			</div> 
		</div> 
	{!! Form::close() !!}
	<script type="text/javascript">
  $(document).ready(function(){

    var form = $('#fClone'); 
    form.parsley();
    form.submit(function(){         
      if(form.parsley().isValid()){      
        var options = { 
          dataType:      'json', 
          beforeSubmit : function() {
            $('.ajaxLoading').show(); 
          },
          success: function( data ) {
	          if(data.status == 'success')
	          {
	            notyMessage(data.message);$('.ajaxLoading').hide();$('#sximo-modal').modal('hide'); 
	            window.location.href ='{{ url("builder")}}';
	          } else {
	            notyMessageError(data.message);$('.ajaxLoading').hide();return false;
	          }
          }  
        }  
        $(this).ajaxSubmit(options); 
        return false;                 
      } else {
        return false;
      }   
    
    });
  })
</script> 
	