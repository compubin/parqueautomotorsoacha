@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/jquery.nestable.js') }}"></script>
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
		<div class="sbox bg-gray"  >
			<div class="sbox-title" >   
				<h3> Folder & Files </h3>
			</div>
			<div class="sbox-content">
				<div class="col-md-3">
					<div style="min-height: 400px;">
						<div id="container_id"></div>
					</div>
				</div>	

				<div class="col-md-9">
					<div class="spanel">
						<div style="min-height: 400px;" class="panel-body">
							<b> File Location : </b> <span class="file_location text-danger"></span>
							{!! Form::open(array('url'=>'root/code_save', 'class'=>'form-horizontal','id'=>'FormCode' )) !!}
		 					 
		 					<div class="message"></div>
		 					<div class="editor_content">
			 					<textarea id="content_html" name="content_html" class="form-control markItUp" rows="20"></textarea>
			 				</div>	
		 					<input type="hidden" name="path" class="path" value="" >
		 					<br />
		 					<button class="btn btn-primary save_content" type="button"> Save Change(s) </button>
		 				{!! Form::close() !!}
						</div>
					</div>					
				</div>	
				<div class="clr"></div>							
				
			</div>	
		</div>
	</div>		
</div>

<!-- N.R. jqueryFileTree fix -->
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/jquery.fileTree/jqueryFileTree.js') }}"></script>
<link href="{{ asset('sximo5/js/plugins/jquery.fileTree/jqueryFileTree.css') }}" rel="stylesheet">
<link href="{{ asset('sximo5/js/plugins/codemirror/style/codemirror.css') }}" rel="stylesheet">
<script src="{{ asset('sximo5/js/plugins/codemirror/script/codemirror.js') }}"></script>
<script src="{{ asset('sximo5/js/plugins/codemirror/javascript.js') }}"></script>
<!-- end -->                               
<script type="text/javascript">
    $(document).ready( function() {

        $('#container_id').fileTree({
            root: '/',
            script: '{{ url("root/code_source/folder")}}',
            expandSpeed: 1000,
            collapseSpeed: 1000,
            multiFolder: false
        }, function(file) {
        	$('.ajaxLoading').show();	
        	$('#content_html').val('');
        	$.get( "{{ url('root/code_edit/')}}",{ path:file}, function( data ) {
        		$('.editor_content').html('<textarea id="content_html" name="content_html" class="form-control markItUp" rows="20">'+ data.content +'</textarea>')
        		$('.file_location').html(data.path);
        		$('.path').val(data.path);
				$('.result').show();
				
				var textarea = document.getElementById("content_html");
				MyEditor = CodeMirror.fromTextArea(textarea , {
					lineNumbers: true,
					matchBrackets: true,
				});
			});
           
        });

        
        $('.save_content').on('click',function(){
        	
        	//alert(arrays);
        	value = MyEditor.getValue();  
        	$('#content_html').val(value);

        	posts =  $('#FormCode :input').serializeArray();
        	$.post('{{ url("root/code_save")}}', posts , function( callback) {
        		 notyMessage(callback.data);
        	})  	
			
        })      
    });

   
</script> 
  
@endsection