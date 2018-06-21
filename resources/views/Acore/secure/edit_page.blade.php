
		 {!! Form::open(array('url'=>'secure/pages', 'class'=>'form-vertical CrudEngineForm ','files' => true , 'id' =>$actionId.'-action' )) !!}			

			<div class="col-sm-9 ">
	

						<ul class="nav nav-tabs" >
						  <li class="active"><a href="#info" data-toggle="tab"> Page Content </a></li>
						  <li ><a href="#meta" data-toggle="tab"> Meta & Description </a></li>
						</ul>	

						<div class="tab-content">
						  <div class="tab-pane active m-t" id="info">
				  <div class="form-group  " >
					<label for="ipt" > Title </label>
					
					  {!! Form::text('title', $row['title'],array('class'=>'form-control input-sm', 'placeholder'=>'', 'required'=>'true'  )) !!} 
					
				  </div> 	

				  <div class="form-group  " >
					<label for="ipt" > Sub Title </label>
					
					  {!! Form::text('sinopsis', $row['sinopsis'],array('class'=>'form-control input-sm', 'placeholder'=>'' )) !!} 
					
				  </div> 

				  <div class="form-group  " >
					<label for="ipt" class=" btn-primary  btn btn-sm">  {!! url('')!!}/  </label>						 
						{!! Form::text('alias', $row['alias'],array('class'=>'form-control input-sm', 'placeholder'=>'', 'style'=>'width:150px; display:inline-block;'   )) !!} 
				  </div> 

							  <div class="form-group  " >
								
								<div class="" style="background:#fff;">
								<a onclick="SximoMedia()" class="btn btn-default btn-sm"><i class="fa fa-picture-o"></i> Insert Media </a>

								  <textarea name='note'  id='note' required="true"   class='form-control CrudEngineEditor'  
									 >{{ $row['note'] }}</textarea> 
								 </div> 
							  </div> 						  

						  </div>

						  <div class="tab-pane m-t" id="meta">

					  		<div class="form-group  " >
								<label class=""> Metakey </label>
								<div class="" style="background:#fff;">
								  <textarea name='metakey' rows='5' id='metakey' class='form-control markItUp'>{{ $row['metakey'] }}</textarea> 
								 </div> 
							  </div> 

				  			<div class="form-group  " >
								<label class=""> Meta Description </label>
								<div class="" style="background:#fff;">
								  <textarea name='metadesc' rows='10' id='metadesc' class='form-control markItUp'>{{ $row['metadesc'] }}</textarea> 
								 </div> 
							  </div> 							  						  

						  </div>

						</div>  
		 	</div>		 
		 
		 	<div class="col-sm-3 ">
					
				  <div class="form-group hidethis " style="display:none;">
					<label for="ipt" class=""> PageID </label>
					
					  {!! Form::text('pageID', $row['pageID'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					
				  </div> 					
				  	
	
				  	<div class="form-group  " >
						<label> Status </label>
						<select name="status" class="form-control input-sm">
							<option value="enable" @if( $row['status'] =='enable') selected @endif> Enable </option>
							<option value="disabled" @if( $row['status'] =='disabled') selected @endif> Disable </option>
						</select>
					</div>	

				  <div class="form-group  " >
					<label> Template </label>
					<select name="template" class="form-control input-sm">
						<option value="frontend" @if( $row['template'] =='frontend') selected @endif> Frontend </option>
						<option value="backend" @if( $row['template'] =='backend') selected @endif> Backend </option>
					</select>				 
				  </div> 	

				<div class="form-group  " >
					<label> Set As Homepage ? </label>
					<div class="">
							{!! $forms['default']['form'] !!}
					</div>					 
				</div> 
				<div class="form-group  " >
					<label for="ipt" > Page Template </label>
					<select class="form-control input-sm" name="filename">
						<option value="page"> Select Template </option>
						<?php
							$path = base_path().'/resources/views/layouts/'.config('sximo.cnf_theme').'/info.json';
							$pagetemplate = json_decode(file_get_contents($path),true);
						?>
						@foreach($pagetemplate['template'] as $key=> $val)
							<option value="{{ $val }}" @if($row['filename'] == $val) selected @endif>{{ $key}}</option>
						@endforeach
					</select>
				</div>	

				  <div class="form-group  " >
				  <label for="ipt"> Who can view this page ? </label>
						{!! $forms['access']['form'] !!}	
						  
				  </div> 
				  <div class="form-group  " >
					<label> Show for Guest ? unlogged  </label>
					<div class="">
						<input  type='checkbox' name='allow_guest'  class="minimal-red" 
 						@if($row['allow_guest'] ==1 ) checked  @endif	
					   value="1"	/> <label> Allow Guest ? </label>  </div>
				  </div>	
				  <div class="form-group  " >
					
					<div class="">
						 <a href="javascript:void(0)" class="btn btn-success btn-block btn-sm actionButton" data-after-task="return">
				Save & Edit </a> <br />

				<a href="javascript:void(0)" class="btn btn-default btn-block btn-sm actionButton" onclick="CrudEngine_Close('#{{ $actionId}}')" >
				Close 
			</a>
				  </div>					  

				 						  				  
		
			</div>
		</div>	

	<input type="hidden" name="{{ $this_key }}" value="{{ $key_value }}" />
	<input type="hidden" name="task" value="{{ $task_value }}" />
	<input type="hidden" name="pagetype" value="page" />
	<input type="hidden" name="data-after-task" id="data-after-task" value="return" />
	<div class="clr clear"></div>
			 {!! Form::close() !!}

<div class="clr"></div>
<script src="{{ asset('sximo5/js/plugins/summernote/dist/plugin/sximo5-summernote.js')}}"></script>
<script src="{{ asset('sximo5/js/plugins/summernote/dist/plugin/summernote-ext-template.js')}}"></script>
<script src="{{ asset('sximo5/js/plugins/summernote/dist/plugin/summernote-ext-highlight.js')}}"></script>

<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/pepper-grinder/jquery-ui.css" />
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/elfinder/js/elfinder.min.js') }}"></script>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo5/js/plugins/elfinder/css/elfinder.min.css')}}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo5/js/plugins/elfinder/css/theme.css')}}" />
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
                $('.ajaxLoading').show(); 
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
		            
		            $('.ajaxLoading').hide();	            
					

		          } else {
		            notyMessageError(data.message);
		            $('.ajaxLoading').hide();
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
<style type="text/css">
	.note-editable  .section {
		border: dotted 1px #eee;
	}
</style>
