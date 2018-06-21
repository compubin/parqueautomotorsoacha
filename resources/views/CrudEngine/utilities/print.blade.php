<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body onload="window.print()">
<?php

$content = '' ;
$content .= '<table class="table table-striped table-bordered">';
$content .= '<tr>';

foreach($fields as $key=>$val )
{
	$content .= '<th style="background:#f9f9f9;">'. $val . '</th>';
}
$content .= '</tr>';

foreach ($rows as $row)
{
	$content .= '<tr>';
	foreach($fields as $key=>$val )
	{
		$content .= '<td> '.$row[ $key ] . '</td>';
	}
	$content .= '</tr>';
}
$content .= '</table>';	
echo $content;
?>
</body>
</html>


