<?php
	
include('includes/session_start.php');

?>
<html>
<head>

<title>Program Report</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">


</head>
<body>
<?php include('includes/header.php'); ?>
<div id="container">
	<div id="replace_data">
	</div>
</div>

<?php include('includes/footer.php'); ?>  
<script type="text/javascript" src="js/programreport.js"></script>


<div id="datesearch" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Search</h4>
      </div>
      <div class="modal-body">
<!--         <p>Search Dates</p> -->
        <!-- new form -->
		<form class="" role="form" method="get" action="programreport.php">
			<div class="form-group">
				<label for="startdate">Start: </label>
				<input type="text" class="form-control" name="startdate" value="<?php echo $startdate; ?>">
			</div>
			<div class="form-group">
				<label for="enddate">End: </label>
				<input type="text" class="form-control" name="enddate" value="<?php echo $enddate; ?>" >
			</div>
			<input name="v" type="hidden" value="<? echo $terr; ?>" />
			<input name="subt" type="hidden" value="<? echo $subt; ?>" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<!--         <button type="button" class="btn btn-primary">Search</button> -->
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</body>
</html>