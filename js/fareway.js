$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
};

function formatDate(date) {
    var d = new Date(date);
    var hh = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    var dd = "am";
    var h = hh;
    if (h >= 12) {
        h = hh-12;
        dd = "pm";
    }
    if (h === 0) {
        h = 12;
    }
    m = m<10?"0"+m:m;

    s = s<10?"0"+s:s;

    /* if you want 2 digit hours:
    h = h<10?"0"+h:h; */

    var pattern = new RegExp("0?"+hh+":"+m+":"+s);

    var replacement = h+":"+m;
    /* if you want to add seconds
    replacement += ":"+s;  */
    replacement += " "+dd;
    var tfd = h+':'+m+' '+dd;

//     return date.replace(pattern,replacement);
    return tfd;
}

function getsched() {
	
	var v = $('#fattr').find('input[name="v"]').val();
	var w = $('#fattr').find('input[name="w"]').val();
	var startdate = $('#fattr').find('input[name="startdate"]').val();
	var enddate = $('#fattr').find('input[name="enddate"]').val();
	var subt = $('#fattr').find('input[name="subt"]').val();
	
	console.log('v: '+v+' startdate: '+startdate);
	
	var data2 = {
		"v": v,
		"startdate": startdate,
		"enddate": enddate,
		"subt": subt
	};
	console.log(data2);
	$.ajax({
		type: "GET",
		url: "get_demoschedule.php",
		dataType: "html",
		data: data2,
		success: function(data) {
			console.log('got the sched');
			var p = $("#footer").detach();
			$("#replace_data").replaceWith(data);
			console.log('data:')
			p.appendTo( "body" );
			console.log(data2);
		}
	});
	
}

function editTHIS() {
	
	var valf = $(this).val();
	console.log(valf);
	var fld = $(this).data('fmfield');
	var frecid = $(this).data('fmrecid');
	console.log(fld);
	console.log(frecid);
	var data2 = {
		"-db": "web_storemind",
		"-lay": "web_bandr_recap_enter",
		"-recid": frecid
	};
	data2[fld] = valf;
	data2["-edit"] = "";
	$.ajax({
		type: "GET",
		url: "fmrelay.php",
		dataType: 'xml',
		data: data2,
		success: function() {
			console.log('Edited a field: ' + data2[fld]);
		}
	});
	
}


function getstorelist() {
	
	var v = $('#fattr').find('input[name="v"]').val();
	var w = $('#fattr').find('input[name="w"]').val();
	var startdate = $('#fattr').find('input[name="startdate"]').val();
	var enddate = $('#fattr').find('input[name="enddate"]').val();
	var subt = $('#fattr').find('input[name="subt"]').val();
	
	console.log(v);
	
	var data2 = {
		"v": v,
		"w": w,
		"startdate": startdate,
		"enddate": enddate,
		"subt": subt
	};
	console.log(data2);
	$.ajax({
		type: "GET",
		url: "get_storelist.php",
		dataType: "html",
		data: data2,
		success: function(data) {
			console.log('got the stuff');
			$("#store_list").replaceWith(data);
		}
	});
	
}


function getDivData(theFile) {
	
	var v = $('#fattr').find('input[name="v"]').val();
	var w = $('#fattr').find('input[name="w"]').val();
	var startdate = $('#fattr').find('input[name="startdate"]').val();
	var enddate = $('#fattr').find('input[name="enddate"]').val();
	var subt = $('#fattr').find('input[name="subt"]').val();
	var ba = $('#badetail').find('input[name="ba"]').val();
	var UID = $('#fattr').find('input[name="UID"]').val();
	var UIDlocation = $('#fattr').find('input[name="UIDlocation"]').val();
	
	var unpaid = $('#fattr').find('input[name="unpaid"]').val();
	var downloaded = $('#fattr').find('input[name="downloaded"]').val();
	var search = $('#fattr').find('input[name="search"]').val();

	
	console.log(ba);
	
	var data2 = {
		"v": v,
		"w": w,
		"ba": ba,
		"UID": UID,
		"UIDlocation": UIDlocation,
		"startdate": startdate,
		"enddate": enddate,
		"subt": subt,
		"search": search,
		"unpaid": unpaid,
		"downloaded": downloaded
	};
	console.log(data2);
	$.ajax({
		type: "GET",
		url: theFile,
		dataType: "html",
		data: data2,
		success: function(data) {
			console.log('got the stuff');
			var p = $("#footer").detach();
			$("#replace_data").replaceWith(data);
// 			$("body").append(p);
// 			p.appendTo( "body" );
// 			console.log('p back'+p.text);
		}
	});
	
}


function checkTime(tt) {
	console.log('time check:');
	console.log(tt);
	var hh = tt.substring(0, tt.indexOf(':')), mm = tt.substring(tt.indexOf(':')+1);
	var hn = hh;
	if(parseInt(hh) < 7) {
		hn = parseInt(hh) + 12;
	}
		console.log(hn);
		console.log(hn+':'+mm);
		return hn+':'+mm+':00';
}