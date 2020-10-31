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
  $tablename = "$cfg_tableprefix".'checknumber';
	$result = mysql_query("SELECT * FROM $tablename WHERE id=1",$dbf->conn);
	$row = mysql_fetch_assoc($result);
	$startcknumber=$row['start_check_number'];
  if ($startcknumber <> "")
    { 
    	echo "Check Number is Already Entered...Please Use Update/Del button.";
    	exit;
    }
}

	

if($action=="update")
{
	$display->displayTitle("Update Check Number");
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'checknumber';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$startcknumber_value=$row['start_check_number'];
		$nextcknumber_value=$row['next_check_number'];
		$bankname_value=$row['bank_name'];
	
	}

}
else
{
	$display->displayTitle("Check Number");

}


$f1=new form('return validateFormOnSubmit(this)','process_form_checknumber.php','POST','checknumber','300',$cfg_theme,$lang);


$f1->createInputField("<b>Start Check Number:</b>",'text','startcknumber',"$startcknumber_value",'10','150');
$f1->createInputField("<b>Next Check Number:</b>",'text','nextcknumber',"$nextcknumber_value",'10','150');
$f1->createInputField("<b>Bank Name:</b>",'text','bankname',"$bankname_value",'23','150');


echo "		
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
$f1->endForm();

$dbf->closeDBlink();


?>
</body>
</html>	




