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

var recruit_url = 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=recruit&xw_action=view';

// THIS DOESN'T WORK, of course, because of "same origin policy". Need to figure out an apps.facebook.com adress...
var add_url = 'http://mwdirectfb10.zynga.com/mwfb/remote/html_server.php?xw_controller=friendbar&xw_action=send_add&fid=';

var mw_url = 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=stats&xw_action=view&user=';
var fb_url = 'http://www.facebook.com/profile.php?id=';
var friends_added = 0;
var friends = null;
var first = true;
var wait = 1;

var content = document.getElementById('app10979261223_content_row');
var heartrate_div = document.createElement("div");
heartrate_div.innerHTML = '<table class="messages"><tr><td colspan="2" style="text-align: right"><a href="http://heartrate.se/" style="margin-left: auto"><img src="http://heartrate.se/images/banner_small.png" width="208px" height="25px" /></a></td></tr><tr><td width="20%">Friends added:</td><td id="friends_added"></td></tr><tr><td>To try:</td><td id="friends_left"></td></tr><tr><td>Status:</td><td id="heartrate_status"></td></tr><tr><td valign="top">Log:</td><td id="heartrate_log"></td></tr></table>';
content.insertBefore(heartrate_div, content.firstChild);

function msg(log) {
    document.getElementById('friends_added').innerHTML = friends_added;
    document.getElementById('friends_left').innerHTML = friends.length;
    var l = document.getElementById('heartrate_log');
    l.innerHTML = log + '<br />' + l.innerHTML;
    //    console.log(log);
}

function status(s) {
    document.getElementById('heartrate_status').innerHTML = s;
}

function fblink() {
    return '<a href="' + fb_url + friends[0].id + '">' + friends[0].name + '</a>';
}

function mwlink(s) {
    return '<a href="' + mw_url + friends[0].id + '">' + s + '</a>';
}

function request_next() {
    function f () {
	status('Adding ' + fblink() + '...');
	request(add_url + friends[0].id);
    }
    if (friends.length > 0) {
	if (first) {
	    first = false;
	    f ();
	} else {
	    status('Waiting for ' + wait + ' seconds...');
	    setTimeout(f, wait * 1000);
	}
    } else {
	status('All done');
	msg('');
    }
}

function state_change() {
    if (xmlHTTP.readyState == 4) {	// 4 = "loaded"
	if (xmlHTTP.status == 200) {	// 200 = OK
	    s = xmlHTTP.responseText;
	    if (m = /You have added (.+) to your mafia/.exec(s)) {
		friends_added++;
		msg('Added ' + mwlink(m[1]) + ' AKA ' + fblink() + '.');
	    } else if (m = /You are already part of (.+)\'s mafia/.exec(s)) {
		msg('Already added ' + mwlink(m[1]) + ' AKA ' + fblink() + '.');
	    } else if (/app10979261223_content_row/.test(s) || /window\.location\.replace/.test(s)) {
		// If Mafia Wars loaded, but we didn't get the message, we probably have a user who doesn't play Mafia Wars.
		msg('Tried adding ' + fblink() + ' with unknown result.');
	    } else {
		retry('Unknown response');
		return;
	    }
	    retries = 0;
	    friends = friends.slice(1);
	    request_next();
	} else {
	    retry('Problem retrieving data');
	    return;
	}
    }
}

function begin() {
    var xpath = "//div[@class='unselected_list']//label[@class='clearfix']";
    var results = document.evaluate(xpath, document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
    var i = 0;
    friends = [];
    while ((res = results.snapshotItem(i)) != null) {
	friends[friends.length] = {'id': res.firstChild.value, 'name': res.lastChild.innerHTML};
	//	console.log('ID:   ' + res.firstChild.value);
	//	console.log('Name: ' + res.lastChild.innerHTML);
	i++;
    }
    if (i == 0) {
	status('Run this bookmarklet from <a href="' + recruit_url + '">the recruit page</a>.');
    } else {
	msg('Found ' + i + ' friends not yet in your mafia');
	wait = prompt('Enter delay between requests in seconds.', 10);
	request_next();
    }
    //    msg('Got friend list');
}

xmlHTTP = get_xmlHTTP();
if (!xmlHTTP) {
	alert("Your browser does not support XMLHTTP.");
	return;
}

//status('Getting friend list');
//request(recruit_url);

begin();

} ());
