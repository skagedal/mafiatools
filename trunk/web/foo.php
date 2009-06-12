<?php
require_once 'bhmt.php';

bhmt_head(array('title' => 'Mafia Mike'));
bhmt_body_start('mafiamike');
echo('<h2>Mafia Mike bookmarklet</h2>');

bm_table_start();
bm_row('mafiamike', bm_load('bookmarklets/mafiamike.js'), 
		'Mike',
		'Install bookmark, go to <a href="http://apps.facebook.com/inthemafia/">Mafia Wars</a>, press bookmarklet. ');
bm_table_end();

bhmt_body_end();

 ?>