<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Secretaria extends Sximo  {
	
	protected $table = 'secretaria';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
