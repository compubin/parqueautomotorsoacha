@include( 'CrudEngine.default.toolbar')
<?php
	$pages = array(10,20,30,40,50);
?>
<div class="table-responsive" style="padding-bottom: 50px;">
<div class=" m-b">
	
	Show 
	<select class="form-control input-sm" id="perpage" style="display: inline-block; width: 75px;">
		@foreach($pages as $page)
		<option value="{{ $page }}" @if(isset($_GET['rows']) && $_GET['rows'] == $page) selected @endif >{{ $page }}</option>
		@endforeach		
	</select>
	entries
	

</div> 

 {!! Form::open(array('url'=> $url, 'class'=>'form-vertical','files' => true ,'id'=> $actionId .'table')) !!}
<table class="table table-hover table-striped ">
	<thead>
		<tr>
			<th> <input type="checkbox" class="checkall  minimal-green" />	 </th> 
			@foreach($fields as $key=>$val)
			<th class=" insort 
					@if(str_replace($this_table.'.',"", $key ) == $order_by ) {{ $order_type }}-sort @endif" 
					data-field="{{ str_replace($this_table.'.',"", $key ) }}" data-sort=""> {{ $val }}
			</th>
			@endforeach	
			<?php if(isset($button['update']) || isset($button['view'])) { ?>
			<th  style="width: 10% !important"> </th>
			<?php } ?>	
			
		</tr>
	</thead>

	<tbody>
		@foreach($rows as $row)
		<tr>
		
			
				<td> <input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row[$this_table.'.'.$this_key] }}" /></td>
			
			@foreach($fields as $key=>$val)
				<td data-value="{{ $row[$key] }}" data-format="{{ htmlentities($row[$key]) }}" data-field="{{ $key }}" > {!!  $row[$key] !!}</td>
			@endforeach	


			<?php if(isset($button['update']) || isset($button['view'])) { ?>
			<td style="text-align: right;"> 

				<div class="dropdown">
				  <button class="btn btn-primary btn-xs  dropdown-toggle" type="button" data-toggle="dropdown"> Action
				 </button>
				  <ul class="dropdown-menu pull-right">
				  	@if(isset($button['view']))
				 	<li><a href="{{ url($url.'?task=view&id='.$row[$this_table.'.'.$this_key] )}}" code="view" class="ajaxCallback" title="" mode="{{  $method['form'] }}" ><i class="fa  fa-search "></i> View </a></li>
				 	@endif	
				 	@if(isset($button['update']))
				 	<li>
				 		<a  href="{{ url($url.'?task=update&id='.$row[$this_table.'.'.$this_key]) }}" code="update"  class=" ajaxCallback" title="" mode="{{  $method['view'] }}" ><i class="fa fa-pencil "></i> Edit</a>
				 	</li>
				 	@endif	
				  </ul>
				</div>
			</td>	
			<?php } ?>								
		</tr>
		@endforeach
	</tbody>
</table>
<input type="hidden" name="task" value="copy" id="task" />
{!! Form::close() !!}
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
@include( 'CrudEngine.default.table_footer')