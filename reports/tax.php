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
include ("../classes/display.php");
include ("../classes/form.php");

$lang= new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);
if(!$sec->isLoggedIn())
{
    header ("location: ../login.php");
    exit();
}

if(isset($_POST['date_range']))
{
	$date_range=$_POST['date_range'];
	$dates=explode(':',$date_range);
	$date1=$dates[0];
	$date2=$dates[1];
	$tax_percent=$_POST['selected_tax'];
}

$sales_table=$cfg_tableprefix.'sales';
$sales_items_table=$cfg_tableprefix.'sales_items';

$display_name=$tax_percent.'%';
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$cfg_company $lang->taxReport");

$tableheaders=array("$lang->saleID","$lang->itemName","$lang->tax","$lang->saleTotalCost");
$tablefields=array('sale_id','item_id','item_total_tax','item_total_cost');

$result=mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER BY id DESC",$dbf->conn);
$result2=mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER BY id ASC",$dbf->conn);
$row=mysql_fetch_assoc($result);
$high_id=$row['id'];
$row=mysql_fetch_assoc($result2);
$low_id=$row['id'];




$result3=mysql_query("select a.id,b.sale_id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,
a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.quantity_purchased,
b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,
b.item_total_cost from jestore_sales a, 
jestore_sales_items b where a.id = b.sale_id and 
b.refundtype=''  and a.date between \"$date1\" and \"$date2\" ORDER by sale_id DESC",$dbf->conn);

echo "<center><h4><font color='$display->list_of_color'>$lang->listOfSalesFor $display_name<br>$lang->between $date1 $lang->and $date2</font></h4></center>";
echo '<hr>';
		if(@mysql_num_rows($result) ==0)
		{
			echo "<div align='center'>$lang->noDataInTable <b>$sales_table</b> $lang->table.</div>";
			exit();
		}
		echo "<table cellspacing='$display->cellspacing' cellpadding='$display->cellpadding' bgcolor='$display->table_bgcolor' width='50%' style=\"border: $display->border_style $display->border_color $display->border_width px\" align='center'>
		
		<tr bgcolor=$display->header_rowcolor>\n\n";
		for($k=0;$k< count($tableheaders);$k++)
		{
			echo "<th align='center'>\n<font color='$display->header_text_color' face='$display->headerfont_face' size='$display->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
		}
		echo '</tr>'."\n\n";	
		$rowCounter=0;
		$subtotal=0;
		$total=0;
		
		while($row=mysql_fetch_assoc($result3))
		{
			$tax_percent_of_item=$row['item_tax_percent'];
			if($tax_percent==$tax_percent_of_item)
			{
				if($rowCounter%2==0)
				{
					echo "\n<tr bgcolor=$display->rowcolor1>\n";
				}
				else
				{
					echo "\n<tr bgcolor=$display->rowcolor2>\n";
				}
				$rowCounter++;
				for($k=0;$k<count($tablefields);$k++)
				{
					$field=$tablefields[$k];
					if($field=='brand_id' or $field=='category_id' or $field=='supplier_id')
					{
						$field_data=$display->idToField("$cfg_tableprefix".'items',"$field",$row['item_id']);
						$data=$display->formatData($field,$field_data,$cfg_tableprefix);
					}
					else
					{
						$data=$display->formatData($field,$row[$field],$cfg_tableprefix);
					
					}
			
				
					echo "\n<td  align='center'>\n<font color='$display->rowcolor_text' face='$display->rowfont_face' size='$display->rowfont_size'>$data</font>\n</td>\n";
				}
				
				@$subtotal+=$row['item_total_cost']-$row['item_total_tax'];
				@$total+=$row['item_total_cost'];

			
			}		
		}	
						echo '</table>'."\n";
						
				$subtotal=number_format($subtotal,2,'.', '');
				$total=number_format($total,2,'.', '');
				$tax=$total-$subtotal;
				$tax=number_format($tax,2,'.', '');

		 		echo "<br><table align='right' cellspacing='$display->cellspacing' cellpadding='$display->cellpadding' bgcolor='$display->table_bgcolor' width='60%' border=0>";
				echo "<tr><td>$lang->totalWithOutTax: <b>$display->currency_symbol$subtotal</b></td></tr>
				<tr><td>$lang->totalWithTax: <b>$display->currency_symbol$total</b></td></tr>
				<tr><td>$lang->tax: <b>$display->currency_symbol$tax</b></td></tr></table>";
?>



</body>
</html> 