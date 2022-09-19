<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] !== true){
	header("location: hand_login.php");
	exit;
}

require_once "config.php";

$user_dob = $server_dob = $err_dob = $user_otp = $server_otp = $err_otp = $email = "";

$uname = htmlspecialchars($_SESSION["user_name"]);
//echo ($uname);

$sql = "SELECT otp,email FROM hand_login WHERE user_name = '$uname'";
$result =  $link->query($sql);
if($result -> num_rows > 0)
{
	while($row = $result -> fetch_assoc())
	{
	//echo("otp:".$row["otp"]);
	$server_otp = $row["otp"];
	$email = $row["email"];
	echo($server_otp);
	//echo($email);
	}
}

$server_dob = htmlspecialchars($_SESSION["dob"]);
//echo($server_dob);

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	// check if user data of birth is empty
	if(empty(trim($_POST["user_dob"])))
	{
		echo '<script language="javascript">';
        echo'alert("Please enter a Date of Birth."); location.href="hand_twostep.php"';
        echo '</script>';
        $err_dob = "yes";

	}
	elseif (trim($_POST["user_dob"]) != $server_dob) 
	{
		echo '<script language="javascript">';
        echo'alert("Invalid Date of Birth."); location.href="hand_twostep.php"';
        echo '</script>';
        $err_dob = "yes";		
	}
	else
	{
		$user_dob = trim($_POST["user_dob"]);
		echo $user_dob;
	}

	//check if otp is empty
	if(empty(trim($_POST["user_otp"])))
	{
		echo '<script language="javascript">';
        echo'alert("Please enter a OTP."); location.href="hand_twostep.php"';
        echo '</script>';
        $err_otp = "yes";
	}
	elseif (trim($_POST["user_otp"]) != $server_otp) 
	{
		echo '<script language="javascript">';
        echo'alert("Invalid OTP."); location.href="hand_twostep.php"';
        echo '</script>';
        $err_otp = "yes";		
	}
	else
	{
		$user_otp = trim($_POST["user_otp"]);
		echo $user_otp;
	}

	// Validate credentials

 	if(empty($err_dob) && empty($err_otp))
    {
    	session_start();
     	$_SESSION["steptwoverification"] = true;
     	header("location: hand_home.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="stylesheet/loginpage.css">
    <link rel="stylesheet" type="text/css" href="bootstrap-3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>

    </style>
</head>
<body id = "body">
	<img src="images/collegelablewe.jpg" class="img-responsive"/>
	<nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" id="button">
        <span class="icon-bar" id="bar"></span>
        <span class="icon-bar" id="bar"></span>
        <span class="icon-bar" id="bar"></span>                        
      </button>
  	 	<a href="index.php" class="navbar-brand" id="brand">
  	    PERSONA ASSESSMENT</a>
  	 </div>
  	 <div class="collapse navbar-collapse" id="myNavbar">
  	  <ul class="nav navbar-nav navbar-right">
  	 	<li style="font-size:15px;"><a href="logout.php"><span class="fa fa-reply"></span> Back</a></li>
  	 </ul> 
  	</div>
  </div>
</nav>
<br>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3" >
			<div class="panel panel-default" style="border-top:2px solid #087ec2;">
				<div class="panel-heading"> 
					<h1 class="panel-title" style="color:#087ec2; font-weight:bold;"><span class="glyphicon glyphicon-lock"></span> Head Login</h1>
				</div>
					<div class="panel-body">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<!-- admin login image -->
							<br><br>
					<!-- Date of Birth -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="dob"><span style="color: red">* </span>Date of Birth</label>
													<input type="date" name="user_dob" class="form-control <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $user_dob; ?>" id="dob">
													<span class="invalid-feedback" style="color:red;"><?php echo $err_dob; ?></span>
												</div><br>

												<!-- OTP -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="dob"><span style="color: red">* </span>OTP</label>
													<input type="text" name="user_otp" class="form-control <?php //echo (!empty($dob_err)) ? 'is-invalid' : ''; ?> " value="<?php //echo $dob; ?>" placeholder = "Enter OTP" id="dob">
													<span>OTP Will be send to your Email.</span>
												</div><br>
					<br>
						<div class="text-center">
							<button type="submit" id="loginbutton" name="btnLogin" class="btn btn-primary"><i class="glyphicon glyphicon-log-in"></i> Login</button>
						</div>
					</form>
					<br>
					<div class="panel-default" style="border-top:2px solid #087ec2;">
						<div class="panel-heading">
							<h1 class="panel-title" style=" color:#087ec2; font-weight: bold; text-align: center;">Head Login</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="footer">
	<p>Student Persona Assessment (SPA)</p>
</div>
</body>
</html>