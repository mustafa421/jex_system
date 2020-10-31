<?php session_start();
include ("../settings.php");
include ("../../../../$cfg_configfile");
include("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

echo "
<html>
<body>
<p><img border=\"0\" src=\"../images/items.gif\" width=\"32\" height=\"33\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>$lang->items</b></font></p>


<center>
<TABLE BORDER=\"0\" CELLPADDING=\"5\" >
<tr>    
      <td><P><B> Manage Items--> </B></P></td>
      <TD><font face=\"Verdana\" size=\"2\"><a href=\"form_items.php?action=insert\"><img src=\"../je_images/bt_enter_new_item.png\" onmouseover=\"this.src='../je_images/bt_enter_new_item_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_enter_new_item.png';\"
      width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
      
      <TD><font face=\"Verdana\" size=\"2\"><a href=\"discounts/form_discounts.php?action=insert\"><img src=\"../je_images/bt_discount_item.png\" onmouseover=\"this.src='../je_images/bt_discount_item_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_discount_item.png';\"
      width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
      
      <TD><font face=\"Verdana\" size=\"2\"><a href=\"discounts/manage_discounts.php\"><img src=\"../je_images/bt_update_discounted_item.png\" onmouseover=\"this.src='../je_images/bt_update_discounted_item_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_update_discounted_item.png';\"
      width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
		
      <TD><font face=\"Verdana\" size=\"2\"><a href=\"manage_items.php\"><img src=\"../je_images/bt_manage_items.png\" onmouseover=\"this.src='../je_images/bt_manage_items_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_manage_items.png';\"
      width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
    
  </tr> 	
  <tr> 
     <TD><P><B> Manage Articles--> </B></P></TD>
        <TD><font face=\"Verdana\" size=\"2\"><a href=\"buyarticles/form_articles.php?action=insert\"><img src=\"../je_images/bt_enter_new_article.png\" onmouseover=\"this.src='../je_images/bt_enter_new_article_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_enter_new_article.png';\"
        width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
        
        <TD><font face=\"Verdana\" size=\"2\"><a href=\"buyarticles/manage_articles.php\"><img src=\"../je_images/bt_update_articles.png\" onmouseover=\"this.src='../je_images/bt_update_articles_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_update_articles.png';\"
        width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
     </tr> 
  <tr>
      <TD><P><B> Manage Categories--> </B></P></TD>
        <TD><font face=\"Verdana\" size=\"2\"><a href=\"categories/form_categories.php?action=insert\"><img src=\"../je_images/bt_enter_new_category.png\" onmouseover=\"this.src='../je_images/bt_enter_new_category_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_enter_new_category.png';\"
        width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
        
        <TD><font face=\"Verdana\" size=\"2\"><a href=\"categories/manage_categories.php\"><img src=\"../je_images/bt_update_category.png\" onmouseover=\"this.src='../je_images/bt_update_category_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_update_category.png';\"
        width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
      </tr>
  

       <tr>
       <TD><P><B> Manage Suppliers--> </B></P></TD>
        <TD><font face=\"Verdana\" size=\"2\"><a href=\"suppliers/form_suppliers.php?action=insert\"><img src=\"../je_images/bt_enter_new_supplier.png\" onmouseover=\"this.src='../je_images/bt_enter_new_supplier_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_enter_new_supplier.png';\"
        width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
        
        <TD><font face=\"Verdana\" size=\"2\"><a href=\"suppliers/manage_suppliers.php\"><img src=\"../je_images/bt_update_supplier.png\" onmouseover=\"this.src='../je_images/bt_update_supplier_MouseOver.png';\" onmouseout=\"this.src='../je_images/bt_update_supplier.png';\"
        width=\"80\" height=\"80\" BORDER=\"1\"></a></font></TD>
      
      <p>&nbsp;</td>
  </tr>
</table>
</center>
</body>

</html>";
$dbf->closeDBlink();

?>
