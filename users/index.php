<?php session_start(); ?>

<html>
<head>


</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/users_display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

$display->displayTitle("$lang->users");
$dbf->closeDBlink();

?>
		
		
<ul>
	<center>
<TABLE BORDER=\"0\" CELLPADDING=\"10\" >
  <tr>
    
    <TD><font face="Verdana" size="2"><a href="form_users.php?action=insert"><img src="../je_images/bt_create_user.png" onmouseover="this.src='../je_images/bt_create_user_MouseOver.png';" onmouseout="this.src='../je_images/bt_create_user.png';"
    	width="80" height="80" BORDER="1"></a></font></TD>
        
    <TD><font face="Verdana" size="2"><a href="manage_users.php"><img src="../je_images/bt_update_user.png" onmouseover="this.src='../je_images/bt_update_user_MouseOver.png';" onmouseout="this.src='../je_images/bt_update_user.png';"
    	width="80" height="80" BORDER="1"></a></font></TD>
  
   
  </tr>
</table>
</ul>



</body>
</html>