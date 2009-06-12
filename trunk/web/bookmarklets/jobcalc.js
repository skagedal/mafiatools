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

f = function(s) {
	return parseInt(document.getElementById('app10979261223_' + s).firstChild.data);
};
exp = f('user_experience');
lev = f('exp_for_next_level');
en = f('user_energy');
max_en = f('user_max_energy');
left = lev - exp;
alert('Experience needed: ' + left + '\nCurrent energy: ' + en + '\nPreferred exp/energy for jobs: ' + (left/en).toFixed(2) + '\n\nIf you had max energy, the ratio would be: ' + (left/max_en).toFixed(2));
