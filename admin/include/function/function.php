<?php

 
/*
  ** Title Function v1.0
  ** Title Function That Echo The Page Title In Case The Page
  ** Has The Variable $pageTitle And Echo Defult Title For Other Pages
  */

 function printTitle() {

 	global $printTitle;

 	if (isset($printTitle)) {

 		echo $printTitle;

 	} else {
 		

 		echo "Default";
 	}


 }

 /*
  ** Home Redirect Function v2.0
  ** This Function Accept Parameters
  ** $theMsg = Echo The Message [ Error | Success | Warning ]
  ** $url = The Link You Want To Redirect To
  ** $seconds = Seconds Before Redirecting
  */
function redirectHome($theMsg, $url = null ,  $seconds = 3 ) {


      if ($url === null ) {

  
   	  $url = 'index.php';
   	  $link = 'Home Page';

 } else {
   
  if (isset($_SERVER['HTTP_REFERER'])  &&  $_SERVER['HTTP_REFERER'] !== '') {


      $url = $_SERVER['HTTP_REFERER'];
      $link = 'Previous Page';


  } else {

        $url  = 'index.php';
        $link = 'Home Page';

   }	
}
 echo $theMsg;

 echo "<div class='alert alert-info'>You Will Be Redirect To $link After $seconds Second</div>";

 header ("refresh:$seconds; url= $url");
 exit();

}

/*
** Check Item Function  V1.0
** Function To Check Item In Database [ Function Accept Prameters ]
** $Select = The Item To Select [ Exemple: user, item, category ]
** $Value = The Value Of Select [Exemple: joker , Box]
*/

function checkItem($select, $form, $value) {

   global $con;

   $stmt2 = $con->prepare("SELECT $select FROM $form WHERE $select = ?");

   $stmt2->execute(array($value));

   $count = $stmt2->rowCount();

   return  $count; 
   exit();

}

/*
  ** Count Number Of Items Function v1.0
  ** Function To Count Number Of Items Rows
  ** $item = The Item To Count
  ** $table = The Table To Choose From
  */

 function countItems($item, $table) {
 	global $con;


    $stmt3 = $con->prepare("SELECT COUNT($item) FROM $table");


    $stmt3->execute();

    return $stmt3->fetchcolumn();

 }



  /*
  ** Get Latest Records Function v1.0
  ** Function To Get Latest Items From Database [ Users, Items, Comments ]
  ** $select = Field To Select
  ** $table = The Table To Choose From
  ** $order = The Desc Ordering
  ** $limit = Number Of Records To Get
  */


	function getLatest($select, $table, $order ,  $limt = 2)  {
 
    global $con;

    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limt ") ; 

    $getStmt->execute();

    $rows = $getStmt->fetchAll();

    return $rows ; 


	}








