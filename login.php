 <?php
  session_start();

  $printTitle = ('Login');

  if (isset($_SESSION['user'])) {

  header('Location: index.php');
  }
  include "init.php";

 

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

if (isset($_POST['login'])) {

   $user       = $_POST['username'];
   $pass       = $_POST['password'];


   $hashedPass = sha1($pass);

   $stmt = $con->prepare("SELECT  UserID, Username,Password 
    FROM 
        users
    Where 
         Username =? 
    AND  
         Password=? 
    ");


   $stmt->execute(array($user,$hashedPass));
   $get = $stmt->fetch();
   $count = $stmt->rowCount();
   
  if ($count > 0 ) {

 $_SESSION['user'] = $user;           // Register Session Name 
 $_SESSION['usid'] = $get['UserID']; // Register User ID In Session
 header('Location: index.php');     // Register To Dashbord Page 

exit();
 }

}  else {

  $fromErrors = array();

  $username  = $_POST['username'];
  $password  = $_POST['password'];
  $password2 = $_POST['password2'];
  $email     = $_POST['email'];

  if (isset($_POST['username'])){

  $FlterUser = filter_var($username, FILTER_SANITIZE_STRING);
  



if (strlen($FlterUser) < 4){


$fromErrors[] = 'Username Must Be Larger Than 4 Characters';




     }

    }
  if (isset($password) && isset($password2)){

   if (empty($password)) {

  

    $fromErrors[] = "Soory Password Cant Be Empty";

   }
  

        
      if (sha1($password) !==  sha1($password2)){


        $fromErrors[] = "Soory Password Ist Not Match";
      }

       
       }
   

    if (isset($_POST['email'])){

    $flterEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  

if  (filter_var($flterEmail, FILTER_VALIDATE_EMAIL) != true){

    $fromErrors[] = "This Email Is Not Vaild";


            }

        }

 
    if (empty($fromErrors)) {
  // Check If User Exiest in Database 
    $check = checkItem('Username', 'users', $username );
  
      if ($check == 1) {

         $fromErrors[] = "Soory This User Is Exiest";

    

      } else {
    // Insert Userinfo In Datebase 

         $stmt = $con->prepare("INSERT INTO
                              users (Username,Password ,Email, RagStutes,  Date) 
                              VALUES (:zuser, :zpass, :zmail, 0 ,now()) ");
         $stmt->execute(array (
             
             'zuser' => $username,
             'zpass' => sha1($password),
             'zmail' => $email,
       
        ));          

     $successMsg = "Congrats You Are Now Registerd User";


     }
   }
 } 
}

  ?>

   <div class="container login-page">
   	<h1 class="text-center">
   		<span class="selected" data-class="login">Login</span> | 
   		<span data-class="signup">Signup</span>
   	</h1>

       <!-- Start login Form-->
   	 <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>"  method='POST'>
  	       <div class="input-container">
  	 	     <input class= "form-control"  type="text" name="username" placeholder="Type Your username" autocomplete="off" required="required" />
  	 	   </div>
  	 	   <div class="input-container">
  	         <input class= "form-control"  type="password" name="password" placeholder="Type Your Password" autocomplete="new_password"  required="required">
  	      </div>
  	      <input  class="btn btn-primary btn-block" name="login" type="submit" value="Login">
  	      
    </form>
    <!-- End login Form-->
    <!-- Start Signup Form-->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>"  method='POST'>
    	     <div class="input-container">
               <input 
               pattern=".{4,}"
               title="Username Must Be Between 4 Chars"
               class= "form-control" 
                type="text" 
                name="username" 
                placeholder="Type Your username"
                 autocomplete="off"
                  required="required" />
           </div>
           <div class="input-container">
  	        <input 
             minlength="4"
             class= "form-control" 
             type="password" name="password" 
             placeholder="Type Your Complex Password" >
  	     </div>
  	     <div class="input-container">
  	       <input 
           minlength="4"
           class= "form-control"
           type="password" 
           name="password2"
           placeholder="Type a Password again"
           autocomplete="new_password">
  	     </div>
  	     <div class="input-container">
  	       <input

          class= "form-control" 
          type="email"
          name="email"
          placeholder="Type a Vaild Email" >
  	      </div>
  	      <input  class="btn btn-success btn-block" name="signup" type="submit" value="Signup">

   	 </form>
   <!-- End Sginup Form-->
    <div class="the-errors text-center">
    <?php 
    
    if (!empty($fromErrors)) {

    foreach ($fromErrors as $error) {
     
      echo '<div class="msg error">' . $error . '</div>';
    }

    }
    if (isset($successMsg)) {

      echo '<div class="msg success">' . $successMsg  . "</div>";
    }



    ?>
    </div>
   </div>



   <?php include   $temp."foooter.php"; ?>
