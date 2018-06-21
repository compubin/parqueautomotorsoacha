@if($row->formID !='')
<div class="infobox infobox-success fade in">
<button type="button" class="close" data-dismiss="alert"> x </button>  
<p><strong> Shortcode Usage : </strong> <code> [sc:Form fnc=render|id={{ $row->formID }}][/sc] </code> </p>
</div>
@endif

 {!! Form::open(array('url'=>'root/form', 'class'=>'form-vertical','files' => true , 'parsley-validate'=>'','novalidate'=>' ' ,'id'=>'formField')) !!}
<h3> Form Information : {{ $row->name }}</h3>
<div class=" form-horizontal row m-t form-fancy ">
	<div class="col-md-6">	
		<div class="form-group ">
			<label class="text-right col-md-5"> Name / Title </label>			
	       	<div class="col-md-7">
	       		 <input type="text" name="name" value="{{ $row->name }}" class="form-control input-sm" required="true" />
	       	</div>       
		</div>
		<div class="form-group">
			<label class="text-right col-md-5"> Save Method </label>			
	       	<div class="col-md-7">
	       		<select class="form-control input-sm" name="method" required="true" >
	       			<option value="email"> Send To Email</option>
	       			<option value="table"> Insert Into Database </option>
	       		</select>
	       		 
	       	</div>       
		</div>
		<div class="form-group method" id="method_email">
			<label class="text-right col-md-5"> Send Email </label>			
	       	<div class="col-md-7">
	       		 <input type="text" name="email" value="{{ $row->email }}" class="form-control input-sm" required="true" />
	       	</div>       
		</div>
		<div class="form-group method" id="method_table">
			<label class="text-right col-md-5"> Store to Database </label>			
	       	<div class="col-md-7">
	       		 <input type="text" name="tablename" value="{{ $row->tablename }}" class="form-control input-sm"  />
	       	</div>       
		</div>		
	</div>
	<div class="col-md-6">	
	
		<div class="form-group">
			<label class="text-right col-md-5"> Success Note </label>			
	       	<div class="col-md-7">
	       		 <input type="text" name="success" value="{{ $row->success }}" class="form-control input-sm"  />
	       	</div>       
		</div>	
		<div class="form-group">
			<label class="text-right col-md-5"> Error Note </label>			
	       	<div class="col-md-7">
	       		 <input type="text" name="failed" value="{{ $row->failed }}" class="form-control input-sm"  />
	       	</div>       
		</div>	
		<div class="form-group">
			<label class="text-right col-md-5"> Redirect  </label>			
	       	<div class="col-md-7">
	       		 <input type="text" name="redirect" value="{{ $row->redirect }}" class="form-control input-sm"  />
	       	</div>       
		</div>				

	</div>
</div>
<hr />


<h4 class="m-t"> Manage Form Fields: </h4>

<table class="table form-fancy ">
	<thead>
		<tr>
			<th> Title </th>
			<th> Field </th>
			<th style="width: 15%"> Validation </th>
			<th> Type </th>
			<th style="width: 40%"> Param / Arguments </th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($configuration as $field => $form )
		<tr class="clone clonedInput">
			<td>
				<input type="text" name="f_title[]" placeholder="Title" value="{{ $form['title'] }}" class="form-control input-sm" required="true" />
			</td>
			<td>
				<input type="text" name="f_field[]" placeholder="field name"  value="{{ $field }}" class="form-control input-sm" required="true" />
			</td>
			<td>
				<input type="text" name="f_validation[]" placeholder="Ex : required|email"   value="{{ $form['validation'] }}" class="form-control input-sm"  />
			</td>
			<td>
				
				<select class="form-control input-sm " name="f_type[]" required="true" >
			    	<option value=""> Input Type </option>
			    	@foreach($field_option as $key=>$val)
			    	<option value="{{ $key }}" @if($key == $form['type']) selected @endif 
			    	data-placeholder="{{ $val['placeholder'] }}" 
			    	>{{ $val['name'] }}</option>
			    	@endforeach

			    </select>

			</td>
			<td>
				<div class="input-group">
					<div class="input-group-btn ">
						<a href="{{ url('root/form/field')}}" class="btn btn-sm btn-default" onclick="SximoModal(this.href,'Field Configuration'); return false;"> <i class="fa fa-question-circle"></i></a>
					</div>	
					<input type="text" name="f_param[]" value="{{ $form['param'] }}" class="form-control input-sm params" />
					<div class="input-group-btn ">
						<a class="btn btn-sm btn-default tips" title="Attribute"> <i class="icon-expand"></i></a>
					</div>
				</div>	
				<div class="attrs">
					<b> Attribute</b>
					<textarea class="form-control input-sm" name="attribute[]" placeholder="Example : style='height=100px;'"></textarea>
				</div>	

				
			</td>
			<td>
				<a href="#" class="btn btn-xs text-danger" onclick="$(this).parents('.clonedInput').remove(); return false"><i class="fa fa-minus"></i></a>
					<input name="counter[]" type="hidden" value="" />
			</td>			
															
		</tr>
		@endforeach
		@if(count($configuration) <=0)

		<tr class="clone clonedInput">
			<td>
				<input type="text" name="f_title[]" placeholder="Title / Label" value="" class="form-control input-sm" required="true" />
			</td>
			<td>
				<input type="text" name="f_field[]" placeholder="field name" value="" class="form-control input-sm" required="true" />
			</td>
			<td>
				<input type="text" name="f_validation[]" placeholder="Ex : required|email" value="" class="form-control input-sm"  />
			</td>
			<td>
				
				<select class="form-control input-sm opt-selections" name="f_type[]" required="true" >
			    	<option value=""> Input Type </option>
			    	@foreach($field_option as $key=>$val)
			    	<option value="{{ $key }}" data-placeholder="{{ $val['placeholder'] }}" >{{ $val['name'] }}</option>
			    	@endforeach

			    </select>

			</td>
			<td>
				<div class="input-group">
					<div class="input-group-btn ">
						<a href="{{ url('root/form/field')}}" class="btn btn-sm btn-default" onclick="SximoModal(this.href,'Field Configuration'); return false;"> <i class="fa fa-question-circle"></i></a>
					</div>	
					<input type="text" name="f_param[]" value="" class="form-control input-sm params" />
					<div class="input-group-btn ">
						<a class="btn btn-sm btn-default tips" title="Attribute"> <i class="icon-expand"></i></a>
					</div>
				</div>	
				<div class="attrs">
					<b> Attribute</b>
					<textarea class="form-control input-sm" name="attribute[]" placeholder="Example : style='height=100px;'"></textarea>
				</div>	
			</td>
			<td>
				<a href="#" class="btn btn-xs text-danger" onclick="$(this).parents('.clonedInput').remove(); return false"><i class="fa fa-minus"></i></a>
					<input name="counter[]" type="hidden" value="" />
			</td>			
															
		</tr>
		@endif
	</tbody>
</table>
<a href="javascript:void(0)" class="btn btn-sm addC btn-default " rel=".clone"><i class="fa fa-plus"></i> Add more field </a>
<button class="btn btn-sm btn-primary"> Save Form </button>

</div>


@if($row->formID !='')
<a href="{{ url('root/form/preview?id='.$row->formID) }}" class="btn btn-success btn-sm" onclick="SximoModal(this.href,'Form Preview'); return false;"> Preview Form </a>

<a href="{{ url('root/form/remove?id='.$row->formID) }}" class="btn btn-danger btn-sm remove"> Delete This Form </a>
@endif
<input name="task" type="hidden" value="field" />
<input name="id" type="hidden" value="{{ $row->formID }}" />
 {!! Form::close() !!}
<style type="text/css">
	.form-fancy {

	}
	.attrs {
		display: none;
	}

</style>

<script type="text/javascript">
$(function(){

	$('.opt-selections' ).on('change',function(){
		var placeholder = $('.opt-selections option:selected').data('placeholder');
		$(this).closest('tr').find('.params').attr('placeholder',placeholder);
		//alert(placeholder);
	})
	$('.addC').relCopy({});
	$('.method').hide()
	$('#method_email').show();
	$('select[name=method]').on('change',function(){
		val = $(this).val();
		$('.method').hide();
		$('#method_'+val).show()
	})

	$('.remove').on('click',function(){
		if(confirm('Are U sure Delete form ?'))
		{
			return true;
		} 
		return false;
	})
	$(".select2").select2({ 
		 
		width:"100%",
		data: <?php echo AppHelper::validation();?> ,
	tags: true
		
	});

	var form = $('#formField'); 
    form.parsley();

    form.submit(function()
    {         
      if (form.parsley().isValid())
      {      
        var options = { 
          dataType:      'json', 
          beforeSubmit : function() {
            $('.ajaxLoading').show(); 
          },
          success: function( data ) {
	          if(data.status == 'success')
	          {
	          	notyMessage(data.message);
	          	$('.ajaxLoading').hide();	
	          } else {
	          	$('.ajaxLoading').hide();
	            notyMessageError(data.message);
	           
	          }
          }  
        }  
        $(this).ajaxSubmit(options); 
        return false;                 
	} 
	else {
		notyMessageError('Error ajax wile submiting !');
		return false;
	}      
	});


});


</script>		