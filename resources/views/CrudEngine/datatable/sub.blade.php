
<fieldset>
	<legend> {{ $title }}</legend>
<div class="table-responsive">
<table class="table table-hover table-striped table-bordered" id="{{ $actionId }}">
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
</div>
</fieldset>
<script type="text/javascript">
	$(document).ready(function() {
    	$('#{{ $actionId }}').DataTable();
	});
</script>
