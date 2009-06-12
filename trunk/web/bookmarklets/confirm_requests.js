// By Chris Dawson: http://userscripts.org/scripts/review/39282

(function() {

	var findPattern = "//div[@id='friend_add']//input[@class='inputbutton' and @value='Confirm']";
	var results = document.evaluate( findPattern, document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null );
	
	var i=0;
	while ( (res = results.snapshotItem(i) ) !=null ){
	    res.click();
	    i++;
	}

})();