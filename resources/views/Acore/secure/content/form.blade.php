
<div class="sximo-tools">
<a href="javascript:void(0)" class="btn btn-default  btn-sm actionButton" onclick="CrudEngine_Close('#{{ $actionId}}')" > 
	<i class="fa fa-arrow-left"></i> Close </a>
</div>
{!! Form::open(array('url'=>'secure/content/'.$cms_type, 'class'=>'form-vertical  CrudEngineForm ','files' => true , 'id' =>$actionId.'-action' )) !!}			
	<div class="form-group " >		
			<div class="input-group">
				<span class="input-group-addon"> Title </span>
		  		<input type="" name="Title" class="form-control input-sm" placeholder="FAQ Title" value="{{ $row['Title']}}" />	

		  	</div>
	</div>

 		
<h4> FAQ Content List</h4>
<div  class="m-t m-b " style="padding: 20px 0; border: dotted 2px #e9e9e9">
	<ul class="faq-list">
	<?php
		$contens = json_decode($row['Contents'],true);
		if(is_array($contens)) {
			$i=0;
			foreach($contens as $key=>$value) { 
	?>
		<li>

			<h4> {{ $value['question'] }} </h4>
			<div>
				{!! $value['answer'] !!}
			</div>
			<div class="text-right" style="padding: 0 20px">
				<a href="javascript://ajax" class="btn btn-xs  edit-field"> Edit   </a>
				<a href="javascript://ajax" class="btn btn-xs  remove-field"> Delete   </a>
			</div>
			<div class="editor-field">
				<div class="form-group  " >						
					<div class="" >
						<div class="input-group">
							<span class="input-group-addon"> Question </span>
					  		<input type="text" name="question[]" class="form-control input-sm" placeholder="Type Question" value=" {{ $value['question'] }}" />	
					  	</div>
				 	</div> 
				</div>

				<div class="form-group  " >	
					
					<div class="" >
					  	<textarea name="answer[]" class="form-control input-sm " placeholder="Type Answer">{!! $value['answer'] !!}</textarea>
				 	</div> 
				</div>	
			</div>
		</li>

	<?php 	}
		}
	 ?>
	</ul>




</div>
<a href="javascript://ajax" onclick="$('.add_new').toggle();" class="btn btn-sm btn-default"> <i class="fa fa-plus"></i> Add Field</a> <br />
<div class="add_new m-t" style="display: none;" >
	<div class="form-group  " >	
		
		<div class="" >
			<div class="input-group">
				<span class="input-group-addon"> Question </span>
		  		<input type="text" name="question[]" class="form-control input-sm" placeholder="Type Question" />	
		  	</div>
	 	</div> 
	</div>

	<div class="form-group  " >	
		
		<div class="" >
		  	<textarea name="answer[]" class="form-control input-sm CrudEngineEditor" placeholder="Type Answer"></textarea>
	 	</div> 
	</div>


</div>	
<hr />
<div class="form-group  " >
	<div class="" >
	<a href="javascript:void(0)" class="btn btn-success  btn-sm actionButton" data-after-task="update"> Submit Change(s) </a> 
	<a href="javascript:void(0)" class="btn btn-default  btn-sm actionButton" onclick="CrudEngine_Close('#{{ $actionId}}')" >  Close </a>		
 	</div> 
</div> 

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
 <script type="text/javascript">
	$(function(){
		$('.edit-field').on('click',function(){
			$('.editor-field').hide();
			$(this).closest('li').find('.editor-field').show();
		})

		$('.CrudEngineEditor').summernote({ 
			height: 150,
			minHeight: null,  
			maxHeight: null,

		})	
	})
</script>		