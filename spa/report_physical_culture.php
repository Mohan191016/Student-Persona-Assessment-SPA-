<?php
 // Initialize the session
 session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
 {
     header("location: index.php");
     exit;
 }

 require_once "config.php";

$batchcode = $batchcode_err = $department = $department_err = $year_of_study = $year_of_study_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

 	// Validate Batch Code

	if(empty(trim($_POST["batch_code"])))
	{
		$batchcode_err = "Please enter the Student Batch Code.";
	}
	elseif(!is_numeric(trim($_POST["batch_code"])))
	{
		$batchcode_err = "Student Batch Code only Contain Numbers.";
	}
	elseif(preg_match('@[^\w]@',trim($_POST["batch_code"])))
	{
		$batchcode_err = "Student Batch Code only Contain Numbers.";
	}
	elseif(strlen(trim($_POST["batch_code"])) != 4)
	{
		$batchcode_err = "Student Batch Code must Contain only 4 characters.";
	}
	else
	{
		$batchcode = trim($_POST["batch_code"]);
	}

	 // Department Validation

	if (empty(trim($_POST["department"]))) 
	{
		$department_err = " Please select Department.";
	}
	else
	{
		$department=trim($_POST["department"]);		
	}

	// Year of Study Validation

	if (empty(trim($_POST["att_year_of_study"]))) 
	{
		$year_of_study_err = " Please select Year of Study.";
	}
	else
	{
		$year_of_study = trim($_POST["att_year_of_study"]);		
	}

	//Generate PDF

	if(empty($batchcode_err) && empty($department_err) && empty($year_of_study_err))
	{
		ob_start();
		require("fpdf/fpdf.php");
		$pdf = new FPDF('p','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B','12');

		if($year_of_study == "I Year") 
		{
		
					$sql = "SELECT roll_no, name, I_100_MD, I_400_MD, I_long_jump, I_pull_ups FROM student_physical_culture WHERE batch_code = '$batchcode' AND major = '$department'";
					$res = $link->query($sql);

					if($res->num_rows>0)
					{
						$i = 0;
						while ($row=$res->fetch_assoc()) 
						{

							$roll_no = $row["roll_no"];
							$name = $row["name"];

							$i++;

							$pdf->cell(12,8,$i,0,0,'L');

							$pdf->cell(25,8,'Roll No: ',0,0,'L');
							$pdf->cell(25,8,$row["roll_no"],0,0,'L');

							$pdf->cell(35,8,'Name:',0,0,'L');
							$pdf->cell(80,8,$row["name"],0,1,'L');

							$pdf->cell(65,8,'Events',1,0,'C');
							$pdf->cell(35,8,'Achieved',1,0,'C');
							$pdf->cell(65,8,'Mark',1,1,'C');

							$I_md_100 = $row["I_100_MD"];

							$pdf->cell(65,8,'100 Metre Dash (in Seconds) ',1,0,'L');
							$pdf->cell(35,8,$row["I_100_MD"],1,0,'C');

							if($I_md_100 >= 17.01)
							{
								$mark_100 = 2; 
							}
							elseif($I_md_100 >= 15.01) 
							{
								$mark_100 = 4;
							}
							elseif($I_md_100 >= 13.01) 
							{
								$mark_100 = 6;
							}
							elseif($I_md_100 >= 11.01) 
							{
								$mark_100 = 8;
							}
							elseif($I_md_100 >= 1.00) 
							{
								$mark_100 = 10;
							}
							else
							{
								$mark_100 = "RA";
							}

							$pdf->cell(65,8,$mark_100,1,1,'C');

							$I_md_400 = $row["I_400_MD"];

							$pdf->cell(65,8,'400 Metre Dash (in Seconds) ',1,0,'L');
							$pdf->cell(35,8,$row["I_400_MD"],1,0,'C');

							if($I_md_400 >= 1.31)
							{
								$mark_400 = 2; 
							}
							elseif($I_md_400 >= 1.21) 
							{
								$mark_400 = 4;
							}
							elseif($I_md_400 >= 1.11) 
							{
								$mark_400 = 6;
							}
							elseif($I_md_400 >= 1.01) 
							{
								$mark_400 = 8;
							}
							elseif($I_md_400 >= 1.00) 
							{
								$mark_400 = 10;
							}
							else
							{
								$mark_400 = "RA";
							}

							$pdf->cell(65,8,$mark_400,1,1,'C');

							$I_long_jump = $row['I_long_jump'];

							$pdf->cell(65,8,'Long Jump (in Metre) ',1,0,'L');
							$pdf->cell(35,8,$row["I_long_jump"],1,0,'C');

							if($I_long_jump <= 0)
							{
								$long_jump = "RA"; 
							}
							elseif($I_long_jump <= 1.00)
							{
								$long_jump = 2; 
							}
							elseif($I_long_jump <= 3.99) 
							{
								$long_jump = 4;
							}
							elseif($I_long_jump <= 4.49) 
							{
								$long_jump = 6;
							}
							elseif($I_long_jump <= 4.99) 
							{
								$long_jump = 8;
							}
							elseif($I_long_jump >= 5.00) 
							{
								$long_jump = 10;
							}

							$pdf->cell(65,8,$long_jump,1,1,'C');

							$I_pull_ups = $row['I_pull_ups'];

							$pdf->cell(65,8,'Pull Ups (in Numbers) ',1,0,'L');
							$pdf->cell(35,8,$row["I_pull_ups"],1,0,'C');

							if($I_pull_ups <= 0)
							{
								$pull_ups = "RA"; 
							}
							elseif($I_pull_ups <= 3)
							{
								$pull_ups = 2; 
							}
							elseif($I_pull_ups <= 5) 
							{
								$pull_ups = 4;
							}
							elseif($I_pull_ups <= 7) 
							{
								$pull_ups = 6;
							}
							elseif($I_pull_ups <= 9) 
							{
								$pull_ups = 8;
							}
							elseif($I_pull_ups >= 10) 
							{
								$pull_ups = 10;
							}

							$pdf->cell(65,8,$pull_ups,1,1,'C');

							$pdf->cell(100,8,'TOTAL ',1,0,'R');

							if($mark_100 == "RA" || $mark_400 == "RA" || $long_jump == "RA" || $pull_ups == "RA")
							{
								$pdf->cell(65,8,"RA",1,1,'C');
							}
							else
							{
								$total = $mark_100 + $mark_400 + $long_jump + $pull_ups;
								$pdf->cell(65,8,"$total / 40",1,1,'C');
							}
						}
					}
		}
/**********************************************************************************************************************************/

		if($year_of_study == "II Year") 
		{
		
					$sql = "SELECT roll_no, name, II_100_MD, II_400_MD, II_long_jump, II_pull_ups FROM student_physical_culture WHERE batch_code = '$batchcode' AND major = '$department'";
					$res = $link->query($sql);

					if($res->num_rows>0)
					{
						$i = 0;
						while ($row=$res->fetch_assoc()) 
						{

							$roll_no = $row["roll_no"];
							$name = $row["name"];

							$i++;

							$pdf->cell(12,8,$i,0,0,'L');

							$pdf->cell(25,8,'Roll No: ',0,0,'L');
							$pdf->cell(25,8,$row["roll_no"],0,0,'L');

							$pdf->cell(35,8,'Name:',0,0,'L');
							$pdf->cell(80,8,$row["name"],0,1,'L');

							$pdf->cell(65,8,'Events',1,0,'C');
							$pdf->cell(35,8,'Achieved',1,0,'C');
							$pdf->cell(65,8,'Mark',1,1,'C');

							$II_md_100 = $row["II_100_MD"];

							$pdf->cell(65,8,'100 Metre Dash (in Seconds) ',1,0,'L');
							$pdf->cell(35,8,$row["II_100_MD"],1,0,'C');

							if($II_md_100 >= 17.01)
							{
								$mark_100 = 2; 
							}
							elseif($II_md_100 >= 15.01) 
							{
								$mark_100 = 4;
							}
							elseif($II_md_100 >= 13.01) 
							{
								$mark_100 = 6;
							}
							elseif($II_md_100 >= 11.01) 
							{
								$mark_100 = 8;
							}
							elseif($II_md_100 >= 1.00) 
							{
								$mark_100 = 10;
							}
							else
							{
								$mark_100 = "RA";
							}

							$pdf->cell(65,8,$mark_100,1,1,'C');

							$II_md_400 = $row["II_400_MD"];

							$pdf->cell(65,8,'400 Metre Dash (in Seconds) ',1,0,'L');
							$pdf->cell(35,8,$row["II_400_MD"],1,0,'C');

							if($II_md_400 >= 1.31)
							{
								$mark_400 = 2; 
							}
							elseif($II_md_400 >= 1.21) 
							{
								$mark_400 = 4;
							}
							elseif($II_md_400 >= 1.11) 
							{
								$mark_400 = 6;
							}
							elseif($II_md_400 >= 1.01) 
							{
								$mark_400 = 8;
							}
							elseif($II_md_400 >= 1.00) 
							{
								$mark_400 = 10;
							}
							else
							{
								$mark_400 = "RA";
							}

							$pdf->cell(65,8,$mark_400,1,1,'C');

							$II_long_jump = $row['II_long_jump'];

							$pdf->cell(65,8,'Long Jump (in Metre) ',1,0,'L');
							$pdf->cell(35,8,$row["II_long_jump"],1,0,'C');

							if($II_long_jump <= 0)
							{
								$long_jump = "RA"; 
							}
							elseif($II_long_jump <= 1.00)
							{
								$long_jump = 2; 
							}
							elseif($II_long_jump <= 3.99) 
							{
								$long_jump = 4;
							}
							elseif($II_long_jump <= 4.49) 
							{
								$long_jump = 6;
							}
							elseif($II_long_jump <= 4.99) 
							{
								$long_jump = 8;
							}
							elseif($II_long_jump >= 5.00) 
							{
								$long_jump = 10;
							}

							$pdf->cell(65,8,$long_jump,1,1,'C');

							$II_pull_ups = $row['II_pull_ups'];

							$pdf->cell(65,8,'Pull Ups (in Numbers) ',1,0,'L');
							$pdf->cell(35,8,$row["II_pull_ups"],1,0,'C');

							if($II_pull_ups <= 0)
							{
								$pull_ups = "RA"; 
							}
							elseif($II_pull_ups <= 3)
							{
								$pull_ups = 2; 
							}
							elseif($II_pull_ups <= 5) 
							{
								$pull_ups = 4;
							}
							elseif($II_pull_ups <= 7) 
							{
								$pull_ups = 6;
							}
							elseif($II_pull_ups <= 9) 
							{
								$pull_ups = 8;
							}
							elseif($II_pull_ups >= 10) 
							{
								$pull_ups = 10;
							}

							$pdf->cell(65,8,$pull_ups,1,1,'C');

							$pdf->cell(100,8,'TOTAL ',1,0,'R');

							if($mark_100 == "RA" || $mark_400 == "RA" || $long_jump == "RA" || $pull_ups == "RA")
							{
								$pdf->cell(65,8,"RA",1,1,'C');
							}
							else
							{
								$total = $mark_100 + $mark_400 + $long_jump + $pull_ups;
								$pdf->cell(65,8,"$total / 40",1,1,'C');
							}
						}
					}
		}

/**********************************************************************************************************************************/
		if($year_of_study == "III Year") 
		{
		
					$sql = "SELECT roll_no, name, III_100_MD, III_400_MD, III_long_jump, III_pull_ups FROM student_physical_culture WHERE batch_code = '$batchcode' AND major = '$department'";
					$res = $link->query($sql);

					if($res->num_rows>0)
					{
						$i = 0;
						while ($row=$res->fetch_assoc()) 
						{

							$roll_no = $row["roll_no"];
							$name = $row["name"];

							$i++;

							$pdf->cell(12,8,$i,0,0,'L');

							$pdf->cell(25,8,'Roll No: ',0,0,'L');
							$pdf->cell(25,8,$row["roll_no"],0,0,'L');

							$pdf->cell(35,8,'Name:',0,0,'L');
							$pdf->cell(80,8,$row["name"],0,1,'L');

							$pdf->cell(65,8,'Events',1,0,'C');
							$pdf->cell(35,8,'Achieved',1,0,'C');
							$pdf->cell(65,8,'Mark',1,1,'C');

							$III_md_100 = $row["III_100_MD"];

							$pdf->cell(65,8,'100 Metre Dash (in Seconds) ',1,0,'L');
							$pdf->cell(35,8,$row["III_100_MD"],1,0,'C');

							if($III_md_100 >= 17.01)
							{
								$mark_100 = 2; 
							}
							elseif($III_md_100 >= 15.01) 
							{
								$mark_100 = 4;
							}
							elseif($III_md_100 >= 13.01) 
							{
								$mark_100 = 6;
							}
							elseif($III_md_100 >= 11.01) 
							{
								$mark_100 = 8;
							}
							elseif($III_md_100 >= 1.00) 
							{
								$mark_100 = 10;
							}
							else
							{
								$mark_100 = "RA";
							}

							$pdf->cell(65,8,$mark_100,1,1,'C');

							$III_md_400 = $row["III_400_MD"];

							$pdf->cell(65,8,'400 Metre Dash (in Seconds) ',1,0,'L');
							$pdf->cell(35,8,$row["III_400_MD"],1,0,'C');

							if($III_md_400 >= 1.31)
							{
								$mark_400 = 2; 
							}
							elseif($III_md_400 >= 1.21) 
							{
								$mark_400 = 4;
							}
							elseif($III_md_400 >= 1.11) 
							{
								$mark_400 = 6;
							}
							elseif($III_md_400 >= 1.01) 
							{
								$mark_400 = 8;
							}
							elseif($III_md_400 >= 1.00) 
							{
								$mark_400 = 10;
							}
							else
							{
								$mark_400 = "RA";
							}

							$pdf->cell(65,8,$mark_400,1,1,'C');

							$III_long_jump = $row['III_long_jump'];

							$pdf->cell(65,8,'Long Jump (in Metre) ',1,0,'L');
							$pdf->cell(35,8,$row["III_long_jump"],1,0,'C');

							if($III_long_jump <= 0)
							{
								$long_jump = "RA"; 
							}
							elseif($III_long_jump <= 1.00)
							{
								$long_jump = 2; 
							}
							elseif($III_long_jump <= 3.99) 
							{
								$long_jump = 4;
							}
							elseif($III_long_jump <= 4.49) 
							{
								$long_jump = 6;
							}
							elseif($III_long_jump <= 4.99) 
							{
								$long_jump = 8;
							}
							elseif($III_long_jump >= 5.00) 
							{
								$long_jump = 10;
							}

							$pdf->cell(65,8,$long_jump,1,1,'C');

							$III_pull_ups = $row['III_pull_ups'];

							$pdf->cell(65,8,'Pull Ups (in Numbers) ',1,0,'L');
							$pdf->cell(35,8,$row["III_pull_ups"],1,0,'C');

							if($III_pull_ups <= 0)
							{
								$pull_ups = "RA"; 
							}
							elseif($III_pull_ups <= 3)
							{
								$pull_ups = 2; 
							}
							elseif($III_pull_ups <= 5) 
							{
								$pull_ups = 4;
							}
							elseif($III_pull_ups <= 7) 
							{
								$pull_ups = 6;
							}
							elseif($III_pull_ups <= 9) 
							{
								$pull_ups = 8;
							}
							elseif($III_pull_ups >= 10) 
							{
								$pull_ups = 10;
							}

							$pdf->cell(65,8,$pull_ups,1,1,'C');

							$pdf->cell(100,8,'TOTAL ',1,0,'R');
							if($mark_100 == "RA" || $mark_400 == "RA" || $long_jump == "RA" || $pull_ups == "RA")
							{
								$pdf->cell(65,8,"RA",1,1,'C');
							}
							else
							{
								$total = $mark_100 + $mark_400 + $long_jump + $pull_ups;
								$pdf->cell(65,8,"$total / 40",1,1,'C');
							}
						}

					}
		}
/*********************************************************************************************************************************/
		
if($year_of_study == "Final") 
		{
		
		$pdf = new FPDF('l','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B','12');

					$sql = "SELECT * FROM student_physical_culture WHERE batch_code = '$batchcode' AND major = '$department'";
					$res = $link->query($sql);

					if($res->num_rows>0)
					{
						$i = 0;
						while ($row=$res->fetch_assoc()) 
						{

							$roll_no = $row["roll_no"];
							$name = $row["name"];

							$i++;

							$pdf->cell(12,8,$i,0,0,'L');

							$pdf->cell(25,8,'Roll No: ',0,0,'L');
							$pdf->cell(25,8,$row["roll_no"],0,0,'L');

							$pdf->cell(35,8,'Name:',0,0,'L');
							$pdf->cell(80,8,$row["name"],0,1,'L');


							$pdf->cell(65,8,'Performance',1,0,'C');
							$pdf->cell(30,8,'I Year',1,0,'C');
							$pdf->cell(30,8,'I Year Mark',1,0,'C');
							$pdf->cell(30,8,'II Year',1,0,'C');
							$pdf->cell(30,8,'II Year Mark',1,0,'C');
							$pdf->cell(30,8,'III Year',1,0,'C');
							$pdf->cell(30,8,'III Year Mark',1,0,'C');
							$pdf ->cell(35,8,'Consolidate',1,1,'C');

							$pdf->cell(65,8,'100 Metre Dash (in Seconds) ',1,0,'L');

							// I Year 

							$I_md_100 = $row["I_100_MD"];

							$pdf->cell(30,8,$row["I_100_MD"],1,0,'C');

							if($I_md_100 >= 17.01)
							{
								$I_mark_100 = 2; 
							}
							elseif($I_md_100 >= 15.01) 
							{
								$I_mark_100 = 4;
							}
							elseif($I_md_100 >= 13.01) 
							{
								$I_mark_100 = 6;
							}
							elseif($I_md_100 >= 11.01) 
							{
								$I_mark_100 = 8;
							}
							elseif($I_md_100 >= 1.00) 
							{
								$I_mark_100 = 10;
							}
							else
							{
								$I_mark_100 = "RA";
							}

							$pdf->cell(30,8,$I_mark_100,1,0,'C');

							//II Year

							$II_md_100 = $row["II_100_MD"];

							$pdf->cell(30,8,$row["II_100_MD"],1,0,'C');

							if($II_md_100 >= 17.01)
							{
								$II_mark_100 = 2; 
							}
							elseif($II_md_100 >= 15.01) 
							{
								$II_mark_100 = 4;
							}
							elseif($II_md_100 >= 13.01) 
							{
								$II_mark_100 = 6;
							}
							elseif($II_md_100 >= 11.01) 
							{
								$II_mark_100 = 8;
							}
							elseif($II_md_100 >= 1.00) 
							{
								$II_mark_100 = 10;
							}
							else
							{
								$II_mark_100 = "RA";
							}

							$pdf->cell(30,8,$II_mark_100,1,0,'C');

							//III Year

							$III_md_100 = $row["III_100_MD"];

							$pdf->cell(30,8,$row["III_100_MD"],1,0,'C');

							if($III_md_100 >= 17.01)
							{
								$III_mark_100 = 2; 
							}
							elseif($III_md_100 >= 15.01) 
							{
								$III_mark_100 = 4;
							}
							elseif($III_md_100 >= 13.01) 
							{
								$III_mark_100 = 6;
							}
							elseif($III_md_100 >= 11.01) 
							{
								$III_mark_100 = 8;
							}
							elseif($III_md_100 >= 1.00) 
							{
								$III_mark_100 = 10;
							}
							else
							{
								$III_mark_100 = "RA";
							}

							$pdf->cell(30,8,$III_mark_100,1,0,'C');

							if($I_mark_100 == "RA" || $II_mark_100 == "RA" || $III_mark_100 == "RA")
							{
								$round_average_100m = "RA";
								$pdf->cell(35,8,"RA",1,1,'C');
							}
							else
							{
								$total = $I_mark_100 + $II_mark_100 + $III_mark_100;
								$average = $total/3;
								$round_average_100m = round($average,2);
								$pdf->cell(35,8,"$round_average_100m",1,1,'C');
							}

							$pdf->cell(65,8,'400 Metre Dash (in Seconds) ',1,0,'L');

							//I Year

							$I_md_400 = $row["I_400_MD"];

							$pdf->cell(30,8,$row["I_400_MD"],1,0,'C');

							if($I_md_400 >= 1.31)
							{
								$I_mark_400 = 2; 
							}
							elseif($I_md_400 >= 1.21) 
							{
								$I_mark_400 = 4;
							}
							elseif($I_md_400 >= 1.11) 
							{
								$I_mark_400 = 6;
							}
							elseif($I_md_400 >= 1.01) 
							{
								$I_mark_400 = 8;
							}
							elseif($I_md_400 >= 1.00) 
							{
								$I_mark_400 = 10;
							}
							else
							{
								$I_mark_400 = "RA";
							}

							$pdf->cell(30,8,$I_mark_400,1,0,'C');

							//II Year

							$II_md_400 = $row["II_400_MD"];

							$pdf->cell(30,8,$row["II_400_MD"],1,0,'C');

							if($II_md_400 >= 1.31)
							{
								$II_mark_400 = 2; 
							}
							elseif($II_md_400 >= 1.21) 
							{
								$II_mark_400 = 4;
							}
							elseif($II_md_400 >= 1.11) 
							{
								$II_mark_400 = 6;
							}
							elseif($II_md_400 >= 1.01) 
							{
								$II_mark_400 = 8;
							}
							elseif($II_md_400 >= 1.00) 
							{
								$II_mark_400 = 10;
							}
							else
							{
								$II_mark_400 = "RA";
							}

							$pdf->cell(30,8,$II_mark_400,1,0,'C');

							//III Year

							$III_md_400 = $row["III_400_MD"];

							$pdf->cell(30,8,$row["III_400_MD"],1,0,'C');

							if($III_md_400 >= 1.31)
							{
								$III_mark_400 = 2; 
							}
							elseif($III_md_400 >= 1.21) 
							{
								$III_mark_400 = 4;
							}
							elseif($III_md_400 >= 1.11) 
							{
								$III_mark_400 = 6;
							}
							elseif($III_md_400 >= 1.01) 
							{
								$III_mark_400 = 8;
							}
							elseif($III_md_400 >= 1.00) 
							{
								$III_mark_400 = 10;
							}
							else
							{
								$III_mark_400 = "RA";
							}

							$pdf->cell(30,8,$III_mark_400,1,0,'C');

							if($I_mark_400 == "RA" || $II_mark_400 == "RA" || $III_mark_400 == "RA")
							{
								$round_average_400m = "RA";
								$pdf->cell(35,8,"RA",1,1,'C');
							}
							else
							{
								$total = $I_mark_400 + $II_mark_400 + $III_mark_400;
								$average = $total/3;
								$round_average_400m = round($average,2);
								$pdf->cell(35,8,"$round_average_400m",1,1,'C');
							}

							$pdf->cell(65,8,'Long Jump (in Metre) ',1,0,'L');

							// I Year

							$I_long_jump = $row['I_long_jump'];

							$pdf->cell(30,8,$row["I_long_jump"],1,0,'C');

							if($I_long_jump <= 0)
							{
								$I_longjump = "RA"; 
							}
							elseif($I_long_jump <= 1.00)
							{
								$I_longjump = 2; 
							}
							elseif($I_long_jump <= 3.99) 
							{
								$I_longjump = 4;
							}
							elseif($I_long_jump <= 4.49) 
							{
								$I_longjump = 6;
							}
							elseif($I_long_jump <= 4.99) 
							{
								$I_longjump = 8;
							}
							elseif($I_long_jump >= 5.00) 
							{
								$I_longjump = 10;
							}

							$pdf->cell(30,8,$I_longjump,1,0,'C');

							//II Year

							$II_long_jump = $row['II_long_jump'];

							$pdf->cell(30,8,$row["II_long_jump"],1,0,'C');

							if($II_long_jump <= 0)
							{
								$II_longjump = "RA"; 
							}
							elseif($II_long_jump <= 1.00)
							{
								$II_longjump = 2; 
							}
							elseif($II_long_jump <= 3.99) 
							{
								$II_longjump = 4;
							}
							elseif($II_long_jump <= 4.49) 
							{
								$II_longjump = 6;
							}
							elseif($II_long_jump <= 4.99) 
							{
								$II_longjump = 8;
							}
							elseif($II_long_jump >= 5.00) 
							{
								$II_longjump = 10;
							}

							$pdf->cell(30,8,$II_longjump,1,0,'C');

							// III Year

							$III_long_jump = $row['III_long_jump'];

							$pdf->cell(30,8,$row["III_long_jump"],1,0,'C');

							if($III_long_jump <= 0)
							{
								$III_longjump = "RA"; 
							}
							elseif($III_long_jump <= 1.00)
							{
								$III_longjump = 2; 
							}
							elseif($III_long_jump <= 3.99) 
							{
								$III_longjump = 4;
							}
							elseif($III_long_jump <= 4.49) 
							{
								$III_longjump = 6;
							}
							elseif($III_long_jump <= 4.99) 
							{
								$III_longjump = 8;
							}
							elseif($III_long_jump >= 5.00) 
							{
								$III_longjump = 10;
							}

							$pdf->cell(30,8,$III_longjump,1,0,'C');

							if($I_longjump == "RA" || $II_longjump == "RA" || $III_longjump == "RA")
							{
								$round_average_longjump = "RA";
								$pdf->cell(35,8,"RA",1,1,'C');
							}
							else
							{
								$total = $I_longjump + $II_longjump + $III_longjump;
								$average = $total/3;
								$round_average_longjump = round($average,2);
								$pdf->cell(35,8,"$round_average_longjump",1,1,'C');
							}

							$pdf->cell(65,8,'Pull Ups (in Numbers) ',1,0,'L');

							// I Year

							$I_pull_ups = $row['I_pull_ups'];

							$pdf->cell(30,8,$row["I_pull_ups"],1,0,'C');

							if($I_pull_ups <= 0)
							{
								$I_pullups = "RA"; 
							}
							elseif($I_pull_ups <= 3)
							{
								$I_pullups = 2; 
							}
							elseif($I_pull_ups <= 5) 
							{
								$I_pullups = 4;
							}
							elseif($I_pull_ups <= 7) 
							{
								$I_pullups = 6;
							}
							elseif($I_pull_ups <= 9) 
							{
								$I_pullups = 8;
							}
							elseif($I_pull_ups >= 10) 
							{
								$I_pullups = 10;
							}

							$pdf->cell(30,8,$I_pullups,1,0,'C');

							// II Year

							$II_pull_ups = $row['II_pull_ups'];

							$pdf->cell(30,8,$row["II_pull_ups"],1,0,'C');

							if($II_pull_ups <= 0)
							{
								$II_pullups = "RA"; 
							}
							elseif($II_pull_ups <= 3)
							{
								$II_pullups = 2; 
							}
							elseif($II_pull_ups <= 5) 
							{
								$II_pullups = 4;
							}
							elseif($II_pull_ups <= 7) 
							{
								$II_pullups = 6;
							}
							elseif($II_pull_ups <= 9) 
							{
								$II_pullups = 8;
							}
							elseif($II_pull_ups >= 10) 
							{
								$II_pullups = 10;
							}

							$pdf->cell(30,8,$II_pullups,1,0,'C');
							
							// III Year
							
							$III_pull_ups = $row['III_pull_ups'];

							$pdf->cell(30,8,$row["III_pull_ups"],1,0,'C');

							if($III_pull_ups <= 0)
							{
								$III_pullups = "RA"; 
							}
							elseif($III_pull_ups <= 3)
							{
								$III_pullups = 2; 
							}
							elseif($III_pull_ups <= 5) 
							{
								$III_pullups = 4;
							}
							elseif($III_pull_ups <= 7) 
							{
								$III_pullups = 6;
							}
							elseif($III_pull_ups <= 9) 
							{
								$III_pullups = 8;
							}
							elseif($III_pull_ups >= 10) 
							{
								$III_pullups = 10;
							}

							$pdf->cell(30,8,$III_pullups,1,0,'C');

							if($I_pullups == "RA" || $II_pullups == "RA" || $III_pullups == "RA")
							{
								$round_average_pullups = "RA";
								$pdf->cell(35,8,"RA",1,1,'C');
							}
							else
							{
								$total = $I_pullups + $II_pullups + $III_pullups;
								$average = $total/3;
								$round_average_pullups = round($average,2);
								$pdf->cell(35,8,"$round_average_pullups",1,1,'C');
							}


							$pdf->cell(215,8,' ',0,0,'R');
							$pdf->cell(30,8,'TOTAL ',1,0,'R');

							if($round_average_100m == "RA" || $round_average_400m == "RA" || $round_average_longjump == "RA" || $round_average_pullups == "RA")
							{
								$pdf->cell(35,8,"RA",1,1,'C');
							}
							else
							{
								$total = $round_average_100m + $round_average_400m + $round_average_longjump + $round_average_pullups;
								$pdf->cell(35,8,"$total / 40",1,1,'C');
							}

							$pdf -> Ln(5);
						}

					}
					else
					{
						$pdf->cell(275,8,"No Student Founded...!",1,1,'C');
					}
					$pdf->output();
					ob_end_flush();
		}
/*********************************************************************************************************************************/
		$pdf->output();
		ob_end_flush();
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" type="text/css" href="stylesheet/homepage.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Physical Culture</title>
</head>
<style type="text/css">
	#navtabs
	{
		font-weight: bold;
	}
	#cnavtabs
	{
		color: dimgrey;
	}
	#footer 
{
   position: bottom;
   bottom: 0;
   width: 100%;
   text-align: center;
   background: #e8e8e8;
   border-top: 1px solid #d2d6de;
   color: #087ec2;
   padding: 15px;
}
</style>
<body>
	
	<!-- navbar start -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="ahome.php">
			<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="lable">VIVEKANANDA COLLEGE - Department of Physical Education</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- navbar end -->

	<!-- breadcrumb start -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb" id="breadcrumb">
				<li class="breadcrumb-item"><a href="hand_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Physical Culture</li>
			</ol>
		</nav>
	</div>

	<!-- breadcrumb end -->

	<!-- main container start -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-trophy fa-lg"></i> <span>Student Physical Culture</span></h6>
					</div>
					<div class = "card-body">
					<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link" href="update_physical_culture.php" id="cnavtabs">Update Physical Culture</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" href="report_physical_culture.php" id="navtabs" >Physical Culture Report</a>
								</li>
							</ul>
						<div class = "card-body">
							<div class="container-fluid"><br>
								<div class="row justify-content-center">
									<div class="col-sm-5 col-sm-5">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-address-book"></i> Physical Culture Report</h6>
											</div>

											<div class="card-body" style="height: 350px">
												<!-- batch -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="batchcode"><span style="color: red">* </span>Batch Code</label>
													<input type="text" name="batch_code" class="form-control <?php echo (!empty($batchcode_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $batchcode; ?>" id="batchcode" placeholder="Enter Batch Code">
													<span class="invalid-feedback"><?php echo $batchcode_err; ?></span>
												</div>

												<!-- department -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="department"><span style="color: red">* </span>Department</label>
													<select name="department" class="custom-select <?php echo (!empty($department_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $department; ?>"id="department">
														<option value="">---Select Department---</option>
														<option value="Economics" 
														
														<?php 
														if($department == 'Economics') 
														{ 
															echo "selected"; 
														} 
														?>

														>Economics</option>
														<option value="History"

														<?php 
														if($department == 'History')
														{
															echo "selected";
														}
														?>

														>History</option>
														<option value="Commerce"

														<?php 
														if($department == 'Commerce')
														{
															echo "selected";
														}
														?>

														>Commerce</option>
														<option value="Mathematics"

														<?php 
														if($department == 'Mathematics')
														{
															echo "selected";
														}
														?>

														>Mathematics</option>
														<option value="Physics"

														<?php 
														if($department == 'Physics')
														{
															echo "selected";
														}
														?>

														>Physics</option>
														<option value="Chemistry"

														<?php 
														if($department == 'Chemistry')
														{
															echo "selected";
														}
														?>

														>Chemistry</option>
														<option value="Botany"

														<?php 
														if($department == 'Botany')
														{
															echo "selected";
														}
														?>

														>Botany</option>
														<option value="Zoology"

														<?php 
														if($department == 'Zoology')
														{
															echo "selected";
														}
														?>

														>Zoology</option>
														<option value="Computer Science"

														<?php 
														if($department == 'Computer Science')
														{
															echo "selected";
														}
														?>

														>Computer Science</option>
														<option value="Commerce (CA)"

														<?php 
														if($department == 'Commerce (CA)')
														{
															echo "selected";
														}
														?>

														>Commerce (CA)</option>
													</select>
													<span class="invalid-feedback"><?php echo $department_err; ?></span>
												</div>
												<div>

													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="year"> <span style="color: red">* </span>Year of Study</label>
													<select name="att_year_of_study" class="custom-select <?php echo (!empty($year_of_study_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year_of_study; ?>"id="year">
														<option value="">---Select Year Of Study---</option>
														<option value="I Year" 

														<?php 
														if($year_of_study == 'I Year') 
														{ 
															echo "selected"; 
														} 
														?>

														>I Year</option>
														<option value="II Year"

														<?php 
														if($year_of_study == 'II Year')
														{
															echo "selected";
														}
														?>

														>II Year</option>
														<option value="III Year"

														<?php 
														if($year_of_study == 'III Year')
														{
															echo "selected";
														}
														?>

														>III Year</option>
														<option value="Final"

														<?php 
														if($year_of_study == 'Final')
														{
															echo "selected";
														}
														?>

														>Consolidate</option>
													</select>
													<span class="invalid-feedback"><?php echo $year_of_study_err; ?></span>
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

						</div><br>
					<div class="card-footer">
						<a href="hand_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
							<button style="float: right;" class="btn btn-success" name="report"> <i class = "fa fa-download" aria-hidden="ture"></i>&nbsp;&nbsp;Download </button>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div><br>

	<!-- main container end -->

	<!-- footer -->

	<div id="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>