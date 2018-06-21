@if($mode =='list')
<div class="table-responsive" style="padding-bottom: 50px;">
<table class="table table-hover table-striped ">
	<thead>
		<tr>			
			@foreach($fields as $key=>$val)
				<th> {{ $val }}</th>
			@endforeach	
			<th> </th>			
		</tr>
	</thead>
	<tbody>
		@foreach($rows as $row)
		<tr>
			@foreach($fields as $key=>$val)
				<td> {!!  $row[$key] !!}</td>
			@endforeach	
			<td><a href="?view={{ $row[ $this_table .'.'. $this_key ]}}" class="btn btn-default btn-sm"> View </a> </td>		
		</tr>
		@endforeach
		
	</tbody>
</table>
</div>

<div class="Page navigation example">	
	<div class="row">
		<div class="col-md-4">
			<div style="vertical-align: middle; line-height: 1.7em; height: 30px; padding: 10px 0;">
				Showing {{ ($paginator->currentpage()-1) * $paginator->perpage()+1 }} to {{$paginator->currentpage()*$paginator->perpage()}}
    of  {{$paginator->total()}} entries

			</div>	
		</div>
		<div class="col-md-8 text-right">
			{!! $paginator->links() !!}
		</div>
	</div>
	
</div>	
@else 

<table class="table table-striped">
	<tbody>
		@foreach($rows as $row)
			@foreach($views as $key=>$val)
			<tr>			
				<td> {{ $val }}</td>
				<td> {!! $row[$key] !!}</td>							
			</tr>
			@endforeach	
		@endforeach
		
	</tbody>
</table>

@endif