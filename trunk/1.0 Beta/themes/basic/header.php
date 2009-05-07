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
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>    
  <head>        
    <meta http-equiv="content-type" content="text/html; charset=windows-1250">        
    <title>            
      <?= COMPANY_NAME ?>            
      <?= TXT_POWEREDBY ?>        
    </title>        
    <link href="themes/basic/style.css" media="all" rel="stylesheet" type="text/css">        
<?php
        scriptIncludes();
            ?>        
<script src="jscripts/jquery/jquery.corner.js"></script>    
  </head>    
  <body>        
    <div id="wrapper">            
      <div id="header">                <h1>                    
          <?= COMPANY_NAME ?>                </h1>                
        <div id="topnav">                    
<?php
                    buildLinks();
                              ?>                
        </div>            
      </div>
