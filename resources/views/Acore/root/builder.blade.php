@extends('layouts.app')

@section('content')
<div class="page-content row"> 
	<div class="page-content-wrapper m-t">
		<div class="sbox"  >
			<div class="sbox-title" >   
				<h3> {{  $title }}</h3>
			</div>
			<div class="sbox-content">
				
<fieldset>
    <legend> Controller Info </legend>

        {!! Form::open(array('url'=> '', 'class'=>'form-horizontal','files' => true ,  'parsley-validate'=>'','novalidate'=>' ')) !!}

            <div class="form-group row " >
                <label for="Name" class=" control-label col-md-3 "> Title / Label </label>
                <div class="col-md-8">
                   <input type="text" name="SiteName" class="form-control input-sm" value="" />
                </div>  
            </div>
            <div class="form-group row " >
                <label for="Name" class=" control-label col-md-3 "> Controller Name </label>
                <div class="col-md-8">
                    <input type="text" name="SiteName" class="form-control input-sm" value="" />
                    <i><code> Dont use any special chacters or white space </code> </i>
                </div> 
            </div>
            <div class="form-group row " >
                <label for="Name" class=" control-label col-md-3 "> Database Table </label>
                <div class="col-md-8">
                    <select class="form-control input-sm">
                        <option value=""> -- Select Table Master --</option>
                        @foreach($table as $key => $value)
                            <option value="{{ $value }}">{{ $value }}</option>

                        @endforeach
                    </select>
                </div> 
            </div>

<div class="table-responsive">

<table class="table table-bordered">
                        <thead>
                            <tr>
                                <td> Field </td>
                                <td> Label </td>
                                <td> Display </td>
                                <td> Detail </td>
                                <td> Form </td>
                                <td> Display Format </td>
                                <td> Form Type </td>
                                <td> Form Validation </td>
                            </tr>
                        </thead>
                    </table>
</div>
         
             <div class="form-group row " >
                <label for="Name" class=" control-label col-md-3 ">  </label>
                <div class="col-md-8">
                    <button type="submit" name="submit" class="btn btn-primary "><i class="fa fa-refresh"></i> Generate Controller </button>
                </div> 
            </div>  

        {!! Form::close() !!}                              
</fieldset>							
				
			</div>	
		</div>
	</div>		
</div>
                               

  
@endsection