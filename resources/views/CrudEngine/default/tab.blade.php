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
				<i class="fa fa-times"></i> {{ __('core.sb_cancel') }}
			</a>
		</div>
	</div>

</div>
<hr />

{!! Form::open(array('url'=> $url, 'class'=>'form-horizontal CrudEngineForm','files' => true ,  'id' =>$actionId.'-action'  , 'parsley-validate'=>'','novalidate'=>' ')) !!}

<ul class="nav nav-tabs CrudTab">
@foreach($layout as $info => $groups  )
	<li >
		<a href="#{{ str_replace(" ","-",$info) }}" data-toggle="tab" role="tab">{{ $info }}</a>
	</li>
@endforeach	
</ul>

<!-- Tab panes -->
<div class="tab-content">
@foreach($layout as $info => $groups  )
	<div class="tab-pane" id="{{ str_replace(" ","-",$info) }}" role="tabpanel">
	<div style="padding: 20px;"> 
	@foreach($forms as $key=>$val)
		<?php $temp =  explode(',',$groups);?>
		@if(in_array($key , $temp))
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
	</div>
	</div>
@endforeach	
@include('CrudEngine.default.subform')
</div>

<input type="hidden" name="task" value="{{ $task_value }}" />
<input type="hidden" name="data-after-task" id="data-after-task" value="" />
{!! Form::close() !!}
<script type="text/javascript">
	$(function(){
		$('.CrudTab a:first').tab('show')
	})
</script>
@include('CrudEngine.default.javascript')