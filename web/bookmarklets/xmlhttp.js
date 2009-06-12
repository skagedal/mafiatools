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

var xmlHTTP; 
var last_url = null;
var retries = 0;

function get_xmlHTTP () {
	// Method 1: Works in all new browsers
	if (window.XMLHttpRequest)
		return new XMLHttpRequest();
	// Method 2: Works in IE 5 & 6
	if (window.ActiveXObject)
		return new ActiveXObject("Microsoft.XMLHTTP");
	return null;
}

function request(url) {
	xmlHTTP.onreadystatechange = state_change;
	xmlHTTP.open("GET", url, true);
	xmlHTTP.send(null);
	last_url = url;
}

function retry(s) {
	if (retries > 9) {
		msg(s + '; not retrying any more.');
	} else {
		retries++;
		msg(s + '; retry #' + retries + '...');
		request(last_url);
	}
}

