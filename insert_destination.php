<?php

include('dbinfo.php');

if(isset($_POST['add'])){
 
    $country = $_POST['country'];

$img = $_FILES['pic']['name'];
$tpm_img = $_FILES['pic']['tmp_name'];
$folder = 'assets/img/' . $img ; 
move_uploaded_file($tpm_img,$folder);
$tour = $_POST['tour'];



  if($country != "" && $img != "" && $tour != ""){

  $que = "insert into destination values(null, '$country' , '$img' , '$tour')";
  
  $res = mysqli_query($con,$que);

  if($res == true){

    header('location:dashboard.php');
  
  }

}
}

?>