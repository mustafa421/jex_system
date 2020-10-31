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
<SCRIPT language=JavaScript>

function reload(form){


var valcat=form.selected_category.options[form.selected_category.options.selectedIndex].value;
var valitem=form.selected_item.options[form.selected_item.options.selectedIndex].value;

self.location='manage_items_by_categories.php?displayresult=no&catid=' +valcat+ '&artid=' +valitem


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
include ("../classes/items_display.php");
include ("../classes/form.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);


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
    
	
	
	
	
	
if(isset($_GET['catid'])){$catid=$_GET['catid'];}
$categorytable = "$cfg_tableprefix".'categories';


$wherefield = ' activate_category = '."'".'Y'. "'" ;


$category_option_titles=$dbf->getAllElementswhere("$categorytable",'category',"$wherefield",'category');
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values=$dbf->getAllElementswhere("$categorytable",'id',"$wherefield",'category');
$category_option_values[0] = $category_id_value;

$category_option_titles[0] = " ";
$category_option_values[0] = 'blank';



if(isset($_GET['catid'])){
$category_id_value=$catid;
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}
	















$articletable = "$cfg_tableprefix".'articles';

$wherefield = 'activate_article = '."'".'Y'. "'" . 'and (category_id =' ." '". "$catid"."'".' or category_id =' ." '". " ". "')"; 


$article_option_titles=$dbf->getAllElementswhere("$articletable",'article',"$wherefield",'article');
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values=$dbf->getAllElementswhere("$articletable",'id',"$wherefield",'article');
$article_option_values[0] = $article_id_value;

$article_option_titles[0] =" ";
$article_option_values[0] ='blank';

if ($article_id_fromtable=="yes"){
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values[0] = $article_id_value;
}


if (isset($_GET['artid']))
{
$article_id_value=$_GET['artid'];
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values[0] = $article_id_value;
}



$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

$display->displayTitle("Manage Inventory By Category");

$f1=new form('return validateFormOnSubmit(this)','manage_items_by_categories.php','POST','items','400',$cfg_theme,$lang);
$onchange="onchange=".'"'."reload(this.form)".'"';
$f1->createSelectField("<b>$lang->selectCategory</b>",'selected_category',$category_option_values,$category_option_titles,'150',$onchange);

$f1->createSelectField("<b>Select Artical</b>",'selected_item',$article_option_values,$article_option_titles,'130');






$f1->createInputField("<b>$lang->searchForItemBy</b>",'text','search','','24','150');


$option_values2=array('ALL','item_number','serialnumber','article_id','description','itemmodel','id','quantity','supplier_catalogue_number');
$option_titles2=array("ALL","$lang->itemNumber","Serial Number","$lang->itemName","Description","Item Model",'ID',"$lang->quantityStock","$lang->supplierCatalogue");
$f1->createSelectField("<b>$lang->searchBy</b>",'searching_by',$option_values2,$option_titles2,100);

$f1->formBreak('500',$cfg_theme);
$f1->createDateSelectFieldModfied($day1);
$f1->formBreak('500',$cfg_theme);
$f1->endForm();









if ($usertype=="Admin"){



$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","$lang->supplier","$lang->category","Article","Model","Description","Item Cost","SellPrice","Tax%","Final SellPrice","Qty","$lang->reorderLevel","Date","ImageLink","$lang->updateItem","$lang->deleteItem","$lang->itembarcode");
$tablefields=array('id','item_number','serialnumber','supplier_id','category_id','article_id','itemmodel','description','buy_price','unit_price','tax_percent','total_cost','quantity','reorder_level','date');

	
}else if (($usertype=="Sales Clerk") and ($cfg_allow_salesclerk_view_buyprice=="no")) {

$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","$lang->supplier","$lang->category","Article","Description","SellPrice","Tax%","Final SellPrice","Qty","$lang->reorderLevel","Date","ImageLink","$lang->updateItem","$lang->itembarcode");
$tablefields=array('id','item_number','serialnumber','supplier_id','category_id','article_id','description','unit_price','tax_percent','total_cost','quantity','reorder_level','date');

	
}else if (($usertype=="Sales Clerk") and ($cfg_allow_salesclerk_view_buyprice=="yes")) {

$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","$lang->supplier","$lang->category","Article","Description","Item Cost","SellPrice","Tax%","Final SellPrice","Qty","$lang->reorderLevel","Date","ImageLink","$lang->updateItem","$lang->itembarcode");
$tablefields=array('id','item_number','serialnumber','supplier_id','category_id','article_id','description','buy_price','unit_price','tax_percent','total_cost','quantity','reorder_level','date');


}else{ 







}






















if (isset($_GET['dateone']))
{
$dateone=$_GET['dateone'];
}

if((isset($_GET['catid'])) or (isset($_POST['selected_category'])) or (($_POST['day1']) !=0 ) or  ($dateone!=0) )
{

 if (($_POST['day1']) !=0 ) 
{
	$day1 = $_POST['day1'];
	$month1 = $_POST['month1'];
	$year1 = $_POST['year1'];
	
	$day2 = $_POST['day2'];
	$month2 = $_POST['month2'];
	$year2 = $_POST['year2'];

	
	$date1=$year1.'-'.$month1.'-'.$day1;
	if ($day2!=0){
	$date2=$year2.'-'.$month2.'-'.$day2;
	}else{
	$date2=0;
	}
	}else{
	$date1=0;
	$date2=0;
	}


 


if (isset($_POST['selected_category'])) 
{
	$catid=$_POST['selected_category'];
}else{
	$catid=$_GET['catid'];
}

if (isset($_POST['selected_item'])) 
{
	$article_id_value=$_POST['selected_item'];
}else{
	$article_id_value=$_GET['artid'];
}

if (isset($_POST['search']))
{
    $search=$_POST['search'];
	$search=trim($search);
}else{
   $search=$_GET['search'];
   $search=trim($search);
}

if (isset($_POST['searching_by']))
{
	$searching_by =$_POST['searching_by'];
}else{
	$searching_by =$_GET['search_by'];
}

$frompanel="bycategory";

if ($dateone!=0)
{
$date1=$_GET['dateone'];

}

if (isset($_GET['datetwo']))
{
if (($_GET['datetwo']!=0))
{
$date2=$_GET['datetwo'];
}
}



	echo "<center>$lang->Categories</b></center>";
	$display->displayManageTableJex("$cfg_tableprefix",'items',$tableheaders,$tablefields,'catogory',$catid,'id',$article_id_value,$search,$searching_by,$frompanel,$date1,$date2);
}else{
if(isset($_GET['lookupbycat'])) {
echo "<br/><br/><br/>";
echo "<center><b><font color=blue>Select category/Artical you would like to view/search inventory for.</font></b></center>";

}

}




$dbf->closeDBlink();

?>
</body>
</html>