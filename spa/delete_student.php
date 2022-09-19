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

// if(isset($_POST['delete']))
// {
// 	$all_rollno = $_POST["deletecheckbox"];
// 	$separate_rollno = implode(',', $all_rollno);
// 	$query = "DELETE FROM student_personal_details WHERE roll_no IN($separate_rollno)";
// 	$query_run = mysqli_query($link,$query);

// 	if($query_run)
// 	{
// 		echo '<script language="javascript">';
// 		echo'alert("Students Deleted Successfully"); location.href="delete_student.php"';
// 		echo '</script>';
// 	}
// 	else
// 	{
// 		echo '<script language="javascript">';
// 		echo'alert("Student not Deleted"); location.href="delete_student.php"';
// 		echo '</script>';
// 	}
//}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Delete Student</title>

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
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script> -->


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
.footer 
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

	<!-- navbar -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="dedit.php">
			<img src="images/collegelogo.jpg"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="lable">VIVEKANANDA COLLEGE - Student Persona Assessment</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- breadcrumb -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Delete Student</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-trash"></i> <span>Delete Student</span></h6>
					</div>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
						<div class="card-body">

							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead style="background-color:#057EC5; color:#FFF;text-align:center;">
										<tr>
											<!-- <th>Select</th> -->
											<th>Roll.No</th>
											<th>Register.No</th>
											<th>Student Name</th>
											<th>Department</th>
											<th>Batch Code</th>
											<th>Delete Student</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT roll_no, reg_no, name, major, batch_code FROM student_personal_details ORDER BY roll_no";
										$res = $link->query($sql);
										if($res->num_rows>0)
										{
											while($row = $res->fetch_assoc())
											{
												echo"<tr style='text-align:center;'>";
												// echo"<td><input type='checkbox' name='deletecheckbox[]' value={$row["roll_no"]}></td>";
												echo"<td>{$row["roll_no"]}</td>";
												echo"<td>{$row["reg_no"]}</td>";
												echo"<td>{$row["name"]}</td>";
												echo"<td>{$row["major"]}</td>";
												echo"<td>{$row["batch_code"]}</td>";
												echo"<td><button type='button' class='btn btn-sm btn-danger del' data-id={$row["roll_no"]}><i class = 'fa fa-trash-o'></i></td>";
												echo"</tr>";
											}
										}
										else
										{
											echo"<tr>";
											echo"<td colspan = '7' style = 'text-align:left;'>No Student found...</td>";
											echo"</tr>";
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">
							<!-- <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete!')" style="float :right ;"><i class="fa fa-trash-o"></i>  <spam>Delete</spam></button> -->
							<a href="student_action.php" class="btn btn-secondary ml-2"><i class="fa fa-reply"></i>&nbsp; Back</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div><br><br>

	<!-- footer -->

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
	<script type="text/javascript">

		$(document).ready(function(){
			$('table').DataTable();
		});

		$(document).on("click",".del",function(){
			var del=$(this);
			var roll_no=$(this).attr("data-id");
			if(confirm('Are you sure you want to delete!.'))
			{
				$.ajax({
					url:"delete_student_query.php",
					type:"post",
					data:{roll_no:roll_no},
					success:function()
					{
						del.closest("tr").hide();
					}
				});
			}
		});
	</script>
</body>
</html>