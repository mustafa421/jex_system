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
<p>
<img border="0" src="je_images/adminpanel_icon.png" width="53" height="49" valign="top"><font color="#005B7F" size="4">&nbsp;<b><?php echo "Admin Panel" ?></b></font></p>
<p><center><font face="Verdana" size="2" color=blue><?php echo "$lang->welcomeTo $cfg_company $lang->adminHomeWelcomeMessage"; ?> </font></center></p>
<ul>
	<center>

<TABLE BORDER=0 CELLPADDING=10 >
<tr> 
	 
<TD><font face="Verdana" size="2"><a href="sales/index.php" TARGET="MainFrame"><img src="je_images/bt_manage_sales.png" onmouseover="this.src='je_images/bt_manage_sales_MouseOver.png';" onmouseout="this.src='je_images/bt_manage_sales.png';" 
width="80" height="80" BORDER="0"></a></font></TD>  
<TD><font face="Verdana" size="2"><a href="items/index.php"><img src="je_images/bt_manage_inventory.png" onmouseover="this.src='je_images/bt_manage_inventory_MouseOver.png';" onmouseout="this.src='je_images/bt_manage_inventory.png';"
width="80" height="80" BORDER="0"></a></font></TD>   
<TD><font face="Verdana" size="2"><a href="users/index.php"><img src="je_images/bt_manage_users.png" onmouseover="this.src='je_images/bt_manage_users_MouseOver.png';" onmouseout="this.src='je_images/bt_manage_users.png';"
width="80" height="80" BORDER="0"></a></font></TD>     
	
</TR>

<TR> 
	<TD><font face="Verdana" size="2"><a href="customers/index.php"><img src="je_images/bt_manage_customers.png" onmouseover="this.src='je_images/bt_manage_customers_MouseOver.png';" onmouseout="this.src='je_images/bt_manage_customers.png';"
width="80" height="80" BORDER="0"></a></font></TD>    
<TD><font face="Verdana" size="2"><a href="reports/index.php"><img src="je_images/bt_reports.png" onmouseover="this.src='je_images/bt_reports_MouseOver.png';" onmouseout="this.src='je_images/bt_reports.png';"
width="80" height="80" BORDER="0"></a></font></TD>
<TD><font face="Verdana" size="2"><a href="settings/index.php"><img src="je_images/bt_store_setting.png" onmouseover="this.src='je_images/bt_store_setting_MouseOver.png';" onmouseout="this.src='je_images/bt_store_setting.png';"
width="80" height="80" BORDER="0"></a></font></TD>	
</TR>

<TR> 

<TD><font face="Verdana" size="2"><a href="items/checks/index.php"><img src="je_images/bt_managecheck.png" onmouseover="this.src='je_images/bt_managecheck_MouseOver.png';" onmouseout="this.src='je_images/bt_managecheck.png';"
width="80" height="80" BORDER="0"></a></font></TD>

<TD><font face="Verdana" size="2"><a href="settings_barcode_edit.php"><img src="je_images/barcode_settings.png" onmouseover="this.src='je_images/barcode_settings_MouseOver.png';" onmouseout="this.src='je_images/barcode_settings.png';"
width="80" height="80" BORDER="0"></a></font></TD>

<td><font face="Verdana" size="2"><a href="<?php echo "backupDB.php?onlyDB=$cfg_database&StartBackup=complete&nohtml=1"?>"><img src="je_images/bt_backup_database.png" onmouseover="this.src='je_images/bt_backup_database_MouseOver.png';" onmouseout="this.src='je_images/bt_backup_database.png';"
width="80" height="80" BORDER="0"></a></font></td>
</TR>





</center>
</table>
  
</ul>
<?php } elseif($auth=="Sales Clerk") { ?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" 

bordercolor="#111111" width="550" id="AutoNumber1">
  <tr>
    <td width="37">
    <img border="0" src="images/home_print.gif" width="33" height="29"></td>
    <td width="513"><font face="Verdana" size="4" color="#336699"><?php echo "$name 
    $lang->home" ?></font></td>
  </tr>
</table>
<p><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->salesClerkHomeWelcomeMessage"; ?>
<?php
}
else
{
?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" 

bordercolor="#111111" width="550" id="AutoNumber1">
  <tr>
    <td width="37">
    <img border="0" src="images/home_print.gif" width="33" height="29"></td>
    <td width="513"><font face="Verdana" size="4" color="#336699"><?php echo "$name 
    $lang->home"?></font></td>
  </tr>
</table>
<p><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->reportViewerHomeWelcomeMessage"; ?>


<?php
}
$dbf->closeDBlink();

?>
