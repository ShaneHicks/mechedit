<?php

/*******************************************************************************

Mech Edit Copyright 2009 Robert W. Mech

 ($Rev: 0 $)

Website: http://www.mechedit.com/

Author: Robert W. Mech



Mech Edit is available for use in all personal or commercial projects under both 

MIT and GPL licenses. This means that you can choose the license that best suits 

your project, and use it accordingly.



Redistributions of files must retain the above copyright notice.

*******************************************************************************/



	// In the future this could be easily changed to use MYSQL instead of text files.

	require_once ('dataaccess.php');



	// Appearance Settings

	define(THEME_PATH,'themes/basic/');

	define(COMPANY_NAME,'MechEdit');

	define(COMPANY_LOGO,'images/logo.gif');

	define(VERSION_STRING,'Version 1.0 Alpha');

	// Language

	define(LANGUAGE_DIR,'languages/english/');

	include LANGUAGE_DIR.'language.php';



	// Software Configuration

	define(CSS_TAG,'clientedit');

	

  // Strongly suggested this not be publically accessable directory!!!!!!!

	define(DATA_DIR,'data/');



	

?>

