 <?php

	 session_start();

	 $printTitle = ('Create New Item');

	  include 'init.php';
	  //echo $sessionUser;
	 if(isset($_SESSION['user'])){	
	 

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	 $fromErrors = array();

		$name     = filter_var($_POST['name'],       FILTER_SANITIZE_STRING);
		$desc     = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
		$price    = filter_var($_POST['price'],      FILTER_SANITIZE_NUMBER_INT);
		$country  = filter_var($_POST['country'],    FILTER_SANITIZE_STRING);
		$status   = filter_var($_POST['status'],     FILTER_SANITIZE_STRING);
		$category = filter_var($_POST['category'],   FILTER_SANITIZE_STRING);
   
   if (strlen($name) < 4 ) {
   $fromErrors[] = "Item Title Must Be At Latest 4 Characters";
   }

   if (strlen($desc) < 10 ) {
   $fromErrors[] = "Item Description Must Be At Latest 10 Characters";
   }
   if (strlen($country) < 2 ) {
   $fromErrors[] = "Item Country Must Be At Latest 2 Characters";
   }
   if (empty($price)) {
   $fromErrors[] = "Item Price Must Not Be Empty";
   }
   if (empty($status)) {
   $fromErrors[] = "Item Status Must Not Be Empty";
   }

if (empty($category)) {
   $fromErrors[] = "Item Category Must Not Be Empty";
   }
 
    if (empty($fromErrors)) {
  
        // Insert Userinfo In Datebase 

         $stmt = $con->prepare("INSERT INTO
        items (Name, Description ,Price, Country_Made, status , Add_Date,Cat_ID, Member_ID  ) 
      VALUES (:zname, :zdesc, :zpric, :zconter,:zstat, now(), :zcat, :zmember) ");
         $stmt->execute(array (
             
             'zname'     =>  $name,
             'zdesc'     =>  $desc,
             'zpric'     =>  $price,
             'zconter'   =>  $country,
             'zstat'     =>  $status,
             'zcat'      =>  $category,
             'zmember'   =>  $_SESSION['uid']
        ));          

        echo "<div class='container'>";
        $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount(). ' Record Insert</div>';
        redirectHome($theMsg, 'back');
        echo "</div>";

}

}


  ?>

<h1 class="text-center"><?php echo $printTitle  ?></h1>

<div class="create-ad block">
<div class="container">
<div class="panel panel-primary">
  <div class="panel-heading"><?php echo $printTitle  ?></div>
   <div class="panel-body">
  	<div class="row">
    	 <div class="col-md-8">
            <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"/>
                 <!-- Start Name Field-->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Name</label>
                     <div class="col-sm-10 col-md-8">
                       <input type="text"
                        name="name"  
                        class="form-control live" 
                         autocomplete="off"
                      
                          placeholder="Name Of The Item"
                          data-class=".live-title"
                           />
                     </div>
                   </div>
                   <!-- End Name Field-->
                   <!-- Start Description Field-->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Description</label>
                     <div class="col-sm-10 col-md-8">
                       <input type="text"
                        name="description" 
                         class="form-control  live"
                           autocomplete="off" 
                         
                           placeholder="description Of The Item"
                           data-class=".live-desc" />
                     </div>
                   </div>
                   <!-- End Description Field-->
                   <!-- Start Price Field-->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Price</label>
                     <div class="col-sm-10 col-md-8">
                       <input type="text"
                        name="price" 
                         class="form-control  live"
                           autocomplete="off" 
                          
                           placeholder="Price Of The Item"
                           data-class=".live-price" />
                     </div>
                   </div>
                   <!-- End Price Field-->
                    <!-- Start Country Field-->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Country</label>
                     <div class="col-sm-10 col-md-8">
                       <input type="text"
                        name="country" 
                         class="form-control"
                           autocomplete="off" 
                             
                           placeholder="Country Of Made" />
                     </div>
                   </div>
                   <!-- End Country Field-->
                   <!-- Start Status  Field-->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Status</label>
                     <div class="col-sm-10 col-md-8">
                      <select class="form-control" name="status">
                        <option value="0">....</option>
                         <option value="1">New</option>
                          <option value="2">Like New</option>
                           <option value="3">Used</option>
                            <option value="4">Very Old</option>
                      </select>
                     </div>
                   </div>
                   <!-- End Status Field-->
                   

                   <!-- Start Categories Field-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Category</label>
                     <div class="col-sm-10 col-md-8">
                      <select class="form-control" name="category">
                        <option value="0">....</option>
                        <?php
                          $stmt2= $con->prepare("SELECT * FROM categories");
                          $stmt2->execute();
                          $cats = $stmt2->fetchAll();

                          foreach ($cats as $cat) {
                      echo "<option value='". $cat['ID'] ."'>" .$cat['Name']."</option>";
                    
                          }



                          ?>
                      </select>
                     </div>
                   </div>
                   <!-- End Categories Field-->
                  
                   <!-- Start Submit Field-->
                 <div class="form-group">
                     <div class="col-sm-offset-2 col-sm-10">
                       <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                     </div>
                   </div>
                   <!-- End Submit Field-->
		          </form>
			  	 </div>
				  	 <div class="col-md-4">
				  	 	<div class='thumbnail item-box live-preview'>
				  	 	<span class='price-tag '>
				  	 	$<span class="live-price">0</span>
				  	 	</sapn>
						<img class='img-responsive' src='4.jpg' alt='' width='150' height=150>
						<div class='caption'>
						<h3 class="live-title">.Name.</h3>
						<p class="live-desc">.Description.</p>
				  	  </div>
				   	</div> 
		              <!-- Start Looping Throog Errors -->
		              <?php 
		             if (! empty($fromErrors)){
		             foreach ($fromErrors as $errors) {
		            
		             echo "<div class='alert alert-danger'>" . $errors . "</div>";

		               }
		             }
		           ?>
		            <!-- End Looping Throog Errors -->
		     
		   </div>
		  </div>
		 </div>
		</div>
		
		

			<?php


			 } else {
			 header('Location: login.php');
			exit();
			 }
				
				  include   $temp."foooter.php";
				  ?>


	 