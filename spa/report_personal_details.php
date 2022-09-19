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

		$sql = "SELECT * FROM student_personal_details WHERE batch_code = '$batchcode' AND major = '$major' ORDER BY reg_no";
		$res = $link->query($sql);
		if($res->num_rows>0)
		{

			$i = 0;
			while ($row=$res->fetch_assoc()) 
			{
				$i++;

				$pdf->cell(12,8,$i,0,0,'L');

				$pdf->cell(35,8,'Roll No: ',0,0,'L');
				$pdf->cell(35,8,$row["roll_no"],0,0,'L');

				$pdf->cell(35,8,'Reg No: ',0,0,'L');
				$pdf->cell(45,8,$row["reg_no"],0,0,'L');

				$pdf->cell(35,8,'Name:',0,0,'L');
				$pdf->cell(80,8,$row["name"],0,1,'L');

			//$pdf->Ln(0);

				$pdf->cell(12,8,"",0,0,'L');

				$pdf->cell(35,8,'Programme:',0,0,'L');
				$pdf->cell(35,8,$row["programme"],0,0,'L');

				$pdf->cell(35,8,'Major:',0,0,'L');
				$pdf->cell(45,8,$row["major"],0,0,'L');

				$pdf->cell(35,8,'Year of Study:',0,0,'L');
				$pdf->cell(45,8,$row["year_of_study"],0,1,'L');

			//$pdf->Ln(0);

				$pdf->cell(12,8,"",0,0,'L');

				$pdf->cell(35,8,'DOB:',0,0,'L');
				$pdf->cell(35,8,$row["dob"],0,0,'L');

				$pdf->cell(35,8,'Blood Group:',0,0,'L');
				$pdf->cell(45,8,$row["blood_group"],0,0,'L');

				$pdf->cell(35,8,'Batch:',0,0,'L');
				$pdf->cell(80,8,$row["batch_code"],0,1,'L');

			//$pdf->Ln(0);

				$pdf->cell(12,8,"",0,0,'L');

				$pdf->cell(35,8,'Email Id:',0,0,'L');
				$pdf->cell(115,8,$row["email"],0,0,'L');

				$pdf->cell(35,8,'Mobile No:',0,0,'L');
				$pdf->cell(80,8,$row["mobile_no"],0,1,'L');

			//$pdf->Ln(0);

				$pdf->cell(12,8,"",0,0,'L');

				$pdf->cell(35,8,'Address:',0,0,'L');
				$address = $row["address_1"].', '.$row["address_2"].', '.$row["address_3"];
				$pdf->cell(80,8,$address,0,1,'L');

				$pdf -> Ln(10);

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
	<title>Personal Details</title>
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
</head>
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
				<li class="breadcrumb-item active" aria-current="page">Personal Details</li>
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
						<h6 class="card-title card-text"><i class="fa fa-users"></i> <span>Student Personal Details</span></h6>
					</div>
					<div class = "card-body">
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link" href="update_info_personal_details.php" id="cnavtabs">Update Personal Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="update_image_personal_details.php" id="cnavtabs" >Update Student Image</a>
							</li>
							<li class="nav-item">
									<a class="nav-link active" href="report_personal_details.php" id="navtabs" >Personal Details Report</a>
								</li>
						</ul>
						<div class="container-fluid"><br>
							<div class="row justify-content-center">
								<div class="col-sm-5 col-sm-5">
									<div class="card" style="border-top:2px solid #087ec2;">
										<div class="card-header bg-light" style="height: 45px;">
											<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-file-pdf-o"></i> Personal Details Report</h6>
										</div>

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