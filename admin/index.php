 <?php
  session_start();
  $noNavbar   = '';
  $printTitle = ('Login');
  if (isset($_SESSION['Username'])) {
  header('Location: dashboard.php');
  }
  include 'init.php';
  
  // Check IF User Coming In Html

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $username = $_POST['user'];
   $password = $_POST['pass'];
   $hashedPass = sha1($password);

   $stmt = $con->prepare("SELECT UserID, Username,Password 
    FROM 
        users
    Where 
         Username =? 
    AND  
         Password=? 
    AND  
         GropID= 1 
      LIMIT 1");



   $stmt->execute(array($username,$hashedPass));
   $row = $stmt->fetch();
   $count = $stmt->rowCount();
   
 if ($count > 0 ) {

 	$_SESSION['Username'] = $username;      // Register Session Name 
  $_SESSION['ID']       = $row['UserID'];// Register  Session ID
 	header('Location: dashboard.php');    // Register To Dashbord Page 

 	exit();
 }
 }
  ?>

<div class="container log">
   <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>"  method='POST'>
    <h2 class="text-center">Admin Login</h2>
    <input class= "form-control input-lg"  type="text" name="user" placeholder="Username" autocomplete="off" />
    <input class= "form-control input-lg"  type="password" name="pass" placeholder="Password" autocomplete="new_password">
    <input  class="btn btn-primary btn-block  input-lg" type="submit" value="Login" style="font-size: 23px;  ">
   </form>
</div>

 <?php include   $tpl."foooter.php"; ?>


 