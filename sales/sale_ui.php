<?php session_start(); 

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
$lang=new language();


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

  reason += validateamt_tendered(theForm.amt_tendered,theForm.finalTotal);
 
 
  
  
  
  
 
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
function validateamt_tendered(fld,fld2) {
    var error = "";
    var illegalChars = /\W/; 
 
 
 
    var TAmountWithDecimal =fld.value.indexOf(".")==-1;
    if (TAmountWithDecimal==true)
	   {
          
	      fld.value=fld.value+".00";
	   }else{
	        
	       
	    }
 
 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Tendered Amount.\n";
    }else 
	if (fld.value<fld2.value) {
        fld.style.background = 'Yellow'; 
        error = "Tendered Amount is less then Total amount due.\n";
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

<script type="text/javascript">

var dvdtitle_value;
function MPClearField(field) {
  var fieldName = field.name;
  if (field.value == "Or Enter Service name"){
        field.value = '';
       
       
        var reason = ""; 
        dvdtitle_value = field.value;      
        
    }
  if (field.value == "You have selected Service"){
        field.value = '';
       
       
        var reason = ""; 
        dvdtitle_value = field.value;      
        
    }
	
	
}


</script>


<script type="text/javascript">
function reload(form){




}
</script>

</head>


<?php




if(isset($_GET['update_item']))
{
	$k=$_GET['update_item'];
	$new_price=$_POST["price$k"];
	$new_tax=$_POST["tax$k"];
	$new_quantity=$_POST["quantity$k"];
    $new_rowtotal=$_POST["rowTotal$k"];
	$new_articalid=$_POST["article_id$k"];
	
	
	$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
	$item_id=$item_info[0];
	$percentOff=$item_info[4];
	$last_rowtotal=$item_info[5];
	$saletype=$item_info[7];
	$rowtotal_changed="no"; 
	If ($last_rowtotal <> $new_rowtotal)
	{
	$rowtotal_changed="yes";  
	}
	
	
	
	if ($saletype=="S"){
	$new_servicename=$_POST["servicename$k"];
	$new_servicename = str_replace(" ", "_", "$new_servicename");
	
	
	
	
		$selected_servicename=$_POST["article_id$k"];
		
		if ($selected_servicename=="blank")
		{
			$message = "Please Select the Service. Your Selected Service is: $selected_servicename. Also do not forget to click Update button." ;
			echo "<SCRIPT>
			alert('$message');
			</SCRIPT>";
		}
	
	}
	
	if ($saletype=="S"){
		$new_servicecost=$_POST["servicecost$k"];
	}else{
		$new_servicecost=$item_info[10];
	}
	
	if ($new_articalid != "blank"){
	
		$new_servicename= "You_have_selected_Service";
	} else if ($new_articalid == "blank" && $new_servicename ==""){
		$new_servicename="Or_Enter_Service_name";
	}else if ($new_articalid == "blank" && $new_servicename =="You_have_selected_Service"){
		$new_servicename="Or_Enter_Service_name";
	}
	
		$service_catid=$item_info[11];
	
	
	$_SESSION['items_in_sale'][$k]=$item_id.' '.$new_price.' '.$new_tax.' '.$new_quantity.' '.$percentOff.' '.$new_rowtotal.' '.$rowtotal_changed.' '.$saletype.' '.$new_articalid.' '.$new_servicename.' '.$new_servicecost.' '.$service_catid;

	
	header("location: sale_ui.php");
}

if(isset($_GET['discount']))
{
	$discount=$_POST['global_sale_discount'];

	if(is_numeric($discount))
	{
		for($k=0;$k<count($_SESSION['items_in_sale']);$k++)
		{
			$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
			$saletype=$item_info[7];
			$item_id=$item_info[0];
			
			if ($saletype!="S"){
			$new_price=$item_info[1]*(1-($discount/100));
			$new_price=number_format($new_price,2,'.', '');
			}else{
			$new_price=$item_info[1];
			}
			$tax=$item_info[2];
			$quantity=$item_info[3];
			$percentOff=$item_info[4];
			$percentOff=$discount;

		$new_rowtotal=$item_info[5];
		$rowtotal_changed=$item_info[6];
		
		
		$articalid=$item_info[8];
		$servicename=$item_info[9];
		$servicename = str_replace(" ", "_", "$servicename");
		$servicecost=$item_info[10];
		$service_catid=$item_info[11];

	
			

			$_SESSION['items_in_sale'][$k]=$item_id.' '.$new_price.' '.$tax.' '.$quantity.' '.$percentOff.' '.$new_rowtotal.' '.$rowtotal_changed.' '.$saletype.' '.$articalid.' '.$servicename.' '.$servicecost.' '.$service_catid;

		}
	
		header("location: sale_ui.php?global_sale_discount=$discount");
	}
}

if(isset($_GET['updateall']))
{


	for($k=0;$k<count($_SESSION['items_in_sale']);$k++)
	{
	

$updating='yes';
	
	$new_price=$_POST["price$k"];
	$new_tax=$_POST["tax$k"];
	$new_quantity=$_POST["quantity$k"];
    $new_rowtotal=$_POST["rowTotal$k"];
	$new_articalid=$_POST["article_id$k"];
	
	
	
	$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
	$item_id=$item_info[0];
	$percentOff=$item_info[4];
	$last_rowtotal=$item_info[5];
	$saletype=$item_info[7];
	$rowtotal_changed="no"; 
	If ($last_rowtotal <> $new_rowtotal)
	{
	$rowtotal_changed="yes";  
	}
	
	
	if ($saletype=="S"){
	$new_servicename=$_POST["servicename$k"];
	$new_servicename = str_replace(" ", "_", "$new_servicename");
	
	
	
	
		$selected_servicename=$_POST["article_id$k"];
		
		if ($selected_servicename=="blank")
		{
			$message = "Please Select the Service. Your Selected Service is: $selected_servicename. Also do not forget to click Update button." ;
			echo "<SCRIPT>
			alert('$message');
			</SCRIPT>";
		}
	
	}
	
	if ($saletype=="S"){
		$new_servicecost=$_POST["servicecost$k"];
	}else{
		$new_servicecost=$item_info[10];
	}
	
	if ($new_articalid != "blank"){
	
		$new_servicename= "You_have_selected_Service";
	} else if ($new_articalid == "blank" && $new_servicename ==""){
		$new_servicename="Or_Enter_Service_name";
	}else if ($new_articalid == "blank" && $new_servicename =="You_have_selected_Service"){
		$new_servicename="Or_Enter_Service_name";
	}
	
		$service_catid=$item_info[11];
	
	if(isset($_GET['gotoaddpayment']))
	{
	$TenderAmtBoxNextstep="yes"; 
	}
	
	
	
	$_SESSION['items_in_sale'][$k]=$item_id.' '.$new_price.' '.$new_tax.' '.$new_quantity.' '.$percentOff.' '.$new_rowtotal.' '.$rowtotal_changed.' '.$saletype.' '.$new_articalid.' '.$new_servicename.' '.$new_servicecost.' '.$service_catid;
}
	
	header("location: sale_ui.php");
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


$display->displayTitle("$lang->newSale");



   $workingcustid=$_GET['woringcustomerid'];
   if($workingcustid != "")
    { 
     $_SESSION['current_sale_customer_id']=$workingcustid;
    }
  
  



$k=$_GET['skvalue'];



	if(isset($_SESSION['items_in_sale']))
	{
		$num_items_sale=count($_SESSION['items_in_sale']);

	}


if(empty($_SESSION['current_sale_customer_id']))
{
   
	$customers_table="$cfg_tableprefix".'customers';
	
	if(isset($_POST['customer_search']) and $_POST['customer_search']!='')
	{
		
	 	$search=$_POST['customer_search'];
		$_SESSION['current_customer_search']=$search;
	 	
	 	$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" or id =\"$search\" or phone_number =\"$search\" ORDER by last_name",$dbf->conn);
   
    }
    elseif(isset($_SESSION['current_customer_search']))
	{
	 	$search=$_SESSION['current_customer_search'];
	 	
	 	$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" or id =\"$search\" or phone_number =\"$search\" ORDER by last_name",$dbf->conn);

	}
	   elseif($dbf->getNumRows($customers_table) >200)
	{
		$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table ORDER by last_name LIMIT 0,200",$dbf->conn);	
	}
	else
  	{
		$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table ORDER by last_name",$dbf->conn);
	}

	$customer_title=isset($_SESSION['current_customer_search']) ? "<b><font color='white'>$lang->selectCustomer: </font></b>":"<font color='white'>$lang->selectCustomer: </font>";

	echo "<table align='center' cellpadding='2' cellspacing='2' bgcolor='$table_bg'>
	<form name='select_customer' action='sale_ui.php' method='POST'>
	<tr><td align='left'><font color='white'>$lang->findCustomer:</font>
	<input type='text' size='8' name='customer_search'>
	<input type='submit' value='Go'><a href='delete.php?action=customer_search'><font size='-1' color='white'><img src=\"../je_images/btgray_clear_search.png\" onmouseover=\"this.src='../je_images/btgray_clear_search_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_clear_search.png';\" BORDER='0'></a>
	<a href=\"../customers/form_customers.php?action=insert\"><font size='-1' color='blue'><img src=\"../je_images/btgray_enter_new_customer.png\" onmouseover=\"this.src='../je_images/btgray_enter_new_customer_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_enter_new_customer.png';\" BORDER='0'></a>
	</form></td></tr>
	
	<form name='scan_customer' action='sale_ui.php' method='POST'>
	<tr><td align='left'>$customer_title<select name='customer_list' onChange=\"updateScanCustomerField()\";>";
 		
 		while($row=mysql_fetch_assoc($customer_result))
		{
			 if($cfg_numberForBarcode=="Row ID")
			 {
			 	$id=$row['id'];
			 }
			 elseif($cfg_numberForBarcode=="Account/Item Number")
			 {
			 	$id=$row['account_number'];
			 }
			 echo $id;
			 $display_name=$row['last_name'].', '.$row['first_name'];
			 echo "<option value=$id>$display_name</option></center>";
		}
	echo "</select></td><br><br>";
	
	echo "<tr><td align='left'><center><small><font color='white'>($lang->scanInCustomer)</font></small></center>";
	echo"<font color='white'>$lang->customerID / $lang->accountNumber: </font><input type='text' name='customer' size='6'>
	<input type='submit'></td></tr>
	</form>";	
}

if(isset($_SESSION['current_sale_customer_id']))
{	

   		if(isset($_GET['saleservice'])){
	 
	 
	 
	 
	
	
	$saletype='S';
	$quantity=1;
	$service_name="Or_Enter_Service_name";
	$itemTax=0;
	$_SESSION['items_in_sale'][]=$item.' '.$itemPrice.' '.$itemTax.' '.$quantity.' '.$discount.' '.$new_rowtotal.' '.$rowtotal_changed.' '.$saletype.' '.$articalid.' '.$service_name.' '.$service_cost.' '.$service_catid;
	}else{

	if(isset($_POST['item']))
	{
		$item=$_POST['item'];
		$discount='0%';
		if($cfg_numberForBarcode=="Account/Item Number")
		{
				
				$item=$dbf->fieldToid($items_table,'item_number',$_POST['item']);
			
				
				
				
                if ($item=="" or $item==" ")
				{
			        $item=$dbf->fieldToid($items_table,'serialnumber',$_POST['item']);
			    }
		}
		
		if($dbf->isValidItem($item))
		{
			if($dbf->isItemOnDiscount($item))
			{
				$discount=$dbf->getPercentDiscount($item).'%';
				$itemPrice=$dbf->getDiscountedPrice($item);
				
			}
			else
			{	
				$itemPrice=$dbf->idToField($items_table,'unit_price',$item);
			}
			$itemTax=$dbf->idToField($items_table,'tax_percent',$item);
			
	$saletype='I';
	$quantity=1;
	$_SESSION['items_in_sale'][]=$item.' '.$itemPrice.' '.$itemTax.' '.$quantity.' '.$discount.' '.$new_rowtotal.' '.$rowtotal_changed.' '.$saletype.' '.$articalid.' '.$service_name.' '.$service_cost.' '.$service_catid;
			
		}
		else
		{
			echo "$lang->itemWithID/$lang->itemNumber ".$_POST['item'].', '."$lang->isNotValid";
		}
	
	
}
	}
	
	

	
	
	
	
	if(isset($_SESSION['items_in_sale']))
	{
		$num_items=count($_SESSION['items_in_sale']);

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

	echo "<hr><center><a href=delete.php?action=all><img src=\"../je_images/btgray_clear_sale.png\" onmouseover=\"this.src='../je_images/btgray_clear_sale_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_clear_sale.png';\" BORDER='0'></a></center>";
	
	
	  $items_table="$cfg_tableprefix".'items';
	  $brands_table="$cfg_tableprefix".'brands';
  
  
	  if(isset($_POST['item_search'])  and $_POST['item_search']!='')
	  {
	  	$search=$_POST['item_search'];
	  	$_SESSION['current_item_search']=$search;
	  	$item_result=mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id FROM $items_table WHERE item_name like \"%$search%\" or item_number= \"$search\" or id =\"$search\" ORDER by item_name",$dbf->conn);
	  }
	  elseif(isset($_SESSION['current_item_search']))
	  {
	  	$search=$_SESSION['current_item_search'];
	  	$item_result=mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id FROM $items_table WHERE item_name like \"%$search%\" or item_number= \"$search\" or id =\"$search\" ORDER by item_name",$dbf->conn);

	  }
	  elseif($dbf->getNumRows($items_table) >200)
	  {
	  	$item_result=mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id FROM $items_table ORDER by item_name LIMIT 0,200",$dbf->conn);
	  }
	  else
	  {
	  	$item_result=mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id FROM $items_table ORDER by item_name",$dbf->conn);
	  }
	  		
  
		$item_title=isset($_SESSION['current_item_search']) ? "<b><font color='white'>$lang->selectItem: </font></b>":"<font color=white>$lang->selectItem: </font>";
	    echo "<form name='select_item' action='sale_ui.php' method='POST'>
		<table border='0' bgcolor='$table_bg' align='center'>
		<tr><td align='left'><font color='white'>$lang->findItem: <input type='text' size='8' name='item_search'></font>
	<input type='submit' value='Go'><a href='delete.php?action=item_search'><font size='-1' color='white'><img src=\"../je_images/btgray_clear_search.png\" onmouseover=\"this.src='../je_images/btgray_clear_search_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_clear_search.png';\" BORDER='0'></a></td></tr>";
		
			echo "</form><tr><td><form name='scan_item' action='sale_ui.php' method='POST'>
				$item_title <select name='item_list' onChange=\"updateScanItemField()\";>\n";
 
	  while($row=mysql_fetch_assoc($item_result))
	  {
	    if($cfg_numberForBarcode=="Row ID")
	    {
	  		$id=$row['id'];
	  		
	  	}
	  	elseif($cfg_numberForBarcode=="Account/Item Number")
	  	{
	  		$id=$row['item_number'];
	  	}
	  	
	  	$quantity=$row['quantity'];
	  	$brand_id=$row['brand_id'];
	  	$brand_name=$dbf->idToField("$brands_table",'brand',"$brand_id");
	  	$unit_price=$row['unit_price'];
	  	$tax_percent=$row['tax_percent'];
	  	$option_value=$id;
	    $display_item="$brand_name".'- '.$row['item_name'];
	    
		if($quantity <=0)
	    {
		
	    	 	echo "<option value='$option_value'>$display_item ($lang->outOfStockWarn)</option>\n";

	    }
	    else
	    {
	    	echo "<option value='$option_value'>$display_item</option>\n";

	    }
  
	  }
echo "</select></td></tr>
	<tr><td><center><small><font color='white'>($lang->scanInItem)</font></small></center>
	<font color='white'>$lang->itemNumber: </font><input type='text' name='item' size='20'>
	<input type='submit'></form></td></tr>
	<center>$lang->orderFor: <b>$order_customer_name</b></center><br>

</table>";
	
	
	 if ($id<>''){
	 	$customer_tablename="$cfg_tableprefix".'customers';
	 	$check_bancustomer_table="SELECT * FROM $customer_tablename where id = $id";
	 	$bancustomer_result=mysql_query($check_bancustomer_table,$dbf->conn);
	 	$bancustomer_row = mysql_fetch_assoc($bancustomer_result);
	 	$banned_customer = $bancustomer_row['bancustomer'];
	 
	 	
	 	  
	 	   if ($banned_customer == 'Y'){ 
	        $bannedcustflag='y';
	        
	        echo "<meta http-equiv=refresh content=\"0; URL=delete.php?action=all&bannedcustomer=$bannedcustflag\">";
	       
       }
     }
	


$categorytable = "$cfg_tableprefix".'categories';
$srvwherefield = ' showon_saleservicepanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
$srvresultcat = mysql_query("SELECT * FROM $categorytable WHERE $srvwherefield ",$dbf->conn);
$srvnumcat_rows = mysql_num_rows($srvresultcat);






if ($srvnumcat_rows > 0 && $cfg_enable_SaleServices=="yes") 
{
		echo "
		<table align='center' bgcolor='$table_bg'><br>
		<tr><td align='left'><font color='white'>Sale Service</font></td>
				<td><input type='button' name='refresh' value='Add Service' onclick=\"document.add_sale.action='sale_ui.php?saleservice=true&skvalue=$num_items_sale';document.add_sale.submit();\"></td></tr>
		</table><br>";
	}
	
	

	
	
	
	
	
	
	
	
	echo "<h3 align='center'>$lang->shoppingCart</h3>
	
	<form name='add_sale' onsubmit='return validateFormOnSubmit(this)' action='addsale.php' method='POST'>";
	







	echo "
	 <div style=\"width:100%;\"> 
	<div style=\"float:left; width:75%; background-color: HighLight;\">
	";



	
	
	echo "<center><FONT COLOR=blue>Note: Only change one value at a time and click Update/UpdateAll button to recalculate</FONT></center>";
	

	
	

if ($cfg_enable_SaleServices=="yes"){
	echo "<table border='0' bgcolor='$table_bg' cellspacing='0' cellpadding='2' align='center'>
	<tr><th><font color=CCCCCC>$lang->remove</font></th>
	<th><font color=CCCCCC>ItemNum/Srv</font></th>
	<th><font color=CCCCCC>Item/Srv Name</font></th>
	<th><font color=CCCCCC>SrvCost</font></th>
	<th><font color=CCCCCC>Price</font></th>
	<th><font color=CCCCCC>$lang->tax %</font></th>
	<th><font color=CCCCCC>Qty</font></th>
	<th><font color=CCCCCC>Final Price</font></th>
	<th><font color=CCCCCC>$lang->update</font></th>	
	<th><font color=CCCCCC>$lang->percentOff</font></th>
	</tr>";
}else{

	echo "<table border='0' bgcolor='$table_bg' cellspacing='0' cellpadding='2' align='center'>
	<tr><th><font color=CCCCCC>$lang->remove</font></th>
	<th><font color=CCCCCC>itemNumber</font></th>
	<th><font color=CCCCCC>$lang->itemName</font></th>
	<th><font color=CCCCCC>$lang->unitPrice</font></th>
	<th><font color=CCCCCC>$lang->tax %</font></th>
	<th><font color=CCCCCC>Qty</font></th>
	<th><font color=CCCCCC>Final Price</font></th>
	<th><font color=CCCCCC>$lang->update</font></th>	
	<th><font color=CCCCCC>$lang->percentOff</font></th>
	</tr>";


}
	



	
	

 

	for($k=0;$k<$num_items;$k++)
	{
		$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
		$temp_item_id=$item_info[0];
		$temp_item_name=$dbf->idToField($items_table,'item_name',$temp_item_id);
		$temp_item_number=$dbf->idToField($items_table,'item_number',$temp_item_id);
		$temp_price=$item_info[1];
		$temp_tax=$item_info[2];
		$temp_quantity=$item_info[3];
		$temp_discount=$item_info[4];
		$temp_rowtotal=$item_info[5];
		$rowtotal_changed=$item_info[6];
		
		$saletype=$item_info[7];
		$articalid=$item_info[8];
		$service_name1=$item_info[9];
		$service_name = str_replace("_", " ", "$service_name1");
		$service_cost=$item_info[10];
		
		
		
		
		
		if ($rowtotal_changed=="yes"){
		$rowTotal=number_format($temp_rowtotal,2,'.', '');
		$temp_price=($temp_rowtotal/(1+($temp_tax/100)))/$temp_quantity;
		$temp_price=number_format($temp_price,2,'.', '');
		
		}
		
		$subTotal=$temp_price*$temp_quantity;
		$tax=$subTotal*($temp_tax/100);

		$rowTotal=$subTotal+$tax;
		$rowTotal=number_format($rowTotal,2,'.', '');
		
		$finalSubTotal+=$subTotal;
		$finalTax+=$tax;
		$finalTotal+=$rowTotal;
		$totalItemsPurchased+=$temp_quantity;






$categorytable = "$cfg_tableprefix".'categories';
$wherefield = ' showon_saleservicepanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";

$resultcat = mysql_query("SELECT * FROM $categorytable WHERE $wherefield ",$dbf->conn);
$numcat_rows = mysql_num_rows($resultcat);




$category_option_titles=$dbf->getAllElementswhere("$categorytable",'category',"$wherefield",'category');
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values=$dbf->getAllElementswhere("$categorytable",'id',"$wherefield",'category');
$category_option_values[0] = $category_id_value;


if ($numcat_rows > 1){ 
$category_option_titles[0] = " ";
$category_option_values[0] = 'blank';
} else if ($numcat_rows == 1){  
$row = mysql_fetch_array($resultcat);
$catid=$row['id'];
}

$service_catid=$catid;

$_SESSION['items_in_sale'][$k]=$temp_item_id.' '.$temp_price.' '.$temp_tax.' '.$temp_quantity.' '.$temp_discount.' '.$rowTotal.' '.$rowtotal_changed.' '.$saletype.' '.$articalid.' '.$service_name1.' '.$service_cost.' '.$service_catid;




$articletable = "$cfg_tableprefix".'articles a,'."$cfg_tableprefix".'categories b ';
$wherefield = ' a.category_id = ' ." '". "$catid"."'".'and  a.category_id = b.id and b.showon_saleservicepanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'";

$resultart = mysql_query("SELECT a.id FROM $articletable WHERE $wherefield ",$dbf->conn);
$numart_rows = mysql_num_rows($resultart);


$article_option_titles=$dbf->getAllElementswhere("$articletable",'a.article',"$wherefield",'a.article');
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values=$dbf->getAllElementswhere("$articletable",'a.id',"$wherefield",'a.article');
$article_option_values[0] = $article_id_value;



if ($numart_rows > 1){
	$article_option_titles[0] ="Select Service";
	$article_option_values[0] ='blank';
} else if ($numart_rows == 1){ 
	$artrow = mysql_fetch_array($resultart);
	$article_id_value=$artrow['a.id'];
	$articletable1 = "$cfg_tableprefix".'articles';
	$article_option_titles[0] ="Select Service";
	$article_option_values[0] ='blank';
	$article_option_titles[1] = $dbf->idToField("$articletable1",'article',"$article_id_value");
	$article_option_values[1] = $article_id_value;
}else{
	$article_option_titles[0] ="Select Service";
	$article_option_values[0] ='blank';
}




if($articalid!=""){ 
$articletable1 = "$cfg_tableprefix".'articles';
$article_id_value=$articalid;
$article_option_titles[0] = $dbf->idToField("$articletable1",'article',"$article_id_value");
$article_option_values[0] = $article_id_value;
}



if($articalid=="blank"){
	$article_option_titles[0] ="Select Service";
	$article_option_values[0] ='blank';
}else{
$lastnumber=$numart_rows+1;
$article_option_titles[$lastnumber] ="Select Service";
$article_option_values[$lastnumber] ='blank';

}









if(isset($_GET['saleservice'])){

}


if(((isset($_GET['saleservice'])) and ($saletype=="S")) or ($saletype=="S")){







$onfocus="onfocus='MPClearField(this)'";
$onchange="onchange=".'"'."reload(this.form)".'"';


	



		
		
		
		
		echo "<tr><td align='center'><a href=delete.php?action=item&pos=$k><font color=white>[$lang->delete]</font></a></td>";
		
		/*
		echo"
		<td><select name='category_id' > ";
		if($category_option_values[0]!='')
		{
			echo"<option selected value=\"$category_option_values[0]\">$category_option_titles[0]</option>";
		}
		for($c=1;$c< count($category_option_values); $c++)
		{
			if($category_option_values[$c]!=$category_option_values[0] )
			{
				echo "
				<option value='$category_option_values[$c]'>$category_option_titles[$c]</option>"; 
			}			
		}
		echo "</select>
		</td>";
		*/
		echo"
		<td><select name=\"article_id$k\" > ";
		if($article_option_values[0]!='')
		{
			echo"<option selected value=\"$article_option_values[0]\">$article_option_titles[0]</option>";
		}
		for($r=1;$r< count($article_option_values); $r++)
		{
			if($article_option_values[$r]!=$article_option_values[0] )
			{
				echo "
				<option value='$article_option_values[$r]'>$article_option_titles[$r]</option>" ; 
			}			
		}
		echo  "</select>
		 </td>";
		 
		 
		 
			 
		 
    if ($cfg_SaleSrvPanel_enable_enter_srvname_field=="yes"){
		echo"
				  <td align='center'><input type=text name=\"servicename$k\" value=\"$service_name\" size='30' $onfocus></td>
				  <td align='center'><input type=text name='servicecost$k' value='$service_cost' size='8' $onfocus></td>
				  <td align='center'><input type=text name='price$k' value='$temp_price' size='8'></td>
				  <td align='center'><input type=text name='tax$k' value='$temp_tax' size='3'></td>
				  <td align='center'><input type=text name='quantity$k' value='$temp_quantity' size='3'></td>
				  <td align='center'><input type=text name='rowTotal$k' value='$rowTotal' size='8'></td> 
				  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>

";
}else{
		echo"
				  <td align='center'><font color='white'><b>$service_name</b></font></td>
				  <td align='center'><input type=text name='servicecost$k' value='$service_cost' size='8' $onfocus></td>
				  <td align='center'><input type=text name='price$k' value='$temp_price' size='8'></td>
				  <td align='center'><input type=text name='tax$k' value='$temp_tax' size='3'></td>
				  <td align='center'><input type=text name='quantity$k' value='$temp_quantity' size='3'></td>
				  <td align='center'><input type=text name='rowTotal$k' value='$rowTotal' size='8'></td> 
				  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>

";

}


		echo"
				  <input type='hidden' name='item_id$k' value='$temp_item_id'>
				  </tr>";


}else if ($cfg_enable_SaleServices=="yes"){

		echo "<tr><td align='center'><a href=delete.php?action=item&pos=$k><font color=white>[$lang->delete]</font></a></td>
				  <td align='center'><font color='white'><b>$temp_item_number</b></font></td>
				  <td align='center'><font color='white'><b>$temp_item_name</b></font></td>
				  <td align='center'><display type=text name='' value='' size='8'></td>
				  <td align='center'><input type=text name='price$k' value='$temp_price' size='8'></td>
				  <td align='center'><input type=text name='tax$k' value='$temp_tax' size='3'></td>
				  <td align='center'><input type=text name='quantity$k' value='$temp_quantity' size='3'></td>
				  <td align='center'><input type=text name='rowTotal$k' value='$rowTotal' size='8'></td> 
				  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>
				  <td align='center'><font color='white'><b>$temp_discount $lang->percentOff</b></font></td>
";

		echo"
				  <input type='hidden' name='item_id$k' value='$temp_item_id'>
				  </tr>";


}else{


		echo "<tr><td align='center'><a href=delete.php?action=item&pos=$k><font color=white>[$lang->delete]</font></a></td>
				  <td align='center'><font color='white'><b>$temp_item_number</b></font></td>
				  <td align='center'><font color='white'><b>$temp_item_name</b></font></td>

				  <td align='center'><input type=text name='price$k' value='$temp_price' size='8'></td>
				  <td align='center'><input type=text name='tax$k' value='$temp_tax' size='3'></td>
				  <td align='center'><input type=text name='quantity$k' value='$temp_quantity' size='3'></td>
				  <td align='center'><input type=text name='rowTotal$k' value='$rowTotal' size='8'></td> 
				  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>
				  <td align='center'><font color='white'><b>$temp_discount $lang->percentOff</b></font></td>
";


	
		echo"
				  <input type='hidden' name='item_id$k' value='$temp_item_id'>
				  </tr>";




}



		$itemselected='yes';
	}
	
	
echo '</table>';	
	

	
	
if (($itemselected=="yes") and ($num_items>1)){
		echo "<br>
		<table align='center' bgcolor='$table_bg' cellspacing='10' cellpadding='0'><br>
		<tr><td align='left'><font color='white'>Update All: </font>   <input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?updateall=true';document.add_sale.submit();\"></td>
		
		<td align='left'><font color='white'>Global Discount(%):</font>
		<input type='text' name='global_sale_discount' size='3'>
		<input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"></td>
		
		</tr>
		
		</table><br>";
		
		
	}	
	
	
if (($itemselected=="yes") and ($num_items==1)){
		
	echo "<br>
		<table align='center' bgcolor='$table_bg'>
		
		<td align='left'><font color='white'>Global Discount(%)</font></td>
		<td align='left'><input type='text' name='global_sale_discount' size='3'></td>
		<td><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"></td></tr>
		
		</table><br>";

	
	}
	
	
	

	
echo "</div>";


		

 echo " <div style=\"float:right; width:25%; background-color: HighLight; \"> ";
 echo "<font color='blue'><u><h3 align='center'>Running Total</h3></u></font>";

	
	
	
	
	
	$finalSubTotal=number_format($finalSubTotal,2,'.', '');
	$finalTax=number_format($finalTax,2,'.', '');
	$finalTotal=number_format($finalTotal,2,'.', '');
	
	
	
	
	echo "<table align='center' ><br>
	<tr><td  align='left'>SubTotal: $cfg_currency_symbol$finalSubTotal</td></tr>
	<tr><td align='left'>$lang->tax: $cfg_currency_symbol$finalTax</td></tr>";
	
	


	
	
	if(isset($_GET['global_sale_discount']))
	{
		$discount=$_GET['global_sale_discount'];
		echo"<tr><td align='left'>$discount% $lang->percentOff</td></tr>";

	}
	echo"<tr><td bgcolor=\"#23902C\" align='left'><b><font color=\"white\">Total Sale: $cfg_currency_symbol$finalTotal</b></font></td></tr>";
	
	echo'</table>';
	
	









	
	
	



	if ($TenderAmtBoxNextstep!="yes" && $cfg_ShowTenderAmtBox_as2nd_Step=="yes"){
		echo "<br>
		<table align='center' bgcolor='$table_bg'><br>
		<tr><td align='left'><font color='white'>Click to Add Payment/Comment</font></td>
		<td><input type='button' name='updateQuantity$k' value='Add Payment ' onclick=\"document.add_sale.action='sale_ui.php?updateall=true&gotoaddpayment=yes';document.add_sale.submit();\"></td></tr>
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
	<option value='$lang->giftCertificate'>$lang->giftCertificate</option>
	<option value='$lang->account'>$lang->account</option>
	<option value='$lang->other'>$lang->other</option>
	</select>
	<font color='white'>$lang->amtTendered:<input  type='text' name='amt_tendered' value='$amt_tendered'></font>
	</td>
	</tr>
	<tr>
	<td>
	<font color='white'>$lang->saleComment:</font>
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
	  <center><b><input type='submit'  value=' Complete Sale ' style='width:200;height:35; font-size: larger; color: #1D211D; background-color:#CFD3D2'></b></center></form>";		
	  }

	  
	  
	if ($TenderAmtBoxNextstep!="yes" && $cfg_ShowTenderAmtBox_as2nd_Step=="no"){
	
	echo "<br><table border='0' bgcolor='$table_bg' align='center'>
	
		
		<tr>
	<td>
	<font color='white'>$lang->amtTendered:</font>
	</td>
	<td>
	<input  type='text' name='amt_tendered' value='$amt_tendered'>
	</td>
	</tr>
	
	
	
	
	<tr>
	<td>
	<font color='white'>$lang->paidWith:</font> 
	</td>
	<td>
	<select name='paid_with'>
	<option value='$lang->cash'>$lang->cash</option>
	<option value='$lang->check'>$lang->check</option>
	<option value='$lang->credit'>$lang->credit</option>
	<option value='$lang->giftCertificate'>$lang->giftCertificate</option>
	<option value='$lang->account'>$lang->account</option>
	<option value='$lang->other'>$lang->other</option>
	</select>
	
	</td>
	</tr>
	
	<tr>
	<td>
	<font color='white'>$lang->saleComment:</font>
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
	  <center><b><input type='submit'  value=' Complete Sale ' style='width:200;height:35; font-size: larger; color: #1D211D; background-color:#CFD3D2'></b></center></form>";		
	  }
	  
	  
	  
	 	if ($TenderAmtBoxNextstep=="yes" && $cfg_ShowTenderAmtBox_as2nd_Step=="no"){
	
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
	<option value='$lang->giftCertificate'>$lang->giftCertificate</option>
	<option value='$lang->account'>$lang->account</option>
	<option value='$lang->other'>$lang->other</option>
	</select>
	<font color='white'>$lang->amtTendered:<input  type='text' name='amt_tendered' value='$amt_tendered'></font>
	</td>
	</tr>
	<tr>
	<td>
	<font color='white'>$lang->saleComment:</font>
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
	  <center><input type='submit' value=' Add Sale '></center></form>";		
	  }
	  

				
 echo "</div></div>";
 
 

	  
}




  
$dbf->closeDBlink();


?>
</body>
</html>