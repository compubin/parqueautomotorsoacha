<table class="table table-striped">
	<thead>
		<tr>
			<th> Widget Name</th>
			<th> Group Access </th>
			<th> Template File </th>
			<th> Status </th>									
		</tr>
	</thead>
	<tbody>
	@foreach($results as $row)
		<tr>
			<td>{{ $row->name }}</td>
			<td></td>
			<td>{{ $row->name }}</td>
			<td>{{ $row->template }}</td>
		</tr>
	@endforeach	
		<tr>
			<td><input type="text" name="name" value="" class="form-control input-sm"></td>
			<td><input type="text" name="name" value="" class="form-control input-sm"></td>
			<td><input type="text" name="name" value="" class="form-control input-sm"></td>
			<td>
				<select class="form-control input-sm"></select>	

			</td>


		</tr>
	</tbody>
</table>
<script type="text/javascript">
	$(function(){
		$('#sximo-modal .modal-dialog').addClass('modal-lg');
	})
</script>