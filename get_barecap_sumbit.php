<?php
	
include('includes/session_start.php');

require_once('dbaccess.php');
$recID = $_REQUEST['recid'];
$layout = $mlay.'_recap_enter';
$tbase = 'Vallarta';
// echo('recap: '.$recapUID);
// $layout = 'web_breakthru_storelist';


$request = $fm->newEditCommand($layout , $recID);
$request->setField($tbase.'ReportEventForm::formSent' , '1' );
$result = $request->execute();

if(FileMaker::isError($result)) {
	$continue = 0;
	$message = "FileMaker Error: ".$result->getMessage();
	$alertLabel = "Recap Not Submitted";
	$alerttxt = "There was an error saving the recap, please try again.<br>If you continue to have trouble contact Nichols and Associates.";
	
}else{ 
	$continue = 1;
$messageint= "confirmed flag updated successfully.";
$message = "Email confirmed";
$alertLabel = "Recap has been Submitted";
$alerttxt = "The Recap has been submitted, when you are ready you can return to your schedule</a>";
}


$records = $result->getRecords();


$found_records_row = current($result->getRecords());

$recordId = $records[0]->getRecordId();

if( $result=="No records match the request" ) { 
echo '<div id="replace_data"><p>No Recap found</p></div>';
exit();
}
?>  
  
<div id="replace_data">

<!-- recap starts -->
<div class="container-fluid">
	
	<ol class="breadcrumb">
		<li><a href="#"></a><?php echo $found_records_row->getField($tbase.'ShowSchedule::rep'); ?></li>
		<li><a href="#">Store #<?php echo $found_records_row->getField($tbase.'Location::StoreNum'); ?></a></li>
		<li class="active"><?php echo $found_records_row->getField($tbase.'ShowSchedule::date'); ?></li>
	</ol>

	<h3>Recap Form</h3>

	<div class="panel panel-default">
		<div class="panel-heading">Rep: <?php echo $found_records_row->getField($tbase.'ShowSchedule::rep'); ?></div>
		<div class="panel-body">
	Store # <?php echo $found_records_row->getField($tbase.'Location::StoreNum'); ?></br>
	<?php echo $found_records_row->getField($tbase.'Location::City'); ?>, <?php echo $found_records_row->getField($tbase.'Location::State'); ?>
			<ul class="list-inline">
				<li>Demo Date</li>
				<li><?php echo $found_records_row->getField($tbase.'ShowSchedule::date'); ?></li>
			</ul>
		</div>
	</div>

<div class="row">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo($alertLabel); ?></div>
		<div class="panel-body"><?php echo($alerttxt); ?></div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 clear">
	<p class="bg-info"> </p>
</div>
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 clear">
	<p class="bg-info"> </p>
	<p> </p>
</div>
</div>  <!-- row -->



</div>  <!-- container-fluid -->





   
</div>










