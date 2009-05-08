
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
	var siteData;
	$(document).ready(function(){
		loadUsers();
	}); 
	function loadUsers(){
	    $.getJSON("userManager.php?action=list&_rn=" + Math.random(0, 10000), function(data){
			var options="";
				options += '<option value="">('+chooseUser+')</option>';
			for(i=0;i<data.length;i++){
				options += '<option value="'+data[i].id+'">'+data[i].displayname+'</option>';
			}
				options += '<option value="-1">'+addNewUser+'</option>';
			siteData=data;
			$('#userList').html(options);
			loadSite($('#userList option:selected').val());
		});
	}

	function removeRecord(){
		if (confirm(removeRecordText)) {
			$.getJSON("siteManager.php?action=delete&FLD_id="+$('#FLD_id').val(),function(data){  
			  // Display Response to transmission
			   alert(data.status);  
			   loadSites();
			 });
		}
	}
	function saveData(){
		if(confirm(saveConfirmText)){
			var queryString='';
			// Build Data
			$('.datafield').each(function(){  
				  queryString+="&"+this.id+"="+this.value;  
			 });
			 // Send Data 
			$.getJSON("siteManager.php?action=update"+queryString,function(data){  
			  // Display Response to transmission
			   alert(data.status);  
			   loadSites();
			 });
		}
	}
	function selectChange(){
		if($('#userList option:selected').val()==-1){
		// Effect, fade out then clearn for new data.
			$('#editSite').fadeOut('slow',function(){
				$('#FLD_site').val('');
				$('#FLD_user').val('');
				$('#FLD_password').val('');
				$('#FLD_path').val('');
				$('#FLD_id').val(Math.random() * Math.pow(10, 17) + Math.random() * Math.pow(10, 17)); // Psuduo Unique Number
				$('#editSite').fadeIn('slow');
				$('#sitePages').fadeOut('slow');
			});
		}else{
			loadSite($('#siteList option:selected').val());
			$('#sitePages').fadeIn('slow');
		} 
	}
	function loadSite(id){
		// Effect, fade out then load data.
		$('#editSite').fadeOut('slow',function(){
			var found=false; // Trigger for found/not found
			for(i=0;i<siteData.length;i++)	{
				if(siteData[i].id==id){
					// Populate based on key to form value.
					for(var key in siteData[i]){  
			       		$('#FLD_'+key).val(eval('siteData[i].'+key));  
		    		 }  				
					 found=true;
				}
			}
			if(found==false){
				$('#editSite').fadeOut('slow');
			}else{
				$('#editSite').fadeIn('slow');
				listPages();
			}
		});
	}










function addPage(){
	if(confirm(addPageText)){
		var queryString='';
		// Build Data
		$('.pagefield').each(function(){  
			  queryString+="&"+this.id+"="+this.value; 
		 });
		 // Send Data 
		$.getJSON("pageManager.php?action=add"+queryString+'&id='+$('#FLD_id').val(),function(data){  
		  // Display Response to transmission
		   alert(data.status);  
		   listPages();
	   	   $('.pagefield').val('');
		 });
	}
}
function removePage(pageKey){
	if (confirm(removePageText)) {
		$.getJSON("pageManager.php?action=remove&key=" + pageKey, function(data){
			alert(data.status)
		   listPages();
		});
	}
}
function listPages(){
	    $.getJSON("pageManager.php?action=list&id="+$('#FLD_id').val()+"&_rn=" + Math.random(0, 10000), function(data){
			var html="";
			for(i=0;i<data.length;i++){
			html += '<tr><td>'+data[i].title+'</td><td>'+data[i].path+'</td><td><div class="clickField" onclick="removePage(\''+data[i].key+'\')">'+deletePageText+'</div></td></tr>';
			}
			$('#activePages>tbody').html(html);
		});
}
