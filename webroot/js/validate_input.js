//ajax
$(document).ready(function(){
	
	//check email address if it exist!!!
	$( "#email" ).keyup(function() {
		checkEmail($( "#email" ).val());
	});
	
	function checkEmail(str) {
		if (str != "") {
			atpos = str.indexOf("@");
			dotpos = str.lastIndexOf(".");
			
			if (str != ""){
				if (atpos < 1 || (dotpos - atpos < 2)){
					$("#l_email").text("Email Address *Error!");
					$("#email").focus();
				}else{
					$("#l_email").text("Email Address");
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {                			
							var resText = xmlhttp.responseText;
							
							if (resText.trim() == 'red'){
								$("#l_email").text("Email Address is taken!");
								$("#l_email").css("color", resText.trim());
								$("#btnsave").attr("disabled", "disabled");
							}else {
								$("#l_email").text("Email Address");
								$("#l_email").css("color", resText.trim());
								$("#btnsave").removeAttr("disabled");
							}
						}
					};
					xmlhttp.open("GET","checkinput.php?email="+str,true);
					xmlhttp.send();
				}
			}		
		}
	}
	
	
	//check password!!!
	$( "#confirm" ).keyup(function() {
		confirmPassword($( "#confirm" ).val());		
	});
	
	function confirmPassword(str) {
		if (str == "") {
			return;
		} else { 		
			var pwd = $("#password").val();
						
			if (str != pwd){				
				$("#l_confirm").css("color", "red");
				$("#l_confirm").text("Password does not match!");
			}else {
				$("#l_confirm").css("color", "green");
				$("#l_confirm").text("Confirm password");
			}	
		}
	}
	
	//check password!!!
	$( "#password" ).keyup(function() {
		confirmPassword($( "#password" ).val());		
	});
	
	function confirmPassword(str) {
		if (str == "") {
			return;
		} else { 		
			var pwd = $("#confirm").val();
						
			if (str != pwd){				
				$("#l_password").css("color", "red");
				$("#l_password").text("Password does not match!");
			}else {
				$("#l_password").css("color", "green");
				$("#l_password").text("Password");
			}	
		}
	}
	
	//check email address if it exist!!!
	$( "#upline" ).keyup(function() {
		checkUpline($( "#upline" ).val());
	});
	
	function checkUpline(str) {
		if (str == "") {
			return;
		} else { 		
			
			atpos = str.indexOf("@");
			dotpos = str.lastIndexOf(".");
			
			if (str != ""){
				if (atpos < 1 || (dotpos - atpos < 2)){
					$("#l_upline").text("Email Address *Error!");
					$("#upline").focus();
				}else{
					$("#l_upline").text("Email Address");
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {                			
							var resText = xmlhttp.responseText;
							
							if (resText.trim() == 'red'){
								$("#l_upline").text("Email Address is invalid!");
								$("#l_upline").css("color", resText.trim());
								//$("#btnsave").attr("disabled", "disabled");
							}else {
								$("#l_upline").text("Email Address");
								$("#l_upline").css("color", resText.trim());
								//$("#btnsave").removeAttr("disabled");
							}
						}
					};
					xmlhttp.open("GET","checkinput.php?upline="+str,true);
					xmlhttp.send();
				}
			}		
		}
	}

});