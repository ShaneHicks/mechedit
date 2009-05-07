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



// Actions for this XHR File

if($_GET['action']=='list')

	listPages();

if($_GET['action']=='add')

	addPage();

if($_GET['action']=='remove')

	removePage();



function removePage(){

	$pageData=getPages();

	$found=false;

	for($i=0;$i<sizeof($pageData);$i++){

		if($pageData[$i]['key']==$_GET['key']){

			$found=true;

			unset($pageData[$i]);

			break;

		}

	}

	if($found==true){

		array_unshift ($pageData, array_shift ($pageData));

		putPages($pageData);	

		echo "{status:'".PAGE_DELETED."'}";

	}else{

		echo "{status:'".PAGE_NOT_FOUND."'}";

	}

}

function listPages(){

	$pageResult=array();	

	$pageData=getPages();

	for($i=0;$i<sizeof($pageData);$i++){

		if($pageData[$i]['id']==$_GET['id']){

			$pageResult[]=$pageData[$i];

		}

	}

	echo json_encode($pageResult);

}



function addPage(){

	// No "update" just add pages, delete and re-add if update necessary.

	$pageData=getPages();

	$pageData[]=array('id'=> $_GET['id'], 'title'=>$_GET['PAG_name'],'path'=>$_GET['PAG_path'],'key'=>uniqid());

	putPages($pageData);

	echo "{status:'".PAGE_ADDED."'}";

}





?>
