<?php 

/*
================================================
== Category Page
================================================
*/
ob_start(); // Output Buffering Start

session_start();

$pageTitle = 'Categories';

if (isset($_SESSION['Username'])) {

		include 'init.php';

	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if ($do == 'Manage') {

   echo "Manage";

	} elseif ($do == 'Add') {

     echo "Add";
		
	
	} elseif ($do == 'Insert') {

    echo "Insert";


	} elseif ($do == 'Edit') {


		
	} elseif ($do == 'Update') {


    } elseif ($do == 'Delete') {



    } elseif ($do == 'Actiavte') {


    }


    include   $tpl."foooter.php";


  } else {
  	
  header('Location: index.php');

  expm1();
  }
  ob_end_flush(); // Release The output_add_rewrite_var(name, value)

  ?>