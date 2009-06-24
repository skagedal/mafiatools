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

/* Get ID from a Facebook profile */
function get_id_from_fb() {
    function f (expr) {
	try {
	    return /id=([0-9]+)/.exec(eval(expr))[1];
	} catch (e) {
	    return null;
	}
    }

    return f("document.getElementById('profileimage').parentNode.innerHTML") 
	|| f("document.getElementById('profile_name').parentNode.innerHTML") 
	|| null;
}
