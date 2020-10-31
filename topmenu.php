<?php session_start();

include ("settings.php");
include ("../../../$cfg_configfile");
include("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);


if(!$sec->isLoggedIn())
{
header ("location: login.php");
exit();
}
$tablename = $cfg_tableprefix.'users';
$auth = $dbf->idToField($tablename,'type',$_SESSION['session_user_id']);
$first_name = $dbf->idToField($tablename,'first_name',$_SESSION['session_user_id']);
$last_name= $dbf->idToField($tablename,'last_name',$_SESSION['session_user_id']);

$name=$first_name.' '.$last_name;
$dbf->optimizeTables();

?>
<HTML>
<head> 
<STYLE TYPE="text/css">

</STYLE>

</head>
<body bgcolor = #FFFFFF>
<?php 
if($auth=="Admin") 
{ 
?>


<center>
<TABLE BORDER=2 CELLPADDING=5  >
<TD width="100" height="10" valign="top" bgcolor==#008000>
<center><font face="Verdana" size="2"><a href="items/suppliers/manage_suppliers.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Buy Item</font></b></a></font></center>
</TD>


<TD width="100" height="10" valign="top" bgcolor==#0000A0>
<?php $cfg_common_supplierNcustomers_allstores = 'no';  ?>
<?php if ($cfg_common_supplierNcustomers_allstores == "yes"){ ?>

<center><font face="Verdana" size="2"><a href="sales/sale_ui_commonSC.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Sell Item</font></b></a></font></center> 


<?php }else{ ?>
<center><font face="Verdana" size="2"><a href="sales/sale_ui.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Sell Item</font></b></a></font></center>

<?php } ?>    	
</TD>

<TD width="100" height="10" valign="top" bgcolor==#008000>

	<center><font face="Verdana" size="2"><a href="items/addto_inventory.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Add to Inventory</font></b></a></font></center>  
</TD>

<TD width="100" height="10" valign="top" bgcolor==#0000A0>	
	<center><font face="Verdana" size="2"><a href="items/manage_items.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Item</font></b></a></font></center>   

</TD>

<TD width="100" height="10" valign="top" bgcolor==#008000>
	<center><font face="Verdana" size="2"><a href="items/manage_item_trans.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Transaction</font></b></a></font></center>
</TD>
<TD width="100" height="10" valign="top" bgcolor==#0000A0>
	<center><font face="Verdana" size="2"><a href="customers/manage_customers.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Customer</font></b></a></font></center> 
</TD>	

<TD width="150" height="10" valign="top" bgcolor==#008000>
	<center><font face="Verdana" size="2"><a href="items/viewallstore_inventory.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Search All Stores Inventory</font></b></a></font></center> 
	
</TD>
<TD width="100" height="10" valign="top" bgcolor==#0000A0>	
	
	<center><font face="Verdana" size="2"><a href="reports/index.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Reports</font></b></a></font></center>
</TD>

<TD width="100" height="10" valign="top" bgcolor==#008000>
<center><font face="Verdana" size="2"><a href="returns/manage_sales.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Refund</font></b></a></font></center>
</TD>

<TD width="100" height="10" valign="top" bgcolor==#0000A0>
<center><font face="Verdana" size="2"><a href="je_admin_panel.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Admin Panel</font></b></a></font></center>
</TD>

</table>
</center>  
<?php } elseif($auth=="Sales Clerk") { ?>
<center>
<table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" >

<TD width="100" height="10" valign="top" bgcolor==#008000>
<center><font face="Verdana" size="2"><a href="items/suppliers/manage_suppliers.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Buy Item</font></b></a></font></center>
</TD>

<TD width="100" height="10" valign="top" bgcolor==#0000A0>
<?php $cfg_common_supplierNcustomers_allstores = 'no'; ?>
<?php if ($cfg_common_supplierNcustomers_allstores == "yes"){ ?>

<center><font face="Verdana" size="2"><a href="sales/sale_ui_commonSC.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Sell Item</font></b></a></font></center> 


<?php }else{ ?>
<center><font face="Verdana" size="2"><a href="sales/sale_ui.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Sell Item</font></b></a></font></center>

<?php } ?>    	
</TD>

<TD width="100" height="10" valign="top" bgcolor==#008000>

	<center><font face="Verdana" size="2"><a href="items/addto_inventory.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Add to Inventory</font></b></a></font></center>  
</TD>

<TD width="100" height="10" valign="top" bgcolor==#0000A0>	
	<center><font face="Verdana" size="2"><a href="items/manage_items.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Item</font></b></a></font></center>   

</TD>

<TD width="100" height="10" valign="top" bgcolor==#008000>
	<center><font face="Verdana" size="2"><a href="items/manage_item_trans.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Transaction</font></b></a></font></center>
</TD>
<TD width="100" height="10" valign="top" bgcolor==#0000A0>
	<center><font face="Verdana" size="2"><a href="customers/manage_customers.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Customer</font></b></a></font></center> 
</TD>	

<TD width="150" height="10" valign="top" bgcolor==#008000>
	<center><font face="Verdana" size="2"><a href="items/viewallstore_inventory.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Search All Stores Inventory</font></b></a></font></center> 
	
</TD>

<TD width="100" height="10" valign="top" bgcolor==#0000A0>
<center><font face="Verdana" size="2"><a href="returns/manage_sales.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Refund</font></b></a></font></center>
</TD>

</center>
<?php
}
else
{
?>
<center>
<table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" >

  <TD width="100" height="10" valign="top" bgcolor==#E8E8E8>	
	
	<center><font face="Verdana" size="2"><a href="reports/index.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Reports</font></b></a></font></center>
</TD>
</table>
</center>


<?php
}
$dbf->closeDBlink();

?>

