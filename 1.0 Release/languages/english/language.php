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
// Language Definitions
define(LANGUAGE_NAME,'English - US');

// General Web Text
define(NOT_AUTHENTICATED,"{status :'You have not been authenticated and can not use this API service'}");  // Must be in JSON Format
define(NOT_AUTHORIZED,"{status :'You are not authorized to use this API service.'}");  // Must be in JSON Format
define(TXT_HOME,'Home');
define(TXT_SITES,'Add/Remove Sites');
define(TXT_USER,'Users');
define(TXT_EDITOR,'Edit Pages');
define(TXT_LOGOUT,'Logout');
define(TXT_PORTAL,'Editing Portal');
define(TXT_POWEREDBY,'is powered by MechEdit');
// NOTE: These next values must match exactly the value in page_editor.js
define(TXT_STANDARD,'Standard Editor');
define(TXT_FIXED_WIDTH,'Fixed Width');
define(TXT_HEADING_TAG,'Heading Tag');


// FTP
define(FTP_CONNECT_FAILURE,'FTP connection has failed! - Attempted to connect to');
define(FTP_UPLOAD_FAILURE,"FTP upload has failed!");
define(FTP_UPLOAD_SUCCESS,'File Sucessfully Uploaded');

// Page
define(PAGE_NOT_FOUND,'This page was not found in the database');
define(PAGE_ADDED,'New page added successfully.');
define(PAGE_DELETED,'This page has been removed');
define(PAGE_NOT_FOUND,'This page was not found in the repository, perhaps it was already deleted?');

// Site
define(SITE_NOT_FOUND,'This site was not found in the database');
define(SITE_ADDED,'New Site Added!');
define(SITE_UPDATED,'Site record updated');
define(SITE_NOT_FOUND,'This site was not found in the repository, perhaps it was already deleted?');
define(SITE_DELETED,'This site has been removed');

// User
define(USER_NOT_FOUND,'This user was not found in the database');
define(USER_ADDED,'New User Added!');
define(USER_UPDATED,'User record updated');
define(USER_NOT_FOUND,'This user was not found in the repository, perhaps it was already deleted?');
define(USER_DELETED,'This user has been removed');


?>
