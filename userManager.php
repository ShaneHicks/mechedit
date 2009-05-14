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

include 'configure.php';
require_once 'authentication.php';
session_start();
// Verfiy the user is logged in
if ( isset ($_GET['action']) && !processLogin()){
    echo NOT_AUTHENTICATED;
    exit ;
}
// Only admin roles can use this API
if($_SESSION['role']!='admin'){
	echo NOT_AUTHORIZED;
	exit;
}
// Actions for this XHR File
if ($_GET['action'] == 'list')
    listUsers();
if ($_GET['action'] == 'update')
    addUpdateData();
if ($_GET['action'] == 'delete')
    removeData();

// XHR Functions
function listUsers()
{
    $userData = getUsers();
	echo json_encode($userData);
}

function addUpdateData(){
    // Build new array array ('id'=>'0', 'displayname'=>'Administrator', 'user'=>'admin', 'password'=>'adminpass', 'role'=>'admin');
    $replacementData = array ('id'=>$_GET['FLD_id'], 'displayname'=>$_GET['FLD_displayname'], 'user'=>$_GET['FLD_user'], 'password'=>$_GET['FLD_password'], 'role'=>$_GET['FLD_role']);
	// Load Users
    $userData = getUsers();
	// Iterate sites, replace if ID match
	$found = false;
	for ($i = 0; $i < sizeof($userData); $i++)
	{
	    if ($userData[$i]['id'] == $_GET['FLD_id'])
	    {
	        $found = true;
		    $userData[$i] = $replacementData;
			break;
		}
	}
	
	// if no match, add new site or report updated
	if ($found == false){
		    $userData[] = $replacementData;
			echo "{status:'".USER_ADDED."'}";
		} else{
			echo "{status:'".USER_UPDATED."'}";
		}
	// Save
	putUsers($userData);
}

function removeData()
{
    $userData = getUsers();
	for ($i = 0; $i < sizeof($userData); $i++){
	    if ($userData[$i]['id'] == $_GET['FLD_id']){
	        $found = true;
		    unset ($userData[$i]);
			break;
		}
	}
	
	if ($found == false){
	    echo "{status:'".USER_NOT_FOUND."'}";
	}else{
	    echo "{status:'".USER_DELETED."'}";
	}
	array_unshift($userData, array_shift($userData));
	putUsers($userData);
}

?>