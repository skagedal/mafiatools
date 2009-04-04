"""Bobby Heartrate's Mafia Tools - common stuff"""

def row(javascript, label, explanation):
    """One row in the bookmarklets table"""
    # Used to have title="Drag me to your toolbar!" - this made IE think that was the title to bookmark */
    return '''<tr>
  <td width="30%%" valign="top"><div class="acont">
    <a class="bookmarklet" href="%(javascript)s">%(label)s</a>
  </div></td>
  <td>%(explanation)s</td>
</tr>''' % locals()
    
