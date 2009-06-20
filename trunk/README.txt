Bobby Heartrate's Mafia Tools
=============================

Yes, this is brief... I don't really expect a lot of people to use
this except me. :)

Installation
------------

 - Copy localsettings.php from doc/ to web/
 - Edit it to suit your needs. 

Linux:

These instructions are for Ubuntu, it should work similarly on other
Linux distributions and other Unix-like systems with Apache.

 - add a line to /etc/hosts:
   127.0.0.1  localheart
 - copy the file "localheart" from docs to
   /etc/apache2/sites-available and edit it to include your path
 - sudo a2ensite localheart
 - sudo a2enmod rewrite (if you don't have mod_rewrite enabled already)

Windows:

 - install XAMPP Lite
 - add a line to C:\WINDOWS\system32\drivers\etc\hosts:
 - include the file "localheart" in C:\xampplite\apache\conf\extra\httpd-vhosts.conf

Contact
-------

Create patches with "diff -u" and mail to bobby at heartrate dot se.
