<?php
  session_start();

  $printTitle = ('Dashbord'); // Ptint Function Titile

  if (isset($_SESSION['Username'])) {

    include 'init.php';


    /*Start Dashbord page*/


    $numUsers = 6; // Number Of Lateast  Users
    $latestUsers = getLatest('*', 'users','UserID', $numUsers); // Latest Users Array

    $numItems = 6; // Number Of Items Users
    $latestItems = getLatest('*', 'items', 'item_ID',$numItems);
   
    $numComments = 4;// Number Of Comments Users
    $latestComent = getLatest('*', 'comments', 'c_id',$numComments);
 
  ?>
    <!-- Start Daschbord From Users -->
  <div class="container home-stats text-center">
   <h1>Dashbord</h1>
     <div class="row">
       <div class="col-md-3">
          <div class="stat st-members">
            <i class="fa fa-users"></i>
            <div class="info">
               Totel Members
             <span><a href="Members.php"><?php echo countItems('UserID', 'users') ?></a></span>   
            </div>
         </div>
       </div>
       <div class="col-md-3">
          <div class="stat st-pending">
            <i class="fa fa-user-plus"></i>
               <div class="info">
                   Pending Members
                 <span><a href="Members.php?page=Pending" >
                 <?php  echo checkItem('RagStutes' , 'users' , 0) ?>
                 </a>
                 </span>
                </div>
           </div>
       </div>
       <!-- End Daschbord From Users -->
       <!-- Start Daschbord item -->
       <div class="col-md-3">
          <div class="stat st-items">
           <i class="fa fa-tag"></i>
            <div class="info">
              Totel Items
               <span>
                 <a href="Items.php?page=Pending" >
                 <?php  echo countItems('item_ID', 'items') ?>
                 </a>
               </span>
            </div>
         </div>
       </div>
       <!-- End Daschbord item -->
       <!-- Start Daschbord Comments-->
       <div class="col-md-3">
          <div class="stat st-comments">
           <i class="fa fa-comments"></i>
              <div class="info">
                  Totel Comments
                 <span>
                   <a href="comments.php" >
                   <?php  echo countItems('c_id', 'comments') ?>
                    </a>
                 </span>
                 
              </div>
         </div>
       </div>
    </div>
  </div>
 <!-- End Daschbord Comments-->
 <!-- Start Last Rigestered Users -->
  <div class="latest">
      <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <div class="panel panel-default">
                <div class="panel panel-heading">
                  <i class="fa fa-users"></i>
                     Latest <?php echo $numUsers  ?> Rigestered Users  
                      <span class="toggle-info  pull-right">
                        <i class="fa fa-plus fa-lg"></i> 
                      </span>
                   </div>
                  <div class="panel-body">
                    <ul class="list-unstyled latest-users">
                      <?php 
                       if (!empty($latestUsers)){
                        foreach ($latestUsers as $user) {    
                     echo  "<li>";
                     echo  $user['Username']; 
                     echo  '<a href="Members.php?do=Edit&userid=' . $user['UserID'].'" >';
                     echo  "<span class='btn btn-success pull-right'>";
                     echo  "<i class='fa fa-edit'></i>Edit";
                       if ($user['RagStutes'] == 0 ) {

                     echo    "<a href='Members.php?do=Actiavte&userid=" .$user['UserID']."' class='btn btn-info pull-right actiavte'><i class='fa fa-check'></i>Actiavte</a>";
                              }
           
                     echo  '</a>';
                     echo  "</span>";
                     echo  "</li>";
                         }
                  }  else {
                     echo "Thers is No Recored To Show";
                  }   
                       ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Last Rigestered Users -->
        <!-- Start Last Rigestered Items  -->
        <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel panel-heading">
                <i class="fa fa-tag"></i> Latest Items <?php echo  $numItems;  ?>
                  <span class="toggle-info  pull-right">
                    <i class="fa fa-plus fa-lg"></i> 
                    </span>
                 </div>
                <div class="panel-body">
                  <ul class="list-unstyled latest-users">
                      <?php 
                        foreach ($latestItems as $Itemss) {    
                     echo  "<li>";
                     echo  $Itemss['Name']; 
                     echo  '<a href="items.php?do=Edit&itemid=' . $Itemss['item_ID'].'" >';
                     echo  "<span class='btn btn-success pull-right'>";
                     echo  "<i class='fa fa-edit'></i>Edit";
                       if ($Itemss['Approve'] == 0 ) {

                     echo    "<a href='items.php?do=Approve&itemid=" .$Itemss['item_ID']."' class='btn btn-info pull-right actiavte'><i class='fa fa-check'></i>Approve</a>";
                              }
           
                     echo  '</a>';
                     echo  "</span>";
                     echo  "</li>";
                         }
                       ?>
                    </ul>

              </div>
            </div>
          </div>
        </div>
        <!-- Start Last Rigestered Items  -->
        <!-- Start Latest Comment -->
         <div class="row">
            <div class="col-sm-6">
              <div class="panel panel-default">
                <div class="panel panel-heading">
                  <i class="fa fa-comments-o"></i>
                   Latest Comments <?php echo  $numComments;  ?>
                      
                      <span class="toggle-info  pull-right">
                        <i class="fa fa-plus fa-lg"></i> 
                      </span>
                   </div>
                  <div class="panel-body">
                    <?php

                   $stmt = $con->prepare("SELECT comments.*, users.Username
                                           FROM comments
                                           INNER JOIN
                                           users ON users.UserID  =comments.user_id 
                                           ORDER BY c_id DESC
                                           Limit  $numComments
                                                  ");

                       $stmt->execute();
                       $comments = $stmt->fetchAll();
                       if(!empty($comments)){
                       foreach ($comments as $comnt) {
                       echo "<div class='comment-box'>";
                       echo "<span class='member-n'>" . $comnt['Username'] . "</span>";
                       echo "<p class='member-c'>" . $comnt['comment'] . "</p>";
                       }
                     } else {
                       echo 'There\'s No Comments To Show';
                     }?>
                       </div>
                    </div>
                 </div>
               </div>
             </div>
           </div>
      <!-- End Latest Comment -->
       </div>
    </div>



  <?php
    /* End Dashbord page  */

      

      include   $tpl."foooter.php";


    } else {
    	
    header('Location: index.php');

    expm1();
    }