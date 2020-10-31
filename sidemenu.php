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


<TABLE BORDER=0 CELLPADDING=1 >
<tr>  
<TD><font face="Verdana" size="2"><a href="items/suppliers/manage_suppliers.php" TARGET="MainFrame"><img src="je_images/bt_buy_item.png" onmouseover="this.src='je_images/bt_buy_item_MouseOver.png';" onmouseout="this.src='je_images/bt_buy_item.png';" 
width="80" height="80" BORDER="0"></a></font></TD>
<?php $cfg_common_supplierNcustomers_allstores = 'no';  ?>
<?php if ($cfg_common_supplierNcustomers_allstores == "yes"){ ?>

<TD><font face="Verdana" size="2"><a href="sales/sale_ui_commonSC.php" TARGET="MainFrame"><img src="je_images/bt_sell_item.png" onmouseover="this.src='je_images/bt_sell_item_MouseOver.png';" onmouseout="this.src='je_images/bt_sell_item.png';"  
width="80" height="80" BORDER="0"></a></font></TD> 
<?php }else{ ?>

<TD><font face="Verdana" size="2"><a href="sales/sale_ui.php" TARGET="MainFrame"><img src="je_images/bt_sell_item.png" onmouseover="this.src='je_images/bt_sell_item_MouseOver.png';" onmouseout="this.src='je_images/bt_sell_item.png';"  
width="80" height="80" BORDER="0"></a></font></TD>   
<?php } ?>    	
</TR>

<TR>
	<TD><font face="Verdana" size="2"><a href="items/addto_inventory.php" TARGET="MainFrame"><img src="je_images/bt_add_to_inventory.png" onmouseover="this.src='je_images/bt_add_to_inventory_MouseOver.png';" onmouseout="this.src='je_images/bt_add_to_inventory.png';"
width="80" height="80" BORDER="0"></a></font></TD>  
	<TD><font face="Verdana" size="2"><a href="items/manage_items.php" TARGET="MainFrame"><img src="je_images/bt_lookup_item.png" onmouseover="this.src='je_images/bt_lookup_item_MouseOver.png';" onmouseout="this.src='je_images/bt_lookup_item.png';"
width="80" height="80" BORDER="0"></a></font></TD>    

</TR>

<TR>
	<TD><font face="Verdana" size="2"><a href="items/manage_item_trans.php" TARGET="MainFrame"><img src="je_images/bt_lookup_transaction.png" onmouseover="this.src='je_images/bt_lookup_transaction_MouseOver.png';" onmouseout="this.src='je_images/bt_lookup_transaction.png';"
width="80" height="80" BORDER="0"></a></font></TD>
	<TD><font face="Verdana" size="2"><a href="customers/manage_customers.php" TARGET="MainFrame"><img src="je_images/bt_lookup_customer.png" onmouseover="this.src='je_images/bt_lookup_customer_MouseOver.png';" onmouseout="this.src='je_images/bt_lookup_customer.png';"
width="80" height="80" BORDER="0"></a></font></TD> 
	

</TR>

<TR>
	<TD><font face="Verdana" size="2"><a href="items/viewallstore_inventory.php" TARGET="MainFrame"><img src="je_images/bt_search_allstore_inventory.png" onmouseover="this.src='je_images/bt_search_allstore_inventory_MouseOver.png';" onmouseout="this.src='je_images/bt_search_allstore_inventory.png';"
width="80" height="80" BORDER="0"></a></font></TD> 
	<TD><font face="Verdana" size="2"><a href="reports/index.php" TARGET="MainFrame"><img src="je_images/bt_reports.png" onmouseover="this.src='je_images/bt_reports_MouseOver.png';" onmouseout="this.src='je_images/bt_reports.png';"
width="80" height="80" BORDER="0"></a></font></TD>
</TR>

<TR>
<TD><font face="Verdana" size="2"><a href="returns/manage_sales.php" TARGET="MainFrame"><img src="je_images/bt_refund_item.png" onmouseover="this.src='je_images/bt_refund_item_MouseOver.png';" onmouseout="this.src='je_images/bt_refund_item.png';"  
width="80" height="80" BORDER="0"></a></font></TD>

<TD><font face="Verdana" size="2"><a href="je_admin_panel.php" TARGET="MainFrame"><img src="je_images/bt_admin_panel.png" onmouseover="this.src='je_images/bt_admin_panel_MouseOver.png';" onmouseout="this.src='je_images/bt_admin_panel.png';"
width="80" height="80" BORDER="0"></a></font></TD> 
</TR>


</table>
  
<?php } elseif($auth=="Sales Clerk") { ?>
<table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" 


<TR> 
<TD><font face="Verdana" size="2"><a href="items/suppliers/manage_suppliers.php" TARGET="MainFrame"><img src="je_images/bt_buy_item.png" onmouseover="this.src='je_images/bt_buy_item_MouseOver.png';" onmouseout="this.src='je_images/bt_buy_item.png';" 
width="80" height="80" BORDER="0"></a></font></TD>	

<TD><font face="Verdana" size="2"><a href="sales/sale_ui.php" TARGET="MainFrame"><img src="je_images/bt_sell_item.png" onmouseover="this.src='je_images/bt_sell_item_MouseOver.png';" onmouseout="this.src='je_images/bt_sell_item.png';"
width="80" height="80" BORDER="0"></a></font></TD>  	
</TR>

<TR> 
<TD><font face="Verdana" size="2"><a href="items/addto_inventory.php" TARGET="MainFrame"><img src="je_images/bt_add_to_inventory.png" onmouseover="this.src='je_images/bt_add_to_inventory_MouseOver.png';" onmouseout="this.src='je_images/bt_add_to_inventory.png';"
width="80" height="80" BORDER="0"></a></font></TD> 	

<TD><font face="Verdana" size="2"><a href="items/manage_items.php" TARGET="MainFrame"><img src="je_images/bt_lookup_item.png" onmouseover="this.src='je_images/bt_lookup_item_MouseOver.png';" onmouseout="this.src='je_images/bt_lookup_item.png';"
width="80" height="80" BORDER="0"></a></font></TD>   	
	
</TR>

<TR>
	<TD><font face="Verdana" size="2"><a href="items/viewallstore_inventory.php" TARGET="MainFrame"><img src="je_images/bt_search_allstore_inventory.png" onmouseover="this.src='je_images/bt_search_allstore_inventory_MouseOver.png';" onmouseout="this.src='je_images/bt_search_allstore_inventory.png';"
width="80" height="80" BORDER="0"></a></font></TD>  

	<TD><font face="Verdana" size="2"><a href="customers/index.php" TARGET="MainFrame"><img src="je_images/bt_manage_customers.png" onmouseover="this.src='je_images/bt_manage_customers_MouseOver.png';" onmouseout="this.src='je_images/bt_manage_customers.png';"
width="80" height="80" BORDER="0"></a></font></TD> 
</TR>

<TR>
<TD><font face="Verdana" size="2"><a href="items/manage_item_trans.php" TARGET="MainFrame"><img src="je_images/bt_lookup_transaction.png" onmouseover="this.src='je_images/bt_lookup_transaction_MouseOver.png';" onmouseout="this.src='je_images/bt_lookup_transaction.png';"
width="80" height="80" BORDER="0"></a></font></TD> 

<TD><font face="Verdana" size="2"><a href="returns/manage_sales.php" TARGET="MainFrame"><img src="je_images/bt_refund_item.png" onmouseover="this.src='je_images/bt_refund_item_MouseOver.png';" onmouseout="this.src='je_images/bt_refund_item.png';"  
width="80" height="80" BORDER="0"></a></font></TD>

</TR>

<?php
}
else
{
?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" 

bordercolor="#111111" width="550" id="AutoNumber1">
  <TD><font face="Verdana" size="2"><a href="reports/index.php" TARGET="MainFrame"><img src="je_images/bt_reports.png" onmouseover="this.src='je_images/bt_reports_MouseOver.png';" onmouseout="this.src='je_images/bt_reports.png';"
width="80" height="80" BORDER="0"></a></font></TD>

</table>


<?php
}
$dbf->closeDBlink();

?>

