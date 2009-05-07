<?php
/*******************************************************************************
Mech Edit Copyright 2009 Robert W. Mech
 ($Rev: 0 $)
Website: http://mechedit.mechsoftware.com/
Author: Robert W. Mech

Mech Edit is available for use in all personal or commercial projects under both 
MIT and GPL licenses. This means that you can choose the license that best suits 
your project, and use it accordingly.

Redistributions of files must retain the above copyright notice.
*******************************************************************************/
require_once 'authentication.php';
include 'siteManager.php';
/*
 * Main Output Function
 */
function mainContent(){
	if(!processLogin()){
			echo file_get_contents(LANGUAGE_DIR.'login.html');
			return; // Exit if not logged in
	}
	// Normal Processing
	if(empty($_GET[q])){
		echo file_get_contents(LANGUAGE_DIR.'welcome.html');
	}elseif($_GET[q]=='sites'){
		echo file_get_contents(LANGUAGE_DIR.'site_manager.html');
	}elseif($_GET[q]=='edit'){
		echo file_get_contents(LANGUAGE_DIR.'page_editor.html');
	}elseif($_GET[q]=='logout'){
		session_destroy();
		echo "<script>document.location='index.php'</script>"; // Redirect to login page
	}else{
		echo file_get_contents(LANGUAGE_DIR.'welcome.html');
	}
}
/*
 * Include all scripts necessary
 */
function scriptIncludes(){
	// jQuery and jQuery Corners
	echo '<script src="jscripts/jquery/jquery-1.3.2.min.js"></script>'."\n";
	echo '<script src="jscripts/jquery/jquery.corner.js"></script>'."\n";
	if($_GET[q]=='sites'){ // Site Manager Script
		echo '<script src="jscripts/mechedit/siteManager.js"></script>'."\n";
		echo '<script src="jscripts/mechedit/pageManager.js"></script>'."\n";
	}
	if($_GET[q]=='edit'){ // Site Manager Script
		echo '<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>'."\n";
		echo '<script src="jscripts/other/json2.js"></script>'."\n";
		echo '<script src="jscripts/mechedit/editManager.js"></script>'."\n";
		
	}
}
/*
 * Activate Javascript in footer
 */
function scriptActivation(){
	echo '
		<script>
		$(document).ready(function(){
			$("#wrapper").corner("20px");	
		});
		</script>	
	';	
}

function buildLinks(){
	processLogin();
	// Admins can access site administration, every valid user can access page editing.
	?>
	      <ul>
	        <li><a href="index.php"><?=TXT_HOME?></a></li>
<?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'): ?>
	        <li><a href="index.php?q=sites"><?=TXT_SITES?></a></li>
<?php endif ?>
<?php if(isset($_SESSION['role'])): ?>
	        <li><a href="index.php?q=edit"><?=TXT_EDITOR?></a></li>
	        <li><a href="index.php?q=logout"><?=TXT_LOGOUT?></a></li>
<?php endif ?>
	      </ul>
	<?php
}

?>
