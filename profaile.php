 <?php

 session_start();
     	
 $printTitle = "Profile";

 include "init.php";
 if(isset($_SESSION["user"])){

 $getUser = $con ->prepare("SELECT * FROM users WHERE Username =?"); //$getUser ->execute(array($_SESSION['user']));
 $getUser ->execute(array($sessionUser));
 $info = $getUser->fetch();
 $userid = $info['UserID'];

 
    ?>

    
  <h1 class="text-center"><?php echo "Welcom ". $_SESSION['user']." Your page Profile";?></h1>

  <div class="information block">
   <div class="container">
    <div class="panel panel-primary">
    	<div class="panel-heading">My Information</div>
    	 <div class="panel-body">
        <ul class="list-unstyled">
      	  <li><i class="fa fa-unlock-alt fa-fw"></i>
            <span>Login Name</span> : <?php echo $info['Username']; ?> 
              </li>
      	  <li><i class="fa fa-envelope-o fa-fw"></i>
            <span>Fullname</span>   : <?php echo $info['FullName'];?>
          </li>
      	  <li><i class="fa fa-user fa-fw"></i>
            <span>Email</span>         :   <?php echo $info['Email']; ?> 
          </li>
      	  <li><i class="fa fa-calendar fa-fw"></i>
            <span>Date</span>       :    <?php echo $info['Date']; ?>   
          </li>
          <li><i class="fa fa-tags fa-fw"></i>
            <span>Favourite Category</span> :
          </li>
       </ul>
      </div>
    	 </div>
    </div>
   </div>
  </div>

  <div id="my-ads"  class="my-ads block">
   <div class="container">
    <div class="panel panel-primary">
    	<div class="panel-heading">My ADS</div>
    	 <div class="panel-body">
        
    	 <?php
       if (!empty(getItems("Member_ID",$info['UserID']))){
        echo "<div class='row'>";
       foreach (getItems("Member_ID",$info['UserID']) as $IItems){
        echo "<div class='col-sm-4 col-md-3'>";
          echo  "<div class='thumbnail'>";
            echo "<p>" .$IItems['Price']."$</p>";
              echo "<img src='Alaa.JPG'  alt=''>";
                echo "<div class='caption'>";
                      echo "<h3><a href='items.php?itemid=".$IItems['item_ID']."'>" .$IItems['Name']."</a></h3>";
                      echo "<p>" .$IItems['Description']."</p>";
                       echo "<div class='date'>" .$IItems['Add_Date']."</div>";
                   echo "</div>";
           echo "</div>";
          echo "</div>";
       
     }
        } else {
        echo"<div class='space'>Sorry There No Ads Show.<a href='Newad.php'>New Ads</a></div>";
        }
      ?> 
    	 </div>
      </div>
    </div>
   </div>
  </div>
   
  <div class="my-comments block">
    <div class="container">
      <div class="panel panel-primary">
        <div class="panel-heading">Latest Comments</div>
        <div class="panel-body">
        <?php
          $myComments = getAllFrom("comment", "comments", "where user_id = $userid", "", "c_id");
          if (! empty($myComments)) {
            foreach ($myComments as $comment) {
              echo '<p>' . $comment['comment'] . '</p>';
            }
          } else {
            echo 'There\'s No Comments to Show';
          }
        ?>
        </div>
      </div>
    </div>
  </div>
   
   <?php
   }  else {
   header("Location: login.php");
   exit();
  }


   include  $temp."foooter.php" ?>