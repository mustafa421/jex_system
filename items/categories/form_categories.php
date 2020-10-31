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
include ("../../classes/categories_display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$display= new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		header ("location: ../../login.php");
		exit();
}

$category_value='';
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
	$display->displayTitle("$lang->updateCategory");
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'categories';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$category_value=$row['category'];
		if ($row['activate_category'] == 'Y'){$activatecategory_checked = 'checked';}
		if ($row['report_transaction'] == 'Y'){$report_transaction_checked = 'checked';}
		if ($row['showon_itempanel'] == 'Y'){$showon_itempanel_checked = 'checked';}
		if ($row['showon_moviespanel'] == 'Y'){$showon_moviespanel_checked = 'checked';}
		if ($row['showon_gamespanel'] == 'Y'){$showon_gamespanel_checked = 'checked';}
		if ($row['showon_jewelrypanel'] == 'Y'){$showon_jewelrypanel_checked = 'checked';}
		if ($row['showon_saleservicepanel'] == 'Y'){$showon_saleservicepanel_checked= 'checked';}
	}

}
else
{
	$display->displayTitle("$lang->addCategory");

}

$f1=new form('return validateFormOnSubmit(this)','process_form_categories.php','POST','categories','400',$cfg_theme,$lang);


$f1->createInputField("<b>$lang->categoryName:</b>",'text','category',"$category_value",'24','150');
$f1->createInputField("$lang->ActivateCategory:",'checkbox','activatecategory',"Y",'10','160',"$activatecategory_checked");
$f1->createInputField("Report Transaction:",'checkbox','report_transaction',"Y",'10','160',"$report_transaction_checked");
$f1->createInputField("Show On Item Panel:",'checkbox','showon_itempanel',"Y",'10','160',"$showon_itempanel_checked");
$f1->createInputField("Show On Movies Panel:",'checkbox','showon_moviespanel',"Y",'10','160',"$showon_moviespanel_checked");
$f1->createInputField("Show On Games Panel:",'checkbox','showon_gamespanel',"Y",'10','160',"$showon_gamespanel_checked");
$f1->createInputField("Show On Jewelry Panel:",'checkbox','showon_jewelrypanel',"Y",'10','160',"$showon_jewelrypanel_checked");
$f1->createInputField("Show On Sale Service Panel:",'checkbox','showon_saleservicepanel',"Y",'10','160',"$showon_saleservicepanel_checked");


echo "		
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
$f1->endForm();

$dbf->closeDBlink();


?>
</body>
</html>	




