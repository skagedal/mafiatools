Bobby Heartrate's Mafia Tools
=============================

Yes, this is brief... I don't really expect a lot of people to use
this except me. :)

Installation
------------

 - Copy localsettings.php from doc/ to web/
 - Edit it to suit your needs. 

If you're running Ubuntu, and you want your own little local copy of
BHMT, do this:

 - add a line to /etc/hosts:
   127.0.0.1  localheart
 - copy the file "localheart" from docs to /etc/apache2/sites-available
 - sudo a2ensite localheart
 - sudo a2enmod rewrite (if you don't have mod_rewrite enabled already)

Contact
-------

Create patches with "diff -u" and mail to bobby at heartrate dot se.
