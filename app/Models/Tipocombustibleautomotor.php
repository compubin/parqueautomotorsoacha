<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Tipocombustibleautomotor extends Sximo  {
	
	protected $table = 'tipo_combustible_automotor';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
