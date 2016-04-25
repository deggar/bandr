<?php
	
include('includes/session_start.php');

require_once('dbaccess.php');

$layout = $mlay.'_recap';
// $tbase = 'Vallarta';
$tbase = 'Vallarta';
// echo($layout);
// $layout = 'web_breakthru_storelist';

//CREATE A FIND REQUEST
$findRequest1 = $fm->newFindRequest($layout);

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('formSent', '1');

/*
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion($tbase.'Location::Region', $terr);

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion($tbase.'Location::Territory', $subt);
*/

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion($tbase.'ShowSchedule::date', $range);
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion($tbase.'ShowSchedule::inUseWith', $section);
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion($tbase.'Location::StoreNum', $storenumber);
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion($tbase.'Location::StoreName', $storename);
//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion($tbase.'ShowSchedule::rep', $demonstrator);

//CREATE COMPOUND FIND COMMAND
$compoundFind = $fm->newCompoundFindCommand($layout);

//ADD SORT RULES

$compoundFind->addSortRule($tbase.'ShowSchedule::rep', 1);
$compoundFind->addSortRule('UIDRep', 2);
$compoundFind->addSortRule($tbase.'Location::StoreName', 3);
$compoundFind->addSortRule($tbase.'Location::StoreNum', 4);
$compoundFind->addSortRule('UIDLocation',5,FILEMAKER_SORT_ASCEND);

 
//ADD FIND REQUEST IN COMMAND
$compoundFind->add(1, $findRequest1);

//EXECUTE THE COMMAND
$result = $compoundFind->execute();

if (FileMaker::isError($result)) {
    $message = 'Error: ' . $result->message . '(' . $result->code . ')';
    $searchMessage = '';
    echo('<div id="replace_data"><p>No recaps found</p><p>For Dates: '.$range.' Message: '.$message.'</p><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Search</button></div>');
    die();
}

$records = $result->getRecords();

$found = $result->getFoundSetCount();

$title = $found.' Recaps';
if(!empty($demonstrator)){
	$title .=' of Demonstrator '.$demonstrator;
}
if(!empty($storename)){
	$title .=' for Store \''.$storename.'\'';
}
if(!empty($storenumber)){
	$title .=' #'.$storenumber;
}
$title .= ' for dates: '.$range;

$found_records_row = current($result->getRecords());

if( $result=="No records match the request" ) { 
echo '<div id="replace_data"><p>No recaps found</p><p>For Dates: '.$range.'[no recaps]</p><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Search</button></div>';
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
					<?php echo($title); ?>
				</th>
				<th colspan="2">
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#datesearch">Search</button>
				</th>
			</tr>
			<tr>
				<th width="10%" colspan="2">Name</th>
				<th width="6%"># Stores</th>
				<th width="6%"># Demos</th>
				<th width="6%" class="info">Ave # Customers</th>
				<th width="6%">Ave # Coupons</th>
				<th width="6%">Total Customers</th>
				<th width="6%">Total Coupons</th>
			</tr>
		</thead>

	</table>
	<table id="" width="100%" border="1" class="table1 table-bordered tablebody">
		<thead>
			<tr>
				<th width="10%" colspan="2"></th>
				<th width="6%"></th>
				<th width="6%"></th>
				<th width="6%" class="info"></th>
				<th width="6%"></th>
				<th width="6%"></th>
				<th width="6%"></th>
			</tr>
		</thead>

      <tbody>
      
<?php
$rep = "";
$loc = "";
$cntLoc = 0;

foreach($result->getRecords() as $found_records_row){ 
	

	if($rep != $found_records_row->getField($tbase.'ShowSchedule::rep') ){
		If(!empty($rep)){
				$a[] = '<tr><td>'.$rep.' <td id="'.$ba.'" class="open-intro">show</td><td id="'.$ba.'close" class="close-intro">hide</td><td>'.$cntLoc.'</td><td>'.$cntDemo.'</td>'.$rep_1.$detail;
		}
		$rep = $found_records_row->getField($tbase.'ShowSchedule::rep');
		$ba =  $found_records_row->getField($tbase.'ShowSchedule::UIDrep');
		$detail = "";
		$cntDemo = $found_records_row->getField('count_DemoByRep');
// 		$cntLoc = $found_records_row->getField('count_DemoByLocation');
		$dcount = 0;
		$cntLoc = 0;
		
	}
	if($loc != $found_records_row->getField('UIDLocation')){
		$loc = $found_records_row->getField('UIDLocation');
		$cntLoc += 1;
	}
	
	    // Get the time records related to this associate
    $prodRecords = $found_records_row->getRelatedSet('naRecapProduct');
    
    // Display the time records in a separate table

	
	$dcount += 1;
	$detail .= '<tr id="" class="recapinfo '.$ba.'detail" ><td class="tdstore" colspan="2"><span class="badge">'.$dcount.'</span> <span>'.$found_records_row->getField('ActualDateWorked').' <br> '.$found_records_row->getField($tbase.'Location::Name').'</span></td><td colspan="6"><table class="table table1 table2 table-condensed">'
	.'<tr>'
	.'<td>Demo Traffic: <strong>'.$found_records_row->getField('N01_DemoBusy').'</strong></td>'
	.'<td>Demo Placement: <strong>'.$found_records_row->getField('N02_DemoPlacement').'</strong></td>'
	.'<td>Other Demos: <strong>'.$found_records_row->getField('OtherDemosInStore').'</strong></td>'
	.'<td>Weather: <strong>'.$found_records_row->getField('WeatherDuringDemo').'</strong></td>'
	.'</tr><tr>'
	.'<td>Customers Sampled: <strong>'.$found_records_row->getField('N05_CustomersSampled').'</strong></td>'
	.'<td>Coupons Distributed: <strong>'.$found_records_row->getField('N06_CouponsDist').'</strong></td>'
	.'<td colspan="2">Manager: <strong>'.$found_records_row->getField('managerNameFirst').' '.$found_records_row->getField('managerNameLast').'</strong></td>'
	.'</tr><tr>'
	.'<td colspan="4">Comments: <strong>'.$found_records_row->getField('CustComment01').'</strong></td>'
	.'</tr></table>'
	.'<table class="table table1 table-condensed table-bordered">'
    .'<tr>'
    .'<th>Product</th>'
    .'<th>Product ID</th>'
    .'<th>Samples</th>'
    .'<th>Beg Inv</th>'
    .'<th>Sold</th>'
    .'<th>End Inv</th>'
    .'<th>Reg Price</th>'
    .'<th>Sale Price</th>'
    .'</tr>';
    foreach ($prodRecords as $prodRecord) {
        $detail .= '<tr>'
        .'<td>'.$prodRecord->getField('naRecapProduct::ProductName').'</td>'
        .'<td>'.$prodRecord->getField('naRecapProduct::ProductID').'</td>'
        .'<td>'.$prodRecord->getField('naRecapProduct::QuantitySamples').'</td>'
        .'<td>'.$prodRecord->getField('naRecapProduct::ProductBeginningInventory').'</td>'
        .'<td>'.$prodRecord->getField('naRecapProduct::ProductUnitsSold').'</td>'
        .'<td>'.$prodRecord->getField('naRecapProduct::ProductEndingInventory').'</td>'
        .'<td>'.$prodRecord->getField('naRecapProduct::ProductRegularPrice').'</td>'
        .'<td>'.$prodRecord->getField('naRecapProduct::ProductSalePrice').'</td>'
        .'</tr>';
    }
    $detail .= '</table>'
	.'</td></tr>';
	

	$rep_1 = "<td>".round($found_records_row->getField('repAvgCustomers'),0)."</td>"
."<td>".round($found_records_row->getField('repAvgCouponsDist'),0)."</td>"
."<td>".$found_records_row->getField('repTotalCustomers')."</td>"
."<td>".$found_records_row->getField('repTotalCouponsDist')."</td>"
."</tr>";


}


$a[] = '<tr>><td>'.$rep.' <td id="'.$ba.'" class="btn btn-xs open-intro">show</td><td id="'.$ba.'close" class="btn btn-xs close-intro">hide</td><td>'.$cntLoc.'</td><td>'.$cntDemo.'</td>'.$rep_1.$detail;


$z = count($a);
?>
                  
                  
      <?php
	  for ($x=0; $x<=$z; $x++)
	    {
		    echo $a[$x];
			echo "\n";
    	} 

	  ?>

   
</div>

<script>
	$('.recapinfo').hide();
	$('.open-intro').click(function() { 
		var theID = this.id;
		console.log(theID);
        $('.'+theID+'detail').slideDown();
        $('#'+theID+'close').show();
        $('#'+theID).hide();
    });
    $('.close-intro').click(function() {
        var theID = this.id;
        theID = theID.replace("close", "");
        $('.'+theID+'detail').slideUp();
        $('#'+theID+'close').hide();
        $('#'+theID).show();
    });
    $('.close-intro').hide();
	</script>