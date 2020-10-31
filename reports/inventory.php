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
$display->displayTitle("$cfg_company Inventory On Hand Cost Report");


if(isset($_POST['month1']) and isset($_POST['selected_item']))
{
	$selected_category=$_POST['selected_category'];
	$selected_item=$_POST['selected_item'];
	
	$date_range=$_POST['date_range'];
	$dates=explode(':',$date_range);
	$month1=$_POST['month1'];
	$day1=$_POST['day1'];
	$year1=$_POST['year1'];
	$month2=$_POST['month2'];
	$day2=$_POST['day2'];
	$year2=$_POST['year2'];
	
	$month1len=strlen($month1);
	$month2len=strlen($month2);
	if ($month1len == 1) { $month1 = '0'.$month1;}  
	if ($month2len == 1) { $month2 = '0'.$month2;}  
	
	
	$day1len=strlen($day1);
	$day2len=strlen($day2);
	if ($day1len == 1) { $day1 = '0'.$day1;}  
	if ($day2len == 1) { $day2 = '0'.$day2;}  
	
	
	
	$date1=date("$year1-$month1-$day1");
	$date2=date("$year2-$month2-$day2");

}

    $selected_category=$_POST['selected_category'];
	$selected_item=$_POST['selected_item'];

if ($usertype=="Admin"){



$tableheaders=array("ItemID","Date","UPC","Item Name","Qty","Item Cost");
$tablefields=array('id','date','item_number','item_name','quantity','buy_price');


}else{


$tableheaders=array("ItemID","$lang->date","UPC","Qty","ItemCost");
$tablefields=array('id','date','item_number','quantity','buy_price');

}
   
   
    $categorytable = "$cfg_tableprefix".'categories';
    $articletable = "$cfg_tableprefix".'articles';
	$selectedcatagoryname= $dbf->idToField("$categorytable",'category',"$selected_category");
	$selecteditemname=$dbf->idToField("$articletable",'article',"$selected_item");
   
    if ($selected_category == "allcategories") { $selectedcatagoryname = 'All Categories';}
	if ($selected_item == "allitems") { $selecteditemname = 'All Items';}
   echo  "<center> Report Ran for Selected Category: $selectedcatagoryname and Selected Items: $selecteditemname </center>"; 



$display->displayInventoryCostReportTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'',"$selected_category","$selected_item","$date1","$date2",'id',"List Of Items On Hand");

?>



</body>
</html> 