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

$batchcode = $batchcode_err = "";

$major = htmlspecialchars($_SESSION["department"]);

if($_SERVER["REQUEST_METHOD"] == "POST")
{

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

	//Generate PDF

	if(empty($batchcode_err))
	{
		ob_start();
		require("fpdf/fpdf.php");
		$pdf = new FPDF('l','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B','12');

		$sql = "SELECT * FROM student_academic_achievement WHERE batch_code = '$batchcode' AND major = '$major' ORDER BY name";
		$res = $link->query($sql);

		if($res->num_rows>0)
		{

			$i = 0;
			while ($row=$res->fetch_assoc()) 
			{
				$i++;
				$pdf->cell(12,8,$i,0,0,'L');

				$pdf->cell(30,8,'Roll No: ',0,0,'L');
				$pdf->cell(35,8,$row["roll_no"],0,0,'L');

				$pdf->cell(30,8,'Name:',0,0,'L');
				$pdf->cell(80,8,$row["name"],0,1,'L');

				//$pdf->Ln(3);

				$pdf->cell(90,8,'',1,0,'L');
				$pdf->cell(40,8,'Knowledge',1,0,'C');
				$pdf->cell(40,8,'Understanding',1,0,'C');
				$pdf->cell(40,8,'Resourcefulness',1,0,'C');
				$pdf->cell(40,8,'Pergaverance',1,1,'C');

				$pdf->cell(90,8,'Part - I: Tamil / Sanskrit / Hindi',1,0,'L');
				$pdf->cell(40,8,$row["I_K"],1,0,'C');
				$pdf->cell(40,8,$row["I_U"],1,0,'C');
				$pdf->cell(40,8,$row["I_R"],1,0,'C');
				$pdf->cell(40,8,$row["I_P"],1,1,'C');

				$pdf->cell(90,8,'Part - II: English',1,0,'L');
				$pdf->cell(40,8,$row["II_K"],1,0,'C');
				$pdf->cell(40,8,$row["II_U"],1,0,'C');
				$pdf->cell(40,8,$row["II_R"],1,0,'C');
				$pdf->cell(40,8,$row["II_P"],1,1,'C');

				$pdf->cell(90,8,'Part - III: Major',1,0,'L');
				$pdf->cell(40,8,$row["III_M_K"],1,0,'C');
				$pdf->cell(40,8,$row["III_M_U"],1,0,'C');
				$pdf->cell(40,8,$row["III_M_R"],1,0,'C');
				$pdf->cell(40,8,$row["III_M_P"],1,1,'C');

				$pdf->cell(90,8,'Allied (A)',1,0,'L');
				$pdf->cell(40,8,$row["III_AA_K"],1,0,'C');
				$pdf->cell(40,8,$row["III_AA_U"],1,0,'C');
				$pdf->cell(40,8,$row["III_AA_R"],1,0,'C');
				$pdf->cell(40,8,$row["III_AA_P"],1,1,'C');

				$pdf->cell(90,8,'Allied (B)',1,0,'L');

				$tgrade_k = $row["III_AB_K"];

				if($tgrade_k == "G")
				{
					$grade_k = "-";
				}
				else
				{
					$grade_k = $row["III_AB_K"];
				}

				$pdf->cell(40,8,$grade_k,1,0,'C');

				$tgrade_u = $row["III_AB_U"];

				if($tgrade_u == "G")
				{
					$grade_u = "-";
				}
				else
				{
					$grade_u = $row["III_AB_U"];
				}

				$pdf->cell(40,8,$grade_u,1,0,'C');

				$tgrade_r = $row["III_AB_R"];

				if($tgrade_r == "G")
				{
					$grade_r = "-";
				}
				else
				{
					$grade_r = $row["III_AB_R"];
				}

				$pdf->cell(40,8,$grade_r,1,0,'C');

				$tgrade_p = $row["III_AB_P"];

				if($tgrade_p == "G")
				{
					$grade_p = "-";
				}
				else
				{
					$grade_p = $row["III_AB_P"];
				}

				$pdf->cell(40,8,$grade_p,1,1,'C');

				$pdf->Ln(3);
			}
		}
		else
		{
			$pdf->cell(277,10,"No Records Found",1,0,'C');
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
	<title>Academic Achievement</title>
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
</style>
<body>
	
	<!-- navbar start -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="ahome.php">
			<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="lable">VIVEKANANDA COLLEGE - Department of <?php echo htmlspecialchars($_SESSION["department"]); ?></span>
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
				<li class="breadcrumb-item"><a href="head_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Academic Achievement</li>
			</ol>
		</nav>
	</div>

	<!-- breadcrumb end -->

	<!-- main container start -->

	<div class="container-fluid">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-graduation-cap fa-lg"></i> <span>Student Academic Achievement</span></h6>
					</div>
					<div class = "card-body">
					<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link" href="update_academic_achievement.php" id="cnavtabs">Update Academic Achievement</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" href="report_academic_achievement" id="navtabs" >Academic Achievement Report</a>
								</li>
							</ul>
						<div class="container-fluid"><br>
								<div class="row justify-content-center">
									<div class="col-sm-5 col-sm-5">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-file-pdf-o"></i> Academic Achievement Report</h6>
											</div>
											<!-- import -->
											<div class="card-body" style="height: 225px">
												<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
												<!-- batch -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="batchcode"><span style="color: red">* </span>Batch Code</label>
													<input type="text" name="batch_code" class="form-control <?php echo (!empty($batchcode_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $batchcode; ?>" id="batchcode" placeholder="Enter Batch Code">
													<span class="invalid-feedback"><?php echo $batchcode_err; ?></span>
												</div>
												<div>
												<button style="float: right;" class="btn btn-success" name="report"> <i class = "fa fa-download" aria-hidden="ture"></i>&nbsp;&nbsp;Download </button>
												</div>
												</form>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div><br>
					<div class="card-footer">
						<a href="head_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- main container end -->

	<!-- footer -->

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>