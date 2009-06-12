<?php
/*
 *  This file is part of Bobby Heartrate's Mafia Tools.
 *
 *  Bobby Heartrate's Mafia Tools is free software: you can
 *  redistribute it and/or modify it under the terms of the GNU Affero
 *  General Public License as published by the Free Software
 *  Foundation, either version 3 of the License, or (at your option)
 *  any later version.
 *
 *  Bobby Heartrate's Mafia Tools is distributed in the hope that it
 *  will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *  See the GNU Affero General Public License for more details.
 */

require_once 'bhmt.php';
require_once 'db.php';

$actions = array(
	'user'		=> array('func' => "sweet_do_user",
						 'help' => 'view $NAME\'s sweetlinks'),
	'add' 		=> array('url' => 
						 'http://apps.facebook.com/inthemafia/status_invite.php?from=$ID',
						 'help' => 
						 'add $NAME to your mafia'),
	'profile' 	=> array('url' => 
						 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=stats&xw_action=view&user=$ID',
						 'help' =>
						 'view $NAME\'s Mafia Wars profile'),
	'promote' 	=> array('url' =>
						 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=group&xw_action=view&promote=yes&uid=$ID',
						 'help' =>
						 'promote $NAME to your Top Mafia'),
	'hitlist' 	=> array('func' => "sweet_do_hitlist",
						 'help' => 
						 'add $NAME to the hit list'),
	'attack' 	=> array('url' =>
						 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=fight&xw_action=attack&opponent_id=$ID',
						 'help' =>
						 'attack $NAME'),
	'punch' 	=> array('url' =>
				'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=fight&xw_action=punch&action=punch&opponent_id=$ID',
						 'help' =>
						 'punch $NAME in the face'),
	'rob' 		=> array('url' =>
						 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=racket&xw_action=view&opponent_id=$ID',
						 'help' => 
						 'rob $NAME\'s properties'),
	'give_help_to' => array('url' =>
						 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=job&xw_action=give_help&target_id=$ID',
						 'help' => 'give help on a job to $NAME'),
	'send_energy_to' => array('url' => 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=group&xw_action=energy&fid=$ID',
						 'help' => 'send energy to $NAME'),
	'give'		=> array('help' => 'give stuff to $NAME'),
	'fb'		=> array('url' => 
						 'http://www.facebook.com/profile.php?id=$ID',
						 'help' => 'view $NAME\'s Facebook profile'),
	'fbadd'	    => array('url' =>
					     'http://www.facebook.com/addfriend.php?id=$ID',
						 'help' => 'request Facebook friendship with $NAME'),
	'message'	=> array('url' => 'http://www.facebook.com/inbox/?compose&id=$ID',
						 'help' => 'message $NAME on Facebook'),
	'set'		=> array('func' => 'sweet_do_set', 'no_user' => 'yes')
);

function is_not_empty_string($s) {
	return !(trim($s) == '');
}

function sweet_parse($cmd) {
	$cmd = rtrim(trim($cmd),'/');
	if ($cmd == '')
		return array();
	else 
		return explode('/', $cmd);
}

function sweet_error_and_die($err) {
	bhmt_head(array('title' => 'Error'));
	bhmt_body_start('error');
	echo $err;
	bhmt_body_end();
	die();
}

function sweet_is_number($str) {
	return (preg_match('/^\d+$/', $str) != 0);
}

function sweet_is_valid_alias($alias) {
	$reserved = array('add', 'delete', 'me', 'self', 'you', 'this', 'someone', 'random', 'anyone', 'noone', 'mafia', 'mafiawars', 'facebook', 'heartrate', 'bobbyheartrate');
	return (strlen($alias) <= 40 && 
		    !in_array($alias, $reserved) && 
			preg_match('/^[a-z][a-z0-9_]+$/', $alias) != 0 &&
			preg_match('/^with_key_(.+)$/', $alias) == 0);
}

function sweet_get_user_id($user) {
	global $users;
	
	if (sweet_is_number($user)) {
		return $user;
	}
	$user = strtolower($user);
	if (sweet_is_valid_alias($user)) {
		$con = db_connect();
		$id = db_get_id_by_alias($user, $con);
		if (!is_null($id))
			return $id;
	}
	return null;
}

function sweet_format($s, $params) {
	foreach ($params as $key => $val) {
		if (is_string ($val))
			$s = str_replace($key, $val, $s);
	}
	return $s;
}

function sweet_autoredirect_form($url = null) {
	?>
	<div style="border:1px solid red; background: #fdd; padding: 1em">
	<p>This page is a service of <a href="/sweeturl/">Bobby Heartrate's Mafia Wars URL Sweetener</a>.</p>
	<p>If in the future, you would rather be directly redirected to the relevant page when you follow <tt>heartrate.se</tt> links, 
	and you totally understand that links such as, for example, <tt>http://heartrate.se/attack/bobby/</tt> will <em>directly</em> 
	attack a user in Mafia Wars, then click "I wholeheartedly accept!". 
	This will set a cookie on your computer<?php if (!is_null($url)) echo "and then redirect you to the above URL"; ?>.</p>
		<form action="/set/auto_redirect/yes" method="POST">
		<?php if(!is_null($url)): ?> <input type="hidden" name="redirect" value="<?php echo htmlentities($url); ?>" /><?php endif; ?>
		<input type="submit" value="I wholeheartedly accept!" />
		</form>
	</div>
	<?php 
}

function sweet_redirect_raw($url) {
	header('HTTP/1.1 302 Found');
	header('Location: '.$url);
}

function sweet_redirect($url, $description = "") {
	if (get_default($_COOKIE, 'auto_redirect', 'no') == 'yes') {
		sweet_redirect_raw($url);
	} else {
		bhmt_head(array('title' => 'URL Sweetener'));
		bhmt_body_start();
		echo "<p>To $description, follow this link:</p>";
		bhmt_url_link($url);
		?> <?php 
		sweet_autoredirect_form($url); 
		bhmt_body_end();
	}
}

function sweet_user_table($name) {
	global $actions;
	echo ('<table border="0">');
	foreach ($actions as $action_name => $a) {
		if (array_key_exists('help', $a)) {
			$sweet_url = "http://heartrate.se/$action_name/$name/";
			$help = ucfirst(sweet_format($a['help'], array('$NAME' => $name))).'.';
			echo "<tr><td><tt><a href=\"$sweet_url\">$sweet_url</a>&nbsp;&nbsp;&nbsp;</tt></td><td>$help</td></tr>\n";
		}
	}
	echo ('</table>');
}

function sweet_do_user($params) {
	global $actions;
	bhmt_head(array('title' => 'User info'));
	bhmt_body_start('');
	echo ('<h2>Stuff you can do</h2>');
	echo (sweet_format('<p>Here\'s some handy URLs to use on $NAME (Facebook ID $ID) &ndash; give them to your friends!</p>', $params));
	sweet_user_table($params['$NAME']);
	bhmt_body_end();
}

function sweet_do_hitlist($params) {
	$extra = $params['$EXTRA'];
	$name = $params['$NAME'];
	if(count($extra) == 2 && $extra[0] == 'for' && preg_match('/^\$(\d+)$/', $extra[1], $matches)) { 
		$params['$AMOUNT'] = $matches[1];
		$url = 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=hitlist&xw_action=create&target_id=$ID&addhit=Set%20Bounty&amount=$AMOUNT';
		$help = "add $name to the hitlist for \$$matches[1]";
	} else if (count($extra) > 0) {
		sweet_error_and_die("weird command");
	} else {
		$url = 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=hitlist&xw_action=set&target_id=$ID';
		$help = "see the hitlist page for $name";
	}
	unset($params['$EXTRA']);
	sweet_redirect(sweet_format($url, $params), $help);
}

function sweet_do_set($params) {
	$args = $params['$EXTRA'];
	if (count($args) == 2) {
		if ($args[0] == 'auto_redirect') {
			if ($args[1] == 'yes') {
				if($_SERVER['REQUEST_METHOD'] == 'POST') {
					if (setcookie('auto_redirect', 'yes', time()+(60*60*24*365*2), '/')) {
						if (array_key_exists('redirect', $_POST)) {
							sweet_redirect_raw($_POST['redirect']);
							return;
						} else {
							// This is more levels of nested ifs than any sane code should ever have. Fuck you, Bobby Heartrate.
							bhmt_head(array('title' => 'Set auto redirect'));
							bhmt_body_start();
							echo ("Cookie set.");
							bhmt_body_end();
							return;
						}
					} else {
						sweet_error_and_die("Could not set cookie");
					}
				} else {
					sweet_autoredirect_form();
					bhmt_body_end();
					return;
				}
			}
		}
	}
	sweet_error_and_die("Bad command.");
}

function sweet_do_action($action, $params) {
	global $actions;
	$a = $actions[$action];
	if(array_key_exists('url', $a)) {
		$url = sweet_format($a['url'], $params);
		$help = sweet_format($a['help'], $params);
		sweet_redirect($url, $help);
	} else if(array_key_exists('func', $a)) {
		call_user_func($a['func'], $params);
	} else {
		sweet_error_and_die('Invalid action: '.$action.'. I wonder what happened here.');
	}
}

function sweet_get_user($action, $errmsg = null) {
	bhmt_head(array('title' => 'Enter user'));
	bhmt_body_start('error');
	if(!is_null($errmsg)) 
		echo $errmsg;
	echo "<p>we wantz de user name, lebowski!</p>";
	bhmt_body_end();
}

function sweet_do() {
	global $actions;

	$cmd = sweet_parse($_GET['cmd']);
	if(count($cmd) < 1) {
		sweet_error_and_die('No action selected. How did you get here, anyway?');
	}
	$action = $cmd[0];
	if(!array_key_exists($action, $actions)) {
		sweet_error_and_die('Invalid action: '.$cmd[0].' This might be an internal server error. Tell Bobby, please.');
	}
	
	if(array_key_exists('no_user', $actions[$action])) {
		sweet_do_action($action, array('$EXTRA' => array_slice($cmd, 1)));
	} else {
		if(count($cmd) > 1) {
			$user = $cmd[1];
			$id = sweet_get_user_id($user);
			if(is_null($id)) {
				sweet_get_user($action, '<p>Invalid user: '.$user.'</p>');
				return;
			}

			sweet_do_action($action, array('$ID' => $id, '$NAME' => $user, '$EXTRA' => array_slice($cmd, 2)));
		} else { 
			sweet_get_user($action);
		}
	}
	
	/* echo '<p>Here\'s what I\'m gonna do:</p><p>'.$url.'</p>'; */

	}

function sweet_debug() {
?>
<table border="1">
<tr><td>cmd</td><td><?php echo $_GET['cmd']?></td></tr>
<tr><td>parsed</td><td><?php print_r(sweet_parse($_GET['cmd'])); ?></td></tr>
</table>
<?php
}

?>