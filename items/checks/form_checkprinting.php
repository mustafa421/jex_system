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
  $tablename = "$cfg_tableprefix".'checkprinting_coordinates';
	$result = mysql_query("SELECT * FROM $tablename WHERE id=1",$dbf->conn);
	$row = mysql_fetch_assoc($result);
	$checkdatepos=$row['date_xpos'];
  if ($checkdatepos <> "")
    { 
    	echo "Check Printing coordinates are Already Entered...Please Use Update/Del button.";
    	exit;
    }
}

	

if($action=="update")
{
	$display->displayTitle("Update Check Printing Coordinates");
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'checkprinting_coordinates';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$datexpos_value=$row['date_xpos'];
		$dateypos_value=$row['date_ypos'];
		$namexpos_value=$row['name_xpos'];
		$nameypos_value=$row['name_ypos'];
		$amountinwordsxpos_value=$row['amount_inwords_xpos'];
		$amountinwordsypos_value=$row['amount_inwords_ypos'];
		$amountxpos_value=$row['amount_xpos'];
		$amountypos_value=$row['amount_ypos'];
		$notexpos_value=$row['note_xpos'];
		$noteypos_value=$row['note_ypos'];
	
	}

}
else
{
	$display->displayTitle("Check Printing Coordinates");

}


$f1=new form('return validateFormOnSubmit(this)','process_form_checkprinting.php','POST','checkprinting','310',$cfg_theme,$lang);


$f1->createInputField("<b>Date-xpos:</b>",'text','datexpos',"$datexpos_value",'10','150');
$f1->createInputField("<b>Date-ypos:</b>",'text','dateypos',"$dateypos_value",'10','150');
$f1->createInputField("<b>Name-xpos:</b>",'text','namexpos',"$namexpos_value",'23','150');
$f1->createInputField("<b>Name-ypos:</b>",'text','nameypos',"$nameypos_value",'23','150');
$f1->createInputField("<b>Amount-InWords-xpos:</b>",'text','amountinwordsxpos',"$amountinwordsxpos_value",'23','150');
$f1->createInputField("<b>Amount-InWords-ypos:</b>",'text','amountinwordsypos',"$amountinwordsypos_value",'23','150');
$f1->createInputField("<b>Amount-xpos:</b>",'text','amountxpos',"$amountxpos_value",'23','150');
$f1->createInputField("<b>Amount-ypos:</b>",'text','amountypos',"$amountypos_value",'23','150');
$f1->createInputField("<b>Note-xpos:</b>",'text','notexpos',"$notexpos_value",'23','150');
$f1->createInputField("<b>Note-ypos:</b>",'text','noteypos',"$noteypos_value",'23','150');

echo "		
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
$f1->endForm();

$dbf->closeDBlink();


?>
</body>
</html>	




