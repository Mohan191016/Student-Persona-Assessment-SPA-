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

 $batch_code = htmlspecialchars($_SESSION["batch_code"]);

 $department = $department_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	// Department Validation

	if (empty(trim($_POST["department"]))) 
	{
		$department_err = " Please select Department.";
	}
	else
	{
		$department=trim($_POST["department"]);
	}

	//Generate PDF

	if(empty($department_err))
	{
		ob_start();
		require("fpdf/fpdf.php");
		$pdf = new FPDF('l','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B','12');

		$sql = "SELECT * FROM student_gurukula_refinements WHERE batch_code = '$batch_code' AND major = '$department'";
					$res = $link->query($sql);

					if($res->num_rows>0)
					{
						$i = 0;
						while ($row=$res->fetch_assoc()) 
						{

							$roll_no = $row["roll_no"];
							$name = $row["name"];

							$i++;

							$pdf->cell(12,8,$i,0,0,'L');

							$pdf->cell(25,8,'Roll No: ',0,0,'L');
							$pdf->cell(45,8,$row["roll_no"],0,0,'L');

							$pdf->cell(25,8,'Name:',0,0,'L');
							$pdf->cell(80,8,$row["name"],0,1,'L');

							$pdf->cell(100,8,'Category',1,0,'C');
							$pdf->cell(35,8,'Grade O',1,0,'C');
							$pdf->cell(35,8,'Grade A',1,0,'C');
							$pdf->cell(35,8,'Grade B',1,0,'C');
							$pdf->cell(35,8,'Grade C',1,0,'C');
							$pdf->cell(35,8,'Grade Obtained',1,1,'C');

							$pdf->cell(100,8,'1. Response to Prayer',1,0,'L');
							$pdf->cell(35,8,'Devoted',1,0,'C');
							$pdf->cell(35,8,'Willing',1,0,'C');
							$pdf->cell(35,8,'Fair',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');

							$g1 = $row["G1"];

							if($g1 == 9 || $g1 == 10)
							{
								$grade = "O";
							}
							elseif($g1 >= 6 || $g1 >= 8)
							{
								$grade = "A";
							}
							elseif($g1 >= 5 || $g1 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'2. Social Relationship',1,0,'L');
							$pdf->cell(35,8,'Exemplary',1,0,'C');
							$pdf->cell(35,8,'Good',1,0,'C');
							$pdf->cell(35,8,'Fair',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');

							$g2 = $row["G2"];

							if($g2 == 9 || $g2 == 10)
							{
								$grade = "O";
							}
							elseif($g2 >= 6 || $g2 >= 8)
							{
								$grade = "A";
							}
							elseif($g2 >= 5 || $g2 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'3. Co-Operation',1,0,'L');
							$pdf->cell(35,8,'Spontaneous',1,0,'C');
							$pdf->cell(35,8,'Laudable',1,0,'C');
							$pdf->cell(35,8,'Remarkable',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');

							$g3 = $row["G3"];

							if($g3 == 9 || $g3 == 10)
							{
								$grade = "O";
							}
							elseif($g3 >= 6 || $g3 >= 8)
							{
								$grade = "A";
							}
							elseif($g3 >= 5 || $g3 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'4. Adaptabitily',1,0,'L');
							$pdf->cell(35,8,'Superb',1,0,'C');
							$pdf->cell(35,8,'Admirable',1,0,'C');
							$pdf->cell(35,8,'Noteworthy',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');

							$g4 = $row["G4"];

							if($g4 == 9 || $g4 == 10)
							{
								$grade = "O";
							}
							elseif($g4 >= 6 || $g4 >= 8)
							{
								$grade = "A";
							}
							elseif($g4 >= 5 || $g4 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'5. Leadership',1,0,'L');
							$pdf->cell(35,8,'Praiseworthy',1,0,'C');
							$pdf->cell(35,8,'Trustworthy',1,0,'C');
							$pdf->cell(35,8,'Dependable',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');
							
							$g5 = $row["G5"];

							if($g5 == 9 || $g5 == 10)
							{
								$grade = "O";
							}
							elseif($g5 >= 6 || $g5 >= 8)
							{
								$grade = "A";
							}
							elseif($g5 >= 5 || $g5 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'6. Disposition',1,0,'L');
							$pdf->cell(35,8,'Genial',1,0,'C');
							$pdf->cell(35,8,'Pleasing',1,0,'C');
							$pdf->cell(35,8,'Quiet',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');
							$g6 = $row["G6"];

							if($g6 == 9 || $g6 == 10)
							{
								$grade = "O";
							}
							elseif($g6 >= 6 || $g6 >= 8)
							{
								$grade = "A";
							}
							elseif($g6 >= 5 || $g6 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'7. Bearing',1,0,'L');
							$pdf->cell(35,8,'Attractive',1,0,'C');
							$pdf->cell(35,8,'Good',1,0,'C');
							$pdf->cell(35,8,'Normal',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');
							$g7 = $row["G7"];

							if($g7 == 9 || $g7 == 10)
							{
								$grade = "O";
							}
							elseif($g7 >= 6 || $g7 >= 8)
							{
								$grade = "A";
							}
							elseif($g7 >= 5 || $g7 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'8. Personal up-keep',1,0,'L');
							$pdf->cell(35,8,'Neat & Tridy',1,0,'C');
							$pdf->cell(35,8,'Good',1,0,'C');
							$pdf->cell(35,8,'Fair',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');
							$g8 = $row["G8"];

							if($g8 == 9 || $g8 == 10)
							{
								$grade = "O";
							}
							elseif($g8 >= 6 || $g8 >= 8)
							{
								$grade = "A";
							}
							elseif($g8 >= 5 || $g8 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'9. discipline',1,0,'L');
							$pdf->cell(35,8,'Exemplary',1,0,'C');
							$pdf->cell(35,8,'Good',1,0,'C');
							$pdf->cell(35,8,'Fair',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');
							$g9 = $row["G9"];

							if($g9 == 9 || $g9 == 10)
							{
								$grade = "O";
							}
							elseif($g9 >= 6 || $g9 >= 8)
							{
								$grade = "A";
							}
							elseif($g9 >= 5 || $g9 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'10. National epics & Religious knowledge',1,0,'L');
							$pdf->cell(35,8,'Splendid',1,0,'C');
							$pdf->cell(35,8,'Good',1,0,'C');
							$pdf->cell(35,8,'Fair',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');
							$g10 = $row["G10"];

							if($g10 == 9 || $g10 == 10)
							{
								$grade = "O";
							}
							elseif($g10 >= 6 || $g10 >= 8)
							{
								$grade = "A";
							}
							elseif($g10 >= 5 || $g10 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'11. Punctuality',1,0,'L');
							$pdf->cell(35,8,'Prompt',1,0,'C');
							$pdf->cell(35,8,'Regular',1,0,'C');
							$pdf->cell(35,8,'Fair',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');
							$g11 = $row["G11"];

							if($g11 == 9 || $g11 == 10)
							{
								$grade = "O";
							}
							elseif($g11 >= 6 || $g11 >= 8)
							{
								$grade = "A";
							}
							elseif($g11 >= 5 || $g11 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf->cell(100,8,'12. Response of Life Training',1,0,'L');
							$pdf->cell(35,8,'Devoted',1,0,'C');
							$pdf->cell(35,8,'Willing',1,0,'C');
							$pdf->cell(35,8,'Fair',1,0,'C');
							$pdf->cell(35,8,'Satisfactory',1,0,'C');
							$g12 = $row["G12"];

							if($g12 == 9 || $g12 == 10)
							{
								$grade = "O";
							}
							elseif($g12 >= 6 || $g12 >= 8)
							{
								$grade = "A";
							}
							elseif($g12 >= 5 || $g12 >= 3)
							{
								$grade = "B";
							}
							else
							{
								$grade = "C";
							}

							$pdf->cell(35,8,$grade,1,1,'C');

							$pdf -> Ln(5);
						}
					}
					else
					{
						$pdf->cell(190,8,"No Student Founded...!",1,1,'C');
					}


		$pdf->output();
		ob_end_flush();
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" type="text/css" href="stylesheet/homepage.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Physical Culture</title>
</head>
<style type="text/css">
	#navtabs
	{
		font-weight: bold;
	}
	#cnavtabs
	{
		color: dimgrey;
	}
	#footer 
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
<body>
	
	<!-- navbar start -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="ahome.php">
			<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="lable">VIVEKANANDA COLLEGE - Gurukula</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- navbar end -->

	<!-- breadcrumb start -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb" id="breadcrumb">
				<li class="breadcrumb-item"><a href="heart_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Gurukula Refinements</li>
			</ol>
		</nav>
	</div>

	<!-- breadcrumb end -->

	<!-- main container start -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-bell fa-lg"></i> <span>Student Gurukula Refinements</span></h6>
					</div>
					<div class = "card-body">
					<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link" href="update_gurukula_refinements.php" id="cnavtabs">Update Gurukula Refinements</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" href="report_gurukula_refinements.php" id="navtabs" >Gurukula Refinements Report</a>
								</li>
							</ul>
						<div class = "card-body">
							<div class="container-fluid"><br>
								<div class="row justify-content-center">
									<div class="col-sm-5 col-sm-5">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-address-book"></i> Physical Culture Report</h6>
											</div>

											<div class="card-body" style="height: 200px">

												<!-- department -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="department"><span style="color: red">* </span>Department</label>
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
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

						</div><br>
					<div class="card-footer">
						<a href="heart_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
							<button style="float: right;" class="btn btn-success" name="report"> <i class = "fa fa-download" aria-hidden="ture"></i>&nbsp;&nbsp;Download </button>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div><br>

	<!-- main container end -->

	<!-- footer -->

	<div id="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>