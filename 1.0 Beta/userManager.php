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
if ( isset ($_GET['action']) && !processLogin())
{
    echo NOT_AUTHENTICATED;
    exit ;
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
?>