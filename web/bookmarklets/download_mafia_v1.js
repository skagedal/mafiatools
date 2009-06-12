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

// void (function () {

var content = null;
var hr_lst = null;

{{INCLUDE xmlhttp.js}}

// This plus a number from 1 to number of pages (keep going until no more mafia members are listed)
var list_page_url = 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=group&xw_action=view&p=';

function str_repeat(s, n) {
    return new Array(n + 1).join(s);
}

function get_list_content(s) {
    // This is pretty arbitrary, but we want to get all the content on the page from where the list starts - we don't want the Top Mafia
    // list since that confuses the hell out of us. 
    m = />\s*Successful Heists\s*<[^]*$/.exec(s);
    return m ? m[0] : null;
}

function scrape_list_page(s) {
    /* This one works but doesn't catch those few whose real name doesn't show 
    var list_regex = /<img uid="(\d+)"[^>]*title=\"([^"]*)\"[^]*?<br \/>([^]*?)<br \/>Level\s+(\d+)\s+[^]*?<br \/>([^<]+)<[^]*?<br \/>([^<]+)<[^]*?<br \/>([^<]+)<[^]*?<br \/>([^<]+)</g; 
    */
    var list_regex = /<img uid="(\d+)"([^>]*)>[^]*?<br \/>([^]*?)<br \/>Level\s+(\d+)\s+[^]*?<br \/>([^<]+)<[^]*?<br \/>([^<]+)<[^]*?<br \/>([^<]+)<[^]*?<br \/>([^<]+)</g; 
    // uid="(\d+)"[^>]*)

    var lst = [];
    while (m = list_regex.exec(s)) {
		var m2 = /title=\"([^"]*)"/.exec(m[2]);      
        m[2] = m2 ? m2[1] : '';
		lst[lst.length] = m.slice(1);
    }
    return lst;
}

// Example: http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=group&xw_action=view&p=1

// This plus Facebook ID
var profile_url = 'http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=stats&xw_action=view&user=';

var wait = 0;			// Seconds to wait between requests
var page = 0;			// Current page
var fb_friends = null;		// List of Facebook friend IDs
var friends = null;		// Current list of friends to try giving help to

var content = document.getElementById('app10979261223_content_row');
var heartrate_div = document.createElement("div");
heartrate_div.innerHTML = '<table class="messages"><tr><td colspan="2" style="text-align: right"><a href="http://heartrate.se/" style="margin-left: auto"><img src="http://heartrate.se/images/banner_small.png" width="208px" height="25px" /></a></td></tr><tr><td>Status:</td><td id="heartrate_status"></td></tr><tr><td valign="top">Log:</td><td id="heartrate_log"></td></tr></table>' +
	'<style>#hr_mafia td {border: 1px solid grey;}#hr_mafia{border-collapse:collapse}.scroll{height:500px;overflow:scroll}</style><div class="scroll"><table id="hr_mafia" class="messages"><tr><th>UID</th><th>Real name</th><th>Mafia Name</th><th>Level</th><th>Character</th><th>Fights Won</th><th>Successful Heists</th><th>Jobs Completed</th></tr></table></div><p></p>';
content.insertBefore(heartrate_div, content.firstChild);
var heartrate_mafia = document.getElementById('hr_mafia');

function msg(log) {
    var l = document.getElementById('heartrate_log');
    l.innerHTML = log + '<br />' + l.innerHTML;
}

function status(s) {
    document.getElementById('heartrate_status').innerHTML = s;
}

function request_next() {
    page++;
    function f () {
	status('Getting page ' + page + '...');
	request(list_page_url + page);
    }
    status('Waiting for ' + wait + ' seconds...');
    setTimeout(f, wait * 1000);
}

function add_rows(lst) {
	var html = '';
	for (var i = 0; i < lst.length; i++) {
		var t = lst[i];
		html += '<tr>';
		for (var j = 0; j < t.length; j++)
			html += '<td>' + t[j] + '</td>';
		html += '</tr>';
	}
	heartrate_mafia.innerHTML += html;
}

function state_change() {
    if (xmlHTTP.readyState == 4) {	// 4 = "loaded"
	if (xmlHTTP.status == 200) {	// 200 = OK
	    var s = get_list_content(xmlHTTP.responseText);

	    content = s; // for debugging

	    if (s) {
			hr_lst = scrape_list_page(s);
			console.log(hr_lst);
			add_rows(hr_lst);
			request_next();
	    } else {
			retry('Did not get a list page');
			return;
	    }
	} else {
	    retry('Problem retrieving data');
	    return;
	}
    }
    retries = 0;
}

// Fields to download from listing page:
//  - Real name
//  - Mafia Name
//  - Level
//  - Character
//  - Fights Won
//  - Successful Heists
//  - Jobs Completed
// Fields to download from profile page:
//  - 
//  - Achievements
//  - Fights Lost
//  - Death
//  - Mobsters Whacked
//  - Hitlist Kills
//  - Times Robbed

// Example text
// var text_to_parse = '<img uid="1401061" size="small" style="border: medium none white; width: 50px; height: 50px;" linked="false" src="http://profile.ak.facebook.com/v222/158/53/s1401061_8272.jpg" alt="Jennifer Ashley Vanderburgh" title="Jennifer Ashley Vanderburgh" /></a></div> 				<div style="float: left; width: 135px;"> 					<a href="http://apps.facebook.com/inthemafia/remote/html_server.php?xw_time=1243198850&amp;xw_exp_sig=3c21aec31d783b7b8861b654ed312e33&amp;xw_controller=stats&amp;xw_action=view&amp;user=1401061" onclick="(new Image()).src = &#039;/ajax/ct.php?app_id=10979261223&amp;action_type=3&amp;post_form_id=d751399f35c541f8a3235fd6472cd8eb&amp;position=3&amp;&#039; + Math.random();fbjs_sandbox.instances.a10979261223.bootstrap();return fbjs_dom.eventHandler.call([fbjs_dom.get_instance(this,10979261223),function(a10979261223_event) {a10979261223_do_ajax(&#039;mainDiv&#039;, &#039;remote/html_server.php?xw_time=1243198850&amp;xw_exp_sig=3c21aec31d783b7b8861b654ed312e33&amp;xw_controller=stats&amp;xw_action=view&amp;user=1401061&#039;); return false;},10979261223],new fbjs_event(event));return true;">Jennifer Vander...</a><br />Doï¿½a Vanderburg...<br />Level 110 					</div> 					<div style="float: left; width: 55px; text-align: center; font-weight: bold;"><br />Mogul</div> 					<div style="float: left; width: 100px; text-align: center; font-weight: bold;"><br />896</div> 					<div style="float: left; width: 100px; text-align: center; font-weight: bold;"><br />940</div> 					<div style="float: left; width: 100px; text-align: center; font-weight: bold;"><br />2492</div> 					<div style="float: left; width: 167px; font-weight: bold; text-align: center;"><br /> 					<div> ';


xmlHTTP = get_xmlHTTP();
if (!xmlHTTP) {
	alert("Your browser does not support XMLHTTP.");
	//	return;
}

request_next();

/* 
"Not again" message:

<table class="messages"><tr><td class="message_body"><span class="bad">Not Again!</span> You have already helped <a href="http://apps.facebook.com/inthemafia/remote/html_server.php?xw_time=1243332992&amp;xw_exp_sig=b88664d8d79719cd88566ad107131f30&amp;xw_controller=stats&amp;xw_action=view&amp;user=1552740609" onclick="(new Image()).src = &#039;/ajax/ct.php?app_id=10979261223&amp;action_type=3&amp;post_form_id=a43622192a3afcfab179e2c84ab3b8c1&amp;position=3&amp;&#039; + Math.random();fbjs_sandbox.instances.a10979261223.bootstrap();return fbjs_dom.eventHandler.call([fbjs_dom.get_instance(this,10979261223),function(a10979261223_event) {a10979261223_do_ajax(&#039;mainDiv&#039;, &#039;remote/html_server.php?xw_time=1243332992&amp;xw_exp_sig=b88664d8d79719cd88566ad107131f30&amp;xw_controller=stats&amp;xw_action=view&amp;user=1552740609&#039;); return false;},10979261223],new fbjs_event(event));return true;">Dodge Anthony</a> on the Embezzle Funds Through a Phony Company job. Check back later for more job requests.</td></tr></table>

"Successful" message:
<table class="messages"><tr><td class="message_body">You received <span class="good">13 experience points</span> and <span class="money"><strong>$2,400,000</strong></span> for helping <a href="http://apps.facebook.com/inthemafia/remote/html_server.php?xw_time=1243333187&amp;xw_exp_sig=5fd3dde744b0309d657fd1f7a7ed67be&amp;xw_controller=stats&amp;xw_action=view&amp;user=1480775524" onclick="(new Image()).src = &#039;/ajax/ct.php?app_id=10979261223&amp;action_type=3&amp;post_form_id=a43622192a3afcfab179e2c84ab3b8c1&amp;position=3&amp;&#039; + Math.random();fbjs_sandbox.instances.a10979261223.bootstrap();return fbjs_dom.eventHandler.call([fbjs_dom.get_instance(this,10979261223),function(a10979261223_event) {a10979261223_do_ajax(&#039;mainDiv&#039;, &#039;remote/html_server.php?xw_time=1243333187&amp;xw_exp_sig=5fd3dde744b0309d657fd1f7a7ed67be&amp;xw_controller=stats&amp;xw_action=view&amp;user=1480775524&#039;); return false;},10979261223],new fbjs_event(event));return true;">[FSM] Sauce</a> complete the job.</td></tr></table><br />  

"Need to be friends" message:
<table class="messages"><tr><td class="message_body">You need to be friends with <a href="http://apps.facebook.com/inthemafia/remote/html_server.php?xw_time=1243333253&amp;xw_exp_sig=6af52980852117833f7d827bd3d7c630&amp;xw_controller=stats&amp;xw_action=view&amp;user=" onclick="(new Image()).src = &#039;/ajax/ct.php?app_id=10979261223&amp;action_type=3&amp;post_form_id=a43622192a3afcfab179e2c84ab3b8c1&amp;position=3&amp;&#039; + Math.random();fbjs_sandbox.instances.a10979261223.bootstrap();return fbjs_dom.eventHandler.call([fbjs_dom.get_instance(this,10979261223),function(a10979261223_event) {a10979261223_do_ajax(&#039;mainDiv&#039;, &#039;remote/html_server.php?xw_time=1243333253&amp;xw_exp_sig=6af52980852117833f7d827bd3d7c630&amp;xw_controller=stats&amp;xw_action=view&amp;user=&#039;); return false;},10979261223],new fbjs_event(event));return true;"></a> to provide help.</td></tr></table><br />  



*/
// hr_match = list_regex.exec(text_to_parse);

// console.log(hr_match.slice(1));

// } ());