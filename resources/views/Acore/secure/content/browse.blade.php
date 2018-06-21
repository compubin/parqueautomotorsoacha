<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/dropzone.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/dropzone.css" />
<div id="uploaded" ></div>

<div class=" m-t text-right" style="padding: 5px 10px; background: #fff;">
	<button class="btn btn-primary insert-selected" > Insert selecte Image(s)</button>
</div>
<script type="text/javascript">	
$(function(){	
	$('.previewImage').fancybox();
	$.get('{{ url("root/dropzone/uploaded") }}',function(data){
		$('#uploaded').html(data);

		$('.insert-selected').on('click',function(){
			html = '';
			$('.thumbnail-image.selected').each(function( index ){
				val = $(this).attr('title');
				var url_image = "{{ url('uploads/dropzone/') }}";
				html += '<div class="gallery-image"> '+
							'<div class="thumb">'+
								'<a href="'+ url_image+'/'+ val +'" class="previewImage">' +
									'<img src="'+ url_image+'/'+ val +'"   />' +
								'</a>'+
							'</div>'+	
							'<div class="info">'+
								'<div class="name">'+ val +' </div>'+				
							'</div>'+
							'<div class="edit">'+
								'<span class="title"><input type="text" name="name[]" value="'+val+'" class="form-control" /> </span><br />'+
								'<textarea  name="caption[]" class="form-control">..</textarea>'+
								'<input type="hidden" name="image[]" value="'+ val +'"/>'+
								'<button type="button" class=" btn btn-xs btn-danger removeParent" '+
								'onclick="$(this).parents('+ "'.gallery-image'" +').remove();"><i class="fa fa-times"></i> Remove This  </button>'+
							'</div>'+
						'</div>';

				//value.push(val);
				
			})
			
			if(html.length >=1)
			{
				$('#loadImage').prepend( html );		
				$('#sximo-modal').modal('hide');	
			}
			
		})

	})
	
})
</script>
<style type="text/css">
	.modal-dialog {
  width: 98%;
  height: 92%;
  padding: 0;
}

.modal-content {
  height: 99%;
  border-radius: 0px;
  padding: 2px;
}
.modal-body { background: #f5f5f5; padding: 0; }
</style>

