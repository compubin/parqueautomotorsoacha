@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> {{ $title }} </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li><a href="{{ url('secure')}}"> CMS </a></li>
    <li  class="active"> {{ $title }} </li>
  </ol>
</section>
<div class="page-content row">
	<div class="page-content-wrapper no-margin">
		<div class="sbox"  >
			<div class="sbox-title" >   
				<h3> {!! $title !!} </h3>
			</div>
			<div class="sbox-content">
				<ul class="nav nav-tabs " style="margin-bottom:10px;">
					<li ><a href="{{ url('secure/users')}}"><i class="fa fa-user-plus"></i> Users  </a></li>
					<li ><a href="{{ url('secure/groups')}}"><i class="fa fa-user"></i> Groups </a></li>
					<li class="active"><a href="{{ url('secure/blast')}}"><i class="fa fa-envelope"></i> Blast Email </a></li>
				</ul>
				<!-- Start blast email -->

				{!! Form::open(array('url'=>'secure/doblast/', 'class'=>'form-horizontal ')) !!}
				  
				<div class="col-sm-6">
				  <div class="form-group  " >
				  <label for="ipt" class=" control-label col-md-3">  {{ Lang::get('core.fr_emailsubject') }}   </label>
				  <div class="col-md-9">
				       {!! Form::text('subject',null,array('class'=>'form-control input-sm', 'placeholder'=>'','required'=>'true')) !!} 
				   </div> 
				  </div> 
				  <div class="form-group  " >
				  <label for="ipt" class=" control-label col-md-3"> {{ Lang::get('core.fr_emailsendto') }}   </label>
				  <div class="col-md-9">
				   @foreach($groups as $row)
				    <div class="checkbox checkbox-success">
				      <input type="checkbox"   name="groups[]" value="{{ $row->group_id}}" /> <label> {{ $row->name }}</label>
				    </div>


				   @endforeach
				   </div> 
				  </div> 		  
				  
				</div>
				<div class="col-sm-6">
				  <div class="form-group  " >
				  	<div for="ipt" class=" control-label col-md-3">  Status   </div>
				  	<div class="col-md-9"> 

				        <div class="radio radio-success">
				            <input type="radio" name="uStatus" value="all" required="true" > <label> All Status</label>
				        </div>
				        <div class="radio radio-success">
				            <input type="radio"  name="uStatus" value="1" required="true" > <label> Active </label>
				        </div>  
				        <div class="radio radio-success">
				            <input type="radio"  name="uStatus" value="0" required="true" > <label> Unconfirmed</label>
				        </div>
				        <div class="radio radio-success">
				            <input type="radio"  name="uStatus" value="2" required="true" > <label> Blocked</label>
				        </div>                                
				  	 </div> 
				  </div>  
				</div>

				<div class="col-sm-12">

				  <div class="form-group "  >				 
				  <div style=" padding:10px;">
				   <label for="ipt" class=" control-label "> {{ Lang::get('core.fr_emailmessage') }} </label>
				   <textarea class="form-control CrudEngineEditor" rows="10"   name="message"></textarea> 
				   </div>
				   <p> {{ Lang::get('core.fr_emailtag') }} : </p>
				   <small> [fullname] [first_name] [last_name] [email]  </small>
				 
				  </div>   
				  <div class="form-group" >
				  <label for="ipt" class=" control-label col-md-3"> </label>
				  <div class="col-md-9">
				      <button type="submit" name="submit" class="btn btn-primary">{{ Lang::get('core.sb_send') }} Mail </button>
				   </div> 
				  </div> 
				</div>	                   
				{!! Form::close() !!}


				<!-- / blast email -->


				<div class="clr clear"></div>
			</div>	

		</div>
	</div>		
</div>



<style type="text/css" >
  .note-editable { min-height: 200px;}
</style>


<script type="text/javascript">
$(function(){
	$('.CrudEngineEditor').summernote({

	})
});
</script>		

@stop