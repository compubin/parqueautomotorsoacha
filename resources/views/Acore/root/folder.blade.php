@extends('layouts.app')

@section('content')
<div class="page-content row"> 
	<div class="page-content-wrapper m-t">
		<div class="sbox"  >
			<div class="sbox-title" >   
				<h3> {{  $title }}</h3>
			</div>
			<div class="sbox-content">
				<ul class="nav nav-tabs " style="margin-bottom:10px;">
					<li ><a href="{{ url('root')}}"><i class="fa fa-menu"></i> Navigation  </a></li>
					<li ><a href="{{ url('root/database')}}"><i class="fa fa-database"></i> Database </a></li>
					<li ><a href="{{ url('root/code')}}"><i class="fa fa-code"></i> Source Code  </a></li>
					<li class="active"><a href="{{ url('root/folder')}}"><i class="fa fa-folder"></i> Folder & Files  </a></li>
				</ul>
							
				
			</div>	
		</div>
	</div>		
</div>
                               

  
@endsection