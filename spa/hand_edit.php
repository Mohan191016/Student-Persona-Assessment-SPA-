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
	<title>Delete</title>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
 	<link rel="stylesheet" type="text/css" href="stylesheet/edit_page.css">
 	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>

	<!-- navbar -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="aedit.php">
			<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="header_lable">VIVEKANANDA COLLEGE - Student Persona Assessment</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- breadcrumb -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb" id="breadcrumb">
				<li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit Faculty</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-edit"></i> <span>Edit Faculty</span></h6>
					</div>
					<div class="card-body">

						<!-- nav-tabs -->

						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link" href="admin_edit.php" id="cnavtabs">Admin</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active" href="hand_edit.php" id="navtabs">Hand</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="heart_edit.php" id="cnavtabs" >Heart</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="head_edit.php" id="cnavtabs">Head</a>
							</li>
						</ul><br><br>

						<!-- table -->
						<div id="output"></div>
						
					</div>
					<div class="card-footer">
						<a href="admin_home.php" class="btn btn-secondary "><i class="fa fa-home"></i>&nbsp; Home</a>
						<a href="hand_register.php" class="btn btn-success " style="float: right;"><i class="fa fa-user-plus"></i>&nbsp; Add</a>
					</div>
				</div>
			</div>
		</div>
	</div><br><br>

	<!-- footer -->

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
	<script>
		$(document).ready(function(){
		 	$("#output").load("hand_edit_table.php");
			});
		$(document).on("click",".del",function(){
			var del=$(this);
			var id=$(this).attr("data-id");
			if(confirm('Are you sure you want to delete!.'))
			{
				$.ajax({
					url:"hand_delete.php",
					type:"post",
					data:{id:id},
					success:function()
					{
						del.closest("tr").hide();
						$("#output").load("hand_edit_table.php");
					}
				});
			}
		});


	</script>
</body>
</html>