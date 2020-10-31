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
<SCRIPT LANGUAGE="JavaScript">
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=700,height=700,left = 362,top = 234');");
}
</script>

<link rel='stylesheet' type='text/css' href='../cssbutton/css/style.css' />
<link rel="stylesheet" href="../cssmenu/styles.css">
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



if(isset($_GET['search']))
{
	  $search = $_GET["search"];
	   $searching_by = $_GET["search_by"];	   
	 
$searchfor = "yes";	
}




		$userstable="$cfg_tableprefix".'users';
		$userid=$_SESSION['session_user_id'];
    $user_result = mysql_query("SELECT type FROM $userstable WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $usertype=$usertable_row['type'];
    
		

$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$lang->manageItems");

$f1=new form('return validateFormOnSubmit(this)','manage_items.php','POST','items','400',$cfg_theme,$lang);

$f1->createInputField("<b>$lang->searchForItemBy</b>",'text','search','','24','150');




$option_values2=array('ALL','item_number','serialnumber','article_id','description','itemmodel','id','quantity','supplier_catalogue_number');
$option_titles2=array("ALL","$lang->itemNumber","Serial Number","$lang->itemName","Description","Item Model",'ID',"$lang->quantityStock","$lang->supplierCatalogue");

$f1->createSelectField("<b>$lang->searchBy</b>",'searching_by',$option_values2,$option_titles2,100);
$f1->endForm();








echo "<br/>";
include ("../cssmenu/index.html");



echo "<br/>";


if ($usertype=="Admin"){

   if(isset($_GET['removedbypd']))
    {


	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Model","Description","Item Cost","SellPrice","Tax%","Final SellPrice","Date","RemovedBy","Qty","RemoveComment","RemoveDate","ImageLink","$lang->updateItem","$lang->deleteItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','itemmodel','description','buy_price','unit_price','tax_percent','total_cost','date','removedbypd','qtyremovedpd','removecommentpd','removedatepd');

	}else if(isset($_GET['removedbyjex']))
	{


	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Model","Description","Item Cost","SellPrice","Tax%","Final SellPrice","Date","RemovedBy","Qty","RemoveComment","RemoveDate","ImageLink","$lang->updateItem","$lang->deleteItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','itemmodel','description','buy_price','unit_price','tax_percent','total_cost','date','removedbyjex','qtyremovedjex','removecommentjex','removedatejex');

	}else{
	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Model","Description","Item Cost","SellPrice","Tax%","Final SellPrice","Qty","$lang->reorderLevel","Date","ImageLink","$lang->updateItem","$lang->deleteItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','itemmodel','description','buy_price','unit_price','tax_percent','total_cost','quantity','reorder_level','date');
     }
	
}else if (($usertype=="Sales Clerk") and ($cfg_allow_salesclerk_view_buyprice=="no")) {
      if(isset($_GET['removedbypd']))
    {


	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Description","SellPrice","Tax%","Final SellPrice","Date","RemovedBy","Qty","RemoveComment","RemoveDate","ImageLink","$lang->updateItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','description','unit_price','tax_percent','total_cost','date','removedbypd','qtyremovedpd','removecommentpd','removedatepd');

	}else if(isset($_GET['removedbyjex']))
	{


	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Description","SellPrice","Tax%","Final SellPrice","Date","RemovedBy","Qty","RemoveComment","RemoveDate","ImageLink","$lang->updateItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','description','unit_price','tax_percent','total_cost','date','removedbyjex','qtyremovedjex','removecommentjex','removedatejex');

	}else{
	
	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Description","SellPrice","Tax%","Final SellPrice","Qty","$lang->reorderLevel","Date","ImageLink","$lang->updateItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','description','unit_price','tax_percent','total_cost','quantity','reorder_level','date');
	}
	
}else if (($usertype=="Sales Clerk") and ($cfg_allow_salesclerk_view_buyprice=="yes")) {
      if(isset($_GET['removedbypd']))
    {


	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Description","Item Cost","SellPrice","Tax%","Final SellPrice","Date","RemovedBy","Qty","RemoveComment","RemoveDate","ImageLink","$lang->updateItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','description','buy_price','unit_price','tax_percent','total_cost','date','removedbypd','qtyremovedpd','removecommentpd','removedatepd');

	}else if(isset($_GET['removedbyjex']))
	{


	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Description","Item Cost","SellPrice","Tax%","Final SellPrice","Date","RemovedBy","Qty","RemoveComment","RemoveDate","ImageLink","$lang->updateItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','description','buy_price','unit_price','tax_percent','total_cost','date','removedbyjex','qtyremovedjex','removecommentjex','removedatejex');

		}else{
	$tableheaders=array("$lang->rowID","$lang->itemNumber","Serial Number","IMEI1","IMEI2","$lang->supplier","$lang->category","Article","Description","Item Cost","SellPrice","Tax%","Final SellPrice","Qty","$lang->reorderLevel","Date","ImageLink","$lang->updateItem","$lang->itembarcode");
	$tablefields=array('id','item_number','serialnumber','imei1','imei2','supplier_id','category_id','article_id','description','buy_price','unit_price','tax_percent','total_cost','quantity','reorder_level','date');
	}
}else{ 
echo "You Do not Access to see this information Please check with your system Admin.";




}


if(isset($_POST['search']))
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
elseif(isset($_GET['outofstock']))
{
	echo "<center>$lang->outOfStock</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'quantity',"outofstock",'id');
}
elseif(isset($_GET['reorder']))
{
	echo "<center>$lang->reorder</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'quantity',"reorder",'id');
}

elseif(isset($_GET['zeroprice']))
{
	echo "<center>$lang->zeroprice</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'unit_price',"zeroprice",'id');

}

elseif(isset($_GET['removedbypd']))
{

	echo "<center>Items removed by Police</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'removedbypd',"removedbypd",'id');

}

elseif(isset($_GET['removedbyjex']))
{
	echo "<center>Items removed by JEX</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'removedbyjex',"removedbyjex",'id');

}


elseif($searchfor=="yes")
{
	$search = $_GET["search"];
	$searching_by = $_GET["search_by"];
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,"$searching_by","$search",'id');

}else{
	echo "<center>Came here display all</center>";
	$display->displayManageTable("$cfg_tableprefix",'items',$tableheaders,$tablefields,'','','id');
}


$dbf->closeDBlink();

?>

</body>
</html>