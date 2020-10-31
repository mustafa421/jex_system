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
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=700,height=600,left = 362,top = 234');");
}
</script>

<link rel='stylesheet' type='text/css' href='../cssbutton/css/style.css' />
<link rel="stylesheet" href="../csstooltip/style1.css">
</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/form.php");
if ($cfg_store_state=="wi"){
   
   include ("../classes/item_trans_wi_display.php");
}else{
	
	include ("../classes/item_trans_il_display.php");
}
	   
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





$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

$display->displayTitle("Manage Transactions");

echo "</br>";



$f1=new form('return validateFormOnSubmit(this)','manage_item_trans.php','POST','items','400',$cfg_theme,$lang);

$f1->createInputField("<b>$lang->searchForItemBy</b>",'text','search','','24','150');


$option_values2=array('ALL','upc','transaction_id','supplier_phone','date');
$option_titles2=array("ALL","$lang->itemNumber","Transaction Number","Supplier Phone","Transaction Date (MM-DD-YYYY)");

$f1->createSelectField("<b>$lang->searchBy</b>",'searching_by',$option_values2,$option_titles2,100);

echo "<center><span class=\"tab\"></span> <span class=\"tab\"></span>";	
include ("../csstooltip/tooltip_manage_item_trans.html");
echo "</center>";

$f1->endForm();

if(isset($_GET['enteredby']))
	{
	
	
	}else{





echo"
<div id=\"button-box\">
    <a href=\"manage_item_trans.php?listsupplieritems=1&enteredby=jex\" class=\"button\">List Items Entered By Jewelry & Exchange</a>
    			
</div><br><br>
";
	}

if ($usertype=="Admin"){
$tableheaders=array("$lang->rowID","ItemRowID","ArticleID","TransactionID","Supplier","SPhone","UPC","BuyPrice","SellPrice","Date","Time","ImageLink","$lang->itembarcode","AddItem","CreateSA","CreatCheck","Update","Delete Trans");
$tablefields=array('id','itemrow_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','date','time');

	
}else if (($usertype=="Sales Clerk") and ($cfg_allow_salesclerk_view_buyprice=="no")) {
	$tableheaders=array("$lang->rowID","ItemRowID","ArticleID","TransactionID","Supplier","SPhone","UPC","SellPrice","Date","Time","ImageLink","$lang->itembarcode","AddItem","CreateSA","Update","CreatCheck");
	$tablefields=array('id','itemrow_id','article_id','transaction_id','supplier_id','supplier_phone','upc','unit_price','date','time');

	
}else if (($usertype=="Sales Clerk") and ($cfg_allow_salesclerk_view_buyprice=="yes")) {

$tableheaders=array("$lang->rowID","ItemRowID","ArticleID","TransactionID","Supplier","SPhone","UPC","BuyPrice","SellPrice","Date","Time","ImageLink","$lang->itembarcode","AddItem","CreateSA","Update","CreatCheck");
$tablefields=array('id','itemrow_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','date','time');

}else{


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
    $display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,"$searching_by","$search",'id',$cfg_store_code);

}
elseif(isset($_GET['outofstock']))
{
	echo "<center>$lang->outOfStock</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'quantity',"outofstock",'id',$cfg_store_code);
}
elseif(isset($_GET['reorder']))
{
	echo "<center>$lang->reorder</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'quantity',"reorder",'id',$cfg_store_code);
}

elseif(isset($_GET['zeroprice']))
{
	echo "<center>$lang->zeroprice</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'unit_price',"zeroprice",'id',$cfg_store_code);
}
elseif(isset($_GET['listsupplieritems']))
{
    $supplierid=$_GET['listsupplieritems'];
	
   
	 $suppliertable = "$cfg_tableprefix".'suppliers';
	    $supplier_query="SELECT firstname, lastname FROM $suppliertable where id = '$supplierid' ";
			$supplier_result=mysql_query($supplier_query,$dbf->conn);
			$supplier_row = mysql_fetch_assoc($supplier_result);
			$firstname=$supplier_row ['firstname'];
			$lastname=$supplier_row ['lastname'];
	$suppliername=$firstname." ".$lastname;
	
	if(isset($_GET['enteredby']))
	{
		$displayjexmsg  = $_GET['enteredby'];
		if ($displayjexmsg=="jex")
		{
			
			echo"<br>
<div id=\"button-box\">
    <a href=\"manage_item_trans.php\" class=\"button\">Go Back</a>
    <center><b><font color=blue> List of Items Entered by Jewelry & Electronic</b> </font></font></center>			
</div><br>
";
		
		}else{
	       echo "<center><b><font color=blue> List of Items Purchased from $suppliername</b> </font><a href=\"suppliers/manage_suppliers.php?backtosupplier=$supplierid\"><font color=green><b>[Go Back]</b></a></font></center>";
		}
	}else{
	echo "<center><b><font color=blue> List of Items Purchased from $suppliername</b> </font><a href=\"suppliers/manage_suppliers.php?backtosupplier=$supplierid\"><font color=green><b>[Go Back]</b></a></font></center>";
	}
	
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'supplier_id',"$supplierid",'id',$cfg_store_code);
}
	elseif(isset($_GET['usingsearch']))
{
  $searching_by=$_GET['searching_by'];
  $search=$_GET['search'];

  $display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,"$searching_by","$search",'id',$cfg_store_code);
   
}
elseif(isset($_GET['searchall']))
{
  $searching_by='ALL';
  $search=$_GET['search'];

$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,"$searching_by","$search",'id',$cfg_store_code);
 
}
else
{
	$display->displayManageTable("$cfg_tableprefix",'item_transactions',$tableheaders,$tablefields,'','','id',$cfg_store_code);
}


$dbf->closeDBlink();

?>
</body>
</html>