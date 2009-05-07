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
    listSites();
if ($_GET['action'] == 'update')
    addUpdateData();
if ($_GET['action'] == 'delete')
    removeData();



// XHR Functions
function listSites()
{
    $siteData = getSites();
echo json_encode($siteData);
}

function addUpdateData()
{
    // Build new array
    $replacementData = array ('id'=>$_GET['FLD_id'], 'site'=>$_GET['FLD_site'], 'user'=>$_GET['FLD_user'], 'password'=>$_GET['FLD_password'], 'path'=>$_GET['FLD_path']);
// Load Sites
$siteData = getSites();

// Iterate sites, replace if ID match

$found = false;

for ($i = 0; $i < sizeof($siteData); $i++)
{
    if ($siteData[$i]['id'] == $_GET['FLD_id'])
    {
        $found = true;
    $siteData[$i] = $replacementData;
break;
}
}

// if no match, add new site or report updated
if ($found == false)
{
    $siteData[] = $replacementData;

echo "{status:'".SITE_ADDED."'}";

} else
{

    echo "{status:'".SITE_UPDATED."'}";

}

// Save
putSites($siteData);
}

function removeData()
{

    $siteData = getSites();
	for ($i = 0; $i < sizeof($siteData); $i++)
	{
	    if ($siteData[$i]['id'] == $_GET['FLD_id'])
	    {
	        $found = true;
	    unset ($siteData[$i]);
	break;
	}
	}
	
	if ($found == false)
	{
	    echo "{status:'".SITE_NOT_FOUND."'}";
	} else
	{
	    echo "{status:'".SITE_DELETED."'}";
	}
	array_unshift($siteData, array_shift($siteData));
	putSites($siteData);
}
?>