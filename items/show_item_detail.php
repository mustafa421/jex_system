<?php session_start(); ?>
<html>
<head>
</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/items_display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);
if(!$sec->isLoggedIn())
{
    header ("location: ../login.php");
    exit();
}



$sale_id = '40';



$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$lang->itemDetail");






$tableheaders=array("$lang->rowID","Desc","$lang->itemName","$lang->itemNumber","$lang->brand","$lang->category","$lang->supplier","Article","ArticleType","$lang->buyingPrice","$lang->sellingPrice","$lang->tax $lang->percent","$lang->finalSellingPricePerUnit","$lang->quantityStock","$lang->reorderLevel","$lang->supplierCatalogue");
$tablefields=array('id','description','item_name','item_number','brand_id','category_id','supplier_id','article_id','articletype_id','buy_price','unit_price','tax_percent','total_cost','quantity','reorder_level','supplier_catalogue_number');
$display->displayReportTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'id',"$sale_id",'','','id',"$sale_customer_name<br><br>");



?>



</body>
</html> 