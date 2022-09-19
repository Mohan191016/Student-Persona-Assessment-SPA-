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

   $query_run_update = $query_run_insert = $department = $department_err = "";
   $verror = 0;

   $batch_code = htmlspecialchars($_SESSION["batch_code"]);

   if(isset($_POST['export']))
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
                    //echo $vrollno;

                if (empty($vrollno))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Roll number is missing."); location.href="update_gurukula_refinements.php"';
                    echo '</script>';
                }
                elseif(!preg_match('/^[A-Z0-9]*$/',$vrollno))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Roll number Invalid.\nCorrect Formate is UG12345/PG12345"); location.href="update_gurukula_refinements.php"';
                    echo '</script>';
                }
                elseif(strlen($vrollno) != 7)
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Roll number must Contain only 7 characters.\nCorrect Formate is UG12345/PG12345"); location.href="update_gurukula_refinements.php"';
                    echo '</script>';   
                }

                    // Student Name Validation

                $vname = $line[1];
                    //echo $vname;

                if(empty($vname))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Name is missing."); location.href="update_gurukula_refinements.php"';
                    echo '</script>';
                }
                elseif (!preg_match("/^[a-zA-Z-. ]*$/",$vname)) 
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Name contain only Letters, Dots and Space."); location.href="update_gurukula_refinements.php"';
                    echo '</script>';
                }
                $vmajor = $line[3];

                if(empty($vmajor))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Major is missing."); location.href="update_gurukula_refinements.php"';
                    echo '</script>';
                }
                elseif($vmajor !== 'Economics' && $vmajor !== 'History' && $vmajor !== 'Commerce' && $vmajor !== 'Mathematics' && $vmajor !== 'Physics' && $vmajor !== 'Chemistry' && $vmajor !== 'Botany' && $vmajor !== 'Zoology' && $vmajor !== 'Computer Science' && $vmajor !== 'Commerce (CA)')
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Major is invalid."); location.href="update_gurukula_refinements.php"';
                    echo '</script>';
                }

                $v_g1 = $line[4];

                if($v_g1 == 0)
                {
                    $v_g1 = $line[4];
                }

                else
                {

                    if(empty($v_g1))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG1 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g1))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G1."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g1 <= 0) || ($v_g1 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G1."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                }

                $v_g2 = $line[5];

                if($v_g2 == 0)
                {
                    $v_g2 = $line[5];
                }

                else
                {

                    if(empty($v_g2))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG2 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g2))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G2."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g2 <= 0) || ($v_g2 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G2."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }

                $v_g3 = $line[6];

                if($v_g3 == 0)
                {
                    $v_g3 = $line[6];
                }

                else
                {

                    if(empty($v_g3))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG3 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g3))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G3."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g3 <= 0) || ($v_g3 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G3."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }

                $v_g4 = $line[7];

                if($v_g4 == 0)
                {
                    $v_g4 = $line[7];
                }

                else
                {

                    if(empty($v_g4))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG4 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g4))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G4."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g4 <= 0) || ($v_g4 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G4."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }

                $v_g5 = $line[8];

                if($v_g5 == 0)
                {
                    $v_g5 = $line[8];
                }

                else
                {

                    if(empty($v_g5))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG5 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g5))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G5."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g5 <= 0) || ($v_g5 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G5."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }

                $v_g6 = $line[9];

                if($v_g6 == 0)
                {
                    $v_g6 = $line[9];
                }

                else
                {

                    if(empty($v_g6))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG6 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g6))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G6."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g6 <= 0) || ($v_g6 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G6."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }

                $v_g7 = $line[10];

                if($v_g7 == 0)
                {
                    $v_g7 = $line[10];
                }

                else
                {

                    if(empty($v_g7))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG7 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g7))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G7."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g7 <= 0) || ($v_g7 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G7."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }

                $v_g8 = $line[11];

                if($v_g8 == 0)
                {
                    $v_g8 = $line[11];
                }

                else
                {

                    if(empty($v_g8))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG8 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g8))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G8."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g8 <= 0) || ($v_g8 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G8."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }

                $v_g9 = $line[12];

                if($v_g9 == 0)
                {
                    $v_g9 = $line[12];
                }

                else
                {

                    if(empty($v_g9))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG9 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g9))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G9."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g9 <= 0) || ($v_g9 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G9."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }

                $v_g10 = $line[13];

                if($v_g10 == 0)
                {
                    $v_g10 = $line[13];
                }

                else
                {

                    if(empty($v_g10))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG10 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g10))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G10."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g10 <= 0) || ($v_g10 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G10."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
                    }
                    
                }
                $v_g11 = $line[14];

                if($v_g11 == 0)
                {
                    $v_g11 = $line[14];
                }

                else
                {

                    if(empty($v_g11))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nG11 is Empty."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    elseif(!is_numeric($v_g11))
                    {
                        $verror++;
                        echo '<script language="javascript">';
                        echo'alert("Error in File.\nInvalid G11."); location.href="update_gurukula_refinements.php"';
                        echo '</script>';
                    }
                    else
                    {
                        if(($v_g11 <= 0) || ($v_g11 >= 11))
                        {
                            $verror++;
                            echo '<script language="javascript">';
                            echo'alert("Error in File.\nInvalid G11."); location.href="update_gurukula_refinements.php"';
                            echo '</script>';
                        }
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
                    $name = $line[1];
                    $major = $line[3];
                    $g1 = $line[4];
                    $g2 = $line[5];
                    $g3 = $line[6];
                    $g4 = $line[7];
                    $g5 = $line[8];
                    $g6 = $line[9];
                    $g7 = $line[10];
                    $g8 = $line[11];
                    $g9 = $line[12];
                    $g10 = $line[13];
                    $g11 = $line[14];

                    $g12 = ($g1 + $g2 + $g3 + $g4 + $g5 + $g6 + $g7 + $g8 + $g9 + $g10 + $g11) / 11;
                    
                     $sql = "SELECT roll_no FROM student_gurukula_refinements WHERE roll_no = '{$rollno}'";
                            $res=$link->query($sql);
                            if($res->num_rows == 1)
                            {
                                $query = "UPDATE student_gurukula_refinements SET G1 = '$g1',  G2 = '$g2', G3 = '$g3',G4 = '$g4', G5 = '$g5', G6 = '$g6', G7 = '$g7', G8 = '$g8', G9 = '$g9', G10 = '$g10', G11 = '$g11', G12 = '$g12'  WHERE roll_no = '$rollno'";

                                if(mysqli_query($link,$query))
                                {
                                    echo '<script language="javascript">';
                                    echo'alert("Saved."); location.href="update_gurukula_refinements.php"';
                                    echo '</script>';
                                }
                            }
                            else
                            {
                                $query = "INSERT INTO student_gurukula_refinements (roll_no,name,major,batch_code, G1,G2,G3,G4,G5,G6,G7,G8,G9,G10,G11,G12) VALUES ('{$rollno}','{$name}', '{$major}','{$batch_code}', '{$g1}', '{$g2}', '{$g3}', '{$g4}', '{$g5}', '{$g6}', '{$g7}', '{$g8}', '{$g9}', '{$g10}', '{$g11}', '{$g12}')";

                                if(mysqli_query($link,$query))
                                {
                                    echo '<script language="javascript">';
                                    echo'alert("Saved."); location.href="update_gurukula_refinements.php"';
                                    echo '</script>';
                                }
                            }
                }
            }
        }
    }
    else
    {
        echo '<script language="javascript">';
        echo'alert("Please Select CSV File."); location.href="update_gurukula_refinements.php"';
        echo '</script>';
    }
}
?>