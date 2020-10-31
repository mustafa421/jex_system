<?php session_start(); ?>

<html>
<head>
<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url)
{
  if(confirm(message) )
  {
    location.href = url;
  }
}

</SCRIPT> 

</head>

<body>
<?php

include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/db_functions.php");
include ("../../classes/security_functions.php");
include ("../../classes/articletypes_display.php");
include ("../../classes/form.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);

if(!$sec->isLoggedIn())
{
	header ("location: ../../login.php");
	exit();
}

$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$lang->manageArticleTypes");

$f1=new form('return validateFormOnSubmit(this)','manage_articletypes.php','POST','articletypes','475',$cfg_theme,$lang);
$f1->createInputField("<b>$lang->searchForArticleType</b>",'text','search','','24','375');
$f1->endForm();

$tableheaders=array("$lang->rowID","$lang->articleTypeName","$lang->updateArticleType","$lang->deleteArticleType");
$tablefields=array('id','articletype');

if(isset($_POST['search']))
{
	$search=$_POST['search'];
	echo "<center>$lang->searchedForArticleType: <b>$search</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'articletypes',$tableheaders,$tablefields,'articletype',"$search",'articletype');
}
else
{
	$display->displayManageTable("$cfg_tableprefix",'articletypes',$tableheaders,$tablefields,'','','articletype');
}



$dbf->closeDBlink();


?>
</body>
</html>