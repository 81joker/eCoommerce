<?php 

/*
================================================
== Category Page
================================================
*/
ob_start(); // Output Buffering Start

session_start();

	$pageTitle = 'Categories';

	if (isset($_SESSION['Username'])) {

	include 'init.php';

	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if ($do == 'Manage') {
     
    $sort = 'ASC';

    $sort_array = array('ASC','DESC');

    if (isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){

    $sort = $_GET['sort'];

     }
    
    $stmt3 = $con->prepare("SELECT * FROM categories ORDER BY Ordering  $sort ");

    $stmt3->execute();

    $cats = $stmt3->fetchAll();
     if (!empty($cats)) {
      ?>
    
    <h1 class="text-center">Manage Categories</h1>
    <div class="container categories">
      <div class="panel panel-defult">
      	 <div class="panel-heading">
      	  <i class="fa fa-edit"></i>Manage Categories
      	 <div class="ordering  pull-right">
      	 	Ordering:[
      	 	<a class ='<?php if ($sort == "ASC") { echo "Activ";} ?>' href="?sort=ASC">Asc </a>  ▼ | ▲
      	 	<a  class ='<?php if ($sort == "DESC") { echo "Activ";} ?>' href="?sort=DESC">Desc</a>
      	 	Viwe:
      	 	<span class="Activ">Full</span> ▼ | ▲
      	 	<span class="Activ">Classic</span>]
      	 </div>
      	</div>
      	  <div class="panel-body">
      	  	<?php 
				      	  	 foreach ($cats as $cat) {
				echo '<div class="cat">';
				echo "<div class='hidden-buttons'>";

				echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] ."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";

				echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] ."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";



               	echo "</div>";
				echo "<h3>". $cat['Name'] . "</h3>";
				echo "<div class='full-view' >";
				echo "<p> "; if($cat['Description'] == ''){ echo 'This cotegories has no description ';
			}else {
			 echo $cat['Description'];}
			  echo "</p>";

						if($cat['Visibility'] == 1) { echo '<span class="visibility ct-span"><i class="fa fa-eye"></i>Hidden</span>';}

						if($cat['Allow_Comment'] == 1) { echo '<span class="commntig ct-span"><i class="fa fa-close"></i>Comments Disabled</span>';}

						if($cat['Allow_Ads'] == 1){ echo '<span class="adver ct-span"><i class="fa fa-close"></i>Ads Disabled</span>';}
			    echo '</div>';
				echo '</div>';
				echo '<hr>';


  	  	 }
  	  	  }else {

			 echo '<div class="container">';
			 echo '<div class="nice-message">There\'s No Comments To Show</div>';
			 echo '<a  class="add-category   btn btn-primary"  href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Cotegory</a>';
			 echo '</div>';

			} ?>

		<?php 



             ?>
      	   </div>
      </div>
      <a  class="add-category   btn btn-primary"  href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Cotegory</a>
    </div>

  <?php
	} elseif ($do == 'Add') { ?>

 	 <h1 class="text-center"> Add New Cotegory</h1>
	    	 <div class="container">
	    	  <form class="form-horizontal" action="?do=Insert" method="POST"/>
	    	  	     <!-- Start Name Field-->
	    	         <div class="form-group form-group-lg">
	                  <label class="col-sm-2 control-label">Name</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="text" name="name"  class="form-control"  autocomplete="off" required='required' placeholder="Name Of The Cotegory" />
	                   </div>
	                 </div>
	                 <!-- End Name Field-->
	                 <!-- Start Description Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Description</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="text" name="description" class=" form-control" a  placeholder="Describ The Cotegory" />
	                   </div>
	                 </div>
	                 <!-- End Description Field-->
	                 <!-- Start Ordering Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Ordering</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <input type="text" name="ordering"  class="form-control"  placeholder="Number To Arrange The Categories" />
	                   </div>
	                 </div>
	                 <!-- End Ordering Field-->
	                  <!-- Start Visibility  Field-->
	    	         <div class="form-group  form-group-lg">
	                  <label class="col-sm-2 control-label">Visible</label>
	                   <div class="col-sm-10 col-md-4">
	                   	 <div>
	                   	 	<input id="vis-yes"  type="radio" name="visibility" value="0" checked="">
	                   	 	<label for="vis-yes">Yes</label>
	                   	 </div>
	                   	 <div>
	                   	 	<input id="vis-no" type="radio" name="visibility" value="1"/>
	                   	 	<label for="vis-no">No</label>
	                   	 </div>
	                   </div>
	                 </div>
	                 <!-- End Visibility  Field-->
	                 <!-- Start Commenting Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="commenting" value="0" checked />
								<label for="com-yes">Yes</label> 
							</div>
							<div>
								<input id="com-no" type="radio" name="commenting" value="1" />
								<label for="com-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Commenting Field -->
					<!-- Start Ads Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" checked />
								<label for="ads-yes">Yes</label> 
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" />
								<label for="ads-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Ads Field -->
	                 <!-- Start Submit Field-->
	    	         <div class="form-group">
	                   <div class="col-sm-offset-2 col-sm-10">
	                   	 <input type="submit" value="Add Cotegory" class="btn btn-primary btn-lg" />
	                   </div>
	                 </div>
	                 <!-- End Submit Field-->
	    	  </form>
	    	 </div>
		
	<?php 
	} elseif ($do == 'Insert') {

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   echo "<h1 class='text-center'>Inserted  Cotegory</h1>";
   echo "<div calss='container'>";
     
  
   	
   	$name    = $_POST['name'];
   	$desc    = $_POST['description'];
   	$order   = $_POST['ordering'];
   	$visibl  = $_POST['visibility'];
   	$comment  = $_POST['commenting'];
   	$ads     = $_POST['ads'];

   
   
  // Check If Cotegory Exiest In Database 

    $check = checkItem('Name', 'categories', $name );

  
  	if ($check == 1) {

    echo "<div class='container'>";

	$theMsg =  "<div class='alert alert-danger'>Soory This Cotegory Is Exiest</div>"; 

	redirectHome($theMsg, 'back');

    echo "</div>";

	  	} else {

			 	// Insert The Cotegory In Datebase 

	   $stmt = $con->prepare("INSERT INTO
			                 categories (Name, Description , Ordering,Visibility, 	Allow_Comment, Allow_Ads) 
			                        VALUES (:zname, :zdesc, :zorder, :zvisibl, :zcomment, :zads)	");
			   $stmt->execute(array (
			       
			       'zname'    =>  $name,
			       'zdesc'    =>  $desc,
			       'zorder'   =>  $order,
			       'zvisibl'  =>  $visibl,
			       'zcomment' =>  $comment,
			       'zads'     =>  $ads
			  ));          




			   	// echo Success  Message 
			  echo "<div class='container'>";
			  $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount(). ' Record Insert</div>';
			 	redirectHome($theMsg , 'back');
			 	echo "</div>";
 }
   
  
   } else {
   
   echo "<div class='container'>";
   $theMsg =  "<div class='alert alert-danger'>Sorry You Can The Browser This Page Dircetory</div>";
   redirectHome($theMsg , 'back');
   echo "</div>";
      }
    
    echo "</div>";



	} elseif ($do == 'Edit') {

		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

	  $stmt = $con->prepare("SELECT * FROM  categories  Where ID = ? ");


	   $stmt->execute(array( $catid ));

	   $cat = $stmt->fetch();

	   $count = $stmt->rowCount();
	   
	   if ($count > 0 ) { ?>
	    <h1 class="text-center"> Edit Cotegory</h1>
		    	 <div class="container">
		    	  <form class="form-horizontal" action="?do=Update" method="POST"/>
		    	  <input type="hidden" name="catid" value="<?php echo  $catid  ?>" />
		    	  	     <!-- Start Name Field-->
		    	         <div class="form-group form-group-lg">
		                  <label class="col-sm-2 control-label">Name</label>
		                   <div class="col-sm-10 col-md-4">
		                   	 <input type="text" name="name"  class="form-control"  required='required' placeholder="Name Of The Cotegory" value="<?php echo $cat['Name']; ?>" />
		                   </div>
		                 </div>
		                 <!-- End Name Field-->
		                 <!-- Start Description Field-->
		    	         <div class="form-group  form-group-lg">
		                  <label class="col-sm-2 control-label">Description</label>
		                   <div class="col-sm-10 col-md-4">
		                   	 <input type="text" name="description" class=" form-control" a  placeholder="Describ The Cotegory"  value="<?php echo $cat['Description']; ?>"/>
		                   </div>
		                 </div>
		                 <!-- End Description Field-->
		                 <!-- Start Ordering Field-->
		    	         <div class="form-group  form-group-lg">
		                  <label class="col-sm-2 control-label">Ordering</label>
		                   <div class="col-sm-10 col-md-4">
		                   	 <input type="text" name="ordering"  class="form-control"  placeholder="Number To Arrange The Categories" value="<?php echo $cat['Ordering']; ?>"/>
		                   </div>
		                 </div>
		                 <!-- End Ordering Field-->
		                  <!-- Start Visibility  Field-->
		    	         <div class="form-group  form-group-lg">
		                  <label class="col-sm-2 control-label">Visible</label>
		                   <div class="col-sm-10 col-md-4">
		                   	 <div>
                                 <input id="vis-yes"  type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0) { echo 'checked';} ?> />
		                   	 	<label for="vis-yes">Yes</label>
		                   	 </div>
		                   	 <div>
		                   	 	<input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1) { echo 'checked';} ?> />
		                   	 	<label for="vis-no">No</label>
		                   	 </div>
		                   </div>
		                 </div>
		                 <!-- End Visibility  Field-->
		                 <!-- Start Commenting Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commenting</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0) { echo 'checked';} ?> />
									<label for="com-yes">Yes</label> 
								</div>
								<div>
									<input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1) { echo 'checked';} ?> />
									<label for="com-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Commenting Field -->
						<!-- Start Ads Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0) { echo 'checked';} ?> />
									<label for="ads-yes">Yes</label> 
								</div>
								<div>
									<input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1) { echo 'checked';} ?>  />
									<label for="ads-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Ads Field -->
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
      echo "<h1 class='text-center'>Update Categories</h1>";
   echo "<div class='container'>";


   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
     // Get Variables From The Form
   	$id       = $_POST['catid'];
   	$name     = $_POST['name'];
   	$desc     = $_POST['description'];
   	$order    = $_POST['ordering'];
   	$visible  = $_POST['visibility'];
   	$comment  = $_POST['commenting'];
   	$ads      = $_POST['ads'];
 
 
  	// Update The Datebase With This Info
   	$stmt = $con->prepare("Update categories SET Name=?, Description=?, Ordering=?, Visibility=? ,Allow_Comment = ?,  Allow_Ads = ? WHERE ID = ? ");

   	$stmt->execute(array( $name, $desc, $order, $visible,	$comment ,	$ads ,$id ));

   	// echo Success  Message 

   $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' Record Updated</div>';
   redirectHome($theMsg , 'back');
  

   
  
   } else {
   //echo "Sorry You Can The Browser This Page Dircetory";
   	$theMsg = "<div class='alert alert-danger'>Sorry You Can The Browser This Page Dircetory</div>";
    redirectHome($theMsg);


      }
    
    echo "</div>";
   

    } elseif ($do == 'Delete') {

	  	echo "<h1 class='text-center'>Deleted Cotegory</h1>";
	 	echo "<div class='container'>";
	  // Delete Members Page
	     $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?intval($_GET['catid']) : 0 ;

	  // Select All Data Depend In The Database
	    $check =  checkItem('ID', 'categories', $catid);
	   
		 if ($check > 0 ) { 

	   	$stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");
	    $stmt->bindparam(":zid" ,  $catid);
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

  expm1();
  }
  ob_end_flush(); // Release The output_add_rewrite_var(name, value)

  ?>