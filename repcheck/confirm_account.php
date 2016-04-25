<?php 
// Security
require_once ('dbaccess.php');
require_once ('FileMaker.php');

$token = $_REQUEST['token'];


//create the FileMaker Object
// $fm = new FileMaker();

//Specify the FileMaker database
// $fm->setProperty('database', 'Flair_App');
//Specify the Host
// $fm->setProperty('hostspec', 'http://50.240.31.157'); //temporarily hosted on local server
    
// $fm->setProperty('username', 'php');
// $fm->setProperty('password', 'php');



$request = $fm->newFindCommand('webuser');
// Check for User Name Account

$request->addFindCriterion('token', $_REQUEST['token']);
// Check for token


$result = $request->execute();

$continue = 0;

if(FileMaker::isError($result)) {
	
	$message = "FileMaker Error: ".$result->getMessage();
	$alertLabel = "Email Not Confirmed";
	$alerttxt = "There was an error or the link was incomplete, please try again.<br>If you continue to have trouble contact Kara. ".$message;
} else {
/* 	set confirm flag */

	$newRecord = current($result->getRecords());

	$recID = $newRecord->getRecordID();

	$passwordnew = $newRecord->getField('Password');
	$usernamenew = $newRecord->getField('UserName');
	$email = $newRecord->getField('Email');

	
	$request = $fm->newEditCommand('webuser' , $recID);
	$request->setField('EmailVerification_Flag' , '1' );
	$result = $request->execute();

	if(FileMaker::isError($result)) {
		$continue = 0;
		$message = "FileMaker Error: ".$result->getMessage();
		$alertLabel = "Email Not Confirmed";
		$alerttxt = "There was an error loading the account, please try again.<br>If you continue to have trouble contact Nichols and Associates.";
		
	}else{ 
		$continue = 1;
	$messageint= "confirmed flag updated successfully.";
	$message = "Email confirmed";
	$alertLabel = "Email Is Confirmed";
	$alerttxt = "You email is confirmed and you are ready to set your password, or use the one provided below.<br><br>Here are your login information:<br><br>User Name: ".$email."<br>Password: ".$passwordnew."<br><br>When you are instructed to do so,<br> use this link to log in:<br><br><a href='http://storemind.com'>storemind</a>";
	}
}


?>
<!DOCTYPE html>

<html>
<head>
<!-- 	<link rel="stylesheet" type="text/css" href="../../css/skanska.css">	 -->
	<title>Login</title>
	<style type="text/css">
	.alert-box {
		color:#555;
		border-radius:10px;
		background-color: white;
		font-family: Tahoma,sans-serif;font-size:13px;
		padding: 10px 36px;
		margin: auto;
		width: 30%;
		border: 1px solid black;
		
	}
	.alert-box span {
		font-weight:bold;
		text-transform:uppercase;
	}
	.form-signin
	{
	    max-width: 330px;
	    padding: 15px;
	    margin: 0 auto;
	}
	.form-signin .form-signin-heading, .form-signin .checkbox
	{
	    margin-bottom: 10px;
	}
	.form-signin .checkbox
	{
	    font-weight: normal;
	}
	.form-signin .form-control
	{
	    position: relative;
	    font-size: 16px;
	    height: auto;
	    padding: 10px;
	    -webkit-box-sizing: border-box;
	    -moz-box-sizing: border-box;
	    box-sizing: border-box;
	}
	.form-signin .form-control:focus
	{
	    z-index: 2;
	}
	.form-signin input[type="text"]
	{
	    margin-bottom: -1px;
	    border-bottom-left-radius: 0;
	    border-bottom-right-radius: 0;
	}
	.form-signin input[type="password"]
	{
	    margin-bottom: 10px;
	    border-top-left-radius: 0;
	    border-top-right-radius: 0;
	}
	.account-wall
	{
	    margin-top: 20px;
	    margin-bottom: 20px;
	    padding: 40px 10px 20px 10px;
	    background-color: #f7f7f7;
	    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	}
	.login-title
	{
	    color: #555;
	    font-size: 18px;
	    font-weight: 400;
	    display: block;
	}
	.profile-img
	{
	    width: 96px;
	    height: 96px;
	    margin: 0 auto 10px;
	    display: block;
	    -moz-border-radius: 50%;
	    -webkit-border-radius: 50%;
	    border-radius: 50%;
	}
	.need-help
	{
	    margin-top: 10px;
	}
	.new-account
	{
	    display: block;
	    margin-top: 10px;
	}
	/* header */
	#header { 
		position: relative;
		height: 70px; 
		margin: 0; padding: 0;
		color: #808080; 		
	}
	#header h1#logo {
		position: absolute;	
		font: bold 3.9em "trebuchet MS", Arial, Tahoma, Sans-Serif;
		margin: 0; padding:0;
		color: #75A54B;
		letter-spacing: -2px;	
		border: none;	
		
		/* change the values of top and Left to adjust the position of the logo*/
		top: 0; left: 2px;		
	}
	#header h1#logo span {
		color: #198DC5;
	}
	#header h2#logo span {
		color: #198DC5;	
	}
	
	#header h2#slogan { 
		position: absolute;
		margin: 0; padding: 0;	
		font: bold 12px Arial, Tahoma, Sans-Serif;	
		text-transform: none;
		
		/* change the values of top and Left to adjust the position of the slogan*/
		top: 43px; left: 45px;
	}
	header rightcorner {
		position: absolute;
		top: 0px; right: 500px;
		padding: 0; margin: 0;
		border: none;
		background-color: transparent; 
	}
	#header img {
		background-color: transparent;
		border:none;
	    position: absolute;
	    top: 5px;
	    right: 5px;
	}


	</style>
	     <!--      jquery -->
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	
	<!-- 	local js file -->
	<script src="js/changepassword.js"></script>
</head>

<html>
	<body>
	<div id="header">
<!-- 	    <img src="images/winco.gif" alt="" width="100" height="50" /> -->
	    <h2 id="logo">storemind&#8482;<span></span></h2>
	    <h2 id="slogan"> </h2>
	</div>

	
	<br>
	
	
	<?php if($continue != 1){ ?>
		
		
		<article>
					<div id="alert" class="alert-box">
					<span><?php echo $alertLabel;?></span>
					<?php echo $alerttxt; ?>
					</div>
	</article>
	<br>
	<?php	exit();
	} ?>
	
	<div class="container">
	    <div class="row">
	        <div class="col-sm-6 col-md-4 col-md-offset-4">
	            
	            <div class="account-wall">
	                
<!-- 					<span><?php echo $alertLabel;?></span> -->
					<?php echo $alerttxt; ?>
					
	                

	                
	                
	            </div>
	            
	        </div>
	    </div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-6 center-block">
<!-- 			<h5 class="center-block">Change Password</h5> -->
			</div>
		</div>
		<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div id="sendform" data-fmrecid="<?php echo $recID; ?>"></div>
				<p class="text-center bg-info center-block">Use the form below to change your password.<br>Your password cannot be the same as your username.</p>
				<form method="post" id="passwordForm" action="confirm_check.php">
				<input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off">
				<div class="row">
				<div class="col-sm-6">
				<span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 4 Characters Long<br>
				<span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Uppercase Letter
				</div>
				<div class="col-sm-6">
				<span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Lowercase Letter<br>
				<span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Number
				</div>
				</div>
				<input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off">
				<div class="row">
				<div class="col-sm-12">
				<span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Passwords Match
				</div>
				</div>
				<input name="recid" type="hidden" value="<?php echo $recID; ?>">
				<input name="UserName" type="hidden" value="<?php echo $usernamenew; ?>">
				<input id="change" type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Changing Password..." value="Change Password">
				</form>
				</div><!--/col-sm-6-->
		</div><!--/row-->
	</div>
		
	</body>
</html>