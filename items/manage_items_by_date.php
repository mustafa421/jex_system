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
self.location='manage_items_by_date.php?displayresult=no&catid=' + valcat











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
		
	
	
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

$display->displayTitle("Manage Inventory By Date");


$f1=new form('return validateFormOnSubmit(this)','manage_items_by_date.php','POST','items','400',$cfg_theme,$lang);
$onchange="onchange=".'"'."reload(this.form)".'"';



$f1->createDateSelectFieldModfied();
$f1->formBreak('500',$cfg_theme);

if(isset($_GET['catid']))
{
}else{
$f1->createInputField("<b>$lang->searchForItemBy</b>",'text','search','','24','150');


$option_values2=array('ALL','item_number','serialnumber','article_id','description','itemmodel','id','quantity','supplier_catalogue_number');
$option_titles2=array("ALL","$lang->itemNumber","Serial Number","$lang->itemName","Description","Item Model",'ID',"$lang->quantityStock","$lang->supplierCatalogue");
$f1->createSelectField("<b>$lang->searchBy</b>",'searching_by',$option_values2,$option_titles2,100);
}

$f1->endForm();







echo "<center><a href='manage_items.php?outofstock=go'><img src=\"../je_images/btgray_show_out_of_stock_items.png\" onmouseover=\"this.src='../je_images/btgray_show_out_of_stock_items_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_show_out_of_stock_items.png';\" BORDER='0'></a>
<a href='manage_items.php?reorder=go'><img src=\"../je_images/btgray_show_items_need_reordering.png\" onmouseover=\"this.src='../je_images/btgray_show_items_need_reordering_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_show_items_need_reordering.png';\" BORDER='0'></a>
<a href='manage_items.php?zeroprice=go'><img src=\"../je_images/btgray_items_with_zero_price.png\" onmouseover=\"this.src='../je_images/btgray_items_with_zero_price_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_items_with_zero_price.png';\" BORDER='0'></a></center>";








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

if (isset($_POST['day1'])){
$day1=$_POST['day1'];
echo "day1=$day1";
}



if(isset($_GET['displayresult'])){
echo "Select Artical";
exit;
}


if((isset($_POST['search'])) and ($catid==""))
{
	$search=$_POST['search'];
	$searching_by =$_POST['searching_by'];
	
	if ($searching_by == 'item_number'){
    
     
    
    
    
     
    }
	
	if ($searching_by == 'article_id'){
	    $articletable = "$cfg_tableprefix".'articles';
	    $article_query="SELECT article_id FROM $articletable where article like = '%$search%' ";
			$article_result=mysql_query($article_query,$dbf->conn);
			$article_row = mysql_fetch_assoc($article_result);
			$search=$article_row ['article_id'];
  }
	
	echo "<center>$lang->searchedForItem: <b>$search</b> $lang->searchBy <b>$searching_by</b></center>";
    $display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,"$searching_by","$search",'id');

}
elseif((isset($_GET['outofstock'])) and ($catid==""))
{
	echo "<center>$lang->outOfStock</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'quantity',"outofstock",'id');
}
elseif((isset($_GET['reorder']))  and ($catid==""))
{
	echo "<center>$lang->reorder</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'quantity',"reorder",'id');
}

elseif((isset($_GET['zeroprice']))  and ($catid==""))
{
	echo "<center>$lang->zeroprice</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'unit_price',"zeroprice",'id');

}
elseif(isset($_GET['usingsearch']))
{
  $searching_by=$_GET['searching_by'];
  $search=$_GET['search'];

  	echo "<center>Item Model: <b>$search</b> $lang->searchBy <b>$searching_by</b></center>";
    $display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,"$searching_by","$search",'id');
   
}
if((isset($_GET['catid'])) or (isset($_POST['selected_category'])))
{

echo "In catID";


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
$article_id_value=$_GET['selected_item'];
}




	echo "<center>$lang->Categories</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'catogory',$catid,'id',$article_id_value);
}
else
{
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'','','id');
}


$dbf->closeDBlink();

?>
</body>
</html>