"""Bobby Heartrate's Mafia Tools - common stuff"""

def head(title_extra = None):
        if title_extra:
                title_extra = ": " + title_extra
        else:
                title_extra = ""
	return """Content-type: text/html

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Bobby Heartrate's Mafia Tools%(title_extra)s</title>
<link rel="stylesheet" type="text/css" href="/new/style/mafia_style.css" />
</head>
	""" % locals()

def body(menu, content):
	return """<body>
<div id="content">
<div id="header">
<img src="/new/images/banner.png" alt="Bobby Heartrate's Mafia Tools" width="800px" />
</div>
<div id="left_column">
%(menu)s
<div class="left_column_item">
<!-- Facebook Badge START --><a href="http://www.facebook.com/people/Bobby-Heartrate/1463977030" title="Bobby Heartrate&#039;s Facebook profile" target="_TOP"><img src="http://badge.facebook.com/badge/1463977030.347.1346701637.png" alt="Bobby Heartrate&#039;s Facebook profile" style="border: 0px;" /></a><!-- Facebook Badge END -->
</div> <!-- left_column_item -->
<div class="left_column_item">
<script type="text/javascript"><!--
google_ad_client = "pub-2774984892854849";
/* 120x600 Grafit */
google_ad_slot = "0439919119";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div> <!-- left_column_item -->
</div> <!-- left_column -->

<div id="main">
%(content)s
<a href="http://validator.w3.org/check?uri=referer">Check valid XHTML</a>
</div> <!-- main -->
</div> <!-- content -->
</body></html>
""" % locals()
	
def menu(id):
	def m_item((_id, title, href)):
		if id == _id:
			return """<li class="selected">%(title)s</li>\n""" % locals()
		else:
			return """<li><a href="%(href)s">%(title)s</a></li>\n""" % locals()
	m = [('index', 'Bookmarklets', '/'),
		 ('news', 'News', '/news/'),
		 ('faq', 'FAQ', '/faq/'),
		 ('donate', 'Donate', '/donate/')]
	return """<ul class="menu">\n""" + "".join(map(m_item, m)) + "</ul>\n"

def row(javascript, label, explanation):
    """One row in the bookmarklets table"""
    # Used to have title="Drag me to your toolbar!" - this made IE think that was the title to bookmark */
    return '''<tr>
  <td width="30%%" valign="top"><div class="acont">
    <a class="bookmarklet" href="%(javascript)s">%(label)s</a>
  </div></td>
  <td>%(explanation)s</td>
</tr>''' % locals()
    
