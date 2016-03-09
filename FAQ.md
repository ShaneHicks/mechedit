#Frequently Asked Questions

### How do I use this on my own website? ###
If you have an HTML website and you want to use it on your own site then you'll need to set it up as if you were setting it up for a remote host anyhow.

Simply setup the software like you would to access a remote FTP server.

site: www.yourhost.com (alternatively you might try 127.0.0.1 which is "localhost")
Then specify your username/password for FTP.

Assign pages like you would for a remote host.  Basically the net effect here is that the software will FTP back to it's own host to upload the files.  While it's a pretty inefficient manner to modify files the software was designed to be installed on one host and access another.  This however this is a workaround that should work.

### Can I use this to edit PHP/ASP/JSP Files? ###
Not directly.  You can however create a .html which the PHP/ASP/JSP file includes at run time and displays.  This is the easiest way to get support into coded web pages.

### Can I use this in a commercial project? ###
Yes, the software is licensed under MIT and GPL so feel free to use it for your customers.