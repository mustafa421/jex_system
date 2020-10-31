<?php session_start();?> 

<?php
include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/form.php");
include ("../classes/display.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);




if(!$sec->isLoggedIn())
{

	header ("location: ../login.php");
	exit ();
}

?>


<html>
<head>
	<style type="text/css">
	
	/* START CSS NEEDED ONLY IN DEMO */
	html{
		height:100%;
	}
	body{
		background-color:#FFF;
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;	
		width:100%;
		height:100%;		
		margin:0px;
		text-align:center;
	}
	
	#mainContainer{
		width:660px;
		margin:0 auto;
		text-align:left;
		height:100%;
		background-color:#FFF;
		border-left:3px double #000;
		border-right:3px double #000;
	}
	#formContent{
		padding:5px;
	}
	/* END CSS ONLY NEEDED IN DEMO */
	
	
	/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #317082;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-size:0.9em;
		z-index:100;
	}
	#ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
		margin:1px;		
		padding:1px;
		cursor:pointer;
		font-size:0.9em;
	}
	#ajax_listOfOptions .optionDiv{	/* Div for each item in list */
		
	}
	#ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
		background-color:#317082;
		color:#FFF;
	}
	#ajax_listOfOptions_iframe{
		background-color:#F00;
		position:absolute;
		z-index:5;
	}
	
	form{
		display:inline;
	}
	
	</style>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/ajax-dynamic-list.js">
	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, April 2006
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	Gets the list of suppliers by typing letters
	************************************************************************************************************/	
	</script>
<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript">
	/************************************************************************************************************
	Ajax client lookup
	Copyright (C) 2006  DTHMLGoodies.com, Alf Magne Kalleland
	
	This library is free software; you can redistribute it and/or
	modify it under the terms of the GNU Lesser General Public
	License as published by the Free Software Foundation; either
	version 2.1 of the License, or (at your option) any later version.
	
	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details.
	
	You should have received a copy of the GNU Lesser General Public
	License along with this library; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
	
	Dhtmlgoodies.com., hereby disclaims all copyright interest in this script
	written by Alf Magne Kalleland.
	
	Alf Magne Kalleland, 2006
	Owner of DHTMLgoodies.com
	
	Get DVD Title
	************************************************************************************************************/	
	
	var ajax = new sack();
	var currentClientID=false;
	
	function getClientData()
	{
		var clientId = document.getElementById('item_number').value.replace(/[^0-9]/g,'');
		if(clientId.length > 2 && clientId!=currentClientID){
			currentClientID = clientId
			ajax.requestFile = 'getGameDVDTitle.php?getClientId='+clientId;	
			ajax.onCompletion = showClientData;	
			ajax.runAJAX();		
			
		}
		
	}
	
	function showClientData()
	{
		
		var formObj = document.forms['gamedvds'];
		eval(ajax.response);
	}
	
	
	function initFormEvents()
	{
		document.getElementById('item_number').onblur = getClientData;
		document.getElementById('item_number').focus();
	}
	
	window.onload = initFormEvents;
	

var gamedvdtitle_value;
function MPClearField(field) {
  var fieldName = field.name;
  if (field.value == "NotFound"){
        field.value = '';
        
        
        var reason = ""; 
        gamedvdtitle_value = field.value;      
        
    }
}

function validateFormOnSubmit(theForm) {

var reason = "";


reason += validateGamedvdtitle(theForm.description);
reason += validateItemNumber(theForm.item_number);
reason += validatesupplier(theForm.supplier_id);
reason += validateBuy_price(theForm.buy_price);
reason += validateUnit_price(theForm.unit_price);
reason += validatefounditemckbox(theForm.itemfound,theForm.founddesc);




 




 
 
 
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

function validateGamedvdtitle(fld) {
    var error = "";
 
    if (gamedvdtitle_value == 'NotFound') {
        fld.style.background = 'Yellow'; 
        
        error = "Enter Game DVD Title.\n";
    } else if ((fld.value == "") || (fld.value == "NotFound")){
    	   fld.style.background = 'Yellow'; 
        error = "Game DVD Title not found in catalog Please enter Game DVD Title.\n";
    
    } else {
        fld.style.background = 'White';
    }
    return error;  
}


function validateItemname(fld) {
    var error = "";
   
   
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "DVD Title is blank.\n";
    } else if ((fld.value.length < 2) || (fld.value.length > 200)) {
        fld.style.background = 'Yellow'; 
        error = "The DVD Title is wrong length.\n";
    } else if (fld.value == "NotFound") {
         fld.style.background = 'Yellow'; 
         error = "Please Delete NotFound and Enter DVD Title.\n";
   
   
   
   
    } else {
        fld.style.background = 'White';
        
        
    }
    return error;
}
function validateItemNumber(fld) {
    var error = ""; 
    var illegalChars = /\W/; 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "UPC code is blank. Please scan the DVD.\n";
    } else if ((fld.value.length < 6) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The UPC code is wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The UPC code contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}
function validatesupplier(fld) {
    var error = ""; 
   
     var dash_pos=fld.value.indexOf('-');
    
    var onlysupplierID = fld.value.substring(0,dash_pos);
    
    
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter Supplier Name. Please select the supplier name from the list\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 30)) {
        fld.style.background = 'Yellow'; 
        error = "The Supplier Name is the wrong length.\n"; 
    } else if (dash_pos == -1) {
     	  fld.style.background = 'Yellow'; 
        error = "Incorrect Supplier Name. Reload Page and select supplier Name again\n";   
    } else if (isNaN(onlysupplierID)) {
     	  fld.style.background = 'Yellow'; 
        error = "The Supplier Name contains illegal characters. First charactor should be numaric. Reload Page and select supplier Name again\n";   
    } else {
        fld.style.background = 'White';
    }
    return error;
}

function validateBuy_price(objName)
{




var period = '.';
var checkOK = "0123456789" + period;
var checkStr = objName;
var allValid = true;
var decPoints = 0;
var allNum = "";
var error = "";

if (objName.value != "") {
					for (i = 0;  i < checkStr.value.length;  i++)
					{
					ch = checkStr.value.charAt(i);
					for (j = 0;  j < checkOK.length;  j++)
					if (ch == checkOK.charAt(j))
					
					break;
					if (j == checkOK.length)
					{
					allValid = false;
					break;
					}
					if (ch != ",")
					allNum += ch;
					}
					if (!allValid)
					{	
					alertsay = "Please enter only these values \""
					alertsay = alertsay + checkOK + "\" in the \"" + checkStr.name + "\" field."
					alert(alertsay);
					objName.style.background = 'Yellow';
					return (false);
					}
					
				
				
				
				
				
				
				
				
				
				
				
				objName.style.background = 'White';
}else{
        objName.style.background = 'Yellow'; 
       error = "Please enter the Buying Price of this DVD.\n";
}
return error;
}



function validateUnit_price(objName)
{




var period = '.';
var checkOK = "0123456789" + period;
var checkStr = objName;
var allValid = true;
var decPoints = 0;
var allNum = "";
var error = "";

if (objName.value != "") {
					for (i = 0;  i < checkStr.value.length;  i++)
					{
					ch = checkStr.value.charAt(i);
					for (j = 0;  j < checkOK.length;  j++)
					if (ch == checkOK.charAt(j))
					
					break;
					if (j == checkOK.length)
					{
					allValid = false;
					break;
					}
					if (ch != ",")
					allNum += ch;
					}
					if (!allValid)
					{	
					alertsay = "Please enter only these values \""
					alertsay = alertsay + checkOK + "\" in the \"" + checkStr.name + "\" field."
					alert(alertsay);
					objName.style.background = 'Yellow';
					return (false);
					}
					
				
				
				
				
				
				
				
				
				
				
				
				objName.style.background = 'White';

}else{
        objName.style.background = 'Yellow'; 
        error = "Please enter the Sell Price for this DVD.\n";
}
return error;

}

function validatefounditemckbox(fld,fld2) {
var error = "";
	if (
	fld.checked == true && fld2.value == "" ) 
	{
	
	    fld2.style.background = 'Yellow'; 
        error = "Enter Item Found Description.\n";
		
		
		
	} else { 	
	    fld2.style.background = 'white'; 
		
	}
	return error;
}	

	</script>
</head>

<body>
<?php





if ($handle = opendir('pdfforms')) {
   while (false !== ($file = readdir($handle))) {
       if ($file != "." && $file != "..") {
          
          $fileurl='pdfforms/'.$file;
          echo "<a href=\"$fileurl\" target=\"_blank\">Sale Agreement file: $file</a><br />";
       }
   }
   closedir($handle);
}













  	










$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		header ("location: ../login.php");
		exit();
}

$articletable=$cfg_tableprefix.'articles';
$categorytable=$cfg_tableprefix.'categories';
$suppliertable=$cfg_tableprefix.'suppliers';


$tb1=mysql_query("SELECT id FROM $articletable",$dbf->conn);
$tb2=mysql_query("SELECT id FROM $categorytable",$dbf->conn);
$tb3=mysql_query("SELECT id,supplier FROM $suppliertable",$dbf->conn);

if(mysql_num_rows($tb1)==0 or mysql_num_rows($tb2)==0 or mysql_num_rows($tb3)==0)
{
	
	echo "$lang->articlessCategoriesSupplierError";
	exit();
}


$item_name_value='';
$item_number_value='';
$category_id_value='';
$article_id_value='';
$supplier_id_value='';
$buy_price_value='';
$unit_price_value='';
$supplier_catalogue_number_value='';
$tax_percent_value="$cfg_default_tax_rate";
$total_cost_value='';
$quantity_value='';
$reorder_level_value='';
$item_image_value=''; 
$id='unknown';
$totalowner_checked='checked';

if(isset($_POST['item_number'])){
  $item_number_value = $_POST['item_number'];
    
      $s_id = $_POST['workingon_id'];
      if ($s_id != "") {
	       $suppliertablename = "$cfg_tableprefix".'suppliers';
		     $supplier_result = mysql_query("SELECT * FROM $suppliertablename WHERE id=\"$s_id\"",$dbf->conn);
		     $supplier_table_row = mysql_fetch_assoc($supplier_result);
     	     $supplier_value = $supplier_table_row['id']."-".$supplier_table_row['supplier'];    
       }  
      
           
      if(isset($_POST['transaction_id'])){ 
     	   $transaction_id_value=$_POST['transaction_id'];
     	   
     	  } 

		  
		  
          


  $tablename = "$cfg_tableprefix".'items';  
  $enteredupc=$item_number_value;
  $res1 = "select * from gamedvd_catalog where upc = $enteredupc";
  $commondbf=new db_functions($cfg_server,$cfg_commondbuser,$cfg_commondbpwd,$cfg_commondbname,$cfg_tableprefix,$cfg_theme,$lang);
  $dvd_table_result = mysql_query($res1,$commondbf->conn);  
  
  $dvd_table_row = mysql_fetch_assoc($dvd_table_result);
  $description_value=$dvd_table_row['title'];    

   if ($description_value==""){
      $description_value = "NotFound";
      $gamedvdtitle_in_catalog_value = 'no';
   }else{
      $gamedvdtitle_in_catalog_value = 'yes';
    }	



  $check_item_table="SELECT item_number FROM $tablename WHERE item_number = $enteredupc";
  if(mysql_num_rows(mysql_query($check_item_table,$dbf->conn))){
       
       
      if ($cfg_gamedvd_upc=="gamedvdupc"){
	           $items_table_query="SELECT * FROM $tablename WHERE item_number = $enteredupc";
				$items_table_result=mysql_query($items_table_query,$dbf->conn);
				$items_table_row = mysql_fetch_assoc($items_table_result);

   			$item_table_quantity=$items_table_row['quantity'];   			
   			$buy_price_value=$items_table_row['buy_price'];
   			$unit_price_value=$items_table_row['unit_price'];
   		    $quantity_value = $item_table_quantity + 1;
			$reorder_level_value = 0; 	
   		}    
		if ($cfg_gamedvd_upc=="storeupc"){
   		    $buy_price_value = $cfg_gamedvd_buyprice;
      	    $unit_price_value = $cfg_gamedvd_sellprice;
      	    $quantity_value = 1;
      	    $reorder_level_value = 0;
   		 }
		 
      }else {
      	
      	$buy_price_value = $cfg_gamedvd_buyprice;
      	$unit_price_value = $cfg_gamedvd_sellprice;
      	$quantity_value = 1;
      	$reorder_level_value = 0;
      }



}




		
		
		if ($_GET['csa'] == 'yes'){$saleagreement_checked = 'checked';};
		


if(isset($_GET['action']))
{
	$action=$_GET['action'];
}
else
{
	$action="insert";
	
}


if($action=="update")
{
	$display->displayTitle("$lang->updateItem");
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'items';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$item_name_value=$row['item_name'];
		$item_number_value=$row['item_number'];
		$category_id_value=$row['category_id'];
		$supplier_id_value=$row['supplier_id'];
		$kindsize_value = $row['kindsize'];
		$numstone_value = $row['numstone'];
		$serialnumber_value = $row['serialnumber'];
		$brandname_value = $row['brandname'];
		$itemsize_value = $row['itemsize'];
		$itemcolor_value = $row['itemcolor'];
		$itemmodel_value = $row['itemmodel'];
		$description_value = $row['description'];
		$buy_price_value=$row['buy_price'];
		$unit_price_value=$row['unit_price'];
		$supplier_catalogue_number_value=$row['supplier_catalogue_number'];
		$tax_percent_value=$row['tax_percent'];
		$total_cost_value=$row['total_cost'];
		$quantity_value=$row['quantity'];
		$reorder_level_value=$row['reorder_level'];
		$item_image_value=$row['item_image']; 
		$id=$row['id'];

		$curitemimage=$item_image_value;
	  
	  $system_assigned_itemnum=$item_number_value;
	}

}
else
{
	$display->displayTitle("$lang->addvdvd");

  
	 if (isset($_GET['working_on_id'])){
	       
	        $s_id= $_GET['working_on_id']; 
	  }
	  if  (isset($_GET['id'])){ 
	    $s_id= $_GET['id'];
	  }
	 
	 
	   if ($s_id != "") {
	    $suppliertablename = "$cfg_tableprefix".'suppliers';
		    $supplier_result = mysql_query("SELECT * FROM $suppliertablename WHERE id=\"$s_id\"",$dbf->conn);
		
		   $supplier_table_row = mysql_fetch_assoc($supplier_result);
     	 $supplier_value = $supplier_table_row['id']."-".$supplier_table_row['supplier'];      	   
     	 $workingon_id_value = $supplier_value; 
     	  }   	
	   
   
   
   
		     $auto_increment_table="'"."$cfg_tableprefix".'items'."'";
		      
		      $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ");
          $row = mysql_fetch_array($r);
          $Auto_increment = $row['Auto_increment'];
          
		 
		      $next_id=$Auto_increment;
    		
		     $itembarcode=$cfg_store_code.$next_id;	
     	
     
     	if(isset($_GET['active_trans_id'])){ 
     	   $transaction_id_value=$_GET['active_trans_id'];
     	  }  	
     	
     	
  

}



if (($cfg_enable_CSAlink=="yes") and (isset($_GET['working_on_id'])) and (isset($_GET[active_trans_id]))){
   if ($cfg_store_state=="wi"){
       echo "<a href=\"create_saleagreement_WI.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Done create sale agreement</a>";
   }else{
	     echo "<a href=\"create_saleagreement_IL.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Done create sale agreement</a>";
   }

echo " | ";
echo "<a href=\"form_buy_jewelry.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Buy Jewelry</a>";
echo " | ";
echo "<a href=\"form_items.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add Items</a>";
echo " | ";
echo "<a href=\"form_items_dvd_v2.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add DVD</a>";
}else{
echo "<a href=\"form_buy_jewelry.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Buy Jewelry</a>";
echo " | ";
echo "<a href=\"form_items.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add Items</a>";
echo " | ";
echo "<a href=\"form_items_dvd_v2.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add DVD</a>";	
}






if ($item_number_value==""){
$f1=new form('return validateFormOnSubmit(this)',"form_items_videogame_dvd_v2.php?working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]",'POST','gamedvds_no','400',$cfg_theme,$lang);
}else{
$f1=new form('return validateFormOnSubmit(this)','process_form_items_videogame_dvd.php','POST','gamedvds_no','400',$cfg_theme,$lang);
}	

$f1->createInputField("<b>$lang->itemUPC:</b> ",'text','item_number',"$item_number_value",'24','160');

if ($item_number_value!=""){
$onfocus="onfocus='MPClearField(this)'";
$f1->createInputField("$lang->dvdtitle: ",'text','description',"$description_value",'50','160',$onfocus);

$categorytable = "$cfg_tableprefix".'categories';
$wherefield = ' category = '."'".'DVD'. "'";
$category_option_titles=$dbf->getAllElementswhere("$categorytable",'category',"$wherefield",'category');
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values=$dbf->getAllElementswhere("$categorytable",'id',"$wherefield",'category');
$category_option_values[0] = $category_id_value;

$f1->createSelectField("<b>$lang->category:</b>",'category_id',$category_option_values,$category_option_titles,'160');


$articletable = "$cfg_tableprefix".'articles';
$wherefield = ' article = '."'".'Game DVD'. "'";
$article_option_titles=$dbf->getAllElementswhere("$articletable",'article',"$wherefield",'article');
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values=$dbf->getAllElementswhere("$articletable",'id',"$wherefield",'article');
$article_option_values[0] = $article_id_value;

$f1->createSelectField("<b>Article:</b>",'article_id',$article_option_values,$article_option_titles,'160');

$suppliertable = "$cfg_tableprefix".'suppliers';

$supplier_option_titles=$dbf->getAllElements("$suppliertable",'supplier','supplier');
$supplier_option_titles[0] = $dbf->idToField("$suppliertable",'supplier',"$supplier_id_value");
$supplier_option_values=$dbf->getAllElements("$suppliertable",'id','supplier');
$supplier_option_values[0] = $supplier_id_value;

$onkeyup = "onkeyup=".'"'."ajax_showOptions(this,'getCountriesByLetters',event)".'"';
$f1->createInputField("<b>$lang->supplier:</b> ",'text','supplier_id',"$supplier_value",'24','160',$onkeyup);

if($action=="insert"){
$f1->createInputField("Total_Owner:",'checkbox','totalowner',"Y",'10','160',"$totalowner_checked");
$f1->createInputField("Item_Found:",'checkbox','itemfound',"Y",'10','160',"$itemfound_checked");
$f1->createTextareaField("Found_Desc ",'founddesc','2','40',"$founddesc_value",'2');
}

$f1->createInputField("<b>$lang->buyingPrice:</b>",'text','buy_price',"$buy_price_value",'10','160');
$f1->createInputField("<b>$lang->sellingPrice ($lang->wo $lang->tax):</b>",'text','unit_price',"$unit_price_value",'10','160');

$f1->createInputField("$lang->supplierCatalogue: ",'text','supplier_catalogue_number',"$supplier_catalogue_number_value",'24','160');
$f1->createInputField("<b>$lang->quantityStock:</b> ",'text','quantity',"$quantity_value",'3','160');
$f1->createInputField("<b>$lang->reorderLevel:</b> ",'text','reorder_level',"$reorder_level_value",'3','160');
if ($cfg_enableimageupload_gdvd == "yes" and $cfg_imagesnapmethod == "pc"){ 
$f1->createInputField("$lang->itemimagelab: ",'file','item_image',"$item_image_value",'30','160'); 
}

}




echo "
		<input type='hidden' name='transaction_id' value='$transaction_id_value'>
		<input type='hidden' name='workingon_id' value='$workingon_id_value'>
		<input type='hidden' name='gamedvdtitle_in_catalog' value='$gamedvdtitle_in_catalog_value'>
		<input type='hidden' name='item_name' value='$item_name_value'>
		<input type='hidden' name='tax_percent' value='$tax_percent_value'>
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
$f1->endForm();

$dbf->closeDBlink();

if(isset($_GET['active_trans_id'])){ 







}



if (($cfg_enable_CSAlink=="yes") and (isset($_GET['working_on_id'])) and (isset($_GET[active_trans_id]))){
   if ($cfg_store_state=="wi"){
       echo "<a href=\"create_saleagreement_WI.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Done create sale agreement</a>";
   }else{
	     echo "<a href=\"create_saleagreement_IL.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Done create sale agreement</a>";
   }
echo " | ";
echo "<a href=\"form_buy_jewelry.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Buy Jewelry</a>";
echo " | ";
echo "<a href=\"form_items.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add Items</a>";
echo " | ";
echo "<a href=\"form_items_dvd_v2.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add DVD</a>";
}else{
echo "<a href=\"form_buy_jewelry.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Buy Jewelry</a>";
echo " | ";
echo "<a href=\"form_items.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add Items</a>";
echo " | ";
echo "<a href=\"form_items_dvd_v2.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add DVD</a>";
}
?>

</body>
</html>






