<?php session_start();
include ("../settings.php");
include ("../../../../$cfg_configfile");
include("../language/$cfg_language");
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


if ($cfg_dvdlookup_version=="1"){ 
echo "
<html>
<body>
<head>

</head>

<p><img border=\"0\" src=\"../images/customers.gif\" width=\"41\" height=\"33\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>$lang->addtoinventory Panel</b></font></p>
<center><font face=\"Verdana\" size=\"2\">$lang->addtoinventoryWelcomeScreen</font></center>


<ul>
	<center>
<TABLE BORDER=\"0\" CELLPADDING=\"10\" >
  <tr>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items.php?action=insert\"><img src=\"../je_images/bt_buyadd_items_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_items_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_items_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_dvd.php?action=insert\"><img src=\"../je_images/bt_buyadd_movies_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_movies_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_movies_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_videogame_dvd.php?action=insert\"><img src=\"../je_images/bt_buyadd_games_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_games_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_games_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
   
   <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_buy_jewelry.php?action=insert\"><img src=\"../je_images/bt_buy_jewelry.png\" onmouseover=\"this.src='../je_images/bt_buy_jewelry_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buy_jewelry.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
	
	<TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_jewelry.php?action=insert&addjewelrytoinventory=yes\"><img src=\"../je_images/bt_addscrapgold_to_invforresale.png\" onmouseover=\"this.src='../je_images/bt_addscrapgold_to_invforresale_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_addscrapgold_to_invforresale.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
	
  </tr>
</table>
</ul>


</body>
</html>";
}

if ($cfg_dvdlookup_version=="2"){ 
echo "
<html>
<body>
<head>

</head>

<p><img border=\"0\" src=\"../je_images/inventory_icon.png\" width=\"41\" height=\"33\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>$lang->addtoinventory Panel</b></font></p>
<center><font face=\"Verdana\" size=\"2\">$lang->addtoinventoryWelcomeScreen</font></center>


<ul>
	<center>
<TABLE BORDER=\"0\" CELLPADDING=\"10\" >
  <tr>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items.php?action=insert\"><img src=\"../je_images/bt_buyadd_items_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_items_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_items_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_dvd_v2.php?action=insert\"><img src=\"../je_images/bt_buyadd_movies_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_movies_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_movies_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_videogame_dvd_v2.php?action=insert\"><img src=\"../je_images/bt_buyadd_games_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_games_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_games_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
   
   <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_buy_jewelry.php?action=insert\"><img src=\"../je_images/bt_buy_jewelry.png\" onmouseover=\"this.src='../je_images/bt_buy_jewelry_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buy_jewelry.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
	
	<TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_jewelry.php?action=insert&addjewelrytoinventory=yes\"><img src=\"../je_images/bt_addscrapgold_to_invforresale.png\" onmouseover=\"this.src='../je_images/bt_addscrapgold_to_invforresale_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_addscrapgold_to_invforresale.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
    
  </tr>
</table>
</ul>


<p><img border=\"0\" src=\"../je_images/note_icon.png\" width=\"41\" height=\"33\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>Read Before Processing Jewelry/Gold</b></font></p>

</font></b><b><font color='green'>1- Buy Jewelry button - Allows you to buy Jewelry/Gold as Scrap or ReSale.  <br> 
</font></b><b><font color='green'>&nbsp; &nbsp; &nbsp; Scrap buy - Will not add the Jewelry to store Inventory therefore you can not sale the Jewelry in store.  <br>
</font></b><b><font color='green'>&nbsp; &nbsp; &nbsp; ReSale buy - Will add the Jewelry to store Inventory so you can create barcode and sale the Jewelry in store.  <br><br>
</font></b><b><font color='green'>2- Add Scrap Gold to Inv for ReSale button - Allows you to Resale Jewelry you already bought as Scrap using Buy Jewelry button. <br>
</font></b><b><font color='green'>&nbsp; &nbsp; &nbsp; This will add the Scrap Jewelry to store inventory so you can create barcode and sale in store.  <br>
<br>
</font></b><b><font color='green'>Please NOTE \"Add Scrap Gold to Inv for ReSale\" button should only be used to add Scrap Jewelry you already bought using the \"Buy Jewelry\" button.   <br>
<br>
</font></b><b><font color='blue'>If the above method is not followed your financial reports will be inaccurate. <br>

</body>
</html>";

}
if ($cfg_dvdlookup_version=="3"){ 
echo "
<html>
<body>
<head>

</head>

<p><img border=\"0\" src=\"../je_images/inventory_icon.png\" width=\"41\" height=\"33\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>$lang->addtoinventory Panel</b></font></p>
<center><font face=\"Verdana\" size=\"2\">$lang->addtoinventoryWelcomeScreen</font></center>


<ul>
	<center>
<TABLE BORDER=\"0\" CELLPADDING=\"10\" >
  <tr>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items.php?action=insert\"><img src=\"../je_images/bt_buyadd_items_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_items_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_items_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_dvd_v3.php?action=insert\"><img src=\"../je_images/bt_buyadd_movies_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_movies_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_movies_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
    <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_videogame_dvd_v3.php?action=insert\"><img src=\"../je_images/bt_buyadd_games_inventory.png\" onmouseover=\"this.src='../je_images/bt_buyadd_games_inventory_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buyadd_games_inventory.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
   
   <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_buy_jewelry.php?action=insert\"><img src=\"../je_images/bt_buy_jewelry.png\" onmouseover=\"this.src='../je_images/bt_buy_jewelry_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_buy_jewelry.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
	
	<TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items_jewelry.php?action=insert&addjewelrytoinventory=yes\"><img src=\"../je_images/bt_addscrapgold_to_invforresale.png\" onmouseover=\"this.src='../je_images/bt_addscrapgold_to_invforresale_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_addscrapgold_to_invforresale.png';\"
    width=\"80\" height=\"80\" BORDER=\"0\"></a></font></TD>
    
    
  </tr>
</table>
</ul>


<p><img border=\"0\" src=\"../je_images/note_icon.png\" width=\"41\" height=\"33\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>Read Before Processing Jewelry/Gold</b></font></p>

</font></b><b><font color='green'>1- Buy Jewelry button - Allows you to buy Jewelry/Gold as Scrap or ReSale.  <br> 
</font></b><b><font color='green'>&nbsp; &nbsp; &nbsp; Scrap buy - Will not add the Jewelry to store Inventory therefore you can not sale the Jewelry in store.  <br>
</font></b><b><font color='green'>&nbsp; &nbsp; &nbsp; ReSale buy - Will add the Jewelry to store Inventory so you can create barcode and sale the Jewelry in store.  <br><br>
</font></b><b><font color='green'>2- Add Scrap Gold to Inv for ReSale button - Allows you to Resale Jewelry you already bought as Scrap using Buy Jewelry button. <br>
</font></b><b><font color='green'>&nbsp; &nbsp; &nbsp; This will add the Scrap Jewelry to store inventory so you can create barcode and sale in store.  <br>
<br>
</font></b><b><font color='green'>Please NOTE \"Add Scrap Gold to Inv for ReSale\" button should only be used to add Scrap Jewelry you already bought using the \"Buy Jewelry\" button.   <br>
<br>
</font></b><b><font color='blue'>If the above method is not followed your financial reports will be inaccurate. <br>


</body>
</html>";

}
$dbf->closeDBlink();


?>
