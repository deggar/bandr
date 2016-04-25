<?php
	
include('includes/session_start.php');

require_once('dbaccess.php');

$layout = $mlay.'_schedule';
$tbase = 'Vallarta';
// echo($layout);
// $layout = 'web_breakthru_storelist';
// echo($std);

if(empty($std)) {
	$startDate = strtotime('today');
	$endDate = strtotime('today + 1 week');
	
	$startdate= date('m/d/Y',$startDate);
	$enddate= date('m/d/Y',$endDate);
} else {
	$startdate= date('m/d/Y',strtotime($std));
	if(empty($etd)){
		$enddate = strtotime("+7 day", strtotime($startdate));
		$enddate = date('m/d/Y',$enddate);
	} else {
		$enddate = date('m/d/Y',strtotime($etd));
	}
}

$range = $startdate."...".$enddate;

// echo($range);

//CREATE A FIND REQUEST
$findRequest1 = $fm->newFindRequest($layout);

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('date', $range);
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('inUseWith', $section);

//CREATE COMPOUND FIND COMMAND
$compoundFind = $fm->newCompoundFindCommand($layout);

//ADD SORT RULES

$compoundFind->addSortRule('date', 1);
$compoundFind->addSortRule($tbase.'Location::'.'Name', 2);

 
//ADD FIND REQUEST IN COMMAND
$compoundFind->add(1, $findRequest1);

//EXECUTE THE COMMAND
$result = $compoundFind->execute();

if (FileMaker::isError($result)) {
    $message = 'Error: ' . $result->message . '(' . $result->code . ')';
    echo('<div id="replace_data"><p>No Schedules found for date range: '.$range.'</p><!-- Button trigger modal -->
					<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Dates</button></div>');
    die();
}

$records = $result->getRecords();


$found_records_row = current($result->getRecords());

if( $result=="No records match the request" ) { 
echo '<div id="replace_data"><p>No Schedules found for date range: '.$range.'</p><!-- Button trigger modal -->
					<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Dates</button></div>';
exit();
}
?>  
  
<div id="replace_data">

	<table id="" width="90%" border="1" class="table1 tablehead-fixed table-bordered">
		<thead>
			<tr>
				<th colspan="3">
				</th>
				<th colspan="3">
					Schedules for dates:  <?php echo($range); ?>
				</th>
				<th colspan="2">
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Dates</button>
				</th>
			</tr>
			<tr>
				<th width="10%">Store</th>
				<th width="6%">Date</th>
				<th width="4%">Store #</th>
				<th width="10%">City, State</th>
				<th width="5%">Day</th>
				<th width="5%">Start Time</th>
				<th width="5%">End Time</th>
				<th width="13%">Demonstator</th>
			</tr>
		</thead>

	</table>
	<table id="" width="100%" border="1" class="table1 table-bordered tablebody">
		<thead>
			<tr>
				<th width="10%"></th>
				<th width="6%"></th>
				<th width="4%"></th>
				<th width="10%"></th>
				<th width="5%"></th>
				<th width="5%"></th>
				<th width="5%"></th>
				<th width="13%"></th>
			</tr>
		</thead>

      <tbody>
      
      <?php foreach($result->getRecords() as $found_records_row){ ?>
      <tr>

		  <td>
		    <?php echo $found_records_row->getField($tbase.'Location::Name'); ?>
		    </td>
		  <td>
		    <?php echo $found_records_row->getField('date'); 
			$dy = strtotime($found_records_row->getField('date'));
			$dayDis= date('l',$dy);
			?>
		    </td>
		  <td>
		    <a href="storerecap.php?uidLocation=<?php echo $found_records_row->getField('UIDlocation'); ?><?php echo "&v=".$terr."&w=".$interval."&subt=".$subt;?>"><?php echo $found_records_row->getField($tbase.'Location::StoreNum'); ?></a>
		    </td>
		  <td>
		    <?php echo $found_records_row->getField($tbase.'Location::City'); ?>, <?php echo $found_records_row->getField($tbase.'Location::State'); ?>
		    </td>
		  <td>
		    <?php echo $dayDis; ?>
		    </td>
		  <td>
		    <?php
			 echo date("g:i a", strtotime($found_records_row->getField('timeStart')) );
			 //echo $found_records_row->getField('timeStart'); ?>
		    </td>
		  <td>
		    <?php echo date("g:i a", strtotime($found_records_row->getField('timeEnd')) );
			//echo $found_records_row->getField('timeEnd'); ?>
		    </td>
		  <td>
		    <a href="demonstratorrecap.php?uidDemonstrator=<?php echo $found_records_row->getField('UIDrep'); ?>&w=Week"><?php echo $found_records_row->getField('rep'); ?></a>
		    </td>

        </tr>
		  <?php } ?>
        


	  </tbody>

  
	</table>
   
   </div>