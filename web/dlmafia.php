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

bhmt_head(array('title' => 'Download Mafia'));
bhmt_body_start('');
?>
<h2 id="faq">Download Mafia</h2>

<?php
bm_table_start();
bm_row('download_mafia', bm_load('bookmarklets/download_mafia.js'),
       'DL Mafia',
      'That\'s the bookmarklet. <strong>Please read instructions below before you use it.</strong>');
bm_table_end();
?>

<p>Have you ever wanted to search through your mafia, or sort it to find the best players to promote to your Top Mafia? Mafia Wars is supposed to have this functionality, but it hasn't been working for a long while. Now, here's a tool that lets you download your mafia and import it into a spreadsheet program like Microsoft Excel or <a href="http://www.openoffice.org/">OpenOffice.org</a>; the latter is <em>free</em> software and is the program I recommend, and is the one I will mostly cover in this tutorial. Download and install it now!</p>

<p>Please note: This isn't the most userfriendly tool at the moment. You will have to read these instructions <em>carefully</em> and probably be a little bit computer savvy and have experience with spreadsheet programs to make good use of this. For now, at least. It's a start.</p>

<p>Install the bookmarklet by dragging it to your toolbar, just like the others. This will only work in Firefox, Safari and Google Chrome (i.e., not in Internet Explorer). </p>

<p>Go to <a href="http://apps.facebook.com/inthemafia/">Mafia Wars</a> and then press the bookmarklet.</p>

<p>Your mafia should now start downloading. It should look a little bit like this:</p>

<p><img src="/images/dl_mafia_start.png" /></p>

<p>It'll take quite some time to download your mafia. Depending on how big it is, of course. If you for some reason need to pause it, press "Pause". At that point, you can copy and paste your partially downloaded mafia to your spreadsheet program to see if it works. See, this is what happens if we press "Pause":</p>

<p><img src="/images/dl_mafia_pause.png" /></p>

<p>You see two more buttons have appeared: "Select" and "Prepare for Excel". Try pressing "select". The big ugly text that represents your mafia is now selected. Copy this by pressing "Ctrl-C". Then fire up OpenOffice.org Calc. (That's such a terrible name for a program. It's nice though.) Go to the Edit menu and choose "Paste Special":</p>

<p><img src="/images/oo_paste_special_menu.png" /></p>

<p>In the next dialog, choose "Unformatted text":</p>

<p><img src="/images/oo_paste_special_unformatted.png" /></p>

<p>The next dialog should look like this &ndash; in particular note the "Text delimiter" field which needs to be set to empty, just mark the little quotation mark there in the text box and press backspace. </p>

<p><img src="/images/oo_text_import.png" /></p>

<p>Press OK! Did that work? If it worked, you can now play with your partially downloaded mafia!</p>

<p>Now go ahead and download the rest of your mafia: Go back to your browser and press "Continue". (You didn't close your Mafia Wars window, did you? Never do that while downloading your mafia, and don't navigate away from the downloading: bascially, don't push anything except the little buttons in the tool itself)</p>

<p>When it's done, just do like described above to import your mafia into OpenOffice.org.</p> 

<p>Now, for you Excel users, the process is similar, but with a twist: Before you press select and copy and paste your mafia, press "Prepare for Excel" and then OK. This will remove all quotation marks from your mafia, i.e., if someone is called <em>"Big" Pussy Bompensiero</em>, they will now be called just <em>Big Pussy Bompensiero</em>. This is needed because otherwise Excel will do strange things.</p>
 
<p>A limitation of this tool at the moment is that only the information on the "My Mafia" pages is downloaded. That means that you'll only see shortened versions of mafia names, i.e., in the example above you'll probably see just <em>Big Pussy...</em> in your spreadsheet. A later version might look at all individual mafia player profiles. </p>
 
<p><strong style="font-size: large">Please post all feedback regarding this tool to <a href="http://www.facebook.com/topic.php?uid=141473635789&topic=9953">this thread</a>. You'll need to be a member of the group Bobby Heartrate's Mafia Tools to be able to post. I will not answer questions by individual e-mail because I just don't have the time. Sorry.</strong></p>
 
<?php bhmt_body_end(); ?>
