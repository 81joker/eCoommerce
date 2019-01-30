<?php

   include 'concet.php';
   $tpl  = 'include/templates/';    // Templet Directory
   $lang = 'include/languges/';    //languges Directiory
   $css  = 'layout/css/';         // Css Directioy
   $js   = 'layout/js/';         // Js Directioy
   $func = 'include/function/'; // Function Directiory

  

  // Include Important Files
   include $func . 'function.php';  // Include Function
   include   $lang.'english.php';  // Include Lanuge
   include  $tpl."headr.php";     // Include Headr

 // Include Navbar on All pages 
   if (!isset($noNavbar)) {include  $tpl."navbar.php"; }



?>