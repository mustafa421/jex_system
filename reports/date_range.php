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


	$userstable="$cfg_tableprefix".'users';
	$userid=$_SESSION['session_user_id'];
    $user_result = mysql_query("SELECT type FROM $userstable WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $usertype=$usertable_row['type'];


$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$cfg_company $lang->dateRangeReport");

if(isset($_POST['month1']))
{
	$month1=$_POST['month1'];
	$day1=$_POST['day1'];
	$year1=$_POST['year1'];
	$month2=$_POST['month2'];
	$day2=$_POST['day2'];
	$year2=$_POST['year2'];
	
	$date1=date("$year1-$month1-$day1");
	$date2=date("$year2-$month2-$day2");

}

if ($usertype=="Admin"){









$tableheaders=array("SaleID","$lang->date","$lang->customer","Item UPC","Item Name","$lang->itemsPurchased","$lang->paidWith","$lang->soldBy","Item Cost","Item Price","Tax","Sale Total","Profit");
$tablefields=array('id','date','customer_id','upc','item_id','quantity_purchased','paid_with','sold_by','item_buy_price','item_unit_price','item_total_tax','item_total_cost','itemprofit');



}else{






$tableheaders=array("SaleID","$lang->date","$lang->customer","Item UPC","Item Name","$lang->itemsPurchased","$lang->paidWith","$lang->soldBy","Item Cost","Item Price","Tax","Sale Total");
$tablefields=array('id','date','customer_id','upc','item_id','quantity_purchased','paid_with','sold_by','item_buy_price','item_unit_price','item_total_tax','item_total_cost');


}

$display->displayReportTable("$cfg_tableprefix",'sales',$tableheaders,$tablefields,'','',"$date1","$date2",'id',"$lang->listOfSalesBetween $date1 $lang->and $date2");

?>



</body>
</html> 