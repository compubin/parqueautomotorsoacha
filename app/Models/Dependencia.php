<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Sximo  {
	
	protected $table = 'dependencia';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
