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
		$pdf = new FPDF('l','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B','12');

		if(($year_of_study == "I Year") || ($year_of_study == "II Year") || ($year_of_study == "III Year"))
		{

			$sql = "SELECT roll_no, name, reg_no FROM student_personal_details WHERE batch_code = '$batchcode' AND major = '$department' ORDER BY name";
			$res = $link->query($sql);
			if($res->num_rows>0)
			{
				$i = 0;
				while ($row=$res->fetch_assoc()) 
				{
					$roll_no = $row["roll_no"];
					$name = $row["name"];
					$reg_no = $row["reg_no"];

					$i++;

					$pdf->cell(12,8,$i,0,0,'L');

					$pdf->cell(35,8,'Roll No: ',0,0,'L');
					$pdf->cell(35,8,$row["roll_no"],0,0,'L');

					$pdf->cell(35,8,'Reg No: ',0,0,'L');
					$pdf->cell(45,8,$row["reg_no"],0,0,'L');

					$pdf->cell(35,8,'Name:',0,0,'L');
					$pdf->cell(80,8,$row["name"],0,1,'L');

					//Physical Jerks

					$physical_jerks = "Physical Jerks";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$year_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$year_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(12,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Physical Jerks Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}
							
						}
					}

					//Asanas 

					$physical_jerks = "Asanas";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$year_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$year_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(12,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Asanas Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0 ." %",0,1,'L');
							}
						}
					}

					//Mass Drill

					$physical_jerks = "Mass Drill";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$year_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$year_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(12,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Mass Drill Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,0,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,0,'L');
							}

							$pdf -> Ln(15);
						}
					}
				}
			}
		}

/* *********************************************************************************************** */

		else
		{

			$sql = "SELECT roll_no, name, reg_no FROM student_personal_details WHERE batch_code = '$batchcode' AND major = '$department' ORDER BY name";
			$res = $link->query($sql);
			if($res->num_rows>0)
			{
				$i = 0;
				while ($row=$res->fetch_assoc()) 
				{
					$roll_no = $row["roll_no"];
					$name = $row["name"];
					$reg_no = $row["reg_no"];

					$i++;

					$pdf->cell(12,8,$i,0,0,'L');

					$pdf->cell(35,8,'Roll No: ',0,0,'L');
					$pdf->cell(35,8,$row["roll_no"],0,0,'L');

					$pdf->cell(35,8,'Reg No: ',0,0,'L');
					$pdf->cell(45,8,$row["reg_no"],0,0,'L');

					$pdf->cell(35,8,'Name:',0,0,'L');
					$pdf->cell(80,8,$row["name"],0,1,'L');

					//Physical Jerks

					$physical_jerks = "Physical Jerks";

					$Iyear_of_study = "I Year";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$Iyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$Iyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,$Iyear_of_study,0,0,'L');
							$pdf->cell(75,8,'Total Physical Jerks Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}
						}
					}

					//Asanas 

					$physical_jerks = "Asanas";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$Iyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$Iyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Asanas Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}

							// $pre = ($present / $count_tot)*100;
							// $presentage = round($pre,2);
							// $pdf->cell(20,8,$presentage." %",0,1,'L');

						}
					}

					//Mass Drill

					$physical_jerks = "Mass Drill";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$Iyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$Iyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Mass Drill Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}

							$pdf -> Ln(2);
						}
					}

/* *********************************************************************************************** */

					//Physical Jerks

					$physical_jerks = "Physical Jerks";

					$IIyear_of_study = "II Year";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,$IIyear_of_study,0,0,'L');
							$pdf->cell(75,8,'Total Physical Jerks Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}
						}
					}

					//Asanas 

					$physical_jerks = "Asanas";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Asanas Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}

						}
					}

					//Mass Drill

					$physical_jerks = "Mass Drill";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Mass Drill Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}

							$pdf -> Ln(2);
						}
					}

/* *********************************************************************************************** */

					//Physical Jerks

					$physical_jerks = "Physical Jerks";

					$IIIyear_of_study = "III Year";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,$IIIyear_of_study,0,0,'L');
							$pdf->cell(75,8,'Total Physical Jerks Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}
						}
					}

					//Asanas 

					$physical_jerks = "Asanas";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Asanas Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}

						}
					}

					//Mass Drill

					$physical_jerks = "Mass Drill";

					$all_query = $link->query("select roll_no,count(*) as countP from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks' and student_attendance.att_status='Present'");

					$singleT= $link->query("select count(*) as countT from student_attendance where student_attendance.roll_no='$roll_no' and student_attendance.att_year_of_study = '$IIIyear_of_study' and student_attendance.att_physical_culture = '$physical_jerks'");

					$count_tot;
					$i=0;

					if ($row=mysqli_fetch_row($singleT))
					{
						$count_tot=$row[0];
					}

     				//echo "Total: ".$count_tot; 

					while ($data = mysqli_fetch_array($all_query))
					{
						$i++;

						if($i <= 1)
						{	
							$pdf->cell(20,8,"",0,0,'L');
							$pdf->cell(75,8,'Total Mass Drill Conducted:',0,0,'L');
							$pdf->cell(20,8,$count_tot,0,0,'L');

							$pdf->cell(30,8,'Present:',0,0,'L');
							$present = $data[1];
							$pdf->cell(20,8,$present,0,0,'L');

							$pdf->cell(30,8,'Absent:',0,0,'L');
							$absent = $count_tot - $data[1];
							$pdf->cell(20,8,$absent,0,0,'L');

							$pdf->cell(30,8,'Presentage:',0,0,'L');
							if($count_tot != 0)
							{
								$pre = ($present / $count_tot)*100;
								$presentage = round($pre,2);
								$pdf->cell(20,8,$presentage." %",0,1,'L');
							}
							else
							{
								$pdf->cell(20,8,0.0." %",0,1,'L');
							}

							$pdf -> Ln(10);
						}
					}

/* *********************************************************************************************** */
				}//End While
			}//End If

		}
		
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
	<title>Attendance Report</title>
	<style type="text/css">
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
</head>
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
				<li class="breadcrumb-item active" aria-current="page">Attendance Report</li>
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
							<h6 class="card-title card-text"><i class="fa fa-file-pdf-o"></i> <span>Student Attendance Report</span></h6>
						</div>
						<div class = "card-body">
							<div class="container-fluid"><br>
								<div class="row justify-content-center">
									<div class="col-sm-5 col-sm-5">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-address-book"></i> Attendance Report</h6>
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

														>Final</option>
													</select>
													<span class="invalid-feedback"><?php echo $year_of_study_err; ?></span>
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
					</form>
				</div>
				
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