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
<script>
<!--
function wopen(url, name, w, h)
{

w += 40;
h += 200;
 var win = window.open(url,
  name, 
  'width=' + w + ', height=' + h + ', ' +
  'location=no, menubar=no, ' +
  'status=no, toolbar=no, scrollbars=yes, resizable=no');
 win.resizeTo(w, h);
 win.focus();
}
// -->
</script> 

<SCRIPT LANGUAGE="JavaScript">
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=830,left = 362,top = 234');");
}
</script>

</head>

<body>
<?php

include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/security_functions.php");
include ("../../classes/db_functions.php");
include ("../../classes/display.php");  
include ("../../classes/form.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);



$sec=new security_functions($dbf,'Sales Clerk',$lang);
if(!$sec->isLoggedIn())
{
	header ("location: ../../login.php");
	exit();
}


		$userstable="$cfg_tableprefix".'users';
		$userid=$_SESSION['session_user_id'];
    $user_result = mysql_query("SELECT type FROM $userstable WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $usertype=$usertable_row['type'];
    
		


$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$lang->manageSuppliers");

$f1=new form('return validateFormOnSubmit(this)','manage_suppliers.php','POST','suppliers','475',$cfg_theme,$lang);
$f1->createInputField("<b>$lang->searchForSupplier</b>",'text','search','','24','375');
$option_values2=array('ALL','phone_number','supplier','id');
$option_titles2=array("ALL","Phone Number","Supplier Name","Supplier ID");

$f1->createSelectField("<b>$lang->searchBy</b>",'searching_by',$option_values2,$option_titles2,100);
$f1->endForm();


echo "<center><a href='form_suppliers.php?action=insert'><img src=\"../../je_images/btgray_enter_new_supplier.png\" onmouseover=\"this.src='../../je_images/btgray_enter_new_supplier_MouseOver.png';\" onmouseout=\"this.src='../../je_images/btgray_enter_new_supplier.png';\" BORDER=\"0\"></a>";


if ($usertype=="Admin"){

$tableheaders=array("$lang->rowID","$lang->supplierName","$lang->phoneNumber","Date","$lang->updateSupplier","$lang->deleteSupplier","$lang->imagefile","$lang->addItem" ,"Checks","$lang->viewsaleagreement");
$tablefields=array('id','supplier','phone_number','date');

}else{ 
$tableheaders=array("$lang->rowID","$lang->supplierName","$lang->phoneNumber","Date","$lang->updateSupplier","$lang->imagefile","$lang->addItem" ,"Checks","$lang->viewsaleagreement");
$tablefields=array('id','supplier','phone_number','date');
	
}	

if(isset($_POST['search']))
{
	$search=$_POST['search'];
	$searching_by =$_POST['searching_by'];
	echo "<center>$lang->searchedForSupplier: <b>$search</b></center>";
	
	 $display->displayManageTable("$cfg_tableprefix",'suppliers',$tableheaders,$tablefields,"$searching_by","$search",'supplier');
	  
	}
elseif(isset($_GET['backtosupplier']))
{	
   $supplierid=$_GET['backtosupplier'];
   $search=$supplierid;
	$searching_by =id;
   $display->displayManageTable("$cfg_tableprefix",'suppliers',$tableheaders,$tablefields,"$searching_by","$search",'supplier');
	  
   
}
elseif(isset($_GET['usingsearch']))
{
  $searching_by=$_GET['searching_by'];
  $search=$_GET['search'];

   $display->displayManageTable("$cfg_tableprefix",'suppliers',$tableheaders,$tablefields,"$searching_by","$search",'supplier');
   
}
elseif(isset($_GET['searchall']))
{
  $searching_by='ALL';
  $search=$_GET['search'];

   $display->displayManageTable("$cfg_tableprefix",'suppliers',$tableheaders,$tablefields,"$searching_by","$search",'supplier');
   
}
else
{
	   
      $display->displayManageTable("$cfg_tableprefix",'suppliers',$tableheaders,$tablefields,'','','id');
	  
	}  



$dbf->closeDBlink();

?>
</body>
</html>