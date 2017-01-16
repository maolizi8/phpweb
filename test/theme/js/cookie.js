function setCookie(cname, cvalue) {
	var d = new Date();
	var exdays = 30;
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i].trim();
		if(c.indexOf(name) == 0) return c.substring(name.length, c.length);
	}
	return "";
}

function delCookie(cname) {
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(cname);
	if(cval != null)
		document.cookie = cname + "=" + "" + ";expires=" + exp.toGMTString();
	//document.cookie= cname + "="+cval+";expires="+exp.toGMTString();
}

function checkUserLogin(){
	var qarole=getCookie("qarole");
	var qauser=getCookie("qausername");
	if (qarole=="" || qarole==null || qauser=="" || qauser==null){
		console.log("noUser!");
		window.location.href = "login.html";
	}
}
