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

bhmt_head();
bhmt_body_start('donate');
?>
<h2 id="donate">Donate</h2>
<p>I'm developing these tools on my spare time for fun, paying for domain and hosting myself. If you'd like to chip in, that would be greatly appreciated, and encourages me to keep developing. </p>
<p>If you donate, and would like to be thanked on this page (and randomly on the front page), please state in your donation message under what name you'd like to be credited, and what to link if anything.</p>

<table border="0" width="100%">
<tr>
<td width="50%" style="text-align: center"><strong>Donate Euro:</strong></td>
<td style="text-align: center"><strong>Donate US Dollars:</strong></td>
</tr>
<tr>
<!-- EURO -->
<td style="text-align: center">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="4302265">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG_global.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</td>
<!-- USD -->
<td style="text-align: center">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="4302318">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG_global.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</td>
</tr>
</table>

<h2>Donators</h2>
A big thank you to the following people for donating.
<?php bhmt_donator_list(); ?>
<?php bhmt_body_end(); ?>
