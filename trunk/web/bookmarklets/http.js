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

/* Wrapper for XMLHttpRequest that handles retries
 * TO DO: should also deal with timeouts and do throttling
 */

/* TO DO: rewrite using class constructor syntax */

function http_new (set_status) {
	function make_statechange_fun(self, on_ok) {
		return function() {
			if (self.xhr.readyState == 4) {		// 4 == "loaded"
				if (self.xhr.status == 200) {	// 200 == OK
					if (var msg = on_ok (self.xhr.responseText)) {
						self.retry(msg);
					}
				} else {
					self.retry('Problem retrieving data');
				}
			}
		};
	}

	return {
		set_status: set_status,

		xhr:	// Method 1: works in all new browsers
			window.XMLHttpReqest ? new XMLHttpRequest() :	
			// Method 2: works in IE 5 & 6
			window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : null,

		get: function (url, pagename, on_ok) {
			this.set_status('Getting ' + pagename);
			this.pagename = pagename;
			this.retries = 0;
			this.xhr.onreadystatechange = make_statechange_fun(this, on_ok);
			this.xhr.open("GET", url, true);
			this.xhr.send(null);
		}

		retry: function () {
			this.retries++;
			if (retries > 10) {
				this.set_status('Giving up getting ' + this.pagename);
			} else {
				this.set_status('Getting ' + this.pagename + '; retry #' + retries + '...');
				this.xhr.send(null);
			}
		}
	}
}
