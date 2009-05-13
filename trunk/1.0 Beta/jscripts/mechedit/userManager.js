
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
	var userData;
	$(document).ready(function(){
		loadUsers();
	}); 
	function loadUsers(){
        $('#statusBox').html(loadingMessage);
	    $.getJSON("userManager.php?action=list&_rn=" + Math.random(0, 10000), function(data){
			var options="";
				options += '<option value="">('+chooseUser+')</option>';
			for(i=0;i<data.length;i++){
				options += '<option value="'+data[i].id+'">'+data[i].displayname+'</option>';
			}
				options += '<option value="-1">'+addNewUser+'</option>';
			userData=data;
			$('#userList').html(options);
	        $('#statusBox').html('');
			loadUser($('#userList option:selected').val());
			loadSites();
		});
	}

	function removeRecord(){
		if (confirm(removeRecordText)) {
	        $('#statusBox').html(loadingMessage);
			$.getJSON("userManager.php?action=delete&FLD_id="+$('#FLD_id').val(),function(data){  
			  // Display Response to transmission
			   alert(data.status);  
			   $('#statusBox').html('');
			   loadUsers();
			 });
		}
	}
	function saveData(){
		if(confirm(saveConfirmText)){
	        $('#statusBox').html(loadingMessage);
			var queryString='';
			// Build Data
			$('.datafield').each(function(){  
				  queryString+="&"+this.id+"="+this.value;  
			 });
			 // Send Data 
			$.getJSON("userManager.php?action=update"+queryString,function(data){  
			  // Display Response to transmission
			   alert(data.status);  
		        $('#statusBox').html('');
			   loadUsers();
			 });
		}
	}
	function selectChange(){
		if($('#userList option:selected').val()==-1){
		// Effect, fade out then clearn for new data.
			$('#editUser').fadeOut('slow',function(){
				$('#FLD_displayname').val('');
				$('#FLD_user').val('');
				$('#FLD_password').val('');
				$('#FLD_role').val('Editor');
				$('#FLD_id').val(Math.random() * Math.pow(10, 17) + Math.random() * Math.pow(10, 17)); // Psuduo Unique Number
				$('#editUser').fadeIn('slow');
				$('#sitePages').fadeOut('slow');
			});
		}else{
			loadUser($('#userList option:selected').val());
			$('#userList').fadeIn('slow');
		} 
	}
	function loadUser(id){
		// Effect, fade out then load data.
		$('#editUser').fadeOut('slow',function(){
			var found=false; // Trigger for found/not found
			for(i=0;i<userData.length;i++)	{
				if(userData[i].id==id){
					// Populate based on key to form value.
					for(var key in userData[i]){  
			       		$('#FLD_'+key).val(eval('userData[i].'+key));  
		    		 }  				
					 found=true;
				}
			}
			if(found==false){
				$('#editUser').fadeOut('slow');
			}else{
				$('#editUser').fadeIn('slow');
				listPages();
			}
		});
	}

function addPage(){
	if(confirm(addPageText)){
        $('#statusBox').html(loadingMessage);
		var queryString='';
		 // Send Data 
		$.getJSON("userPageManager.php?action=add"+queryString+
				'&id='+$('#FLD_id').val()+
				'&site='+$('#siteList option:selected').text()+
				'&key='+$('#pageList option:selected').val()+
				'&title='+$('#pageList option:selected').text()+
				'&user='+$('#FLD_user').val(),function(data){  
					  // Display Response to transmission
					   alert(data.status);  
				        $('#statusBox').html('');
					   listPages();
				   	   $('.pagefield').val('');
		 });
	}
}
function removePage(pageKey){
	if (confirm(removePageText)) {
        $('#statusBox').html(loadingMessage);
		$.getJSON("userPageManager.php?action=remove&key=" + pageKey, function(data){
			alert(data.status)
			$('#statusBox').html('');
		   listPages();
		});
	}
}
function listPages(){
		$('#statusBox').html(loadingMessage);
	    $.getJSON("userPageManager.php?action=list&user="+$('#FLD_user').val()+"&_rn=" + Math.random(0, 10000), function(data){
			var html="";
			for(i=0;i<data.length;i++){
			html += '<tr><td>'+data[i].site+'</td><td>'+data[i].title+'</td><td><div class="clickField" onclick="removePage(\''+data[i].key+'\')">'+deletePageText+'</div></td></tr>';
			}
			$('#activePages>tbody').html(html);
	        $('#statusBox').html('');
		});
}
function listSitePages(){
    $('#statusBox').html(loadingMessage);
    $.getJSON("pageManager.php?action=list&id="+$('#siteList option:selected').val()+"&_rn=" + Math.random(0, 10000), function(data){
		var html="";
		for(i=0;i<data.length;i++){
		html += '<option value="'+data[i].key+'">'+data[i].title+'</option>';
		}
		$('#pageList').html(html);
        $('#statusBox').html('');
	});
}
