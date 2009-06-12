/*  Copyright 2009 Simon Kågedal
 *
 *  This file is part of Bobby Heartrate's Mafia Tools.
 *
 *  Bobby Heartrate's Mafia Tools is free software: you can
 *  redistribute it and/or modify it under the terms of the GNU General
 *  Public License as published by the Free Software Foundation, either
 *  version 3 of the License, or (at your option) any later version.
 *
 *  Bobby Heartrate's Mafia Tools is distributed in the hope that it
 *  will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *  See the GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Bobby Heartrate's Mafia Tools.  If not, see
 *  <http://www.gnu.org/licenses/>.
 */

void (function () {

{{INCLUDE xmlhttp.js}}

var mike_url = 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=property&xw_action=buy&buy_props=Buy&amount=1&property=13';
var lots_url = 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=property&xw_action=buy&buy_props=Buy&amount=10&property=1';
var mikes_bought = 0;
var money_spent = 0;

var content = document.getElementById('app10979261223_content_row');
var heartrate_div = document.createElement("div");

heartrate_div.innerHTML = '<table class="messages"><tr><td width="20%">Mikes bought:</td><td id="mikes_bought"></td></tr><tr><td>Money spent:</td><td id="money_spent"></td></tr><tr><td>Status:</td><td id="mike_status"></td></tr><tr><td colspan="2" style="text-align: right"><a href="http://heartrate.se/" style="margin-left: auto"><img src="http://heartrate.se/images/banner_small.png" width="208px" height="25px" /></a></td></tr></table>';

content.insertBefore(heartrate_div, content.firstChild);
//var textArea = document.createElement('textarea');


function msg(s) {
	document.getElementById('mikes_bought').innerHTML = mikes_bought;
	document.getElementById('money_spent').innerHTML = '$' + money_spent;
	document.getElementById('mike_status').innerHTML = s;
}


function p_int(s) {
	return parseInt(s.replace(/,/g, ''));
}

function state_change() {
	if (xmlHTTP.readyState == 4) {		// 4 = "loaded"
		if (xmlHTTP.status == 200) {	// 200 = OK
			s = xmlHTTP.responseText;
			if (m = /You just bought 1 Mafia Mike's for \$([\d,]+)/.exec(s)) {
				mikes_bought++;
				money_spent += p_int(m[1]);
				msg('Bought Mafia Mike for $' + m[1] + '; trying one more...');
				request(mike_url);
			} else if (m = /You just bought 10 Abandoned Lots for \$([\d,]+)/.exec(s)) {
				money_spent += p_int(m[1]);
				msg('Bought 10 Abandonded Lots for $' + m[1] + '; let us buy more Mikes...');
				request(mike_url);
			} else if (/You need an Abandoned Lot/.test(s)) {
				msg('Need Abandoned Lots, buying ten...');
				request(lots_url);
			} else if (/You have not recruited/.test(s)) {
				msg('Recruit more mafia, then rerun the bookmarklet.');
			} else if (/You need more cash/.test(s)) {
				msg('Get more cash, then rerun the bookmarklet.');
			} else {
				retry('Unknown response');
				return;
			}
		}
		else {
			retry("Problem retrieving data");
			return;
		}
	}
	retries = 0;
}


xmlHTTP = get_xmlHTTP();
if (!xmlHTTP) {
	alert("Your browser does not support XMLHTTP.");
	return;
}

request(mike_url);
msg('Buying Mafia Mike...');

} ());
