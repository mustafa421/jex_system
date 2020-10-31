<?php session_start(); ?>

<html>
<head>


</head>

<body>
<?php

include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/db_functions.php");
include ("../../classes/security_functions.php");
include ("../../classes/form.php");
include ("../../classes/checknumber_display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$display= new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		header ("location: ../../login.php");
		exit();
}

$startcknumber_value='';
$nextcknumber_value='';
$bankname_value='';
$id=-1;


if(isset($_GET['action']))
{
	$action=$_GET['action'];
}
else
{
	$action="insert";
}


if($action=="insert"){
  $tablename = "$cfg_tableprefix".'printed_checks';
	$result = mysql_query("SELECT * FROM $tablename WHERE id=1",$dbf->conn);
	$row = mysql_fetch_assoc($result);
	$checknumber=$row['checknumber'];
 
 
 
 
 
}

	

if($action=="update")
{
	$display->displayTitle("Update Printed Check Information");
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'printed_checks';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$checknumber_value=$row['checknumber'];
		$supplierid_value=$row['supplierid'];
		$transactionid_value=$row['transactionid'];
		$checkamount_value=$row['checkamount'];
		$bankname_value=$row['bankname'];
		$date_value=$row['date'];
	}

}
else
{
	$display->displayTitle("Check Printing Coordinates");

}


$f1=new form('return validateFormOnSubmit(this)','process_form_printed_checks.php','POST','printedchecks','310',$cfg_theme,$lang);


$f1->createInputField("<b>TransactionID:</b>",'text','transactionid',"$transactionid_value",'10','150');
$f1->createInputField("<b>SupplierID:</b>",'text','supplierid',"$supplierid_value",'23','150');
$f1->createInputField("<b>CheckNumber:</b>",'text','checknumber',"$checknumber_value",'10','150');
$f1->createInputField("<b>CheckAmt:</b>",'text','checkamount',"$checkamount_value",'23','150');
$f1->createInputField("<b>BankName:</b>",'text','bankname',"$bankname_value",'23','150');
$f1->createInputField("<b>Date:</b>",'text','date',"$date_value",'23','150');


echo "		
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
$f1->endForm();

$dbf->closeDBlink();


?>
</body>
</html>	




