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
	var content = document.getElementById('profileimage');
	match = /id=([0-9]+)/.exec(content.innerHTML);
	//	if (match && match.length > 1)
	    return match[1];

	// Fall back on the old 
	    /*
	var url = location.href;
	// If there are several matches, we want the last one because of the situations that look like this:
	// http://www.facebook.com/profile.php?id=xxxx&ref=mf#/profile.php?id=yyyy - yyyy is the one we want
	// This function returns the last match of the regular expression "re". 
	function last(re) {
	    var l = null;
	    while (m = re.exec(url))
		l = m;
	    return l;
	}
	var m = last(/(?:profile|addfriend).php[?&]id=(\d+)/g) || last(/s.php[?&]k=\d+&id=(\d+)/g);

	return m ? m[1] : null;
	    */
}
