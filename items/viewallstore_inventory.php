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
include ("../classes/allstore_items_display.php");
include ("../classes/form.php");


$lang=new language();

$dbf=new db_functions($cfg_server,$cfg_shareINVdbuser,$cfg_shareINVdbpwd,$cfg_shareINVdbname,$cfg_tableprefix,$cfg_theme,$lang);









$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("Search All Stores Inventory");

$f1=new form('return validateFormOnSubmit(this)','viewallstore_inventory.php','POST','inventory','400',$cfg_theme,$lang);

$f1->createInputField("<b>$lang->searchForItemBy</b>",'text','search','','24','150');







$option_values2=array('upc','article','description');
$option_titles2=array("$lang->itemNumber","Article Name","Description");

$f1->createSelectField("<b>$lang->searchBy</b>",'searching_by',$option_values2,$option_titles2,100);
$f1->endForm();



$tableheaders=array("RowID","UPC","Article","Description","Price w/o Tax","Quantity","Store Address","Store Phone","Item Image");
$tablefields=array('id','upc','article','description','price','quantity','storelocation','storephone');



if(isset($_POST['search']))
{
	$search=$_POST['search'];
	$searching_by =$_POST['searching_by'];
	
	if ($searching_by == 'upc'){
    
     
    
    
    
     
    }
	
	if ($searching_by == 'article_id'){
	  
	  
		
		
		
  }
	
	echo "<center>$lang->searchedForItem: <b>$search</b> $lang->searchBy <b>$searching_by</b></center>";
    
$display->displayManageTable("$cfg_tableprefix",'inventory',$tableheaders,$tablefields,"$searching_by","$search",'id'); 

}
elseif(isset($_GET['outofstock']))
{
	echo "<center>$lang->outOfStock</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'inventory',$tableheaders,$tablefields,'quantity',"outofstock",'id');
}
elseif(isset($_GET['reorder']))
{
	echo "<center>$lang->reorder</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'inventory',$tableheaders,$tablefields,'quantity',"reorder",'id');
}

elseif(isset($_GET['zeroprice']))
{
	echo "<center>$lang->zeroprice</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'inventory',$tableheaders,$tablefields,'unit_price',"zeroprice",'id');
}
else
{
	$display->displayManageTable("$cfg_tableprefix",'inventory',$tableheaders,$tablefields,'','','id'); 
}


$dbf->closeDBlink();

?>
</body>
</html>