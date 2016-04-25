<?php
	
include('includes/session_start.php');

require_once('dbaccess.php');

$layout = $mlay.'_storelist';
echo($layout);
// $layout = 'web_breakthru_storelist';

//CREATE A FIND REQUEST
$findRequest1 = $fm->newFindRequest($layout);

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('inUseWith', $section);

//ADD FIND CRITERION IN REQUEST
// $findRequest1->addFindCriterion('Territory', $subt);

/*
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('BreakThruShowSchedule::date', $range);
*/


// echo('made it here');




//CREATE COMPOUND FIND COMMAND
$compoundFind = $fm->newCompoundFindCommand($layout);

//ADD SORT RULES

$compoundFind->addSortRule('StoreName', 1);
$compoundFind->addSortRule('StoreNum', 2);

 
//ADD FIND REQUEST IN COMMAND
$compoundFind->add(1, $findRequest1);

// echo('made it to pre result');

//EXECUTE THE COMMAND
$result = $compoundFind->execute();

if (FileMaker::isError($result)) {
    $message = 'Error: ' . $result->message . '(' . $result->code . ')';
    echo('<div id="replace_data"><p>No Stores found</p></div>');
    die();
}

$records = $result->getRecords();


$found_records_row = current($result->getRecords());

if( $result=="No records match the request" ) { 
echo '<div id="replace_data"><p>No Stores found</p></div>';
exit();
}
?>  
  
<div id="replace_data">

	<table id="" width="90%" border="1" class="table1 tablehead-fixed table-bordered">
		<thead>
			<tr>
				<th colspan="4">
					List of Stores
				</th>
			</tr>

			<tr>
			<th width="6%">Store #</th>
			<th width="8%">Store</th>
			<th width="8%">Address</th>
			<th width="15%">City, State</th>
			</tr>
		</thead>
	</table>
	<table id="" width="100%" border="1" class="table1 table-bordered tablebody">
		<thead>
			<tr>
			<th width="6%"></th>
			<th width="8%"></th>
			<th width="8%"></th>
			<th width="15%"></th>
			</tr>
		</thead>

	<tbody>

      <?php foreach($result->getRecords() as $found_records_row){ ?>
	<tr>
		<td>
			<a href="storerecap.php?uidLocation=<?php echo $found_records_row->getField('ReferenceUID'); ?>"><?php echo $found_records_row->getField('StoreNum'); ?></a>
		</td>
		<td>
			<?php echo $found_records_row->getField('StoreName'); ?>
		</td>
		
		<td>
			<?php echo $found_records_row->getField('AddressStreet'); ?>
		</td>
		<td>
			<?php echo $found_records_row->getField('City'); ?>, <?php echo $found_records_row->getField('State'); ?>
		</td>
		
    </tr>
		  <?php } ?>
        


	  </tbody>
  
	</table>
   
   </div>