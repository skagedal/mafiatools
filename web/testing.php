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

bhmt_head(array('title' => 'Testing Area'));
bhmt_body_start('testing');
echo('<h2>Bookmarklets under construction</h2>');

bm_table_start();

/*
bm_row('mafiamike', bm_load('bookmarklets/mafiamike.js'), 
		'Mike',
		'Install bookmark, go to <a href="http://apps.facebook.com/inthemafia/">Mafia Wars</a>, press bookmarklet. Mikes will be bought.');
*/

/*
bm_row('quick_heal', bm_load('bookmarklets/quick_heal.js'), 
       'QHeal',
      'Install bookmark, go to <a href="http://apps.facebook.com/inthemafia/">Mafia Wars</a>, press bookmarklet.');
	*/		     
bm_row('download_mafia', bm_load('bookmarklets/download_mafia.js'),
       'DL Mafia',
      'Install bookmark, go to <a href="http://apps.facebook.com/inthemafia/">Mafia Wars</a>, press bookmarklet.');
       
/*
	   bm_row('help_everyone', bm_load('bookmarklets/help_everyone.js'),
       'Help Everyone',
      'Install bookmark, go to <a href="http://apps.facebook.com/inthemafia/">Mafia Wars</a>, press bookmarklet.');

bm_row('vw_add_all', bm_load('bookmarklets/vw_add_all_unadded.js'),
       'VW Add All',
      'Install bookmark, go to <a href="http://apps.facebook.com/vampiresgame/recruit.php">Vampire Wars recruit page</a>, press bookmarklet.');
*/

	bm_row('test', bm_load('bookmarklets/testclass.js'), 'Test', '');

bm_table_end();

bhmt_body_end();

 ?>