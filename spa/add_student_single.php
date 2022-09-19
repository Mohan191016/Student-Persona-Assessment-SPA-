<?php

// Initialize the session
session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
 {
     header("location: index.php");
     exit;
 }


// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $rollno = $trollno = $major = $programme = $batchcode = "";
$name_err = $rollno_err = $major_err = $batchcode_err = $programme_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	// Student name validation

	if(empty(trim($_POST["name"])))
	{
		$name_err = "Please enter a Student Name.";
	}
	elseif (!preg_match("/^[a-zA-Z-'. ]*$/",trim($_POST["name"])))
	{
		$name_err = "Student Name contain only Letters, Dots and Space.";
	}
	else
	{
		$name = trim($_POST["name"]);
	}

	// Roll number validation

	if(empty(trim($_POST["roll_no"])))
	{
		$rollno_err = "Please enter a Student Roll Number.";
	} 
	elseif(preg_match('@[^\w]@',trim($_POST["roll_no"])))
	{
		$rollno_err = "Student Roll number only Contain Numbers and Letters.";
	}
	elseif(strlen(trim($_POST["roll_no"])) != 7)
	{
		$rollno_err = "Student Roll number must Contain only 7 Characters.";
	}
	else
	{
		$troll_no = trim($_POST["roll_no"]);
		$sql = "SELECT roll_no FROM student_personal_details WHERE roll_no = '{$troll_no}'";
		$res=$link->query($sql);
		if($res->num_rows == 1)
		{
			$rollno_err = "Student Roll number is Already Taken.";
		}
		else
		{
			$rollno = trim($_POST["roll_no"]);
		}
	}

	// Validate Major

	if (empty(trim($_POST["major"]))) 
	{
		$major_err = " Please Select Student Major.";
	}
	else
	{
		$major = trim($_POST["major"]);
	}

	//Validate Programme

	if(empty(trim($_POST["programme"])))
	{
		$programme_err = "Please Select Student Programme.";
	}
	else
	{
		$programme = trim($_POST["programme"]);
	}

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

	//insert validation data into database

	if(empty($name_err) && empty($rollno_err) && empty($programme_err) && empty($major_err) && empty($batchcode_err))
	{
		// Prepare an insert statement
        $sql = "INSERT INTO student_personal_details (roll_no, name, programme, major, batch_code) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_rollno, $param_name, $param_programme, $param_major, $param_batchcode);
            
            // Set parameters
            $param_rollno = $rollno;
            $param_name = $name;
            $param_programme = $programme;
            $param_major = $major;
            $param_batchcode = $batchcode;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Redirect to registeration page
               echo '<script language="javascript">';
               echo'alert("Successfully Registered"); location.href="add_student_single.php"';
               echo '</script>';
             } 
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Student</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="stylesheet/homepage.css">
	<style>
	#navtabs
	{
		font-weight: bold;
	}
	#cnavtabs
	{
		color: dimgrey;
	}
	#btnsave
	{
		float: right;
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
</head>
<body>

	<!-- navbar -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="ahome.php">
			<img src="images/collegelogo.jpg"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="lable">VIVEKANANDA COLLEGE - Student Personal Assessment</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a>
			</li> 
		</ul>
	</nav>

	<!-- breadcrumb -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb" id = "breadcrumb">
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
					<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
						<div class="card-body">

							<!-- nav-tabs -->

							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link" href="add_student_multiple.php" id="cnavtabs">Add Multiple Student</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" href="add_student_single.php" id="navtabs" >Add Single Student</a>
								</li>
							</ul>

							<!-- end nav-tabs -->

							<div class="container-fluid"><br>
								<div class="row">
									<div class="col-sm-6 col-sm-6">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-user"></i> Student Details</h6>
											</div>
											<div class="card-body" style="height: 350px">

												<!-- rollno -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="rollno"> <span style="color: red">* </span>Roll Number</label>
													<input type="text" name="roll_no" class="form-control <?php echo (!empty($rollno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rollno; ?>" placeholder="Enter Roll Number" id="rollno">
													<span class="invalid-feedback"><?php echo $rollno_err; ?></span>
												</div>
												<!-- student name -->
												<div class="form-group">	
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" for="sname"> <span style="color: red">* </span>Student Name</label>
													<input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" placeholder="Enter Student Name" id="sname">
													<span class="invalid-feedback"><?php echo $name_err; ?></span>
												</div>
												<!-- programme -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="programme"> <span style="color: red">* </span>Programme</label>
													<select name = "programme" class="custom-select <?php echo (!empty($programme_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $programme; ?>" id="programme">
													<option value = "">---Select Programme---</option>
													<option value="B.Sc.," 
														
														<?php 
														if($programme == 'B.Sc.,') 
															{ 
																echo "selected"; 
															} 
														?>

														>B.Sc.,</option>
														<option value="B.A.," 
														
														<?php 
														if($programme == 'B.A.,') 
															{ 
																echo "selected"; 
															} 
														?>

														>B.A.,</option>
														<option value="B.Com.," 
														
														<?php 
														if($programme == 'B.Com.,') 
															{ 
																echo "selected"; 
															} 
														?>

														>B.Com.,</option>
													</select>
													<span class="invalid-feedback"><?php echo $programme_err; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6 col-sm-6">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold;"><i class="fa fa-user"></i> Student Details</h6>
											</div>
											<div class="card-body" style="height: 350px">
												<!-- major -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="major"><span style="color: red">* </span>Major</label>
													<select name="major" class="custom-select <?php echo (!empty($major_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $major; ?>" id="major">
														<option value="">---Select Major---</option>
														<option value="Economics" 
														
														<?php 
														if($major == 'Economics') 
															{ 
																echo "selected"; 
															} 
														?>

														>Economics</option>
														<option value="History"

														<?php 
														if($major == 'History')
														{
															echo "selected";
														}
														?>

														>History</option>
														<option value="Commerce"

														<?php 
														if($major == 'Commerce')
														{
															echo "selected";
														}
														?>

														>Commerce</option>
														<option value="Mathematics"

														<?php 
														if($major == 'Mathematics')
														{
															echo "selected";
														}
														?>

														>Mathematics</option>
														<option value="Physics"

														<?php 
														if($major == 'Physics')
														{
															echo "selected";
														}
														?>

														>Physics</option>
														<option value="Chemistry"

														<?php 
														if($major == 'Chemistry')
														{
															echo "selected";
														}
														?>

														>Chemistry</option>
														<option value="Botany"

														<?php 
														if($major == 'Botany')
														{
															echo "selected";
														}
														?>

														>Botany</option>
														<option value="Zoology"

														<?php 
														if($major == 'Zoology')
														{
															echo "selected";
														}
														?>

														>Zoology</option>
														<option value="Computer Science"

														<?php 
														if($major == 'Computer Science')
														{
															echo "selected";
														}
														?>

														>Computer Science</option>
														<option value="Commerce (CA)"

														<?php 
														if($major == 'Commerce (CA)')
														{
															echo "selected";
														}
														?>

														>Commerce (CA)</option>
													</select>
													<span class="invalid-feedback"><?php echo $major_err; ?></span>
												</div>
												<!-- batch -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="batchcode"><span style="color: red">* </span>Batch Code</label>
													<input type="text" name="batch_code" class="form-control <?php echo (!empty($batchcode_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $batchcode; ?>" id="batchcode" placeholder="Enter Batch Code">
													<span class="invalid-feedback"><?php echo $batchcode_err; ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- button -->

						<div class="card-footer">
							<button type="submit" class="btn btn-success" id="btnsave"><i class="fa fa-paper-plane" aria-hidden="ture"></i>&nbsp; Save</button>
							<a href="admin_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div><br>

<!-- footer -->

<div id = "footer">
	<strong>Student Persona Assessment (SPA)</strong>
</div>
</body>
</html>