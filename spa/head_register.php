<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
 {
     header("location: index.php");
     exit;
 }

 function sendemail_verify($uname, $verify_token, $email)
{
	require 'G:\wamp64\www\spa\PHPMailer\PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 4;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'mohanvc19030@gmail.com';                 // SMTP username
	$mail->Password = 'Mohan@090301';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('mohanvc19030@gmail.com', 'Email Verification');
		$mail->addAddress($email);     // Add a recipient
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Email Verification from SPA';
	$content = "<h2>You have registered with SPA</h2>
	<h5>Verify your email address to login with the below link</h5><br><a href = 'http://localhost/spa/head_verify_email.php?UserName=$uname&Token=$verify_token'>Click Me</a>";
	$mail->MsgHTML($content);
	$mail -> send();

	// if(!$mail->send()) 
	// {
	// 	echo 'Message could not be sent.';
	// 	echo 'Mailer Error: ' . $mail->ErrorInfo;
	// } 
	// else 
	// {
	// 	echo 'Message has been sent';
	// }
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$uname = $password = $cpassword = $sname = $email = $tsname= $temail= $department = $dob = "";
$uname_err = $password_err = $cpassword_err = $sname_err = $email_err = $department_err= $dob_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty(trim($_POST["user_name"])))
	{
		$uname_err = "Please enter a Username.";
	}
	else
	{
		
	// Prepare a select statement
		$sql = "SELECT id FROM head_login WHERE user_name = ?";
		
		if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_uname);
			
            // Set parameters
			$param_uname = trim($_POST["user_name"]);
			
            // Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt))
			{
				/* store result */
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					$uname_err = "This Username is already taken.";
				} 
				else
				{
					$uname = trim($_POST["user_name"]);
				}
			} 
			else
			{
				echo "Oops! Something went wrong. Please try again later.";
			}

            // Close statement
			mysqli_stmt_close($stmt);
		}
	}
    // Validate password
	if(empty(trim($_POST["password"])))
	{
		$password_err = "Please enter a Password.";     
	} 
	elseif(strlen(trim($_POST["password"])) < 8)
	{
		$password_err = "Password must have atleast 8 characters.";
	}
	elseif(!preg_match('@[0-9]@',trim($_POST["password"])))
	{
		$password_err = "Password must contain at least one number.";
	}
	elseif(!preg_match('@[A-Z]@',trim($_POST["password"])))
	{
		$password_err = "Password must contain at least one upper case letter.";
	}
	elseif(!preg_match('@[a-z]@',trim($_POST["password"])))
	{
		$password_err = "Password must contain at least one lower case letter.";
	} 
	elseif(!preg_match('@[^\w]@',trim($_POST["password"])))
	{
		$password_err = "Password must contain special character.";
	}  
	else
	{
		$password = trim($_POST["password"]);
		
	}

     // Validate confirm password
	if(empty(trim($_POST["cpassword"])))
	{
		$cpassword_err = "Please enter a  Confirm Password.";     
	} 
	else
	{
		$cpassword = trim($_POST["cpassword"]);
		if(empty($password_err) && ($password != $cpassword))
		{
			$cpassword_err = "Password did not match.";
		}
	}

	//validate date of birth
	if(empty(trim($_POST["dob"])))
	{
		$dob_err = "Please enter the Date of Birth.";
	}
	else
	{
		$dob = trim($_POST["dob"]);
	}
    //validate staff name
	if(empty(trim($_POST["sname"])))
	{
		$sname_err = "Please enter a Staff Name.";
	}
	else
	{
		$tsname=trim($_POST["sname"]);
	} 
	if(!preg_match("/^[a-zA-Z-'. ]*$/",$tsname))
	{
		$sname_err = "Only letters, Dots and white space allowed.";
	} 
	
	else
	{
		$sname = trim($_POST["sname"]);
	}
    	//validate department
	if (empty(trim($_POST["department"]))) 
	{
		$department_err = " Please select Department.";
	}
	else
	{
		$department=trim($_POST["department"]);		
	}
	    //validate email
	if (empty(trim($_POST["email"]))) 
	{
		$email_err = "Please enter a Email.";
	} 
	else 
	{
		$temail = trim($_POST["email"]);
		    // check if e-mail address is well-formed
		if (!filter_var($temail, FILTER_VALIDATE_EMAIL)) 
		{
			$email_err = "Invalid email format.";
		}
		else
		{
			$email = trim($_POST["email"]);
		}
	}	

  // Check input errors before inserting in database
	if(empty($uname_err) && empty($password_err) && empty($cpassword_err) && empty($sname_err) && empty($email_err) && empty($department_err) && empty($dob_err))
	{
		$verify_token = md5(rand());
		
        // Prepare an insert statement
		$sql = "INSERT INTO head_login (user_name, password, dob,  staff_name, department, email, verify_token) VALUES (?,?,?,?,?,?,?)";
		
		if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "sssssss", $param_username, $param_password, $param_dob, $param_sname, $param_department, $param_email, $param_verify_token);
			
            // Set parameters
			$param_username = $uname;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_dob = $dob;
            $param_sname = $sname;
            $param_department = $department;
            $param_email = $email;
            $param_verify_token = $verify_token;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
            	sendemail_verify("$uname","$verify_token","$email");
                // Redirect to registeration page
            	echo '<script language="javascript">';
            	echo'alert("Successfully Registered"); location.href="head_register.php"';
            	echo '</script>';
            } 
            else
            {
            	echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
    
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="stylesheet/register.css">
</head>
<body>

	<!-- navbar -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="dregister.php">
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
				<li class="breadcrumb-item active" aria-current="page">Registration</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-edit"></i> <span>Registration</span></h6>
					</div>
					<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
						<div class="card-body">

							<!-- nav-tabs -->

							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link" href="admin_register.php" id="cnavtabs">Admin Registration</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="hand_register.php" id="cnavtabs">Hand Registration</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="heart_register.php" id="cnavtabs">Heart Registration</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" href="head_register.php" id="navtabs">Head Registration</a>
								</li>
							</ul>

							<!-- end nav-tabs -->

							<div class="container-fluid"><br>
								<div class="row">
									<div class="col-sm-6 col-sm-6">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-lock"></i> Head - Login Details</h6>
											</div>
											<div class="card-body" style="height: 455px">

												<!-- login details container -->

												<!-- username -->
												<div class="form-group">	
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" for="username"> <span style="color: red">* </span>User Name</label>
													<input type="text" name="user_name" class="form-control <?php echo (!empty($uname_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $uname; ?>" placeholder="Enter Faculty Id" id="username">
													<span class="invalid-feedback"><?php echo $uname_err; ?></span>
												</div>
												<!-- password -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="pwd"> <span style="color: red">* </span>Password</label>
													<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $password; ?>" placeholder="Enter Password" id="pwd">
													<span class="invalid-feedback"><?php echo $password_err; ?></span>
												</div>
												<!-- confirm password -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="cpwd"> <span style="color: red">* </span>Confirm Password</label>
													<input type="password" name="cpassword" class="form-control  <?php echo (!empty($cpassword_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $cpassword; ?>" placeholder="Enter Confirm Password" id="cpwd">
													<span class="invalid-feedback"><?php echo $cpassword_err; ?></span>
												</div>
												<!-- Date of Birth -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="dob"><span style="color: red">* </span>Date of Birth</label>
													<input type="date" name="dob" class="form-control <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $dob; ?>" id="dob">
													<span class="invalid-feedback"><?php echo $dob_err; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6 col-sm-6">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold;"><i class="fa fa-user"></i> Head - Personal Details</h6>
											</div>
											<div class="card-body" style="height: 455px">

												<!-- personal details container -->

												<!-- Faculty name -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="name"><span style="color: red">* </span>Faculty Name</label>
													<input type="text" name="sname" class="form-control <?php echo (!empty($sname_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $sname; ?>" id="name" placeholder="Enter Faculty Name">
													<span class="invalid-feedback"><?php echo $sname_err; ?></span>
												</div>
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
												<!-- email -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="email"><span style="color: red">* </span>Email Id</label>
													<input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?> "  value="<?php echo $email; ?>" id="email" placeholder="Enter Email Id">
													<span class="invalid-feedback"><?php echo $email_err; ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- button -->

						<div class="card-footer">
							<button  type="submit" class="btn btn-success" id="btnsave"><i class="fa fa-paper-plane" aria-hidden="ture"></i>&nbsp; Save</button>
							<a href="admin_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div><br>
	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>