<?php
        
            // Start Routes for marcaautomotor 
            Route::resource('marcaautomotor','MarcaautomotorController');
            Route::post('marcaautomotor','MarcaautomotorController@index');
            // End Routes for marcaautomotor
            // Start Routes for lineaautomotor 
            Route::resource('lineaautomotor','LineaautomotorController');
            Route::post('lineaautomotor','LineaautomotorController@index');
            // End Routes for lineaautomotor
            // Start Routes for tipoautomotor 
            Route::resource('tipoautomotor','TipoautomotorController');
            Route::post('tipoautomotor','TipoautomotorController@index');
            // End Routes for tipoautomotor
            // Start Routes for tiposervicioautomotor 
            Route::resource('tiposervicioautomotor','TiposervicioautomotorController');
            Route::post('tiposervicioautomotor','TiposervicioautomotorController@index');
            // End Routes for tiposervicioautomotor
            // Start Routes for colorautomotor 
            Route::resource('colorautomotor','ColorautomotorController');
            Route::post('colorautomotor','ColorautomotorController@index');
            // End Routes for colorautomotor
            // Start Routes for cilindrajeautomotor 
            Route::resource('cilindrajeautomotor','CilindrajeautomotorController');
            Route::post('cilindrajeautomotor','CilindrajeautomotorController@index');
            // End Routes for cilindrajeautomotor
            // Start Routes for tipocarroceriaautomotor 
            Route::resource('tipocarroceriaautomotor','TipocarroceriaautomotorController');
            Route::post('tipocarroceriaautomotor','TipocarroceriaautomotorController@index');
            // End Routes for tipocarroceriaautomotor
            // Start Routes for tipocombustibleautomotor 
            Route::resource('tipocombustibleautomotor','TipocombustibleautomotorController');
            Route::post('tipocombustibleautomotor','TipocombustibleautomotorController@index');
            // End Routes for tipocombustibleautomotor
            // Start Routes for estadoautomotor 
            Route::resource('estadoautomotor','EstadoautomotorController');
            Route::post('estadoautomotor','EstadoautomotorController@index');
            // End Routes for estadoautomotor
            // Start Routes for inventario 
            Route::resource('inventario','InventarioController');
            Route::post('inventario','InventarioController@index');
            // End Routes for inventario
            // Start Routes for secretaria 
            Route::resource('secretaria','SecretariaController');
            Route::post('secretaria','SecretariaController@index');
            // End Routes for secretaria
            // Start Routes for dependencia 
            Route::resource('dependencia','DependenciaController');
            Route::post('dependencia','DependenciaController@index');
            // End Routes for dependencia
            // Start Routes for usuarios 
            Route::resource('usuarios','UsuariosController');
            Route::post('usuarios','UsuariosController@index');
            // End Routes for usuarios
            // Start Routes for ciudades 
            Route::resource('ciudades','CiudadesController');
            Route::post('ciudades','CiudadesController@index');
            // End Routes for ciudades
            // Start Routes for proveedores 
            Route::resource('proveedores','ProveedoresController');
            Route::post('proveedores','ProveedoresController@index');
            // End Routes for proveedores
            // Start Routes for centrocosto 
            Route::resource('centrocosto','CentrocostoController');
            Route::post('centrocosto','CentrocostoController@index');
            // End Routes for centrocosto
            // Start Routes for archivocombustible 
            Route::resource('archivocombustible','ArchivocombustibleController');
            Route::post('archivocombustible','ArchivocombustibleController@index');
            // End Routes for archivocombustible
            // Start Routes for combustible 
            Route::resource('combustible','CombustibleController');
            Route::post('combustible','CombustibleController@index');
            // End Routes for combustible?>