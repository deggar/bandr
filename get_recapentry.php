<?php require_once('Connections/biljac.php'); ?>
<?php
$found_records_find = $biljac->newFindCommand('webbiljacrecap');
$found_records_findCriterions = array('UID'=>$_REQUEST['UID'],);
foreach($found_records_findCriterions as $key=>$value) {
    $found_records_find->AddFindCriterion($key,$value);
}

fmsSetPage($found_records_find,'found_records',1); 

$found_records_result = $found_records_find->execute(); 

if(FileMaker::isError($found_records_result)) fmsTrapError($found_records_result,"error.php"); 

fmsSetLastPage($found_records_result,'found_records',1); 

$found_records_row = current($found_records_result->getRecords());

// $found_records__BiljacShowSchedule_portal = fmsRelatedRecord($found_records_row, 'BiljacShowSchedule');
// $found_records__BiljacLocation_portal = fmsRelatedRecord($found_records_row, 'BiljacLocation');
// $found_records__calc_portal = fmsRelatedRecord($found_records_row, 'calc');
 
 // FMStudio Pro - do not remove comment, needed for DreamWeaver support ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recap</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!--     <script type="text/javascript" src="js/bootstrap.js"></script> -->
<!--     <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script> -->
    <script type="text/javascript" src="js/livevalidation_standalone.compressed.js"></script>
    <script type="text/javascript" src="js/parsley.js"></script>
    <link rel="stylesheet" href="http://yandex.st/highlightjs/8.0/styles/default.min.css">
<script src="http://yandex.st/highlightjs/8.0/highlight.min.js"></script>
<script src="js/modernizr.custom.11707.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	
<style>
.LV_validation_message{
    font-weight:bold;
    margin:0 0 0 5px;
}

.LV_valid {
    color:#00CC00;
}
	
.LV_invalid {
    color:#CC0000;
}
    
.LV_valid_field,
input.LV_valid_field:hover, 
input.LV_valid_field:active,
textarea.LV_valid_field:hover, 
textarea.LV_valid_field:active {
    border: 1px solid #00CC00;
    float: left;
}
    
.LV_invalid_field, 
input.LV_invalid_field:hover, 
input.LV_invalid_field:active,
textarea.LV_invalid_field:hover, 
textarea.LV_invalid_field:active {
    border: 1px solid #CC0000;
}
	
	</style>
  </head>
  <body>
  <div class="container-fluid">
  <ol class="breadcrumb">
  <li><a href="#"></a><?php echo $found_records_row->getField('BiljacShowSchedule::rep'); ?></li>
  <li><a href="#">Store #<?php echo $found_records_row->getField('BiljacLocation::StoreNum'); ?></a></li>
  <li class="active"><?php echo $found_records_row->getField('BiljacShowSchedule::date'); ?></li>
  </ol>
  
  <h3>Selling Recap Form</h3>
    
    <div class="panel panel-default">
  <div class="panel-heading">BA: <?php echo $found_records_row->getField('BiljacShowSchedule::rep'); ?></div>
  <div class="panel-body">
    Store # <?php echo $found_records_row->getField('BiljacLocation::StoreNum'); ?></br>
    <?php echo $found_records_row->getField('BiljacLocation::City'); ?>, <?php echo $found_records_row->getField('BiljacLocation::State'); ?>
    <ul class="list-inline">
  <li>Demo Date</li>
  <li><?php echo $found_records_row->getField('BiljacShowSchedule::date'); ?></li>
</ul>
<li>Demo Type: <?php echo $found_records_row->getField('BiljacShowSchedule::demoType'); ?></li>
  </div>
</div>

<div class="bs-callout bs-callout-warning hidden">
            <h4>Oh snap!</h4>
            <p>This form seems far to be valid :(</p>
          </div>

          <div class="bs-callout bs-callout-info hidden">
            <h4>Yay!</h4>
            <p>Everything seems to be ok :)</p>
          </div>

<form id="demo-form" action="savedemo.php" method="post" target="_self" data-parsley-validate>
<input name="-recid" type="hidden" value="<?php echo $found_records_row->getRecordId(); ?>">
<!--Was the Demo busy enough to achieve goals today? -->


<div class="panel panel-default">
  <div class="panel-heading">Was the Demo busy enough to achieve goals today?</div>
  <div class="panel-body">

<div class="radio">
  <label>
  
    <input id="f2" type="radio" name="N01_DemoBusy" id="optionsRadios1" value="1" <?php if( $found_records_row->getField('N01_DemoBusy')==1){ echo "checked";} ?>>Yes</label>
</div>
<div class="radio-inline"> 
  <label>
    <input id="f2" type="radio" name="N01_DemoBusy" id="optionsRadios2" value="2" <?php if( $found_records_row->getField('N01_DemoBusy')==2){ echo "checked";} ?>>No</label>
</div>

</div>
</div>


<!--Where did you set up the event? -->
<div class="panel panel-default">
  <div class="panel-heading">Where did you set up the event? </div>
  <div class="panel-body">

<div class="radio">
<p>
  <label>
    <input type="radio" name="N02_DemoPlacement" id="optionsRadios1" value="1" <?php if( $found_records_row->getField('N02_DemoPlacement')==1){ echo "checked";} ?> required>
    Main Drive Aisle at FRONT 1/3 of store (PREFERRED)
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N02_DemoPlacement" id="optionsRadios2" value="2" <?php if( $found_records_row->getField('N02_DemoPlacement')==2){ echo "checked";} ?>>
    Main Drive Aisle MIDDLE 1/3 of store
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N02_DemoPlacement" id="optionsRadios2" value="3" <?php if( $found_records_row->getField('N02_DemoPlacement')==3){ echo "checked";} ?>>
    Main Drive Aisle  BACK 1/3 of store
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N02_DemoPlacement" id="optionsRadios2" value="4" <?php if( $found_records_row->getField('N02_DemoPlacement')==4){ echo "checked";} ?>>
    NO Display Allowed (if NO, please respond with comments below)
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N02_DemoPlacement" id="optionsRadios2" value="5" <?php if( $found_records_row->getField('N02_DemoPlacement')==5){ echo "checked";} ?>>
    Perimeter of store or Food Aisle (NOT PREFERRED)
    </label>
    </p>
</div>

<input type="text" class="form-control" name="N02_DemoPlacementComment" placeholder="Comments"value="<?php echo $found_records_row->getField('N02_DemoPlacementComment'); ?>">

</div>
</div>


<!--How many Compare Flyers did you hand out today? -->

<div class="panel panel-default">
  <div class="panel-heading">How many Compare Flyers did you hand out today?</div>
  <div class="panel-body">

<input id="f3" type="text" name="N03_CompareFlyerOut" placeholder="enter Quantity" value="<?php echo $found_records_row->getField('N03_CompareFlyerOut'); ?>" required>
				  <script type="text/javascript">
		            var f3 = new LiveValidation('f3');
		            f3.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
					f3.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		          </script>  


</div>
</div>


<!--Did you report a low inventory situation to Store Mgr? -->

<div class="panel panel-default">
  <div class="panel-heading">Did you report a low inventory situation to Store Mgr?</div>
  <div class="panel-body">

<div class="radio">
  <label>
    <input type="radio" name="N04_ReportLowInventory" id="optionsRadios1" value="1" <?php if( $found_records_row->getField('N04_ReportLowInventory')==1){ echo "checked";} ?> required>Yes</label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N04_ReportLowInventory" id="optionsRadios2" value="2" <?php if( $found_records_row->getField('N04_ReportLowInventory')==2){ echo "checked";} ?>>No, there were no inventory problems to report</label>
</div>

</div>
</div>

<!-- check for selling or sampling -->
    <? if ($found_records_row->getField('BiljacShowSchedule::demoType')=="Selling"){ ?>

<!-- Selling -->
<!-- How many customers did you speak with during your event  -->

<div class="panel panel-default">
  <div class="panel-heading">How many customers did you speak with during your event? </div>
  <div class="panel-body">

<div class="radio">
  <label>
    <input type="radio" name="N05_CustomersSpokenTo" id="optionsRadios1" value="1" <?php if( $found_records_row->getField('N05_CustomersSpokenTo')==1){ echo "checked";} ?>>
    Less than 15
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N05_CustomersSpokenTo" id="optionsRadios2" value="2" <?php if( $found_records_row->getField('N05_CustomersSpokenTo')==2){ echo "checked";} ?>>
    16 - 24
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N05_CustomersSpokenTo" id="optionsRadios2" value="3" <?php if( $found_records_row->getField('N05_CustomersSpokenTo')==3){ echo "checked";} ?>>
    25 -30
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N05_CustomersSpokenTo" id="optionsRadios2" value="4" <?php if( $found_records_row->getField('N05_CustomersSpokenTo')==4){ echo "checked";} ?>>
    31 or more
    </label>
</div>

</div>
</div>


    <? } else { ?>
    	<!-- Sampling -->


<!-- How many customers did you speak with during your event  -->

<div class="panel panel-default">
  <div class="panel-heading">How many customers did you speak with during your event? </div>
  <div class="panel-body">

<div class="radio">
  <label>
    <input type="radio" name="N05_CustomersSpokenTo" id="optionsRadios1" value="1" <?php if( $found_records_row->getField('N05_CustomersSpokenTo')==1){ echo "checked";} ?>>
    Less than 85
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N05_CustomersSpokenTo" id="optionsRadios2" value="2" <?php if( $found_records_row->getField('N05_CustomersSpokenTo')==2){ echo "checked";} ?>>
    85 - 99
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N05_CustomersSpokenTo" id="optionsRadios2" value="3" <?php if( $found_records_row->getField('N05_CustomersSpokenTo')==3){ echo "checked";} ?>>
    100 -130
    </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="N05_CustomersSpokenTo" id="optionsRadios2" value="4" <?php if( $found_records_row->getField('N05_CustomersSpokenTo')==4){ echo "checked";} ?>>
    131 or more
    </label>
</div>

</div>
</div>

<!--How many sample cups did you give out?  -->
<div class="panel panel-default">
  <div class="panel-heading">How many sample cups did you give out?</div>
  <div class="panel-body">

<input id="n06" type="number" class="form-control" name="N06_sampleCupsOut" placeholder="enter Quantity" value="<?php echo $found_records_row->getField('N06_sampleCupsOut'); ?>" >
<script type="text/javascript">
		    var n06 = new LiveValidation('n06');
		    n06.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			n06.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>

</div>
</div>


<!-- end Sampling -->

    <? } ?>




<!-- Bil-Jac Product Sales During Event -->

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Bil-Jac Product Sales During Event</h3>
  </div>
  <div class="panel-body">
    
    <p>Enter quantity of each size Bil-Jac Dry Dog Food sold during event in box below:</p>
    
    <!-- next Section -->
    <div class="row">
    
      <div class="form-group form-inline">
    <label for="N06A_foodBag04" class="col-sm-2 control-label">4 lb bag of food</label>
    <div class="col-sm-4">
      <input id="f6a" type="text" class="form-control" name="N06A_foodBag04" placeholder="Qty" size="6" width="50px">
		<script type="text/javascript">
		    var f6a = new LiveValidation('f6a');
		    f6a.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f6a.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  
  </div>

<div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">6 lb bag of food</label>
    <div class="col-sm-4">
      <input id="f6b" type="text" class="form-control" name="N06B_foodBag06" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f6b = new LiveValidation('f6b');
		    f6b.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f6b.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
  
  
      <div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">12 lb bag of food</label>
    <div class="col-sm-4">
      <input id="f6c" type="text" class="form-control" name="N06C_foodBag12" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f6c = new LiveValidation('f6c');
		    f6c.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f6c.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
      <div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">15 lb bag of food</label>
    <div class="col-sm-4">
      <input id="f6d" type="text" class="form-control" name="N06D_foodBag15" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f6d = new LiveValidation('f6d');
		    f6d.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f6d.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
      <div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">24 lb bag of food</label>
    <div class="col-sm-4">
      <input id="f6e" type="text" class="form-control" name="N06E_foodBag24" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f6e = new LiveValidation('f6e');
		    f6e.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f6e.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
      <div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">30 lb bag of food</label>
    <div class="col-sm-4">
      <input id="f6f" type="text" class="form-control" name="N06F_foodBag30" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f6f = new LiveValidation('f6f');
		    f6f.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f6f.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
    
    <!-- next Section -->
    
  </div>
</div>

<!-- trial -->

<div class="panel panel-default">
  <div class="panel-heading">
    Enter quantity of other Bil-Jac Product sold during event in box below(by size):
  </div>
  <div class="panel-body">
    
    
    <!-- next Section -->
    <div class="row">
    
      <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">1 lb Trial Size</label>
    <div class="col-sm-4">
      <input id="f7a" type="text" class="form-control" name="N07A_trialSize01" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f7a = new LiveValidation('f7a');
		    f7a.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f7a.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  
  </div>

<div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">3.5 oz Wet Dog Food</label>
    <div class="col-sm-4">
      <input id="f7b" type="text" class="form-control" name="N07B_foodWet" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f7b = new LiveValidation('f7b');
		    f7b.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f7b.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
  
    
    <!-- next Section -->
    
  </div>
</div>


<!-- Enter quantity of each size Bil-Jac Treat sold during event in box below: -->

<div class="panel panel-default">
  <div class="panel-heading">
    Enter quantity of each size Bil-Jac Treat sold during event in box below:
  </div>
  <div class="panel-body">
    
    <!-- next Section -->
    <div class="row">
    
      <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">4 oz Treats</label>
    <div class="col-sm-4">
      <input id="f8a" type="text" class="form-control" name="N08A_treats04" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f8a = new LiveValidation('f8a');
		    f8a.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f8a.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  
  </div>

<div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">10 oz Treats</label>
    <div class="col-sm-4">
      <input id="f8b" type="text" class="form-control" name="N08B_treats10" placeholder="Qty" size="6" width="50px">
            <script type="text/javascript">
		    var f8b = new LiveValidation('f8b');
		    f8b.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f8b.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
  
  
      <div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">16 oz Treats</label>
    <div class="col-sm-4">
      <input id="f8c" type="text" class="form-control" name="N08C_treats16" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f8c = new LiveValidation('f8c');
		    f8c.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f8c.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
      <div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">12 oz Bonus Treats</label>
    <div class="col-sm-4">
      <input id="f8d" type="text" class="form-control" name="N08D_treatsBonus12" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f8d = new LiveValidation('f8d');
		    f8d.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f8d.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
      <div class="row">
  <div class="form-group form-inline">
    <label for="inputEmail3" class="col-sm-2 control-label">20 oz Bonus Treats</label>
    <div class="col-sm-4">
      <input id="f8e" type="text" class="form-control" name="N08E_treatsBonus20" placeholder="Qty" size="6" width="50px">
      <script type="text/javascript">
		    var f8e = new LiveValidation('f8e');
		    f8e.add(Validate.Numericality, { minimum: 0, onlyInteger: true } );
			f8e.add(Validate.Presence, {failureMessage: "Cannot be empty, enter 0 if none"});
		</script>
    </div>
  </div>
  </div>
  
    
    <!-- next Section -->
    
  </div>
</div>

<!-- Is your next months schedule on the store calendar:  (1) YES   (0) NO -->

<div class="panel panel-default">
  <div class="panel-heading">Is your next months schedule on the store calendar?</div>
  <div class="panel-body">

<div class="radio-inline">
  <label>
    <input type="radio" name="N09_nextMonthOnCal" id="optionsRadios1" value="1" <?php if ($found_records_row->getField('N09_nextMonthOnCal')==1){ echo 'checked';} ?>>Yes</label>
</div>
<div class="radio-inline" style="vertical-align: none;">
  <label>
    <input type="radio" name="N09_nextMonthOnCal" id="optionsRadios2" value="0" <?php if ($found_records_row->getField('N09_nextMonthOnCal')==0){ echo 'checked';} ?>>No</label>
</div>

</div>
</div>


<!-- Please provide manager's name that you signed in/worked with today? Type Full Name  -->

<div class="panel panel-default">
  <div class="panel-heading">Please provide the PetSmart Manager’s name that you signed in/worked with today:</div>
  <div class="panel-body">

<input type="text" class="form-control" name="N10_managerName" placeholder="Enter Full Name" style="width: 300px;">

</div>
</div>

<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Invoice</div>
  <div class="panel-body">
    <p>Subcontractor Invoice for Event Date <?php echo $found_records_row->getField('BiljacShowSchedule::date'); ?></p>
  </div>

  <!-- List group -->
  <ul class="list-group">
    <li class="list-group-item">Your Name:
    <input type="text" class="form-control" name="invRepName" placeholder="Enter Your Full Name" size="12" style="width: 300px;">
    </li>
    <li class="list-group-item">Your Address:
      <textarea name="invRepAddress" rows="3" class="form-control" placeholder="Enter Address" style="width: 300px;"><?php echo $found_records_row->getField('invRepAddress'); ?></textarea>
    </li>
    <li class="list-group-item">Start Time: (example: 11:00am)
    <input type="time" class="form-control" name="timeArrival" placeholder="" size="15" style="width: 200px;">
    </li>
    <li class="list-group-item">End Time: (example: 3:00pm)
    <input name="timeDeparture" type="time" class="form-control" placeholder="" size="15" maxlength="15" style="width: 200px;">
    </li>
    <li class="list-group-item">Hours Worked: 
    <input type="text" class="form-control" name="hoursWorked" placeholder="" size="15" style="width: 150px;">
    </li>
    <li class="list-group-item">
        <label>
          <input id="repacc" type="checkbox" name="invRepAccepts" value="1" id="invRepAccepts_0" required> 
        Check this box to accept this as your invoice to Flair Events
        </label> 
        <script type="text/javascript">
        var repacc = new LiveValidation('repacc');
		repacc.add( Validate.Acceptance );
        </script>
        <br>

    </li>
  </ul>
</div>


<input name="Save" type="submit" class="btn btn-primary" onClick="confrim("click");">

<!--<span class="btn btn-default">validate</span>
 -->
 <div class="invalid-form-error-message"></div>

</form>


<!-- next Section -->

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--     <script src="https://code.jquery.com/jquery.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<!--     <script src="js/bootstrap.min.js"></script> -->
    
    </div>
    


<script type="text/javascript">
$(document).ready(function () {
	
  $.listen('parsley:form:validate', function () {
	  confirm("listen");
    validateFront();
  });

  $('#demo-form .btn').on('click', function () {
	confirm("validate btn");
    $('#demo-form').parsley().validate();
    validateFront();
  });
  

  var validateFront = function () {
    if (true === $('#demo-form').parsley().isValid()) {
      $('.bs-callout-info').removeClass('hidden');
      $('.bs-callout-warning').addClass('hidden');
	  confirm("yes");
    } else {
      $('.bs-callout-info').addClass('hidden');
      $('.bs-callout-warning').removeClass('hidden');
	  confirm("no");
    }
  };
});
</script>
    


  </body>
</html>