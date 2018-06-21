<?php 

use App\Models\Post;

class CmsHelper 
{

	public function __construct()
	{
		$this->data = json_decode(file_get_contents(base_path().'/resources/views/core/posts/config.json'),true);
	}

	public static function testimonial( $id , $para = '') {

		$output = \DB::table('tb_contents')->where('CmsID',$id)->get();
		if(count($output))
		{
			$row = $output[0];
			$data = array(
				'title'	=> $row->Title ,
				'CmsID'	=> $id ,
				'contents'	=> json_decode($row->Contents,true)	
			);
			//print_r($data);exit;
			return view("Acore.secure.content.public.testimonial",$data);

		} else {
			return 'This is Porpolio';	
		}
		
				
	}

	public static function gallery( $id , $para = '' ) {

		$output = \DB::table('tb_contents')->where('CmsID',$id)->get();
		if(count($output))
		{
			$row = $output[0];
			$data = array(
				'title'	=> $row->Title ,
				'CmsID'	=> $id ,
				'contents'	=> json_decode($row->Contents,true)	
			);
			return view("Acore.secure.content.public.gallery",$data);

		} else {
			return 'This is FAQ';	
		}	
	}	

	public static function faq( $id , $para = '') {

		$output = \DB::table('tb_contents')->where('CmsID',$id)->get();
		if(count($output))
		{
			$row = $output[0];
			$data = array(
				'title'	=> $row->Title ,
				'CmsID'	=> $id ,
				'contents'	=> json_decode($row->Contents,true)	
			);
			return view("Acore.secure.content.public.faq",$data);

		} else {
			return 'This is FAQ';	
		}
					
	}	
	
}