<?php session_start();

include ("../settings.php");
include ("../../../../$cfg_configfile");
include("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);


if(!$sec->isLoggedIn())
{
header ("location: ../login.php");
exit();
}
$tablename = $cfg_tableprefix.'users';
$auth = $dbf->idToField($tablename,'type',$_SESSION['session_user_id']);
$first_name = $dbf->idToField($tablename,'first_name',$_SESSION['session_user_id']);
$last_name= $dbf->idToField($tablename,'last_name',$_SESSION['session_user_id']);

$name=$first_name.' '.$last_name;
$dbf->optimizeTables();



?>


<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="styles.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="script.js"></script>
   <title>Menu</title>
</head>
<body>

<?php 
if($auth=="Admin") 
{ 
?>

<div id='cssmenu'>
<ul>
<li><a href="#" onClick="window.open('../home.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Home</span></a></li>
  
<li><a class="active" href="#" onClick="window.open('../items/suppliers/manage_suppliers.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Buy</span></a></li>

<li><a class="active" href="#" onClick="window.open('../sales/sale_ui.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Sell</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/addto_inventory.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Add to Inventory</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/manage_items.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>LookUP Item</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/manage_item_trans.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>LookUP Transaction</span></a></li>

<li><a class="active" href="#" onClick="window.open('../customers/manage_customers.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>LookUP Customer</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/viewallstore_inventory.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>All Stores Inventory</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/bulkload/index.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Purchase Order</span></a></li>

<li><a class="active" href="#" onClick="window.open('../returns/manage_sales.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Refund</span></a></li>

<li><a class="active" href="#" onClick="window.open('../reports/index.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Reports</span></a></li>


<li><a class="active" href="#" onClick="window.open('../je_admin_panel.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Admin Panel</span></a></li>
</ul>
</div>

<?php } elseif($auth=="Sales Clerk") { ?>
<div id='cssmenu'>
<ul>

<li><a href="#" onClick="window.open('../home.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Home</span></a></li>
  
<li><a class="active" href="#" onClick="window.open('../items/suppliers/manage_suppliers.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Buy</span></a></li>

<li><a class="active" href="#" onClick="window.open('../sales/sale_ui.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Sell</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/addto_inventory.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Add to Inventory</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/manage_items.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>LookUP Item</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/manage_item_trans.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>LookUP Transaction</span></a></li>

<li><a class="active" href="#" onClick="window.open('../customers/manage_customers.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>LookUP Customer</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/viewallstore_inventory.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>All Stores Inventory</span></a></li>

<li><a class="active" href="#" onClick="window.open('../items/bulkload/index.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Purchase Order</span></a></li>

<li><a class="active" href="#" onClick="window.open('../returns/manage_sales.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Refund</span></a></li>

</ul>
</div>
<?php }else{ ?>
<div id='cssmenu'>
<ul>
  <li><a class="active" href="#" onClick="window.open('../reports/index.php','MainFrame','toolbar=0,scrollbars=1,width=880,height=300,resizable=0');return false;"><span>Reports</span></a></li>
   </ul>
</div> 
<?php
}
$dbf->closeDBlink();

?> 


</body>
<html>
