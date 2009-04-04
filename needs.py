#!/usr/bin/python2.5

PATH_DATA = '/home/simon/public_html/mafia'

def gifts():
    def split_lines(gifts):
        return [tuple([x.strip() for x in g.split('=')]) for g in gifts.split('\n') if g.strip() != ""]

    gifts = open(PATH_DATA + '/gifts.txt').read()
    grouped = gifts.split('\n\n')
    gs = map(split_lines, grouped)
    return gs

def make_url(num):
    return "http://apps.facebook.com/inthemafia/remote/html_server.php?xw_controller=gift&recipients%5B1%5D=1463977030&gift_id=" + num + "&xw_action=send"


for group in gifts():
    for gift in group:
        (num, name) = gift
        print('''<li><a href="%s">%s</a></li>''' % (make_url(num), name))


