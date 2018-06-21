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
             <h4> {{ $row->module_title }} :  <small> MySQL Editor ( Edit SQL Statement ) </small></h4>
            </div>  
            <div class="sbox-content">

              @include('Acore.builder.tab',array('active'=>'sql' ))
                
               {!! Form::open(array('url'=>'builder/savesql/'.$module_name, 'class'=>'form-horizontal ' ,'id'=>'SQL' , 'parsley-validate'=>'','novalidate'=>' ')) !!}
               <div class="infobox infobox-info fade in">
                <button type="button" class="close" data-dismiss="alert"> x </button>  
                <p> <strong>Tips !</strong> Where ever you made change on database table fields , please resave SQL to get new configuration fields </p> 
              </div>  


              <div class="form-group">
                 <label for="ipt" class=" control-label col-md-3"> Master Table  </label>
                 <div class="col-md-9">
                    <select class="form-control input-sm" name="module_db">
                        <option value="{{ $table }}"> {{ $table }}</option>
                    </select>
                 </div>
               </div>
              
              <div class="form-group">
             <label for="ipt" class=" control-label col-md-3"> Join Table </label>
              <div class="col-md-9">

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
        @if(count($join_table))
          @foreach($join_table as $key=>$val)
          <tr class="clone clonedInput">
            <td>
              {!! Form::select('table[]', $tables , $key , 
                array('class'=>'form-control input-sm', 'required'=>'true' )); 
              !!}
            </td>
            <td><input type="text" name="master[]" value="{{ $val['master']}}" placeholder="Master Table Key " class="form-control input-sm" /></td>
            <td><input type="text" name="join[]" value="{{ $val['join']}}" placeholder="Joined Table Key " class="form-control input-sm" /></td>
            <td>
            <a href="#" class="btn btn-xs" onclick="$(this).parents('.clonedInput').remove(); return false"><i class="fa fa-minus"></i></a>
            <input name="counter[]" type="hidden" value="" />
            </td>        
          </tr>
          @endforeach
        @else
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
         @endif
      </tbody>

    </table>
    <a href="javascript:void(0)" class="btn btn-xs addC" rel=".clone"><i class="fa fa-plus"></i> Join Table </a>
              </div>
              </div>  

    
              <div class="form-group">
                <label for="ipt" class=" control-label col-md-3"></label>
                <div class="col-md-9">
                  <button type="submit" class="btn btn-primary"> Re-Save SQL & Configuration</button>
                </div>  
              </div>  

               <input type="hidden" name="module_id" value="{{ $row->module_id }}" />
               <input type="hidden" name="module_name" value="{{ $row->module_name }}" />
               
               {!! Form::close() !!}


            </div>
        </div>
    </div>
</div>    

<script type="text/javascript">
  $(document).ready(function(){
    $('a.addC').relCopy({});
    <?php echo SximoHelpers::sjForm('SQL'); ?>
  })
</script> 
@stop