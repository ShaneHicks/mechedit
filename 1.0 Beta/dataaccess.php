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

// Users
function getUsers()
{
    error_reporting(0);
    $users = file_get_contents(DATA_DIR.'users.dat');
    if ($users === false)
    {
        $userData[0] = array ('id'=>'0', 'site'=>'Administrator', 'user'=>'admin', 'password'=>'adminpass', 'role'=>'admin');
        $userData[1] = array ('id'=>'1', 'site'=>'Editor', 'user'=>'editor', 'password'=>'editorpass', 'role'=>'editor');
        putUsers($userData);
    } else
    {
        $userData = unserialize($users);
    }
    error_reporting(1);
    return $userData;

}

function putUsers($userData)
{
    file_put_contents(DATA_DIR.'users.dat', serialize($userData));
}

// Generic Get Sites Function
function getSites()
{

    error_reporting(0);
    $sites = file_get_contents(DATA_DIR.'sites.dat');
    if ($sites === false)
    {
        $siteData[0] = array ('id'=>'0', 'site'=>'www.example.net', 'user'=>'user', 'password'=>'password', 'path'=>'public_html/');
        putSites($siteData);
    } else
    {
        $siteData = unserialize($sites);
    }
    error_reporting(1);
    return $siteData;
}

function putSites($siteData)
{
    file_put_contents(DATA_DIR.'sites.dat', serialize($siteData));
}



// Pages
function getPages()
{
    error_reporting(0);
    $pages = file_get_contents(DATA_DIR.'pages.dat');
    if ($pages === false)
    {
        $pageData = array ();
    } else
    {
        $pageData = unserialize($pages);
    }

    error_reporting(1);
    return $pageData;
}

function putPages($pageData)
{
    file_put_contents(DATA_DIR.'pages.dat', serialize($pageData));
}
?>
