<?php

            $val .= "
// Start Routes for ".$row->module_name." 
Route::resource('{$class}','{$controller}');
Route::post('{$class}','{$controller}@index');
// End Routes for ".$row->module_name." 
"; 

?>                    