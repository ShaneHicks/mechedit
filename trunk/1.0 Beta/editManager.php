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
include('simple_html_dom.php');
require_once 'authentication.php';
session_start();
if(isset($_GET['action']) && !processLogin()){
	echo NOT_AUTHENTICATED;
	exit;
}
// Actions for this XHR File
if($_GET['action']=='get')
	getPageJSON();
// Actions for this XHR File
if($_GET['action']=='update')
	updatePage();
function updatePage(){
	// First decode the received data
	$pageData=base64_decode($_POST['data']);
	// Get the page we need to edit
	$html=getPage();
	// Iterate HTML, look for the editable region and make sure it's count matches the one being sent. 
	$eid=0; // Assign logical number to each found class tag
	foreach($html->find('.clienteditor') as $e){ // TODO: change this to variable defined topic for edit regions
	  	if($eid==$_GET['id']){
	  		$e->innertext=$pageData;
	  	}
		$eid++;
	}
	// Post Back the updated HTML object.
	$result=postData($html);
	echo "{'status':'$result'}";
}
function postData($html){
	$pageData=getPages();
	for($i=0;$i<sizeof($pageData);$i++){
		if($pageData[$i]['key']==$_GET['key']){
			$page=$pageData[$i];
		}
	}
	// Return on empty/not found page
	if(!isset($page)){
		return PAGE_NOT_FOUND;
	}
	// Access Site Info
	$siteData=getSites();
	for($i=0;$i<sizeof($siteData);$i++){
		if($siteData[$i]['id']==$page['id']){
			$site=$siteData[$i];
		}
	}
	// Return on empty/not found page
	if(!isset($site)){
		return SITE_NOT_FOUND;
	}
	//  Real Work Done Here
	// FTP Connection Setup
	$ftp_server=$site['site'];
	$ftp_user_name=$site['user'];
	$ftp_user_pass=$site['password'];
	$local_file = tempnam("/tmp", "tmp");
	$source_file=$local_file;
	$server_file=$site['path'].$page['path'];
	// set up basic connection
	$conn_id = ftp_connect($ftp_server); 
	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	// check connection
	if ((!$conn_id) || (!$login_result)) { 
        return  FTP_CONNECT_FAILURE . "$ftp_user_name @ $ftp_server"; 
    }
	file_put_contents($source_file,$html);
	// upload the file
	$upload = ftp_put($conn_id, $server_file, $source_file, FTP_BINARY); 
	// close the FTP stream 
	ftp_close($conn_id);  
	unlink($source_file);
	// check upload status
	if (!$upload) { 
	        return FTP_UPLOAD_FAILURE;
    } else {
	        return FTP_UPLOAD_SUCCESS;
    }
}
/*
 * Change the HTML DOM object into an array for those editable items 
 * and echo the JSON data back to the client.
 */
function getPageJSON(){
	$html=getPage();
	$eid=0; // Assign logical number to each found class in linear order
	foreach($html->find('.clienteditor') as $e){ // TODO: change this to variable defined topic for edit regions
		if(isset($e->attr['title']))
			$title=$e->attr['title'];
		else
			$title='';
		// Type Checking (to see what sort of editor box we need)
		if(array_search(strtoupper($e->tag),array('H1','H2','H3','H4','H5','H6'))!==false){
			$type=TXT_HEADING_TAG;
		}elseif(array_search(strtoupper($e->tag),array('pre'))!==false){
			$type=TXT_FIXED_WIDTH;
		}else{
			$type=TXT_STANDARD;
		}
	    $pageHTML[]=array('id'=> $eid, 'HTML'=>base64_encode($e->innertext),'title'=>$title,'tag'=>$e->tag,'type'=>$type);
		$eid++;
	}	
	echo json_encode($pageHTML);
}
/*
 * Function to retreive the file VIA FTP and then return a DOM object for further processing
 * TODO: Clean up procedure and add error handling.
 * @returns a DOM object from the FTP file.
 */
function getPage(){
	$pageData=getPages();
	for($i=0;$i<sizeof($pageData);$i++){
		if($pageData[$i]['key']==$_GET['key']){
			$page=$pageData[$i];
		}
	}
	// Return on empty/not found page
	if(!isset($page)){
		return;
	}
	// Access Site Info
	$siteData=getSites();
	for($i=0;$i<sizeof($siteData);$i++){
		if($siteData[$i]['id']==$page['id']){
			$site=$siteData[$i];
		}
	}
	// Return on empty/not found page
	if(!isset($site)){
		return;
	}
	//  Real Work Done Here
	// FTP Connection Setup
	$ftp_server=$site['site'];
	$ftp_user_name=$site['user'];
	$ftp_user_pass=$site['password'];
	$local_file = tempnam("/tmp", "tmp");
	$server_file=$site['path'].$page['path'];
	// set up basic connection
	$conn_id = ftp_connect($ftp_server); 
	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	// check connection
	if ((!$conn_id) || (!$login_result)) { 
        echo "FTP connection has failed!";
        echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
        exit; 
    } 
	if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
//	    echo "Successfully written to $local_file\n";
	} else {
	    echo "There was a problem\n";
	}
	// close the FTP stream 
	ftp_close($conn_id);  
	$html = file_get_html($local_file);
	unlink($local_file);
	return $html;
}
?>
