<div class="sximo_tools">
	<div class="row">
		<div class="col-md-6">
			
		</div>

		<div class="col-md-6 text-right">
			<a href="javascript:void(0)" class="btn btn-danger btn-sm actionButton" onclick="CrudEngine_Close('#{{ $actionId}}')" >
				<i class="fa fa-close"></i> Close 
			</a>
		</div>
	</div>
<hr />


</div>
</div>	


	<div class="row"> 
	<?php $count = 12 / count($layout);?>
	@foreach($layout as $info => $groups  )
		<div class="col-md-{{ $count}}">
			<fieldset>
			<legend> {{ $info }}</legend>
			<?php $temp =  explode(',',$groups);?>
			@foreach($rows as $row)
				@foreach($views as $key=>$val)
				{{ $key}}
					@if(in_array($key, $temp))
						<tr>			
							<td> {{ $val }}</td>
							<td> {!! $row[$key] !!}</td>							
						</tr>
					@endif	
				@endforeach	
			@endforeach	
			</fieldset>
			
		</div>
	@endforeach
	</div>


