@extends('layouts.app')

@section('content')
	<section class="page-header row">
		<h3> {{ $pageTitle }} <small>{{ $pageNote }}</small> </h3>
		<ol class="breadcrumb">
			<li><a href="{{ url('dashboard')}}"> Home </a></li>
			<li><a href="{{ url('builder')}}"> {!! $pageTitle !!} </a></li>
			<li  class="active">{{ $row->module_title }}   </li>
		</ol>
	</section>
	<div class="page-content row">
		<div class="page-content-wrapper no-margin">
			<div class="sbox"  >
				<div class="sbox-title">
					<h4> {{ $row->module_title }} <small> : File Template </small></h4>
				</div>
				<div class="sbox-content">
					@include('Acore.builder.tab',array('active'=>'template','type'=> $type))
					@if($attach =='system')
						<div class="infobox infobox-info fade in">
							<button type="button" class="close" data-dismiss="alert"> x </button>
							<p> <strong>Tips !</strong> If you want to use custom template , you can start by generating files template .<br />  If files generated , system will automatic swith  from <b>datatables</b> to <b> jQuery Table </b>  CRUD
								<a href="{{ url('builder/attach/'.$row->module_name.'?do=attach') }}" class="text-danger btn btn-sm btn-danger">Generate template files ? </a><p>
						</div>
					@else
						<div class="infobox infobox-info fade in">
							<button type="button" class="close" data-dismiss="alert"> x </button>
							<p> <strong>Tips !</strong> If you want to use template system ,  click here :
								<a href="{{ url('builder/attach/'.$row->module_name.'?do=deattach') }}" class=""> Use Template System ? </a>
							<p>
						</div>

					@endif



					@if($attach =='custom')




						{!! Form::open(array('url'=>'builder/savetemplate/'.$module_name, 'class'=>'form-horizontal','id'=>'fTable')) !!}


						<div class=" m-t" id="table" >
							<h4> Table ( Grid ) </h4>
							<div class="infobox fade in">
								<p> File Location :  <span class="text-info"> /resources/views/{{ $module_name}}/table.blade.php</span>  </p>
							</div>
							<textarea class="form-control code-editor" id="code-editor" name="table" rows="20">{{ $template['table'] }}</textarea>
							<br /> <button class="btn btn-success" type="submit"> Save Change(s) </button>
						</div>
						<div class="  m-t" id="form">
							<h4> Form  </h4>
							<div class="infobox fade in">
								<p> File Location :  <span class="text-info"> /resources/views/{{ $module_name}}/form.blade.php</span>  </p>
							</div>
							<textarea class="form-control" rows="20" name="form"  id="code-editor_2">{{ $template['form'] }}</textarea>
							<br /> <button class="btn btn-success" type="submit"> Save Change(s) </button>
						</div>
						<div class="  m-t" id="view">
							<h4> View Detail </h4>
							<div class="infobox fade in">
								<p> File Location :  <span class="text-info"> /resources/views/{{ $module_name}}/view.blade.php</span>  </p>
							</div>
							<textarea class="form-control" rows="20" name="view"  id="code-editor_3">{{ $template['view'] }}</textarea>
							<br /> <button class="btn btn-success" type="submit"> Save Change(s) </button>
						</div>



						<input type="hidden" name="path" value="{{ $row->module_name }}" />
						<input type="hidden" name="module_id" value="{{ $row->module_id }}" />
						{!! Form::close() !!}
					@endif


				</div>
			</div>
		</div>
	</div>



	@if($attach =='custom')
		<script type="text/javascript" src="{{ asset('sximo5/js/plugins/editarea/edit_area/edit_area_full.js') }}"></script>

		<script type="text/javascript">
            editAreaLoader.init({
                id : "code-editor"		// textarea id
                ,syntax: "html"			// syntax to be uses for highgliting
                ,start_highlight: true		// to display with highlight mode on start-up
            });
            editAreaLoader.init({
                id : "code-editor_2"		// textarea id
                ,syntax: "html"			// syntax to be uses for highgliting
                ,start_highlight: true		// to display with highlight mode on start-up
            });
            editAreaLoader.init({
                id : "code-editor_3"		// textarea id
                ,syntax: "html"			// syntax to be uses for highgliting
                ,start_highlight: true		// to display with highlight mode on start-up
            });
            $(document).ready(function() {
                <?php echo SximoHelpers::sjForm('fTable'); ?>

            })
		</script>
	@endif
	<style type="text/css">
		.tab-content textarea { font-size: 12px; }
		#editor {
			border: solid 1px #eee !important;
		}
		.area_toolbar
		{
			background-color:#fff !important;
		}
	</style>
@stop
