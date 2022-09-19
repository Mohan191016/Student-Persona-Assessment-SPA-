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

$rollno = "";

?>


<!DOCTYPE html>
<html>
<head>
	<title>Student Actions</title>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
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
.card-title-new
{
	border-bottom: 1px dotted #000000; 
	padding-bottom: 5px; 
	margin-bottom:20px;
	margin-top: 10px; 
	color:#057EC5; 
	font-size:20px;
}
.btncss
{
	height: 120px;
	width: 230px;
	font-size: 25px;
	padding-top: 36px;
}
#faicon
{
	opacity: 0.4;
	float:left;
	padding-top: 5px;
	color: white;
}
#btnlab
{
	position: absolute;
	transform: translate(-60%,0%);
	color: white;
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
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- breadcrumb -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">View Student</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-eye fa-lg"></i> <span>View Student</span></h6>
					</div>
					<div class="card-body">
						<h3 class="card-title card-title-new">Student Personal Details</h3>
						
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead style="background-color:#057EC5; color:#FFF;">
									<tr>
										<th colspan = '7' style="text-align:center;">Student Personal Details</th>
									</tr>
								</thead>
								<?php

								if (isset($_POST['view'])) 
								{
									$rollno = $_POST['rollno'];

								$sql = "SELECT * FROM student_personal_details WHERE roll_no = '$rollno'";
								$res = $link->query($sql);
								if($res->num_rows>0)
								{
									while($row = $res->fetch_assoc())
									{
										echo"<tr style='text-align:center;'>";
										echo"<th>Roll No</th>";
										echo"<td>{$row["roll_no"]}</td>";
										echo"<th>Name</th>";
										echo"<td>{$row["name"]}</td>";
										echo"<th>Reg No</th>";
										echo"<td>{$row["reg_no"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Programme</th>";
										echo"<td>{$row["programme"]}</td>";
										echo"<th>Major</th>";
										echo"<td>{$row["major"]}</td>";
										echo"<th>Year of Study</th>";
										echo"<td>{$row["year_of_study"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Batch</th>";
										echo"<td>{$row["batch_code"]}</td>";
										echo"<th>DOB</th>";
										echo"<td>{$row["dob"]}</td>";
										echo"<th>Blood Group</th>";
										echo"<td>{$row["blood_group"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Email</th>";
										echo"<td >{$row["email"]}</td>";
										echo"<th>Phone Number</th>";
										echo"<td >{$row["mobile_no"]}</td>";
										echo "<td rowspan = '5' colspan = '2'><img width = '110px' height = '110px' src = 'data:image;base64,{$row['image']}'></td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Address</th>";
										echo"<td colspan = '3'>{$row["address_1"]}, {$row["address_2"]}, {$row["address_3"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Pledge 1</th>";
										echo"<td>{$row["pledge_1"]}</td>";
										echo"<th>Pledge 2</th>";
										echo"<td>{$row["pledge_2"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Values Acquired</th>";
										echo"<td>{$row["value"]}</td>";
										echo"<th colspan = '2'>Reason For Choose This Institution</th>";
										echo"<td colspan = '2'>{$row["wci"]}</td>";
										echo "<tr>";
									}
								}
								else
								{
									echo"<tr>";
									echo"<td colspan = '7' style = 'text-align:left;'>No Admin found...</td>";
									echo"</tr>";
								}

								?>
							</table>

						</div>

						<div style="border-bottom:2px dashed #114F81; margin-bottom:15px;"></div>

						<h3 class="card-title card-title-new">Hand</h3>

						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead style="background-color:#057EC5; color:#FFF;">
									<tr>
										<th colspan = '7' style="text-align:center;">Record of Physical Culture</th>
									</tr>
									<tr>
										<th style="text-align:center;">Performance</th>
										<th style="text-align:center;">I Year</th>
										<th style="text-align:center;">II Year</th>
										<th style="text-align:center;">III Year</th>
									</tr>
								</thead>
								<?php
								$sql = "SELECT * FROM student_physical_culture WHERE roll_no = '$rollno'";
								$res = $link->query($sql);
								if($res->num_rows>0)
								{
									while($row = $res->fetch_assoc())
									{
										echo"<tr style='text-align:center;'>";
										echo"<th>100 Meter Dash (in Seconds)</th>";
										echo"<td>{$row["I_100_MD"]}</td>";
										echo"<td>{$row["II_100_MD"]}</td>";
										echo"<td>{$row["III_100_MD"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>400 Meter Dash (in Seconds)</th>";
										echo"<td>{$row["I_400_MD"]}</td>";
										echo"<td>{$row["II_400_MD"]}</td>";
										echo"<td>{$row["III_400_MD"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Long Jump (in Metre)</th>";
										echo"<td>{$row["I_long_jump"]}</td>";
										echo"<td>{$row["II_long_jump"]}</td>";
										echo"<td>{$row["III_long_jump"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Pull ups (in Number)</th>";
										echo"<td>{$row["I_pull_ups"]}</td>";
										echo"<td>{$row["II_pull_ups"]}</td>";
										echo"<td>{$row["III_pull_ups"]}</td>";
										echo "<tr>";
									}
								}
							
								?>
							</table>
						</div>

						<div style="border-bottom:2px dashed #114F81; margin-bottom:15px;"></div>

						<h3 class="card-title card-title-new">Heart</h3>

						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead style="background-color:#057EC5; color:#FFF;">
									<tr>
										<th colspan = '7' style="text-align:center;">Record of Refinements</th>
									</tr>
									<tr>
										<th style="text-align:center;">Category</th>
										<th style="text-align:center;">Grade O</th>
										<th style="text-align:center;">Grade A</th>
										<th style="text-align:center;">Grade B</th>
										<th style="text-align:center;">Grade C</th>
										<th style="text-align:center;">Grade Obtained</th>
									</tr>
								</thead>
								<?php

								$sql = "SELECT * FROM student_gurukula_refinements WHERE roll_no = '$rollno'";
								$res = $link->query($sql);
								if($res->num_rows>0)
								{
									while($row = $res->fetch_assoc())
									{ 

								echo"<tr style='text-align:center;'>";
								echo"<th>Response to Prayer</th>";
								echo"<td>Devoted</td>";
								echo"<td>Willing</td>";
								echo"<td>Fair</td>";
								echo"<td>Satisfactory</td>";

								$g1 = $row["G1"];

							if($g1 == 9 || $g1 == 10)
							{
								$grade1 = "O";
							}
							elseif($g1 >= 6 || $g1 >= 8)
							{
								$grade1 = "A";
							}
							elseif($g1 >= 5 || $g1 >= 3)
							{
								$grade1 = "B";
							}
							else
							{
								$grade1 = "C";
							}
								echo"<td>$grade1</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Socila Relationship</th>";
								echo"<td>Exeplary</td>";
								echo"<td>Good</td>";
								echo"<td>Fair</td>";
								echo"<td>Satisfactory</td>";
								$g2 = $row["G2"];

							if($g2 == 9 || $g2 == 10)
							{
								$grade2 = "O";
							}
							elseif($g2 >= 6 || $g2 >= 8)
							{
								$grade2 = "A";
							}
							elseif($g2 >= 5 || $g2 >= 3)
							{
								$grade2 = "B";
							}
							else
							{
								$grade2 = "C";
							}
								echo"<td>$grade2</td>";
								//echo"<td>{$row["I_P"]}</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Co-Operation</th>";
								echo"<td>Spontaneous</td>";
								echo"<td>Laudable</td>";
								echo"<td>Remarkable</td>";
								echo"<td>Satisfactory</td>";
								$g3 = $row["G3"];

							if($g3 == 9 || $g3 == 10)
							{
								$grade3 = "O";
							}
							elseif($g3 >= 6 || $g3 >= 8)
							{
								$grade3 = "A";
							}
							elseif($g3 >= 5 || $g3 >= 3)
							{
								$grade3 = "B";
							}
							else
							{
								$grade3 = "C";
							}
								echo"<td>$grade3</td>";
								//echo"<td>{$row["I_P"]}</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Adaptability</th>";
								echo"<td>Superb</td>";
								echo"<td>Admirable</td>";
								echo"<td>Noteworthy</td>";
								echo"<td>Satisfactory</td>";
								$g4 = $row["G4"];

							if($g4 == 9 || $g4 == 10)
							{
								$grade4 = "O";
							}
							elseif($g4 >= 6 || $g4 >= 8)
							{
								$grade4 = "A";
							}
							elseif($g4 >= 5 || $g4 >= 3)
							{
								$grade4 = "B";
							}
							else
							{
								$grade4 = "C";
							}
								echo"<td>$grade4</td>";
								//echo"<td>{$row["I_P"]}</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Leadership</th>";
								echo"<td>Praiseworthy</td>";
								echo"<td>Trustworthy</td>";
								echo"<td>Dependable</td>";
								echo"<td>Satisfactory</td>";
								$g5 = $row["G5"];

							if($g5 == 9 || $g5 == 10)
							{
								$grade5 = "O";
							}
							elseif($g5 >= 6 || $g5 >= 8)
							{
								$grade5 = "A";
							}
							elseif($g5 >= 5 || $g5 >= 3)
							{
								$grade5 = "B";
							}
							else
							{
								$grade5 = "C";
							}
								echo"<td>$grade5</td>";
								//echo"<td>{$row["I_P"]}</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Disposition</th>";
								echo"<td>Genial</td>";
								echo"<td>Pleasing</td>";
								echo"<td>Quiet</td>";
								echo"<td>Satisfactory</td>";
								$g6 = $row["G6"];

							if($g6 == 9 || $g6 == 10)
							{
								$grade6 = "O";
							}
							elseif($g6 >= 6 || $g6 >= 8)
							{
								$grade6 = "A";
							}
							elseif($g6 >= 5 || $g6 >= 3)
							{
								$grade6 = "B";
							}
							else
							{
								$grade6 = "C";
							}
								echo"<td>$grade6</td>";
								//echo"<td>{$row["I_P"]}</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Bearing</th>";
								echo"<td>Attractive</td>";
								echo"<td>Good</td>";
								echo"<td>Normal</td>";
								echo"<td>Satisfactory</td>";
								$g7 = $row["G7"];

							if($g7 == 9 || $g7 == 10)
							{
								$grade7 = "O";
							}
							elseif($g7 >= 6 || $g7 >= 8)
							{
								$grade7 = "A";
							}
							elseif($g7 >= 5 || $g7 >= 3)
							{
								$grade7 = "B";
							}
							else
							{
								$grade7 = "C";
							}
								echo"<td>$grade6</td>";
								//echo"<td>{$row["I_P"]}</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Personal up-keep</th>";
								echo"<td>Neat & Tridy</td>";
								echo"<td>Good</td>";
								echo"<td>Fair</td>";
								echo"<td>Satisfactory</td>";
								//echo"<td>{$row["I_P"]}</td>";
								$g8 = $row["G8"];

							if($g8 == 9 || $g8 == 10)
							{
								$grade8 = "O";
							}
							elseif($g8 >= 6 || $g8 >= 8)
							{
								$grade8 = "A";
							}
							elseif($g8 >= 5 || $g8 >= 3)
							{
								$grade8 = "B";
							}
							else
							{
								$grade8 = "C";
							}
								echo"<td>$grade8</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Discipline</th>";
								echo"<td>Exemplary</td>";
								echo"<td>Good</td>";
								echo"<td>Fair</td>";
								echo"<td>Satisfactory</td>";
								//echo"<td>{$row["I_P"]}</td>";
								$g9 = $row["G9"];

							if($g9 == 9 || $g9 == 10)
							{
								$grade9 = "O";
							}
							elseif($g9 >= 6 || $g9 >= 8)
							{
								$grade9 = "A";
							}
							elseif($g9 >= 5 || $g9 >= 3)
							{
								$grade9 = "B";
							}
							else
							{
								$grade9 = "C";
							}
								echo"<td>$grade9</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>National epics & Religious knowledge</th>";
								echo"<td>Splendid</td>";
								echo"<td>Good</td>";
								echo"<td>Fair</td>";
								echo"<td>Satisfactory</td>";
								$g10 = $row["G10"];

							if($g10 == 9 || $g10 == 10)
							{
								$grade10 = "O";
							}
							elseif($g10 >= 6 || $g10 >= 8)
							{
								$grade10 = "A";
							}
							elseif($g10 >= 5 || $g10 >= 3)
							{
								$grade10 = "B";
							}
							else
							{
								$grade10 = "C";
							}
								echo"<td>$grade10</td>";
								//echo"<td>{$row["I_P"]}</td>";
							
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Punctuality</th>";
								echo"<td>Prompt</td>";
								echo"<td>Regular</td>";
								echo"<td>Fair</td>";
								echo"<td>Satisfactory</td>";
								$g11 = $row["G11"];

							if($g11 == 9 || $g11 == 10)
							{
								$grade11 = "O";
							}
							elseif($g11 >= 6 || $g11 >= 8)
							{
								$grade11 = "A";
							}
							elseif($g11 >= 5 || $g11 >= 3)
							{
								$grade11 = "B";
							}
							else
							{
								$grade11 = "C";
							}
								echo"<td>$grade11</td>";
								//echo"<td>{$row["I_P"]}</td>";
								echo "<tr>";

								echo"<tr style='text-align:center;'>";
								echo"<th>Response of Life Training</th>";
								echo"<td>Devoted</td>";
								echo"<td>Willing</td>";
								echo"<td>Fair</td>";
								echo"<td>Satisfactory</td>";
								$g12 = $row["G12"];

							if($g12 == 9 || $g12 == 10)
							{
								$grade12 = "O";
							}
							elseif($g12 >= 6 || $g12 >= 8)
							{
								$grade12 = "A";
							}
							elseif($g12 >= 5 || $g12 >= 3)
							{
								$grade12 = "B";
							}
							else
							{
								$grade12 = "C";
							}
								echo"<td>$grade12</td>";
								//echo"<td>{$row["I_P"]}</td>";
								echo "<tr>";

									}
								}

								?>
							</table>
						</div>
						<div style="border-bottom:2px dashed #114F81; margin-bottom:15px;"></div>

						<h3 class="card-title card-title-new">Head</h3>

						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead style="background-color:#057EC5; color:#FFF;">
									<tr>
										<th colspan = '7' style="text-align:center;">Record of Academic Achievement</th>
									</tr>
									<tr>
										<th style="text-align:center;"></th>
										<th style="text-align:center;">Knowledge</th>
										<th style="text-align:center;">Understanding</th>
										<th style="text-align:center;">Resourcefulness</th>
										<th style="text-align:center;">Persaverance</th>
									</tr>
								</thead>
								<?php 

								$sql = "SELECT * FROM student_academic_achievement WHERE roll_no = '$rollno'";
								$res = $link->query($sql);
								if($res->num_rows>0)
								{
									while($row = $res->fetch_assoc())
									{
										echo"<tr style='text-align:center;'>";
										echo"<th>Part - I: Tamil/Sanskrit/Hindi</th>";
										echo"<td>{$row["I_K"]}</td>";
										echo"<td>{$row["I_U"]}</td>";
										echo"<td>{$row["I_R"]}</td>";
										echo"<td>{$row["I_P"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Part - II: English</th>";
										echo"<td>{$row["II_K"]}</td>";
										echo"<td>{$row["II_U"]}</td>";
										echo"<td>{$row["II_R"]}</td>";
										echo"<td>{$row["II_P"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Part - III: Major</th>";
										echo"<td>{$row["III_M_K"]}</td>";
										echo"<td>{$row["III_M_U"]}</td>";
										echo"<td>{$row["III_M_R"]}</td>";
										echo"<td>{$row["III_M_P"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Part - III: Allied (A)</th>";
										echo"<td>{$row["III_AA_K"]}</td>";
										echo"<td>{$row["III_AA_U"]}</td>";
										echo"<td>{$row["III_AA_R"]}</td>";
										echo"<td>{$row["III_AA_P"]}</td>";
										echo "<tr>";

										echo"<tr style='text-align:center;'>";
										echo"<th>Part - III: Allied (B)</th>";
										$g1 = $row["III_AB_K"];
										if($g1 == "G")
										{
											echo"<td>-</td>";
										}
										else
										{
											echo"<td>{$row["III_AB_K"]}</td>";
										}

										$g2 = $row["III_AB_U"];
										if($g2 == "G")
										{
											echo"<td>-</td>";
										}
										else
										{
											echo"<td>{$row["III_AB_U"]}</td>";
										}
										
										$g3 = $row["III_AB_R"];
										if($g3 == "G")
										{
											echo"<td>-</td>";
										}
										else
										{
											echo"<td>{$row["III_AB_R"]}</td>";
										}

										$g4 = $row["III_AB_P"];
										if($g4 == "G")
										{
											echo"<td>-</td>";
										}
										else
										{
											echo"<td>{$row["III_AB_P"]}</td>";
										}
										echo "<tr>";
									}
								}

							}
								?>
							</table>
						</div>

						<div style="border-bottom:2px dashed #114F81; margin-bottom:15px;"></div>

					</div>
					<div class="card-footer">
						<a href="view_student.php" class="btn btn-secondary ml-2"><i class="fa fa-reply"></i>&nbsp; Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	

	<!-- footer -->

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>