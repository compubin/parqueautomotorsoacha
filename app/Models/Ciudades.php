<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Ciudades extends Sximo  {
	
	protected $table = 'ciudad';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
