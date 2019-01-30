<?php

/*
=================================================
=== Mange Members Page
=== You Can Add | Edit | Delete Membors From Hear
=================================================
*/

  session_start();

  $printTitle = ('Membors');

  if (isset($_SESSION['Username'])) {


   include 'init.php';

   $do =  isset($_GET['do']) ? $_GET['do'] : 'Mange';

     // Start The Mange Page
  if ($do == 'Mange'){// Mange Members Page


  $qeury = '';

  if(isset($_GET['page']) && $_GET['page'] == 'Pending') {

  $qeury =  'AND RagStutes = 0' ; 

   
  }
   // Select All Users
   $stmt = $con->prepare("SELECT * FROM users WHERE GropID != 1  $qeury ");

    // Execute The Statment
   $stmt->execute();

   // Assigen To Variable
   $row = $stmt->fetchAll();
   if (! empty($row)) {
 
   
  	?>

    <h1 class="text-center"> Mange Members</h1>
    	 <div class="container">
    	 	<div class="table-responsive">
		    	 		<table class="main-table text-center table table-bordered">
				    	 			<tr>
					    	 					<td>#ID</td>
					    	 					<td>Username</td>
					    	 					<td>Email</td>
					    	 					<td>Full Name</td>
					    	 					<td>Full Jobb</td>
					    	 					<td>Registered Date</td>
					    	 		   <td>Control</td>
				    	 			</tr>
				    	 			  <?php
				    	 			     foreach ($row as $rows) {
	                      echo "<tr>";
	                        echo "<td>" . $rows['UserID']  . "</td>";
	                        echo "<td>" . $rows['Username']. "</td>";
	                        echo "<td>" . $rows['Email']   . "</td>";
	                        echo "<td>" . $rows['FullName']. "</td>";
	                        echo "<td>" . $rows['Job']    . "</td>";
	                        echo "<td>" . $rows['Date']    . "</td>";
	                        echo "<td> 
	     <a href='Members.php?do=Edit&userid=" .$rows['UserID']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
	     
	     <a href='Members.php?do=Delete&userid=" .$rows['UserID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

	     if ($rows['RagStutes'] == 0 ) {

	    echo  	"<a href='Members.php?do=Actiavte&userid=" .$rows['UserID']."' class='btn 

											    btn-info actiavte'><i class='fa fa-check'></i>Actiavte</a>";
	                       }
	                                 echo "</td>";
							         echo "</tr>";

				    	 			     }
				    	 			     
				    	 			  ?>
				    	
				    	 		</table>

							 <a href="members.php?do=Add" class="btn btn-primary">
						   <i class="fa fa-plus"></i> New Member
					     </a>
		    	     </div>      
				 </div>
     <?php } else {
     echo "<div class='container'>";

     echo  "<div class='nice nice-message'>There is No Recored To Show</div>";
     echo '<a href="members.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Member
						</a>';
	 echo "</div>";

     }?>
   
    <?php  


   } elseif ($do == 'Add') { 	// Add Members page?>
  

 	<h1 class="text-center"> Add New Members</h1>
	    	 <div class="container">
	    	  <form class="form-horizontal" action="?do=Insert" method="POST"/>
	    	  	     <!-- Start UserName Field-->
	    	         <div class="form-group form-group-lg">
	                  <label class="col-sm-2 control-label">USER NAME</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="text" name="Username"  class="form-control"  autocomplete="off" required='required' placeholder="Username To Login Shop" />
	                   </div>
	                 </div>
	                 <!-- End UserName Field-->
	                 <!-- Start Password Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Password</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="password" name="password" class="password form-control" autocomplete="new-password" required='required' placeholder="Password Must Be Hard & Comlex" />
	                   	 	 <i class="show-pass fa fa-eye fa-2x"></i>
	                   </div>
	                 </div>
	                 <!-- End Passwoed Field-->
	                 <!-- Start Email Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Email</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="email" name="email"  class="form-control" required='required' placeholder="Email Must Be Valid" />
	                   </div>
	                 </div>
	                 <!-- End Email Field-->
	                  <!-- Start Fullname Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Full Name</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="exet" name="full"  class="form-control" required='required' placeholder="Full Name Appear In Your Profile Page" />
	                   </div>
	                 </div>
	                 <!-- End Fullname Field-->
	                 <!-- Start Submit Field-->
	    	         <div class="form-group">
	                   <div class="col-sm-offset-2 col-sm-10">
	                   	 <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
	                   </div>
	                 </div>
	                 <!-- End Submit Field-->
	    	  </form>
	    	 </div>

     <?php 
    } elseif ($do == 'Insert') {
   

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   echo "<h1 class='text-center'>Inserted  Member</h1>";
   echo "<div calss='container'>";
     
     // Get Variables From The Form
   	
   	$user  = $_POST['Username'];
   	$pass  = $_POST['password'];
   	$email = $_POST['email'];
   	$name  = $_POST['full'];

   	$hashpass = sha1($_POST['password']);
 
    
   	// Valdidate The Form 
   $fromErrors = array();
   if(strlen($user) < 4 ){
    $fromErrors[] = '<div class="alert alert-danger">Username Cant Be Less Then <strong>4 Chrachters</strong></div>';

   }
    if(strlen($user)> 20 ){
    $fromErrors[] = 'Username Cant Be More Then<strong>20 Chrachters</strong>';

   }
   if (empty($user)) {

   $fromErrors[] = 'Username Cant Be <strong>Empty</strong>';


   }
   if (empty($pass)) {

   $fromErrors[] = 'Password Cant Be <strong>Empty</strong>';


   }
   if (empty($email )) {

  $fromErrors[] = 'Email Cant Be <strong>Empty</strong>';

   }
   if (empty($name )) {

 $fromErrors[] = 'FullName Cant Be Empty Be <strong>Empty</strong>';

   }

   foreach ($fromErrors as $error) {
   	
   	echo '<div class="alert alert-danger">'.$error. '</div>' ;
   }
    
    if (empty($fromErrors)) {
  // Check If User Exiest in Database 
    $check = checkItem('Username', 'users', $user );

  
	  	if ($check == 1) {
    echo "<div class='container'>";
	  	$theMsg =  "<div class='alert alert-danger'>Soory This Name Is Exiest</div>"; 
	  	redirectHome($theMsg, 'back');
    echo "</div>";

	  	} else {

			 	// Insert Userinfo In Datebase 

			   $stmt = $con->prepare("INSERT INTO
			                        users (Username,Password ,Email, FullName, RagStutes,  Date) 
			                        VALUES (:zuser, :zpass, :zmail, :zname,1,now())	");
			   $stmt->execute(array (
			       
			       'zuser' =>  $user,
			       'zpass' =>  $hashpass,
			       'zmail' =>  $email,
			       'zname' =>  $name
			  ));          




			   	// echo Success  Message 
			  echo "<div class='container'>";
			  $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount(). ' Record Insert</div>';
			 	redirectHome($theMsg , 'back');
			 	echo "</div>";
 }
    }
  
   } else {
   
   echo "<div class='container'>";
   $theMsg =  "<div class='alert alert-danger'>Sorry You Can The Browser This Page Dircetory</div>";
   redirectHome($theMsg);
   echo "</div>";
      }
    
    echo "</div>";



   } elseif ($do == 'Edit'){  //Edit Page 

 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?intval($_GET['userid']) : 0 ;

     $stmt = $con->prepare("SELECT *
    FROM 
        users
    Where 
         UserID =? 
      LIMIT 1");



   $stmt->execute(array( $userid ));
   $row = $stmt->fetch();
   $count = $stmt->rowCount();
   
    if ($count > 0 ) { ?>

	    	<h1 class="text-center"> Edit Users</h1>
	    	 <div class="container">
	    	  <form class="form-horizontal" action="?do=Update" method="POST"/>
	    	  	<input type="hidden" name="userid" value="<?php echo  $userid  ?>" />
	    	  	     <!-- Start UserName Field-->
	    	         <div class="form-group form-group-lg">
	                  <label class="col-sm-2 control-label">USER NAME</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="text" name="Username" value="<?php echo $row['Username'] ?>" class="form-control"  autocomplete="off" required='required'/>
	                   </div>
	                 </div>
	                 <!-- End UserName Field-->
	                 <!-- Start Password Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Password</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
	                   	 <input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
	                   </div>
	                 </div>
	                 <!-- End Passwoed Field-->
	                 <!-- Start Email Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Email</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required='required'/>
	                   </div>
	                 </div>
	                 <!-- End Email Field-->
	                  <!-- Start Fullname Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Full Name</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="exet" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required='required' />
	                   </div>
	                 </div>
	                 <!-- End Fullname Field-->
	                 <!-- Start Submit Field-->
	    	         <div class="form-group">
	                   <div class="col-sm-offset-2 col-sm-10">
	                   	 <input type="submit" value="Save" class="btn btn-primary btn-lg" />
	                   </div>
	                 </div>
	                 <!-- End Submit Field-->
	    	  </form>
	    	 </div>
 

    

     <?php 

      } else {

     echo "<div class='container'>";
    	$theMsg = "<div class='alert alert-danger'>Thers No Such ID</div>";
    	redirectHome($theMsg);
    	echo "</div>";
    
      }

   } elseif ($do == 'Update') {

   echo "<h1 class='text-center'>Update Member</h1>";
   echo "<div class='container'>";


   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
     // Get Variables From The Form
   	$id    = $_POST['userid'];
   	$user  = $_POST['Username'];
   	$email = $_POST['email'];
   	$name  = $_POST['full'];
 
   	// Password Trick 
 $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

   	// Valdidate The Form 
   $fromErrors = array();
	   if(strlen($user) < 4 ){
	    $fromErrors[] = '<div class="alert alert-danger"><Username Cant Be Less Then <strong>4 Chrachters</strong></div>';

	   }
	    if(strlen($user)> 20 ){
	    $fromErrors[] = '<div class="alert alert-danger">Username Cant Be More Then<strong>20 Chrachters</strong></div>';

	   }
	   if (empty($user)) {

	   $fromErrors[] = '<div class="alert alert-danger">Username Cant Be <strong>Empty</strong></div>';


	   }
	   if (empty($email )) {

	  $fromErrors[] = '<div class="alert alert-danger">Email Cant Be<strong>Empty</strong></div>';

	   }
	   if (empty($name )) {

	 $fromErrors[] = '<div class="alert alert-danger">FullName Cant Be Empty</div>';

	   }

	   foreach ($fromErrors as $error) {
	   	
	   	echo $error ;
	   }
    
    if (empty($fromErrors)) {

    	
  	// Update The Datebase With This Info
   	$stmt = $con->prepare("Update users SET Username=?, Email=?, Fullname=?, Password=? WHERE UserID=?");
   	$stmt->execute(array( $user, $email, $name, $pass, $id ));
   	// echo Success  Message 

   $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' Record Updated</div>';
   redirectHome($theMsg , 'back');
  

    }
  
   } else {
   //echo "Sorry You Can The Browser This Page Dircetory";
   	$theMsg = "<div class='alert alert-danger'>Sorry You Can The Browser This Page Dircetory</div>";
    redirectHome($theMsg);


      }
    
    echo "</div>";
   
   } elseif ( $do == 'Delete') {
   	echo "<h1 class='text-center'>Deleted Member</h1>";
		 	echo "<div class='container'>";
  // Delete Members Page
     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?intval($_GET['userid']) : 0 ;

  // Select All Data Depend In The Database
    $check =  checkItem('userid', 'users', $userid);
   
	 if ($check > 0 ) { 

   	$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
    $stmt->bindparam(":zuser" ,  $userid);
    $stmt->execute();
    $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
    redirectHome($theMsg, 'back');
      
	 } else{
    
   $theMsg = "<div class='alert alert-danger'>This ID Not Exist</div>";
    redirectHome($theMsg);
	   
	   }
  echo "</div>";
} elseif ($do == 'Actiavte') {
	
 	echo "<h1 class='text-center'> Actiavte Member</h1>";
		echo "<div class='container'>";
  // Delete Members Page
   $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?intval($_GET['userid']) : 0 ;

  // Select All Data Depend In The Database
   $check =  checkItem('userid', 'users', $userid);
   
	  if ($check > 0 ) { 

   	$stmt = $con->prepare("UPDATE users	 SET RagStutes	= 1 WHERE UserID = ?");
 
    $stmt->execute(array($userid ));

    $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Actiavte</div>';

    redirectHome($theMsg, 'back');
      
	 } else{
    
   $theMsg = "<div class='alert alert-danger'>This ID Not Exist</div>";
    redirectHome($theMsg);
	   
	   }
  echo "</div>";
}


    include   $tpl."foooter.php";


  } else {
  	
  header('Location: index.php');

  exit();
  }