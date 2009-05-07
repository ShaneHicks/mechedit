<?php

function processLogin(){
	if(!isset($_SESSION['username'])){
		if(!isset($_REQUEST['user'])){
			return false;		
		}else{
			// Process login request
			if(!isset($_REQUEST['user']) || !isset($_REQUEST['pass']))
				return false;
			// Obtain User Object
			$users=getUsers();
			$validUser=false;
			for($i=0;$i<sizeof($users);$i++){
				if($users[$i]['user']==$_REQUEST['user']){
					if($users[$i]['password']==$_REQUEST['pass']){
						$validUser=true;
						$_SESSION['username']=$users[$i]['user'];
						$_SESSION['role']=$users[$i]['role'];
						break;
					}
				}
			}
			if($validUser==false)
				return false;
		}
	}
	// Username established, so valid session verified.
	return true;
}

?>
