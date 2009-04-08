#!/usr/bin/python
import cgi

#import cgitb
#cgitb.enable()

import bhmt

PATH_DATA = '/home/simon/public_html/mafia' 

def fix_js(js):
    return js.replace('<','&lt;').replace('>','&gt;').replace(' ','%20').replace('"','%22').replace('[','%5B').replace(']','%5D')

id_from_mw = r"""c=document.getElementById('app10979261223_content_row');if(c){as=c.getElementsByTagName('a');if(as&&as[0]){href=as[0].getAttribute('href');if(href){id=/&opponent_id=(\d+)/.exec(href);}}}"""
id_from_fb = r"""id=/profile.php[?&]id=(\d+)/.exec(location.href);if(!id)id=/s.php[?&]k=\d+&id=(\d+)/.exec(location.href);"""
id_from_either = 'id=null;' + id_from_mw + 'if(!id)' + id_from_fb
my_id = r'''/%2522p_(\d+)/.exec(document.cookie)''' # id string will be in [1]

def simple(base_url, info_text):
    """Generates javascript for "simple" bookmarklets"""
    err = fix_js('ERROR: Could not find id! Are you on a profile page?')
    return 'javascript:' + id_from_either + \
                  r"""if(id){document.write('<html><body>'+%s+'</body></html>');location.href='%s'+id[1];}else{alert('%s');}""" % \
                  (fix_js(info_text), base_url, err);

def gifts():
    """Generate the Gift javascript """
    def split_lines(gifts):
        return [tuple([x.strip() for x in g.split('=')]) for g in gifts.split('\n') if g.strip() != ""]
    def join_jsarray(gs):
        return "[" + ",".join(["['%s','%s']" % (num, name) for (num, name) in gs]) + "]"

    gifts = open(PATH_DATA + '/gifts.txt').read()
    grouped = gifts.split('\n\n')
    gs = map(split_lines, grouped)
    jsarray = "[" + ",".join(map(join_jsarray, gs)) + "]"

    js = "javascript:d=document;" + id_from_either + "d.write('<html><body>');if(!id){d.write('Not on profile page, using own id<br/>');id=%s}" % my_id + "if(id){a=" + jsarray + """;d.write('Give to user with id '+id[1]+':<table>');a.forEach(function(row){d.write('<tr>');row.forEach(function(e){document.write('<td><a href="http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=gift&recipients%255B1%255D='+id[1]+'&gift_id='+e[0]+'&xw_action=send">'+e[1]+'</a></td>')});d.write('</tr>')});d.write('</table></body></html>');}"""

    return js

def switcher():
    """Generate the Switch Profile javascript"""
    return 'javascript:id=null;' + id_from_mw + r"""if(id){location.href='http://www.facebook.com/profile.php?id='+id[1];}else{id=/(?:profile|addfriend).php[?&]id=(\d+)/.exec(location.href);if(!id)id=/s.php[?&]k=\d+&id=(\d+)/.exec(location.href);if(id){location.href='http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=stats&xw_action=view&user='+id[1];}else{alert('ERROR:%20Could%20not%20find%20id!%20Are%20you%20on%20a%20profile%20page?');}}"""


bookmarklets = [
    (simple("http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=group&xw_action=view&promote=yes&uid=",
            "'Promote user with id '+id[1]+'...'"),
     "Promote",
     "Use this to add someone to your Top Mafia."),
    (simple("http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=hitlist&xw_action=set&target_id=",
            "'Hitlist user with id '+id[1]+'...'"),
     "Hitlist",
     "Use this to hitlist someone. It's also useful to see if the person has already been killed, without spending a stamina point."),
    (simple("http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=fight&xw_action=attack&opponent_id=",
            "'Attack user with id '+id[1]+'...'"), 
     "Attack",
     "Use this to attack someone."),
    (simple("http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=fight&xw_action=punch&action=punch&opponent_id=",
            "'Punch user with id '+id[1]+'...'"), 
     "Punch",
     "Use this to punch someone in the face."),
    (simple("http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=racket&xw_action=view&opponent_id=",
            "'Rob user with id '+id[1]+'...'"), 
     "Rob",
     "Use this to open up the page where you can rob this person's properties."),
    (simple("http://www.facebook.com/inbox/?compose&id=",
            "'Message user with id'+id[1]+'...'"),
     'Message',
     "Use this to send a Facebook message to someone")]


main_content = """
<body>
<div id="main">
<h1 id="logoh1"><img id="logo" src="/simon/mafia/bobby_logo.png" alt="Bobby Heartrate's Mafia Tools" /></h1>
<p>Here are some useful <em>bookmarklets</em> that simplifies some common tasks when playing Mafia Wars. If you have no clue what I'm talking about, read the FAQ below.</p>
<p>These bookmarklets do Mafia Wars actions on a user from their Facebook or Mafia Wars profile. They also work on "closed" Facebook profiles, i.e. "profile pages" of people you are not friends with &ndash; for example, if you see someone in the <a href="http://www.facebook.com/board.php?uid=10979261223">forum</a> that you want to attack, rob, whatever; right-click on the person and open it up in a new tab, then, from that tab, click "Attack".</p>
</p>
<h2 id="instructions">Instructions</h2>
<p>Install the bookmarklets you want by dragging them to your bookmarks toolbar. (If you're using Internet Explorer, dragging doesn't seem to work. Instead, right-click on the link and then take "Add to favourites". You really should do yourself a favour and get <a href="http://www.mozilla.com/firefox/">Firefox</a> or <a href="http://www.google.com/chrome">Google Chrome</a>.)</p>
<table border="0">""" + \
"\n".join(bhmt.row(js, label, expl) for (js, label, expl) in bookmarklets) + \
"""</table>
</body>
</html>
"""

s = bhmt.head() + bhmt.body(bhmt.menu("index"), main_content)

print(s)

# open("/home/simon/public_html/mafia/gift_js.txt", "w").write(fix_js(gifts()))

