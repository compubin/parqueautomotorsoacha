

 {!! Form::open(array('url'=>'builder/create/','id'=>'fCreate' ,'class'=>'form-horizontal', 'parsley-validate'=>'','novalidate'=>'')) !!}

<div class="infobox infobox-info fade in">
  <button type="button" class="close" data-dismiss="alert"> x </button>  
   <p><strong> <i class="fa fa-info text-info"></i> Tips : </strong> After module created , you can add more option query via MySQL editor or directly to controller  </p>
  
</div>

	<div class="form-group has-feedback">
		<label class="col-sm-3 text-right"> Module Title </label>
		<div class="col-sm-9">	
	  {!! Form::text('module_title', null, array('class'=>'form-control input-sm', 'placeholder'=>'Title Name', 'required'=>'true')) !!}
		</div>
	</div>		
	
	<div class="form-group ">
		<label class="col-sm-3 text-right"> Short Desc  </label>
		<div class="col-sm-9">	
	  {!! Form::text('module_note', null, array('class'=>'form-control input-sm', 'placeholder'=>'Short description module')) !!}
		
		</div>
	</div>

	<div class="form-group " style="display: none;">
		<label class="col-sm-3 text-right"> Template :  </label>
		<div class="col-sm-9">	
			@foreach($cruds as $crud)
			<label class="" style="font-weight: 300;">	

				<input type="radio" name="module_template" value="{{ $crud->type }}" checked="checked" class="minimal-red" />
				<label style="font-size: 14px;"> {{ $crud->name }} </label>   <br />
				<small > {{ $crud->note }} </small> 
			</label> <br />
			@endforeach

				
					
		</div>
	</div>		


	<div class="form-group ">
		<label class="col-sm-3 text-right">Class Controller </label>
		<div class="col-sm-9">	
	  {!! Form::text('module_name', null, array('class'=>'form-control input-sm', 'placeholder'=>'Class Controller / Module Name' ,  'required'=>'true')) !!}
		
		</div>
	</div>	
		
	
	<div class="form-group">
		<label class="col-sm-3 text-right"> {{ Lang::get('core.fr_modtable') }}  </label>
		<div class="col-sm-9">	
		{!! Form::select('module_db', $tables , '' , 
			array('class'=>'form-control input-sm', 'required'=>'true' )); 
		!!}
	 	
		</div>
	</div>	
	<div class="form-group" style="display: none;">
		<label class="col-sm-3 text-right">   </label>
		<div class="col-sm-9">	
		<input type="checkbox" name="joined[]" class="join_check" value="1"> Use Join Table
	 	
		</div>
	</div>

	<div class="row form-group joine_table" style="display: none;">
	<hr />
	<b> Join Table ( Relation ) </b><small><i> Leave Blank if not use join table </i> </small>
		
		<table class="table">
			<thead>
				<tr>
					<th> Table</th>
					<th> Master Key </th>
					<th> Joined Key</th>
					<th>  </th>
				</tr>
			</thead>
			<tbody>
				<tr class="clone clonedInput">
					<td>
						{!! Form::select('table[]', $tables , '' , 
							array('class'=>'form-control input-sm', 'required'=>'true' )); 
						!!}
					</td>
					<td><input type="text" name="master[]" placeholder="Master Table Key " class="form-control input-sm" /></td>
					<td><input type="text" name="join[]" placeholder="Joined Table Key " class="form-control input-sm" /></td>
					<td>
					<a href="#" class="btn btn-xs" onclick="$(this).parents('.clonedInput').remove(); return false"><i class="fa fa-minus"></i></a>
					<input name="counter[]" type="hidden" value="" />
					</td>
					
				</tr>
			</tbody>

		</table>
		<a href="javascript:void(0)" class="btn btn-xs addC" rel=".clone"><i class="fa fa-plus"></i> Join Table </a>
	</div>	
				
	<div class="form-group " style="display:none;">
		<label class="col-sm-3 text-right">Author </label>
		<div class="col-sm-9">	
	  	{!! Form::text('module_author',  null, array('class'=>'form-control input-sm', 'placeholder'=>'Author')) !!}
		
		</div>
	</div>	
		



	
		
      <div class="form-group">
		<label class="col-sm-3 text-right">&nbsp;</label>
		<div class="col-sm-9">	
	  	<button type="submit" class="btn btn-primary "><i class="icon-checkmark-circle2"></i>  Save & Generate Module</button>
	  	
	  	<input type="hidden" name="mode" id="mode" value="">
		</div>	  

      </div>
  </div>
    
    </div>

    <div id="result">

    </div>
 {!! Form::close() !!}


<script type="text/javascript">
  $(document).ready(function(){


  	
  	$('a.addC').relCopy({});
  	$('input.join_check').on('click',function(){
  		 $('.joine_table').toggle()
  	})
    var form = $('#fCreate'); 

  	$('.preview').on('click',function(){
  		var table = $('select[name=module_db] option:selected').text();
  		$.get("{{ url('builder/preview/') }}/"+ table+'?mode=view',function(data){
  			$('#result').html(data);
  			$('.modal-dialog ').addClass('modal-lg')
  		})	
  	})

    form.parsley();
    form.submit(function(){         
      if(form.parsley().isValid()){      
        var options = { 
          dataType:      'json', 
          beforeSubmit : function() {
            $('.ajaxLoading').show(); 
          },
          success: function( data ) {
	          if(data.status == 'success')
	          {
	          	$('#result').html(data);
	            notyMessage(data.message);$('.ajaxLoading').hide();$('#sximo-modal').modal('hide'); 
	            window.location.href ='{{ url("builder")}}';
	          } else {
	            notyMessageError(data.message);$('.ajaxLoading').hide();return false;
	          }
          }  
        }  
        $(this).ajaxSubmit(options); 
        return false;                 
      } else {
        return false;
      }   
    
    });
  })
</script> 
