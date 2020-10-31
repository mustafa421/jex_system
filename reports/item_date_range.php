<?php session_start(); ?>
<html>
<head>
<SCRIPT LANGUAGE="JavaScript">
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=300,left = 362,top = 234');");
}

</script>
</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);


if(!$sec->isLoggedIn())
{
    header ("location: ../login.php");
    exit();
}
if(isset($_POST['month1']) and isset($_POST['selected_item']))
{
	$selected_item=$_POST['selected_item'];
	$date_range=$_POST['date_range'];
	$dates=explode(':',$date_range);

	$month1=$_POST['month1'];
	$day1=$_POST['day1'];
	$year1=$_POST['year1'];
	$month2=$_POST['month2'];
	$day2=$_POST['day2'];
	$year2=$_POST['year2'];
	
	$date1=date("$year1-$month1-$day1");
	$date2=date("$year2-$month2-$day2");
}



$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

$display->displayTitle("$cfg_company $lang->itemReportDateRange");

$tableheaders=array("$lang->date","$lang->totalCostofItemsWithOutTax");
$display->displayTotalsReport($cfg_tableprefix,'articlecostreport',$tableheaders,$date1,$date2,'id',"$selected_item");
?>



</body>
</html> 