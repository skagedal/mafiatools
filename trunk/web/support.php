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

bhmt_head(array('title' => 'Support'));
bhmt_body_start('support');
?>
<h2>Reporting problems</h2>

If you have any problems with the tools on this page, or would like to report a bug, please follow these instrunctions as good as you can!

<h3>Update!</h3>
If your problem is with a bookmarklet, it might already have been fixed &ndash; make sure you are using the most recent version by re-installing your bookmarklet. Just remove the old bookmark and install it again like you did the first time.

<h3>Check the FAQ!</h3>

If you're lucky, your question might already be answered in the <a href="/faq/">Frequently Asked Questions</a> or at the <a href="http://www.facebook.com/board.php?uid=141473635789">discussion board</a>!

<h3>Ask!</h3>
If not, write your question as <a href="http://www.facebook.com/edittopic.php?uid=141473635789&action=8">a new topic</a> at the discussion board (you have to be member of <a href="http://www.facebook.com/group.php?gid=141473635789">the group</a>). Try to describe your problem as detailed as possible, this will help me help you much quicker. It might help if you include the following information:
<ul>
<li>What were you trying to do?</li>
<li>Where were you when you were trying to do it – what did the adress bar say and, if in Mafia Wars, what screen were you at? (e.g., someone's profile page; just after fighting someone; your properties page, etc...)</li>
<li>What did you expect to happen?</li>
<li>What happened instead?</li>
<li>What browser are you using? It helps if you include the following text:
<blockquote>My user agent is <?php echo $_SERVER['HTTP_USER_AGENT']; ?>.</blockquote>
</li>
<li>If any error messages appear, copy them and include in your report.</li>
</ul>

<h3>Combat Calculator</h3>
If your question is about the Combat Calculator, report it to The Wanderer in <a href="http://mafia-wars.org/viewtopic.php?f=10&t=216">this thread</a>. Note the distinction between: 
<ul><li>the Combat Calculator, which is the excellent tool from The Wanderer that analyzes your fights. If, for example, a weapon is missing from the analysis, it is a problem with the Combat Calculator. If your problem is on the page <a href="http://mafia-wars.info/">mafia-wars.info</a>, report it to The Wanderer.</li>
<li>the "Analyze" bookmarklet, which is a little piece of glue that makes the Combat Calculator a little bit easier to use. If something weird happens when you press the bookmarklet, or there is something wrong going on on a page under <a href="http://heartrate.se">heartrate.se</a> or <a href="http://helgo.net/cgi-bin/simon/mafia/fight.py">helgo.net</a>, report it to me.</li>
</li>
</ul>


<?php bhmt_body_end(); ?>
