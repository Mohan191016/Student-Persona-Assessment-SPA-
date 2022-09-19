<?php
 
 if(isset($_GET['UserName']) && isset($_GET['Token']))
 {
 	$status = "";
 	$uname = $_GET['UserName'];
	$get_verify_token = $_GET['Token'];

	require_once "config.php";

	$sql = "SELECT verify_token, status FROM admin_login WHERE user_name = '$uname'";
	$result =  $link->query($sql);
	if($result -> num_rows > 0)
	{
		while($row = $result -> fetch_assoc())
		{
			$verify_token = $row["verify_token"];
			$status = $row["status"];
		}
	}
	if ($status == 0) 
	{
		$status = 1;
        $query = "update admin_login set status = '$status' where user_name = '$uname'";
        mysqli_query($link, $query);
		header("Location:index.php?active=true");
	}
	else
	{
		echo '<script language="javascript">';
        echo'alert("Account Already Activated."); location.href="index.php"';
        echo '</script>';
	}
 }

?>