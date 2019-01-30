<?php 

session_start();// Start The ssesion

session_unset(); // Unset The Data

session_destroy(); // Destory The session

header('Location: index.php');

exit();