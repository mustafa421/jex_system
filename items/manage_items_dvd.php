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

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/items_dvd_display.php");
include ("../classes/form.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$lang->manageItems");

$f1=new form('return validateFormOnSubmit(this)','manage_items_dvd.php','POST','items','400',$cfg_theme,$lang);

$f1->createInputField("<b>$lang->searchForItemBy</b>",'text','search','','24','150');



$option_values2=array('supplier_id','item_id','id','quantity','supplier_catalogue_number');
$option_titles2=array("$lang->itemNumber","$lang->itemName",'ID',"$lang->quantityStock","$lang->supplierCatalogue");

$f1->createSelectField("<b>$lang->searchBy</b>",'searching_by',$option_values2,$option_titles2,100);
$f1->endForm();








echo "<center><a href='manage_items_dvd.php?outofstock=go'><img src=\"../je_images/btgray_show_out_of_stock_items.png\" onmouseover=\"this.src='../je_images/btgray_show_out_of_stock_items_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_show_out_of_stock_items.png';\" BORDER='0'></a>
<a href='manage_items_dvd.php?reorder=go'><img src=\"../je_images/btgray_show_items_need_reordering.png\" onmouseover=\"this.src='../je_images/btgray_show_items_need_reordering_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_show_items_need_reordering.png';\" BORDER='0'></a>
<a href='manage_items_dvd.php?zeroprice=go'><img src=\"../je_images/btgray_items_with_zero_price.png\" onmouseover=\"this.src='../je_images/btgray_items_with_zero_price_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_items_with_zero_price.png';\" BORDER='0'></a></center>";











$tableheaders=array("$lang->rowID","$lang->itemName","$lang->itemNumber","$lang->description","$lang->brand","$lang->category","$lang->supplier","$lang->buyingPrice","$lang->sellingPrice","$lang->tax $lang->percent","$lang->finalSellingPricePerUnit","$lang->quantityStock","$lang->reorderLevel","$lang->supplierCatalogue","$lang->updateItem","$lang->deleteItem","ImageLink");
$tablefields=array('id','supplier_id','item_id','supplier_phone','transaction_id','upc');

if(isset($_POST['search']))
{
	$search=$_POST['search'];
	$searching_by =$_POST['searching_by'];
	
	if ($searching_by == 'item_number'){
     	$search = intval($search); 
    }
	
	echo "<center>$lang->searchedForItem: <b>$search</b> $lang->searchBy <b>$searching_by</b></center>";
    $display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,"$searching_by","$search",'id');

}
elseif(isset($_GET['outofstock']))
{
	echo "<center>$lang->outOfStock</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'quantity',"outofstock",'id');
}
elseif(isset($_GET['reorder']))
{
	echo "<center>$lang->reorder</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'quantity',"reorder",'id');
}

elseif(isset($_GET['zeroprice']))
{
	echo "<center>$lang->zeroprice</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'unit_price',"zeroprice",'id');
}
else
{
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'','','id');
}


$dbf->closeDBlink();

?>
</body>
</html>