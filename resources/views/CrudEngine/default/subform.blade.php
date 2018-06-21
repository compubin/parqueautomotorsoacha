@if(count($subforms))		

	<table class="table table-bordered">
		<thead>
			<tr>
			@foreach($subforms['field'] as $key=>$field)					
				<th @if($key == $subforms['key']) style="display: none;" @endif> {{ $field }} </th>
			@endforeach
				<th></th>	
			</tr>
		</thead>
		
		<tbody>
		@foreach($subforms['form'] as $subform)	
			<tr class="clone clonedInput">
			@foreach($subform as $key=>$form)
				<td @if($key == $subforms['key']) style="display: none;" @endif> {!! $form['form'] !!} </td>
			@endforeach
				<td><a href="#" class="btn btn-xs" onclick="$(this).parents('.clonedInput').remove(); return false"><i class="fa fa-minus"></i></a>
					<input name="sub_counter[]" type="hidden" value="" />
				</td>
			</tr>	
		@endforeach			
		</tbody>
		
	</table>
	
	
	<a href="javascript:void(0)" class="btn btn-xs addC" rel=".clone"><i class="fa fa-plus"></i> Form </a>
	<input name="sub_key" type="hidden" value="{{ $subforms['key'] }}" />
	<input name="sub_relation" type="hidden" value="{{ $subforms['relation'] }}" />
@endif