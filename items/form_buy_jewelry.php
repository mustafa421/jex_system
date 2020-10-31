<?php session_start(); ?>

<html>
<head>
<script type="text/javascript"> </script>
	<title>Inventory System</title>

	<link rel="stylesheet" href="../classes/css/lightbox.css" type="text/css" media="screen" />
	
	<script src="../classes/js/prototype.js" type="text/javascript"></script>
	<script src="../classes/js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="../classes/js/lightbox.js" type="text/javascript"></script>

<script type="text/javascript">
	
		
		
		function autoFireLightbox() {
			
			
			setTimeout(function() {
				if(document.location.hash && $(document.location.hash.substr(1)).rel.indexOf('lightbox')!=-1) {
				
					myLightbox.start($(document.location.hash.substr(1)));
				}},
				250
			);
		}
		Event.observe(window, 'load', autoFireLightbox, false);
	
</script>

	<style type="text/css">
		body{ color: #333; font: 13px 'Lucida Grande', Verdana, sans-serif;	}
	</style>
	
<script type="text/javascript"> </script>		
	
	
	
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
<script type="text/javascript">
		function reload(form){

		var valaction=form.action.value; 


if (valaction == "insert") {
		var imagesnapmethod = "<?php echo($cfg_imagesnapmethod);?>";
		var enableimageupload_items = "<?php echo($cfg_enableimageupload_jewelry);?>";
		var valsupplierid=form.supplier_id.value;
		var valcat=form.category_id.options[form.category_id.options.selectedIndex].value;
		var valarticleid=form.article_id.options[form.article_id.options.selectedIndex].value;
		var valitemgender=form.item_gender.options[form.item_gender.options.selectedIndex].value;
		var valmaterialtype=form.material_type.options[form.material_type.options.selectedIndex].value;
		
		var valjewelrybuytype=form.jewelrybuy_type.options[form.jewelrybuy_type.options.selectedIndex].value;

		var valkindsize=form.kindsize.value;
		var valnumstone=form.numstone.value;
		var valbrandname=form.brandname.value;
		var valserialnumber=form.serialnumber.value;
		var valitemmodel=form.itemmodel.value;
		var valdescription=form.description.value;
		
		var checktotalowner=form.totalowner.checked;
		if (checktotalowner == true)
		{
			var valtotalowner='checked';
		}
		
		var checkitemfound=form.itemfound.checked;
		if (checkitemfound == true)
		{
			var valitemfound='checked';
		}
		
		var valfounddesc=form.founddesc.value;
		var valbuyprice=form.buy_price.value;
		

		if (valjewelrybuytype == "ReSaleJewelry")
		{
			var valunitprice=form.unit_price.value;
			var valquantity=form.quantity.value;
			var valreorderlevel=form.reorder_level.value;
		}
		


		
var valtranid=form.transaction_id.value; 
var valitemnumber=form.item_number.value; 
var valitemname=form.item_name.value; 
var valtaxpercent=form.tax_percent.value; 
var valsystemgenitemnum=form.system_gen_itemnum.value; 
var valonlyloadimage=form.onlyloadimage.value; 

var valitemtblrowid=form.itemtblrowid.value; 
var valinventorytblrowid=form.inventorytblrowid.value; 


var valaction=form.action.value; 
var valid=form.id.value; 

if ((enableimageupload_items == "yes") && (imagesnapmethod == "pc")) {
var valitemimage=form.item_image.value;
}

self.location='form_buy_jewelry.php?reloadcat=yes&valitem_number_value=' + valitemnumber
+'&valdescription=' + valdescription
+'&valcat=' + valcat
+'&valarticleid=' + valarticleid
+'&valsupplierid=' + valsupplierid
+'&valitemgender=' + valitemgender
+'&valmaterialtype=' + valmaterialtype
+'&valjewelrybuytype=' + valjewelrybuytype
+'&valkindsize=' + valkindsize
+'&valnumstone=' + valnumstone
+'&valbrandname=' + valbrandname
+'&valserialnumber=' + valserialnumber
+'&valitemmodel=' + valitemmodel
+'&valtotalowner=' + valtotalowner
+'&valitemfound=' + valitemfound
+'&valfounddesc=' + valfounddesc
+'&valbuyprice=' + valbuyprice
+'&valunitprice=' + valunitprice
+'&valquantity=' + valquantity
+'&valreorderlevel=' + valreorderlevel
+'&valtranid=' + valtranid
+'&valitemnumber=' + valitemnumber
+'&valitemname=' + valitemname
+'&valtaxpercent=' + valtaxpercent
+'&valsystemgenitemnum=' + valsystemgenitemnum
+'&valonlyloadimage=' + valonlyloadimage
+'&valitemtblrowid=' + valitemtblrowid
+'&valinventorytblrowid=' + valinventorytblrowid

+'&valaction=' + valaction
+'&valid=' + valid


if ((enableimageupload_items == "yes") && (imagesnapmethod == "pc")) {
+'&valitemimage=' + valitemimage
}
}
;
}



function validateFormOnSubmit(theForm) {
var reason = "";


 reason += validateCategoryid(theForm.category_id);

 reason += validateWatchbrand(theForm.category_id,theForm.brandname);

 reason += validateItem_Gender(theForm.item_gender);   

 reason += validatematerial_type(theForm.material_type); 
 
 var valaction=theForm.action.value; 
 if (valaction == "insert") {
 reason += validatefounditemckbox(theForm.itemfound,theForm.founddesc);
}
 reason += validateArticleid(theForm.article_id);
 reason += validatedescription(theForm.description);

 reason += validatesuppliername(theForm.supplier_id);
 reason += validateBuy_price(theForm.buy_price); 
 
 

 
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

function validateItem_Gender(fld) {
    var error = "";
    

    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
       if (fld.value == "null") {
              fld.style.background = 'Yellow';
              error = "Select Item Gender from the dropdown box.\n";      	 
    } else {
        fld.style.background = 'White';
       
    }
    
    return error;
}

function validatematerial_type(fld) {
    var error = "";
    

    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
       if (fld.value == "null") {
              fld.style.background = 'Yellow';
              error = "Select Material Type from the dropdown box.\n";      	 
    } else {
        fld.style.background = 'White';
       
    }
    
    return error;
}
function validateBrand(fld,fld2) {
    var error = "";



    if (fld.value == "blank" && fld2.value == "") {
        fld.style.background = 'Yellow'; 
        fld2.style.background = 'Yellow'; 
        error = "Please select the brand from the dropdown list. If Brand not in the list leave this blank and Type in the brand in brand name field below\n"
     }else if (fld.value != "blank" && fld2.value != "") {
        fld2.style.background = 'White';
        fld2.value = "";
        alert('You have selected Brand therefore BrandName filed has been blanked');
    } else {

       fld.style.background = 'White';
       fld2.style.background = 'White'; 
    }
    return error;  
}

function validateWatch(fld,fld2) {
    var error = "";



    if (fld.value == "3" && fld2.value == "") {

        fld2.style.background = 'Yellow'; 
        error = "Please Enter Watch Serial/Model\n"
     }else if (fld.value == "3" && fld2.value != "") {
        fld2.style.background = 'White';

        
    }else if (fld.value != "3") {
        fld2.style.background = 'White';

    }		
    return error;  
}

function validateWatchbrand(fld,fld2) {
    var error = "";



    if (fld.value == "3" && fld2.value == "") {

        fld2.style.background = 'Yellow'; 
        error = "Please Enter Watch Brand\n"
     }else if (fld.value == "3" && fld2.value != "") {
        fld2.style.background = 'White';

        
    }else if (fld.value != "3") {
        fld2.style.background = 'White';

    }		
    return error;  
}


function validateCat(fld) {
    var error = "";
 alert('The Brand value '+fld.value+' ');
   
}



function validateItemgender(fld) {
var error = "";

myOption = -1;
for (i=fld.length-1; i > -1; i--) {
if (fld[i].checked) {
myOption = i; i = -1;
}
}
if (myOption == -1) {
	

  error = "You must select a Item Gender.\n";


}


return error;
}


function validatematerialtype(fld) {
var error = "";

myOption = -1;
for (i=fld.length-1; i > -1; i--) {
if (fld[i].checked) {
myOption = i; i = -1;
}
}
if (myOption == -1) {
	

  error = "You must select material type.\n";


}


return error;
}

function validateCategoryid(fld) {
    var error = "";
    

    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
       if (fld.value == "blank") {
              fld.style.background = 'Yellow';
              error = "Select category for the dropdown box.\n";      	 
    } else {
        fld.style.background = 'White';
       
    }
    
    return error;
}

function validateArticleid(fld) {
    var error = "";
    

    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
       if (fld.value == "blank") {
              fld.style.background = 'Yellow';
              error = "Select Article from the dropdown box.\n";      	 
    } else {
        fld.style.background = 'White';
       
    }
    
    return error;
}



function validatedescription(fld) {
    var error = "";
    

      var illegalChars= /[\<\>\,\;\:\\\/\"\[\]]/
       if (fld.value == "") {
              fld.style.background = 'Yellow';
              error = "Enter Description of this Item.\n";   
    	 }else if ((fld.value.length < 2) || (fld.value.length > 210)) {
              fld.style.background = 'Yellow';
              error = "The Description is the wrong length. Max 210 \n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The Description contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
       
    }
    
    return error;
}


function validateItemname(fld,fld2) {
  


    var error = "";

    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "blank" && fld2.value == "") {
        fld.style.background = 'Yellow'; 
        fld2.style.background = 'Yellow';
        error = "You didn't select Article from dropdown list. If Article name not in list leave article field blank and type article name in item name field.\n";
    }else if (fld.value != "blank" && fld2.value != "") {
        fld2.style.background = 'White';
        fld2.value = "";
        alert('You have selected Article from dropdown list therefore Item Name field has been blanked out');
    } else 
    	   if (((fld2.value.length < 2) || (fld2.value.length > 30)) && ((fld2.value != "") && (fld.value == "blank"))) {
              fld2.style.background = 'Yellow'; 
              fld.style.background = 'white';
              error = "The Item Name is the wrong length.\n";
    } else if (illegalChars.test(fld2.value)) {
        fld2.style.background = 'Yellow'; 
        error = "The Item Name contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
        fld2.style.background = 'White';
    }
    return error;
}
function validateItemNumber(fld,fld2) {
    var error = ""; 
    var illegalChars = /\W/; 
    var system_assigned_itemnum = fld2.value; 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "Item Number is blank This should fill Automatically. Cancle and come back to this screen again.\n";

       } else if (fld.value != system_assigned_itemnum) {
        fld.style.background = 'Yellow'; 
        error = 'The Item number value should be '+system_assigned_itemnum+'.\n';
        alert('The Item number value should be '+system_assigned_itemnum+' Please correct it');
    } else if ((fld.value.length < 3) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The Item number is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The Item number contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}
function validatesuppliername(fld) {
    var error = "";
    
    var dash_pos=fld.value.indexOf('-');

    var onlysupplierID = fld.value.substring(0,dash_pos);

    
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "Select the supplier name from the list.\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 50)) {
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
       error = "Please enter the Buying Price of this item.\n";
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

function checkCheckBoxes(theForm) {
	if (
	theForm.CHECKBOX_1.checked == false &&
	theForm.CHECKBOX_2.checked == false &&
	theForm.CHECKBOX_3.checked == false) 
	{
		alert ('You didn\'t choose any of the checkboxes!');
		return false;
	} else { 	
		return true;
	}
}



</script>

</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/form.php");
include ("../classes/display.php");



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
$tb3=mysql_query("SELECT id FROM $suppliertable",$dbf->conn);

if(mysql_num_rows($tb1)==0 or mysql_num_rows($tb2)==0 or mysql_num_rows($tb3)==0)
{

	echo "$lang->articlessCategoriesSupplierError";
	exit();
}


		$userstable="$cfg_tableprefix".'users';
		$userid=$_SESSION['session_user_id'];
    $user_result = mysql_query("SELECT type FROM $userstable WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $usertype=$usertable_row['type'];



    	



$item_name_value='';
$description_value='';
$item_number_value='';
$brand_id_value='';
$category_id_value='';
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
$show_supplierLicPic = 'No';
$show_create_sapdf='yes';
$totalowner_checked='checked';





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

if(isset($_GET['onlyloadimage'])){
$onlyloadimage=$_GET['onlyloadimage'];
$onlyloadimage_value=$_GET['onlyloadimage'];
$itemtblrowid_value=$_GET['itemtblrowid'];
}

if ($onlyloadimage != "yes"){
	$display->displayTitle("$lang->updateItem");
}else{
    $display->displayTitle("Load Jewelry Image (only image filed is used)");
}

	if(isset($_GET['id']))
	{
		$id=$_GET['id'];

		$tablename = "$cfg_tableprefix".'item_transactions';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);

		$category_id_value=$row['category_id'];
		$supplier_id_value=$row['supplier_id'];
		$article_id_value = $row['article_id'];
		$itemgender_value = $row['item_gender'];
		$materialtype_value = $row['material_type'];

		$transaction_id_value = $row['transaction_id'];
		$shareinventorytbl_rowid_value = $row['share_inventorytbl_rowid'];
		$itemtblrowid_value = $row['itemrow_id'];
		$cat_id_fromtable='yes';
		$article_id_fromtable='yes';
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
		

		
		$quantity_value=$row['quantity'];
		$reorder_level_value=$row['reorder_level'];
		$itementerdate=$row['date'];
		$add_toinventory =$row['addtoinventory'];
		$item_image_value=$row['item_image']; 
		$id=$row['id'];
		
		if ($row['addtoinventory'] == 'Y'){$addtoinventory_checked = 'checked';}
		if ($description_value == ""){$description_value = 'Description Not Found';}
		
		$curitemimage=$item_image_value;
	   
	     if ($cfg_data_outside_storedir == "yes"){
            $curitemimage=$cfg_data_itemIMGpathdir.$curitemimage;
	        
        }else{
	        $curitemimage="images/".$curitemimage;
	        
        }
	   
	   
	   
	   
	  
	   $result2 = mysql_query("SELECT * FROM $suppliertable WHERE id=\"$supplier_id_value\"",$dbf->conn);
	   $row2 = mysql_fetch_assoc($result2);
	   $supplier2=$row2['supplier'];
	   $supplier_value = $row2['id']."-".$row2['supplier']; 
	   
	   

	  
	  
	  
	  
	  
	  
	  $item_name_value = str_replace("'", "", "$item_name_value"); 
	  $item_name_value = str_replace(":", "", "$item_name_value");
	  $item_name_value = str_replace("/", "", "$item_name_value");
	  $item_name_value = str_replace("(", "", "$item_name_value");
	  $item_name_value = str_replace(")", "", "$item_name_value");
	  $item_name_value = str_replace(",", "", "$item_name_value");
	  $item_name_value = str_replace("[", "", "$item_name_value");
	  $item_name_value = str_replace("]", "", "$item_name_value");
	  $item_name_value = str_replace('"', "", "$item_name_value");
	  
	  
	  
      $transaction_number=$cfg_store_code.$row['id'];
      if ($transaction_number != $row['item_number']){
	   
	           $show_create_sapdf='no';
	     }
	}

}
else
{
	
	if ($_GET['addjewelrytoinventory'] == 'yes'){
 	  $display->displayTitle("$lang->addjewelry");
  }else{
    $display->displayTitle("Buy Jewelry");
  
  }

   
	    $workingonsupplier=$_GET['id']; 

	    
	    
	    if(isset($_GET['id'])){
	         $supplier_id_value=$_GET['id'];
	         $supplier_value=$supplier_id_value;
	    
	    $result3 = mysql_query("SELECT * FROM $suppliertable WHERE id=\"$supplier_id_value\"",$dbf->conn);
	   $row3 = mysql_fetch_assoc($result3);
	   $supplier3=$row3['supplier'];
	   $supplier_value = $row3['id']."-".$row3['supplier']; 	    
	    
	    }else{
	    
	          if(isset($_GET['working_on_id'])){
	          	 $woid=$_GET['working_on_id'];
	          	
	            	if ($woid != ""){

	          	
	                  $supplier_id_value=$_GET['working_on_id'];

	                  $result4 = mysql_query("SELECT * FROM $suppliertable WHERE id=\"$supplier_id_value\"",$dbf->conn);
	                  $row4 = mysql_fetch_assoc($result4);
	                  $supplier_imagepath= 'suppliers/'.$row4['image'];

	                  $supplier4=$row4['supplier'];
	                  $supplier_value = $row4['id']."-".$row4['supplier']; 
	                  }
	          }else{

	      }
	  }  
   
   
		     $auto_increment_table="'"."$cfg_tableprefix".'items'."'";
		      
		      $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ");
          $row = mysql_fetch_array($r);
          $Auto_increment = $row['Auto_increment'];
 
		 
		      $next_id=$Auto_increment;
    		
     	$quantity_value = 1;
     	$reorder_level_value = 0;
  
  


     	if(isset($_GET['active_trans_id'])){ 
     	   $transaction_id_value=$_GET['active_trans_id'];
     	  
     	  if ($transaction_id_value == "SupplierLicInDB"){
     	     $show_supplierLicPic = 'Yes';
     	     $transaction_id_value="";
     	  }  
     	} 


}
     



if ($onlyloadimage != "yes"){



if (($cfg_enable_CSAlink=="yes") and (isset($_GET['working_on_id'])) and (isset($_GET[active_trans_id]))){ 
    if ($cfg_store_state=="wi"){
        echo "<a href=\"create_saleagreement_WI.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$transaction_id_value\">Done create sale agreement</a> \n";
    }else{
      	echo "<a href=\"create_saleagreement_IL.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$transaction_id_value\">Done create sale agreement</a> \n";
    }

echo " | ";
echo "<a href=\"form_items.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Buy/Add Items</a>";
echo " | ";
   if ($cfg_dvdlookup_version=="2"){ 
      echo "<a href=\"form_items_dvd_v2.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd_v2.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
}else if ($cfg_dvdlookup_version=="3"){ 
      echo "<a href=\"form_items_dvd_v3.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd_v3.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
   
 }else{ 
   	  echo "<a href=\"form_items_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
   } 
}else{

echo "<a href=\"form_items.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Buy/Add Items</a>";
echo " | ";

   if ($cfg_dvdlookup_version=="2"){ 
      echo "<a href=\"form_items_dvd_v2.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd_v2.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
   }else if ($cfg_dvdlookup_version=="3"){ 
      echo "<a href=\"form_items_dvd_v3.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd_v3.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
   
   }else{
   	  echo "<a href=\"form_items_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
   } 
}


$quantity_value = 1;
$reorder_level_value = 0;
if(isset($_GET['reloadcat']))
{

$item_number_value=$_GET['valitem_number_value'];
$description_value=$_GET['valdescription'];
$valcat=$_GET['valcat'];
$valarticleid=$_GET['valarticleid'];
$supplier_value=$_GET['valsupplierid'];
$itemgender_value=$_GET['valitemgender'];
$materialtype_value=$_GET['valmaterialtype'];

$jewelrybuytype_value=$_GET['valjewelrybuytype'];

$kindsize_value=$_GET['valkindsize'];
$numstone_value=$_GET['valnumstone'];
$brandname_value=$_GET['valbrandname'];
$serialnumber_value=$_GET['valserialnumber'];
$itemmodel_value=$_GET['valitemmodel'];
$totalowner_checked=$_GET['valtotalowner'];

$itemfound_checked=$_GET['valitemfound'];

$founddesc_value=$_GET['valfounddesc'];

$unit_price_value=$_GET['valunitprice'];
if($unit_price_value == "undefined"){$unit_price_value = 0;}

$quantity_value=$_GET['valquantity'];
if($quantity_value == "undefined"){$quantity_value = 1;}

$reorder_level_value=$_GET['valreorderlevel'];
if($reorder_level_value == "undefined"){$reorder_level_value = 0;}



if(isset($_GET['valitemimage']))
{
$item_image_value=$_GET['valitemimage'];
}

$transaction_id_value=$_GET['valtranid'];
$item_number_value=$_GET['valitemnumber'];
$item_name_value=$_GET['valitemname'];
$tax_percent_value=$_GET['valtaxpercent'];
$system_assigned_itemnum=$_GET['valsystemgenitemnum'];
$onlyloadimage_value=$_GET['valonlyloadimage'];
$itemtblrowid_value=$_GET['valitemtblrowid'];
$shareinventorytbl_rowid_value=$_GET['valinventorytblrowid'];
$action=($_GET['valaction']);
$id=$_GET['valid'];




}



if ($cfg_processForm_version=="1"){
	$f1=new form('return validateFormOnSubmit(this)','process_form_jewelry_v1.php','POST','pjitems','400',$cfg_theme,$lang);
}else if ($cfg_processForm_version=="2"){
	$f1=new form('return validateFormOnSubmit(this)','process_form_jewelry_v2.php','POST','pjitems','400',$cfg_theme,$lang);
}



$suppliertable = "$cfg_tableprefix".'suppliers';

$supplier_option_titles=$dbf->getAllElements("$suppliertable",'supplier','supplier');
$supplier_option_titles[0] = $dbf->idToField("$suppliertable",'supplier',"$supplier_id_value");
$supplier_option_values=$dbf->getAllElements("$suppliertable",'id','supplier');
$supplier_option_values[0] = $supplier_id_value;


$onkeyup = "onkeyup=".'"'."ajax_showOptions(this,'getCountriesByLetters',event)".'"';
$f1->createInputField("<b>$lang->supplier:</b> ",'text','supplier_id',"$supplier_value",'24','160',$onkeyup);


$categorytable = "$cfg_tableprefix".'categories';

$wherefield = ' showon_jewelrypanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
$resultcat = mysql_query("SELECT * FROM $categorytable WHERE $wherefield ",$dbf->conn);
$numcat_rows = mysql_num_rows($resultcat);

if ($numcat_rows < 1) 
{

$wherefield = ' activate_category = '."'".'Y'. "'" . ' and category <> '."'".'DVD'. "'" . ' and category = '."'".'Jewelry'. "'" . ' or category = '."'".'Watch'. "'" . ' and category <> '."'".' '. "'";


$category_option_titles=$dbf->getAllElementswhere("$categorytable",'category',"$wherefield",'category');
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values=$dbf->getAllElementswhere("$categorytable",'id',"$wherefield",'category');
$category_option_values[0] = $category_id_value;



if ($cat_id_fromtable=="yes"){
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}



if(isset($_GET['valcat'])){
$catid=$_GET['valcat'];
$category_id_value=$catid;
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}


$f1->createSelectField("<b>$lang->category:</b>",'category_id',$category_option_values,$category_option_titles,'160');


if ($jewelrybuytype_value == "null" or $jewelrybuytype_value == " " or $jewelrybuytype_value == ""){
   $jewelrybuytype_value = 'ScrapGold';
   $jewelrybuytype_option_titles[0] = "$jewelrybuytype_value";
   $jewelrybuytype_option_values[0] = "$jewelrybuytype_value";
}else{
     $jewelrybuytype_option_titles[0] = "$jewelrybuytype_value";
   $jewelrybuytype_option_values[0] = "$jewelrybuytype_value";
}  
$jewelrybuytype_option_titles[1] = "ScrapGold";
$jewelrybuytype_option_values[1] = "ScrapGold";
$jewelrybuytype_option_titles[2] = "ReSaleJewelry";
$jewelrybuytype_option_values[2] = "ReSaleJewelry";

$onchange="onchange=".'"'."reload(this.form)".'"';
$f1->createSelectField("<b>JewelryBuy_Type:</b>",'jewelrybuy_type',$jewelrybuytype_option_values,$jewelrybuytype_option_titles,'160',$onchange);





$catJewelryID = $dbf->fieldToid("$categorytable",'category',"Jewelry");
$catWatchID =   $dbf->fieldToid("$categorytable",'category',"Watch");


$articletable = "$cfg_tableprefix".'articles';


$wherefield = '(article <>'." '". 'Video DVD'."' " .' and category_id =' ." '". "$catWatchID"."' ".' or category_id =' ." '". "$catJewelryID"."' ".'and article <>' ." '". 'Game DVD'."' ".'and activate_article = '."'".'Y'. "')";


$article_option_titles=$dbf->getAllElementswhere("$articletable",'article',"$wherefield",'article');
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values=$dbf->getAllElementswhere("$articletable",'id',"$wherefield",'article');
$article_option_values[0] = $article_id_value;

$article_option_titles[0] =" ";
$article_option_values[0] ='blank';

if ($article_id_fromtable=="yes"){
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values[0] = $article_id_value;
}




if(isset($_GET['valarticleid'])){
$article_id_value=$valarticleid;
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values[0] = $article_id_value;
}




$f1->createSelectField("<b>Article:</b>",'article_id',$article_option_values,$article_option_titles,'160');

}else{ 

$wherefield = ' showon_jewelrypanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";


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


if(isset($_GET['valcat'])){
$catid=$_GET['valcat'];
$category_id_value=$catid;
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}else if($action=="update"){ 
$category_id_value=$catid;
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}

$onchange="onchange=".'"'."reload(this.form)".'"';
$f1->createSelectField("<b>$lang->category:</b>",'category_id',$category_option_values,$category_option_titles,'160',$onchange);





if ($jewelrybuytype_value == "null" or $jewelrybuytype_value == " " or $jewelrybuytype_value == ""){
   $jewelrybuytype_value = 'ScrapGold';
   $jewelrybuytype_option_titles[0] = "$jewelrybuytype_value";
   $jewelrybuytype_option_values[0] = "$jewelrybuytype_value";
}else{
     $jewelrybuytype_option_titles[0] = "$jewelrybuytype_value";
   $jewelrybuytype_option_values[0] = "$jewelrybuytype_value";
}  
$jewelrybuytype_option_titles[1] = "ScrapGold";
$jewelrybuytype_option_values[1] = "ScrapGold";
$jewelrybuytype_option_titles[2] = "ReSaleJewelry";
$jewelrybuytype_option_values[2] = "ReSaleJewelry";

$f1->createSelectField("<b>JewelryBuy_Type:</b>",'jewelrybuy_type',$jewelrybuytype_option_values,$jewelrybuytype_option_titles,'160',$onchange);





$articletable = "$cfg_tableprefix".'articles a,'."$cfg_tableprefix".'categories b ';
$wherefield = ' a.category_id = ' ." '". "$catid"."'".'and  a.category_id = b.id and b.showon_jewelrypanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'";

$resultart = mysql_query("SELECT a.id FROM $articletable WHERE $wherefield ",$dbf->conn);
$numart_rows = mysql_num_rows($resultart);


$article_option_titles=$dbf->getAllElementswhere("$articletable",'a.article',"$wherefield",'a.article');
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values=$dbf->getAllElementswhere("$articletable",'a.id',"$wherefield",'a.article');
$article_option_values[0] = $article_id_value;



if ($numart_rows > 1){
	$article_option_titles[0] =" ";
	$article_option_values[0] ='blank';
} else if ($numart_rows == 1){ 
	$artrow = mysql_fetch_array($resultart);
	$article_id_value=$artrow['a.id'];
	$articletable1 = "$cfg_tableprefix".'articles';
	$article_option_titles[0] = $dbf->idToField("$articletable1",'article',"$article_id_value");
	$article_option_values[0] = $article_id_value;
}else{
	$article_option_titles[0] =" ";
	$article_option_values[0] ='blank';
}

if($action=="update"){ 
$articletable1 = "$cfg_tableprefix".'articles';
$article_option_titles[0] = $dbf->idToField("$articletable1",'article',"$article_id_value");
$article_option_values[0] = $article_id_value;
}

$f1->createSelectField("<b>Article:</b>",'article_id',$article_option_values,$article_option_titles,'160');


}
  
if ($itemgender_value == "null" or $itemgender_value == " " or $itemgender_value == ""){
   $itemgender_option_titles[0] = "";
   $itemgender_option_values[0] = 'null';
}else{
   $itemgender_option_titles[0] = "$itemgender_value";
   $itemgender_option_values[0] = "$itemgender_value";
}   
$itemgender_option_titles[1] = "LADIE'S";
$itemgender_option_values[1] = "LADIE'S";
$itemgender_option_titles[2] = "MEN'S";
$itemgender_option_values[2] = "MEN'S";
$itemgender_option_titles[3] = "NOGENDER";
$itemgender_option_values[3] = "NOGENDER";

$f1->createSelectField("<b>Item Gender:</b>",'item_gender',$itemgender_option_values,$itemgender_option_titles,'160');


if ($materialtype_value == "null" or $materialtype_value == " " or $materialtype_value == ""){
   $materialtype_option_titles[0] = "";
   $materialtype_option_values[0] = 'null';
}else{
   $materialtype_option_titles[0] = "$materialtype_value";
   $materialtype_option_values[0] = "$materialtype_value";
}   
$materialtype_option_titles[1] = "YELLOW GOLD";
$materialtype_option_values[1] = "YELLOW GOLD";
$materialtype_option_titles[2] = "WHITE GOLD";
$materialtype_option_values[2] = "WHITE GOLD";
$materialtype_option_titles[3] = "SILVER";
$materialtype_option_values[3] = "SILVER";
$materialtype_option_titles[4] = "OTHER";
$materialtype_option_values[4] = "OTHER";   

$f1->createSelectField("<b>Material_Type:</b>",'material_type',$materialtype_option_values,$materialtype_option_titles,'160');



$f1->createInputField("$lang->kindsize:",'text','kindsize',"$kindsize_value",'10','160');
$f1->createInputField("$lang->numstone:",'text','numstone',"$numstone_value",'10','160');
$f1->createInputField("$lang->brandname: ",'text','brandname',"$brandname_value",'24','160');

$f1->createInputField("$lang->watchserial: ",'text','serialnumber',"$serialnumber_value",'24','160');
$f1->createInputField("$lang->itemmodel: ",'text','itemmodel',"$itemmodel_value",'24','160');

$f1->createTextareaField("<b>$lang->jewelrydesc:</b> ",'description','2','40',"$description_value",'2');
if($action=="insert"){
$f1->createInputField("Total_Owner:",'checkbox','totalowner',"Y",'10','160',"$totalowner_checked");
$f1->createInputField("Item_Found:",'checkbox','itemfound',"Y",'10','160',"$itemfound_checked");
$f1->createTextareaField("Found_Desc ",'founddesc','2','40',"$founddesc_value",'2');
}
$f1->createInputField("<b>$lang->buyingPrice:</b>",'text','buy_price',"$buy_price_value",'10','160');



if ($jewelrybuytype_value == "ReSaleJewelry"){
    $f1->createInputField("$lang->sellingPrice ($lang->wo $lang->tax):",'text','unit_price',"$unit_price_value",'10','160');
    
    $f1->createInputField("<b>$lang->quantityStock:</b> ",'text','quantity',"$quantity_value",'3','160');
    $f1->createInputField("<b>$lang->reorderLevel:</b> ",'text','reorder_level',"$reorder_level_value",'3','160');
}


if ($cfg_enableimageupload_jewelry == "yes" and $cfg_imagesnapmethod == "pc"){
$f1->createInputField("$lang->itemimagelab: ",'file','item_image',"$item_image_value",'30','160'); 
}

if ($show_create_sapdf=="yes"){

}


}else{ 


$f1=new form('return validateFormOnSubmit(this)','process_form_jewelry.php','POST','pjitems','400',$cfg_theme,$lang);
if ($cfg_enableimageupload_jewelry == "yes" and $cfg_imagesnapmethod == "pc"){ 
$f1->createInputField("$lang->itemimagelab: ",'file','item_image',"$item_image_value",'30','160'); 
}


} 


if ($jewelrybuytype_value == "ScrapGold"){
$addtoinventory_checked = 'N';

echo "
		<input type='hidden' name='transaction_id' value='$transaction_id_value'>
		<input type='hidden' name='item_number' value='$item_number_value'>
		<input type='hidden' name='item_name' value='$item_name_value'>
		<input type='hidden' name='tax_percent' value='$tax_percent_value'>
		<input type='hidden' name='system_gen_itemnum' value='$system_assigned_itemnum'>
		<input type='hidden' name='onlyloadimage' value='$onlyloadimage_value'>
		<input type='hidden' name='itemtblrowid' value='$itemtblrowid_value'>
		<input type='hidden' name='inventorytblrowid' value='$shareinventorytbl_rowid_value'>
		<input type='hidden' name='unit_price' value='$unit_price_value'>
		<input type='hidden' name='quantity' value='$quantity_value'>
		<input type='hidden' name='reorder_level' value='$reorder_level_value'>
		<input type='hidden' name='addtoinventory' value='$addtoinventory_checked'>
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
}else{
$addtoinventory_checked = 'Y';

echo "
		<input type='hidden' name='transaction_id' value='$transaction_id_value'>
		<input type='hidden' name='item_number' value='$item_number_value'>
		<input type='hidden' name='item_name' value='$item_name_value'>
		<input type='hidden' name='tax_percent' value='$tax_percent_value'>
		<input type='hidden' name='system_gen_itemnum' value='$system_assigned_itemnum'>
		<input type='hidden' name='onlyloadimage' value='$onlyloadimage_value'>
		<input type='hidden' name='itemtblrowid' value='$itemtblrowid_value'>
		<input type='hidden' name='inventorytblrowid' value='$shareinventorytbl_rowid_value'>
		<input type='hidden' name='addtoinventory' value='$addtoinventory_checked'>
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";

}
		
		
$f1->endForm();


$dbf->closeDBlink();



if ($onlyloadimage != "yes"){


if (($cfg_enable_CSAlink=="yes") and (isset($_GET['working_on_id'])) and (isset($_GET[active_trans_id]))){ 
    if ($cfg_store_state=="wi"){
        echo "<a href=\"create_saleagreement_WI.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$transaction_id_value\">Done create sale agreement</a> \n";
    }else{
      	echo "<a href=\"create_saleagreement_IL.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$transaction_id_value\">Done create sale agreement</a> \n";
    }

echo " | ";
echo "<a href=\"form_items.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Add Items</a>";
echo " | ";
   if ($cfg_dvdlookup_version=="2"){ 
      echo "<a href=\"form_items_dvd_v2.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd_v2.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
  }else if ($cfg_dvdlookup_version=="3"){ 
      echo "<a href=\"form_items_dvd_v3.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd_v3.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
     
  }else{
   	  echo "<a href=\"form_items_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
   } 
}else{

echo "<a href=\"form_items.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$_GET[active_trans_id]\">Buy/Add Items</a>";
echo " | ";

   if ($cfg_dvdlookup_version=="2"){ 
      echo "<a href=\"form_items_dvd_v2.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd_v2.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
  }else if ($cfg_dvdlookup_version=="3"){ 
      echo "<a href=\"form_items_dvd_v3.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd_v3.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
     
  }else{
   	  echo "<a href=\"form_items_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Movies</a>";
      echo " | ";
      echo "<a href=\"form_items_videogame_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add Games</a>";
   } 
}
} 
?>


<table border="0" cellpadding="1" cellspacing="1" width="70%">
<tr>
<TD>
<?php if(isset($_GET['id'])){ ?>
<p class=MsoNormal align=center style='text-align:center'><span style='color:blue'><o:p>&nbsp;</o:p></span></p>
<center><p class=MsoNormal><FONT SIZE="1" COLOR="black">Item Picture on file</font></p></center>
<center><a href="<?php echo $curitemimage ?>" rel="lightbox" id="Item001"><img src="<?php echo $curitemimage ?>" width="100" height="40" alt="Item Picture" /a></center>
<center><p class=MsoNormal><FONT SIZE="1" COLOR="blue"><?php echo "$item_image_value"?></font></p></center>
<?php } ?>
</TD>

<TD>
<?php if ($show_supplierLicPic == "Yes"){ ?> 
<p class=MsoNormal align=center style='text-align:center'><span style='color:blue'><o:p>&nbsp;</o:p></span></p>
<center><p class=MsoNormal><FONT SIZE="1" COLOR="black">Lic Picture on file</font></p></center>
<center><a href="<?php echo $supplier_imagepath ?>" rel="lightbox" id="SupplierLicPicInDB001"><img src="<?php echo $supplier_imagepath ?>" width="100" height="40" alt="Supplier Lic Picture on file" /></center>

<?php } ?>
</TD>



<br> <br> 
<b><font color='blue'>Please Note<br>
<b><font color='blue'>***********<br> 
</font></b><b><font color='green'>1- JewelryBuy_Type = ScarpGold Will NOT add item to inventory for sale. <br> 
</font></b><b><font color='green'>2- JewelryBuy_Type = ReSaleJewelry Will add item to inventory for sale. <br> 
</font></b><b><font color='green'><br> 
</font></b><b><font color='green'><br> </font></b>





</body>

<?php if ($show_supplierLicPic == "Yes"){ ?>
<script language="javascript" defer type="text/javascript">

setTimeout("myLightbox.start($('SupplierLicPicInDB001'))", 1000);
<?php } ?>
</script>

</html>
	