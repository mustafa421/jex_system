<?php session_start();

include ("settings.php");
include ("../../../$cfg_configfile");
include ("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");



$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);

$tablename = $cfg_tableprefix.'users';
$auth = $dbf->idToField($tablename,'type',$_SESSION['session_user_id']);
$userLoginName= $dbf->idToField($tablename,'username',$_SESSION['session_user_id']);

$storecityNversion=$cfg_company_city.' '.$cfg_pos_version;


$dbf->closeDBlink();



?>

<HTML>
<HEAD>
<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url)
{
	if(confirm(message) )
  {
    parent.location.href = url;
  }
}
// --->
</SCRIPT>

<style type="text/css">
 
 </style>
<TITLE><?php echo $cfg_company ?>--<?php echo $lang->poweredBy?>Inventory Point Of Sale System</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">

<script type="text/javascript">









var currenttime = '<?PHP print date("F d, Y H:i:s", time())?>' 



var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime)

function padlength(what){
var output=(what.toString().length==1)? "0"+what : what
return output
}

function displaytime(){
serverdate.setSeconds(serverdate.getSeconds()+1)
var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()
var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
document.getElementById("servertime").innerHTML=datestring+" "+timestring
}

window.onload=function(){
setInterval("displaytime()", 1000)
}

</script>

</HEAD>


   <BODY BGCOLOR=#DAA520 LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 background="je_images/je2_menu_bg.png">



<TABLE WIDTH="100%" BORDER=0 align="left" CELLPADDING=0 CELLSPACING=0 style="border-collapse: collapse" bordercolor="#111111">
	<TR>
	
	<?php if ($cfg_menulocation=="header") { ?>
		<TD width="430"background="images/je2_menubar_02.png" height="78" style="cursor: hand;" onClick="window.open('home.php','MainFrame')">
    
	<?php }else{ ?>
	
	     <TD width="430"background="images/je2_menubar_01.png" height="78" style="cursor: hand;" onClick="window.open('home.php','MainFrame')">
    
	<?php } ?>		
			<div align="center">
              <center>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="95%" id="AutoNumber1">
                <tr>
                  <td width="100%"><b>
                  	
                    <P ALIGN=right><font face="Verdana" color="#0000FF" size="3"><?php echo $cfg_company ?></font></b></td>
                </tr>
              </table>
              </center>
            </div>
        </TD>
		
		
		
<?php if (($auth=="Admin") and ($cfg_menulocation=="header")) { ?>

	<TD width="90" height="5" valign="center" bgcolor==#008000 >
<center><font face="Verdana" size="2"><a href="items/suppliers/manage_suppliers.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Buy Item</font></b></a></font></center>
</TD>	
<TD width="90" height="5"  valign="center"  bgcolor==#008080>
<?php $cfg_common_supplierNcustomers_allstores = 'no'; 
<?php if ($cfg_common_supplierNcustomers_allstores == "yes"){ ?>

<center><font face="Verdana" size="2"><a href="sales/sale_ui_commonSC.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Sell Item</font></b></a></font></center> 


<?php }else{ ?>
<center><font face="Verdana" size="2"><a href="sales/sale_ui.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Sell Item</font></b></a></font></center>

<?php } ?>
</TD>

<TD width="90" height="10" valign="center" bgcolor==#008000>

	<center><font face="Verdana" size="2"><a href="items/addto_inventory.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Add to Inventory</font></b></a></font></center>  
</TD>

<TD width="70" height="10" valign="center" bgcolor==#008080>	
	<center><font face="Verdana" size="2"><a href="items/manage_items.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Item</font></b></a></font></center>   

</TD>

<TD width="50" height="10" valign="center" bgcolor==#008000>
<center><font face="Verdana" size="2"><a href="items/manage_item_trans.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Lookup Transaction</font></b></a></font></center>
</TD>

<TD width="100" height="10" valign="center" bgcolor==#008080>
	<center><font face="Verdana" size="2"><a href="customers/manage_customers.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Lookup Customer</font></b></a></font></center> 
	
</TD>

<TD width="100" height="10" valign="center" bgcolor==#008000>
	<center><font face="Verdana" size="2"><a href="items/viewallstore_inventory.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Search All Stores Inventory</font></b></a></font></center> 
	
</TD>
<TD width="90" height="10" valign="center" bgcolor==#008080>	
	
	<center><font face="Verdana" size="2"><a href="reports/index.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Reports</font></b></a></font></center>
</TD>


<TD width="90" height="10" valign="center" bgcolor==#008000>
<center><font face="Verdana" size="2"><a href="returns/manage_sales.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Refund</font></b></a></font></center>
</TD>

<TD width="90" height="10" valign="center" bgcolor==#008080>
<center><font face="Verdana" size="2"><a href="je_admin_panel.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Admin Panel</font></b></a></font></center>
</TD>

		
		
		
	</TR>	
		
	
	
	<?php } if (($auth=="Sales Clerk") and ($cfg_menulocation=="header")) { ?>
	
		
	<TD width="100" height="5" valign="center" bgcolor==#008000 > 
<center><font face="Verdana" size="2"><a href="items/suppliers/manage_suppliers.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Buy Item</font></b></a></font></center>
</TD>
	
<TD width="100" height="5"  valign="center" bgcolor==#008080>
<?php $cfg_common_supplierNcustomers_allstores = 'no'; 
<?php if ($cfg_common_supplierNcustomers_allstores == "yes"){ ?>

<center><font face="Verdana" size="2"><a href="sales/sale_ui_commonSC.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Sell Item</font></b></a></font></center> 


<?php }else{ ?>
<center><font face="Verdana" size="2"><a href="sales/sale_ui.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Sell Item</font></b></a></font></center>

<?php } ?>    	
</TD>

<TD width="100" height="10" valign="center" bgcolor==#008000> 

	<center><font face="Verdana" size="2"><a href="items/addto_inventory.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Add to Inventory</font></b></a></font></center>  
</TD>

<TD width="100" height="10" valign="center" bgcolor==#008080>	
	<center><font face="Verdana" size="2"><a href="items/manage_items.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Item</font></b></a></font></center>   

</TD>

<TD width="100" height="10" valign="center" bgcolor==#008000>
	<center><font face="Verdana" size="2"><a href="items/manage_item_trans.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">LookUP Transaction</font></b></a></font></center>
</TD>
<TD width="100" height="10" valign="center" bgcolor==#008080>
	<center><font face="Verdana" size="2"><a href="customers/index.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Manage Customer</font></b></a></font></center> 
</TD>	



<TD width="150" height="10" valign="center" bgcolor==#008000>
	<center><font face="Verdana" size="2"><a href="items/viewallstore_inventory.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Search All Stores Inventory</font></b></a></font></center> 
	
</TD>

<TD width="100" height="10" valign="center" bgcolor==#008080>
<center><font face="Verdana" size="2"><a href="returns/manage_sales.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Refund</font></b></a></font></center>
</TD>

	<?php } if (($auth=="Report Viewer") and ($cfg_menulocation=="header")) { ?>

<TD width="100" height="10" valign="center" bgcolor==#008000>	
	
	<center><font face="Verdana" size="2"><a href="reports/index.php" style="text-decoration:none" TARGET="MainFrame"><b><font color="white">Reports</font></b></a></font></center>
</TD>

		
	<?php } ?>
	<TR>
		<TD COLSPAN=4 width="609" bgcolor="#0A6184" height="22">
			<div align="center">
              <center>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="97%" id="AutoNumber2">
                <tr>
                  <td width="100%"><b>
                  <font face="Verdana" size="1" color="#FFFFFF">
				  <?php echo $lang->welcome ?>
				  <?php echo $userLoginName; ?>!
				  | <a href="javascript:decision('<?php echo $lang->logoutConfirm ?>','logout.php')"><font color="#FFFFFF">
                  <?php echo $lang->logout ?></font></a></font></b></td>
                </tr>
              </table>
              </center>
            </div>
        </TD>
        
        
		<TD COLSPAN=3 width="400" bgcolor="#0A6184" height="22">
			<div align="center">
              <center>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="95%" id="AutoNumber3">
                <tr>
                  <td width="100%">
                  <p align="left"><b>
                  	<font face="Verdana" size="2" color="#FFFFFF"><?php echo $storecityNversion ?></font></b></td>
                </tr>
              </table>
              </center>
            </div>
        </TD>
        
        
        <TD COLSPAN=3 width="141" bgcolor="#0A6184" height="22">
			<div align="center">
              <center>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="95%" id="AutoNumber3">
                <tr>
                  <td width="100%">
                  <p align="right"><b>
				  
				  <font face="Verdana" size="1" color="#FFFFFF"><p><span id="servertime"></span></p></font></b></td>
              

				
				</tr>
              </table>
			  

			  <TD COLSPAN=3 width="50" bgcolor="#0A6184" height="22">
			<div align="center">
              
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="95%" id="AutoNumber3">
                <tr>
                  <td width="100%">
                  <p align="right"><b>
				  
				  <font face="Verdana" size="1" color="#FFFFFF"><p><span id="servertime"></span></p></font></b></td>
              

				
				</tr>
              </table>
			 
            </div>
             </TD>

			  
              </center>
            </div>
        </TD>
          
	</TR>
	</TABLE>
	<?php

 ?>
	
</BODY>
</HTML>
