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

$name = $rollno = $trollno = $tregno = $regno = $department = $batchcode = "";
$sname_err = $rollno_err = $regno_err = $department_err = $batchcode_err = "";

if (isset($_POST['editbtn'])) 
{
	$rollno = $_POST['rollno'];

	$query = "SELECT * FROM student_personal_details WHERE roll_no='$rollno'";
	$query_run = mysqli_query($link,$query);
	$row = mysqli_fetch_assoc($query_run);

	$rollno = $row['roll_no'];
	$regno = $row['reg_no'];
	$name = $row['name'];
	$department = $row['major'];
	$batchcode = $row['batch_code'];

}

if(isset($_POST['update']))
{
	// Roll number validation

	if(empty(trim($_POST["rollno"])))
	{
		$rollno_err = "Please enter a Student Roll Number.";
	}
	else
	{
		$rollno = trim($_POST["rollno"]);
	}

	// Register number validation

	if(empty(trim($_POST["regno"])))
	{
		$regno_err = "Please enter a Student Register Number.";
	}
	elseif(!is_numeric(trim($_POST["regno"])))
	{
		$regno_err = "Student Register number only Contain Numbers.";
	}
	elseif(preg_match('@[^\w]@',trim($_POST["regno"])))
	{
		$regno_err = "Student Register number only Contain Numbers.";
	}
	elseif(strlen(trim($_POST["regno"])) != 6)
	{
		$regno_err = "Student Register number must Contain only 6 characters.";
	}
	else
	{
		$regno = trim($_POST["regno"]);
	}

	// Department validation

	if (empty(trim($_POST["department"]))) 
	{
		$department_err = " Please select Department.";
	}
	else
	{
		$department = trim($_POST["department"]);
	}

	// Student name validation

	if(empty(trim($_POST["name"])))
	{
		$sname_err = "Please enter a Student Name.";
	}
	elseif (!preg_match("/^[a-zA-Z-'. ]*$/",trim($_POST["name"])))
	{
		$sname_err = "Student Name contain only Letters, Dots and Space.";
	}
	else
	{
		$name = trim($_POST["name"]);
	}

	// Batch code validation

	if(empty(trim($_POST["batchcode"])))
	{
		$batchcode_err = "Please enter the Student Batch Code.";
	}
	elseif(!is_numeric(trim($_POST["batchcode"])))
	{
		$batchcode_err = "Student Batch Code only Contain Numbers.";
	}
	elseif(preg_match('@[^\w]@',trim($_POST["batchcode"])))
	{
		$batchcode_err = "Student Batch Code only Contain Numbers.";
	}
	elseif(strlen(trim($_POST["batchcode"])) != 4)
	{
		$batchcode_err = "Student Batch Code must Contain only 4 characters.";
	}
	else
	{
		$batchcode = trim($_POST["batchcode"]);
	}

	if(empty($sname_err) && empty($rollno_err) && empty($regno_err) && empty($department_err) && empty($batchcode_err))
	{

	$query = "UPDATE student_personal_details SET  reg_no = '$regno', name = '$name', major = '$department', batch_code = '$batchcode' WHERE roll_no = '$rollno'";
	$query_run = mysqli_query($link,$query);

	if($query_run)
	{
		echo '<script language="javascript">';
		echo'alert("Update Successfully"); location.href="edit_student.php"';
		echo '</script>';
	}
	else
	{
		echo '<script language="javascript">';
		echo'alert("Not Updated"); location.href="edit_student.php"';
		echo '</script>';
	}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Student</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
	.navbar
	{
		height: 50px;
		padding-bottom: 1px;
		border-bottom: 2px solid #087ec2;
	}
	#collegelogo
	{
		margin-top: -11px;
		margin-left: -5px;
		height: 45px;
	}
	#lable
	{
		font-size:20px; 
		color:#000; 
		font-weight:bold; 
		margin-top: -4px;
		float:right;
	}
	.navbar-header
	{
		margin-left: -13px;
	}
	.page-header
	{
		vertical-align: middle;
		margin: 10px ;
		padding: 0;
		border-bottom: none;
	}
	.breadcrumb 
	{
		background: none;
	}
	#navtabs
	{
		font-weight: bold;
	}
	#cnavtabs
	{
		color: dimgrey;
	}
	.card-header h6 i 
	{
		margin-right: 8px;
	}

	.card-header h6
	{
		font-size: 16px;
		font-weight: 700;
		display: inline-block;
		color:#057EC5;
	}
	#btnsave
	{
		float: right;
	}
	.footer 
	{
		position: fixed;
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
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit Student</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-edit"></i> <span>Edit Student Details</span></h6>
					</div>
					<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
						<div class="card-body">
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
													<input type="text" readonly="readonly" name="rollno" class="form-control" value="<?php echo $rollno;?>" id="rollno">
													<span class="invalid-feedback"><?php echo $rollno_err; ?></span>
												</div>
												<!-- student name -->
												<div class="form-group">	
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" for="sname"> <span style="color: red">* </span>Student Name</label>
													<input type="text" name="name" class="form-control" value="<?php echo $name;?>" placeholder="Enter Student Name" id="sname">
													<span class="invalid-feedback"><?php echo $sname_err; ?></span>
												</div>
												<!-- regno -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="regno"> <span style="color: red">* </span>Register Number</label>
													<input type="text" name="regno" class="form-control <?php echo (!empty($regno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $regno;?>" placeholder="Enter Register Number" id="regno">
													<span class="invalid-feedback"><?php echo $regno_err; ?></span>
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
												<!-- department -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="department"><span style="color: red">* </span>Department</label>
													<select name="department" class="custom-select" value="<?php echo $department;?>" id="department">
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
												<!-- batch -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="batchcode"><span style="color: red">* </span>Batch Code</label>
													<input type="text" name="batchcode" class="form-control" value="<?php echo $batchcode;?>" id="batchcode" placeholder="Enter Batch Code">
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
							<button type="submit" class="btn btn-success" name="update" id="btnsave"><i class="fa fa-edit" aria-hidden="ture"></i>&nbsp; Save Changes</button>
							<a href="edit_student.php" class="btn btn-secondary ml-2"><i class="fa fa-reply"></i>&nbsp; Back</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div><br>

<!-- footer -->

<div class="footer">
	<strong>Student Persona Assessment (SPA)</strong>
</div>
</body>
</html>