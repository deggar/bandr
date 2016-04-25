<?php
session_start();

$section = 'bandr';
$mlay = 'web_bandr';
$tbase = 'Vallarta';

date_default_timezone_set('America/Los_Angeles');
$checkEndDate = mktime(0,0,0,date("m"),date("d")-100,date("Y"));
$checkStartDate = mktime(0,0,0,date("m"),date("d")+0,date("Y"));
$today = date('m/d/Y');
$checkEndDate= date('m/d/Y',$checkEndDate);
$checkStartDate= date('m/d/Y',$checkStartDate);
$theFile = basename($_SERVER["SCRIPT_FILENAME"], '.php');


$username = $_SESSION['UserName'];
$portal = $_SESSION['Portal'] ;
$area = $_SESSION['Area'] ;
$region = $_SESSION['Region'] ;
$repUID = $_SESSION['UID'] ;
$repFLAG = $_SESSION['REP'] ;
$name = $_SESSION['Name'];

// $_SESSION['UserName'] = 'TestGuy';
// $repFLAG = 1;
// $name = 'TestGuy';

$terr = $_REQUEST["v"]; //region
$interval = $_REQUEST["w"];
$subt = $_REQUEST["subt"]; //territory
$std = $_REQUEST["startdate"];
$etd = $_REQUEST["enddate"];
$ba = $_REQUEST['ba'];
$search = $_REQUEST['search'];
$downloaded = $_REQUEST['downloaded'];
$unpaid = $_REQUEST['unpaid'];
$recapUID = $_REQUEST['recapUID'];

if(isset($_SESSION['UserName']))  {
	if($repFLAG == 1 && $theFile != 'ba_sched')  {
// 		header("Location: ba_sched.php");
	}
} else {
	header("Location: ../index.php");
}

//use for program recap listing
if(isset($_REQUEST['uidProgram'])){
	$uidProgram = $_REQUEST['uidProgram'];
	$_SESSION['uidProgram'] = $uidProgram;
} elseif(isset($_SESSION['uidProgram'])) {
	$uidProgram = $_SESSION['uidProgram'];
} else {
	$uidProgram = "";
	$_SESSION['uidProgram'] = $uidProgram;
}

if(isset($_REQUEST['storename'])){
	$storename = $_REQUEST['storename'];
	$_SESSION['storename'] = $storename;
} elseif(isset($_SESSION['storename'])) {
	$storename = $_SESSION['storename'];
} else {
	$storename = "";
	$_SESSION['storename'] = $storename;
}

if(isset($_REQUEST['storenumber'])){
	$storenumber = $_REQUEST['storenumber'];
	$_SESSION['storenumber'] = $storenumber;
} elseif(isset($_SESSION['storenumber'])) {
	$storenumber = $_SESSION['storenumber'];
} else {
	$storenumber = "";
	$_SESSION['storename'] = $storenumber;
}

if(isset($_REQUEST['demonstrator'])){
	$demonstrator = $_REQUEST['demonstrator'];
	$_SESSION['demonstrator'] = $demonstrator;
} elseif(isset($_SESSION['demonstrator'])) {
	$demonstrator = $_SESSION['demonstrator'];
} else {
	$demonstrator = "";
	$_SESSION['demonstrator'] = $demonstrator;
}

//use for store recap listing
if(isset($_REQUEST['uidLocation'])){
	$uidLocation = $_REQUEST['uidLocation'];
	$_SESSION['uidLocation'] = $uidLocation;
} elseif(isset($_SESSION['uidLocation'])) {
	$uidLocation = $_SESSION['uidLocation'];
} else {
	$uidLocation = "";
	$_SESSION['uidLocation'] = $uidLocation;
}

//use for demonstrator recap listing
if(isset($_REQUEST['uidDemonstrator'])){
	$uidDemonstrator = $_REQUEST['uidDemonstrator'];
	$_SESSION['uidDemonstrator'] = $uidDemonstrator;
} elseif(isset($_SESSION['uidDemonstrator'])) {
	$uidDemonstrator = $_SESSION['uidDemonstrator'];
} else {
	$uidDemonstrator = "";
	$_SESSION['uidDemonstrator'] = $uidDemonstrator;
}

// remove later
if (empty($terr) or $terr=="National") {$terr = "*";}
if (empty($interval) ) {$interval = "Week";}
if (empty($subt) or $subt=="All" or $terr=="National") {$subt = "*";}

if (!empty($area) and $region != "National") {
	$terr = $region;
	$subt = $area;
}

if (empty($area) and $region != "National") {
	$terr = $region;
}


$endDate = strtotime('last Sunday');
if($interval=="Week"){
	$startDate = strtotime('last Sunday - 1 week + 1 day');
	//$pstartDate = strtotime('last Sunday - 1 week');
	}
if($interval=="Month"){
	$startDate = strtotime('last Sunday - 4 week + 1 day');
	}
if($interval=="Quarter"){
	$startDate = strtotime('last Sunday - 13 week + 1 day');
	}
if($interval=="YTD"){
	$startDate = strtotime('first day of January');
	}

if(!empty($std)) {
	$startDate = strtotime($std);
	$endDate = strtotime($etd);
} else {
	$endDate = strtotime($today);
	$startDate = strtotime('last Sunday - 4 week + 1 day');
}

$startdate= date('m/d/Y',$startDate);
$enddate= date('m/d/Y',$endDate);
	
$range = $startdate.'...'.$enddate;
If(empty($pstartDate)){
	$prange = $range;
} else {
	$prange = date('m/d/Y',$pstartDate).'...'.$enddate;
}
set_time_limit(0);


?>
