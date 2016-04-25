<?php
	
include('includes/session_start.php');

?>
<html>
<head>

<title>BR BA Schedule</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">


</head>
<body>
<?php //include('includes/header.php'); ?>
<div class="container-fluid">
	<ol class="breadcrumb">
	<li><a href="#"></a><?php echo $name; ?></li>
</ol>

<div id="container">
	<div id="replace_data">
	</div>
</div>

<?php include('includes/footer.php'); ?>  
<script type="text/javascript" src="js/ba_sched.js"></script>
    
</body>
</html>