<?php

/*
=================================================
=== Mange Comments Page
=== You Can Edit | Delete|Approve Comments From Hear
=================================================
*/

  session_start();

  $printTitle = ('Comments');

  if (isset($_SESSION['Username'])) {


    include 'init.php';

    $do =  isset($_GET['do']) ? $_GET['do'] : 'Mange';

     // Start The Mange Page
  if ($do == 'Mange'){// Mange Members Page



   // Select All Users
   $stmt = $con->prepare("SELECT comments.*, items.Name AS Item_Name,users.Username
                                 FROM comments
                                 INNER JOIN 
                                 items ON items.item_ID =comments.item_id
                                 INNER JOIN
                                  users ON users.UserID  =comments.user_id
                                ");

    // Execute The Statment
   $stmt->execute();

   // Assigen To Variable
   $comment = $stmt->fetchAll();
   if (!empty($comment)) {

  	?>

    <h1 class="text-center"> Comments Members</h1>
    	 <div class="container">
    	 	<div class="table-responsive">
		    	 		<table class="main-table text-center table table-bordered">
				    	 			<tr>
			    	 					<td>ID</td>
			    	 					<td>Comment</td>
			    	 					<td>Item Name</td>
			    	 					<td>User Name</td>
			    	 					<td>Registered Data</td>
					    	 		  <td>Control</td>
				    	 			</tr>
				    	 			  <?php
				    	 			     foreach ($comment as $comnt) {
	                        echo "<tr>";
	                        echo "<td>" . $comnt['c_id']  . "</td>";
	                        echo "<td>" . $comnt['comment']. "</td>";
	                        echo "<td>" . $comnt['Item_Name']   . "</td>";
	                        echo "<td>" . $comnt['Username']. "</td>";
	                        echo "<td>" . $comnt['comment_data']    . "</td>";
	                        echo "<td> 
	     <a href='comments.php?do=Edit&comid=" .$comnt['c_id']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
	     
	     <a href='comments.php?do=Delete&comid=" .$comnt['c_id']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

	     if ($comnt['status'] == 0 ) {

	    echo  	"<a href='comments.php?do=Approve&comid=" .$comnt['c_id']."' class='btn 

											    btn-info actiavte'><i class='fa fa-check'></i>Approve</a>";
	     }
	                      echo "</td>";
							    	 			  
					     echo "</tr>";

				    	 			     }
				    	 		  
				    	 			  ?>
				    	 
						 
				    	   </table>
		    	  	</div>
              <a href='comments.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add New Comment
              </a>
            </div>
    <?php } else {

        echo '<div class="container">';
        echo '<div class="nice-message">There\'s No Comments To Show</div>';
        echo '</div>';

      } ?>

   

   <?php  } elseif ($do == "Add"){  ?>

  <h1 class="text-center">Comments</h1>
        <div class="container">
           <form class="form-horizontal" action="?do=Insert" method="POST">
            <!--Srart UserNme-->
             <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Comments</label>
              <div class="col-md-6 col-sm-10">
              <textarea class="form-control"    type="textarea" name="commen" placeholder=" Insert Comments" ></textarea>
              </div>
             </div>
            <!--End UserNme-->
            <!-- Start Items  Field-->
                 <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Select Item</label>
                   <div class="col-sm-10 col-md-4">
                    <select class="form-control"  name="item">
                       <option value="0">....</option>
                        <?php  
                         $stmt=$con->prepare("SELECT * FROM items ");
                         $stmt->execute();
                         $items=$stmt->fetchAll();
                         foreach($items as $item){
                         echo "<option value='".$item['item_ID']."'>".$item['Name']."</option>";
                         }
                         ?>                      
                    </select>
                   </div>
                 </div>
                   <!-- End Items Field-->
                   <!-- Start Member  Field-->
                 <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Member</label>
                   <div class="col-sm-10 col-md-4">
                    <select class="form-control"  name="member">
                       <option value="0">....</option>
                        <?php  
                         $stmt=$con->prepare("SELECT * FROM users");
                         $stmt->execute();
                         $userss=$stmt->fetchAll();
                         foreach($userss as $user){
                         echo "<option value='".$user['UserID']."'>".$user['Username']."</option>";
                         }
                         ?>                      
                    </select>
                   </div>
                 </div>
                   <!-- End Member Field-->
              <!--Srart Data
             <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Insert Data</label>
              <div class=" col-md-6 col-sm-10">
              <input class="form-control"    type="date" name="date" placeholder="" " >
              </div>شب
             </div>
            <!--End Data-->
             
             
              <!--Srart Submit-->
             <div class="form-group form-group-lg">
              <div class="col-sm-offset-2 col-sm-10 col-sm-10">
              <input class=" btn btn-primary btn-lg"    type="submit" value="Add New Members" >
              </div>
             </div>
            <!--End Submit-->

           </form>
          </div>
         

  <?php 
      } elseif ($do == "Insert") {   
       
     echo '<h1 class="text-center"> Insert Member</h1>';

     if ($_SERVER['REQUEST_METHOD'] == 'POST'){
     
      $comme    = $_POST['commen'];
      $item     = $_POST['item']; 
      $member   = $_POST['member']; 
    
     


    $stmt = $con->prepare("INSERT INTO 
      comments (comment,item_id,user_id,comment_data)
      VALUES(:zcomnt,:zitemid,:zmember,now()) ");


       $stmt->execute(array(
            "zcomnt"   =>  $comme,
            "zitemid"  =>  $item ,
            "zmember"  =>  $member ,
         
  ));
          echo "<div class='container'>";

          $theMsg="<div class='alert alert-success'> ".$stmt->rowCount()."Record Updated</div>";

          redirectHome($theMsg,"back");

          echo "</div>";   

     } else {
      echo "<div class='container'>";
      $theMsg =  "<div class='alert alert-danger'>Sorry You Can Browser This Page Dirctly</div>";
      redirectHome($theMsg, 4);
      echo "<div>";
       }




     } elseif ($do == 'Edit'){  //Edit Page 

   $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ?intval($_GET['comid']) : 0 ;

       $stmt = $con->prepare("SELECT *
      FROM 
          comments
      Where 
            	c_id =? 
        ");



     $stmt->execute(array( $comid ));
     $row = $stmt->fetch();
     $count = $stmt->rowCount();
     
      if ($count > 0 ) { ?>

  	    	<h1 class="text-center"> Edit Comments</h1>
  	    	 <div class="container">
  	    	  <form class="form-horizontal" action="?do=Update" method="POST"/>
  	    	  	<input type="hidden" name="comid" value="<?php echo  $comid  ?>" />
  	    	  	     <!-- Start Comments Field-->
  	    	         <div class="form-group form-group-lg">
  	                  <label class="col-sm-2 control-label">Comments</label>
  	                   <div class="col-sm-10 col-md-4">
  	                     <textarea class="from-control" name="comment"><?php echo $row['comment'] ?>
  	                    </textarea>
  	                   </div>
  	                 </div>
  	                 <!-- End Comments Field-->
  	              
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
     	$comid    = $_POST['comid'];
     	$comment  = $_POST['comment'];

   
     	// Password Trick 
   
    	// Update The Datebase With This Info
     	$stmt = $con->prepare("Update comments SET  comment=? WHERE c_id=?");
     	$stmt->execute(array( $comment,  $comid ));
     	// echo Success  Message 

     $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' Record Updated</div>';
     redirectHome($theMsg , 'back');
    

      
    
     } else {
     //echo "Sorry You Can The Browser This Page Dircetory";
     	$theMsg = "<div class='alert alert-danger'>Sorry You Can The Browser This Page Dircetory</div>";
      redirectHome($theMsg);


        }
      
      echo "</div>";
     
     } elseif ( $do == 'Delete') {
     	echo "<h1 class='text-center'>Deleted Comments</h1>";
  		 	echo "<div class='container'>";
    // Delete Members Page
       $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ?intval($_GET['comid']) : 0 ;

    // Select All Data Depend In The Database
      $check =  checkItem('c_id', 'comments', $comid);
     
  	 if ($check > 0 ) { 

     	$stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zcom ");
      $stmt->bindparam(":zcom" ,  $comid);
      $stmt->execute();
      $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
      redirectHome($theMsg, 'back');
        
  	 } else{
      
     $theMsg = "<div class='alert alert-danger'>This ID Not Exist</div>";
      redirectHome($theMsg);
  	   
  	   }
    echo "</div>";
  } elseif ($do == 'Approve') {
  	
   	echo "<h1 class='text-center'> Approve Comments</h1>";
  	echo "<div class='container'>";
    // Delete Members Page
     $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ?intval($_GET['comid']) : 0 ;

    // Select All Data Depend In The Database
     $check =  checkItem('c_id', 'comments', $comid);
     
  	  if ($check > 0 ) { 

     	$stmt = $con->prepare("UPDATE comments	 SET  	status 	= 1 WHERE c_id = ?");
   
      $stmt->execute(array($comid ));

      $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approved
      </div>';

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