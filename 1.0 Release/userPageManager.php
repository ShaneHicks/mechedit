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
if(isset($_GET['action']) && !processLogin()){
	echo NOT_AUTHENTICATED;
	exit;
}

if($_GET['action']=='add' || $_GET['action']=='remove'){
	// Only admin roles can use this API to add and remove
	if($_SESSION['role']!='admin'){
		echo NOT_AUTHORIZED;
		exit;
	}
}
// Default Values
if(!isset($_GET['user'])){
	$_GET['user']=$_SESSION['username'];
}

// Actions for this XHR File
if($_GET['action']=='list')
	listPages();
if($_GET['action']=='add')
	addPage();
if($_GET['action']=='remove')
	removePage();
function removePage(){
	$userPageData=getUserPages();
	$found=false;
	for($i=0;$i<sizeof($userPageData);$i++){
		if($userPageData[$i]['key']==$_GET['key']){
			$found=true;
			unset($userPageData[$i]);
			break;
		}
	}
	if($found==true){
		array_unshift ($userPageData, array_shift ($userPageData));
		putUserPages($userPageData);	
		echo "{status:'".PAGE_DELETED."'}";
	}else{
		echo "{status:'".PAGE_NOT_FOUND."'}";
	}
}
// Return pages only for user.
function listPages(){
	$pageResult=array();	
	$userPageData=getUserPages();
	for($i=0;$i<sizeof($userPageData);$i++){
		if($userPageData[$i]['user']==$_GET['user']){
			$pageResult[]=$userPageData[$i];
		}
	}
	echo json_encode($pageResult);
}
function addPage(){
	// No "update" just add pages, delete and re-add if update necessary.
	$userPageData=getUserPages();
	$userPageData[]=array('id'=> $_GET['id'], 'user'=>$_GET['user'],'key'=>$_GET['key'],'title'=>$_GET['title'],'site'=>$_GET['site']);
	putUserPages($userPageData);
	echo "{status:'".PAGE_ADDED."'}";
}
?>
