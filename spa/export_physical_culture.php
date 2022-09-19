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

$batch_code = $batchcode_err = $query_run_update = $query_run_insert = $year_of_study = "";
$verror = 0;

if(isset($_POST['export']))
{
    if (empty(trim($_POST["year_of_study"]))) 
    {
        $verror++;
        echo '<script language="javascript">';
        echo'alert("Please enter the Year of Study."); location.href="update_physical_culture.php"';
        echo '</script>';
    }
    else
    {
        $year_of_study = trim($_POST["year_of_study"]);  
        //echo $year_of_study;   
    }

    if($verror == 0)
    {
        $csvMimes= array('application/vnd.ms-excel', 'text/plain', 'text/csv');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
        {
            if(is_uploaded_file($_FILES['file']['tmp_name']))
            {
                $csvfile = fopen($_FILES['file']['tmp_name'], 'r');
                fgetcsv($csvfile);
                while (($line = fgetcsv($csvfile)) !== FALSE)
                {
                // Roll Number Verification

                    $vrollno = $line[0];

                    if (empty($vrollno))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nStudent Roll number is missing."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }
                    elseif(!preg_match('/^[A-Z0-9]*$/',$vrollno))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nStudent Roll number Invalid.\nCorrect Formate is UG12345/PG12345"); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }
                    elseif(strlen($vrollno) != 7)
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nStudent Roll number must Contain only 7 characters.\nCorrect Formate is UG12345/PG12345"); location.href="update_physical_culture.php"';
                        echo '</script>';   
                    }



                    // 100 MD Verification

                    $vone_md = $line[5];

                    if (empty($vone_md))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\n100 Meter Dash is Empty."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($vone_md))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid 100 Meter Dash."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }

                    //four hundred meter dash

                    $vfour_md = $line[6];

                    if (empty($vfour_md))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\n400 Meter Dash is Empty."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($vfour_md))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid 400 Meter Dash."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }

                    $vlong_jump = $line[7];

                    if (empty($vlong_jump))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nLong Jump is Empty."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($vlong_jump))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid Long Jump."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }

                    // pull ups

                    $vpull_ups = $line[8];

                    if (empty($vpull_ups))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nPull Ups is Empty."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($vpull_ups))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid Pull Ups."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }
                    elseif(preg_match('@[^\w]@',$vpull_ups))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid Pull Ups."); location.href="update_physical_culture.php"';
                        echo '</script>';
                    }

                    if(($year_of_study == "I Year") || ($year_of_study == "III Year"))
                    {
                        $vheight = $line[9];

                        if (empty($vheight))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nHeight is Empty."); location.href="update_physical_culture.php"';
                            echo '</script>';
                        }
                        elseif(!is_numeric($vheight))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid Height."); location.href="update_physical_culture.php"';
                            echo '</script>';
                        }

                        $vweight = $line[10];

                        if (empty($vweight))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\Weight is Empty."); location.href="update_physical_culture.php"';
                            echo '</script>';
                        }
                        elseif(!is_numeric($vweight))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid Weight."); location.href="update_physical_culture.php"';
                            echo '</script>';
                        }
                    }

                }

                fclose($csvfile);
                if ($verror == 0)
                {
                    $csvfile = fopen($_FILES['file']['tmp_name'], 'r');
                    fgetcsv($csvfile);
                    while (($line = fgetcsv($csvfile)) !== FALSE)
                    {
                        $rollno = $line[0];
                        //$reg_no = $line[1];
                        $name = $line[2];
                        $major = $line[3];
                        $batch_code = $line[4];
                        $one_md = $line[5];
                        $four_md = $line[6];
                        $long_jump = $line[7];
                        $pull_ups = $line[8];

                        if($year_of_study == "I Year")
                        {
                            $height = $line[9];
                            $weight = $line[10];

                            $sql = "SELECT roll_no FROM student_physical_culture WHERE roll_no = '{$rollno}'";
                            $res=$link->query($sql);
                            if($res->num_rows == 1)
                            {
                                $query = "UPDATE student_physical_culture SET I_100_MD = '$one_md', I_400_MD = '$four_md', I_long_jump = '$long_jump',I_pull_ups = '$pull_ups', height_joining = '$height', weight_joining = '$weight' WHERE roll_no = '$rollno'";

                                if(mysqli_query($link,$query))
                                {
                                    echo '<script language="javascript">';
                                    echo'alert("Saved."); location.href="update_physical_culture.php"';
                                    echo '</script>';
                                }
                            }
                            else
                            {
                                $query = "INSERT INTO student_physical_culture (roll_no,name,major,batch_code, I_100_MD, I_400_MD, I_long_jump, I_pull_ups, height_joining, weight_joining) VALUES ('{$rollno}','{$name}', '{$major}','{$batch_code}', '{$one_md}', '{$four_md}', '{$long_jump}', '{$pull_ups}', '{$height}', '{$weight}')";

                                if(mysqli_query($link,$query))
                                {
                                    echo '<script language="javascript">';
                                    echo'alert("Saved."); location.href="update_physical_culture.php"';
                                    echo '</script>';
                                }
                            }
                        }
                        elseif($year_of_study == "II Year")
                        {
                            $sql = "SELECT roll_no FROM student_physical_culture WHERE roll_no = '{$rollno}'";
                            $res=$link->query($sql);
                            if($res->num_rows == 1)
                            {
                                $query = "UPDATE student_physical_culture SET II_100_MD = '$one_md', II_400_MD = '$four_md', II_long_jump = '$long_jump',II_pull_ups = '$pull_ups' WHERE roll_no = '$rollno'";

                                if(mysqli_query($link,$query))
                                {
                                    echo '<script language="javascript">';
                                    echo'alert("Saved."); location.href="update_physical_culture.php"';
                                    echo '</script>';
                                }
                            }
                            else
                            {
                                $query = "INSERT INTO student_physical_culture (roll_no,name,major,batch_code II_100_MD, II_400_MD, II_long_jump, II_pull_ups) VALUES ('{$rollno}', '{$name}', '{$major}','{$batch_code}','{$one_md}', '{$four_md}', '{$long_jump}', '{$pull_ups}')";
                                
                                if(mysqli_query($link,$query))
                                {
                                    echo '<script language="javascript">';
                                    echo'alert("Saved."); location.href="update_physical_culture.php"';
                                    echo '</script>';
                                }
                            }
                        }
                        else
                        {
                            $height = $line[9];
                            $weight = $line[10];

                            $sql = "SELECT roll_no FROM student_physical_culture WHERE roll_no = '{$rollno}'";
                            $res=$link->query($sql);
                            if($res->num_rows == 1)
                            {
                                $query = "UPDATE student_physical_culture SET III_100_MD = '$one_md', III_400_MD = '$four_md', III_long_jump = '$long_jump',III_pull_ups = '$pull_ups', height_leaving = '$height', weight_leaving = '$weight' WHERE roll_no = '$rollno'";

                                if(mysqli_query($link,$query))
                                {
                                    echo '<script language="javascript">';
                                    echo'alert("Saved."); location.href="update_physical_culture.php"';
                                    echo '</script>';
                                }
                            }
                            else
                            {
                                $query = "INSERT INTO student_physical_culture (roll_no,name,major,batch_code III_100_MD, III_400_MD, III_long_jump, III_pull_ups, height_leaving, weight_leaving) VALUES ('{$rollno}','{$name}', '{$major}','{$batch_code}', '{$one_md}', '{$four_md}', '{$long_jump}', '{$pull_ups}', '{$height}', '{$weight}')";
                                
                                if(mysqli_query($link,$query))
                                {
                                    echo '<script language="javascript">';
                                    echo'alert("Saved."); location.href="update_physical_culture.php"';
                                    echo '</script>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

?>