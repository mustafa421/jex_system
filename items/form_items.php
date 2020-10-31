<?php session_start(); ?>

<html>
<head>
<script type="text/javascript">  </script>
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
	
<script type="text/javascript">  </script>		
	
	
	
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


	
<SCRIPT language=JavaScript>

function reload(form){


var myaction = "<?php echo($action);?>";
var imagesnapmethod = "<?php echo($cfg_imagesnapmethod);?>";
var enableimageupload_items = "<?php echo($cfg_enableimageupload_items);?>";
var myaction=form.action.value; 
var valtranfrompanel=form.transaction_from_panel.value; 
if (myaction == "update") {
var valcat=form.category_id.options[form.category_id.options.selectedIndex].value;
var valaction = 'update';
var valid=form.id.value; 







if (valtranfrompanel == "jewelry"){
var valjewelrybuytype=form.jewelrybuy_type.options[form.jewelrybuy_type.options.selectedIndex].value;





}


}else{
var valsupplierid=form.supplier_id.value; 
var valcat=form.category_id.options[form.category_id.options.selectedIndex].value; 
var valarticleid=form.article_id.options[form.article_id.options.selectedIndex].value;
var valbrandname=form.brandname.value;
var valserialnumber=form.serialnumber.value;
var valimei1=form.imei1.value;
var valimei2=form.imei2.value;
var valitemsize=form.itemsize.value;
var valitemcolor=form.itemcolor.value;
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
var valunitprice=form.unit_price.value;
var valsuppliercatalognumber=form.supplier_catalogue_number.value;
var valquantity=form.quantity.value;
var valreorderlevel=form.reorder_level.value;
if ((enableimageupload_items == "yes") && (imagesnapmethod == "pc")) {
var valitemimage=form.item_image.value;
}
var valtranid=form.transaction_id.value; 
var valitemnumber=form.item_number.value; 
var valitemname=form.item_name.value; 
var valtaxpercent=form.tax_percent.value; 
var valsystemgenitemnum=form.system_gen_itemnum.value; 
var valinventorytblrowid=form.inventorytblrowid.value; 
var valitemtranstblrowid=form.itemtranstblrowid.value; 
var valaction=form.action.value; 
var valid=form.id.value; 
var valqtyremovedpd=form.qtyremovedpd.value; 
var valqtyremovedjex=form.qtyremovedjex.value; 
var valupdatelinkfrompanel=form.updatelinkfrompanel.value; 
}

 
  




if (myaction == "update") {

self.location='form_items.php?catid=' + valcat
+'&action=' + valaction
+'&valjewelrybuytype=' + valjewelrybuytype
+'&id=' + valid
;
}else{

self.location='form_items.php?catid=' + valcat 
+'&valsupplierid=' + valsupplierid
+'&valarticleid=' + valarticleid
+'&valbrandname=' + valbrandname
+'&valserialnumber=' + valserialnumber
+'&valimei1=' + valimei1
+'&valimei2=' + valimei2
+'&valitemsize=' + valitemsize
+'&valitemcolor=' + valitemcolor
+'&valitemmodel=' + valitemmodel
+'&valdescription=' + valdescription
+'&valtotalowner=' + valtotalowner
+'&valitemfound=' + valitemfound
+'&valfounddesc=' + valfounddesc
+'&valbuyprice=' + valbuyprice
+'&valunitprice=' + valunitprice
+'&valsuppliercatalognumber=' + valsuppliercatalognumber
+'&valquantity=' + valquantity
+'&valreorderlevel=' + valreorderlevel
+'&valtranid=' + valtranid
+'&valitemnumber=' + valitemnumber
+'&valitemname=' + valitemname
+'&valtaxpercent=' + valtaxpercent
+'&valsystemgenitemnum=' + valsystemgenitemnum
+'&valinventorytblrowid=' + valinventorytblrowid
+'&valitemtranstblrowid=' + valitemtranstblrowid
+'&valaction=' + valaction
+'&valid=' + valid
+'&valqtyremovedpd=' + valqtyremovedpd
+'&valqtyremovedjex=' + valqtyremovedjex
+'&valupdatelinkfrompanel=' + valupdatelinkfrompanel
if ((enableimageupload_items == "yes") && (imagesnapmethod == "pc")) {
+'&valitemimage=' + valitemimage
}
;
}


}
</script>	
	
<script type="text/javascript">

function validateFormOnSubmit(theForm) {
var reason = "";

 
 
 reason += validateCategoryid(theForm.category_id);
 reason += validateArticleid(theForm.article_id);
 reason += validatedescription(theForm.description);
 reason += validatesuppliername(theForm.supplier_id);

 var valaction=theForm.action.value; 
 if (valaction == "insert") {
 reason += validatefounditemckbox(theForm.itemfound,theForm.founddesc);
 }
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
    	 }else if ((fld.value.length < 2) || (fld.value.length > 250)) {
              fld.style.background = 'Yellow';
              error = "The Description is the wrong length. Max 250 \n";
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
        error = "You didn't enter Supplier Name. Please select the supplier name from the list\n";
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
include ("../classes/cryptastic.php");

























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


$catid=$_GET['catid'];






		
		
		if ($_GET['csa'] == 'yes'){$saleagreement_checked = 'checked';};
		





if(isset($_GET['catid']))
{

   @$catid=$_GET['catid']; 
   if(strlen($cat) > 0 and !is_numeric($cat)){ 
         echo "Data Error";
          exit;
    }
 
        $supplier_value=$_GET['valsupplierid'];
        $category_id_value=$catid;
		
		$brandname_value = $_GET['valbrandname'];
		$serialnumber_value = $_GET['valserialnumber'];
		$imei1_value = $_GET['valimei1'];
		$imei2_value = $_GET['valimei2'];
		$itemsize_value = $_GET['valitemsize'];
		$itemcolor_value = $_GET['valitemcolor'];
		$itemmodel_value = $_GET['valitemmodel'];
		$description_value = $_GET['valdescription'];
		
		$totalowner_checked=$_GET['valtotalowner'];
		$itemfound_checked=$_GET['valitemfound'];
		$founddesc_value=$_GET['valfounddesc'];
		
		$jewelrybuytype_value=$_GET['valjewelrybuytype'];
		
		
		$buy_price_value=$_GET['valbuyprice'];
		$unit_price_value=$_GET['valunitprice'];
		$supplier_catalogue_number_value=$_GET['valsuppliercatalognumber'];
		$quantity_value=$_GET['valquantity'];
		$reorder_level_value=$_GET['valreorderlevel'];
		$item_image_value=$_GET['valitemimage']; 
		$transaction_id_value = $_GET['valtranid']; 
		$item_number_value=$_GET['valitemnumber'];
		$item_name_value=$_GET['valitemname'];
		$tax_percent_value=$_GET['valtaxpercent'];
		
		$shareinventorytbl_rowid_value = $_GET['valinventorytblrowid'];
		$itemtranstbl_rowid_value = $_GET['valitemtranstblrowid'];
		
        $id=$_GET['valid'];
		$qtyremovedpd_value=$_GET['valqtyremovedpd'];
		$qtyremovedjex_value=$_GET['valqtyremovedjex'];
		$updatelinkfrompanel_value=$_GET['valupdatelinkfrompanel'];
		$action=$_GET['valaction'];
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		


		
	
	  
	  
}




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
		$article_id_value = $row['article_id'];
		$shareinventorytbl_rowid_value = $row['share_inventorytbl_rowid'];
		$itemtranstbl_rowid_value = $row['itemtranstbl_rowid'];
		$transaction_id_value = $row['item_number']; 
		$cat_id_fromtable='yes';
		$article_id_fromtable='yes';
		$kindsize_value = $row['kindsize'];
		$numstone_value = $row['numstone'];
		$serialnumber_value = $row['serialnumber'];
		$imei1_value = $row['imei1'];
		$imei2_value = $row['imei2'];
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
		$itementerdate=$row['date'];
		$item_image_value=$row['item_image']; 
		$id=$row['id'];
		
if(isset($_GET['updatelinkfrompanel'])){
$updatelinkfrompanel_value=$_GET['updatelinkfrompanel'];
}





		if (($row['removedbypd'] == "PD") && ($updatelinkfrompanel_value=="pdpanel")){
		$removedbypd_checked = 'checked';
		$removecomment_value=$row['removecommentpd'];
		
		}
		
		if (($row['removedbyjex'] == "JEX") && ($updatelinkfrompanel_value=="jexpanel")){
		$removedbyjex_checked = 'checked';
		$removecomment_value=$row['removecommentjex'];
		
		}

		$qtyremovedpd_value=$row['qtyremovedpd'];
		$qtyremovedjex_value=$row['qtyremovedjex'];
		
		if(isset($_GET['catid']))
{
$catid=$_GET['catid'];
}else{		
		$catid=$category_id_value;
}		
		

 
        $transtablename = "$cfg_tableprefix".'item_transactions';
		$transresult = mysql_query("SELECT item_gender,material_type,scrap_or_resale,transaction_from_panel,addtoinventory_scrapgold FROM $transtablename WHERE id=\"$itemtranstbl_rowid_value\"",$dbf->conn);
		$transrow = mysql_fetch_assoc($transresult);

       $transaction_from_panel = $transrow['transaction_from_panel'];
	   $itemgender_value = $transrow['item_gender'];
	   $materialtype_value = $transrow['material_type'];
	   $add_jewelry_toinventory_value = $transrow['addtoinventory_scrapgold'];
	  	   
	   $jewelrybuytype_value = $transrow['scrap_or_resale'];
		



		
		
		
		
		
		
		
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
	  
	  $description_value = str_replace(":", "-", "$description_value");
	  
	  
      $transaction_number=$cfg_store_code.$row['id'];
      if ($transaction_number != $row['item_number']){
	   
	           $show_create_sapdf='no';
	     }
	}

}
else
{
	
	$display->displayTitle("$lang->addItemtitle");

   
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
	                  
					  if ($cfg_data_outside_storedir == "yes"){
                          $supplierIMGDir1 = substr($cfg_data_supplierIMGpathdir, 3); 
	                      $supplierIMGDir = $cfg_data_supplierIMGpathdir; 
						  $licfilename=$row4['imagelic'];
						  $supplier_imagepath= $supplierIMGDir.$row4['imagelic'];
	                      
                      }else{
	                      $supplier_imagepath= 'suppliers/images/'.$row4['imagelic'];
						  $licfilename=$row4['imagelic'];
	        
                     }
					  
					  
					  
					  $supplier4=$row4['supplier'];
	                  $supplier_value = $row4['id']."-".$row4['supplier']; 
	                  
					  
					  
	  
                              
                              
                               $cryptastic = new cryptastic;

                             $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	                                 die("Failed to generate secret key.");
									 
	                     if ($cfg_imageZipORnozip == "nozip"){	
                              $msg 			= file_get_contents($supplierIMGDir.$licfilename);
	                          $decrypted = $cryptastic->decrypt($msg, $key) or
			         	                 die("Failed to complete decryption Lic image");

                                $dencryptedFile 	= "$cfg_data_csapdf_pathdir/temp/$licfilename";
 
	                             $fHandle		= fopen($dencryptedFile, 'w+');
	                             fwrite($fHandle, $decrypted);
	                             fclose($fHandle);
                                
	                     }else{
                          
							   $zippedimg1=$supplierIMGDir.$licfilename.'.zip';

							   $zippedimg=$supplierIMGDir.$licfilename.'.zip';
							   $zippedimg=substr($zippedimg,3);             
		                  
						       $unzippedimg=$cfg_data_storePDFDataTempDir;
	                           exec("unzip -jP $key $zippedimg -d $unzippedimg", $output1);
		                       $dencryptedFile=$cfg_data_storePDFDataTempDir.$licfilename; 
                               $supplier_imagepath=$dencryptedFile;
                              }
							
	                    
					  
					  
					  
					  
					  
					  
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
     
	if(isset($_GET['catid'])) {
	$jewelrybuytype_value=$_GET['valjewelrybuytype'];
    
	}
	
	







if($action!="update"){

if (($cfg_enable_CSAlink=="yes") and (isset($_GET['working_on_id'])) and (isset($_GET[active_trans_id]))){ 

   if ($cfg_store_state=="wi"){
       echo "<a href=\"create_saleagreement_WI.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$transaction_id_value\">Done create sale agreement</a> \n";
   }else{
       echo "<a href=\"create_saleagreement_IL.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$transaction_id_value\">Done create sale agreement</a> \n";
   }
echo " | ";
echo "<a href=\"form_buy_jewelry.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy Jewelry</a>";
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
    echo "<a href=\"form_items_videogame_dvd.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy/Add video Games</a>";
  }	
}else{

echo "<a href=\"form_buy_jewelry.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy Jewelry</a>";
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









if ($cfg_processForm_version=="1"){
$f1=new form('return validateFormOnSubmit(this)','process_form_items_v1.php','POST','items','400',$cfg_theme,$lang);
}else if ($cfg_processForm_version=="2"){
$f1=new form('return validateFormOnSubmit(this)','process_form_items_v2.php','POST','items','400',$cfg_theme,$lang);
}



$suppliertable = "$cfg_tableprefix".'suppliers';

$supplier_option_titles=$dbf->getAllElements("$suppliertable",'supplier','supplier');
$supplier_option_titles[0] = $dbf->idToField("$suppliertable",'supplier',"$supplier_id_value");
$supplier_option_values=$dbf->getAllElements("$suppliertable",'id','supplier');
$supplier_option_values[0] = $supplier_id_value;


$onkeyup = "onkeyup=".'"'."ajax_showOptions(this,'getCountriesByLetters',event)".'"';
$f1->createInputField("<b>$lang->supplier:</b> ",'text','supplier_id',"$supplier_value",'24','160',$onkeyup);



$categorytable = "$cfg_tableprefix".'categories';

$wherefield = ' showon_itempanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
$resultcat = mysql_query("SELECT * FROM $categorytable WHERE $wherefield ",$dbf->conn);
$numcat_rows = mysql_num_rows($resultcat);

if ($numcat_rows < 1) 
{


if($transaction_from_panel=="jewelry"){
$wherefield = ' activate_category = '."'".'Y'. "'" . ' and category <> '."'".'DVD'. "'" . ' and category = '."'".'Jewelry'. "'" . ' or category = '."'".'Watch'. "'" . ' and category <> '."'".' '. "'";


}else{

$wherefield = ' activate_category = '."'".'Y'. "'" . ' and category <> '."'".'DVD'. "'". ' and category <> '."'".'Jewelry'. "'" . ' and category <> '."'".'Watch'. "'";
}



$category_option_titles=$dbf->getAllElementswhere("$categorytable",'category',"$wherefield",'category');
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values=$dbf->getAllElementswhere("$categorytable",'id',"$wherefield",'category');
$category_option_values[0] = $category_id_value;

$category_option_titles[0] = " ";
$category_option_values[0] = 'blank';



if(isset($_GET['catid'])){
$category_id_value=$catid;
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}


if ($cat_id_fromtable=="yes"){
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}







$onchange="onchange=".'"'."reload(this.form)".'"';

$f1->createSelectField("<b>$lang->category:</b>",'category_id',$category_option_values,$category_option_titles,'160',$onchange);






if($transaction_from_panel=="jewelry"){
if (($jewelrybuytype_value == "null" or $jewelrybuytype_value == " " or $jewelrybuytype_value == "") and $Itemrow_id_value == 0){
    
     $jewelrybuytype_value = 'scrap';
     $jewelrybuytype_option_titles[0] = "ScrapGold";
     $jewelrybuytype_option_values[0] = "$jewelrybuytype_value";
   
   
   
   
}else{
    if ($jewelrybuytype_value == "scrap") { $jewelrybuytypetitle_value = 'ScrapGold';}
	if ($jewelrybuytype_value == "resale") { $jewelrybuytypetitle_value = 'ReSaleJewelry';}
   $jewelrybuytype_option_titles[0] = "$jewelrybuytypetitle_value";
   $jewelrybuytype_option_values[0] = "$jewelrybuytype_value";
}  
$jewelrybuytype_option_titles[1] = "ScrapGold";
$jewelrybuytype_option_values[1] = "scrap";
$jewelrybuytype_option_titles[2] = "ReSaleJewelry";
$jewelrybuytype_option_values[2] = "resale";

$onchange="onchange=".'"'."reload(this.form)".'"';
if(($transaction_from_panel=="jewelry") and ($add_jewelry_toinventory_value=="Y")){
	
	
     $jewelrybuytype_option_titles[0] = "unmodifiable";
     $jewelrybuytype_option_values[0] = " ";
	$jewelrybuytype_option_titles[1] = " ";
	$jewelrybuytype_option_values[1] = " ";
	$jewelrybuytype_option_titles[2] = " ";
	$jewelrybuytype_option_values[2] = " ";
	$f1->createSelectField("<b>JewelryBuy_Type:</b>",'jewelrybuy_type',$jewelrybuytype_option_values,$jewelrybuytype_option_titles,'160',$onchange);

}else{	
$f1->createSelectField("<b>JewelryBuy_Type:</b>",'jewelrybuy_type',$jewelrybuytype_option_values,$jewelrybuytype_option_titles,'160',$onchange);
}
}






$catJewelryID = $dbf->fieldToid("$categorytable",'category',"Jewelry");
$catWatchID =   $dbf->fieldToid("$categorytable",'category',"Watch");



$articletable = "$cfg_tableprefix".'articles';





  

  



$wherefield = 'activate_article = '."'".'Y'. "'" . 'and (category_id =' ." '". "$catid"."'".' or category_id =' ." '". " ". "')"; 




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


$f1->createSelectField("<b>Article:</b>",'article_id',$article_option_values,$article_option_titles,'160');

}else{ 

if($transaction_from_panel=="jewelry"){
$wherefield = ' showon_jewelrypanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
}else{

$wherefield = ' showon_itempanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
}

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


if(isset($_GET['catid'])){
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




if($transaction_from_panel=="jewelry"){
if (($jewelrybuytype_value == "null" or $jewelrybuytype_value == " " or $jewelrybuytype_value == "") and $Itemrow_id_value == 0){
    
     $jewelrybuytype_value = 'scrap';
     $jewelrybuytype_option_titles[0] = "ScrapGold";
     $jewelrybuytype_option_values[0] = "$jewelrybuytype_value";
   
   
   
   
}else{
    if ($jewelrybuytype_value == "scrap") { $jewelrybuytypetitle_value = 'ScrapGold';}
	if ($jewelrybuytype_value == "resale") { $jewelrybuytypetitle_value = 'ReSaleJewelry';}
   $jewelrybuytype_option_titles[0] = "$jewelrybuytypetitle_value";
   $jewelrybuytype_option_values[0] = "$jewelrybuytype_value";
}  
$jewelrybuytype_option_titles[1] = "ScrapGold";
$jewelrybuytype_option_values[1] = "scrap";
$jewelrybuytype_option_titles[2] = "ReSaleJewelry";
$jewelrybuytype_option_values[2] = "resale";

$onchange="onchange=".'"'."reload(this.form)".'"';
if(($transaction_from_panel=="jewelry") and ($add_jewelry_toinventory_value=="Y")){
	
	
     $jewelrybuytype_option_titles[0] = "unmodifiable";
     $jewelrybuytype_option_values[0] = " ";
	$jewelrybuytype_option_titles[1] = " ";
	$jewelrybuytype_option_values[1] = " ";
	$jewelrybuytype_option_titles[2] = " ";
	$jewelrybuytype_option_values[2] = " ";
	$f1->createSelectField("<b>JewelryBuy_Type:</b>",'jewelrybuy_type',$jewelrybuytype_option_values,$jewelrybuytype_option_titles,'160',$onchange);

}else{	
$f1->createSelectField("<b>JewelryBuy_Type:</b>",'jewelrybuy_type',$jewelrybuytype_option_values,$jewelrybuytype_option_titles,'160',$onchange);
}
}





$articletable = "$cfg_tableprefix".'articles a,'."$cfg_tableprefix".'categories b ';

if($transaction_from_panel=="jewelry"){
	$wherefield = ' a.category_id = ' ." '". "$catid"."'".'and  a.category_id = b.id and b.showon_jewelrypanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'";
}else{
	
    $wherefield = ' a.category_id = ' ." '". "$catid"."'".'and  a.category_id = b.id and b.showon_itempanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'";

	}



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

if($transaction_from_panel=="jewelry"){

if ($itemgender_value == "null" or $itemgender_value == " " or $itemgender_value == ""){
   $itemgender1_option_titles[0] = "";
   $itemgender1_option_values[0] = 'null';
}else{
    if ($itemgender_value == "MEN") { $itemgendertitle_value = "MEN'S";}
	if ($itemgender_value == "LADIE") { $itemgendertitle_value = "LADIE'S";}
	if ($itemgender_value == "NOGENDER") { $itemgendertitle_value = "NOGENDER";}
	$itemgender1_option_titles[0] = "$itemgendertitle_value";
    $itemgender1_option_values[0] = "$itemgender_value";
}   

$itemgender1_option_titles[1] = "LADIE'S";
$itemgender1_option_values[1] = "LADIE'S";
$itemgender1_option_titles[2] = "MEN'S";
$itemgender1_option_values[2] = "MEN'S";
$itemgender1_option_titles[3] = "NOGENDER";
$itemgender1_option_values[3] = "NOGENDER";


$f1->createSelectField("Item Gender: ",'item_gender',$itemgender1_option_values,$itemgender1_option_titles,'160');





if ($materialtype_value == "null" or $materialtype_value == " " or $materialtype_value == ""){
   $materialtype1_option_titles[0] = "";
   $materialtype1_option_values[0] = 'null';
}else{
   if ($materialtype_value == "YELLOW GOLD") { $materialtypetitle_value = "YELLOW GOLD";}
   if ($materialtype_value == "WHITE GOLD") { $materialtypetitle_value = "WHITE GOLD";}
   if ($materialtype_value == "SILVER") { $materialtypetitle_value = "SILVER";}
   if ($materialtype_value == "OTHER") { $materialtypetitle_value = "OTHER";}
   $materialtype1_option_titles[0] = "$materialtypetitle_value";
   $materialtype1_option_values[0] = "$materialtype_value";
}


   
$materialtype1_option_titles[1] = "YELLOW GOLD";
$materialtype1_option_values[1] = "YELLOW GOLD";
$materialtype1_option_titles[2] = "WHITE GOLD";
$materialtype1_option_values[2] = "WHITE GOLD";
$materialtype1_option_titles[3] = "SILVER";
$materialtype1_option_values[3] = "SILVER";
$materialtype1_option_titles[4] = "OTHER";
$materialtype1_option_values[4] = "OTHER";   

$f1->createSelectField("Material-Type: ",'material_type',$materialtype1_option_values,$materialtype1_option_titles,'160');



$f1->createInputField("$lang->kindsize:",'text','kindsize',"$kindsize_value",'10','160');
$f1->createInputField("$lang->numstone:",'text','numstone',"$numstone_value",'10','160');

}

$f1->createInputField("$lang->brandname: ",'text','brandname',"$brandname_value",'24','160');





$f1->createInputField("$lang->serialnumber: ",'text','serialnumber',"$serialnumber_value",'24','160');
$f1->createInputField("IMEI1#: ",'text','imei1',"$imei1_value",'24','160');
$f1->createInputField("IMEI2#: ",'text','imei2',"$imei2_value",'24','160');

$f1->createInputField("$lang->itemsize: ",'text','itemsize',"$itemsize_value",'24','160');
$f1->createInputField("$lang->itemcolor: ",'text','itemcolor',"$itemcolor_value",'24','160');
$f1->createInputField("$lang->itemmodel: ",'text','itemmodel',"$itemmodel_value",'24','160');

$f1->createTextareaField("<b>$lang->detaildescription:</b> ",'description','2','40',"$description_value",'2');
if($action=="insert"){
$f1->createInputField("Total_Owner:",'checkbox','totalowner',"Y",'10','160',"$totalowner_checked");
$f1->createInputField("Item_Found:",'checkbox','itemfound',"Y",'10','160',"$itemfound_checked");
$f1->createTextareaField("Found_Desc ",'founddesc','2','40',"$founddesc_value",'2');
}

if($action=="update"){


if ($updatelinkfrompanel_value=="itempanel"){







$Notremoved_checked='checked';
$f1->createInputField("Not Removed:",'radio','itemremovedby',"Notrm",'24','150',"$Notremoved_checked");

$removedbypd_checked="";
$removedbyjex_checked="";
$f1->createInputField("RemovedBy PD:",'radio','itemremovedby',"PD",'24','150',"$removedbypd_checked");
$f1->createInputField("RemovedBy JEX:",'radio','itemremovedby',"JEX",'24','150',"$removedbyjex_checked");





$removecomment_value="";
$f1->createTextareaField("Remove Comment ",'removecomment','2','40',"$removecomment_value",'2');

}else{ 
	
	
	
	
	$f1->createInputField("RemovedBy PD:",'radio','itemremovedby',"PD",'24','150',"$removedbypd_checked");
	$f1->createInputField("RemovedBy JEX:",'radio','itemremovedby',"JEX",'24','150',"$removedbyjex_checked");


	if (($removedbypd_checked=="checked") or ($removedbyjex_checked=="checked")){
		$f1->createInputField("Relist RemovedItem:",'radio','itemremovedby',"relistremoveditem",'24','150',"$relistremoveditem_checked");
	}
	$f1->createTextareaField("Remove Comment ",'removecomment','2','40',"$removecomment_value",'2');

}

 }


$f1->createInputField("<b>$lang->buyingPrice:</b>",'text','buy_price',"$buy_price_value",'10','160');
$f1->createInputField("<b>$lang->sellingPrice ($lang->wo $lang->tax):</b>",'text','unit_price',"$unit_price_value",'10','160');

$f1->createInputField("$lang->supplierCatalogue: ",'text','supplier_catalogue_number',"$supplier_catalogue_number_value",'24','160');
$f1->createInputField("<b>$lang->quantityStock:</b> ",'text','quantity',"$quantity_value",'3','160');
$f1->createInputField("<b>$lang->reorderLevel:</b> ",'text','reorder_level',"$reorder_level_value",'3','160');

if (($cfg_enableimageupload_items=="yes") and ($cfg_imagesnapmethod=="pc")) {
   $f1->createInputField("$lang->itemimagelab: ",'file','item_image',"$item_image_value",'30','160');
}

if ($show_create_sapdf=="yes"){

}







echo "
		<input type='hidden' name='transaction_id' value='$transaction_id_value'>
		<input type='hidden' name='item_number' value='$item_number_value'>
		<input type='hidden' name='item_name' value='$item_name_value'>
		<input type='hidden' name='tax_percent' value='$tax_percent_value'>
		<input type='hidden' name='system_gen_itemnum' value='$system_assigned_itemnum'>
		<input type='hidden' name='inventorytblrowid' value='$shareinventorytbl_rowid_value'>
		<input type='hidden' name='itemtranstblrowid' value='$itemtranstbl_rowid_value'>
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>
		<input type='hidden' name='qtyremovedpd' value='$qtyremovedpd_value'>
		<input type='hidden' name='qtyremovedjex' value='$qtyremovedjex_value'>
		<input type='hidden' name='transaction_from_panel' value='$transaction_from_panel'>
		<input type='hidden' name='updatelinkfrompanel' value='$updatelinkfrompanel_value'>";
$f1->endForm();

$dbf->closeDBlink();









if($action!="update"){

if (($cfg_enable_CSAlink=="yes") and (isset($_GET['working_on_id'])) and (isset($_GET[active_trans_id]))){ 

   if ($cfg_store_state=="wi"){
       echo "<a href=\"create_saleagreement_WI.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$transaction_id_value\">Done create sale agreement</a> \n";
   }else{
       echo "<a href=\"create_saleagreement_IL.php?action=insert&working_on_id=$_GET[working_on_id]&active_trans_id=$transaction_id_value\">Done create sale agreement</a> \n";
   }
echo " | ";
echo "<a href=\"form_buy_jewelry.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy Jewelry</a>";
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

echo "<a href=\"form_buy_jewelry.php?action=insert&working_on_id=$supplier_id_value&active_trans_id=$transaction_id_value\">Buy Jewelry</a>";
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

$showitempic="no";  
?>


<table border="0" cellpadding="1" cellspacing="1" width="70%">
<tr>
<TD>
<?php if ($showitempic=="yes") {  ?>
<?php if(isset($_GET['id'])){ ?>
<p class=MsoNormal align=center style='text-align:center'><span style='color:blue'><o:p>&nbsp;</o:p></span></p>
<center><p class=MsoNormal><FONT SIZE="1" COLOR="black">Item Picture on file</font></p></center>
<center><a href="<?php echo $curitemimage ?>" rel="lightbox" id="Item001"><img src="<?php echo $curitemimage ?>" width="100" height="40" alt="Item Picture" /a></center>
<center><p class=MsoNormal><FONT SIZE="1" COLOR="blue"><?php echo "$item_image_value"?></font></p></center>
<?php } ?>
<?php }  ?>
</TD>

<TD>
<?php if ($show_supplierLicPic == "Yes"){ ?> 
<p class=MsoNormal align=center style='text-align:center'><span style='color:blue'><o:p>&nbsp;</o:p></span></p>
<center><p class=MsoNormal><FONT SIZE="1" COLOR="black">Lic Picture on file</font></p></center>
<center><a href="<?php echo $supplier_imagepath ?>" rel="lightbox" id="SupplierLicPicInDB001"><img src="<?php echo $supplier_imagepath ?>" width="100" height="40" alt="Supplier Lic Picture on file" /></center>

<?php } ?>
</TD>
</body>

<?php if ($show_supplierLicPic == "Yes"){ ?>
<script language="javascript" defer type="text/javascript">

setTimeout("myLightbox.start($('SupplierLicPicInDB001'))", 1000);
<?php } ?>
</script>

</html>
	