<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class post extends Sximo  {
	
	protected $table = 'tb_pages';
	protected $primaryKey = 'pageID';

	public function __construct() {
		parent::__construct();
		
	}
	public static function comments( $pageID)
	{
		$sql = \DB::select("
			SELECT tb_comments.* ,username , avatar , email
			FROM tb_comments LEFT JOIN tb_users ON tb_users.id = tb_comments.userid
			WHERE pageID ='".$pageID."'
			");
		return $sql;
	}
	public static function latestposts( )
	{
		$sql = \DB::select("
			SELECT * FROM tb_pages WHERE pagetype ='post' ORDER BY created DESC LIMIT 5
			");
		return $sql;
	}
}
