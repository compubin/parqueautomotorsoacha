<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Colorautomotor extends Sximo  {
	
	protected $table = 'color_automotor';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}
