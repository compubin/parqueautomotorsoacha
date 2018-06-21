@if($method['form'] =='native')
<div class="sximo_tools text-right">
	<a href="javascript:void(0)" class="btn btn-sm actionButton tips" title="{{ __('core.sb_cancel') }}" onclick="CrudEngine_Close('#{{ $actionId}}')" >
		<i class="fa fa-close"></i> 
	</a>
</div>	
@endif

<table class="table table-striped table-bordered">
	<tbody>
		<thead>
			<tr>
				<th> Property </th>
				<th> Value </th>
			</tr>
		</thead>
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
	</tbody>
</table>

@if(is_array($subdetail))

	@foreach($subdetail as $sub)
		
			<div class="subdetail" id="{{ $sub }}">{{ $sub }}</div>
		
	@endforeach

	<script type="text/javascript">
		$(function(){
			<?php foreach($subdetail as $sub) :
				$suburl = $sub."?task=sub&relation=".$this_key."&id=".$key_value;
			 ?>
			
			$.get('<?php echo $suburl ;?>',function(data){
				$('#<?php echo $sub;?>').html(data)
			})
			
			<?php endforeach;?>
		})
	</script>
@endif