<?php
	
include('includes/session_start.php');

require_once('dbaccess.php');

$layout = $mlay.'_recap_enter';
$tbase = 'Vallarta';
// echo('recap: '.$recapUID);
// $layout = 'web_breakthru_storelist';

//CREATE A FIND REQUEST
$findRequest1 = $fm->newFindRequest($layout);

//ADD FIND CRITERION IN REQUEST
// $findRequest1->addFindCriterion($tbase.'ReportEventForm::formSent', '=' );

//ADD FIND CRITERION IN REQUEST
// $findRequest1->addFindCriterion($tbase.'ReportEventForm::UIDRep', $repUID );

//ADD FIND CRITERION IN REQUEST
$findRequest1->addFindCriterion('ReferenceUID', $recapUID );

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
    echo('<div id="replace_data"><div class="container"><div class="alert alert-warning" role="alert"><p>The recap could not be found, please try again</p><p>Please Check back later.'.'recap: '.$recapUID.' name: '.$name.'<p> Message: '.$message.'</p></div></div></div>');
    die();
}

$records = $result->getRecords();


$found_records_row = current($result->getRecords());

$recordId = $records[0]->getRecordId();

if( $result=="No records match the request" ) { 
echo '<div id="replace_data"><p>No Events found</p><p>Region: '.$terr.' Territory: '.$subt.' For Dates: '.$range.'[no events]</p></div>';
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
	<strong><?php echo $found_records_row->getField($tbase.'Location::Name'); ?> </strong><br> <?php echo $found_records_row->getField($tbase.'Location::AddressStreet'); ?> <br><?php echo $found_records_row->getField($tbase.'Location::City'); ?>, <?php echo $found_records_row->getField($tbase.'Location::State'); ?> </br>
			<ul class="list-inline">
				<li>Demo Date</li>
				<li><?php echo $found_records_row->getField($tbase.'ShowSchedule::date'); ?></li>
			</ul>
		</div>
	</div>



<!-- precall ddate and time -->
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Pre-Call Information</div>
		<div class="panel-body">
		<ul class="list-group">
		    <li class="list-group-item">Pre-call Date: (example: 3/15/2016)
		    <input id="precalldate" name="precalldate" type="text" class="form-control" placeholder="" size="15" style="width: 200px;" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::precallDate'); ?>" data-fmfield="<?php echo $tbase; ?>ReportEventForm::precallDate" data-fmrecid="<?php echo $recordId; ?>">
		    </li>
		    <li class="list-group-item">Pre-Call Time: (example: 3:00pm)
		    <input name="precalltime" type="time" class="form-control" placeholder="" size="15" maxlength="15" style="width: 200px;" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::precallTime'); ?>" data-fmfield="<?php echo $tbase; ?>ReportEventForm::precallTime" data-fmrecid="<?php echo $recordId; ?>">
		    </li>
		    <li class="list-group-item">Pre-Call with Manager: (Manager Name)
		    <input class="form-control" name="precallwith" type="text" class="form-control" placeholder="" size="15" maxlength="15" style="width: 200px;" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::precallWith'); ?>" data-fmfield="<?php echo $tbase; ?>ReportEventForm::precallWith" data-fmrecid="<?php echo $recordId; ?>">
		    </li>
		</ul>
		</div>
	</div>
</div>

<!--What was the Manager first and last name? -->
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Enter the Manager's first and last name</div>
		<div class="panel-body">
		<div class="col-md-6">
			<input id="f3" type="text" name="managerNameFirst" placeholder="First Name" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::managerNameFirst'); ?>" required data-fmfield="<?php echo $tbase; ?>ReportEventForm::managerNameFirst" data-fmrecid="<?php echo $recordId; ?>">
		</div>
		<div class="col-md-6">
			<input id="f3" type="text" name="managerNameLast" placeholder="First Name" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::managerNameLast'); ?>" required data-fmfield="<?php echo $tbase; ?>ReportEventForm::managerNameLast" data-fmrecid="<?php echo $recordId; ?>">
		</div>
		</div>
	</div>
</div>

<!-- Actual Date and time of demo-->
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Actual Demo Date and Time</div>
		<div class="panel-body">
		<ul class="list-group">
		    <li class="list-group-item">Demo Date: (example: 3/15/2016)
		    <input id="ActualDateWorked" name="ActualDateWorked" type="text" class="form-control" placeholder="" size="15" style="width: 200px;" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::ActualDateWorked'); ?>" data-fmfield="<?php echo $tbase; ?>ReportEventForm::ActualDateWorked" data-fmrecid="<?php echo $recordId; ?>">
		    </li>
		    <li class="list-group-item">Start Time: (example: 11:00am)
		    <input name="timeArrival" type="time" class="form-control" placeholder="" size="15" maxlength="15" style="width: 200px;" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::timeArrival'); ?>" data-fmfield="<?php echo $tbase; ?>ReportEventForm::timeArrival" data-fmrecid="<?php echo $recordId; ?>">
		    </li>
		    <li class="list-group-item">End Time: (example: 3:00pm)
		    <input class="form-control" name="timeDeparture" type="time" class="form-control" placeholder="" size="15" maxlength="15" style="width: 200px;" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::timeDeparture'); ?>" data-fmfield="<?php echo $tbase; ?>ReportEventForm::timeDeparture" data-fmrecid="<?php echo $recordId; ?>">
		    </li>
		</ul>
		</div>
	</div>
</div>

<!--How many Customers Sampled today? -->
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">How many Customers sampled today?</div>
		<div class="panel-body">
		
			<input id="f3" type="text" name="N05_CustomersSampled" placeholder="enter Quantity" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::N05_CustomersSampled'); ?>" required data-fmfield="<?php echo $tbase; ?>ReportEventForm::N05_CustomersSampled" data-fmrecid="<?php echo $recordId; ?>">
		
		</div>
	</div>
</div>



<!--How many Coupons distributed today? -->
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">How many Coupons were distributed today?</div>
		<div class="panel-body">
		
			<input id="f3" type="text" name="N06_CouponsDist" placeholder="enter Quantity" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::N06_CouponsDist'); ?>" required data-fmfield="<?php echo $tbase; ?>ReportEventForm::N06_CouponsDist" data-fmrecid="<?php echo $recordId; ?>">
		
		</div>
	</div>
</div>



<div class="clearfix"></div>

<div class="row">
	
		<?php // Get the time records related to this associate
			foreach ($records as $product) {
				$recId = $product->getRecordId();
				?>

<!--Product Info? -->
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Product: <? echo($product->getField('ProductID').' <span> <strong>'.$product->getField('ProductName')); ?></strong></span></div>
		<div class="panel-body">
		<label for="Price" class="col-md-6">Price</label>
			<input id="" type="text" name="Price" placeholder="" value="<?php echo $product->getField('ProductRegularPrice'); ?>" required data-fmfield="ProductRegularPrice" data-fmrecid="<?php echo $recId; ?>">
			<div class="clear"></div>
		<label for="BegInv" class="col-md-6">Beginning Inventory</label>
			<input id="" type="text" name="BegInv" placeholder="" value="<?php echo $product->getField('ProductBeginningInventory'); ?>" required data-fmfield="ProductBeginningInventory" data-fmrecid="<?php echo $recId; ?>">
			<div class="clear"></div>
		<label for="BegInv" class="col-md-6">Samples Used</label>
			<input id="" type="text" name="BegInv" placeholder="" value="<?php echo $product->getField('QuantitySamples'); ?>" required data-fmfield="QuantitySamples" data-fmrecid="<?php echo $recId; ?>" >
			<div class="clear"></div>
		<label for="BegInv" class="col-md-6">Ending Inventory</label>
			<input id="" type="text" name="BegInv" placeholder="" value="<?php echo $product->getField('ProductEndingInventory'); ?>" required data-fmfield="ProductEndingInventory" data-fmrecid="<?php echo $recId; ?>">
			<div class="clear"></div>
		<label for="BegInv" class="col-md-6">Units Sold</label>
			<input id="" type="text" name="BegInv" placeholder="" value="<?php echo $product->getField('ProductUnitsSold'); ?>" required data-fmfield="ProductUnitsSold" data-fmrecid="<?php echo $recId; ?>">
			<div class="clear"></div >
		
		</div>
	</div>
</div>

<?php } ?>

</div>  <!-- row -->

<div class="row">

	<!--Demo Location in store? -->
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Customer Comments</div>
			<div class="panel-body">
			
				<input class="form-control" id="n02" type="text" name="N02_DemoPlacement" placeholder="" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::CustComment01'); ?>" required data-fmfield="<?php echo $tbase; ?>ReportEventForm::CustComment01" data-fmrecid="<?php echo $recordId; ?>">
			
			</div>
		</div>
	</div>


</div>  <!-- row -->


<!--Demo Location in store? -->
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Where was your Demo located in the store?</div>
		<div class="panel-body">
		
			<input class="form-control" id="n02" type="text" name="N02_DemoPlacement" placeholder="" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::N02_DemoPlacement'); ?>" required data-fmfield="<?php echo $tbase; ?>ReportEventForm::N02_DemoPlacement" data-fmrecid="<?php echo $recordId; ?>">
		
		</div>
	</div>
</div>

<!--Other Demos in store? -->
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">What other Demos were in the store?</div>
		<div class="panel-body">
		
			<input class="form-control" id="n03" type="text" name="N02_DemoPlacement" placeholder="" value="<?php echo $found_records_row->getField($tbase.'ReportEventForm::OtherDemosInStore'); ?>" required data-fmfield="<?php echo $tbase; ?>ReportEventForm::OtherDemosInStore" data-fmrecid="<?php echo $recordId; ?>">
		
		</div>
	</div>
</div>




<!--How was the weather today? -->

<div class="col-md-6">
<div class="panel panel-default">
	<div class="panel-heading">How was the weather today?</div>
	<div class="panel-body">
		<select class="form-control" placeholder="Choose Weather type" name="WeatherDuringDemo" id="N01" data-fmfield="<?php echo $tbase; ?>ReportEventForm::WeatherDuringDemo" data-fmrecid="<?php echo $recordId; ?>">
			<option value=""></option>
		  <option value="Sunny" <?php if( $found_records_row->getField($tbase.'ReportEventForm::WeatherDuringDemo')=='Sunny'){ echo "selected";} ?> >Sunny</option>
		  <option value="Rainy" <?php if( $found_records_row->getField($tbase.'ReportEventForm::WeatherDuringDemo')=='Rainy'){ echo "selected";} ?>>Rainy</option>
		  <option value="Overcast" <?php if( $found_records_row->getField($tbase.'ReportEventForm::WeatherDuringDemo')=='Overcast'){ echo "selected";} ?>>Overcast</option>
		  <option value="Snow" <?php if( $found_records_row->getField($tbase.'ReportEventForm::WeatherDuringDemo')=='Snow'){ echo "selected";} ?>>Snow</option>
		</select>

	
	</div>
</div>
</div>



<!--How was the weather today? -->

<div class="col-md-6">
<div class="panel panel-default">
	<div class="panel-heading">How was the store traffic today?</div>
	<div class="panel-body">
		
		<select class="form-control" placeholder="Choose Weather type" name="N01_DemoBusy" id="N01" data-fmfield="<?php echo $tbase; ?>ReportEventForm::N01_DemoBusy" data-fmrecid="<?php echo $recordId; ?>">
			<option value=""></option>
		  <option value="Busy" <?php if( $found_records_row->getField($tbase.'ReportEventForm::N01_DemoBusy')=='Busy'){ echo "selected";} ?> >Busy</option>
		  <option value="Moderate" <?php if( $found_records_row->getField($tbase.'ReportEventForm::N01_DemoBusy')=='Moderate'){ echo "selected";} ?>>Moderte</option>
		  <option value="Slow" <?php if( $found_records_row->getField($tbase.'ReportEventForm::N01_DemoBusy')=='Slow'){ echo "selected";} ?>>Slow</option>
		</select>

	
	</div>
</div>
</div>



<?php $recp = trim($recordId," "); ?>




<div class="clearfix"></div>

<div class="col-md-12 clear">
	<div class="bg-info"><form method="get" class="form-inline" action="ba_recap_submit.php"><input name="recid" type="hidden" value="<?php echo $recp; ?>"><button class="btn btn-primary" type="submit">Submit Recap</button><span> <span><span> End of Recap </span></form></div>
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

<script>
	$('[data-fmfield]').on('blur',editTHIS);
	
	$( "#precalldate" ).datepicker({
		dateFormat: "mm/dd/yy",
		onSelect: editTHIS
	});
	$( "#ActualDateWorked" ).datepicker({
		dateFormat: "mm/dd/yy",
		onSelect: editTHIS
	});
</script>









