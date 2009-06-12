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

/* Get ID from a Mafia Wars (and similar games) profile */
function get_id_from_game() {
    // Mafia Wars
    try {
	var content = document.getElementById('app10979261223_content_row');
	var as = content.getElementsByTagName('a');
	for (i = 0; i < as.length; i++) {
	    if (as[i].innerHTML == 'Profile') {
		match = /[;&]user=(\d+)/.exec(as[i].href);
		if (match)
		    return match[1];
	    }
	}
    } catch (err) { }

    // Pirates
    try {
	var content = document.getElementById('app_content_16421175101').innerHTML;
	return /[?;&]opponent_id=(\d+)/.exec(content)[1];
    } catch (err) { }

    return null;
}
