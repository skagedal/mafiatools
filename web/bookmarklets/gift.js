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

{{INCLUDE get_id.js}}

id = get_id();
if(id) {
	// Try to find gift key from a profile page
	match = /gift_key=([0-9a-f]+)/.exec(document.body.innerHTML);
	location.href = 'http://{{HOSTNAME}}/give/' + id + '/' + (match ? 'with_key_' + match[1] : '');
} else {
	key = document.getElementById('app10979261223_gift_key').value;
	if (key) {
		location.href= 'http://{{HOSTNAME}}/give/with_key_' + key;
	} else {
		alert('ERROR: Could not find id or gift key. You should use this bookmarklet either from the Mafia Wars profile page of a friend with wishlist items, or from your own gifting page.');
	}
}
