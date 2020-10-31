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
// --->
</SCRIPT> 

</head>

<body>
<?php

include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/db_functions.php");
include ("../../classes/security_functions.php");
include ("../../classes/articles_display.php");
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
$display->displayTitle("$lang->manageArticles");

$f1=new form('return validateFormOnSubmit(this)','manage_articles.php','POST','articles','475',$cfg_theme,$lang);
$f1->createInputField("<b>$lang->searchForArticle</b>",'text','search','','24','375');
$f1->endForm();

$tableheaders=array("$lang->rowID","$lang->articleName","Category","Active Status","$lang->updateArticle","$lang->deleteArticle");
$tablefields=array('id','article','category_id','activate_article');

if(isset($_POST['search']))
{
	$search=$_POST['search'];
	echo "<center>$lang->searchedForArticle: <b>$search</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'articles',$tableheaders,$tablefields,'article',"$search",'article');
}
else
{
	$display->displayManageTable("$cfg_tableprefix",'articles',$tableheaders,$tablefields,'','','article');
}



$dbf->closeDBlink();


?>
</body>
</html>