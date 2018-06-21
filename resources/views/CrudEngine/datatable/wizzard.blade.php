<div class="sximo_tools">
	<div class="row">
		<div class="col-md-12 text-right">
			<a href="javascript:void(0)" class="btn  btn-sm actionButton" onclick="CrudEngine_Close('#{{ $actionId}}')" >
				<i class="fa fa-close"></i> {{ __('core.sb_cancel') }}
			</a>
		</div>
	</div>
<hr />


</div>
</div>	
<div class="sximo-form" >
	{!! Form::open(array('url'=> $url, 'class'=>'form-horizontal CrudEngineForm','files' => true , 'id' =>$actionId.'-action' , 'parsley-validate'=>'','novalidate'=>' ')) !!}
	<div  id="wizard-step" class="wizard-circle number-tab-steps " > 
	@foreach($layout as $info => $groups  )
		<h3>{{ $info }}</h3>
		<section>
			@foreach($forms as $key=>$val)

				<?php $temp =  explode(',',$groups);?>
				@if(in_array($key , $temp))
					
					<div class="form-group row " >
						<label for="Name" class=" control-label col-md-3 "> {{ $val['title'] }} </label>
						<div class="col-md-9">
							@if(array_key_exists($key, $forms))
								{!! $val[ 'form'] !!}
							@endif
						</div> 
					</div>
					
				@endif					

			@endforeach
			
		</section>
	@endforeach
	</div>
	@include('CrudEngine.datatable.subform')
	<input type="hidden" name="{{ $this_key }}" value="{{ $key_value }}" />
	<input type="hidden" name="task" value="{{ $task_value }}" />
	<input type="hidden" name="data-after-task" id="data-after-task" value="" />

{!! Form::close() !!}
</div>
<script type="text/javascript">
	$(function() {


	    $("#wizard-step").steps({
	        headerTag: "h3",
	        bodyTag: "section",
	        transitionEffect: "fade",
	        titleTemplate: '<span class="step">#index#</span> #title#',
	        autoFocus: true,
	        labels: {
        		finish: 'Submit'
		    },
		    onFinished: function (event, currentIndex) {
		    	$('#{{ $actionId }}-action').submit();
//		        alert("Form submitted.");
		    }
	    });
	     $('.steps ul > li > a span').removeClass('number')
	    //$('.steps ul > li > a span').addClass('step')


	})
</script>
@include('CrudEngine.datatable.javascript')