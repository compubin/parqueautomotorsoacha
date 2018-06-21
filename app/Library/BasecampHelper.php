<?php

class BasecampHelper {


	public static function teams( $users , $thumb = 30 ) {

		$results = \DB::table('tb_users')->whereIn('id',explode(",",$users))->get();
		$data = array();
		foreach($results as $row) 
		{
			$data[ $row->id ] = ['avatar'=> \SiteHelpers::avatar(  $thumb , $row->id ) , 'name'=> $row->username ]; 
		}
		return $data;

	}

	public static function progress( $id  ) {
		$row = \DB::select("
			SELECT 
			COUNT(todo_id) AS tasks ,
			SUM(CASE WHEN `status` ='open' THEN 1 ELSE 0 END ) AS opened ,
			SUM(CASE WHEN `status` ='close' THEN 1 ELSE 0 END ) AS closed 	
			FROM basecamp_todo
			LEFT JOIN basecamp_sets ON  basecamp_sets.set_id = basecamp_todo.set_id
			LEFT JOIN basecamp ON  basecamp.camp_id = basecamp_sets.basecamp_id
			WHERE basecamp.camp_id = {$id}

		")[0];
		if(is_null($row->closed)) $row->closed = 0;
		if(is_null($row->opened)) $row->opened = 0;
		$progress = @($row->closed / $row->tasks) * 100;
		return [
			'tasks'		=> $row->tasks,
			'opened'	=> $row->opened,
			'closed'	=> $row->closed,
			'progress'	=> ceil($progress)
		];
	}

	public static function widget(   ) {
		
		$res = \DB::select("
				SELECT * FROM basecamp_todo 
				WHERE FIND_IN_SET(".session('uid').", assigned )
				AND status = 'open'
			");
		return $res ;

	}

}
