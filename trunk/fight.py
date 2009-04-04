#!/usr/bin/python2.5
import sys
import os
import cgi
import cgitb
import Cookie
import urllib
import xml.sax.saxutils

import bhmt

cgitb.enable()

PATH_DATA = '/home/simon/public_html/mafia' 

form = cgi.FieldStorage()
cookies = Cookie.BaseCookie(os.environ.get("HTTP_COOKIE", ""))

def get_field(s):
    if form.has_key(s):
        return form[s].value
    if cookies.has_key(s):
        return urllib.unquote(cookies[s].value)
    return None

def js():
    return r"""javascript:m=document.getElementById('app10979261223_content_row');if(m){tds=m.getElementsByTagName('td');s='';s2='';for(var i=0;i<tds.length;i++){td=tds[i];if(td.className=='message_body')s+=td.innerHTML.replace(/<.*?>/g,'')+'\n\n';if(td.className=='profile_stat_name'){s2+=/\w+/.exec(td.innerHTML.toLowerCase())[0]+'='}if(td.className=='profile_stat_number'){s2+=td.innerHTML+'&'}}location.href='http://helgo.net/cgi-bin/simon/mafia/fight.py?fight='+encodeURI(s)+'&'+s2+'&level='+document.getElementById('app10979261223_user_level').firstChild.data}""" 

def bookmarklet():
    return '<table border="0">\n' + bhmt.row(js(), 'Analyze', 'Use this to analyze your fights') + '</table>'

def bookmarklet_again():
    return '<p>In case you lost your bookmarklet, here it is again:</p>\n' + bookmarklet()

def stats(attack, defense, level):
    return '<table>\n' + \
        '\n'.join('<tr><td>%s:</td><td>%s</td></tr>' % x for x in [('Attack', attack), ('Defense', defense), ('Level', level)]) + \
        '</table>\n'

def fightlink(s):
    return '''<a href="http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=fight&xw_action=view">%s</a>''' % s

s = """<html>
<head>
<title>Bobby Heartrate's Mafia Tools: Fight Analyzer</title>
<link rel="stylesheet" type="text/css" href="/simon/mafia/style.css" />
</head>
<body>
<div id="main">
<h1 id="logoh1"><img id="logo" src="/simon/mafia/bobby_logo.png" alt="Bobby Heartrate's Mafia Tools" /></h1>
"""

fight = get_field('fight')
attack = get_field('attack')
defense = get_field('defense')
level = get_field('level')

if (fight):
    if attack and defense and level:
        # s += stats(attack, defense, level)
        # Print warning if values come from cookies
        if (not form.has_key('attack')):
            s += """<p>Press Calculate to analyze your fight with David Holderness' Combat Calculator!</p>"""
        s += '''<form name="frmSend" action="http://www.mafia-wars.info/index.php" method="POST">
<input type="hidden" name="Submission" value="yes">
<table border="0"  cellspacing="0" cellpadding="0">
<tr>
<td><h2>Combat Results</h2></td>
<td colspan="2"><textarea rows="5" cols="55" name="attack_equipment">%(fight)s</textarea></td>
</tr>         
<tr><td colspan="2"><h2>&nbsp;</h2></td>
<td width="50%%" rowspan="4">
</tr>
<tr><td><h2>Attack</h2></td>
<td>
<input type="text" name="attack" value="%(attack)s" maxlength="250">
</td>
<td>
</td>
</tr>
<tr><td><h2>Defense</h2></td>
<td>
<input type="text" name="defence" value="%(defense)s" maxlength="250">
</td>
<td>
</td>
</tr>
<tr><td width="20%%"><h2>Level</h2></td>
<td>
<input type="text" name="level" value="%(level)s" maxlength="250">
</td>
</td>
</tr>
<tr><td colspan="2"><h2>&nbsp;</h2></td>
<td></td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="1"><p><input style="margin-top:4" type="submit" value="Calculate!" name="Submit1" class="button"></p></td>
<td align="right">
</td>
</tr>
</td></tr></table>
</form>''' % {'fight':xml.sax.saxutils.escape(fight), 'attack':attack, 'defense':defense, 'level':level}
        
        s += """<ul><li>Now just press "Calculate" to calculate your combat skills!</li>"""
        s += """<li>To update your stats, go to your <a href="http://apps.facebook.com/inthemafia/">Mafia Wars homepage</a> 
                    and press Analyze.</li>"""
        s += '<li>Then go do some more '+fightlink('fighting')+''' and press Analyze again!</li></ul>'''
        s += bookmarklet_again()
    else:
        s += '<div class="fightresult">\n' + fight.replace('\n','<br />') + '\n</div>\n'
        s += '''<p>Cool! I need your stats as well. 
                Please go to your <a href="http://apps.facebook.com/inthemafia/">Mafia Wars homepage</a> and press Analyze again.</p>'''
        s += bookmarklet_again()
else:
    if attack and defense and level:
        s += stats(attack, defense, level)
        s += '<p>I have your stats now, great! Now, '+fightlink('go fight some mafias')+', and then press Analyze again.</p>'
        s += bookmarklet_again()
    else:
        s += """<p>Welcome to Bobby Heartrate's Fight Analyzer, a tool that simplifies the use of David Holderness' <a href="http://mafia-wars.info/">Combat Calculator</a> &ndash; using this, you can analyze your fights with one <span style="font-size: small">(or two)</span> simple clicks! We just need to set you up first. Get started by dragging this bookmarklet to your toolbar:</p>"""
        s += bookmarklet()
        s += """<p>After doing that, give me your stats by going to your <a href="http://apps.facebook.com/inthemafia/">Mafia Wars homepage</a> and press Analyze.</p>"""

s += """<hr /><a href="/simon/mafia/">Bobby Heartrate's Mafia Tools</a>"""

s += """</body>
</html>"""

for (val, cookie_name) in [(attack, "attack"), (defense, "defense"), (level, "level"), (fight, "fight")]:
    if val:
        cookies[cookie_name] = urllib.quote(str(val))

if __name__ == '__main__':
    if '--js' in sys.argv:
        print(js())
    else:
        print("Content-type: text/html")
        print(cookies.output())
        print("")
        print(s)
