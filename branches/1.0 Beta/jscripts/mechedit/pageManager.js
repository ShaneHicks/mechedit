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
function addPage(){
	if(confirm(addPageText)){
        $('#statusBox').html(loadingMessage);
		var queryString='';
		// Build Data
		$('.pagefield').each(function(){  
			  queryString+="&"+this.id+"="+this.value; 
		 });
		 // Send Data 
		$.getJSON("pageManager.php?action=add"+queryString+'&id='+$('#FLD_id').val(),function(data){  
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
		$.getJSON("pageManager.php?action=remove&key=" + pageKey, function(data){
			alert(data.status)
			$('#statusBox').html('');
		   listPages();
		});
	}
}
function listPages(){
		$('#statusBox').html(loadingMessage);
	    $.getJSON("pageManager.php?action=list&id="+$('#FLD_id').val()+"&_rn=" + Math.random(0, 10000), function(data){
			var html="";
			for(i=0;i<data.length;i++){
			html += '<tr><td>'+data[i].title+'</td><td>'+data[i].path+'</td><td><div class="clickField" onclick="removePage(\''+data[i].key+'\')">'+deletePageText+'</div></td></tr>';
			}
			$('#activePages>tbody').html(html);
	        $('#statusBox').html('');
		});
}
