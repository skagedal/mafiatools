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

$extras = array('tags' => file_get_contents('hitlist_amount_script.txt'));
bhmt_head($extras);

$extras = array('body_tag' => ' onload="hitlist_amount()" ');
bhmt_body_start('index', $extras);
?>
<p><strong>Welcome!</strong></p>

<p>This page contains some useful tools, called <em>bookmarklets</em>, that simplify common tasks in the Facebook game Mafia Wars. 
If you have no clue what I'm talking about, read the <a href="/faq/">FAQ</a>!</p>

<p>Install the bookmarklets you want by dragging them to your bookmarks toolbar. 
(If you're using Internet Explorer, dragging doesn't seem to work. Instead, right-click on the link and then choose "Add to favorites". 
You really should do yourself a favour and get <a href="http://www.mozilla.com/firefox/">Firefox</a> or 
<a href="http://www.google.com/chrome">Google Chrome</a>.)</p>

<?php
bm_show_group('mafiawars');
bm_show_group('mafiawars_misc');
bm_show_group('facebook');
bm_show_group('facebook_misc');

bhmt_body_end();
?>

