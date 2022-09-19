<?php

require_once "config.php";

$rollno = "UG19030";

$query = "SELECT batch_code FROM student_personal_details WHERE roll_no = '{$rollno}'";

$res = $link->query($query);

if($res->num_rows>0)
{
                    
    while($row=$res->fetch_assoc())
    {
                        
    $batch_code = $row['batch_code'];

    echo($batch_code);
}
                        
}
?>
