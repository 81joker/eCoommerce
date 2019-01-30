<?php 


 /*
  
   Categories ==> [Mange| Edit | Update | Add | Insert | Delete | Stats]
   Categories ? True  : false 
 */

   $do =  isset($_GET['do']) ? $_GET['do'] : 'Mange';

  // If The Page Main Page 

   if ($do == 'Mange') {

    echo "Welcome You Are In Mange Category Page";
    echo "<a href=?do=Add>Add New Category +</a>";

   } elseif ($do == 'Add') {

   	echo 'Welcome You Are In Add Category Page';

   	} elseif ($do == 'Insert') {

   	echo 'Welcome You Are In Insert Category Page';
   	
   } else {

   echo "Error There\'s No Page With This Name";

   }



   /*
   if(isset($_GET['do'])) {

    $do = $_GET['do'];


   } else {
   
   $do = 'Mange';


   }
   */