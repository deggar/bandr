function submitPW() {
	
	var param1 = new Date();
	var param2 = (param1.getMonth()+1) + '/' + param1.getDate() + '/' + param1.getFullYear() + ' ' + param1.getHours() + ':' + param1.getMinutes() + ':' + param1.getSeconds();
	var tstamp = param2;
	
	console.log(tstamp);
	var fmrecid = $('#sendform').data('fmrecid');
	var pword = $('#password2').val();
	var data2 = {
		"-db": "Flair_App",
		"-lay": 'webuser',
		"-recid": fmrecid,
		"userLocationDefault": na,
		"info_LastLoggedIn": tstamp,
		"Password": pword
	};

	data2["-edit"] = "";
	console.log(data2);
	$.ajax({
		type: "GET",
		url: "fmrelay.php",
		dataType: 'xml',
		data: data2,
		success: function() {
			console.log('Submitting a password change: ' + data2['info_LastLoggedIn']);
			
		}
	});
	
}


$(document).ready(function() {
	
	$("#ucase").removeClass("glyphicon-remove");
	$("#ucase").addClass("glyphicon-ok");
	$("#ucase").css("color","#00A41E");
	$("#lcase").removeClass("glyphicon-remove");
	$("#lcase").addClass("glyphicon-ok");
	$("#lcase").css("color","#00A41E");
	$("#num").removeClass("glyphicon-remove");
	$("#num").addClass("glyphicon-ok");
	$("#num").css("color","#00A41E");

	$("input[type=password]").keyup(function(){
/*
		var ucase = new RegExp("[A-Z]+");
		var lcase = new RegExp("[a-z]+");
		var num = new RegExp("[0-9]+");
				var num = 1;
*/
		
		if($("#password1").val().length >= 4){
			$("#8char").removeClass("glyphicon-remove");
			$("#8char").addClass("glyphicon-ok");
			$("#8char").css("color","#00A41E");
		}else{
			$("#8char").removeClass("glyphicon-ok");
			$("#8char").addClass("glyphicon-remove");
			$("#8char").css("color","#FF0004");
		}
		
/*
		if(ucase.test($("#password1").val())){
			$("#ucase").removeClass("glyphicon-remove");
			$("#ucase").addClass("glyphicon-ok");
			$("#ucase").css("color","#00A41E");
		}else{
			$("#ucase").removeClass("glyphicon-ok");
			$("#ucase").addClass("glyphicon-remove");
			$("#ucase").css("color","#FF0004");
		}
		
		if(lcase.test($("#password1").val())){
			$("#lcase").removeClass("glyphicon-remove");
			$("#lcase").addClass("glyphicon-ok");
			$("#lcase").css("color","#00A41E");
		}else{
			$("#lcase").removeClass("glyphicon-ok");
			$("#lcase").addClass("glyphicon-remove");
			$("#lcase").css("color","#FF0004");
		}
		
		if(num.test($("#password1").val())){
			$("#num").removeClass("glyphicon-remove");
			$("#num").addClass("glyphicon-ok");
			$("#num").css("color","#00A41E");
		}else{
			$("#num").removeClass("glyphicon-ok");
			$("#num").addClass("glyphicon-remove");
			$("#num").css("color","#FF0004");
		}
*/
		
		if($("#password1").val() == $("#password2").val()){
			$("#pwmatch").removeClass("glyphicon-remove");
			$("#pwmatch").addClass("glyphicon-ok");
			$("#pwmatch").css("color","#00A41E");
		}else{
			$("#pwmatch").removeClass("glyphicon-ok");
			$("#pwmatch").addClass("glyphicon-remove");
			$("#pwmatch").css("color","#FF0004");
		}
	});
	
	
	var d, dom, ie, ie4, ie5x, moz, mac, win, lin, old, ie5mac, ie5xwin, op;
	
	d = document;
	n = navigator;
	na = n.appVersion;
	nua = n.userAgent;
	win = ( na.indexOf( 'Win' ) != -1 );
	mac = ( na.indexOf( 'Mac' ) != -1 );
	lin = ( nua.indexOf( 'Linux' ) != -1 );
	
	if ( !d.layers ){
		dom = ( d.getElementById );
		op = ( nua.indexOf( 'Opera' ) != -1 );
		konq = ( nua.indexOf( 'Konqueror' ) != -1 );
		saf = ( nua.indexOf( 'Safari' ) != -1 );
		moz = ( nua.indexOf( 'Gecko' ) != -1 && !saf && !konq);
		ie = ( d.all && !op );
		ie4 = ( ie && !dom );
		
		/*
		ie5x tests only for functionality. ( dom||ie5x ) would be default settings. 
		Opera will register true in this test if set to identify as IE 5
		*/
		
		ie5x = ( d.all && dom );
		ie5mac = ( mac && ie5x );
		ie5xwin = ( win && ie5x );
	}
	console.log(nua);
	console.log(na);
	
	$( "#passwordForm" ).submit(function( event ) {
// 		event.preventDefault();
		submitPW();
		
	});
	
/*
	$("#change").click(function(event){
		event.preventDefault();
		submitPW();
		$("#passwordForm").submit()
		
	});
*/
	
	
	

}); //end of load