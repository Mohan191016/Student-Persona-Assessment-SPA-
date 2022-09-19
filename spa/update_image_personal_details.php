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

$regno = $regno_err = $image = $image_err = "";

$staff_department = htmlspecialchars($_SESSION["department"]);

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//Register Number Validation


	if(empty(trim($_POST['reg_no'])))
	{
		$regno_err = "Please Enter the Student Register Number.";
	}
	elseif(!is_numeric(trim($_POST['reg_no']))) 
	{
		$regno_err = "Student Register number Contain only Numbers.";
	}
	elseif(preg_match('@[^\w]@',trim($_POST['reg_no'])))
	{
		$regno_err = "Student Register number Contain only Numbers.";
	}
	elseif(strlen(trim($_POST['reg_no'])) != 6)
	{
		$regno_err = "Student Register number must Contain only 6 characters.";	
	}
	else
	{
		$tregno = $_POST['reg_no'];
		$query = "SELECT major from student_personal_details WHERE reg_no = '$tregno'";
		$result = $link->query($query);
		if($result -> num_rows > 0)
		{
			while($row = $result -> fetch_assoc())
			{
				$major = $row["major"];

				if($major == $staff_department)
				{
					$regno = $_POST['reg_no'];
				}
				else
				{
					echo '<script language="javascript">';
					echo'alert("This Student is Not a Your Department Student."); location.href="update_image_personal_details.php"';
					echo '</script>';
				}

			}
		}
		else
		{
			echo '<script language="javascript">';
			echo'alert("No Student Founded."); location.href="update_image_personal_details.php"';
			echo '</script>';
		}
	}

	// Image Validation

	$fileSize = $_FILES['image']['size'];
	if ($fileSize == 0)
	{
		$image_err = "Please Select Student Image.";
	}
	else
	{
		$image = $_FILES['image']['tmp_name'];
		$name = $_FILES['image']['name'];

		$image = file_get_contents($image);
		$image = base64_encode($image);
		$query = "UPDATE student_personal_details SET image = '$image' WHERE reg_no = '$regno'";
		if ($link -> query($query)) 
		{
			echo '<script language="javascript">';
			echo'alert("Image Uploaded Successfully"); location.href="update_image_personal_details.php"';
			echo '</script>';
		}
		else
		{
			echo '<script language="javascript">';
			echo'alert("Image Not Uploaded Successfully"); location.href="update_image_personal_details.php"';
			echo '</script>';
		}
	}
}
// $query = "SELECT image from student_personal_details";
// $result = $link->query($query);
// if($result -> num_rows > 0)
// {
//  while($row = $result -> fetch_assoc())
//  {
//      echo "<img width = '100px'
//          height = '110px' src = 'data:image;base64,{$row['image']}'>";
//          echo "<br><br>";
//  }
// }

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
						<h6 class="card-title card-text"><i class="fa fa-users fa-lg"></i> <span>Student Personal Details</span></h6>
					</div>
					<div class = "card-body">
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link" href="update_info_personal_details.php" id="cnavtabs">Update Personal Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active" href="update_image_personal_details.php" id="navtabs" >Update Student Image</a>
							</li>
							<li class="nav-item">
									<a class="nav-link" href="report_personal_details.php" id="cnavtabs" >Personal Details Report</a>
								</li>
						</ul>
						<div class="container-fluid"><br>
							<div class="row justify-content-center">
								<div class="col-5">
									<div class="card" style="border-top:2px solid #087ec2;">
										<div class="card-header bg-light" style="height: 45px;">
											<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold;"><i class="fa fa-upload"></i> Update Student Image</h6>
										</div>
										<div class="card-body" style="height: 300px">
											<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
												<!-- Register Number -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="regno"> <span style="color: red">* </span>Register Number</label>

													<input type="text" name="reg_no" class="form-control <?php echo (!empty($regno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $regno; ?>" placeholder="Enter Register Number" id="regno">

													<span class="invalid-feedback"><?php echo $regno_err; ?></span>
												</div>
												<!-- photo -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="batch_code"><span style="color: red">* </span>Image</label>

													<input type="file" name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>">
													<span class="invalid-feedback"><?php echo $image_err; ?></span>

												</div>
												<div>
													<button style="float: right;" class="btn btn-success" type="submit" name="update"><i class = "fa fa-upload" aria-hidden="ture"></i>&nbsp;&nbsp;Update</button>
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