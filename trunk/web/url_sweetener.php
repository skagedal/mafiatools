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

require('bhmt.php');

bhmt_head(array('title' => 'URL Sweetener'));
bhmt_body_start('sweeturl');
?>
<h2>Bobby Heartrate's Mafia Wars URL Sweetener</h2>
<p>You know those pain-in-the-ass, ridiculously long, impossible-to-read URLs that Mafia Wars uses? Wouldn't you rather post a neat, readable URL on your Facebook profile or in a message to your friends?</p>

 <p>You might have heard of, or even used, such URL shortening services such as <a href="http://tinyurl.com/">TinyURL</a>. Bobby Heartrate's Mafia Wars URL Sweetener is like that, but gives you readable URLs. <br /><strong>Don't just shorten &ndash; sweeten!</strong></p>
 
 <p>So, here's how it works: You get someone's Facebook ID number. This is the number you see in the URL of profile pages just after <tt>id=</tt>. For example, <a href="http://www.facebook.com/profile.php?id=1463977030">my profile</a> has the adress <tt>http://www.facebook.com/profile.php?id=1463977030</tt>, so my id is <tt>1463977030</tt>. Now, the URL to hitlist me using Bobby Heartrate's Mafia Wars URL Sweetener is:</p>
 
<blockquote><tt><a href="http://heartrate.se/hitlist/1463977030">heartrate.se/hitlist/1463977030</a></tt></blockquote>

<p>Click that link to hitlist me!</p>
<p>Here's the full list of actions. Replace <em><tt>id</tt></em> with the Facebook id of your choice.</p>

<table border="0">
<?php 
$help = array(
	'add' 		=> 'Add someone to your mafia. You have to be Facebook friends.',
	'profile' 	=> 'Go to someone\'s Mafia Wars profile page.',
	'promote' 	=> 'Promote someone to your top mafia.',
	'hitlist' 	=> 'Hitlist someone.',
	'attack' 	=> 'Attack someone.',
	'punch' 	=> 'Punch someone in the face.',
	'rob' 		=> 'Rob someone.',
	'gift'		=> 'Give a gift to someone (opens up a menu for choosing gift)');
foreach ($help as $cmd => $explanation) {
	echo "<tr><td style=\"padding: 1em\" valign=\"top\"><tt>heartrate.se/$cmd/<em>id</em></tt></td><td style=\"padding: 1em\" valign=\"top\">$explanation</td></tr>\n";
}
?>
<tr><td style="padding: 1em" valign="top"><tt>heartrate.se/give/<em>id</em>/topaz_ring</tt></td><td style="padding: 1em" valign="top">Give a topaz ring to someone</td></tr>
<tr><td style="padding: 1em" valign="top"><tt>heartrate.se/give/<em>id</em>/20/humvees</tt></td><td style="padding: 1em" valign="top">Give twenty humvees to someone<p>These are just examples of gifts! Try any gift name and any amount!</p></td></tr>

</table>
 
<p>But there's more! Those ID numbers are pretty ugly and hard to remember, aren't they? Now, there's aliases: instead of <tt>1463977030</tt>, you can just write <tt>bobby</tt>. As in:

<blockquote><tt><a href="http://heartrate.se/hitlist/bobby">heartrate.se/hitlist/bobby</a></tt></blockquote>

<p>Cool, eh? So go ahead:</p>

<div style="border: 1px solid black; padding: 10px; text-align: center">
<strong><a href="http://apps.facebook.com/heartrate/">Set your own alias here!</a></strong>
</div>
<p>&nbsp;</p><p>&nbsp;</p> 
<?php bhmt_body_end(); ?>
