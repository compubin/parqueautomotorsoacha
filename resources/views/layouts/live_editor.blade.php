
<div class="modal fade" id="live-editor-modal" tabindex="-1" role="dialog">
<div class="modal-dialog  modal-lg">
  <div class="modal-content">
    <div class="modal-header bg-default">        
        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"> Quick Live Editor </h4>
    </div>
    <div class="modal-body" id="sximo-modal-content">

    	
    </div>
  </div>
</div>
</div>

@if(session('gid') =='1' || session('gid') =='2')

<div class="live-editor">
<ul>
	<li><a href="javascript://ajax" onclick="$('#live-editor-modal').modal('show'); return false;" class="live_editor">
		<i class="fa fa-pencil"></i></a>	
	

</ul>


</div>	

@endif
<link href="{{ asset('sximo5/js/plugins/summernote/dist/summernote.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/summernote/dist/summernote.min.js') }}"></script>
<script type="text/javascript">
	$(function(){
		$('.live_editor').on('click',function() {
			$.get('{!! url("secure/pages?task=update&id=".$pageID."&mode=quicly")!!}',function(data){
				$('#sximo-modal-content').html(data);	
			})
			//$('.editor').summernote({ height:450})
		})

	})
</script>

<style type="text/css">

	.live-editor {
		top: 20%;
		position: fixed;
		width: 30px;
		background: #1d2b36 ;
		
		z-index: 10000;
	}
	.live-editor ul{ 
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.live-editor ul li{ 
		
	}
	.live-editor ul li a{ 
		display: block;
		line-height: 30px;
		height: 30px;
		text-align: center;
		font-size: 13px;
		color: #fff;
	}	

</style>