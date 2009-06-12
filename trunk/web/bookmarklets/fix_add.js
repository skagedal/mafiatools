void(function(){
var xmlHTTP;
var last_url=null;
var retries=0;
function get_xmlHTTP(){if(window.XMLHttpRequest)return new XMLHttpRequest();if(window.ActiveXObject)return new ActiveXObject("Microsoft.XMLHTTP");return null;}
function request(url){
xmlHTTP.onreadystatechange=state_change;
xmlHTTP.open("GET",url,true);
xmlHTTP.send(null);
last_url=url;}
function retry(s){if(retries>9){msg(s+'; not retrying any more.');}else{retries++;msg(s+'; retry %23'+retries+'...');request(last_url);}}
var recruit_url='http://apps.facebook.com/inthemafia/remote/html_server.php%3Fxw_controller=recruit%26xw_action=view';
var add_url='http://apps.facebook.com/inthemafia/status_invite.php%3Ffrom=';
var mw_url='http://apps.facebook.com/inthemafia/remote/html_server.php%3Fxw_controller=stats%26xw_action=view%26user=';
var fb_url='http://www.facebook.com/profile.php%3Fid=';
var friends_added=0;
var friends=null;
var first=true;
var wait=1;
var content=document.getElementById('app10979261223_content_row');
var heartrate_div=document.createElement("div");
heartrate_div.innerHTML='<table class="messages"><tr><td colspan="2" style="text-align: right"><a href="http://heartrate.se/" style="margin-left: auto"><img src="http://heartrate.se/images/banner_small.png" width="208px" height="25px" /></a></td></tr><tr><td width="20%25">Friends added:</td><td id="friends_added"></td></tr><tr><td>To try:</td><td id="friends_left"></td></tr><tr><td>Status:</td><td id="heartrate_status"></td></tr><tr><td valign="top">Log:</td><td id="heartrate_log"></td></tr></table>';
content.insertBefore(heartrate_div,content.firstChild);
function msg(log){document.getElementById('friends_added').innerHTML=friends_added;document.getElementById('friends_left').innerHTML=friends.length;var l=document.getElementById('heartrate_log');l.innerHTML=log+'<br />'+l.innerHTML;}
function status(s){document.getElementById('heartrate_status').innerHTML=s;}
function fblink(){return'<a href="'+fb_url+friends[0].id+'">'+friends[0].name+'</a>';}
function mwlink(s){return'<a href="'+mw_url+friends[0].id+'">'+s+'</a>';}
function request_next(){function f(){status('Adding '+fblink()+'...');request(add_url+friends[0].id);}if(friends.length>0){if(first){first=false;f();}else{status('Waiting for '+wait+' seconds...');setTimeout(f,wait%2A1000);}}else{status('All done');msg('');}}

function state_change(){
    if(xmlHTTP.readyState==4) {
	if(xmlHTTP.status==200) {
	    s=xmlHTTP.responseText;
	    if(m=/You have added (.+) to your mafia/.exec(s)) { 
		friends_added++;
		msg('Added '+mwlink(m[1])+' AKA '+fblink()+'.');
	    } else if (m=/You are already part of (.+)\'s mafia/.exec(s)){
		msg('Already added '+mwlink(m[1])+' AKA '+fblink()+'.');
	    }else if(/app10979261223_content_row/.test(s)){
		msg('Couldn\'t add '+fblink()+', maybe not a Mafia Wars player%3F');
	    }
	    friends=friends.slice(1);request_next();}else{retry('Problem retrieving data');return;}}retries=0;}function begin(){var xpath="//div[%40class='unselected_list']//label[%40class='clearfix']";var results=document.evaluate(xpath,document,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,null);var i=0;friends=[];while((res=results.snapshotItem(i))%21=null){friends[friends.length]={'id':res.firstChild.value,'name':res.lastChild.innerHTML};i++;}if(i==0){status('Run this bookmarklet from <a href="'+recruit_url+'">the recruit page</a>.');}else{msg('Found '+i+' friends not yet in your mafia');wait=prompt('Enter delay between requests in seconds.',10);request_next();}}xmlHTTP=get_xmlHTTP();if(%21xmlHTTP){alert("Your browser does not support XMLHTTP.");return;}begin();}());