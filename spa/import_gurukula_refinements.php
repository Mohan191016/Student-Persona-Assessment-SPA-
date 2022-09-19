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

$department = "";
$verror = 0;

if(isset($_POST['import']))
{
    // validate department

    if(empty(trim($_POST["department"])))
    {
        $verror++;
        echo '<script language="javascript">';
        echo'alert("Please Select Department."); location.href="update_gurukula_refinements.php"';
        echo '</script>';
    }
    else
    {
        $department = trim($_POST["department"]);
    }

    if ($verror == 0) 
    {
        header('Content-Type: text/csv; charset = utf-8');
        header('Content-Disposition: attachment; filename = student_gurukula_refinements.csv');
        $output = fopen("php://output", "w");

        fputcsv($output, array('ROLL NO', 'NAME','REG NO', 'DEPARTMENT', 'G1', 'G2', 'G3', 'G4', 'G5', 'G6', 'G7', 'G8', 'G9', 'G10', 'G11'));

        $query = "SELECT roll_no, name, reg_no, major from student_personal_details WHERE major = '{$department}' AND batch_code = '{$batch_code}' ORDER BY reg_no";

        $result = mysqli_query($link, $query);
        while($row = mysqli_fetch_assoc($result))
        {
            fputcsv($output, $row);
        }

        fclose($output);
    }
}

?>