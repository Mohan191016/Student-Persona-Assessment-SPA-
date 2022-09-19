<?php

$roll_no = $_POST['roll_no'];
include "config.php";
$sql="DELETE FROM student_personal_details WHERE roll_no = '{$roll_no}'" ;
$link->query($sql)


?>