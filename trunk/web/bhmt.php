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
 *
 *  You should have received a copy of the GNU Affero General Public
 *  License along with Bobby Heartrate's Mafia Tools.  If not, see
 *  <http://www.gnu.org/licenses/>.
 */

error_reporting(E_ALL);

require_once 'jsmin.php';
require_once 'spyc.php';
require_once 'localsettings.php';

/* These are various generic php helper functions */

function get_default($array, $key, $default) {
	if(array_key_exists($key, $array))
		return $array[$key];
	return $default;
}

function disable_magic_quotes() {
	if (get_magic_quotes_gpc()) {
		function stripslashes_deep($value)
		{
			$value = is_array($value) ?
						array_map('stripslashes_deep', $value) :
						stripslashes($value);

			return $value;
		}

		$_POST = array_map('stripslashes_deep', $_POST);
		$_GET = array_map('stripslashes_deep', $_GET);
		$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
		$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
	}
}

/* Actions */

class Actions
{
	// Static methods
	function get_actions() {
		static $actions; 
		if (!isset($actions)) {
			$actions = new Actions();
			$actions->load('data/actions.yaml');
		}
		return $actions;
	}
	
	private $_actions;
	
	// Instance methods
	function __construct() {
		$this->_actions = null;
	}

	function load($filename) 
	{
		$this->_actions = Spyc::YAMLLoad($filename);
	}

	function find_group($group_name) {
		foreach ($this->_actions as $group) {
			if ($group['group'] == $group_name)
				return $group;
		}
		return null;
	}
}

/* To write - for the URL sweetener */

function action_do_user()
{
}

function action_give()
{
}

function action_set()
{
}



/* Bookmarklets */

function escape_space($str) {
   return str_replace(' ', '%20', $str);
}

function bm_table_start() {
	echo '<table class="bookmark_table" border="0">'."\n";
}

function bm_table_end() {
	echo "</table>\n";
	}

function bm_row($id, $javascript, $label, $explanation, $extra_content = '') {
   /* Used to have title=\"Drag me to your toolbar!\" - this made IE think that was the title to bookmark */
   echo "
 <tr>
   <td width=\"30%\" valign=\"top\">
     <div class=\"acont\">
	   <a id=\"$id\" class=\"bookmarklet\" href=\"$javascript\">$label</a>
	 </div>
	 $extra_content
   </td>
   <td>$explanation</td>
 </tr>
 ";
}

function bm_row_old($javascript, $label, $explanation) {
   /* Used to have title=\"Drag me to your toolbar!\" - this made IE think that was the title to bookmark */
   return "<tr>\n  <td width=\"30%\" valign=\"top\"><div class=\"acont\"><a class=\"bookmarklet\" href=\"$javascript\">$label</a></div></td>\n  <td>$explanation</td>\n</tr>\n";
}

// Load javascript file and expand includes (but no other macros)
function bm_load_raw($filename, $basepath = ".") {
	// Special case: we want to be able to type an empty filename to get empty code
	if ($filename == '')
		return '';
		
	$filename = "$basepath/$filename";
	$contents = file_get_contents($filename);
	$new_basepath = dirname($filename);
	$callback = create_function('$matches', 'return bm_load_raw($matches[1], "'.$new_basepath.'");');
	return preg_replace_callback('/\{{INCLUDE\s+([^}]+)}}/', $callback, $contents);
}

function bm_expand_macros($code, $macros = null) {
	if (!$macros)
		$macros = bm_macros();
		
	foreach ($macros as $key => $val) 
		$code = str_replace('{{'.$key.'}}', $val, $code);
	return $code;
}

function bm_make_bookmarklet($code) {
	return 'javascript:'.rawurlencode(str_replace("\n", "", JSMin::minify($code)));
}

function bm_macros() {
	return array('HOSTNAME' => $_SERVER['SERVER_NAME']);
}

function bm_load($filename) {
	return bm_make_bookmarklet(bm_expand_macros(bm_load_raw($filename)));
}

// Get the bookmarklet help of an action. If there is no specific bookmarklet help, use sweeturl help.
function bm_help($action) {
  if (array_key_exists('bookmarklet', $action) && array_key_exists('help', $action['bookmarklet']))
    return $action['bookmarklet']['help'];
  return ucfirst(str_replace('$NAME', 'someone', $action['help'])).'.';
}

// Show bookmarklets from a action group 
function bm_show_group($group_name) {
	$actions = Actions::get_actions();
	$group = $actions->find_group($group_name);

	echo "<h2>$group[title]</h2>\n";
	echo "<p>$group[description]</p>\n";
	bm_table_start();
	
	$default_filename = get_default($group, 'default_bookmarklet_code', null);
	$default_raw_code = $default_filename ? bm_load_raw($default_filename) : '';
	$macros = bm_macros();
	$group_actions = get_default($group, 'actions', array());

	foreach ($group_actions as $action) {
		if(array_key_exists('bookmarklet', $action)) {
			$bookmarklet = $action['bookmarklet'];
			if(array_key_exists('code', $bookmarklet))
				$raw_code = bm_load_raw($bookmarklet['code']);
			else
				$raw_code = $default_raw_code;
			
			$macros['URL'] = get_default($action, 'url', "http://$_SERVER[SERVER_NAME]/$action[action]/".'$ID/');
			$js_url = bm_make_bookmarklet(bm_expand_macros($raw_code, $macros));

			$action_id = 'bm_' . $action['action'];
			$extra_content = get_default($bookmarklet, 'extra_content', '');
			$help = bm_help($action);
			bm_row($action_id, $js_url, $bookmarklet['title'], $help, $extra_content);
			}
	}

	bm_table_end();
}


/* BHMT */

function is_development() {
	// Returns true if it's the development version
	return ($_SERVER['SERVER_NAME'] == 'localhost');
}

function bhmt_head($extras = array()) {
	?> 
<html>
<head>
<title>Bobby Heartrate's Mafia Tools<?php if (array_key_exists('title', $extras)) echo ': '.$extras['title']; ?></title>
<link rel="stylesheet" type="text/css" href="/style/mafia_style.css" />
<?php if (array_key_exists('tags', $extras)) echo $extras['tags']; ?>
</head> <?php
	}

function make_menu($id) {
	$menu = array(array('index', 'Bookmarklets', '/'),
				  array('gifting', 'Gifting', '/gift/'),
				  array('sweeturl', 'URL Sweetener', '/sweeturl/'),
				  array('games', 'Other games', '/games/'),
				  array('news', 'News', '/news/'),
				  array('support', 'Support', '/support/'),
				  array('faq', 'FAQ', '/faq/'),
				  array('donate', 'Donate', '/donate/'),
				  array('links', 'Links', '/links/'));
	
	echo ("<ul class=\"menu\">\n");
	foreach ($menu as $item) {
		if ($id == $item[0]) {
			echo("<li class=\"selected\">$item[1]</li>\n");
		} else {
			echo("<li><a href=\"$item[2]\">$item[1]</a></li>\n");
		}
	}
	echo ("</ul>\n");
}

function bhmt_body_start($id = "none", $extras = array()) {
	?> <body<?php echo get_default($extras, 'body_tag', '');?>>
<div id="content">
<div id="header">
<img src="/images/banner.png" alt="Bobby Heartrate's Mafia Tools" width="800px" />
</div>
<div id="left_column">
<? make_menu($id); ?>
<div class="left_column_item" style="border: 1px solid black; font-size: 75%; width: 120px; padding: 3px;">
Thank you for <a href="/donate/">donating</a>, <?php echo bhmt_donator_random(); ?>!
</div>
<div class="left_column_item">
<script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_button { display: -moz-inline-block; display:inline-block; padding:1px 20px 0 5px; height:15px; border:1px solid #d8dfea; background:url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981) no-repeat top right; font-size: 75% } html .fb_share_button:hover { color:#fff; border-color:#295582; background:#3b5998 url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981) no-repeat top right; text-decoration:none; } </style> <a href="http://www.facebook.com/share.php?u=<url>" class="fb_share_button" onclick="return fbs_click()" target="_blank" style="text-decoration:none;">Share</a>
</div>
<?php if (!is_development()): ?>
<div class="left_column_item">
<!-- Facebook Badge START --><a href="http://www.facebook.com/people/Bobby-Heartrate/1463977030" title="Bobby Heartrate&#039;s Facebook profile" target="_TOP"><img src="http://badge.facebook.com/badge/1463977030.347.1346701637.png" alt="Bobby Heartrate&#039;s Facebook profile" style="border: 0px;" /></a><!-- Facebook Badge END -->
</div> <!-- left_column_item -->
<div class="left_column_item">

<script type="text/javascript"><!--
google_ad_client = "pub-2774984892854849";
/* 120x600 Grafit */
google_ad_slot = "0439919119";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div> <!-- left_column_item -->
<?php endif; // development ?>

</div> <!-- left_column -->

<div id="main"> <?php 
	}
	
function bhmt_body_end() {
	?>
<!-- <a href="http://validator.w3.org/check?uri=referer">Check valid XHTML</a> -->
</div> <!-- main -->
</div> <!-- content -->
</body></html>
	<?php
	}
	

function bhmt_error_msg($str) {
	echo ('<p class="error">'.$str.'</p>');
}

function bhmt_url_link($url) {
	$print_url = chunk_split($url, 60, '<br />');
	echo("<p style=\"margin-left: 2em;\"><tt><a href=\"$url\">$print_url</a></tt></p>");
}

/* Log */

function bhmt_get_log_filename() {
	 $settings = get_local_settings();
	 return $settings['logfile'];
}

function bhmt_log($str) {
	$f = fopen(bhmt_get_log_filename(), 'a');
	if ($f) {
		fputs($f, date("c: "));
		fputs($f, $str);
	}
	fclose($f);
}
/* Donators */

$donators = array(
	array('name' => 'Verbal Di aka (SBG) Verbaldi'),
	array('name' => '[FSM]ViciousKitty', 'url' => 'http://heartrate.se/fb/kitty/'),
	array('name' => 'Rachel AKA Keylime Khiori'),
	array('name' => 'Flea', 'url' => 'http://heartrate.se/user/flea/'),
	array('name' => 'Max Handelsman', 'url' => 'http://heartrate.se/user/max/'),
	array('name' => 'Lizabeth Stevens'),
	array('name' => 'Curro Cuadrado'),
	array('name' => 'Richard Jay Silverman', 'url' => 'http://www.facebook.com/profile.php?id=1250289552'),
	array('name' => '[SIN WC] Don Fumare', 'url' => 'http://www.facebook.com/profile.php?id=656799921'),
	array('name' => '[FSM] Francesca "IQ" Manarola'),
	array('name' => 'Faye Kalius', 'url' => 'http://www.facebook.com/profile.php?id=1331318782'),
	array('name' => '[AWR]mahyas', 'url' => 'http://www.facebook.com/profile.php?id=650066629'),
	array('name' => 'Don Dingleberry', 'url' => 'http://www.facebook.com/profile.php?id=1223788605'),
	array('name' => '[FSM] Lefty Loosie', 'url' => 'http://www.facebook.com/profile.php?id=556041394'),
	array('name' => 'Ghost Dog'),
	array('name' => '[MMA] Mr. Trees'),
	array('name' => '&infin; Ozzie &infin;', 'url' => 'http://www.facebook.com/profile.php?id=653912232'),
	array('name' => '[Merc] &#352;&#358;&#926;&#290;&#288;&#165; &#8482;'),
	array('name' => 'Dianne, Diamond Dee and Butterfly'),
	array('name' => 'Ava Tagliano', 'url' => 'http://mafia.codewidow.com/'),
	array('name' => '[DOG] Don Galleano and [MMA][WODB] Valentina Freccia'),
	array('name' => 'Jason Younker', 'url' => 'http://www.facebook.com/pages/Top-Mafia-Adds-Invites-Tips-Tricks-etc/99274538125'),
	array('name' => 'Sista'),
	array('name' => 'Glitzgal'),
	array('name' => 'Mafia-Wars.org', 'url' => 'http://Mafia-Wars.org/'),
	array('name' => 'Nina Romeyn aka [DMNR] Mz Demeanor', 'url' => 'http://www.facebook.com/profile.php?id=899110240'),
	array('name' => 'Edie Goodwin aka Don GoThere'),
	array('name' => 'louieb58'),
	array('name' => '[MFF] Matriarch Sovereign'),
	array('name' => '[LCN]MeanyMin'),
	array('name' => 'Les Willett', 'url' => 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=stats&xw_action=view&user=1210820502'),
	array('name' => '[WODB] Don Juan'),
);

function donator($don) {
	if (array_key_exists('url', $don))
		return "<a href=\"$don[url]\">$don[name]</a>";
	return $don['name'];
}

function bhmt_donator_list() {
	global $donators;
	echo "<ul>\n";
	foreach ($donators as $don) {
		$don = donator($don);
		echo "<li>$don</li>\n";
	}
	echo "</ul>\n";
}

function bhmt_donator_random() {
	global $donators;
	return donator($donators[mt_rand(0, count($donators) - 1)]);
}

?>
