<?php namespace App\Library;

class DataTable {

	static function limit ( $request, $columns )
	{
		$limit = array('page'=>'','limit'=>'');
		if(isset($_POST['start'])){
			$page = (intval($_POST['start']) != 0 ? ($_POST['start'] + $_POST['length']) / $_POST['length'] : 1 );
			$limit = array(
				'page'	=> $page ,
				'limit'	=> intval($_POST['length'])
			);
		}
		return $limit;

	}

	static function order ( $request, $columns )
	{
		$order = array('sort'=>'','by'=>'');

		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = self::pluck( $columns, 'dt' );

			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];
				$order = array(
					'sort'		=> $column['db'].'.'.$column['dt'] ,
					'by'		=> $request['order'][$i]['dir'] === 'asc' ?	'ASC' :	'DESC'
				);
			}

		}

		return $order;
	}



	static function simple ( $request,   $columns )
	{
		
		$bindings = array();
		$limit = self::limit( $request, $columns );
		$return = array(
			'page'	=> $limit['page'],
			'limit'	=> $limit['limit'],
			'order'	=> self::order( $request, $columns ),
			//'params'=> self::filter( $request, $columns, $bindings )
		); 
		return $return ;
		
	}


	static function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );

		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);

		return $key;
	}


	static function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			$out[] = $a[$i][$prop];
		}

		return $out;
	}


}

