<?php
	
	$actions = array(
			'create'	=> ['icon'=>'fa fa-plus','button'=>'btn-primary','title'=> 'Create','method'=> $method['form']],
			'view'		=> ['icon'=>'fa fa-eye','button'=>'btn-info','title'=> 'View Detail','method'=> $method['view']],
			'update'	=> ['icon'=>'fa fa-pencil','button'=>'btn-success','title'=> 'Update','method'=> $method['form']],
			'copy'		=> ['icon'=>'fa fa-copy','button'=>'btn-warning','title'=> 'Copy Selected','method'=> ''],
			'delete'	=> ['icon'=>'fa fa-trash-o','button'=>'btn-danger','title'=> 'Delete Selected','method'=> ''],
			'export'	=> ['icon'=>'fa fa-download','button'=>'btn-info','title'=> 'Export CSV','method'=> ''],
			'print'		=> ['icon'=>'fa fa-print','button'=>'btn-success','title'=> 'Print Page','method'=> ''],
			);

	if(count($button))
	{
		$action = [] ;
		foreach( $button as $act){
			if(array_key_exists($act ,  $actions ))
				$action[$act] = $actions[ $act  ];
		}
		
		$actions = $action ;
	}

?>


<div class="sximo_tools m-b">
<div class="">
	<!-- Toolbar Top -->
	<div class="row">
		<div class="col-md-4"> 
		@if(isset($actions['create']))
		<a href="javascript:void(0)" class="btn btn-default btn-sm ajaxCallback" code="create" 
		mode="{{ $actions['create']['method'] }}"  
			title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create New </a>
		@endif	
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-menu5"></i> Bulk actions </button>
	        <ul class="dropdown-menu">
				@if(isset($actions['export']))
				<li>
					<li><a href="{{ url( $url.'?task=export') }}" target="_blank" class="actions_Row" code="view" mode="{{ $actions['export']['method'] }}" >
					 {{ $actions['export']['title'] }}</a></li>
				</li>
				@endif
				@if(isset($actions['print']))
				<li>
					<li><a href="{{ url( $url.'?task=print') }}" >{{ $actions['print']['title'] }}</a></li>
				</li>
				@endif			
				@if(isset($actions['delete']))
					<li role="separator" class="divider"></li>
					<li><a href="javascript://ajax" code="delete" class="tips ajaxCallback" title="{{ __('core.btn_remove') }}">
					Remove Selected </a></li>
				@endif 				

			</ul>

		</div>    
		</div>
		<div class="col-md-4 pull-right">
			<div class="input-group">
			      <div class="input-group-btn">
			        <button type="button" class="btn btn-default btn-sm " ><i class="fa fa-filter"></i> Filter </button>
			      </div><!-- /btn-group -->
			      <input type="text" class="form-control input-sm" placeholder=".. @lang('core.btn_typesearch') .." name="onsearch">
			    </div>
		</div>    
	</div>					
	<!-- End Toolbar Top -->
	</div>
</div>
