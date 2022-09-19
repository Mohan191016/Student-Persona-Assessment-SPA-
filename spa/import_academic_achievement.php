<?php
 // Initialize the session
 session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
 {
     header("location: index.php");
     exit;
 }

$batch_code = $batchcode_err = "";
 $berror = $verror = 0;
 
require_once "config.php";

 $major = htmlspecialchars($_SESSION["department"]);

 $batch_code = $batchcode_err = "";
$berror = $verror = 0;

 if(isset($_POST['import']))
 {

 	// Validate Batch Code

 	if(empty(trim($_POST["batch_code"])))
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Please enter the Batch Code."); location.href="update_academic_achievement.php"';
		echo '</script>';
	}
	elseif(!is_numeric(trim($_POST["batch_code"])))
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Batch Code only Contain Numbers."); location.href="update_academic_achievement.php"';
		echo '</script>';
	}
	elseif(preg_match('@[^\w]@',trim($_POST["batch_code"])))
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Batch Code only Contain Numbers."); location.href="update_academic_achievement.php"';
		echo '</script>';
	}
	elseif(strlen(trim($_POST["batch_code"])) != 4)
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Batch Code must Contain only 4 characters."); location.href="update_academic_achievement.php"';
		echo '</script>';
	}
	else
	{
		$batch_code = trim($_POST["batch_code"]);
	}

	// import CSV file

	if($berror == 0)
	{

	header('Content-Type: text/csv; charset = utf-8');
	header('Content-Disposition: attachment; filename = student_academic_achievement.csv');
	$output = fopen("php://output", "w");

	fputcsv($output, array('ROLL NO', 'NAME','REG NO', 'PART1-K', 'PART1-U', 'PART1-R', 'PART1-P','PART2-K', 'PART2-U', 'PART2-R', 'PART2-P', 'PART3-MK','PART3-MU','PART3-MR','PART3-MP','PART3-AAK','PART3-AAU','PART3-AAR','PART3-AAP','PART3-ABK','PART3-ABU','PART3-ABR','PART3-ABP'));
	
	$query = "SELECT roll_no, name, reg_no from student_personal_details WHERE major = '{$major}' AND batch_code = '{$batch_code}' ORDER BY roll_no";

	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($result))
	{
		fputcsv($output, $row);
	}
	fclose($output);
	}
}

?>