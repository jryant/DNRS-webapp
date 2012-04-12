function getAjax(){
	var objAjax;
	try { // W3C: Chrome, Firefox, Opera, Safari, IE9
		objAjax = new XMLHttpRequest();
	} catch (e1) {
		try { // IE 6-8
			objAjax = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e2) {
			try { // IE 5.5
				objAjax = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e3) {
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	return objAjax;
}