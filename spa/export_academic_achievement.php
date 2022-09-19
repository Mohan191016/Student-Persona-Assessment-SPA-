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

 $major = htmlspecialchars($_SESSION["department"]);

 $batch_code = $batchcode_err = $query_run_update = $query_run_insert = "";
$berror = $verror = 0;

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

                if (empty($vrollno))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Roll number is missing."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif(!preg_match('/^[A-Z0-9]*$/',$vrollno))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Roll number Invalid.\nCorrect Formate is UG12345/PG12345"); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif(strlen($vrollno) != 7)
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Roll number must Contain only 7 characters.\nCorrect Formate is UG12345/PG12345"); location.href="update_academic_achievement.php"';
                    echo '</script>';   
                }
                
                // Student Name Validation

                $vname = $line[1];

                if(empty($vname))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Name is missing."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif (!preg_match("/^[a-zA-Z-. ]*$/",$vname)) 
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Error in File.\nStudent Name contain only Letters, Dots and Space."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }

                $vpart1_k = $line[3];

                if(empty($vpart1_k))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart1_k != "A" && $vpart1_k != "B" && $vpart1_k != "C" && $vpart1_k != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart1_u = $line[4];

                if(empty($vpart1_u))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart1_u != "A" && $vpart1_u != "B" && $vpart1_u != "C" && $vpart1_u != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart1_r = $line[5];

                if(empty($vpart1_r))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart1_r != "A" && $vpart1_r != "B" && $vpart1_r != "C" && $vpart1_r != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart1_p = $line[6];

                if(empty($vpart1_p))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart1_p != "A" && $vpart1_p != "B" && $vpart1_p != "C" && $vpart1_p != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 
                
                $vpart2_k = $line[7];

                if(empty($vpart2_k))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart2_k != "A" && $vpart2_k != "B" && $vpart2_k != "C" && $vpart2_k != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart2_u = $line[8];

                if(empty($vpart2_u))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart2_u != "A" && $vpart2_u != "B" && $vpart2_u != "C" && $vpart2_u != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart2_r = $line[9];

                if(empty($vpart2_r))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart2_r != "A" && $vpart2_r != "B" && $vpart2_r != "C" && $vpart2_r != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                }

                $vpart2_p = $line[10];

                if(empty($vpart2_p))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart2_p != "A" && $vpart2_p != "B" && $vpart2_p != "C" && $vpart2_p != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart3_mk = $line[11];

                if(empty($vpart3_mk))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart3_mk != "A" && $vpart3_mk != "B" && $vpart3_mk != "C" && $vpart3_mk != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart3_mu = $line[12];

                if(empty($vpart3_mu))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart3_mu != "A" && $vpart3_mu != "B" && $vpart3_mu != "C" && $vpart3_mu != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart3_mr = $line[13];

                if(empty($vpart3_mr))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart3_mr != "A" && $vpart3_mr != "B" && $vpart3_mr != "C" && $vpart3_mr != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart3_mp = $line[14];

                if(empty($vpart3_mp))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart3_mp != "A" && $vpart3_mp != "B" && $vpart3_mp != "C" && $vpart3_mp != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 
                
                $vpart3_aak = $line[15];

                if(empty($vpart3_aak))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart3_aak != "A" && $vpart3_aak != "B" && $vpart3_aak != "C" && $vpart3_aak != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart3_aau = $line[16];
                if(empty($vpart3_aau))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart3_aau != "A" && $vpart3_aau != "B" && $vpart3_aau != "C" && $vpart3_aau != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart3_aar = $line[17];

                if(empty($vpart3_aar))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart3_aar != "A" && $vpart3_aar != "B" && $vpart3_aar != "C" && $vpart3_aar != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                } 

                $vpart3_aap = $line[18];

                if(empty($vpart3_aap))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Grade is Empty."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }
                elseif($vpart3_aap != "A" && $vpart3_aap != "B" && $vpart3_aap != "C" && $vpart3_aap != "O" )
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                }

                $vpart3_abk = $line[19];

                if($vpart3_abk != "A" && $vpart3_abk != "B" && $vpart3_abk != "C" && $vpart3_abk != "O" && (!empty($vpart3_abk)) )
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                     
                }

                $vpart3_abu = $line[20];

                if($vpart3_abu != "A" && $vpart3_abu != "B" && $vpart3_abu != "C" && $vpart3_abu != "O" && (!empty($vpart3_abu)) )
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>';
                }

                $vpart3_abr = $line[21];

                if($vpart3_abr != "A" && $vpart3_abr != "B" && $vpart3_abr != "C" && $vpart3_abr != "O" && (!empty($vpart3_abr)))
                {
                   $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>'; 
                }

                $vpart3_abp = $line[22]; 

                if($vpart3_abp != "A" && $vpart3_abp != "B" && $vpart3_abp != "C" && $vpart3_abp != "O" && (!empty($vpart3_abp)))
                {
                    $verror++;
                    echo '<script language="javascript">';
                    echo'alert("Invalid Grade Point."); location.href="update_academic_achievement.php"';
                    echo '</script>';
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

                    $part1_k = $line[3];
                    $part1_u = $line[4];
                    $part1_r = $line[5];
                    $part1_p = $line[6];

                    $part2_k = $line[7];
                    $part2_u = $line[8];
                    $part2_r = $line[9];
                    $part2_p = $line[10];

                    $part3_mk = $line[11];
                    $part3_mu = $line[12];
                    $part3_mr = $line[13];
                    $part3_mp = $line[14];

                    $part3_aak = $line[15];
                    $part3_aau = $line[16];
                    $part3_aar = $line[17];
                    $part3_aap = $line[18];

                    $tpart3_abk = $line[19];
                    
                    if(empty($tpart3_abk))
                    {
                        $part3_abk = "G";
                    }
                    else
                    {
                        $part3_abk = $line[19];
                    }

                    $tpart3_abu = $line[20];

                    if(empty($tpart3_abu))
                    {
                        $part3_abu = "G";
                    }
                    else
                    {
                        $part3_abu = $line[20];
                    }

                    $tpart3_abr = $line[21];

                    if(empty($tpart3_abr))
                    {
                        $part3_abr = "G";
                    }
                    else
                    {
                        $part3_abr = $line[21];
                    }

                    $tpart3_abp = $line[22];

                    if(empty($tpart3_abp))
                    {
                        $part3_abp = "G";
                    }
                    else
                    {
                        $part3_abp = $line[22];
                    }

                    $query = "SELECT batch_code FROM student_personal_details WHERE roll_no = '{$rollno}'";

                    $res = $link->query($query);
                    if($res->num_rows>0)
                    {
                    
                        while($row=$res->fetch_assoc())
                        {
                        
                            $batch_code = $row['batch_code'];
                        }
                        
                    }


                    $sql = "SELECT roll_no FROM student_academic_achievement WHERE roll_no = '{$rollno}'";
                    $res=$link->query($sql);
                    if($res->num_rows == 1)
                    {
                        $query = "UPDATE student_academic_achievement SET 
    I_K = '$part1_k', I_U = '$part1_u', I_R = '$part1_r', I_P = '$part1_p',
    II_K = '$part2_k', II_U = '$part2_u', II_R = '$part2_r', II_P = '$part2_p', 
    III_M_K = '$part3_mk', III_M_U = '$part3_mu', III_M_R = '$part3_mr', III_M_P = '$part3_mp',
    III_AA_K = '$part3_aak', III_AA_U = '$part3_aau', III_AA_R = '$part3_aar', III_AA_P = '$part3_aap',III_AB_K = '$part3_abk', III_AB_U = '$part3_abu', III_AB_R = '$part3_abr', III_AB_P = '$part3_abp' WHERE roll_no = '$rollno'";

                        $query_run_update = mysqli_query($link,$query);
                    }
                    else
                    {
                         $query = "INSERT INTO student_academic_achievement (roll_no, name, major,batch_code, I_K, I_U, I_R, I_P, II_K, II_U, II_R, II_P, III_M_K, III_M_U, III_M_R, III_M_P, III_AA_K, III_AA_U, III_AA_R, III_AA_P, III_AB_K, III_AB_U, III_AB_R, III_AB_P) VALUES ('{$rollno}', '{$name}', '{$major}', '{$batch_code}', '{$part1_k}', '{$part1_u}', '{$part1_r}', '{$part1_p}', '{$part2_k}', '{$part2_u}', '{$part2_r}', '{$part2_p}', '{$part3_mk}', '{$part3_mu}', '{$part3_mr}', '{$part3_mp}', '{$part3_aak}', '{$part3_aau}', '{$part3_aar}', '{$part3_aap}', '{$part3_abk}', '{$part3_abu}', '{$part3_abr}', '{$part3_abp}')";

                        $query_run_insert = mysqli_query($link,$query);
                    }

                    if($query_run_insert || $query_run_update == true)
                    {
                        echo '<script language="javascript">';
                        echo'alert("Saved."); location.href="update_academic_achievement.php"';
                        echo '</script>'; 
                    }
                }
            }
        }
    }
    else
    {
        echo '<script language="javascript">';
        echo'alert("Please Select CSV File."); location.href="update_academic_achievement.php"';
        echo '</script>';
    }
}
?>