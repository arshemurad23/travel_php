
<?php

include('dbinfo.php');

$id = $_REQUEST['id'];

$qur = "DELETE from user_signup WHERE id = '$id'"; 
$res = mysqli_query($con,$qur);
if($res == true){

    header('location:dashboard.php');
}

?>