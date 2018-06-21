<div class="sximo_tools">
	<div class="row">
		<div class="col-md-6">
			<a href="javascript:void(0)" class="btn btn-default btn-sm actionButton" data-after-task="update">
				 {{ __('core.sb_apply') }}
			</a>
			<a href="javascript:void(0)" class="btn btn-default btn-sm actionButton" data-after-task="return">
				 {{ __('core.sb_save') }}
			</a>
		</div>

		<div class="col-md-6 text-right">
			<a href="javascript:void(0)" class="btn  btn-sm actionButton" onclick="CrudEngine_Close('#{{ $actionId}}')" >
				<i class="fa fa-times"></i> Close 
			</a>
		</div>
	</div>
</div>
</div>	
<hr />	

	{!! Form::open(array('url'=> $url, 'class'=>'form-horizontal CrudEngineForm','files' => true , 'id' =>$actionId.'-action' , 'parsley-validate'=>'','novalidate'=>' ')) !!}

@if($validation <= 0 )
	<p class="alert alert-danger"><i class="fa fa-warning"></i> <b>Warning !</b> this form does not any validation ! . Please set at least one validation input </p> 
@endif	

	@foreach($layout as $info => $groups  )
		<fieldset>
			<legend> {{ $info }}</legend>


			@foreach($forms as $key=>$val)

				<?php $temp =  explode(',',$groups);?>
				@if(in_array($key , $temp))
					
					<div class="form-group row " >
						<label for="Name" class=" control-label col-md-3 "> {{ $val['title'] }} </label>
						<div class="col-md-9">
							@if(array_key_exists($key, $forms))
								{!! $val[ 'form'] !!}
							@endif
						</div> 
					</div>
					
				@endif					

			@endforeach
			
		</fieldset>

 


	@endforeach
	@include('CrudEngine.default.subform')
	<input type="hidden" name="{{ $this_key }}" value="{{ $key_value }}" />
	<input type="hidden" name="task" value="{{ $task_value }}" />
	<input type="hidden" name="data-after-task" id="data-after-task" value="" />

{!! Form::close() !!}
@include('CrudEngine.default.javascript')