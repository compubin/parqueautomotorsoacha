<div class="sximo_tools">
	<div class="row">
		<div class="col-md-6"></div>
		<div class="col-md-6 text-right">			
			<a href="javascript:void(0)" class="btn btn-primary btn-sm actionButton" data-after-task="insert">
				Save & New 
			</a>
			<a href="javascript:void(0)" class="btn btn-success btn-sm actionButton" data-after-task="update">
				Save & Edit 
			</a>
			<a href="javascript:void(0)" class="btn btn-info btn-sm actionButton" data-after-task="return">
				Save & Return 
			</a>

			<a href="javascript:void(0)" class="btn btn-danger btn-sm actionButton" onclick="CrudEngine_Close('#{{ $actionId}}')" >
				Close 
			</a>
		</div>
	</div>

</div>	
<hr />


{!! Form::open(array('url'=>'secure/posts', 'class'=>'form-vertical row CrudEngineForm' ,'files' => true , 'parsley-validate'=>'','novalidate'=>' ', 'id' =>$actionId.'-action')) !!}
<div class="col-md-9">

<ul class="nav nav-tabs m-b" >
  <li class="active"><a href="#info" data-toggle="tab"><i class="fa  fa-info-circle"></i> Page Content </a></li>
  <li ><a href="#meta" data-toggle="tab"><i class="fa fa-sitemap"></i> Meta & Description </a></li>
  <li ><a href="#image" data-toggle="tab"><i class="fa fa-picture-o"></i> Images </a></li>
</ul>	

<div class="tab-content">
  <div class="tab-pane active m-t" id="info">

	{!! Form::hidden('pageID', $row['pageID']) !!}		
	{!! Form::hidden('pagetype', 'post') !!}
	{!! Form::hidden('pageID', $row['pageID']) !!}			
			  <div class="form-group  " >
				<label > Post Title    </label>									
				  {!! Form::text('title', $row['title'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 						
			  </div> 					
			  <div class="form-group  " >
				<label for="ipt" class=" btn-success  btn btn-sm">  {!! url('post/read/')!!}  </label>							
					 
				  {!! Form::text('alias', $row['alias'],array('class'=>'form-control input-sm', 'placeholder'=>'', 'style'=>'width:150px; display:inline-block;'   )) !!} 						
					
			  </div> 					
			  <div class="form-group  " >
				<label > Post Content    </label>		
				<a onclick="SximoMedia()" class="btn btn-default btn-sm"><i class="fa fa-picture-o"></i> Insert Media </a>					
				  <textarea name='note' rows='25' id='note' class='form-control CrudEngineEditor'  
   >{{ $row['note'] }}</textarea> 						
			  </div> 					
			   					
	</div>
	<div class="tab-pane m-t" id="meta">		  					
			  <div class="form-group  " >
				<label > Metakey    </label>
				 <textarea name='metakey' rows='5' id='metakey' class='form-control '  
   >{{ $row['metakey'] }}</textarea> 						
			  </div> 					
			  <div class="form-group  " >
				<label > Metadesc    </label>									
				  <textarea name='metadesc' rows='5' id='metadesc' class='form-control '  
   >{{ $row['metadesc'] }}</textarea> 						
			  </div> 	
	</div>

	<div class="tab-pane m-t" id="image">
		<div class="form-group  " >
			<label > Images    </label>
			<input type="file" name="image"></input> 	
						
		  </div>


	</div>

</div>	
</div>

<div class="col-md-3">
		
<div class="form-group  " >
<label> Post Status :  </label>
<div class="">					
	<input  type='radio' name='status'  value="enable" required class="minimal-red" 
	@if( $row['status'] =='enable')  checked	  @endif/> 
	<label>Enable</label>
</div> 
<div class="">					
	<input  type='radio' name='status'  value="disable" required class="minimal-red" 
	@if( $row['status'] =='disable')  	checked	  @endif				  
	/> 
	<label>Disabled</label>
</div> 					 
</div>									
   					
	<div class="form-group  " >
		<label for="ipt" class=" control-label "> Created    </label>								  
		<div class="input-group m-b" style="width:150px !important;">
			{!! Form::text('created', $row['created'],array('class'=>'form-control input-sm CrudEngineDateTime', 'style'=>'width:150px !important;')) !!}
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		</div>				 						
	</div> 					

	<div class="form-group  " >
		<label for="ipt"> Who can view this page ? </label>
		{!! $forms['access']['form'] !!}	
	  
	</div>

   <div class="form-group  " >
	<label> Show for Guest ? unlogged  </label>
	<div class=""><input  type='checkbox' name='allow_guest'  class="minimal-red" 
			@if($row['allow_guest'] ==1 ) checked  @endif	
	   value="1"	/> <label>Allow Guest ?  </lable>
	   </div>
  </div>			



	<div class="form-group  " >
		<label > Labels    </label>									
		<textarea name='labels' rows='2' id='labels' class='form-control '>{{ $row['labels'] }}</textarea> 						
	</div>
</div>		

	<input type="hidden" name="pagetype" value="post" />
	<input type="hidden" name="{{ $this_key }}" value="{{ $key_value }}" />
	<input type="hidden" name="task" value="{{ $task_value }}" />
	<input type="hidden" name="data-after-task" id="data-after-task" value="" />

			 {!! Form::close() !!}

<script src="{{ asset('sximo5/js/plugins/summernote/dist/plugin/sximo5-summernote.js')}}"></script>
<script src="{{ asset('sximo5/js/plugins/summernote/dist/plugin/summernote-ext-template.js')}}"></script>
<script type="text/javascript">


	$(function(){

		$('.CrudEngineDate').datepicker({format:'yyyy-mm-dd',autoClose:true})
		$('.CrudEngineDateTime').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss',autoClose:true}); 
		$('.CrudEngineTime').timepicker()
		$('.CrudEngineYear').datepicker({minViewMode: 2,format: 'yyyy'});
		$('.CrudEngineEditor').summernote({ 
			height: 450,
			minHeight: null,  
			maxHeight: null,
			focus: true,
			toolbar: [
				['SximoMedia',['SximoMedia']],
				['template',['template']],
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'clear']],
				['fontname', ['fontname']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['table', ['table']],
				['insert', ['media', 'link', 'hr', 'picture', 'video']],
				['view', ['fullscreen', 'codeview']],
				['help', ['help']],

			],
			template: {
				path: '{{ asset("sximo5/js/plugins/summernote/tpls/")}}',
				list: {
		            'section'		: 'Section Div' ,
		      
		        }
			}
		});



		$('#{{ $actionId}}View .actionButton').click(function () {
			var task = $(this).attr('data-after-task');
			$('#data-after-task').val(task);
			$('#{{ $actionId}}-action').submit();
		})

		var form = $('#{{ $actionId}}-action'); 
        form.parsley();

        form.submit(function()
        {         
          if (form.parsley().isValid())
          {      
            var options = { 
              dataType:      'json', 
              beforeSubmit : function() {
                Pace.restart() 
              },
              success: function( data ) {
		          if(data.status == 'success')
		          {
		          	var table = $('#{{ $actionId}}Table').DataTable();
					table.ajax.reload();

		            notyMessage(data.message);
		            if(data.after =='update')
		            {
		            	$('input[name={{ $this_key}}]').val(data.id);	
		            } 
		            if(data.after =='insert') {
		            	form.trigger('reset');
		            }
		            if(data.after =='return') {
		            	CrudEngine_Close('#{{ $actionId}}')
		            }	            
		           

		          } else {
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
	function SximoMedia() {
		
		 $('<div id="browse_media" />').dialogelfinder({
	   		url: '{{ url("root/folder/") }}',
	    	resizable: true,
	    	 width: '80%',
	    	height: '500px',
	    	onlyMimes: ["image"],
	        uiOptions: {
	            // toolbar configuration
	            toolbar: [ ]
	    	},
		   getFileCallback: function(file) {               
				image_url = "<?php echo asset(''); ?>/" +  file.path  ; 
				$('.CrudEngineEditor').summernote('editor.insertImage', image_url  );	
				$('#browse_media').remove(); //close the window after image is selected
				
			}
		})	
	}
</script>
