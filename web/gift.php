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

error_reporting(E_ALL);

require_once 'bhmt.php';
require_once 'sweet.php';
require_once 'user.php';

$filename_gifts = 'data/gifts.txt';
$filename_loot = 'data/loot.txt';

$items[0] = gift_read_file($filename_gifts);
$items[1] = gift_read_file($filename_loot);

function get_gift($cat, $id) {
	global $items;
	return $items[(int)$cat][(int)$id];
}

$canon_items = gift_make_canon_items($items);


function gift_start() {
	bhmt_head(array('title' => 'Gifts'));
	bhmt_body_start('gifting');
	echo('<h2>Gift</h2>');
}

function gift_end() {
	echo('<p>&nbsp;</p>');
	bhmt_body_end();
}

function gift_show_bookmarklet() {
	$gifter_js = bm_load('bookmarklets/gift.js');
	bm_table_start();
	bm_row('gift', $gifter_js, 
            'Gift',
            'Install by bookmarking this link &ndash; drag it to your toolbar!');
	bm_table_end();
}

function gift_main() {

	if (!array_key_exists('cmd', $_GET)) {
		gift_start();
		enter_ID();
		gift_end();
		return;
	}

	$command_line = $_GET['cmd'];
	// We reverse it so we can use array_pop
	$cmd = array_reverse(sweet_parse($command_line));
//	print_r($cmd);

	$found_key = null;
	foreach ($cmd as $arg_key => $arg) {
		if (preg_match('/^with_key_(.+)$/', $arg, $matches)) {
			$found_key = $matches[1];
			break;
		}
	}
	if ($found_key) 
		unset($cmd[$arg_key]);
	
	$with_key = $found_key ? "with_key_$found_key/" : "";
		
	if (count($cmd) == 0 && $found_key) {
		$command_line = get_default($_COOKIE, 'gift_cmd', '');
		$cmd = array_reverse(sweet_parse($command_line));
	}

	if (count($cmd) == 0) {
		gift_start();
		enter_ID();
		gift_end();
		return;
	} 

	if(!$found_key)
		$found_key = get_default($_COOKIE, 'gift_cookie', '');

	if($found_key)
		setcookie('gift_cookie', $found_key, time()+(60*60*24*365*2), '/'); // expires in two years
		
	$user_field = array_pop($cmd);
	$user = User::from_id_or_alias($user_field);
	if (is_null($user)) { 
		gift_start();
//		echo "<p>Command line: $command_line</p>";
		bhmt_error_msg(htmlspecialchars($user_field).' is neither a valid Facebook ID (only numbers) or an alias that exists.');
		enter_ID();
		gift_end();
		return;
	}

	// echo "We have a recipient with id " . $user->id() . " and alias " . $user->alias() . ".<br />";
	
	if (count($cmd) == 0) {
		gift_start();
		gift_menu($user);
		gift_end();
		return;
	} 
	
	$amount = 1;
	$amount_or_item = array_pop($cmd);
	if (sweet_is_number($amount_or_item)) {
		$amount = (int)$amount_or_item;
		if($amount < 1 or $amount > 500) {
			gift_start();
			bhmt_error_msg('Illegal armount: '.$amount);
			gift_end();
			return;
		}
		if (count($cmd) == 0) {
			gift_start();
			gift_menu($user, $amount);
			gift_end();
			return;
		}
		$amount_or_item = array_pop($cmd);
	}
	$item_name = $amount_or_item;
	
	if (count($cmd) != 0) {
		gift_start();
		bhmt_error_msg('I don\'t understand: '.implode('/', $cmd));
		gift_end();
		return;
	}
	
	$item = gift_find_item($item_name);
	if (is_null($item)) {
		gift_start();
		bhmt_error_msg('Unknown item: '.$item_name);
		gift_item_list();
		gift_end();
		return;
	}
	$gift = get_gift($item['cat'], $item['id']);
	

	
	if (!$found_key) {
		if(!setcookie('gift_cmd', $command_line, 0, '/')) { // expires in one hour
			echo "<p>Could not set cookie</p>";
		}
		
		gift_start();
//		echo "<p>Setting cookie to: $command_line</p>";
		echo "You want to give ".gift_format_item($gift, $amount)." to ".$user->format_link().". 
			  Now all we need is a <em>secret key</em> to allow for gifting. You'll get this by:
			  <ol>
			  <li>Installing the bookmarklet below. (If you don't already have it &ndash; it's the same \"Gift\" bookmarklet that's on the main page, but make sure you have the latest version!)</li>
			  <li>Going to <a href=\"http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=gift&xw_action=view\">your gifting page</a> and pressing the bookmarklet. <p>If your gifting page doesn't load (because you have a huge mafia), instead go to the Mafia Wars profile of someone who's in your mafia and has items on their wish list (maybe <a href=\"/profile/giancarlo/\">giancarlo</a> or <a href=\"/profile/bobby/\">bobby</a>?), and press the bookmarklet. Either action should set a cookie with your gift key in it so that further gifting via heartrate.se will be pain-free.</p></li>
			  </ol>";

		gift_show_bookmarklet();
		gift_end();
		return;
	}
	
	$recipient = $user->id();
	$recipients = '';
	for ($i = 0; $i < $amount; $i++) { 
		$recipients .= "recipients%5b$i%5d=$recipient&";
	}
	$url = "http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=gift&$recipients" . "gift_category=$item[cat]&gift_id=$item[id]&gift_key=$found_key&xw_action=send";

	if(!setcookie('gift_cmd', $command_line, 0, '/')) { // expires in one hour
		echo "<p>Could not set cookie</p>";
	}
	gift_start();
//	echo "<p>Key: $found_key</p>";
	echo('<p>All set! Now give '.gift_format_item($gift, $amount).' to '.$user->format_link().' with the link below.</p>');
	echo("<p class=\"smalltext\"><strong>Two things to note:</strong><ol><li class=\"smalltext\">Sometimes you get the page that says: \"Error while loading page from Mafia Wars. There are still a few kinks Facebook and the makers of Mafia Wars, yada yada...\" &ndash; but the gift is still sent. </li><li>Sometimes gifts just disappear. This seems to be because of bugs in Mafia Wars. You've been warned.</li><li class=\"smalltext\">If you get \"A mysterious error has occured\", you probably need to update your secret key. <a href=\"/faq/#gift_secret_key\">Here are instructions.</a> If several users are using the same computer, you need to do this when you switch users.</li></ol>");
	echo '<div style="background-color: #ffd; border: 1px solid black;">';

	bhmt_url_link($url);

	echo '</div>';
	$amstr = $amount > 1 ? "$amount/" : "";
	echo "<p><a href=\"http://$_SERVER[SERVER_NAME]/give/".$user->alias_or_id()."/$amstr\">Give something else.</a></p>";
	gift_end();
	
	/* sweet_redirect($url); */
	/*
	gift_start();
	echo('We will give '.$amount.' number of '.$item_name.' to '.$recipient.'.<br/>');
	echo("That's category $item[cat], id $item[id]");
	echo("<p>URL: $url</p>");
	gift_end();
	*/
}

function gift_find_item($name) {
	global $canon_items;
	$canon = gift_canonicalize_name($name);
	if(array_key_exists($canon, $canon_items)) {
		return $canon_items[$canon];
	}
	return null;
}

$amounts = array(1=>'one', 2=>'two', 3=>'three', 4=>'four', 5=>'five', 6=>'six', 7=>'seven', 8=>'eight', 9=>'nine');
function gift_format_item($item, $amount) {
	global $amounts;
	$params = array('$I' => $item['name']);
	if (array_key_exists($amount, $amounts))
		$params['$X'] = $amounts[$amount];
	else
		$params['$X'] = (string)$amount;
		
	return sweet_format($item[($amount == 1) ? 'singular' : 'plural'], $params);
}

function gift_item_list()
{
	global $canon_items;
	echo('<p>These are valid item names &ndash; you may insert underscores, capitalize letters and add plural s if you find that makes it more readable.</p><ul>');
	foreach ($canon_items as $name => $item) {
		echo "<li>$name</li>\n";
	}
	echo("</ul>\n");
}

function gift_read_file_keep($s) {
	// Only keep lines that aren't empty or comments
	return (trim($s) != "" && $s[0] != "#");
}
function gift_read_file($filename) {

	$contents = file_get_contents($filename);
	$lines = array_filter(explode("\n", $contents), "gift_read_file_keep");
	$items = array();
	foreach ($lines as $line) {
		$sp = explode('=', $line);
		$gift_id = trim($sp[0]);
		$fields = explode('|', $sp[1]);
		$gift = array();
		$gift['name'] = trim($fields[0]);
		$gift['singular'] = trim($fields[1]);
		$gift['plural'] = trim($fields[2]);
		$items[$gift_id] = $gift;
	}
	return $items;
}

function gift_canonicalize_name($str) {
	// The canonicalized version of an item name is:
	//  - lower cased
	//  - all but latin alphanumeric characters removed
	//  - any trailing s:es removed (to allow for plural forms in URLs)
	return rtrim(preg_replace('/[^a-z0-9]+/', '', strtolower($str)), 's');
}

function gift_url_name($gift) {
	// The preferred version of the gift name to show in URLs
	return preg_replace('/[^a-z0-9_]+/', '', preg_replace('/\s/', '_', strtolower($gift['name'])));
}

function gift_make_canon_items($items) {
	$arr = array();
	foreach ($items as $gift_cat => $cat_items) {
		foreach ($cat_items as $gift_id => $gift) {
			$arr[gift_canonicalize_name($gift['name'])] = array('cat' => $gift_cat, 'id' => $gift_id);
		}
	}
	return $arr;
}

function gift_table($items, $amount, $user, $gift_cat) {
	$amount = $amount > 1 ? "$amount/" : "";
	echo('<table class="gift_table" border="1">');
	foreach (array_chunk($items, 7, TRUE) as $gift_row) {
		echo "<tr>\n";
		foreach($gift_row as $gift_id => $gift) {
			?>
			<td><a href="<?php echo "http://$_SERVER[SERVER_NAME]/give/".$user->alias_or_id()."/$amount".gift_url_name($gift)."/"; ?>"><?php echo $gift['name']; ?></a></td>
			<?php
		}
		echo "</tr>\n";
	}
	echo "</table>";
}


function enter_ID() {
	?>
	Enter the Facebook ID of the person you would like to give a gift to and press OK.
	<p>
	<input style="margin: 5px 20px" id="recipient_id" type="text" size="10" />
	<button onclick="location.href='http://<?php echo $_SERVER['SERVER_NAME']; ?>/gift/'+getElementById('recipient_id').value;">OK</button>
	</p>
	<p>Instead of typing in the ID manually, you can use the "Gift" bookmarklet from the gift recipient's Facebook or Mafia Wars profile page:</p>
	<?php
	gift_show_bookmarklet();
}

function gift_menu($user, $amount = '1') {
	global $items;
	
	?>
	<p>Give a gift to <?php echo $user->format_link(); ?> by clicking on the gift name.</p>
	
	<p>
	Amount: 
	<select onchange="location ='http://<?php echo $_SERVER['SERVER_NAME']; ?>/give/<?php echo $user->alias_or_id(); ?>/'+this.options[this.selectedIndex].value;">
	<?php 
	for ($i=1; $i<201; $i++) { 
		$selected = ($i == $amount) ? ' selected="1" ' : '';
		$value = ($i > 1) ? "$i/" : "";
		echo "<option value=\"$value\" $selected>$i</option>";
	} 
	?>
	</select>
	</p> 
	<?php
	echo("<h3>Collection items</h3>\n");
	gift_table($items[0], $amount, $user, '0');
	echo("<h3>Loot</h3>\n");
	gift_table($items[1], $amount, $user, '1');
}

gift_main();
