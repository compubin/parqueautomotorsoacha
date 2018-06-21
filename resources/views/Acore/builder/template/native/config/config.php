<?php
        $template = base_path().'/resources/views/Acore/builder/template/native/';
        $controller = file_get_contents(  $template.'controller.tpl' );
        $grid = file_get_contents(  $template.'index.tpl' );               
        $model = file_get_contents(  $template.'model.tpl' );

        $build_controller       = \SiteHelpers::blend($controller,$codes);    
        $build_grid             = \SiteHelpers::blend($grid,$codes);    
        $build_model            = \SiteHelpers::blend($model,$codes);    
         

        if(!is_null($request->input('rebuild')))
        {
            // rebuild spesific files
            if($request->input('c') =='y'){
                file_put_contents( $dirC."{$ctr}Controller.php" , $build_controller) ;    
            }
            if($request->input('m') =='y'){
                file_put_contents(  $dirM."{$ctr}.php" , $build_model) ;
            }    
            
            if($request->input('g') =='y'){
                file_put_contents(  $dir."/index.blade.php" , $build_grid) ;
            }    

        
        } else {
        
            file_put_contents(  $dirC ."{$ctr}Controller.php" , $build_controller) ;    
            file_put_contents(  $dirM ."{$ctr}.php" , $build_model) ;
            file_put_contents(  $dir."/index.blade.php" , $build_grid) ;                                    
        
        }  

?>             