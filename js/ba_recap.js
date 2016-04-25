

$(document).ready(function() {

	var efUID = $.urlParam('recapUID');

	getDivData('get_barecap.php?recapUID='+efUID);
	
	
	$('[data-fmfield]').on('blur',editTHIS);
	
	$( "#precalldate" ).datepicker({
		dateFormat: "mm/dd/yy",
		onSelect: editTHIS
	});
	
	$( "#ActualDateWorked" ).datepicker({
		dateFormat: "mm/dd/yy",
		onSelect: editTHIS
	});
	
});