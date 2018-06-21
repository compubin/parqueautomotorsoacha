@if($method['form'] == 'native' )
<div class="sximo_tools text-right">		
	<a href="javascript:void(0)" class="btn  btn-sm " onclick="CrudEngine_Close('#{{ $actionId}}');" >
		<i class="fa fa-times"></i>
	</a>
</div>	
@endif
@if($validation <= 0 )
	<p class="alert alert-danger"><i class="fa fa-warning"></i> <b>Warning !</b> this form does not any validation ! . Please set at least one validation input </p> 
@endif		
 {!! Form::open(array('url'=>$url, 'class'=>'form-horizontal CrudEngineForm','files' => true , 'id' =>$actionId.'-action' ,'parsley-validate'=>'','novalidate'=>' ')) !!}

@foreach($forms as $key=>$val)

	@if($this_key != $key and $val['type'] != 'hidden')
		<div class="form-group row " >
			<label for="Name" class=" control-label col-md-3 "> {{ $val['title'] }}</label>
			<div class="col-md-9">
				@if(array_key_exists($key, $forms))
					{!! $val[ 'form'] !!}
				@endif
			</div> 
		</div>	
	@endif	

@endforeach	
	<div class="form-group row ">
		<label for="Name" class=" control-label col-md-3 "> </label>
		<div class="col-md-9">
			<a href="javascript:void(0)" class="btn btn-success  actionButton" data-after-task="update"> {{ __('core.sb_apply') }}</a>
			<a href="javascript:void(0)" class="btn btn-info  actionButton" data-after-task="return"> {{ __('core.sb_save') }} </a>
		</div> 
	</div>

@include('CrudEngine.default.subform')
	<input type="hidden" name="{{ $this_key }}" value="{{ $key_value }}" />
	<input type="hidden" name="task" value="{{ $task_value }}" />
	<input type="hidden" name="data-after-task" id="data-after-task" value="" />
{!! Form::close() !!}
@include('CrudEngine.default.javascript')
