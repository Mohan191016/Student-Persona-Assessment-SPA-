<?php

include "config.php";
$sql="delete from student_personal_details where roll_no=".$_POST["rollno"];
$link->query($sql);

?>