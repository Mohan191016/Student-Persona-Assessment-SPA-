<?php

 // Initialize the session
 session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
 {
     header("location: index.php");
     exit;
 }

 include "config.php";

 $error = 0;

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
				// Validate Roll Number

				$vrollno = $line[1];

				if (empty($vrollno))
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Roll number is missing."); location.href="add_student_multiple.php"';
					echo '</script>';
				}
				elseif(!preg_match('/[A-Za-z0-9]/',$vrollno))
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\n Student Roll number Contain only Letters and Numbers."); location.href="add_student_multiple.php"';
					echo '</script>';
				}
				elseif(strlen($vrollno) != 7)
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\n Student Roll number must Contain only 7 characters."); location.href="add_student_multiple.php"';
					echo '</script>';	
				}
				else
				{
					$sql = "SELECT roll_no FROM student_personal_details WHERE roll_no = '{$vrollno}'";
					$res=$link->query($sql);
					if($res->num_rows == 1)
					{
						$error++;
						echo '<script language="javascript">';
						echo'alert("Error in File.\nStudent Roll number is Already Taken."); location.href="add_student_multiple.php"';
						echo '</script>';
					}
				}

				// Validate Student Name.

				$vname = $line[2];

				if(empty($vname))
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Name is missing."); location.href="add_student_multiple.php"';
					echo '</script>';
				}
				elseif (!preg_match("/^[a-zA-Z-'. ]*$/",$vname)) 
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Name contain only Letters, Dots and Space."); location.href="add_student_multiple.php"';
					echo '</script>';
				}

				// Validate Programme

				$vprogramme = $line[3];

				if(empty($vprogramme))
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nProgramme is missing."); location.href="add_student_multiple.php"';
					echo '</script>';
				}
				elseif($vprogramme !== 'B.Sc.,' && $vprogramme !== 'B.A.,' && $vprogramme !== 'B.Com.,' )
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nProgramme must be in the formate of B.Sc., or B.A., or B.Com.,"); location.href="add_student_multiple.php"';
					echo '</script>';
				}

				// Validate Student Major.

				$vmajor = $line[4];

				if(empty($vmajor))
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Major is missing."); location.href="add_student_multiple.php"';
					echo '</script>';
				}
				elseif($vmajor !== 'Economics' && $vmajor !== 'History' && $vmajor !== 'Commerce' && $vmajor !== 'Mathematics' && $vmajor !== 'Physics' && $vmajor !== 'Chemistry' && $vmajor !== 'Botany' && $vmajor !== 'Zoology' && $vmajor !== 'Computer Science' && $vmajor !== 'Commerce (CA)')
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Major is invalid."); location.href="add_student_multiple.php"';
					echo '</script>';
				}

				// Validate Student Batch Code

				$vbatchcode = $line[5];

				if(empty($vbatchcode))
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Batch Code is missing."); location.href="add_student_multiple.php"';
					echo '</script>';
				}
				elseif(!is_numeric($vbatchcode)) 
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\nStudent Batch Code Contain only Numbers."); location.href="add_student_multiple.php"';
					echo '</script>';
				}
				elseif(preg_match('@[^\w]@',$vbatchcode))
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\n Student Batch Code Contain only Numbers."); location.href="add_student_multiple.php"';
					echo '</script>';
				}
				elseif(strlen($vbatchcode) != 4)
				{
					$error++;
					echo '<script language="javascript">';
					echo'alert("Error in File.\n Student Batch Code must Contain only 4 Characters."); location.href="add_student_multiple.php"';
					echo '</script>';
				}

			}
			fclose($csvfile);

			if ($error == 0) 
			{
				$csvfile = fopen($_FILES['file']['tmp_name'], 'r');
				fgetcsv($csvfile);
				while (($line = fgetcsv($csvfile)) !== FALSE)
				{
					$rollno = $line[1];
					$name = $line[2];
					$programme = $line[3];
					$major = $line[4];
					$batchcode = $line[5];

					$sql_insert = "INSERT INTO student_personal_details (roll_no, name, programme, major,  batch_code) VALUES('{$rollno}', '{$name}', '{$programme}', '{$major}', '{$batchcode}')";
					if($link->query($sql_insert))
					{
						echo '<script language="javascript">';
						echo'alert("Uploaded Successfully"); location.href="add_student_multiple.php"';
						echo '</script>';
					}
				}
				fclose($csvfile);
			}
		}
	}
	else
	{
		echo '<script language="javascript">';
		echo'alert("Please Select a CSV File"); location.href="add_student_multiple.php"';
		echo '</script>';
	}
}
 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Student</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="stylesheet/homepage.css">
</head>
<style>
.card-title-new
{
	border-bottom: 1px dotted #000000; 
	padding-bottom: 5px; 
	margin-bottom:20px;
	margin-top: 10px; 
	color:#057EC5; 
	font-size:20px;
}
#navtabs
{
	font-weight: bold;
}
#cnavtabs
{
	color: dimgrey;
}
</style>
<body>

	<!-- navbar -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="ahome.php">
			<img src="images/collegelogo.jpg"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="lable">VIVEKANANDA COLLEGE - Student Persona Assessment</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a>
			</li> 
		</ul>
	</nav>

	<!-- breadcrumb -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb" id="breadcrumb">
				<li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Add Student</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-user-plus"></i> <span>Add Student</span></h6>
					</div>
					<div class="card-body">

						<!-- nav-tabs -->

						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" href="add_student_multiple.php" id="navtabs">Add Multiple Student</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="add_student_single.php" id="cnavtabs" >Add Single Student</a>
							</li>
						</ul><br>

						<!-- end nav-tabs -->

						<h3 class="card-title card-title-new">Add Student by File</h3>
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-6 col-sm-6">
									<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
										<input type="file" name="file" id="uploadfile">
										<button class="btn btn-success" type="submit" name="export"><i class = "fa fa-upload" aria-hidden="ture"></i>&nbsp;&nbsp;Export</button>
									</form>
								</div>
								<div class="col-sm-6 col-sm-6">
									<form action="import_student.php" method="post" enctype="multipart/form-data">
										<button style="float: right;" class="btn btn-danger" name="import"> <i class = "fa fa-download" aria-hidden="ture"></i>&nbsp;&nbsp;Import </button>
									</form>
								</div>
							</div>
						</div><br>
						<div style="border-bottom:2px dashed #114F81; margin-bottom:5px;"></div><br>
					</div>

					<!-- home button -->

					<div class="card-footer">
						<a href="admin_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
						<a href="#" class="btn btn-success ml-2" style="float: right;"><i class="fa fa-eye"></i>&nbsp; View</a>
					</div>

				</div>
			</div>
		</div>
	</div><br><br>

	<!-- footer -->

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>