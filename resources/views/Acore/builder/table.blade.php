@extends('layouts.app')

@section('content')
<?php 
	$formats = array(
			'date'		=> ['name'=>'Date','placeholder'=>'ex : dd-mm-yy'],
			'image'		=> ['name'=>'Image','placeholder'=>'ex : /uploads/foldername/'],
			'link'		=> ['name'=>'Link','placeholder'=>'ex : http://link.com/{id}'],
			'radio'		=> ['name'=>'Checkbox/Radio','placeholder'=> 'ex : value:display,value1,display1'],
			'number'	=> ['name'=>'number','placeholder'=>'']	,
			'file'		=> ['name'=>'Files','placeholder'=>'ex : /uploads/foldername/'],
			'function'	=> ['name'=>'Function','placeholder'=>'ex : Class:method:{id}-{id2}'],
			'database'	=> ['name'=>'Lookup / Database','placeholder'=>'ex : tb_name:id:display_field']								
		);
	?>

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
        		<h4>  {{ $row->module_title }} <small> : Table Editor ( Edit Table Setting ) </small></h4>
        	</div>	
            <div class="sbox-content clearfix">
            	@include('Acore.builder.tab',array('active'=>'table','type'=>$type))
				{!! Form::open(array('url'=>'builder/savetable/'.$module_name, 'class'=>'form-horizontal','id'=>'fTable')) !!}

						
						
					<div class="infobox infobox-success fade in">
					  <button type="button" class="close" data-dismiss="alert"> x </button>  
					  <p> <strong>New Feature ! ( LIMIT TO ) </strong> Type User ID's using (,) into spesific column to limit the column only viewd by them </p>	
					</div>

					 
							<table class="table table-striped" id="table">
							<thead class="no-border">
							  <tr>
								<th scope="col">No</th>
								
								<th scope="col">Field</th>
								<th scope="col" width="70" style="display: none;"> Limit</th>
								<th scope="col" data-hide="phone">Title / Caption </th>
								<th scope="col" data-hide="phone">Show</th>
								<th scope="col" data-hide="phone">VD </th>
								<th scope="col" data-hide="phone">ST</th>
								<th scope="col" data-hide="phone">DW</th>
								<th scope="col" data-hide="phone" style="width:70px;">Width</th>
								<th scope="col" data-hide="phone" style="width:100px;">Align</th>				
								<th scope="col" data-hide="phone"> Format As </th>
							  </tr>
							 </thead> 
							<tbody class="no-border-x no-border-y">	
							<?php usort($tables, "SiteHelpers::_sort"); ?>
							  <?php $num=0; foreach($tables as $rows){
									$id = ++$num;
							  ?>
							  <tr >
								<td class="index"><?php echo $id;?></td>
								
								<td ><strong><?php echo $rows['field'];?></strong>
								<input type="hidden" name="field[<?php echo $id;?>]" id="field" value="<?php echo $rows['alias'];?>" />			</td>
								<td style="display: none;">
									<?php
										 $limited_to = (isset($rows['limited']) ? $rows['limited'] : '');
									?>
									<input type="text" class="form-control input-sm" width="40" name="limited[<?php echo $id;?>]" class="limited" value="<?php echo $limited_to;?>" style="width: 30px" />

								</td>
								<td >           
									<div class="input-group input-group-sm">
									<span class="input-group-addon xlick bg-default btn-xs " >EN</span>				
									<input name="label[<?php echo $id;?>]" type="text" class="form-control input-sm " 
									id="label" value="<?php echo $rows['label'];?>" />
									</div>

								
								  <?php $lang = SiteHelpers::langOption();
								  if($sximoconfig['cnf_multilang'] ==1) {
									foreach($lang as $l) { if($l['folder'] !='en') {
								   ?>
								   <div class="input-group input-group-sm" style="margin:1px 0 !important;">
								   <span class="input-group-addon xlick bg-default btn-sm " ><?php echo strtoupper($l['folder']);?></span>
									 <input name="language[<?php echo $id;?>][<?php echo $l['folder'];?>]" type="text" class="form-control input-sm " 
									 value="<?php echo (isset($rows['language'][$l['folder']]) ? $rows['language'][$l['folder']] : '');?>"
									 placeholder="Label for <?php echo ucwords($l['name']);?>"
									  />
									 
								  </div>
								  <?php } } }?>	
								 
								</td>					
								<td>
								<label >
								<input name="view[<?php echo $id;?>]" type="checkbox" id="view" value="1"  class="minimal-green"
								<?php if($rows['view'] == 1) echo 'checked="checked"';?>/>
								</label>
								</td>
								<td>
								<label >
								<input name="detail[<?php echo $id;?>]" type="checkbox" id="detail" value="1"  class="minimal-green"
								<?php if($rows['detail'] == 1) echo 'checked="checked"';?>/>
								</label>
								</td>
								<td>
								<label >
								<input name="sortable[<?php echo $id;?>]" type="checkbox" id="sortable" value="1"  class="minimal-green"
								<?php if($rows['sortable'] == 1) echo 'checked="checked"';?>/>
								</label>
								</td>
								<td>
								<label >
								<input name="download[<?php echo $id;?>]" type="checkbox" id="download" value="1"  class="minimal-green"
								<?php if($rows['download'] == 1) echo 'checked="checked"';?>/>
								</label>
								</td>
								<td>
									<input type="text" class="form-control input-sm" name="width[<?php echo $id;?>]" value="<?php echo $rows['width'];?>" />
								</td>
								<td>
									<?php $aligns = array('left','center','right'); ?>
									<select class="form-control input-sm" name="align[<?php echo $id;?>]">
									<?php foreach ($aligns as $al) { ?>
										<option value="<?php echo $al;?>" <?php if(isset($rows['align']) && $rows['align'] == $al) echo 'selected';?> ><?php echo ucwords($al);?></option>
									<?php } ?>
									</select>
								</td>	


								<td>
								
									<div class="input-group">
								      <div class="input-group-btn ">
								        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									        @if($rows['format_as'] != '')
									        	{{ $rows['format_as'] }}
									        @else
									        	Format
									        @endif	
								         </button>
								        <ul class="dropdown-menu format-option">
											@foreach($formats as $key=>$val)			
											<li><a href="javascript://void" code="{{ $val['placeholder'] }}" value="{{ $key }}" onid="{{ $id }}">{{ $val['name'] }}</a></li>
											@endforeach
											<li class="divider"></li>
											<li><a href="javascript://void" value="Format" code="Unformated" onid="{{$id}}" > Format  </a></li>
								        </ul>
								      </div><!-- /btn-group --> 
								      <input type="text" name="format_value[<?php echo $id;?>]" id="format_value-{{$id}}"  value="<?php if(isset($rows['format_value'])) echo $rows['format_value'];?>" class="form-control input-sm" placeholder="Unformated" >
								       <input type="hidden" name="format_as[<?php echo $id;?>]" id="format_as-{{ $id }}" value="{{ $rows['format_as'] }}">
								    </div><!-- /input-group -->

								

						
								<a href="javascript://ajax" data-html="true" class="text-success format_info" data-toggle="popover" title="Example Usage" data-content="  <b>Data </b> = dd-yy-mm <br /> <b>Image</b> = /uploads/path_to_upload <br />  <b>Link </b> = http://domain.com ? <br /> <b> Function </b> = class|method|params <br /> <b>Checkbox</b> = value:Display,...<br /> <b>Database</b> = table|id|field <br /><br /> All Field are accepted using tag {FieldName} . Example {<b><?php echo $rows['field'];?></b>} " data-placement="left">
								<i class="fa fa-question-circles	"></i>
								</a>

								
								<input type="hidden" name="frozen[<?php echo $id;?>]" value="<?php echo $rows['frozen'];?>" />
								<input type="hidden" name="search[<?php echo $id;?>]" value="<?php echo $rows['search'];?>" />
								<input type="hidden" name="hidden[<?php echo $id;?>]" value="<?php if(isset($rows['hidden'])) echo $rows['hidden'];?>" />
								<input type="hidden" name="alias[<?php echo $id;?>]" value="<?php echo $rows['alias'];?>" />
								<input type="hidden" name="field[<?php echo $id;?>]" value="<?php echo $rows['field'];?>" />
								<input type="hidden" name="sortlist[<?php echo $id;?>]" class="reorder" value="<?php echo $rows['sortlist'];?>" />
					
								<input type="hidden" name="conn_valid[<?php echo $id;?>]"   
								value="<?php if(isset($rows['conn']['valid'])) echo $rows['conn']['valid'];?>"  />
								<input type="hidden" name="conn_db[<?php echo $id;?>]"   
								value="<?php if(isset($rows['conn']['db'])) echo $rows['conn']['db'];?>"  />	
								<input type="hidden" name="conn_key[<?php echo $id;?>]"  
								value="<?php if(isset($rows['conn']['key'])) echo  $rows['conn']['key'];?>"   />
								<input type="hidden" name="conn_display[<?php echo $id;?>]" 
								value="<?php if(isset($rows['conn']['display'])) echo   $rows['conn']['display'];?>"    />			 
								
								</td>
								
							  </tr>
							  <?php } ?>
							  </tbody>
							</table>
							
					 <div class="infobox infobox-info fade in">
					  <button type="button" class="close" data-dismiss="alert"> x </button>  
					   <b> NOTE :  </b> | <b>(DW)</b>  = Download | <b> (VD) </b> = View Detail | <b>( ST )</b> = Sortable <br />
					  <p> <strong>Tips !</strong> Drag and drop rows to re ordering lists </p>	
					</div>	
									
							<button type="submit" class="btn btn-primary"><i class="icon-checkmark-circle2"></i> Save Changes </button>
							<input type="hidden" name="module_id" value="{{ $row->module_id }}" />
					{!! Form::close() !!}
		</div>			
    </div>
</div>    



</div></div>
<style type="text/css">
	.popover-content { font-size: 13px; }

</style>

<script type="text/javascript">

$(document).ready(function() {

	$('.format_info').popover();
	$('.format-option li a').on('click',function(){
		var selText = $(this).text();

		$(this).parents('.input-group-btn').find('.dropdown-toggle').html(selText);
		var id = $(this).attr('onid');
		var code = $(this).attr('code');
		var value = $(this).attr('value');
		$('#format_as-'+ id).val(value)
		$('#format_value-'+ id).attr('placeholder',code)
		if(value =='Format')
		{
			$('#format_as-'+ id).val('')
			$('#format_value-'+ id).val('')		
			
		}		

	})

	var fixHelperModified = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index) {
			$(this).width($originals.eq(index).width())
		});
		return $helper;
		},
		updateIndex = function(e, ui) {
			$('td.index', ui.item.parent()).each(function (i) {
				$(this).html(i + 1);
			});
			$('.reorder', ui.item.parent()).each(function (i) {
				$(this).val(i + 1);
			});			
		};
		
	$("#table tbody").sortable({
		helper: fixHelperModified,
		stop: updateIndex
	});		
});
</script>
<script type="text/javascript">
  $(document).ready(function(){

    <?php echo SximoHelpers::sjForm('fTable'); ?>

  })
</script> 

<style>
	.xlick { cursor:pointer;}
	.popover { width:600px;}
</style>

@stop