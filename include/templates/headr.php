<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php  printTitle() ?></title>
     <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css" />
  	 <link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
  	 <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
  	 <link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css"/>
  	 <link rel="stylesheet" href="<?php echo $css ?>front.css" />
</head>
<body>
    <div class="upper-bar">
      <div class="container">
     <?php 

         if  (isset($_SESSION['user'])){

          echo "Welcome ". $_SESSION['user'];
           $userStatus = checkUserStatus($_SESSION['user']);
           echo ' <a href="profaile.php" class="btn btn-info">My Profaile</a>';
           echo ' <a href="Newad.php" class="btn btn-info">New Ads</a>';
            echo ' <a href="profaile.php#my-ads" class="btn btn-info">My Items</a>';

           if ($userStatus == 1){
            echo " Your Member Need  Actvieded";

           }

           ?>
          <a  href="logout.php">
         <span class="pull-right btn btn-danger" >
          Logout
         </span>
         </a>
         <?php
         }else{

     ?>
        <a href="login.php">
          <span class="pull-right btn btn-success" >
            Login|Signup
          </span>
          </a>
       <?php } ?>
    </div>
   </div>
    <nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
    </div>

    <div class="collapse navbar-collapse " id="app-nav">
      <ul class="nav navbar-nav navbar-right">
       <?php foreach (getCat() as $cat) {
              
             echo "<li><a href='categories.php?pageid=". $cat['ID'].
             "&pagename=".str_replace(" ", "-", $cat['Name'])."'>".$cat['Name']."</a></li>";


             }
        ?>
      </ul>

      
    </div>
  </div>
</nav>