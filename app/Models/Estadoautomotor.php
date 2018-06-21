<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Estadoautomotor extends Sximo  {
	
	protected $table = 'estado_automotor';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
