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
include ("../../classes/articletypes_display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$display= new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		header ("location: ../../login.php");
		exit();
}

$articletype_value='';
$id=-1;


if(isset($_GET['action']))
{
	$action=$_GET['action'];
}
else
{
	$action="insert";
}


if($action=="update")
{
	$display->displayTitle("$lang->updateArticleType");
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'articletypes';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$articletype_value=$row['articletype'];
	
	}

}
else
{
	$display->displayTitle("$lang->addArticleType");

}

$f1=new form('return validateFormOnSubmit(this)','process_form_articletypes.php','POST','articletypes','300',$cfg_theme,$lang);


$f1->createInputField("<b>$lang->articleTypeName:</b>",'text','articletype',"$articletype_value",'24','150');


echo "		
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
$f1->endForm();

$dbf->closeDBlink();


?>
</body>
</html>	




