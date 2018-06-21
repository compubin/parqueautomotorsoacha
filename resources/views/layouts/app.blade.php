<?php 
$path = base_path().'/resources/views/layouts/themes/'.config('sximo.cnf_backend').'/';
if(is_dir($path))
{
	$themes = 'layouts.themes.'.config('sximo.cnf_backend').'.index';
} else {
	$themes = 'layouts.themes.minimal.index';	
}

 ?>
@include( $themes)