<?php
/* Edit this and move it to the directory next to all the other php files */

function get_local_settings() {
	return array(
		     /* Database */
		     'server'   => 'server:port',
		     'user'     => 'myusername',
		     'password' => 'mypassword',
		     'database' => 'databasename',
		     
		     /* Facebook app */
		     'appapikey' => '',
		     'appsecret' => '',

		     /* Log file */
		     'logfile' => '',
		     );
}
?>