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

$uname = $sname = $tsname = $email = $temail = $error = $dob = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$id = $_POST['id'];
	$uname = $_POST['user_name'];

	// Validate Staffname

	if(empty(trim($_POST["staff_name"])))
	{
		$error++;
		echo '<script language="javascript">';
		echo'alert("Please enter a staff Name."); location.href="hand_edit.php"';
		echo '</script>';
	}
	else
	{
		$tsname=trim($_POST["staff_name"]);
	} 
	if(!preg_match("/^[a-zA-Z-'. ]*$/",$tsname))
	{
		$error++;
		echo '<script language="javascript">';
		echo'alert("Only letters, white space and dots are allowed."); location.href="hand_edit.php"';
		echo '</script>';
	} 
	else
	{
		$aname = trim($_POST["staff_name"]);
	}

	// Email Validation

	if (empty(trim($_POST["email"]))) 
	{
		$error++;
		echo '<script language="javascript">';
		echo'alert("Please enter a Email."); location.href="hand_edit.php"';
		echo '</script>';
	} 
	else 
	{
		$temail = trim($_POST["email"]);
	    // check if e-mail address is well-formed
		if (!filter_var($temail, FILTER_VALIDATE_EMAIL)) 
		{
			$error++;
			echo '<script language="javascript">';
		  echo'alert("Invalid email format."); location.href="hand_edit.php"';
			echo '</script>';
		}
		else
		{
			$email = trim($_POST["email"]);
		}
	}

	//validate date of birth
	if (empty(trim($_POST["dob"])))
	{
		$error++;
		echo '<script language="javascript">';
		echo'alert("Please Enter the Date of Birth."); location.href="hand_edit.php"';
		echo '</script>';
	
	}
	else
	{
		$dob = trim($_POST["dob"]);
	}	

	if($error==0)
	{
		$query = "UPDATE hand_login SET staff_name = '$aname', email = '$email', dob = '$dob' WHERE user_name = '$uname'";
		$query_run = mysqli_query($link,$query);

		if($query_run)
		{
			echo '<script language="javascript">';
			echo'alert("Update Successfully"); location.href="hand_edit.php"';
			echo '</script>';
		}
	}
	else
	{
		echo '<script language="javascript">';
		echo'alert("Not Updated"); location.href="hand_edit.php"';
		echo '</script>';
	}
}

?>

<!-- Modal -->

<div class="modal fade" id="editpopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-light" style="border-top:3.5px solid #087ec2;">
				<h6 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i><spam>  Edit Faculty Details</spam></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<div class="modal-body">
					<h3 class="card-title card-title-new">Faculty Login Detail</h3>
					<!-- username -->
					<div class="form-group">	
						<label style="font-size: 17px; color:dimgrey; font-weight: bold;" for="user_name"> <span style="color: red">* </span>User Name</label>
						<input type="text" name="user_name" class="form-control " value="" placeholder="Enter Faculty Username" id="user_name" readonly="readonly">
					</div>
					<h3 class="card-title card-title-new">Faculty Personal Details</h3>
					<!-- Faculty name -->
					<div class="form-group">
						<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="sname"><span style="color: red">* </span>Faculty Name</label>
						<input type="text" name="staff_name" class="form-control" id="Faculty_name" placeholder="Enter Faculty Name">
					</div>
					<!-- Date of Birth -->
					<div class="form-group">
						<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="dob"><span style="color: red">* </span>Date of Birth</label>
						<input type="date" name="dob" class="form-control" id="dob" placeholder="Enter Faculty DOB">
					</div>
					<!-- email -->
					<div class="form-group">
						<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="email"><span style="color: red">* </span>Email Id</label>
						<input type="text" name="email" class="form-control" id="email" placeholder="Enter Email Id">
					</div>
					<input type="hidden" name="id" id="id" value="0">
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="sumit" class="btn btn-success" name="update"><i class = 'fa fa-edit'></i>&nbsp;Save changes</button>
				</div>

			</form>
		</div>
	</div>
</div>


<div class="row">
	<!-- <div class="col-lg-12 col-md-12 col-sm-12"> -->
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead style="background-color:#057EC5; color:#FFF;">
					<tr>
						<th style="text-align:center;">Sl.No</th>
						<th style="text-align:center;">Faculty Name</th>
						<th style="text-align:center;">User Name</th>
						<th style="text-align:center;">DOB</th>
						<th style="text-align:center;">Email Id</th>
						<th style="text-align:center;">Status</th>
						<th style="text-align:center;">Edit Faculty</th>
						<th style="text-align:center;">Delete Faculty</th>
					</tr>
				</thead>
					<?php
					$sql = "SELECT * FROM hand_login";
					$res = $link->query($sql);
					if($res->num_rows>0)
					{
						$i=0;
						while($row = $res->fetch_assoc())
						{
							$i++;
							echo"<tr style='text-align:center;'>";
							echo"<td>{$i}</td>";
							echo"<td>{$row["staff_name"]}</td>";
							echo"<td>{$row["user_name"]}</td>";
							echo"<td>{$row["dob"]}</td>";
							// $dob = $row["dob"];
							// $dmydob = date("d-m-Y", strtotime($dob));
							// echo"<td>$dmydob</td>";
							// echo "<td>$edob</td>";
							echo"<td>{$row["email"]}</td>";
							$status = $row["status"];
							if($status == 1)
							{
								echo "<td>Activated</td>";
								//$status="Activated";
							}
							else
							{
								echo "<td>Not Activated</td>";
							}
							//echo"<td>{$row["status"]}</td>";
							echo"<td><button type='button' class='btn btn-sm btn-success edit' data-id={$row["id"]}><i class = 'fa fa-edit'></i></td>";
							echo"<td><button type='button' class='btn btn-sm btn-danger del' data-id={$row["id"]}><i class = 'fa fa-trash-o'></i></td>";
							echo"</tr>";
						}
					}
					else
					{
						echo"<tr>";
						echo"<td colspan = '7' style = 'text-align:left;'>No Faculty found...</td>";
						echo"</tr>";
					}
					?>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('table').DataTable({
			ordering:false,
		});
	});

	$(document).ready(function(){
		$('.edit').on('click',function(){
			$('#editpopup').modal('show');
			var row=$(this);
			var id=$(this).attr("data-id");
			$("#id").val(id);
			var name=row.closest('tr');
			var data = name.children("td").map(function(){
			return $(this).text();
			}).get();

			console.log(data);
			$('#Faculty_name').val(data[1]);
			$('#user_name').val(data[2]);
			$('#dob').val(data[3]);
			$('#email').val(data[4]);
		});
	});

</script>
