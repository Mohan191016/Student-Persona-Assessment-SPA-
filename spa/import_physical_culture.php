<?php
 // Initialize the session
session_start();

 // Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
{
	header("location: index.php");
	exit;
}

$batch_code = $batchcode_err = $year_of_study = $year_of_study_err = $department = "";
$berror = 0;

require_once "config.php";


$batch_code = $batchcode_err = "";
$berror = 0;

if(isset($_POST['import']))
{

 	// Validate Batch Code

	if(empty(trim($_POST["batch_code"])))
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Please enter the Batch Code."); location.href="update_physical_culture.php"';
		echo '</script>';
	}
	elseif(!is_numeric(trim($_POST["batch_code"])))
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Batch Code only Contain Numbers."); location.href="update_physical_culture.php"';
		echo '</script>';
	}
	elseif(preg_match('@[^\w]@',trim($_POST["batch_code"])))
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Batch Code only Contain Numbers."); location.href="update_physical_culture.php"';
		echo '</script>';
	}
	elseif(strlen(trim($_POST["batch_code"])) != 4)
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Batch Code must Contain only 4 characters."); location.href="update_physical_culture.php"';
		echo '</script>';
	}
	else
	{
		$batch_code = trim($_POST["batch_code"]);
	}

	//Year of Study Validation

	if (empty(trim($_POST["year_of_study"]))) 
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Please enter the Year of Study."); location.href="update_physical_culture.php"';
		echo '</script>';
	}
	else
	{
		$year_of_study = trim($_POST["year_of_study"]);		
	}

	//validate department

	if (empty(trim($_POST["department"]))) 
	{
		$berror++;
		echo '<script language="javascript">';
		echo'alert("Please enter the Department."); location.href="update_physical_culture.php"';
		echo '</script>';
	}
	else
	{
		$department=trim($_POST["department"]);		
	}

	// import CSV file

	if($berror == 0)
	{

		header('Content-Type: text/csv; charset = utf-8');
		header('Content-Disposition: attachment; filename = student_physical_culture.csv');
		$output = fopen("php://output", "w");

		if($year_of_study == "I Year")
		{
			fputcsv($output, array('ROLL NO','REG NO', 'NAME', 'DEPARTMENT','BATCH CODE', 'I_100_MD', 'I_400_MD', 'I_LONG JUMP', 'I_PULL UPS', 'HEIGHT_JOINING', 'WEIGHT_JOINING'));

			$query = "SELECT roll_no, reg_no, name, major, batch_code from student_personal_details WHERE major = '{$department}' AND batch_code = '{$batch_code}' ORDER BY reg_no";

			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_assoc($result))
			{
				fputcsv($output, $row);
			}
		}
		elseif($year_of_study == "II Year")
		{
			fputcsv($output, array('ROLL NO','REG NO', 'NAME','DEPARTMENT', 'BATCH CODE','II_100_MD', 'II_400_MD', 'II_LONG JUMP', 'II_PULL UPS'));

			$query = "SELECT roll_no, reg_no, name, major,batch_code from student_personal_details WHERE major = '{$department}' AND batch_code = '{$batch_code}' ORDER BY reg_no";

			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_assoc($result))
			{
				fputcsv($output, $row);
			}
		}
		else
		{
			fputcsv($output, array('ROLL NO','REG NO', 'NAME','DEPARTMENT', 'BATCH CODE','III_100_MD', 'III_400_MD', 'III_LONG JUMP', 'III_PULL UPS', 'HEIGHT_LEAVING', 'WEIGHT_LEAVING'));

			$query = "SELECT roll_no, reg_no, name,major, batch_code from student_personal_details WHERE major = '{$department}' AND batch_code = '{$batch_code}' ORDER BY reg_no";

			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_assoc($result))
			{
				fputcsv($output, $row);
			}
		}
		fclose($output);
	}
}


?>