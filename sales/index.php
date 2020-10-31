<?php session_start();
include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);
if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}
echo "
<html>
<body>
<head>

</head>

<p><img border=\"0\" src=\"../images/sales.gif\" width=\"30\" height=\"31\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>$lang->sales</b></font></p>
<br>
<p><center><font face=\"Verdana\" size=\"2\">$lang->salesWelcomeMessage</font></center></P>


<ul>
	<center>
<TABLE BORDER=\"0\" CELLPADDING=\"10\" >
  <tr>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"sale_ui.php\"><img src=\"../je_images/bt_process_sale.png\" onmouseover=\"this.src='../je_images/bt_process_sale_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_process_sale.png';\"
    width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
        
   <TD><font face=\"Verdana\" size=\"2\"><a href=\"manage_sales.php\"><img src=\"../je_images/bt_update_sale.png\" onmouseover=\"this.src='../je_images/bt_update_sale_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_update_sale.png';\"
   width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
  
  </tr>
</table>
</ul>
</body>
</html>";

$dbf->closeDBlink();


?>
