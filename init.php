<?php

 ini_set('display_errors', 'on');
 error_reporting(E_ALL);

 $sessionUser = '';
 if (isset($_SESSION['user'])){
$sessionUser = $_SESSION['user'];

 }



   include 'admin/concet.php';
   $temp = 'include/templates/'; // Templet Directory
   $lang = 'include/languges/';
   $css  = 'layout/css/';       // Css Directioy
   $js   = 'layout/js/';        // Js Directioy
   $func = 'include/function/';

  

  // Include Important Files
   include $func . 'function.php';
   include $lang.'english.php';
   include $temp."headr.php";
 






