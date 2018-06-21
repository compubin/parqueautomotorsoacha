
<div class="table-responsive">
 {!! Form::open(array('url'=> $url, 'class'=>'form-vertical','files' => true ,'id'=> $actionId .'table')) !!}
<table class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
	
			@foreach($fields as $key=>$val)
				<th> {{ $val }}</th>
			@endforeach	
			
		</tr>
	</thead>

	<tbody>
		@foreach($rows as $row)
		<tr>	
			
			@foreach($fields as $key=>$val)
				<td> {!!  $row[$key] !!}</td>
			@endforeach				
		</tr>
		@endforeach
		
	</tbody>
</table>
