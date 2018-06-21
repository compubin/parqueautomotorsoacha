@extends('layouts.app')

@section('content')
<div class="page-content row"> 
	<div class="page-content-wrapper m-t">
		<div class="sbox bg-gray"  >
			<div class="sbox-title" >   
				<h3>  Web Contents <small> Built In CMS </small></h3>
				
			</div>
			<div class="sbox-content">
				<p> Introducing new features for your frontend need . this new features are <span class="label label-success"> beta </span> version and still on development . so if you find bugs or unfinished module , we are apologize .</p>
				<hr />
				
					<div class="row iconic m-t">
						<div class="col-md-3 ">
							<a href="{{ url('secure/content/gallery')}}">
								<i class="fa fa-picture-o"></i> <br />
								<span >Galleries </span> 
								<p> Images , Portpolio , Slider Etc </p>
							</a>	
						</div> 

						<div class="col-md-3 ">
							<a href="{{ url('secure/content/testimonial')}}">
								<i class="fa fa-comments"></i> <br />
								<span > Testimonial </span>
								<p> Simple users Testimonial </p> 
							</a>	
						</div>

						<div class="col-md-3 ">
							<a href="{{ url('secure/content/faq')}}">
								<i class="fa fa-question-circle"></i> <br />
								<span >FAQ </span> 
								<p> Simple users FAQ </p> 
							</a>	
						</div>


					</div>
				
				
				</div>
					
			
		</div>
	</div>		
</div>
  
  <style type="text/css">
  .iconic .col-md-3 {
  	height: 120px; text-align: center;
  	font-size: 20px;

  }
   .iconic .col-md-3 p{ font-size: 14px; }
  .iconic a { color: #1d2b36 ; }
  .iconic .col-md-3 i{
  	font-size: 70px;
  	color: #1d2b36  
  }	
  </style>
@endsection