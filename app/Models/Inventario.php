<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Sximo  {
	
	protected $table = 'inventario';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
