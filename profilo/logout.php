<?php  

session_start();
$email=$_SESSION['username'];
   $offset = strlen($email)+1;
   echo $offset;
?>



