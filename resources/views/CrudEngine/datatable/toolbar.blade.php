
@if($type =='crud')
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
<div class="sximo_tools">
	<!-- Toolbar Top -->
	<div class="row">
		<div class="col-md-4"> 
		@if(isset($action['create']))
		<a href="javascript:void(0)" class="btn btn-default btn-sm Action_Row" code="create" 
		mode="{{ $action['create']['method'] }}"  
			title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create New </a>
		@endif	
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-menu5"></i> Bulk Action </button>
	        <ul class="dropdown-menu">
				@if(isset($action['export']))
				<li>
					<li><a href="{{ url( $url.'?task=export') }}" target="_blank" class="Action_Row" code="view" mode="{{ $action['export']['method'] }}" >
					 {{ $action['export']['title'] }}</a></li>
				</li>
				@endif
				@if(isset($action['print']))
				<li>
					<li><a href="{{ url( $url.'?task=print') }}" >{{ $action['print']['title'] }}</a></li>
				</li>
				@endif			
				@if(isset($action['delete']))
					<li role="separator" class="divider"></li>
					<li><a href="javascript://ajax" code="delete" class="tips Action_Row" title="{{ __('core.btn_remove') }}">
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


@endif