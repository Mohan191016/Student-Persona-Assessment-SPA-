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

$department = $department_err = $batch_code = $batchcode_err = $physical_culture = $physical_culture_err = $date = $date_err = $year_of_study = $year_of_study_err = "";

if(isset($_POST["search"]))
{
	// Batch Code Validation

	if(empty(trim($_POST["batch_code"])))
	{
		$batchcode_err = "Please enter the Batch Code.";
	}
	elseif(!is_numeric(trim($_POST["batch_code"])))
	{
		$batchcode_err = "Batch Code only Contain Numbers.";
	}
	elseif(preg_match('@[^\w]@',trim($_POST["batch_code"])))
	{
		$batchcode_err = "Batch Code only Contain Numbers.";
	}
	elseif(strlen(trim($_POST["batch_code"])) != 4)
	{
		$batchcode_err = "Batch Code must Contain only 4 characters.";
	}
	else
	{
		$batch_code = trim($_POST["batch_code"]);
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

	// Date Validation

	if (empty(trim($_POST["att_date"])))
	{
		$date_err = "Please select The Date.";
	}
	else
	{
		$date = trim($_POST["att_date"]);
	}

	// Physical Culture Validation

	if (empty(trim($_POST["att_physical_culture"]))) 
	{
		$physical_culture_err = " Please select Physical Culture.";
	}
	else
	{
		$physical_culture = trim($_POST["att_physical_culture"]);		
	}

		// Physical Year of Study

	if (empty(trim($_POST["att_year_of_study"]))) 
	{
		$year_of_study_err = " Please select Year of Study.";
	}
	else
	{
		$year_of_study = trim($_POST["att_year_of_study"]);		
	}

	// echo $physical_culture;
	// echo $year_of_study;
	// echo $date;
}

if(isset($_POST["attendance"]))
{
	foreach ($_POST['att_status'] as $i => $att_status) 
	{

		$roll_no = $_POST['roll_no'][$i];
		$date = trim($_POST["att_date"]);
		$year_of_study = trim($_POST["att_year_of_study"]);
		$physical_culture = trim($_POST["att_physical_culture"]);


		$stat = $link->query("insert into student_attendance(roll_no,att_year_of_study,att_physical_culture,att_status,att_date) values('$roll_no','$year_of_study','$physical_culture','$att_status','$date')");

		echo '<script language="javascript">';
		echo'alert("Attendance Marker Successfully."); location.href="attendance.php"';
		echo '</script>';

	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Attendance</title>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" type="text/css" href="stylesheet/register.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<style type="text/css">
#date
{
	font-weight: 800;
	font-size:16px;
}
</style>
<body>

	<!-- navbar -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="aregister.php">
			<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="header_lable">VIVEKANANDA COLLEGE - Department Of Physical Education</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- breadcrumb -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb" id="breadcrumb">
				<li class="breadcrumb-item"><a href="hand_home">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Mark Attendance</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card" style="border-top:2px solid #087ec2;">
						<div class="card-header bg-light" style="height: 45px;">
							<h6 class="card-title card-text"><i class="fa fa-edit"></i> <span>Mark Attendance - </span><span id = "date">Date : <?php echo " ".date('d-m-Y')." (".date('l').")" ?></span></h6>
						</div>
						<div class="card-body">

							<div class="row justify-content-center">
								<div class="col-3">
									<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="batch_code"> <span style="color: red">* </span>Batch Code</label>
									<input type="text" name="batch_code" class="form-control <?php echo (!empty($batchcode_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $batch_code; ?>" id="batch_code" placeholder="Enter Batch Code">
									<span class="invalid-feedback"><?php echo $batchcode_err; ?></span>
								</div>
								<div class="col-3">
									<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="department"> <span style="color: red">* </span>Department</label>
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
							</div><br>
							<div class="row justify-content-center">
								<div class="col-3">
									
									<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="adate"><span style="color: red">* </span>Date of Attendance</label>
									<input type="date" name="att_date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $date; ?>" id="adate">
									<span class="invalid-feedback"><?php echo $date_err; ?></span>

								</div>
								<div class="col-3">
									<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="physical_culture"> <span style="color: red">* </span>Physical Culture</label>
									<select name="att_physical_culture" class="custom-select <?php echo (!empty($physical_culture_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $physical_culture; ?>"id="physical_culture">
										<option value="">---Select Physical Culture---</option>
										<option value="Physical Jerks" 

										<?php 
										if($physical_culture == 'Physical Jerks') 
										{ 
											echo "selected"; 
										} 
										?>

										>Physical Jerks</option>
										<option value="Asanas"

										<?php 
										if($physical_culture == 'Asanas')
										{
											echo "selected";
										}
										?>

										>Asanas</option>
										<option value="Mass Drill"

										<?php 
										if($physical_culture == 'Mass Drill')
										{
											echo "selected";
										}
										?>

										>Mass Drill</option>
									</select>
									<span class="invalid-feedback"><?php echo $physical_culture_err; ?></span>
								</div>
								<div class="col-3">
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
									</select>
									<span class="invalid-feedback"><?php echo $year_of_study_err; ?></span>
								</div>
							</div><br>
							<div class="row justify-content-center">
								<div class="col-0.5"> 
									<button  type="submit" class="btn btn-success" name="search"><i class="fa fa-search" aria-hidden="ture"></i>&nbsp; Search</button>
								</div>
							</div><br>
							<div style="border-bottom:2px dashed #114F81; margin-bottom:15px;"></div>
							<!-- </form> -->

							<?php
							if(empty($department_err) && empty($batchcode_err))
							{
								$radio = 0;
								$sql = "SELECT roll_no, name FROM student_personal_details WHERE major = '{$department}' AND batch_code = '{$batch_code}' ORDER BY name ";
								$res = $link->query($sql);
								if($res->num_rows>0)
								{
									?>

									<div class="row-8">
										<div class="table-responsive">
											<table class="table table-bordered table-hover">
												<thead style="background-color:#057EC5; color:#FFF;">
													<tr>
														<th style="text-align:center;">Sl.No</th>
														<th style="text-align:center;">Roll No</th>
														<th style="text-align:center;">Name</th>
														<th style="text-align:center;">Present</th>
														<th style="text-align:center;">Absent</th>
													</tr>
												</thead>

												<?php
												$i=0;

												while($row = $res->fetch_assoc())
												{
													$i++;
													?>
													<tr style = "text-align: center;">
														<td><?php echo $i; ?></td>
														<td>
															<?php echo $row['roll_no']; ?>
															<input type="hidden" name="roll_no[]" value="<?php echo $row['roll_no']; ?>">

														</td>
														<td><?php echo $row['name']; ?></td>
														<td>
															<input type="radio" name="att_status[<?php echo $radio; ?>]" value="Present" checked>
															<label>Present</label>
														</td>
														<td>
															<input type="radio" name="att_status[<?php echo $radio; ?>]" value="Absent">
															<label>Absent </label>
														</td>
													</tr>
													<?php
													$radio++;
												}
												?>
											</table>
											<button  type="submit" name = "attendance" class="btn btn-success" id="btnsave"><i class="fa fa-check-square-o" aria-hidden="ture"></i>&nbsp; Mark Attendance</button>
										</div>
									</div>
									<?php
								}
								else
								{
									?>

									<div class = "alert alert-danger alert-dismissible fade show" role = "alert">
										<strong>No Student Found...!</strong>
										<button type="button" class = "close" data-dismiss = "alert" aria-label = "Close">
											<span aria-hidden = "true">&times;</span>
										</button>
									</div>

									<?php
								}
							}

							?>

						</div>
						<!-- button -->

						<div class="card-footer">
							<a href="hand_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</form><br>

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>