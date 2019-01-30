<?php 

   session_start();

    $printTitle="catogery";

    include "init.php"; ?>
  <div class="container text-center">
	  <h1>Schow Categorey</h1>
	  <div class="row">
	  <?php 
	   foreach (getItems("Cat_ID", $_GET["pageid"]) as $IItem){
	   	echo "<div class='col-sm-4 col-md-3'>";
	    echo "<span class='price'>".$IItem['Price']."</span>";
	   	  echo  "<div class='thumbnail'>";
	   	      echo "<img src='4.jpg'  alt=''>";
		   	      echo "<div class='caption'>";
	                  echo "<h3><a href='newItem.php?itemid=".$IItem['item_ID']."'>" .$IItem['Name']."</a></h3>";
	                  echo "<p>" .$IItem['Description']."</p>";
	               echo "</div>";
    	   echo "</div>";
	   echo "</div>";
	    }
	  ?> 
  </div>
 </div> 

<?php  include  $temp."foooter.php" ?>










