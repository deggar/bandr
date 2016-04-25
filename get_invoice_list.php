<?php


include('includes/session_start.php');

// require_once('dbaccess.php');

$layout = $mlay.'_schedule';
$tbase = 'bandr';


$path = preg_replace("#^(.*[/\\\\])[^/\\\\]*[/\\\\][^/\\\\]*$#",'\1',__FILE__);
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

//include the FileMaker PHP API
require_once ('FileMaker.php');



//create the FileMaker Object
$fm = new FileMaker();

//Specify the FileMaker database
$fm->setProperty('database', 'wincoInvoice');

//Specify the Host
//     $fm->setProperty('hostspec', '50.240.31.157'); //needed when on a different web server

$fm->setProperty('username', 'php');
$fm->setProperty('password', 'php');


/*
$search = $_REQUEST['search'];
$downloaded = $_REQUEST['downloaded'];
$unpaid = $_REQUEST['unpaid'];
*/

	$layoutName = "ContainerTest";

	//CREATE A FIND REQUEST
	$findRequest1 = $fm->newFindRequest($layoutName);


if(!empty($search)) {
	 
	//ADD FIND CRITERION IN REQUEST
	$findRequest1->addFindCriterion('title', $search);
	$findRequest1->addFindCriterion('inUseWith' , $tbase);
	 
	//CREATE ANOTHER FIND REQUEST
	$findRequest2 = $fm->newFindRequest($layoutName);
	 
	//ADD FIND CRITERION IN REQUEST
	$findRequest2->addFindCriterion('bcode', $search);
	$findRequest2->addFindCriterion('inUseWith' , $tbase);
/* 	$findRequest2->setOmit(true); */
	 
	//CREATE COMPOUND FIND COMMAND
	$compoundFind = $fm->newCompoundFindCommand($layoutName);
	 
	//ADD FIND REQUEST IN COMMAND
	$compoundFind->add(1, $findRequest1);
	$compoundFind->add(2, $findRequest2);
	
	/* Sorting */
	$compoundFind->addSortRule('dated', 1, FILEMAKER_SORT_DESCEND);
	 
	//EXECUTE THE COMMAND
	$result = $compoundFind->execute();

} else if ($downloaded == 1) {
	$command = $fm->newFindCommand('ContainerTest');
	$command->addFindCriterion('flagDownloaded' , '=');
	$command->addFindCriterion('inUseWith' , $tbase);
	//$command->setOmit(true);
	$command->addSortRule('dated', 1, FILEMAKER_SORT_DESCEND);
	$result = $command->execute(); 
} else if ($downloaded == 0) {
	$command = $fm->newFindCommand('ContainerTest');
	$command->addFindCriterion('dated' , '*');
	$command->addFindCriterion('inUseWith' , $tbase);
	//$command->setOmit(true);
	$command->addSortRule('dated', 1, FILEMAKER_SORT_DESCEND);
	$result = $command->execute(); 
} else {

	$command = $fm->newFindCommand('ContainerTest');
	$command->addFindCriterion('flagDownloaded' , '=');
	$command->addFindCriterion('inUseWith' , $tbase);
	//$command->setOmit(true);
	$command->addSortRule('dated', 1, FILEMAKER_SORT_DESCEND);
	$result = $command->execute(); 
}




if (FileMaker::isError($result)) {
    $message = 'Error: ' . $result->message . '(' . $result->code . ')';
//     echo('<div id="replace_data"><p>No Invoices found</p><p>Search: '.$search.'</p><p>Error: '.$message.'</p></div>');
//     die();
}
?>

<div id="replace_data">


<div class="invoicetop">


<div class="col-md-12">
	<div class="col-md-6">
		<form class="form-inline">
			<div class="form-group">
				<input name="search" type="text" class="form-control" placeholder="Search" value="<?php echo $search;?>">
			</div>
			<button type="submit" class="btn btn-default">Search</button>
		</form>
	</div>
	<div class="col-md-6">
		<div class="col-md-8">
			<a class="btn btn-primary" href="invoice_list.php?downloaded=1" role="button">Show Not Downloaded</a>
		</div>
		<div class="col-md-4">
			<a class="btn btn-default" href="invoice_list.php?downloaded=0" role="button">Show All Invoices</a>
		</div>
	</div>
	
<?php if($downloaded){ ?>
	<div class="col-sm-12 col-md-12">
		<div class="alert alert-info">
			<p>Showing only invoices <strong>not</strong> checked as downloaded</p>
		</div>
	</div>
<?php } ?>

</div>

<?php if(!empty($message)){ ?>

<div class="col-sm-6 col-md-6">
	<div class="alert alert-warning">
		<h4>No Invoices found</h4>
		<p>There were no invoices found with [<?php echo($search);?>]<br>
		<strong> Try searching again</strong>.</p>
		<?php echo($result); ?>
	</div>
</div>

<?php } else { ?>


<div id="invoicelist">
	<table id="box-table-b" class="table1 table-bordered" width="90%">
	<thead><tr class="invth">
	<th width="50%" >Invoice</th><th>Date</th><th>Downloaded</th></tr></thead><tbody>
	<?php 
	
	// Loop over the records
	foreach ($result->getRecords() as $record) {
		
		// Get the url to the container field
		$url = urlencode($record->getField('container'));
		$url2 = urlencode($record->getField('containerRecap'));
		
		// Get the title of the record
		$title = $record->getField('title');
		$title2 = $record->getField('titleRecap');
		// Get the date of the record
		$dated = $record->getField('dated');
		$billcode = $record->getField('bcode');
		$flagDownloaded = $record->getField('flagDownloaded');
		if($flagDownloaded == 1){
		$chkds = ' checked="checked"';
		} else { 
		$chkds = ' data-check="1"';
		}
		$recordId = $record->getRecordId();
		
		// Show a link to the record
		echo('<tr><td id="tleft"> <a href="img.php?-url=' . $url . '&-title=' . $title . '"> ' . $title .' / '.$billcode. '</a><br/></td><td>'.$dated.'</td>');
		
		echo('<td>');
		?>
		<button class="btndwn">
		<input class="checkDownload" type="checkbox" value="1" data-fmfield="flagDownloaded" data-fmrecid="<?php echo $recordId;?>" data-fmvalue="<?php echo $flagDownloaded;?>" <?php echo $chkds ?> />
		<a class="downloadsave" id="<?php echo $recordId;?>" href="#" class="btn-group-xs">Save</a>
		</button>
		<?php
		echo('</td></tr>');
	}
	?>
	</tbody></table>
	
	<form name="f1" action="setasdl.php" method="post" class="collapse">
	<input name="recid" type="hidden" value=""/>
	</form>

</div>
<?php } ?>
</div>
</div>

<script>
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
</script>