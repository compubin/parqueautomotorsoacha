
		 {!! Form::open(array('url'=>'secure/pages', 'class'=>'form-vertical CrudEngineForm ','files' => true , 'id' =>$actionId.'-action' )) !!}			

	  <div class="form-group  " >
		<label for="ipt" > Title </label>
		
		  {!! Form::text('title', $row['title'],array('class'=>'form-control input-sm', 'placeholder'=>'', 'required'=>'true'  )) !!} 
		
	  </div> 	

					 
			{!! Form::hidden('alias', $row['alias'],array('class'=>'form-control input-sm', 'placeholder'=>'', 'style'=>'width:150px; display:inline-block;'   )) !!} 


	<div class="form-group  " >
			
			<div class="" style="background:#fff;">
			
			  <textarea name='note'  id='note' required="true"   class='form-control CrudEngineEditor'  
				 >{{ $row['note'] }}</textarea> 
			 </div> 
		  						  

	  </div>
	
<div class="form-group  " >			
	<div class="">
		<button type="submit" class="btn btn-success  btn-sm actionButton" 
		data-after-task="return"> Submit Change(s) </button> 
  	</div>
</div>  	


	<input type="hidden" name="{{ $this_key }}" value="{{ $key_value }}" />
	<input type="hidden" name="task" value="{{ $task_value }}" />
	<input type="hidden" name="pagetype" value="page" />
	<input type="hidden" name="data-after-task" id="data-after-task" value="return" />

	<input type="hidden" name="status" value="{{ $row['status'] }}" />
	<input type="hidden" name="template" value="frontend" />
	<input type="hidden" name="allow_guest" value="{{ $row['allow_guest'] }}" />
	<input type="hidden" name="filename" value="{{ $row['filename'] }}" />

	

	<div class="clr clear"></div>
			 {!! Form::close() !!}

<div class="clr"></div>
<script src="{{ asset('sximo5/js/plugins/summernote/dist/plugin/sximo5-summernote.js')}}"></script>
<script type="text/javascript">
	$(function(){
	  
		$('.CrudEngineEditor').summernote({ 
			height: 350,
			minHeight: null,  
			maxHeight: null,
			focus: true,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'clear']],
				['fontname', ['fontname']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['table', ['table']],
				['insert', ['media', 'link', 'hr', 'picture', 'video']],
				['view', ['fullscreen', 'codeview']],
				 ['highlight', ['highlight']]
			]
		});

		var form = $('#{{ $actionId}}-action'); 
        form.parsley();

        form.submit(function()
        {         
          if (form.parsley().isValid())
          {      
            var options = { 
              dataType:      'json', 
              beforeSubmit : function() {
                $('.ajaxLoading').show(); 
              },
              success: function( data ) {
		          if(data.status == 'success')
		          {
		          	          
						window.location.href="{{ url( $row['alias']) }}";

		          } else {
		           
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
<style type="text/css">
	.note-editable  .section {
		border: dotted 1px #eee;
	}
	.modal-dialog {
		  width: 98%;
		  height: 92%;
		  padding: 0;
		}
	.modal-body { background: #fff; }	

.modal-content {
  height: 99%;
  border-radius: 0px;
  padding: 2px;
}
</style>
