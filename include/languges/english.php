<?php 


function lang ( $phrase ) {
  
  static $lang = array (
     // Navbar Links
   'HOME_ADMIN'	=> 'Home',
   'CATEGORIES' => 'Categories',
   'ITEMS' 		=> 'Items',
   'MEMBERS' 	=> 'Members',
   'Comments'	=> 'COMMENTS',
   'LOGS' 		=> 'Logs',
		   	'' => '',
			'' => '',
			'' => '',
			'' => '',

  );

  return $lang[$phrase];


}

?>

