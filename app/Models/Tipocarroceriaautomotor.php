<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Tipocarroceriaautomotor extends Sximo  {
	
	protected $table = 'tipo_carroceria_automotor';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
