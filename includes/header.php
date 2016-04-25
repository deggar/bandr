<div class="head">
<div id="header">
	<img src="images/logo_transparent_small.png" alt="" width="100" height="60" />
	<h2 id="logo">storemind&#8482;<span></span></h2>
	<h2 id="slogan"> </h2>
</div>
<div id="menu">
	<ul>
	  <li id="m1"><a href="index.php">Home</a></li>
	  <li id="m2"><a href="demoschedule.php<?php echo "?v=".$terr."&subt=".$subt;?>">Demo Schedule</a></li>
	  <li id="m3"><a href="storelist.php<?php echo "?v=".$terr."&subt=".$subt;?>">Store List</a></li>
	  <li id="m4"><a href="bareport.php<?php echo "?v=".$terr."&subt=".$subt;?>">Recap Reports</a></li>
	  <li id="m6"><a href="programreport.php">Programs</a></li>
	  <li id="m5"><a href="invoice_list.php<?php echo "?v=".$terr."&subt=".$subt;?>">Invoices</a></li>
	</ul>
</div>
<form id="fattr" name="f1" action="" method="get" target="_self" class="collapse">
	<input name="v" type="hidden" value="<?php echo $terr; ?>"/>
	<input name="w" type="hidden" value="<?php echo $interval; ?>" />
	<input name="subt" type="hidden" value="<?php echo $subt; ?>" />
	<input name="ba" type="hidden" value="" />
	<input name="startdate" type="hidden" value="<?php echo $startdate; ?>" />
	<input name="enddate" type="hidden" value="<?php echo $enddate; ?>" />
	<input name="UID" type="hidden" value=""/>
	<input name="search" type="hidden" value="<?php echo $search; ?>"/>
	<input name="downloaded" type="hidden" value="<?php echo $downloaded; ?>"/>
	<input name="unpaid" type="hidden" value="<?php echo $unpaid; ?>"/>
</form>
</div>

