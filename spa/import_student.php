<?php 

if(isset($_POST['import']))
{
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition:attachment; filename = Add Student.csv');
	$output = fopen("php://output", "w");
	fputcsv($output, array('SL.NO','ROLL NO','NAME','PROGRAMME','MAJOR','BATCH CODE'));
	fclose($output);
}
else
{
	echo '<script language="javascript">';
	echo'alert("File not exported."); location.href="studentmul.php"';
	echo '</script>';
}

?>
