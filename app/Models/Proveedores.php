<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Sximo  {
	
	protected $table = 'proveedor';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
