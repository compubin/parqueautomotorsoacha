
<div class="sximo-tools">
<a href="javascript:void(0)" class="btn btn-danger  btn-sm actionButton" onclick="CrudEngine_Close('#{{ $actionId}}')" > 
	<i class="fa fa-times"></i> Close </a>

	<a href="javascript:void(0)" class="btn btn-success  btn-sm actionButton pull-right" data-after-task="update"> Submit Change(s) </a>
</div>
{!! Form::open(array('url'=>'secure/content/'.$cms_type, 'class'=>'form-vertical  CrudEngineForm ','files' => true , 'id' =>$actionId.'-action' )) !!}			
	<div class="form-group " >		
			<div class="input-group">
				<span class="input-group-addon"> Album / Title </span>
		  		<input type="" name="Title" class="form-control input-sm" placeholder="Gallery Title" value="{{ $row['Title']}}" />	

		  	</div>
	</div>

 		
<h4> Gallery Images </h4>
<div  class="m-t m-b " style="padding: 10px; border: dotted 2px #999">
	<div class="album" id="loadImage" >
			
	<?php
		$contens = json_decode($row['Contents'],true);
		if(is_array($contens)) {
			$i=0;
			foreach($contens as $key=>$value) { 
	?>
		<div class="gallery-image">

		<div class="thumb">
			<a href="{{ asset($value['image']) }}" class="previewImage">
				<img src="{{ asset($value['image']) }}"   />
			</a>
		</div>	
		<div class="info">
			<div class="name"> {{ $value['name']}} </div>
			
		</div>
		<div class="edit">
			<span class="title"><input type="text" name="name[]" value="{{ $value['name']}}" class="form-control" /> </span><br />
			<textarea  name="caption[]" class="form-control">{{ $value['caption']}}</textarea>
			<input type="hidden" name="image[]" value="{{ $value['image'] }}"/>
			<button type="button" class=" btn btn-xs btn-danger removeParent"><i class="fa fa-times"></i> Remove This  </button>
		</div>
	</div>

	<?php 	}
		}
	 ?>
	 <div class="clr"></div>
	</div>




</div>
<a href="javascript://ajax" onclick="SximoMedia()" class="btn btn-sm btn-default"> <i class="fa fa-plus"></i> Insert Image</a> 
<a href="javascript://ajax" class="btn btn-sm btn-primary updated-image " ><i class="fa fa-pencil"></i> Edit Image  </a>
<br />



<input type="hidden" name="{{ $this_key }}" value="{{ $key_value }}" />
<input type="hidden" name="task" value="{{ $task_value }}" />
<input type="hidden" name="Type" value="{{ $cms_type }}" />
<input type="hidden" name="data-after-task" id="data-after-task" value="apply" />
 {!! Form::close() !!}


<div class="modal fade" id="sximo-modal" tabindex="-1" role="dialog">
<div class="modal-dialog  ">
  <div class="modal-content">
    <div class="modal-header bg-default">
        
        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
    </div>
    <div class="modal-body" id="sximo-modal-content">

    </div>

  </div>
</div>
</div>
<style type="text/css">
	.editor-field { display: none; }
</style>

@include('CrudEngine.default.javascript')
<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/pepper-grinder/jquery-ui.css" />
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/elfinder/js/elfinder.min.js') }}"></script>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo5/js/plugins/elfinder/css/elfinder.min.css')}}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo5/js/plugins/elfinder/css/theme.css')}}" />
 <script type="text/javascript">
	$(function(){
		$('.previewImage').fancybox();
		$('.edit-field').on('click',function(){
			$('.editor-field').hide();
			$(this).closest('li').find('.editor-field').show();
		})
		$('.updated-image').on('click',function(){
				$('#loadImage .gallery-image').toggleClass('update-mode');	
		})

	    $('.removeParent').on('click',function(){
	    	$(this).parents('.gallery-image').remove();
	    })	
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
	   		html = '';
	   		//var url_image = "{{ url('uploads/dropzone/') }}";
	   		url_image = "<?php echo asset(''); ?>/" +  file.path  ; 
	   		val = file.name ;
	   		
	   		//alert(url_image);
	   	
			html += '<div class="gallery-image"> '+
						'<div class="thumb">'+
							'<a href="'+ url_image+'" class="previewImage">' +
								'<img src="'+ url_image+'"   />' +
							'</a>'+
						'</div>'+	
						'<div class="info">'+
							'<div class="name">'+ val +' </div>'+				
						'</div>'+
						'<div class="edit">'+
							'<span class="title"><input type="text" name="name[]" value="'+val+'" class="form-control" /> </span><br />'+
							'<textarea  name="caption[]" class="form-control"> '+val+'</textarea>'+
							'<input type="hidden" name="image[]" value="'+ url_image +'"/>'+
							'<button type="button" class=" btn btn-xs btn-danger removeParent" '+
							'onclick="$(this).parents('+ "'.gallery-image'" +').remove();"><i class="fa fa-times"></i> Remove This  </button>'+
						'</div>'+
					'</div>';           
		
			
			$('#browse_media').remove(); //close the window after image is selected
			$('#loadImage').prepend( html );	
			
		}
	})	
}	
</script>		