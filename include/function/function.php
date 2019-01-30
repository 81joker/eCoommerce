<?php

 

/*
  ** Check If User Is Not Activated
  ** Function To Check The RegStatus Of The User
  */

  function checkUserStatus($user) {

    global $con;

    $stmtx = $con->prepare("SELECT 
                  Username, RagStutes  
                FROM 
                  users 
                WHERE 
                  Username = ? 
                AND 
                  RagStutes = 0");

    $stmtx->execute(array($user));

    $status = $stmtx->rowCount();

    return $status;

  }


/*
  ** Get All Function v2.0
  ** Function To Get Catogries From Database 
 
  */

  function getCat()  {
 
    global $con;

    $getCat = $con->prepare("SELECT * FROM categories ") ; 

    $getCat->execute();

    $cats = $getCat->fetchAll();

    return $cats ; 


  }




/*
  ** Get All Function v2.0
  ** Function To Get Catogries From Database 
 
  */

  function getItems($where, $value)  {
 
    global $con;

    $getItems = $con->prepare("SELECT * FROM items Where $where=? ORDER BY  item_ID DESC ") ; 

    $getItems->execute(array($value));

    $item = $getItems->fetchAll();

    return $item ; 


  }





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
 ** The Funcion Pramiters 
 ** $theMsg = echo The error Message
 ** $second  = Second Before Radirecting
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


  /*
  ** Get All Function v2.0
  ** Function To Get All Records From Any Database Table
  */

  function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

    global $con;

    $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

    $getAll->execute();

    $all = $getAll->fetchAll();

    return $all;

  }
  






