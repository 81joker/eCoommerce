<?php 

/*
================================================
== Items Page
================================================
*/
ob_start(); // Output Buffering Start

session_start();

$printTitle = 'Items';//Print Title 

  if (isset($_SESSION['Username'])) {

  include 'init.php'; // Include Files


$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if ($do == 'Manage') {
 // Nimmt data Items from data base and join with users and categories
 $stmt = $con->prepare("SELECT items.*,
  categories.Name AS categories_Name , users.Username FROM items
  INNER JOIN categories ON categories.ID = items.Cat_ID
  INNER JOIN users ON users.UserID = items.Member_ID; ");

    // Execute The Statment
     $stmt->execute();

     // Assigen To Variable
     $items = $stmt->fetchAll();
     if (!empty($items)) {
      ?>
    <!-- Start Manage Items-->
    <h1 class="text-center"> Manage Items</h1>
       <div class="container">
        <div class="table-responsive">
              <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Categories</td>
                        <td>Username</td>
                        <td>Control</td>
                    </tr>
                      <?php
                         foreach ($items as $item) {
                        echo "<tr>";
                          echo "<td>" . $item['item_ID']  . "</td>";
                          echo "<td>" . $item['Name']. "</td>";
                          echo "<td>" . $item['Description']   . "</td>";
                          echo "<td>" . $item['Price']. "</td>";
                          echo "<td>" . $item['Add_Date']    . "</td>";
                          echo "<td>" . $item['categories_Name']    . "</td>";
                          echo "<td>" . $item['Username']    . "</td>";
                         echo "<td> 
                          <a href='items.php?do=Edit&itemid=" .$item['item_ID']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                          <a href='items.php?do=Delete&itemid=" .$item['item_ID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                          if ($item['Approve'] == 0 ) {

                          echo    "<a href='items.php?do=Approve&itemid=" .$item['item_ID']."' class='btn 

                                     btn-info actiavte'><i class='fa fa-check'></i>Approve</a>"; }
                          echo "</td>";
                     echo "</tr>";
                       }
                    ?>
                </table>
          </div>
        <a href='items.php?do=Add' class="btn btn-sm btn-primary">
         <!-- Add New Items-->
          <i class="fa fa-plus"></i> New Item</a>
    </div>
<?php } else {

        echo '<div class="container">';
        echo '<div class="nice-message">There\'s No Comments To Show</div>';
     echo "<a href='items.php?do=Add' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i> New Item</a>";
        echo '</div>';

      } ?>

  <?php
 // Start add Items page
	} elseif ($do == 'Add') {   ?>
      <h1 class="text-center"> Add New Item</h1>
         <div class="container">
          <form class="form-horizontal" action="?do=Insert" method="POST"/>
                 <!-- Start Name Field-->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-10 col-md-4">
                       <input type="text"
                        name="name"  
                        class="form-control" 
                         autocomplete="off"
                          required="required" 
                            placeholder="Name Of The Item" />
                     </div>
                   </div>
                   <!-- End Name Field-->
                   <!-- Start Description Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Description</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                          name="description" 
                           class="form-control"
                             autocomplete="off" 
                             required="required" 
                             placeholder="description Of The Item" />
                       </div>
                     </div>
                     <!-- End Description Field-->
                     <!-- Start Price Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Price</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                          name="price" 
                           class="form-control"
                             autocomplete="off" 
                             required="required" 
                             placeholder="Price Of The Item" />
                       </div>
                     </div>
                     <!-- End Price Field-->
                      <!-- Start Country Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Country</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                          name="country" 
                           class="form-control"
                             autocomplete="off" 
                              required="required" 
                             placeholder="Country Of Made" />
                       </div>
                     </div>
                     <!-- End Country Field-->
                     <!-- Start Status  Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Status</label>
                       <div class="col-sm-10 col-md-4">
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
                     <!-- Start Members   Field-->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Member</label>
                       <div class="col-sm-10 col-md-4">
                        <select class="form-control" name="member">
                          <option value="0">....</option>
                          <?php
                            $stmt= $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $names = $stmt->fetchAll();

                          foreach ($names as $namee) {
                          echo "<option value='". $namee['UserID'] ."'>" .$namee['Username']."</option>";
                    
                          }



                          ?>
                      </select>
                     </div>
                   </div>
                   <!-- End Members  Field-->

                   <!-- Start Categories Field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                     <div class="col-sm-10 col-md-4">
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
        <?php
    		
    	
    	} elseif ($do == 'Insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

       echo "<h1 class='text-center'>Inserted  Item</h1>";
       echo "<div calss='container'>";
         
         // Get Variables From The Form
        
        $name     = $_POST['name'];
        $descript = $_POST['description'];
        $price    = $_POST['price'];
        $country  = $_POST['country'];
        $status   = $_POST['status'];
        $member   = $_POST['member'];
        $cat      = $_POST['category'];
      
        // Valdidate The Form 
       $fromErrors = array();
       if(empty($name)){
        $fromErrors[] = 'Name Cant Not be <strong>Empty</strong>';

      
       }
       if (empty($descript)) {

       $fromErrors[] = 'Description Cant Not be <strong>Empty</strong>';


       }
       if (empty($price)) {

      $fromErrors[] = 'Price Cant Not be <strong>Empty</strong>';

       }
       if (empty($country)) {

     $fromErrors[] = 'Country Cant Not be <strong>Empty</strong>';

       }
        if ( $status == 0 ) {

     $fromErrors[] = 'You Musst Chose the <strong>Status</strong>';

       }
        if ( $member == 0 ) {

     $fromErrors[] = 'You Musst Chose the <strong>Member</strong>';

       }
        if ( $cat == 0 ) {

     $fromErrors[] = 'You Musst Chose the <strong>Category</strong>';

       }

       foreach ($fromErrors as $error) {
        
        echo '<div class="alert alert-danger">' . $error . '</div>';
       }
        
        if (empty($fromErrors)) {
      
            // Insert Userinfo In Datebase 

             $stmt = $con->prepare("INSERT INTO
            items (Name, Description ,Price, Country_Made, status , Add_Date,Cat_ID, Member_ID  ) 
          VALUES (:zname, :zdesc, :zpric, :zconter,:zstat, now(), :zcat, :zmember) ");
             $stmt->execute(array (
                 
                 'zname'     =>  $name,
                 'zdesc'     =>  $descript,
                 'zpric'     =>  $price,
                 'zconter'   =>  $country,
                 'zstat'     =>  $status,
                 'zcat'      =>  $cat,
                 'zmember'   =>  $member ));          

        // echo Success  Message 
        echo "<div class='container'>";
        $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount(). ' Record Insert</div>';
        redirectHome($theMsg, 'back');
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

      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?intval($_GET['itemid']) : 0 ;

         $stmt = $con->prepare("SELECT *
        FROM 
            items
        Where 
            item_ID =? 
          ");
      
       $stmt->execute(array( $itemid ));
       $item = $stmt->fetch();
       $count = $stmt->rowCount();
       
        if ($count > 0 ) { ?>

        <h1 class="text-center"> Edit Item</h1>
           <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST"/>
              <input type="hidden" name="itemid" value="<?php echo  $itemid  ?>" />
                   <!-- Start Name Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Name</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                          name="name"  
                          class="form-control" 
                           autocomplete="off"
                            required="required" 
                            placeholder="Name Of The Item"
                            value="<?php echo $item['Name'] ?>" />
                       </div>
                     </div>
                     <!-- End Name Field-->
                     <!-- Start Description Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Description</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                          name="description" 
                           class="form-control"
                             autocomplete="off" 
                             required="required" 
                             placeholder="description Of The Item"
                             value="<?php echo $item['Description'] ?>" />
                       </div>
                     </div>
                     <!-- End Description Field-->
                     <!-- Start Price Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Price</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                          name="price" 
                           class="form-control"
                             autocomplete="off" 
                             required="required" 
                             placeholder="Price Of The Item"
                             value="<?php echo $item['Price'] ?>" />
                       </div>
                     </div>
                  <!-- End Price Field-->
                  <!-- Start Country Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Country</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                          name="country" 
                          class="form-control"
                          autocomplete="off" 
                          required="required" 
                          placeholder="Country Of Made" 
                          value="<?php echo $item['status'] ?>"/>
                       </div>
                     </div>
                     <!-- End Country Field-->
                     <!-- Start Status  Field-->
                   <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Status</label>
                       <div class="col-sm-10 col-md-4">
                        <select class="form-control" name="status">
                         <option value="1" <?php if($item['status'] == 1){ echo 'selected'; }?> >New</option>
                         <option value="2" <?php if($item['status'] == 2){ echo 'selected'; }?> >Like New</option>
                         <option value="3" <?php if($item['status'] == 3){ echo 'selected'; }?> >Used</option>
                         <option value="4" <?php if($item['status'] == 4){ echo 'selected'; }?> >Very Old</option>
                        </select>
                       </div>
                     </div>
                     <!-- End Status Field-->
                     <!-- Start Members   Field-->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Member</label>
                       <div class="col-sm-10 col-md-4">
                        <select class="form-control" name="member">
                          <?php
                            $stmt= $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $names = $stmt->fetchAll();

                            foreach ($names as $namee) {
                            echo "<option value='". $namee['UserID'] ."'";
                            if($item['Member_ID'] == $namee['UserID']){ echo 'selected'; }
                           echo  ">" .$namee['Username']."</option>";          
                            }
                          ?>
                      </select>
                     </div>
                   </div>
                   <!-- End Members  Field-->

                   <!-- Start Categories Field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                     <div class="col-sm-10 col-md-4">
                      <select class="form-control" name="category">
                        <?php
                          $stmt2= $con->prepare("SELECT * FROM categories");
                          $stmt2->execute();
                          $cats = $stmt2->fetchAll();

                          foreach ($cats as $cat) {
                          echo "<option value='". $cat['ID'] ."'";
                          if($item['Cat_ID'] == $cat['ID']){ echo 'selected'; }
                          echo">" .$cat['Name']."</option>";
                    
                          }



                          ?>
                      </select>
                     </div>
                   </div>
                   <!-- End Categories Field-->
                  
                   <!-- Start Submit Field-->
                 <div class="form-group">
                     <div class="col-sm-offset-2 col-sm-10">
                       <input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
                     </div>
                   </div>
                   <!-- End Submit Field-->
          </form>

<?php

   // Select All Users
   $stmt = $con->prepare("SELECT comments.*, users.Username
                                 FROM comments
                                 INNER JOIN
                                  users ON users.UserID  =comments.user_id 
                                  Where item_id = ? 
                                ");

    // Execute The Statment
   $stmt->execute(array($itemid));

   // Assigen To Variable
   $row = $stmt->fetchAll();
   if (! empty($row)) {
    ?>

    <h1 class="text-center"> Comments [ <?php echo $item['Name'] ?> ] Members</h1>
        <div class="table-responsive">
              <table class="main-table text-center table table-bordered">
                    <tr> 
                      <td>Comment</td>
                      <td>User Name</td>
                      <td>Added Date</td>
                        <td>Control</td>
                    </tr>
                      <?php
                         foreach ($row as $rows) {
                          echo "<tr>";
                            echo "<td>" . $rows['comment']. "</td>";
                            echo "<td>" . $rows['Username']. "</td>";
                            echo "<td>" . $rows['comment_data']    . "</td>";
                            echo "<td> 
                           <a href='comments.php?do=Edit&comid=" .$rows['c_id']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                           
                           <a href='comments.php?do=Delete&comid=" .$rows['c_id']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

                           if ($rows['status'] == 0 ) {
                          echo    "<a href='comments.php?do=Approve&comid=" .$rows['c_id']."' class='btn 
                                              btn-info actiavte'><i class='fa fa-check'></i>Approve</a>";}
                          echo "</td>";
                        echo "</tr>";
                         }    
                      ?>
               </table>
             </div>
            <?php } ?>
         </div>

      <?php
        } else {
        // In Direct in such id 
       echo "<div class='container'>";
        $theMsg = "<div class='alert alert-danger'>Thers No Such ID</div>";
        redirectHome($theMsg);
        echo "</div>";
      
        }

  		// Satrt In Update Page
    	} elseif ($do == 'Update') {
       echo "<h1 class='text-center'>Update Item</h1>";
       echo "<div class='container'>";


       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         
      $id       = $_POST['itemid'];
      $name     = $_POST['name'];
      $descript = $_POST['description'];
      $price    = $_POST['price'];
      $country  = $_POST['country'];
      $status   = $_POST['status'];
      $cat      = $_POST['category'];
      $member   = $_POST['member'];
      
    
    

    // Valdidate The Form 
     $fromErrors = array();
     if(empty($name)){
      $fromErrors[] = 'Name Cant Not be <strong>Empty</strong>';

      
       }
       if (empty($descript)) {

       $fromErrors[] = 'Description Cant Not be <strong>Empty</strong>';


       }
       if (empty($price)) {

      $fromErrors[] = 'Price Cant Not be <strong>Empty</strong>';

       }
       if (empty($country)) {

     $fromErrors[] = 'Country Cant Not be <strong>Empty</strong>';

       }
        if ( $status == 0 ) {

     $fromErrors[] = 'You Musst Chose the <strong>Status</strong>';

       }
        if ( $cat == 0 ) {

     $fromErrors[] = 'You Musst Chose the <strong>Member</strong>';

       }
        if ($member == 0 ) {

     $fromErrors[] = 'You Musst Chose the <strong>Category</strong>';

       }

       foreach ($fromErrors as $error) {
        
        echo '<div class="alert alert-danger">' . $error . '</div>';
       }
        
        if (empty($fromErrors)) {
      
          // Insert Userinfo In Datebase 

           $stmt = $con->prepare("UPDATE items SET Name=?, Description=?, Price =?, Country_Made=?,status=?,Cat_ID=?,Member_ID=? WHERE item_ID=?");
      $stmt->execute(array( $name, $descript, $price, $country,$status, $cat,$member,$id ));
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


   
      } elseif ($do == 'Delete') {

     echo "<h1 class='text-center'>Deleted Item</h1>";
     echo "<div class='container'>";
    // Delete Members Page
       $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?intval($_GET['itemid']) : 0 ;

    // Select All Data Depend In The Database
      $check =  checkItem('item_ID', 'items', $itemid);
     
     if ($check > 0 ) { 

      $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zid");
      $stmt->bindparam(":zid" ,  $itemid);
      $stmt->execute();
      $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
      redirectHome($theMsg, 'back');
        
     } else{
      
     $theMsg = "<div class='alert alert-danger'>This ID Not Exist</div>";
      redirectHome($theMsg);
       
       }
   

    } elseif ($do == 'Approve') {
    
        echo "<h1 class='text-center'> Approve Item</h1>";
          echo "<div class='container'>";
        // Delete Members Page
         $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?intval($_GET['itemid']) : 0 ;

        // Select All Data Depend In The Database
         $check =  checkItem('item_ID', 'items', $itemid);
         
          if ($check > 0 ) { 

          $stmt = $con->prepare("UPDATE items  SET Approve  = 1 WHERE item_ID = ? ");
       
          $stmt->execute(array($itemid ));

          $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Actiavte</div>';

          redirectHome($theMsg,'back');
            
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