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
 {!! Form::open(array('url'=>'secure/users', 'class'=>'form-vertical CrudEngineForm ','files' => true , 'id' =>$actionId.'-action' )) !!}	
<div class="row">
	<div class="col-md-8">
		<fieldset>
			<legend> Personal Info </legend>
			<div class="form-group  " >
				<label for="ipt" class="">  Group ID  </label>						 
				{!! $forms['group_id']['form'] !!}
			</div> 
			<div class="row">
					<div class="form-group  col-md-6" >
						<label for="ipt" class="">  First Name  </label>						 
						{!! $forms['first_name']['form'] !!}
					</div> 
					<div class="form-group  col-md-6" >
						<label for="ipt" class="">  Last Name  </label>						 
						{!! $forms['last_name']['form'] !!}
					</div> 			
			</div>
			<div class="row">
					<div class="form-group  col-md-6" >
						<label for="ipt" class=""> Status </label>						 
						{!! $forms['active']['form'] !!}
					</div> 
					<div class="form-group  col-md-6" >
						<label for="ipt" class=""> Avatar / Photo   </label>						 
						{!! $forms['avatar']['form'] !!}
					</div> 			
			</div>			
		</fieldset>
	</div>		

	<div class="col-md-4">
		<fieldset>
			<legend> Login Credit </legend>
			<div class="form-group  " >
				<label for="ipt" class="">  Username ID  </label>						 
				{!! $forms['username']['form'] !!}
			</div> 
			<div class="form-group  " >
				<label for="ipt" class="">  Email Address  </label>						 
				{!! $forms['email']['form'] !!}
			</div> 
			<div class="form-group  " >
				<label for="ipt" class="">  Password  </label>						 
				{!! $forms['password']['form'] !!}
			</div> 						

		</fieldset>
	</div>		
</div>	
	<input type="hidden" name="{{ $this_key }}" value="{{ $key_value }}" />
	<input type="hidden" name="task" value="{{ $task_value }}" />
	<input type="hidden" name="pagetype" value="page" />
	<input type="hidden" name="data-after-task" id="data-after-task" value="" />

			 {!! Form::close() !!}
@include('CrudEngine.datatable.javascript')