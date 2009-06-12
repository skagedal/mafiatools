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

require('bhmt.php');

bhmt_head(array('title' => 'FAQ'));
bhmt_body_start('faq');
?>
<h2 id="faq">FAQ</h2>
<dl>
<dt>What is this?</dt> 
<dd>It's a collection of useful bookmarklets and sweet URLs for Mafia Wars.</dd>
<dt>What is Mafia Wars?</dt>
<dd>An addictive game for <a href="http://facebook.com/">Facebook</a>. There are also versions for MySpace and some other social networks, but these tools are for the Facebook version. <a href="http://apps.facebook.com/inthemafia/">Go here to play!</a></dd>
<dt>Who made Mafia Wars?</dt>
<dd>A company called <a href="http://www.zynga.com/">Zynga</a>. They're also the creators of several other cool games with a similar gameplay, such as Vampires, Pirates and Special Forces.</dd>
<dt>What's a "bookmarklet"?</dt>
<dd>A bookmarklet is a piece of Javascript code put in a link that extends or modifies the functionality of the web site you're currently visiting. Read more about it in <a href="http://en.wikipedia.org/wiki/Bookmarklet">the Wikipedia article</a>.</dd>
<dt>Who made these tools?</dt>
<dd><a href="http://www.facebook.com/profile.php?id=1463977030">Bobby Heartrate</a>. I prefer to have all feedback on the tools to be directed to the <a href="http://www.facebook.com/board.php?uid=141473635789">discussion board</a> of the <a href="http://www.facebook.com/group.php?gid=141473635789">group</a> &ndash; please <a href="/support/">read the support page</a> on how to report problems! I'll be happy to confirm friend requests from users of these tools; please mention heartrate.se in the add message! I'll leave the hooking up of mafias to you. </dd>
<dt>Who else should be given credit?</dt>
<dd><ul>
<li>A lot of credit for figuring out how the gifting stuff in Mafia Wars works, and also some other stuff, should be given to <a href="http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=stats&xw_action=view&user=1485356529">Giancarlo</a> &ndash; please go to his profile and give him stuff!</li>
<li>David Panofsky contributed did the "Add to FB" bookmarklet.</li>
</ul></dd>
<dt id="bookmarklets_how">So, how do you use these bookmarklet thingies?</dt>
<dd>If you're on <strong>Firefox</strong>, these instructions may help you:
<ol><li>Make sure that 'Bookmarks Toolbar' is enabled.. Click View > Toolbars > Check 'Bookmarks Toolbar'. You should have a toolbar for bookmarks just below the adress bar.</li>
<li>Drag the links from <a href="/">the bookmarklet page</a> to your toolbar... For example, click "Switch Profile" and HOLD mouse button, drag it to the toolbar, then release. You should have a "Switch Profile" link in your toolbar.</li>
<li>Now, use like this: Go to a profile page (e.g., <a href="http://www.facebook.com/profile.php?id=1463977030">mine</a>). Then press "Switch Profile". Presto.</li></ol>
<p id="ie">If you're using <strong>Internet Explorer</strong>, instead of dragging and dropping, do this:
<ol>
  <li>Right-click on the bookmarklet</li>
  <li>Pick "Add to Favorites..."</li>
  <li>You'll be asked "You are adding a favorite that may not be safe. Do you want to continue?". Answer "Yes" if you trust Bobby Heartrate. <!-- (If in doubt, take a look at <a href="http://www.facebook.com/photo.php?pid=30152923&op=1&o=all&view=all&subj=141473635789&aid=-1&oid=141473635789&id=1223788605">this picture</a>, and ask yourself: Would that guy lie to you? Would a good-lookin' giraffe like that fool you into installing malware on your computer?) --></li>
  <li>In the next dialog, under "Create in" pick "Links" &ndash; that's your toolbar. Click "Add". </li> 
  <li>That's it.</li>
</ol></dd>
<dt>Tricky. Is there any screenshot tutorial to walk me through this?</dt>
  <dd>There are a some really nice tutorials on <a href="http://www.facebook.com/pages/Top-Mafia-Adds-Invites-Tips-Tricks-etc/99274538125">this fan page</a> on how to, respectively, <a href="http://www.facebook.com/note.php?note_id=76907102198">add to mafia</a>, <a href="http://www.facebook.com/note.php?note_id=76976642198">send messages</a>, <a href="http://www.facebook.com/note.php?note_id=76106957198">mass purchase Mafia Mike's</a> and <a href="http://www.facebook.com/note.php?note_id=77320347198">maximizing your energy using Jobcalc</a>.</dd>
<dt>But really, it's not working for me!</dt>
<dd>Ok, maybe you've found a bug! Maybe I can fix it if you report it, but just saying "it's not working" will not help either of us. You need to be as specific as you can. Please read the page <a href="/support/">support</a> page for how to report problems.
<dt id="switch_profile_privacy">On some players, the "Switch Profile" bookmarklet just takes me to my Facebook home page! Why?</dt>
<dd>This happens when the user have their privacy settings set to not allow for public listing. You can adjust this through <a href="http://www.facebook.com/privacy/?view=search">Settings -> Privacy -> Search</a>. There's nothing I can do about this, nor would I want to &ndash; people's privacy settings should of course be respected.</dd>
<dt id="gift_problems">Gifting doesn't work! What's up?</dt>
<dd><ol><li>Sometimes you get the page that says: "Error while loading page from Mafia Wars. There are still a few kinks Facebook and the makers of Mafia Wars, yada yada..." &ndash; but the gift is still sent. I'm guessing happens when servers are overloaded; nothing I can do about it, sorry.</li><li>If you get "A mysterious error has occured", you probably need to update your secret key; see instructions below. If several users are using the same computer, you need to do this when you switch users.</li></ol>
</dd>
<dt id="gift_secret_key">What is my "secret key" and how do I update it?</dt>
<dd>The short answer is that it's something you need to be able to use the gifting tool. It can be fetched from Mafia Wars by the "Gift" bookmarklet and then saved on your computer in a <a href="http://en.wikipedia.org/wiki/Cookie_(browser)">cookie</a> for further use. Each Mafia Wars user have their own unique secret key, so if two people are using the same computer, and both are using the gifting tool, you'll need to update your key when you swith users. <p>To set or update your secret key, install the "Gift" bookmarklet from <a href="/">the main page</a>, go to <a href="http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=gift&xw_action=view">your gifting page</a> and press the bookmarklet. If your gifting page doesn't load, you can instead go to a friend's Mafia Wars profile page that has wishlist items on it, and press the bookmarklet there.</p> </dd>
<dt>What browsers do these bookmarklets work on?</dt>
<dd>I've tested it on Firefox 3, Internet Explorer 7 and Google Chrome and it has worked on all.</dd>
<dt>Isn't this cheating?</dt>
<dd>In my view, these are just tools that make some common operations a little bit more convenient. I have received many positive reactions from users who say that these tools make a good game even better; I have so far received no negative reactions. To me, crossing the line to "cheating" is when you run a script that really plays the game <em>for</em> you.  </dd>
<dt>But does Zynga allow it?</dt>
<dd>This is what Mafia Wars' Terms of Service says: "If you cheat on any of our games, use any hacking scripting or editing programs in Mafia Wars, violate the Mafia Wars rules or break the law, we can freeze or terminate your account, or if appropriate, report you to the police."<p> I don't know if they'd count my tools as "hacking scripting or editing programs". In any case, I take ABSOLUTELY NO responsibility for what might happen if you use it.</p></dd>
<dt>Can I use your code and modify it?</dt>
<dd>Yes, as much as you like. </dd>
<dt>Can I redistribute your bookmarklets?</dt>
<dd>Yes, you can. Giving credit is a nice thing to do, though. It's also better to spread the link to <a href="http://heartrate.se/">heartrate.se</a> instead of copying and pasting the bookmarklets, since the bookmarklets might have to get upgraded to accommodate changes to Mafia Wars.</dd>
<dt>Hey, can you do a bookmarklet that does X?</dt>
<dd>Maybe! I'm interested in all ideas. Please write on <a href="http://www.facebook.com/board.php?uid=141473635789">the discussion board</a>. I'll implement new ones if I find it interesting and have the time.</dd>
</dl>
<h2>The Author</h2>
<dt>Is it true that you are, in fact, a giraffe?</dt>
<dd>Yes.</dd>
<dt>Are you affiliated with any clan?</dt>
<dd>Since I am a giraffe of faith, I'm a member of <a href="http://www.facebook.com/group.php?gid=46352595748">The Church of The Flying Spaghetti Monster</a>. Special shout-outs to <a href="http://www.facebook.com/group.php?gid=59211812115">Legion</a> for promoting this page.</dd>
<dt>I love you, Bobby Heartrate. Do you sing as well?</dt>
<dd>Why, of course: <a href="http://www.myspace.com/bobbyheartrate">See my MySpace space</a></dd>
</dl>
<h2>Mafia Wars Questions</h2>
If you have general questions about Mafia Wars, there are support forums with people who are much more able to answer these things than I am. Some examples:
<ul>
<li><a href="http://forums.zynga.com/forumdisplay.php?f=36">Zynga's official forum</a></li>
<li><a href="http://mafia-wars.org/">Mafia-Wars.org</a> &ndash; a great fan forum!</li>
<li>Your favorite clan</li>
<li>Support groups and pages on Facebook &ndash; for example:
<ul>
<li><a href="http://www.facebook.com/pages/Top-Mafia-Adds-Invites-Tips-Tricks-etc/99274538125">Top Mafia - Adds, Invites, Tips, Tricks, etc</a> &ndash; has screenshot tutorials</li>
<li><a href="http://www.facebook.com/pages/Mafia-Wars-New-Players-Tips-MWNPT/148432115314">Mafia Wars New Players Tips "MWNPT"</a> &ndash; lots of great advice</li> 
<li><a href="http://www.facebook.com/group.php?gid=83995106872">Mafia Wars Cara & Renays get 501+ Club</a> &ndash; has a nice "Tip of the day" thread</li>
</ul>
</li>
</ul>
<p>The wonderful <a href="http://docs.google.com/Doc?id=dcr4zcqs_5fgm2mdhh">Mafia Wars FAQ</a> might already have the answer to your question! Here are some common questions I've been getting:</p>
<dl>
<dt>Is it possible to remove members from your mafia?</dt>
<dd>No, as far as I know, it is not.</dd>
<dt>plz add me lvl 666 daily player omg lol: http://apps.facebook.com/inthemafia/status_invite.php?from=666</dt>
<dd>
</dl>
<?php bhmt_body_end(); ?>
