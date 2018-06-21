<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Combustible extends Sximo  {
	
	protected $table = 'combustible';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
