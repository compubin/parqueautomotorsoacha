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
                <h4> {{ $row->module_title }}  <small> :  Extend form ( Setting Child Form ) </small> </h4>
            </div>
            <div class="sbox-content">

              @include('Acore.builder.tab',array('active'=>'subform'))

              <ul class="nav nav-tabs" style="margin-bottom:10px;">
                  <li  ><a href="{{ URL::to('builder/form/'.$module_name)}}">Form Configuration </a></li>
                  <li class="active" ><a href="{{ URL::to('builder/subform/'.$module_name)}}">Sub Form </a></li> 
                <li ><a href="{{ URL::to('builder/formdesign/'.$module_name)}}">Form Layout</a></li> 
              </ul>    
                
              {!! Form::open(array('url'=>'builder/savesubform/'.$module_name, 'class'=>'form-horizontal  ','id'=>'fSubf')) !!}

                  <input  type='text' name='master' id='master'  value='{{ $row->module_name }}'  style="display:none;" /> 
                  <input  type='text' name='module_id' id='module_id'  value='{{ $row->module_id }}'  style="display:none;" />

                   <div class="form-group">
                    <label for="ipt" class=" control-label col-md-4"> Subform Title <code>*</code></label>
                    <div class="col-md-8">
                      {!! Form::text('title', (isset($subform['title']) ? $subform['title']: null ),array('class'=>'form-control input-sm', 'placeholder'=>'' ,'required'=>'true')) !!} 
                    </div> 
                  </div>   

                  <div class="form-group">
                    <label for="ipt" class=" control-label col-md-4">Sub Form Database <code>*</code></label>
                    <div class="col-md-8">
                    <select name="table" id="table" required="true" class="form-control input-sm">       
                              </select> 
                    </div> 
                  </div>       
                  <div class="form-group">
                    <label for="ipt" class=" control-label col-md-4">Sub Form Primary Key <code>*</code></label>
                    <div class="col-md-8">
                    <select name="master_key" id="master_key" required="true" class="form-control input-sm">
                    </select> 
                    </div> 
                  </div>  
                  <div class="form-group">
                    <label for="ipt" class=" control-label col-md-4">Sub Form Relation Key <code>*</code></label>
                    <div class="col-md-8">
                    <select name="key" id="key" required="true" class="form-control input-sm">
                    </select> 
                    </div> 
                  </div>     



    <table class="table">
      <thead>
        <tr>
          <th> Field Name</th>
          <th> Form Type </th>
          <th> Form Config</th>
          <th> Validation</th>
          <th>  </th>
        </tr>
      </thead>
      <tbody>

      @if(!isset($subform['data']))

       
        <tr class="clone clonedInput">
          <td>
            <select class="form-control input-sm fiel_name" name="fields[]" required="true"></select>
          </td>
          <td>
            <select class="form-control input-sm" required="true" name="type[]">
              @foreach($field_type_opt as $key=>$val)
                <option value="{{ $key }}">{{ $val }}</option>
              @endforeach
            </select>
          </td>
          <td><input type="text" name="config[]" placeholder="Config / Attribute " class="form-control input-sm" /></td>
          <td><input type="text" name="validation[]" placeholder="validation " class="form-control input-sm" /></td>
          <td>
          <a href="#" class="btn btn-xs" onclick="$(this).parents('.clonedInput').remove(); return false"><i class="fa fa-minus"></i></a>
          <input name="counter[]" type="hidden" value="" />
          </td>        
        </tr>

       

      @else  
         @foreach($subform['data'] as $field=>$value)
        <tr class="clone clonedInput">
          <td>
            <select class="form-control input-sm fiel_name_current" name="fields[]" required="true">
             @foreach($table_fields as $f)
                <option value="{{ $f }}" @if($field ==$f) selected @endif>{{ $f }} </option>
              @endforeach
             
            </select>
          </td>
          <td>
            <select class="form-control input-sm" required="true" name="type[]">
             @foreach($field_type_opt as $key=>$val)
                <option value="{{ $key }}" @if($value['1'] ==$key) selected @endif>{{ $val }}</option>
             @endforeach 
            </select>
          </td>
          <td><input type="text" value="{{ $value['2'] }}" name="config[]" placeholder="Config / Attribute " class="form-control input-sm" /></td>
          <td><input type="text" value="{{ $value['3'] }}" name="validation[]" placeholder="validation " class="form-control input-sm" /></td>
          <td>
          <a href="#" class="btn btn-xs" onclick="$(this).parents('.clonedInput').remove(); return false"><i class="fa fa-minus"></i></a>
          <input name="counter[]" type="hidden" value="" />
          </td>        
        </tr>
         @endforeach
      @endif  
        
      </tbody>

    </table>
    <a href="javascript:void(0)" class="btn btn-xs addC" rel=".clone"><i class="fa fa-plus"></i> More field </a>

                   <div class="form-group">
                    <label for="ipt" class=" control-label col-md-4"></label>
                  <div class="col-md-8">
                    <button name="submit" type="submit" class="btn btn-primary"><i class="icon-bubble-check"></i> Save Master Detail </button>
                    @if(isset($subform['master_key']))
                    <a href="{{ url('builder/subformremove/'.$module_name) }}" class="btn btn-danger"><i class="icon-cancel-circle2 "></i> Remove </a>
                    @endif
                   </div> 
                  </div> 
               {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>    
 

 <script>
$(document).ready(function(){   
    $("#table").jCombo("{{ url('builder/combotable') }}",
    {selected_value : "{{ (isset($subform['table']) ? $subform['table']: null ) }}" }); 
    <?php if(isset($subform['data'])) { ?>
    $("#key ").jCombo("{{ url('builder/combotablefield') }}?table=",
    { parent  :  "#table" , selected_value : "{{ (isset($subform['key']) ? $subform['key']: null ) }}"}); 
    $("#master_key ").jCombo("{{ url('builder/combotablefield') }}?table=",
    { parent  :  "#table" , selected_value : "{{ (isset($subform['master_key']) ? $subform['master_key']: null ) }}"}); 
    <?php } else { ?>
    $("#key ,.fiel_name").jCombo("{{ url('builder/combotablefield') }}?table=",
    { parent  :  "#table" , selected_value : "{{ (isset($subform['key']) ? $subform['key']: null ) }}"});
     $("#master_key ").jCombo("{{ url('builder/combotablefield') }}?table=",
    { parent  :  "#table" , selected_value : "{{ (isset($subform['master_key']) ? $subform['master_key']: null ) }}"}); 
    <?php } ;?>
});
</script> 

<script type="text/javascript">
  $(document).ready(function(){
    $('a.addC').relCopy({});
    <?php echo SximoHelpers::sjForm('fSubf'); ?>

  })
</script> 

@stop     