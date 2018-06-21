<?php

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.$title.'-data.'.strtotime(date("d-m-Y")).'.csv');


// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

$head= array();
foreach($fields as $key=>$val )
{
	$head[] = $val;
}

fputcsv($output, $head);


foreach ($rows as $row)
{
	$content= array();
	foreach($fields as $key=>$val )
	{

		$content[]= $row[$key] ;

	}
	fputcsv($output,$content);	
}	

