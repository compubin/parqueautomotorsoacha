@extends('layouts.app')

@section('content')
<div class="page-content row"> 
	<div class="page-content-wrapper m-t">
		<div class="sbox"  >
			<div class="sbox-title" >   
				<h3>  Web Contents </h3>
			</div>
			<div class="sbox-content">
				<div class="col-md-2">
					<ul class="nav">
						<li><a href="{{ url('secure/content/gallery')}}"><i class="fa fa-picture-o"></i> Galleries </a></li>
						<li><a href="{{ url('secure/content/testimonial')}}"><i class="fa fa-comments"></i> Testimonial </a></li>			
						<li><a href="{{ url('secure/content/faq')}}"><i class="fa fa-question-circle"></i> FAQ </a></li>


					</ul>
				</div>
				<div class="col-md-10">
				
				
				{!! $table !!}
				
				</div>

				<div class="clr"></div>
					
			</div>	
		</div>
	</div>		
</div>
  
@endsection