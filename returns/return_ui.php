<?php session_start(); 

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
$lang=new language();


if(isset($_GET['update_item']))
{
	$k=$_GET['update_item'];
	$new_price=$_POST["price$k"];
	$new_tax=$_POST["tax$k"];
	$new_quantity=$_POST["quantity$k"];
	$new_total_cost=$_POST["rowTotal$k"];

	$item_info=explode(' ',$_SESSION['items_in_return'][$k]);
	$upc=$item_info[0];
	$unit_price=$item_info[1];
	$tax=$item_info[2];
	$total_cost=$item_info[3];
	$item_id=$item_info[4];
	$quantity=$item_info[5];
	$sale_id=$item_info[6];
	$saleitem_rowid=$item_info[7];
	$percentOff=$item_info[8];
	$refundtype=$item_info[9];
	$valuechanged=$item_info[10];
	$saletype=$item_info[11];
	$srvname=$item_info[12];
	$itemtaxpercent=$item_info[13];
	$refundtype='F'; 
	$valuechanged='N';
	if ($new_total_cost != $total_cost)
	{
	$total_cost=$new_total_cost;
	$total_cost=number_format($total_cost,2,'.', '');

	if ($saletype=="S"){
	$taxrate=1+($itemtaxpercent/100);
	}else{
	$taxrate=1+($cfg_default_tax_rate/100);
	}
	$unit_price=$total_cost/$taxrate;
	$unit_price=number_format($unit_price,2,'.', '');

	if ($saletype=="S"){
	$tax=$unit_price * ($itemtaxpercent/100);
	}else{
	$tax=$unit_price * ($cfg_default_tax_rate/100);
	}
	
	$tax=number_format($tax,2,'.', '');
	$refundtype='P'; 
	$valuechanged='Y';
	}

	$_SESSION['items_in_return'][$k]=$upc.' '.$unit_price.' '.$tax.' '.$total_cost.' '.$item_id.' '.$quantity.' '.$sale_id.' '.$saleitem_rowid.' '.$percentOff.' '.$refundtype.' '.$valuechanged.' '.$saletype.' '.$srvname.' '.$itemtaxpercent;

	header("location: return_ui.php?returnaction=update&kvalue=$k&cursaleid=$sale_id");
	
}



if(isset($_GET['updateall']))
{



	for($k=0;$k<count($_SESSION['items_in_return']);$k++)
	{

	$new_price=$_POST["price$k"];
	$new_tax=$_POST["tax$k"];
	$new_quantity=$_POST["quantity$k"];
	$new_total_cost=$_POST["rowTotal$k"];

	$item_info=explode(' ',$_SESSION['items_in_return'][$k]);
	$upc=$item_info[0];
	$unit_price=$item_info[1];
	$tax=$item_info[2];
	$total_cost=$item_info[3];
	$item_id=$item_info[4];
	$quantity=$item_info[5];
	$sale_id=$item_info[6];
	$saleitem_rowid=$item_info[7];
	$percentOff=$item_info[8];
	$refundtype=$item_info[9];
	$valuechanged=$item_info[10];
	$saletype=$item_info[11];
	$srvname=$item_info[12];
	$itemtaxpercent=$item_info[13];
	$refundtype='F'; 
	$valuechanged='N';
	if ($new_total_cost != $total_cost)
	{
	$total_cost=$new_total_cost;
	$total_cost=number_format($total_cost,2,'.', '');

	if ($saletype=="S"){
	$taxrate=1+($itemtaxpercent/100);
	}else{
	$taxrate=1+($cfg_default_tax_rate/100);
	}

	$unit_price=$total_cost/$taxrate;
	$unit_price=number_format($unit_price,2,'.', '');
	
	if ($saletype=="S"){
	$tax=$unit_price * ($itemtaxpercent/100);
	}else{
	$tax=$unit_price * ($cfg_default_tax_rate/100);
	}
	$tax=number_format($tax,2,'.', '');
	$refundtype='P'; 
	$valuechanged='Y';
	}
	
		if ($saletype=="S"){
	$taxrate=1+($itemtaxpercent/100);
	}else{
	$taxrate=1+($cfg_default_tax_rate/100);
	}
	$unit_price=$total_cost/$taxrate;
	$unit_price=number_format($unit_price,2,'.', '');

	if ($saletype=="S"){
	$tax=$unit_price * ($itemtaxpercent/100);
	}else{
	$tax=$unit_price * ($cfg_default_tax_rate/100);
	}
	

	
$_SESSION['items_in_return'][$k]=$upc.' '.$unit_price.' '.$tax.' '.$total_cost.' '.$item_id.' '.$quantity.' '.$sale_id.' '.$saleitem_rowid.' '.$percentOff.' '.$refundtype.' '.$valuechanged.' '.$saletype.' '.$srvname.' '.$itemtaxpercent;

} 
	header("location: return_ui.php?returnaction=update&kvalue=$k&cursaleid=$sale_id&TenderAmtBoxNextstep=yes");
}


if(isset($_GET['discount']))
{
	$discount=$_POST['global_sale_discount'];

	if(is_numeric($discount))
	{
		for($k=0;$k<count($_SESSION['items_in_return']);$k++)
		{
			$item_info=explode(' ',$_SESSION['items_in_return'][$k]);
			$item_id=$item_info[0];
			$new_price=$item_info[1]*(1-($discount/100));
			$tax=$item_info[2];
			$quantity=$item_info[3];
			$percentOff=$item_info[4];
			
			$new_price=number_format($new_price,2,'.', '');
	
			
		}
	
		header("location: return_ui.php?global_sale_discount=$discount");
	}
}


include ("../classes/db_functions.php");
include ("../classes/security_functions.php");		
include ("../classes/display.php");

$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);






if(isset($_POST['customer']))
{	
	if($cfg_numberForBarcode=="Row ID")
	{
		if($dbf->isValidCustomer($_POST['customer']))
		{
			$_SESSION['current_sale_customer_id']=$_POST['customer'];
		}
	}
	else
	{
	
	  
		$id=$dbf->fieldToid($cfg_tableprefix.'customers','account_number',$_POST['customer']);
				
		if($dbf->isValidCustomer($id))
		{
			$_SESSION['current_sale_customer_id']=$id;
		}
		else
		{
			
			echo "$lang->customerWithID/$lang->accountNumber ".$_POST['customer'].', '."$lang->isNotValid";
		}

	}
}

?>

<html>
<head>
<title>Inventory Point Of Sale</title>
<script type="text/javascript" language="javascript">
<!--
function customerFocus()
{
	document.scan_customer.customer.focus();
	updateScanCustomerField();
}

function itemFocus()
{
	document.scan_item.item.focus();
	updateScanItemField();
}

function updateScanCustomerField()
{
	document.scan_customer.customer.value=document.scan_customer.customer_list.value;
}

function updateScanItemField()
{
	document.scan_item.item.value=document.scan_item.item_list.value;
}

//-->
</script>

<script type="text/javascript">
function validateFormOnSubmit(theForm) {
var reason = "";

  reason += validateamt_tendered(theForm.amt_tendered);
 
 
  
  
  
  
 
  if (reason != "") {
    alert("Some fields need correction:\n" + reason);
    return false;
  }

 
  
}
function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "The required field has not been filled in.\n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}
function validateamt_tendered(fld) {
    var error = "";
    var illegalChars = /\W/; 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Tendered Amount.\n";
    } 
    return error;
}
function validateAddress(fld) {
    var error = "";
    
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Address.\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 35)) {
        fld.style.background = 'Yellow'; 
        error = "The Address is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The Address contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}
function validateContact(fld) {
    var error = "";
    var illegalChars = /\W/; 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a username.\n";
    } else if ((fld.value.length < 2) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The contact is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The conatct contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}
function validatePassword(fld) {
    var error = "";
    var illegalChars = /[\W_]/; 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "You didn't enter a password.\n";
    } else if ((fld.value.length < 7) || (fld.value.length > 15)) {
        error = "The password is the wrong length. \n";
        fld.style.background = 'Yellow';
    } else if (illegalChars.test(fld.value)) {
        error = "The password contains illegal characters.\n";
        fld.style.background = 'Yellow';
    } else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
        error = "The password must contain at least one numeral.\n";
        fld.style.background = 'Yellow';
    } else {
        fld.style.background = 'White';
    }
   return error;
}  
function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}
function validateEmail(fld) {
    var error="";
    var tfld = trim(fld.value);                        
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
   
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "You didn't enter an email address.\n";
    } else if (!emailFilter.test(tfld)) {              
        fld.style.background = 'Yellow';
        error = "Please enter a valid email address.\n";
    } else if (fld.value.match(illegalChars)) {
        fld.style.background = 'Yellow';
        error = "The email address contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}
function validatePhone(fld) {
    var error = "";
    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    

   if (fld.value == "") {
        error = "You didn't enter a phone number.\n";
        fld.style.background = 'Yellow';
    } else if (isNaN(parseInt(stripped))) {
        error = "The phone number contains illegal characters.\n";
        fld.style.background = 'Yellow';
    } else if (!(stripped.length == 10)) {
        error = "The phone number is the wrong length. Make sure you included an area code.\n";
        fld.style.background = 'Yellow';
    }
    return error;
}
</script>


</head>

<?php
if(isset($_SESSION['current_sale_customer_id']))
{
?>
<body onLoad="itemFocus();">
<?php
}
else
{
?>
<body onLoad="customerFocus();">
<?php
}



$table_bg=$display->sale_bg;
$items_table="$cfg_tableprefix".'items';

if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}






$display->displayTitle("Process Refund");


   $workingcustid=$_GET['woringcustomerid'];
   if($workingcustid != "")
    { 
     $_SESSION['current_sale_customer_id']=$workingcustid;
    }
  
  

	
	$salestable=$cfg_tableprefix.'sales';
	$salesitems_table=$cfg_tableprefix.'sales_items';
	$customers_table=$cfg_tableprefix.'customers';
	
	if(isset($_GET['fromdeleteitem']))
	{
	$k=$_GET['itempos'];
	$sale_id=$_GET['saleid'];
	echo "<a href=\"manage_sales.php?kvalue=$k&cursaleid=$sale_id\">Add another item from receipt</a>";
	}
	
	if(isset($_GET['returnaction']))
	{
	$action='update';
	}

	if ($action!="update")
	{
	
	$result = mysql_query("SELECT customer_id FROM $salestable WHERE id=\"$sale_id\"",$dbf->conn);
	$row = mysql_fetch_assoc($result);
	$customerid=$row['customer_id'];
	
	$_SESSION['current_sale_customer_id']=$customerid;
	$customer_name=$dbf->idToField($customers_table,'first_name',$_SESSION['current_sale_customer_id']).' '.$dbf->idToField($customers_table,'last_name',$_SESSION['current_sale_customer_id']);


	if(isset($_GET['curkvalue'])){
		$curkvalue =$_GET['curkvalue'];
	

$upc =$_GET['upc'];
$unit_price=$_GET['unit_price'];


$tax=$_GET['tax'];
$total_cost=$_GET['total_cost'];
$quantity=$_GET['quantity'];

$item_id =$_GET['item_id'];
$sale_id=$_GET['sale_id'];

$saleitem_rowid=$_GET['row_id'];
$refundtype='F'; 
$valuechanged='N';

$saletype=$_GET['saletype'];
$srvname=$_GET['srvname'];
$srvname= str_replace(" ", "_", "$srvname");
$itemtaxpercent=$_GET['itemtaxpercent'];

	   $resultsalesitems = mysql_query("SELECT refundtype FROM $salesitems_table WHERE id=\"$saleitem_rowid\"",$dbf->conn);
	  $row_salesitems = mysql_fetch_assoc($resultsalesitems);
	   $refunded=$row_salesitems['refundtype'];
	
	

if ($refunded != "") {
	 echo "<center>This item was refunded therefore can not refund again.</center>";
	 	$k=$curkvalue - 1;
		echo "<br/><br/>";
		echo "<center><a href=\"manage_sales.php?kvalue=$k\">Add another item from receipt</a></center>";
	  exit;
}else{
	$k=$curkvalue;
	$valuechanged='N';
	

	$_SESSION['items_in_return'][$k]=$upc.' '.$unit_price.' '.$tax.' '.$total_cost.' '.$item_id.' '.$quantity.' '.$sale_id.' '.$saleitem_rowid.' '.$percentOff.' '.$refundtype.' '.$valuechanged.' '.$saletype.' '.$srvname.' '.$itemtaxpercent;

}

echo "<a href=\"manage_sales.php?kvalue=$k&cursaleid=$sale_id\">Add another item from receipt</a>";

}
	
}else{ 

$k=$_GET['kvalue'];
$sale_id=$_GET['cursaleid'];
echo "<a href=\"manage_sales.php?kvalue=$k&cursaleid=$sale_id\">Add another item from receipt</a>";

}

	  


	  
	if(isset($_SESSION['items_in_return']))
	{
		$num_items=count($_SESSION['items_in_return']);
					


	}
	else
	{
		$num_items=0;
	}	
	$temp_item_name='';
	$temp_item_id='';
	$temp_quantity='';
	$temp_price='';
	$finalSubTotal=0;
	$finalTax=0;
	$finalTotal=0;
	$totalItemsPurchased=0;
	
	$item_info=array();

	$customers_table="$cfg_tableprefix".'customers';
	$order_customer_first_name=$dbf->idToField($customers_table,'first_name',$_SESSION['current_sale_customer_id']);
	$order_customer_last_name=$dbf->idToField($customers_table,'last_name',$_SESSION['current_sale_customer_id']);
	$order_customer_name=$order_customer_first_name.' '.$order_customer_last_name;

	
	echo "<center><a href=\"delete.php?action=all\">Clear All Returns</a></center>";
	
	  $items_table="$cfg_tableprefix".'items';
	  $brands_table="$cfg_tableprefix".'brands';
  

	echo "<h3 align='center'>Return Item Cart</h3>
	

<center>$now<br>
<h4>$lang->orderBy: $customer_name </h4>
	
	
	<form name='add_sale' onsubmit='return validateFormOnSubmit(this)' action='refundsale.php' method='POST'>";
	if ($num_items>=1){
	echo "<center><FONT COLOR=blue>Note: If refund Amount changed you must click Update/UpdateAll button to recalculate</FONT></center>";
	}
	echo "<table border='0' bgcolor='$table_bg' cellspacing='0' cellpadding='2' align='center'>
	<tr><th><font color=CCCCCC>$lang->remove</font></th>
	<th><font color=CCCCCC>UPC</font></th>
	<th><font color=CCCCCC>$lang->itemName</font></th>
	<th><font color=CCCCCC>SubAmt</font></th>
	<th><font color=CCCCCC>Tax</font></th>
	<th><font color=CCCCCC>Qty</font></th>
	<th><font color=CCCCCC>Refund Amt</font></th>
	</tr>";


	for($k=0;$k<$num_items;$k++)
	{
		$item_info=explode(' ',$_SESSION['items_in_return'][$k]);
		
		$temp_item_number=$item_info[0];
		
		
		$temp_price=$item_info[1];
		$temp_tax=$item_info[2];
		$temp_totalcost=$item_info[3];
		$temp_item_id=$item_info[4];
		$temp_item_name=$dbf->idToField($items_table,'item_name',$temp_item_id);
		$temp_quantity=$item_info[5];
		$temp_sale_id=$item_info[6];
		$temp_discount=$item_info[7];
		
		$temp_saletype=$item_info[11];
		if ($temp_saletype=="S"){ 
			$temp_srvname=$item_info[12];
			$temp_srvname=str_replace("_", " ", "$temp_srvname");
			
			$temp_item_number='Service';
			$temp_item_name=$temp_srvname;
		}
		
		$subTotal=$temp_price*$temp_quantity;
		
		$tax=$temp_tax;
		$rowTotal=$subTotal+$tax;
		$rowTotal=number_format($rowTotal,2,'.', '');
		
		$finalSubTotal+=$subTotal;
		$finalTax+=$tax;
		$finalTotal+=$rowTotal;
		$totalItemsPurchased+=$temp_quantity;
	


		echo "<tr><td align='center'><a href=delete.php?action=item&pos=$k&saleid=$temp_sale_id><font color=white>[$lang->delete]</font></a></td>
				  <td align='center'><font color='white'><b>$temp_item_number</b></font></td>
				  <td align='center'><font color='white'><b>$temp_item_name</b></font></td>
				  <td align='center'><font color='white'><b>$temp_price</b></font></td>
				  <td align='center'><font color='white'><b>$temp_tax</b></font></td>
				  <td align='center'><font color='white'><b>$temp_quantity</b></font></td>

				  <td align='center'><input type=text name='rowTotal$k' value='$rowTotal' size='8'></td>
				  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='return_ui.php?update_item=$k';document.add_sale.submit();\"></td>
				  <input type='hidden' name='item_id$k' value='$temp_item_number'>
				  </tr>";
		$itemselected='yes';
				}




if (($itemselected=="yes") and ($num_items>1)){
		echo "<br>
		<table align='center' bgcolor='$table_bg'><br>
		<tr><td align='left'><font color='white'>Update All</font></td>
		<td><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='return_ui.php?updateall=true';document.add_sale.submit();\"></td></tr>
		</table><br>";
	}
	
	$finalSubTotal=number_format($finalSubTotal,2,'.', '');
	$finalTax=number_format($finalTax,2,'.', '');
	$finalTotal=number_format($finalTotal,2,'.', '');
	
	echo '</table>';
	
	
	echo "<table align='center' ><br>
	<tr><td align='left'>Refund SubTotal: $cfg_currency_symbol$finalSubTotal</td></tr>
	<tr><td align='left'>$lang->tax: $cfg_currency_symbol$finalTax</td></tr>";
	
	if(isset($_GET['global_sale_discount']))
	{
		$discount=$_GET['global_sale_discount'];
		echo"<tr><td align='left'>$discount% $lang->percentOff</td></tr>";

	}
	echo"<tr><td align='left'><b>Total Refund Amount: $cfg_currency_symbol$finalTotal</b></td></tr>";
	echo'</table>';
	echo "<br/><br/><br/><br/>";
	echo "<tr><td><b>$lang->saleID: $temp_sale_id</b></td></tr>";
	


$TenderAmtBoxNextstep=$_GET['TenderAmtBoxNextstep'];

	if ($TenderAmtBoxNextstep!="yes" && $cfg_ShowTenderAmtBox_as2nd_Step=="yes"){

		echo "<br>
		<table align='center' bgcolor='$table_bg'><br>
		<tr><td align='left'><font color='white'>Click to Add Refund/Comment</font></td>
		<td><input type='button' name='updateQuantity$k' value='Add Refund' onclick=\"document.add_sale.action='return_ui.php?updateall=true';document.add_sale.submit();\"></td></tr>
		</table><br>";
		

	}



	if ($TenderAmtBoxNextstep=="yes" && $cfg_ShowTenderAmtBox_as2nd_Step=="yes"){
	echo "<br><table border='0' bgcolor='$table_bg' align='center'>
	<tr>
	<td>
	<font color='white'>$lang->paidWith:</font> 
	</td>
	<td>
	<select name='paid_with'>
	<option value='$lang->cash'>$lang->cash</option>
	<option value='$lang->check'>$lang->check</option>
	<option value='$lang->credit'>$lang->credit</option>
	
	</select>
	
	</td>
	</tr>
	<tr>
	<td>
	<font color='white'>Refund Comment:</font>
	</td>
	<td>
	<input type=text name=comment size=25>
	</td>
	</tr>

	</table>
	  <br>
  	  <input type=hidden name='totalItemsPurchased' value='$totalItemsPurchased'>
  	  <input type=hidden name='totalTax' value='$finalTax'>
  	  <input type=hidden name='finalTotal' value='$finalTotal'>
	  <center><input type='submit' value='Complete Refund'></center></form>";
	  }

if ($TenderAmtBoxNextstep!="yes" && $cfg_ShowTenderAmtBox_as2nd_Step=="no"){
	echo "<br><table border='0' bgcolor='$table_bg' align='center'>
	<tr>
	<td>
	<font color='white'>$lang->paidWith:</font> 
	</td>
	<td>
	<select name='paid_with'>
	<option value='$lang->cash'>$lang->cash</option>
	<option value='$lang->check'>$lang->check</option>
	<option value='$lang->credit'>$lang->credit</option>
	
	</select>
	
	</td>
	</tr>
	<tr>
	<td>
	<font color='white'>Refund Comment:</font>
	</td>
	<td>
	<input type=text name=comment size=25>
	</td>
	</tr>

	</table>
	  <br>
  	  <input type=hidden name='totalItemsPurchased' value='$totalItemsPurchased'>
  	  <input type=hidden name='totalTax' value='$finalTax'>
  	  <input type=hidden name='finalTotal' value='$finalTotal'>
	  <center><input type='submit' value='Process Refund'></center></form>";
	  }






  
$dbf->closeDBlink();


?>
</body>
</html>