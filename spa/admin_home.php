<?php
 // Initialize the session
 session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
 {
     header("location: index.php");
     exit;
 }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>

	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" type="text/css" href="stylesheet/homepage.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
</head>
<body>

<!-- navbar -->

<nav class="navbar navbar-light bg-light">
	<a class="navbar-brand" href="ahome.php">
		<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
		<span id="lable">VIVEKANANDA COLLEGE - Student Persona Assessment</span>
	</a>
	<ul class="nav navbar-nav navbar-right">
		<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
	</ul>
</nav>

<!-- breadcrumb -->

<div class="page-header">
	<nav aria-label="breadcrumb">
  		<ol class ="breadcrumb" id="breadcrumb">
    		<li class="breadcrumb-item active" aria-current="page">Home</li>
  		</ol>
	</nav>
</div>

<!-- main container -->

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card" style="border-top:2px solid #087ec2;">
				<div class="card-header bg-light" style="height: 45px;">
					<h6 class="card-title card-text"><i class="fa fa-home fa-lg"></i> <span>Home :: Welcome to VIVEKANANDA COLLEGE - Admin Portal</span></h6>
				</div>
				<div class="card-body">

					<!-- faculty column -->

					<h3 class="card-title" id="card-title">Faculty Column</h3>
					<a  class="btn btn-success btn-lg" href="admin_register.php" role="button" id="btnas" name="addfaculty"><i class="fa fa-users fa-3x" aria-hidden="ture" id="faicon"></i>&nbsp;<spam id="btnlab"> Add Faculty</spam></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a  class="btn btn-danger btn-lg" href="admin_edit.php" role="button" id="btnas"><i class="fa fa-edit fa-3x" aria-hidden="ture"id="faicon"></i>&nbsp; <spam id="btnlab">Edit Faculty</spam></a><br><br>
					<div style="border-bottom:2px dashed #114F81; margin-bottom:5px;"></div><br>
					
					<!-- student column -->

					<h3 class="card-title" id = "card-title">Student Column</h3>
					<a  class="btn btn-success btn-lg addstudent" href="add_student_multiple.php" role="button" id="btnas"><i class="fa fa-graduation-cap fa-3x" aria-hidden="ture" id="faicon"></i>&nbsp;<spam id="btnlab"> Add Student</spam></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a  class="btn btn-warning btn-lg" href="student_action.php" role="button" id="btnas"><i class="fa fa-edit fa-3x" aria-hidden="ture"id="faicon"></i>&nbsp; <spam id="btnlab">Student Actions</spam></a>&nbsp;&nbsp;&nbsp;&nbsp;
					 <a  class="btn btn-danger btn-lg" href="view_student.php" role="button" id="btnas"><i class="fa fa-eye fa-3x" aria-hidden="ture"id="faicon"></i>&nbsp; <spam id="btnlab">View Student</spam></a>&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
					<div style="border-bottom:2px dashed #114F81; margin-bottom:15px;"></div>
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