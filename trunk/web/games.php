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
require_once 'spyc.php';

bhmt_head();

bhmt_body_start('games');
?>
<p><strong>Welcome!</strong></p>

<p>Here are some bookmarklets for some games on Facebook. Originally, this was a site with tools for Mafia Wars only. Now here are some tools for some other games. But the site is still called "Bobby Heartrate's Mafia Tools". </p>

  These bookmarklets do Vampire Wars and Special Forces actions from a user's Facebook or Mafia Wars profile. Yes, I said Mafia Wars profile. Soon, hopefully, you'll be able to do the actions from all games. The descriptions below are intentionally brief; please refer to the <a href="/">Mafia Wars bookmarklets</a>, the same instructions apply, and read the <a href="/faq/">FAQ</a>.  And join the <a href="http://www.facebook.com/group.php?gid=141473635789">group</a>. 

<?php
bm_show_group('vampirewars');
bm_show_group('specialforces');
bm_show_group('various');

bhmt_body_end();

?>
