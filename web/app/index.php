<?php
// Copyright 2007 Facebook Corp.  All Rights Reserved. 
// 
// Application: Bobby Heartrate's Mafia Tools
//   Based on Facebook skeleton. 
// 

require_once 'facebook.php';
require '../db.php';
require '../sweet.php';
require '../localsettings.php';

$dbcon = db_connect();

$settings = get_local_settings();
$facebook = new Facebook($settings['appapikey'], $settings['appsecret']);
$user_id = $facebook->require_login();

// Greet the currently logged-in user!
?>
<p>Welcome, <fb:name uid="<?php echo $user_id; ?>" useyou="false" />, to <strong>Bobby Heartrate's Mafia Tools Companion</strong>!</p>
<p>Here, you can set your own alias for <a href="http://heartrate.se/sweeturl/">Bobby Heartrate's Mafia Wars URL Sweetener</a>.</p>
<ul>
<li>Your alias can consist only of lowercase letters, digits, and the underscore (_).</li>
<li>It has to begin with a letter.
</ul>
<?php
if (array_key_exists('cmd', $_POST)) {
	$cmd = $_POST['cmd'];
	if($cmd == 'set_alias') {
		if (array_key_exists('alias', $_POST)) {
			$requested_alias = $_POST['alias'];
			$print_alias = htmlspecialchars($requested_alias);
			if (sweet_is_valid_alias($requested_alias)) {
				$ret = db_create_user ($user_id, $dbcon);
/*				if ($ret) 
					echo "<p>User created ok.</p>";
				else
					echo "<p>User already existed.</p>"; */
				if (db_set_alias ($user_id, $requested_alias, $dbcon)) {
					echo "<p><strong>You successfully set your alias to $print_alias.</strong> Now, go have fun!</p>";
					bhmt_log("User $user_id set alias to $requested_alias.\n");
				} else {
					echo "<p>Sorry, the alias $print_alias is taken. Try another one!</p>";
				}
			} else {
				echo "<p>Sorry, $print_alias is not a valid alias. Try another one!</p>";
			}
		}
	}
}

$alias = db_get_alias($user_id, $dbcon);
?>
<form action="http://apps.facebook.com/heartrate/" method="post">
<input type="hidden" name="cmd" value="set_alias" />
Alias: <input type="text" name="alias" value="<?php echo $alias; ?>" />
<input type="submit" value="Set" />
</form>
<?php
if($alias && $alias != "") {
	echo "<h2 style=\"margin-top: 20px; margin-bottom: 10px\" >Give these links to your friends!</h2>";
	sweet_user_table($alias);
}

//echo "<p>Your ID is absolutely $user_id, but that's beside the point.";


// Print out at most 25 of the logged-in user's friends,
// using the friends.get API method
/*
echo "<p>Friends:";
$friends = $facebook->api_client->friends_get();
$friends = array_slice($friends, 0, 25);
foreach ($friends as $friend) {
  echo "<br>$friend";
}
echo "</p>";
*/