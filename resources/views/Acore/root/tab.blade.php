<?php

$tabs = array(
		'config' 		        => ''. Lang::get('core.tab_siteinfo'),
		'email'			=> ' '. Lang::get('core.tab_email'),
		
	);

?>

<ul class="nav nav-tabs m-b" style="margin-bottom: 20px;">
@foreach($tabs as $key=>$val)
	<li  @if($key == $active) class="active" @endif><a href="{{ URL::to('root/'.$key)}}"> {!! $val !!}  </a></li>
@endforeach

</ul>