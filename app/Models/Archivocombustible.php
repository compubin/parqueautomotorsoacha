<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Archivocombustible extends Sximo  {
	
	protected $table = 'archivo_combustible';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
