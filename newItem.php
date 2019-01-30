 <?php

 session_start();
     	
 $printTitle = "Items";

 include "init.php";

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;



   $stmt = $con->prepare("SELECT items.*,
            categories.Name AS CAT_Name,
            users.Username 
            FROM items
          INNER JOIN categories ON categories.ID = items.Cat_ID
          INNER JOIN users ON users.UserID = items.Member_ID WHERE item_ID=? ");

   $stmt->execute(array($itemid));

   

   $count= $stmt->rowCount();

   if($count > 0 ){

  $rowit = $stmt->fetch();

 
    ?>

    
  <h1 class="text-center"><?php echo $rowit['Name'];?></h1>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <img class='img-responsive img-thumbnail center-block' src='Alaa.JPG'  alt=''>
        </div>
        <div class="col-md-9 info-item">
          <ul class="list-unstyled">
            <li><span>Description </span>: <?php echo $rowit['Description'];?></li>

            <li><i class="fa fa-money fa-fw fa-md"></i>
              <span>Price </span>: <?php echo $rowit['Price'];?>$
            </li>

            <li><i class="fa fa-building fa-fw fa-lg"></i>
              <span>Made In </span>: <?php echo $rowit['Country_Made'];?>$
            </li>


            <li><i class="fa fa-calendar fa-fw fa-md"></i>
              <span>Datum </span>: <?php echo $rowit['Add_Date'];?>
            </li>

            <li><i class="fa fa-tags fa-fw"></i>
              <span>Categorey
              </span>:<a href="categor.php?pageid=<?php echo $rowit['Cat_ID'] ?> "> 
                <?php echo $rowit['CAT_Name'];?></a>
            </li>

            <li><i class="fa fa-user fa-fw fa-lg"></i>
              <span>Name </span>: <?php echo $rowit['Username'];?>
            </li>
        

         </ul>
        </div>
        
      </div>
      <!-- Start Add Comment-->
      <?php if(isset($_SESSION["user"])){  ?>
      <hr>
         <div class="custom-comment">
           <div class="row">
            <div class="col-md-offset-3">
             <h2>Add Comment</h2>
              <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$rowit['Item_ID']; ?>" method="POST">
                  <textarea name="comment"></textarea>
                  <input class="btn btn-primary" type="submit" name="Add Comment">
                </form>
                <?php
                  if($_SERVER['REQUEST_METHOD'] == "POST") {
                   
                   $comment = filter_var($_POST['comment'].FILTER_SANITIZE_STRING);
                   $userid  = $_SESSION['uid'];
                   $itemid  = $rowit['Item_ID'];
                  if(! empty($comment)) {

                   $stmt=$con->prepare("INSERT INTO comments(comment,status,comment_date,item_id,user_id)
                    VALUES(:zcomment,0 , NOW(), :zitemid, :zuserid)  ");

                   $stmt->execute(array(

                   "zcomment" =>$comment,
                   "zitemid"  =>$itemid,
                   "zuserid"  =>$userid
                   ));

                  if($stmt){
                     

                  echo "<div class='container'>";
                  $errorMsg = "<div class='alert alert-success'>Comment Add</div>"; 
                  redirectHome($errorMsg,'back', 3);
                  echo "</div>";

                  }



                }

              }
                 ?>
            </div>
          </div>
        </div>
         <?php }else {
          
          echo "<a href='login.php'>LOGIN</a> OR <a href='#'>Register</a>";
         } ?>
      <!-- End Add Comment-->
      <hr class="custom-hr">
      
       
            <?php 
           $stmt = $con->prepare("SELECT comments.*,
              users.Username As Member
              FROM comments
              INNER JOIN 
              users ON users.UserID = comments.user_id
              WHERE  Item_ID=? AND status=1");

             $stmt ->execute(array($rowit['item_ID']));

              $comments = $stmt->fetchAll(); 
             foreach ($comments as $comment) {

              ?>
        
          <div class="comment-box">
            <div class="row">    
             <div class="col-sm-2 text-center">
              <img class='img-responsive img-thumbnail img-circle center-block' 
              src='img.PNG'  alt=''>
               <?php echo $comment['Member'] ?>
             </div>
             <div class="col-sm-10">
              <p class="lead">
                   <?php
                echo  $comment['comment']."<br>";
          
                 
                

              ?>
               </p>
             </div>
        </div>
      </div>
      <hr class="custom-hr">
      <?php } ?>
    </div>
<?php
} else {
  
 echo "Thers No Susch Id";
} 
   include  $temp."foooter.php" ?>