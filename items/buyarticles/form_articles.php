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
include ("../../classes/articles_display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$display= new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		header ("location: ../../login.php");
		exit();
}

$article_value='';
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
	$display->displayTitle("$lang->updateArticle");
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'articles';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$article_value=$row['article'];
		$category_id_value=$row['category_id'];
		$cat_id_fromtable = 'yes';
		if ($row['activate_article'] == 'Y'){$activatearticle_checked = 'checked';}
	
	}

}
else
{
	$display->displayTitle("$lang->addArticle");
  $activatearticle_checked = 'checked';
}

$f1=new form('return validateFormOnSubmit(this)','process_form_articles.php','POST','articles','300',$cfg_theme,$lang);


$f1->createInputField("<b>$lang->articleName:</b>",'text','article',"$article_value",'24','150');

$categorytable = "$cfg_tableprefix".'categories';
$wherefield = ' activate_category = '."'".'Y'. "'" . ' and category <> '."'".'DVD'. "'" . ' or category = '."'".' '. "'";


$category_option_titles=$dbf->getAllElementswhere("$categorytable",'category',"$wherefield",'category');
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values=$dbf->getAllElementswhere("$categorytable",'id',"$wherefield",'category');
$category_option_values[0] = $category_id_value;

$category_option_titles[0] = " ";
$category_option_values[0] = 'blank';






if ($cat_id_fromtable=="yes"){
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}


$f1->createSelectField("<b>Article Category:</b>",'category_id',$category_option_values,$category_option_titles,'160');

$f1->createInputField("$lang->ActivateArticle:",'checkbox','activatearticle',"Y",'10','160',"$activatearticle_checked");



echo "		
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
$f1->endForm();

$dbf->closeDBlink();


?>
</body>
</html>	




