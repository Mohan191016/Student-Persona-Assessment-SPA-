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

 $major = htmlspecialchars($_SESSION["department"]);

 $batch_code = $batchcode_err = "";
$berror = $verror = 0;

if(isset($_POST['export']))
{
	$csvMimes= array('application/vnd.ms-excel', 'text/plain', 'text/csv');
	if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
	{
		if(is_uploaded_file($_FILES['file']['tmp_name']))
		{
			$csvfile = fopen($_FILES['file']['tmp_name'], 'r');
			fgetcsv($csvfile);
			while (($line = fgetcsv($csvfile)) !== FALSE)
			{

				// Roll Number Verification

				$vrollno = $line[0];

				if (empty($vrollno))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Roll number is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!preg_match('/^[A-Z0-9]*$/',$vrollno))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Roll number Invalid.\nCorrect Formate is UG12345/PG12345"); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(strlen($vrollno) != 7)
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Roll number must Contain only 7 characters.\nCorrect Formate is UG12345/PG12345"); location.href="update_info_personal_details.php"';
					echo '</script>';	
				}
				
				// Student Name Validation

				$vname = $line[1];

				if(empty($vname))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Name is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif (!preg_match("/^[a-zA-Z-. ]*$/",$vname)) 
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Name contain only Letters, Dots and Space."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				// Programme validation

				$vprogramme = $line[2];

				if(empty($vprogramme))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nProgramme is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif($vprogramme !== 'B.Sc.,' && $vprogramme !== 'B.A.,' && $vprogramme !== 'B.Com.,' )
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nProgramme must be in the formate of B.Sc., or B.A., or B.Com.,"); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				// Major validation

				$vmajor = $line[3];

				if(empty($vmajor))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Major is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif($vmajor !== 'Economics' && $vmajor !== 'History' && $vmajor !== 'Commerce' && $vmajor !== 'Mathematics' && $vmajor !== 'Physics' && $vmajor !== 'Chemistry' && $vmajor !== 'Botany' && $vmajor !== 'Zoology' && $vmajor !== 'Computer Science' && $vmajor !== 'Commerce (CA)')
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Major is invalid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				//Batch Code Validation

				$vbatchcode = $line[4];

				if(empty($vbatchcode))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Batch Code is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!is_numeric($vbatchcode)) 
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Batch Code Contain only Numbers."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(preg_match('@[^\w]@',$vbatchcode))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\n Student Batch Code Contain only Numbers."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(strlen($vbatchcode) != 4)
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\n Student Batch Code must Contain only 4 Characters."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				// Register Number Validation

				$vreg_no = $line[5];

				if(empty($vreg_no))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Register number is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!is_numeric($vreg_no)) 
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Register number Contain only Numbers."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(preg_match('@[^\w]@',$vreg_no))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\n Student Register number Contain only Numbers."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(strlen($vreg_no) != 6)
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\n Student Register number must Contain only 6 characters."); location.href="update_info_personal_details.php"';
					echo '</script>';	
				}

			 	$vyear_of_study = $line[6];

			 	if(empty($vyear_of_study))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Year of Study number is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif((!preg_match('/^([0-9]{4})-([0-9]{2})$/',$vyear_of_study)) && (!preg_match('/^([0-9]{4})-([0-9]{4})$/',$vyear_of_study)))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Year of Study number is Invlid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				// Date of Birth Validation

				$vdob = $line[7];

				if(empty($vdob))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Date of Birth is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!preg_match("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/",$vdob))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Date of Birth is Invlid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				
				// Mobile Number Validation

				$vmobile_no = $line[8];

				if(empty($vmobile_no))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Condact Number is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!preg_match('/^([0-9]{10})$/',$vmobile_no))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Condact Number is Invalid."); location.href="update_info_personal_details.php"';
					echo '</script>';	
				}

				// Email Validation

				$vmail = $line[9];

				if(empty($vmail))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Mail Id is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!filter_var($vmail, FILTER_VALIDATE_EMAIL))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Mail Id is Invalid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				// Address Validation

			 	$vaddress_1 = $line[10];

			 	if(empty($vaddress_1))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Address 1 is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				$vaddress_2 = $line[11];

				if(empty($vaddress_2))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Address 2 is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				$vaddress_3 = $line[12];

				if(empty($vaddress_3))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Address 3 is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				// Blood Group Validation

				$vblood_group = $line[13];

				if(empty($vblood_group))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Blood Group is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!preg_match('/^(A|A1|A1B|B|AB|O)[+-]$/',$vblood_group))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Blood Group is Invalid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				// Why Choose This Institution Validation

				$vwci = $line[14];

				if(empty($vwci))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nWhy Choose This Institution is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!preg_match('/^[a-zA-Z-., ]*$/',$vwci))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nWhy Choose This Institution is Invalid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				// Values Validation

				$vvalues = $line[15];

				if(empty($vvalues))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Values are missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!preg_match('/^[a-zA-Z-., ]*$/',$vvalues))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Values are Invalid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				//Pledge Validation

				$vpledge_1 = $line[16];

				if(empty($vpledge_1))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Pledge 1 is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!preg_match('/^[a-zA-Z-., ]*$/',$vpledge_1))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Pledge 1 is Invalid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}

				$vpledge_2 = $line[17];

				if(empty($vpledge_2))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Pledge 2 is missing."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				elseif(!preg_match('/^[a-zA-Z-., ]*$/',$vpledge_2))
				{
					$verror++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Pledge 2 is Invalid."); location.href="update_info_personal_details.php"';
					echo '</script>';
				}
				
			}
			fclose($csvfile);
			if ($verror == 0) 
			{
				$csvfile = fopen($_FILES['file']['tmp_name'], 'r');
				fgetcsv($csvfile);
				while (($line = fgetcsv($csvfile)) !== FALSE)
				{
					$rollno = $line[0];
					$name = $line[1];
					$programme = $line[2];
					$major = $line[3];
					$batch_code = $line[4];
					$reg_no = $line[5];
			 		$year_of_study = $line[6];
					$dob = $line[7];
					$mobile_no = $line[8];
					$email = $line[9];
			 		$address_1 = $line[10];
					$address_2 = $line[11];
					$address_3 = $line[12];
					$blood_group = $line[13];
					$wci = $line[14];
					$values = $line[15];
					$pledge_1 = $line[16];
					$pledge_2 = $line[17];

				$query = "UPDATE student_personal_details SET roll_no = '$rollno', name = '$name', programme = '$programme', major = '$major', batch_code = '$batch_code', reg_no = '$reg_no', year_of_study = '$year_of_study', dob = '$dob', mobile_no = '$mobile_no', email = '$email', address_1 = '$address_1', address_2 = '$address_2', address_3 = '$address_3', blood_group = '$blood_group', wci = '$wci', value = '$values', pledge_1 = '$pledge_1', pledge_2 = '$pledge_2' WHERE roll_no = '$rollno'";

				$query_run = mysqli_query($link,$query);

					if($query_run)
					{
						echo '<script language="javascript">';
						echo'alert("Uploaded Successfully"); location.href="update_info_personal_details.php"';
						echo '</script>';
					}
				}
			}
		}
	}
	else
	{
		echo '<script language="javascript">';
		echo'alert("Please Select CSV File."); location.href="update_info_personal_details.php"';
		echo '</script>';
	}
}
?>