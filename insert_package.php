<?php

include('dbinfo.php');

if(isset($_POST['add'])){
 
    $name = $_POST['name'];
  $location = $_POST['location'];
  $day = $_POST['days'];

$img = $_FILES['pic']['name'];
$tpm_img = $_FILES['pic']['tmp_name'];
$folder = 'assets/img/' . $img ; 
move_uploaded_file($tpm_img,$folder);

$bedroom = $_POST['bedroom'];
$washroom = $_POST['washroom'];
$nearby = $_POST['nearby'];
$description = $_POST['descrip'];
$price = $_POST['price'];



  if($name != "" && $location != "" && $day != "" &&   $img != "" && $bedroom != "" && $washroom != "" && $nearby != "" && $description != "" && $price != "" ){

  $que = "insert into packages values(null, '$name' , '$location' , '$day'  , '$img' ,'$bedroom', '$washroom' , '$nearby','$description','$price')";
  
  $res = mysqli_query($con,$que);
  if($res == true){
    header('location:dashboard.php');
  }

}
}

?>