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
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<style>
	#btnlab2
{
	position: absolute;
	transform: translate(-60%,-22%);
	color: white;
}
</style>
<body>

<!-- navbar -->

<nav class="navbar navbar-light bg-light">
	<a class="navbar-brand" href="ahome.php">
		<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
		<span id="lable">VIVEKANANDA COLLEGE - Department Of <?php echo htmlspecialchars($_SESSION["department"]); ?></span>
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
					<h6 class="card-title card-text"><i class="fa fa-home fa-lg"></i> <span>Home :: Welcome to VIVEKANANDA COLLEGE - Head Portal</span></h6>
				</div>
				<div class="card-body">

					<!-- Student Personal Details column -->

					<h3 class="card-title" id="card-title">Student Column</h3>

					<a  class="btn btn-success btn-lg" href="update_info_personal_details.php" role="button" id="btnas"><i class="fa fa-users fa-3x" aria-hidden="ture" id="faicon"></i>&nbsp;<spam id="btnlab"> Personal Details</spam></a>&nbsp;&nbsp;&nbsp;&nbsp;

					<a  class="btn btn-danger btn-lg" href="update_academic_achievement.php" role="button" id="btnas"><i class="fa fa-graduation-cap fa-3x" aria-hidden="ture" id="faicon"></i>&nbsp; <spam id="btnlabaa">Academic <br>Achievement</spam></a><br><br>
					
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