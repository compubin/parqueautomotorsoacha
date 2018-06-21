@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> {{ $title }} </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('root')}}"> Core  </a></li>
    <li  class="active"> {{ $title }} </li>
  </ol>
</section>
<div class="page-content row">
	<div class="page-content-wrapper no-margin">
        <div class="sbox"  >
            <div class="sbox-title" >   
                <h3> All Tables  </h3>
				<div class="sbox-tools">
					<a href="{{ url('root/database?task=config')}}" class="btn btn-sm  linkConfig tips" title="New Table "><i class="fa fa-plus"></i> Create New Table  </a>
					<a href="{{ url('root/database?task=query')}}" class="btn btn-sm linkConfig tips" title="MySQL Editor"><i class="fa fa-pencil"></i> MySQL Editor  </a>	
				</div>                
            </div>
            <div class="sbox-content">

    		<div class="infobox infobox-info fade in">
			  <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times"></i> </button>  
			   <p><strong> Importanly : </strong> PHP MyAdmin Lite is just a simple MySQL editor , its usefull for quick change on alter , drop and create database table . If you want to advance MySQL editor , please your external tools such PHP MyAdmin , SQL Yog , Maestro Etc .   </p>
			</div>	

<div class="row">
			<div class="col-md-3">
				{!! Form::open(array('url'=>'root/database/delete', 'class'=>'form-horizontal','id'=>'removeTable','method'=>'DELETE' )) !!}
				<div class="table-responsive m-t" id="table-list" style="height: 500px; ">
					<table class="table">
						<thead>
							<tr>
								
								<th width="30"> <input type="checkbox" class="checkall minimal-green " /></th>
								<th> Table Name </th>
								<th width="50"> Action </th>
							</tr>
						</thead>
						<tbody>
						@foreach($tables as $table)
							<tr>
								<td><input type="checkbox" class="ids  minimal-green" name="id[]" value="{{ $table }}" /> </td>
								<td><a href="{{ url('root/database?task=config&table='.$table)}}" class="linkConfig" > {{ $table }}</a></td>
								<td>
								<a href="javascript:void(0)" onclick="droptable()" class="btn btn-xs btn-default"><i class="fa fa-trash-o"></i></a>
								</td>
							</tr>
						@endforeach
						</tbody>
					
					</table>
				
				</div>
				{!! Form::close() !!}		
			</div>
			<div class="col-md-9">
				
				<div class="tableconfig" style="background:#fff; padding:10px; min-height:300px;">

				</div>

			</div>

		</div>
			
	 	</div>
    </div>

              
            </div>  
        </div>
    </div>      
</div>
 
 <script type="text/javascript">
$(document).ready(function(){

	$('.linkConfig').click(function(){
		$('.ajaxLoading').show();
		var url =  $(this).attr('href');
		$.get( url , function( data ) {
			$( ".tableconfig" ).html( data );
			$('.ajaxLoading').hide();
			
			
		});
		return false;
	});
});

function droptable()
{
	if(confirm('are you sure remove selected table(s) ?'))
	{
		$('#removeTable').submit();
	} else {
		return false;
	}
}

</script>
@endsection