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
        	<h4> {{ $row->module_title }} <small> : Form Design Editor </small></h4>
        	</div>
            <div class="sbox-content">

	@include('Acore.builder.tab',array('active'=>'form','type'=> 'addon'))

	<ul class="nav nav-tabs" style="margin-bottom:10px;">
	  	<li ><a href="{{ url('builder/form/'.$module_name)}}">Form Configuration </a></li> 
	  	<li  ><a href="{{ url('builder/subform/'.$module_name)}}">Sub Form </a></li> 
		<li class="active" ><a href="{{ url('builder/formdesign/'.$module_name)}}">Form Layout</a></li> 
	</ul>
	<div class="infobox infobox-success fade in">
	  <button type="button" class="close" data-dismiss="alert"> x </button>  
	  <strong>Tips !</strong> Drag and drop rows to re ordering lists	
	</div>	

 {!! Form::open(array('url'=>'builder/formdesign/'.$module_name,'id'=>'doReorder', 'class'=>'form-vertical','parsley-validate'=>'','novalidate'=>' ')) !!}
 
 <div class="col-md-4">
	  <div class="form-group ">
		<label> Number Of Block : </label>
		
		<select class="form-control"  required name="column" style="width:200px;" onchange="location.href='?block='+this.value">
		<?php for($i=1 ; $i<5;$i++) {?>	
				<option value="<?php echo $i;?>" <?php if($form_column == $i) echo 'selected';?> ><?php echo $i;?> Block </option>	
		<?php  } ?>	
		</select>
		
	</div>

 </div>
 
 <div class="form-vertical">
 <div class="col-md-4">
	<div class="form-group">
		<label> Display Form As : </label>
		<div class="radio">		
			<input type="radio" name="format" value="def" class="minimal-green" 
			<?php if($format == 'def') echo 'checked';?>
			  /> Default	
		</div>	  	
		<div class="radio">	
			<input type="radio" name="format" value="tab" class="minimal-green" 
			<?php if($format == 'tab') echo 'checked';?>
			  /> Tab
		</div>
		<div class="radio">		  
			<input type="radio" name="format" value="column" class="minimal-green" 
			<?php if($format == 'column') echo 'checked';?>
			  /> Column
		</div>	  
		<div class="radio">		  
			<input type="radio" name="format" value="group" class="minimal-green" 
			<?php if($format == 'group') echo 'checked';?>
			  /> Groupped   	   		
		</div>	
		<div class="radio">		  
			<input type="radio" name="format" value="wizzard" class="minimal-green" 
			<?php if($format == 'wizzard') echo 'checked';?>
			  /> Wizzard / Steps   	   		
		</div>				
	</div> 
	
	

 </div>
 <div class="col-md-4">
 	<div class="form-group">
		<label> Form Layout : </label>
		<div class="radio-group">
		
			<input type="radio" name="display" value="horizontal" class="minimal-green" 
			<?php if($display == 'horizontal') echo 'checked';?>
			  /> Normal
		
			<input type="radio" name="display" value="vertical" class="minimal-green" 
			<?php if($display == 'vertical') echo 'checked';?>
			  /> Vertical
		
		</div>				
	</div>	

	<div class="form-group">
	
			<label> Once you made changes on layout , please rebuild Form Files to take affect </label>
			<input type="hidden" name="reordering" id="reordering" value="" class="form-control" />
			<input type="hidden" name="module_id" value="{{ $row->module_id }}" />
			<button type="button" class="btn btn-primary" id="saveLayout"> Save Layout </button>
	
	 </div>	 
 </div>
</div>
<div style="margin-bottom:20px; clear:both; border-bottom:dashed 1px #ddd; padding:5px;"></div>
 


				 
			<!-- BEGIN: XHTML for example 1.2 -->
			
			<div id="FormLayout" class="row">
				<?php
					
					for($i=0;$i<$form_column;$i++)
					{
						if($form_column == 4) {
							$class = 'col-md-3';
						}  elseif( $form_column ==3 ) {
							$class = 'col-md-4';
						}  elseif( $form_column ==2 ) {
							$class = 'col-md-6';
						} else {
							$class = 'col-md-12';
						}
						?>
						<div class="column left  <?php echo $class ;?>">
							  <div class="form-group">
								<label for="ipt" class=" "> Block Title <?php echo $i+1;;?></label>
								<input type="type" name="title[]" class="form-control" required placeholder=" Title Block "
								 value="<?php if(isset($title[$i])) echo $title[$i];?>"
								 />
							  </div>  
 							
							<ul class="sortable-list">
							<?php foreach($forms as $rows){
								if($rows['form_group'] == $i) {
									echo '<li class="sortable-item" id="'.$rows['field'].'"> '.$rows['label'].' </li>';
								}
							}?>
							</ul>
						</div>
						<?php
					}
				
				?>

				<div class="clearer">&nbsp;</div>
				<div class="col-md-12" style="margin:10px 0;">

				</div>	
				

			</div>
 {!! Form::close() !!}


            </div>
        </div>
    </div>
</div>    



<script>
$(document).ready(function() {
	$('#saveLayout').click(function(){
		val = getItems('#FormLayout');
		$('#reordering').val(val);
		$('#doReorder').submit();

		//alert('Items saved (' + val + ')');
	});
	// Example 1.2: Sortable and connectable lists
	$('#FormLayout .sortable-list').sortable({
		connectWith: '#FormLayout .sortable-list'
	});
	

});

	function getItems(exampleNr)
	{
		var columns = [];

		$(exampleNr + ' ul.sortable-list').each(function(){
			columns.push($(this).sortable('toArray').join(','));				
		});

		return columns.join('|');
	}
</script>
<style>

/* Floats */


.clear,.clearer {clear: both;}
.clearer {
	display: block;
	font-size: 0;
	height: 0;
	line-height: 0;
}


/*
	Example specifics
------------------------------------------------------------------- */

/* Layout */





/* Sortable items */

.sortable-list {
	background-color: #fff; border: 1px solid #e9e9e9;
	list-style: none;
	margin: 0;
	min-height: 60px;
	padding: 10px;
}
.sortable-item {
	background-color: #f9f9f9;
	
	cursor: move;
	display: block;
	margin-bottom: 5px;
	padding: 5px 20px;
}

/* Containment area */

#containment {
	background-color: #FFA;
	height: 230px;
}


/* Item placeholder (visual helper) */

.placeholder {
	background-color: #ddd;
	border: 1px dashed #666;
	height: 58px;
	margin-bottom: 5px;
}
</style>
@stop