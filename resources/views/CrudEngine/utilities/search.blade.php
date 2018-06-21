<div class="sximo_tools">
	<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="ajaxClose('#{{ $actionId}}')"><i class="fa fa-arrow-left"></i> Return </a>
</div>	
 {!! Form::open(array('url'=> $url, 'class'=>'form-horizontal','files' => true , 'id' =>'sClassForm' , 'parsley-validate'=>'','novalidate'=>' ')) !!}

@foreach($forms as $key=>$val)

	@if($key == $tablekey)
		<input type="hidden" name="{{ $key }}" value="" />
	@else
	<div class="form-group row " >
		<label for="Name" class=" control-label col-md-4 "> {{ $val['title'] }}</label>
		<div class="col-md-8">
			@if(array_key_exists($key, $forms))
				{!! $val[ 'form'] !!}
			@endif
		</div> 
	</div>
	@endif

@endforeach	
<div class="form-group row " >
	<label for="Name" class=" control-label col-md-4 "></label>
	<div class="col-md-8">
		<button class="btn btn-sm btn-primary" type="submit" name="submit_form"> Save & Return </button>
	</div> 
</div>
<input type="hidden" name="task" value="insert" />
{!! Form::close() !!}