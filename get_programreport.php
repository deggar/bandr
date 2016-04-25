<?php
	
include('includes/session_start.php');

require_once('dbaccess.php');

$layout = $mlay.'_program';
// $tbase = 'Vallarta';
$tbase = 'Vallarta';
// echo($layout);
// $layout = 'web_breakthru_storelist';

//CREATE A FIND REQUEST
$findRequest1 = $fm->newFindRequest($layout);

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('Active', '1');
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('dateStart', $range);
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('inUseWith', $section);

//CREATE COMPOUND FIND COMMAND
$compoundFind = $fm->newCompoundFindCommand($layout);

//ADD SORT RULES
$compoundFind->addSortRule('dateStart',1,FILEMAKER_SORT_DESCEND);
 
//ADD FIND REQUEST IN COMMAND
$compoundFind->add(1, $findRequest1);

//EXECUTE THE COMMAND
$result = $compoundFind->execute();

if (FileMaker::isError($result)) {
    $message = 'Error: ' . $result->message . '(' . $result->code . ')';
    echo('<div id="replace_data"><p>No programs found</p><p>For Dates: '.$range.' Message: '.$message.'</p><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Search</button></div>');
    die();
}

$records = $result->getRecords();


$found_records_row = current($result->getRecords());

if( $result=="No records match the request" ) { 
echo '<div id="replace_data"><p>No programs found</p><p>For Dates: '.$range.'[no recaps]</p><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Search</button></div>';
exit();
}
?>  
  
<div id="replace_data">

	<table id="" width="90%" border="1" class="table1 tablehead-fixed table-bordered">
		<thead>
			<tr>
				<th colspan="2">
				</th>
				<th colspan="4">
					Programs for dates:  <?php echo($range); ?>
				</th>
				<th colspan="2">
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Search</button>
				</th>
			</tr>
			<tr>
				<th width="20%">Name</th>
				<th width="5%">Date Start</th>
				<th width="5%">Date End</th>
				<th width="10%" class="info">Product</th>
				<th width="5%"># Stores</th>
				<th width="5%">PO #</th>
				<th width="5%">Invoice #</th>
			</tr>
		</thead>

	</table>
	<table id="" width="100%" border="1" class="table1 table-bordered tablebody">
		<thead>
			<tr>
				<th width="20%"></th>
				<th width="5%"></th>
				<th width="5%"></th>
				<th width="10%" class="info"></th>
				<th width="5%"></th>
				<th width="5%"></th>
				<th width="5%"></th>
			</tr>
		</thead>

      <tbody>
      
<?php

foreach($result->getRecords() as $record){ 
	
	$name = $record->getField('Name');
	$programLink = 'programrecap.php?uidProgram='.$record->getField('UID');
	$dateStart = $record->getField('dateStart');
	$dateEnd = $record->getField('dateEnd');
	$product = $record->getField('Product');
	$storeNum = $record->getField('LocationCount');
	$po = $record->getField('BillingCode');
	$invoice = $record->getField('Program_Job::InvoiceNumber');
	
	$a[] = '<tr><td><a href="'.$programLink.'">'.$name.'</a></td><td>'.$dateStart.'</td><td>'.$dateEnd.'</td><td>'.$product.'</td><td>'.$storeNum.'</td><td>'.$po.'</td><td>'.$invoice.'</td></tr>';

}

$z = count($a);
?>
                  
                  
      <?php
	  for ($x=0; $x<=$z; $x++)
	    {
		    echo $a[$x];
			echo "\n";
    	} 

	  ?>

      </tbody>
	</table>
</div>

<script>

	</script>