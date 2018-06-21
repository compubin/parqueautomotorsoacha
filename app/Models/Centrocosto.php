<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Centrocosto extends Sximo  {
	
	protected $table = 'centro_costo';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
