$(document).ready(function() {
	
	$("#m5").addClass("current");
	getDivData('get_invoice_list.php');
	
	$(".downloadsave").hide();
	
	console.log('hidden?');
	
	$(".checkDownload").click(function(){
		var id = $(this).data('fmrecid');
		
		var id = $(this).data('fmrecid');
		var vl = $(this).data('fmvalue');
		var chd = $(this).is( ":checked" );
		
		
		console.log('id: '+id+'  vl: '+vl+'  chd: '+chd);
		
		if(chd == true){
			if(vl != 1) {
				$('#'+id).show();
			} else {
				$('#'+id).hide();
			}
		} else if (chd != true){
			if(vl === 1){
				$('#'+id).show();
			} else {
				$('#'+id).hide();
			}
		}
		
		
	});
	
	$(".downloadsave").click(function(){
		var id = $(this).prev().data('fmrecid');
		var vl = $(this).prev().data('fmvalue');
		var chd = $(this).prev().is( ":checked" );
						
		$(this).text('saving...');
		
		var svbtn = $(this);
				
		if(chd == true && vl != 1) {
			var vlnew = 1;
		} else {
			var vlnew = 0;
		}
		
		console.log('id: '+id+'  vl: '+vl+'  chd: '+chd+'  vlnew: '+vlnew);
		
		$.post( "setasdl.php", { recid: id, flagDownloaded: vlnew })
			.done(function( data ) {
				svbtn.prev().data('fmvalue',1);
				svbtn.text('saved');
				console.log('svd vl: '+svbtn.prev().data('fmvalue'));
				svbtn.fadeOut('slow', function(){
					svbtn.text('Save');
				});
				
				
		});
		
	});

	
});