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

bhmt_head(array('title' => 'News'));
bhmt_body_start('news');
?>
<h2 id="news">News</h2>
<?php
require_once 'rss_fetch.inc';

$url = 'http://www.facebook.com/feeds/notes.php?id=1463977030&viewer=1463977030&key=0192d3d93d&format=rss20';
$rss = fetch_rss($url);

foreach ($rss->items as $item ) {
	$title = $item['title'];
	$url   = $item['link'];
	$description = '<p>' . preg_replace('/^\s*$/m', "</p>\n<p>", $item['description']) .'</p>';
	echo "<h3><a href=$url>$title</a></h3>\n";
	echo "$description\n";
	echo "<div class=\"date\"><a href=\"$url\" style=\"color: grey\">Comments</a> &middot; $item[pubdate]</div>\n";
	//	print_r($item);
}


?>

<!--
<p><strong>NOTE!</strong> I'm not really updating this page. Instead, to stay updated, <a href="http://www.facebook.com/group.php?gid=141473635789">join the group</a> and <a href="http://www.facebook.com/notes.php?id=1463977030">read my notes</a>!</p>

<ul>
<li><span class="date">2009-04-14:</span> Introducing the <a href="/sweeturl/">URL Sweetener</a>!</li>
<li><span class="date">2009-04-13:</span> New "Gift" bookmarklet and gifting section of this page.</li>
<li><span class="date">2009-04-12:</span> Redesigned the page. </li>
<li><span class="date">2009-04-09:</span> New bookmarklet: "HL". This one is for those who do a lot of hitlisting and get tired of typing in the same amount. Oh, and by the way: Moved this page to a new domain, heartrate.se. The old adress will still work, but please update your links and bookmarks!</li>
<li><span class="date">2009-03-26:</span> New bookmarklet: "Jobcalc". Don't know if this is of any use to anyone except me.</li>
<li><span class="date">2009-03-26:</span> New and improved version of the Gift bookmarklet! Please try it out and tell me how it works for you. Also, renamed "FB/MW" to "Switch Profile".</li>
<li><span class="date">2009-03-26:</span> Fixed a bug in Google Chrome, that the little info messages wouldn't appear.</li>
<li><span class="date">2009-03-26:</span> Hmm, just realized I managed to screw up <em>all</em> bookmarklets except the Gift one yesterday...! :( So if you came here yesterday and thinks weren't working, try re-installing. You'll have better luck.</li>
<li><span class="date">2009-03-25:</span> New bookmarklet: "Gift", based on the good work of <a href="http://www.facebook.com/profile.php?id=1425814400">Giancarlo</a> &ndash; see <a href="http://www.mafia-wars.org/viewtopic.php?f=4&t=1210">this thread</a>. (<strong>updated</strong>@14.00GMT)</li>
<li><span class="date">2009-03-24:</span> Made "FB/MW" work also from "addfriend.php" pages, as per suggestion from <a href="http://www.facebook.com/s.php?k=100000080&id=1236913151">Reg Sledge</a>. Thanks!</li>
<li><span class="date">2009-03-22:</span> <a href="http://www.facebook.com/profile.php?id=500070344">Uncle Charles</a> suggested that the "Promote" button should work from a user's Mafia Wars profile. Good idea! I implemented that, and for the hell of it, made all bookmarklets work from either FB profile page or MW profile page (although it's of limited use since "Attack", "Hitlist" etc. are already available from the MW profile, but why not?). Thank you Charles, who also reported a problem with the FB/MW bookmarklet, which was screwed up yesterday (saturday March 21), so if you installed it and it doesn't work then you need to re-install it! Also added "Message", so you can send a FB message to someone from their MW profile. Much fun.</li>
<li><span class="date">2009-03-21:</span> Redesigned the page a little bit and created a <a href="http://www.facebook.com/group.php?gid=141473635789">group</a> &ndash; please join!</li>
<li><span class="date">2009-03-18:</span> Added "FB/MW", the first bookmarklet that's able to sniff the user id from a Mafia Wars page. This bookmarklet replaces "View Mafia", but since this code is a bit tricky, I'm keeping the old one around if anyone's having problems.</li>
<li>2009-03-17: Added "Attack", "Punch" and "Rob" and made the bookmarklets work also on non-friends, i.e. on "search" pages. Thanks to user <a href="http://www.facebook.com/profile.php?id=1425814400&ref=profile">Giancarlo</a> at <a href="http://www.mafia-wars.org/viewtopic.php?f=4&t=824">the Mafia Wars forum</a> for the idea!</li>
<li><span class="date">2009-03-16:</span> Added "Hitlist" and "Promote" bookmarklets.</li>
<li><span class="date">2009-03-13:</span> "Add to Mafia" button made more error-safe; you should upgrade. Added "View Mafia" button.</li>
<li><span class="date">2009-03-12:</span> First edition</li>
</ul>
-->

<?php bhmt_body_end(); ?>
