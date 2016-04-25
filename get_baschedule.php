<?php
	
include('includes/session_start.php');

require_once('dbaccess.php');

$layout = $mlay.'_recap';
$tbase = 'Vallarta';
// echo($layout);
// $layout = 'web_breakthru_storelist';

//CREATE A FIND REQUEST
$findRequest1 = $fm->newFindRequest($layout);

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('formSent', '=');

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('UIDRep', $repUID);

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion($tbase.'ShowSchedule::date', '*');

//CREATE COMPOUND FIND COMMAND
$compoundFind = $fm->newCompoundFindCommand($layout);

//ADD SORT RULES

$compoundFind->addSortRule($tbase.'ShowSchedule::date', 1);
$compoundFind->addSortRule($tbase.'ShowSchedule::timeStart', 2);

 
//ADD FIND REQUEST IN COMMAND
$compoundFind->add(1, $findRequest1);

//EXECUTE THE COMMAND
$result = $compoundFind->execute();

if (FileMaker::isError($result)) {
    $message = 'Error: ' . $result->message . '(' . $result->code . ')';
    echo('<div id="replace_data"><div class="container"><div class="alert alert-warning" role="alert"><p>You have successfully logged in, but there are no events found for dates: '.$range.'</p><p>Please Check back after your next demo event.<p> Message: '.$message.'</p></div></div></div>');
    die();
}

$records = $result->getRecords();


$found_records_row = current($result->getRecords());

if( $result=="No records match the request" ) { 
echo '<div id="replace_data"><p>No Events found</p><p>Region: '.$terr.' Territory: '.$subt.' For Dates: '.$range.'[no events]</p></div>';
exit();
}
?>  
  
<div id="replace_data">

	<div class="panel panel-default">
		<div class="panel-heading">
		<h3>Demo Events</h3>
		</div>
		<div class="panel-body">
		
			<ul class="list-group">
			
			<?php foreach($result->getRecords() as $found_records_row){ ?>
			
			<li class="list-group-item">
			
			<?php if(strtotime($found_records_row->getField($tbase.'ShowSchedule::date')) <= strtotime($checkStartDate) and strtotime($found_records_row->getField($tbase.'ShowSchedule::date')) >= strtotime($checkEndDate) and $found_records_row->getField('formSent') <> 1 )  { ?>
			
			<span class="pull-right"> 
			<a class="btn btn-primary" href="ba_recap.php?recapUID=<?php echo $found_records_row->getField('UID'); ?>" >Enter Recap
			</a></span>
			
			<?php } ?>
			
			<strong><?php echo $found_records_row->getField($tbase.'Location::Name'); ?> </strong><br> <?php echo $found_records_row->getField($tbase.'Location::AddressStreet'); ?> <br><?php echo $found_records_row->getField($tbase.'Location::City'); ?>, <?php echo $found_records_row->getField($tbase.'Location::State'); ?> </br>
			<strong><?php echo $found_records_row->getField($tbase.'ShowSchedule::demoType'); ?></strong> Demo on <?php echo $found_records_row->getField($tbase.'ShowSchedule::date'); ?>
			</li>
			
			
			<?php } ?>
			</ul>
		
		</div>
	</div>
   
</div>