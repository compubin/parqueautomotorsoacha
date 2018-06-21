<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Cilindrajeautomotor extends Sximo  {
	
	protected $table = 'cilindraje_automotor';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
