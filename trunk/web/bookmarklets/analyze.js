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

m = document.getElementById('app10979261223_content_row');
if (m) {
	tds = m.getElementsByTagName('td');
	message = '';
	stats = '';
	for (var i = 0; i < tds.length; i++) {
		td = tds[i];
		if (td.className == 'message_body')
			message += td.innerHTML.replace(/<.*?>/g, '') + '\n\n';
		if (td.className == 'profile_stat_name') {
			stats += /\w+/.exec(td.innerHTML.toLowerCase())[0] + '=';
		}
		if (td.className == 'profile_stat_number') {
			stats += td.innerHTML + '&';
		}
	}
	f = (/^Your Mafia( Wars)? of \d+ (fought|robbed)/i.test(message)) ? ('fight=' + encodeURIComponent(message) + '&') : '';
	
	location.href = 'http://helgo.net/cgi-bin/simon/mafia/fight.py?' + f + stats + '&level=' + document.getElementById('app10979261223_user_level').firstChild.data;
}
