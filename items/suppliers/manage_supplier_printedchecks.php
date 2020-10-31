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
include ("../../classes/printedcheck_display.php");
include ("../../classes/form.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("Checks Issued");



$tableheaders=array("$lang->rowID","checknumber","supplierid","transactionid","checkamount","bankname","date","$lang->update","Delete");
$tablefields=array('id','checknumber','supplierid','transactionid','checkamount','bankname','date');



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
    $display->displayManageTable("$cfg_tableprefix",'printed_checks',$tableheaders,$tablefields,"$searching_by","$search",'id');

}
elseif(isset($_GET['outofstock']))
{
	echo "<center>$lang->outOfStock</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'printed_checks',$tableheaders,$tablefields,'quantity',"outofstock",'id');
}
elseif(isset($_GET['reorder']))
{
	echo "<center>$lang->reorder</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'printed_checks',$tableheaders,$tablefields,'quantity',"reorder",'id');
}

elseif(isset($_GET['zeroprice']))
{
	echo "<center>$lang->zeroprice</b></center>";
	$display->displayManageTable("$cfg_tableprefix",'printed_checks',$tableheaders,$tablefields,'unit_price',"zeroprice",'id');
}
else
{
	if(isset($_GET['id'])){
	   $wherefield='supplierid';
	   $wherefielddata=$_GET['id'];
	  }
	$display->displayManageTable("$cfg_tableprefix",'printed_checks',$tableheaders,$tablefields,$wherefield,$wherefielddata,'id');
}


$dbf->closeDBlink();

?>
</body>
</html>