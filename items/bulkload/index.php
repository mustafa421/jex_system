<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Inventory Bulk Item Load</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="css/default.css"/>
		<script type="text/javascript" src="js/script.js"></script> 
    
	
	
<script>
function myFunction(val) {
   
	self.location='index.php?valcat=' + val;
}
</script>	
	

<script type="text/javascript">	
	function validateForm() {
		 
	var illegalChars= /[\<\>\,\;\:\\\/\"\[\]]/	
		
		
		  
   

  
    
		
		
		
    var brandname = document.forms["myForm"]["brandname"].value;
	var itemmodel = document.forms["myForm"]["itemmodel"].value;
	var description = document.forms["myForm"]["description"].value;
	var itemsize = document.forms["myForm"]["itemsize"].value;
	var itemcolor = document.forms["myForm"]["itemcolor"].value;
    var vendorname = document.forms["myForm"]["vendorname"].value;
	var buyprice = document.forms["myForm"]["buyprice"].value;
	var saleprice = document.forms["myForm"]["saleprice"].value;
	
	 
	 
    if (illegalChars.test(brandname)) {
        document.forms["myForm"]["brandname"].style.background = 'Yellow';
	    return false;
	}else{
		document.forms["myForm"]["brandname"].style.background = 'white';
    }
	
	if (illegalChars.test(itemmodel)) {
        document.forms["myForm"]["itemmodel"].style.background = 'Yellow';
	    return false;
	}else{
		document.forms["myForm"]["itemmodel"].style.background = 'white';
    }
	
    if (illegalChars.test(description)) {
         document.forms["myForm"]["description"].style.background = 'Yellow';
	     return false;
	}else{
		 document.forms["myForm"]["description"].style.background = 'white';
    }
	
	
    if (illegalChars.test(itemsize)) {
         document.forms["myForm"]["itemsize"].style.background = 'Yellow';
	     return false;
	}else{
		 document.forms["myForm"]["itemsize"].style.background = 'white';
    }
	
    if (illegalChars.test(itemcolor)) {
         document.forms["myForm"]["itemcolor"].style.background = 'Yellow';
	     return false;
	}else{
		 document.forms["myForm"]["itemcolor"].style.background = 'white';
    }	
	
	
    if (illegalChars.test(vendorname)) {
         document.forms["myForm"]["vendorname"].style.background = 'Yellow';
	     return false;
	}else{
		 document.forms["myForm"]["vendorname"].style.background = 'white';
    }	
	
    if (illegalChars.test(buyprice)) {
         document.forms["myForm"]["buyprice"].style.background = 'Yellow';
	     return false;
	}else{
		 document.forms["myForm"]["buyprice"].style.background = 'white';
    }	
		
	
    if (illegalChars.test(saleprice)) {
         document.forms["myForm"]["saleprice"].style.background = 'Yellow';
	     return false;
	}else{
		 document.forms["myForm"]["saleprice"].style.background = 'white';
    }	

	
}
</script>



	
	</head>
    <body> 


<?php



include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/db_functions.php");
include ("../../classes/security_functions.php");
include ("../../classes/form.php");
include ("../../classes/display.php");





$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);


if(isset($_GET['catid'])){ 
$selcat=$_GET['catid'];

}








if(!$sec->isLoggedIn())
{
		header ("location: ../../login.php");
		exit();
}


if(isset($_GET['valcat'])){ 
$selcat=$_GET['valcat'];

}



$articletable=$cfg_tableprefix.'articles';
$categorytable=$cfg_tableprefix.'categories';
$suppliertable=$cfg_tableprefix.'suppliers';



?>


	
        <form name="myForm" action="process.php"  onsubmit="return validateForm()" class="register" method="POST" enctype=multipart/form-data>
            <h1>Add to Inventory - Purchase Order Items</h1>
			<fieldset class="row1">
                <legend>Common fields for all items being loaded</legend>
			

<p>				 
					
<?php





if(isset($_GET['valcat'])){ 
$catname=$_GET['valcat'];





$categorytable = "$cfg_tableprefix".'categories';
$catid=$dbf->fieldtoid("$categorytable",'category',"$catname");

}

$resultcat2 = mysql_query("SELECT * FROM $categorytable ",$dbf->conn);



?>
<label>Categories * 
                    </label>
<?php
echo "<select name=\"Mycat\" onchange=\"myFunction(this.value)\" tabindex=1>";



  if ($catname <> ""){ 
	 echo "<option value='" . $catid . "'>" . $catname . "</option>";
 }
while ($row = mysql_fetch_array($resultcat2)){
echo "<option value='" . $row['category'] . "'>" . $row['category'] . "</option>";
}
echo "</select>";

?>	



			 
					
<?php
$categorytable = "$cfg_tableprefix".'categories';
$articletable = "$cfg_tableprefix".'articles';
$catname=$_GET['valcat'];


$catid=$dbf->fieldtoid("$categorytable",'category',"$catname");

$wherefield = 'activate_article = '."'".'Y'. "'" . 'and (category_id =' ." '". "$catid"."'".' or category_id =' ." '". " ". "')"; 

$resultart1 = mysql_query("SELECT * FROM $articletable where $wherefield  ",$dbf->conn);

?>
<label>Articles * 
                    </label>
					
<?php

echo "<select name=\"Myart\" type=\"text\" tabindex=2>";
while ($row = mysql_fetch_array($resultart1)){



echo "<option value='" . $row['article'] . "'>" . $row['article'] . "</option>";
}
echo "</select>";

?>	





</p>
			<p>
                    <label>Brand Name: 
                    </label>
                    <input name="brandname" type="text" tabindex=3 />
                    
					<label>Model:
                    </label>
                    <input name="itemmodel" type="text" tabindex=4/>
					
					<label>Description:
                    </label>
                    <input name="description" type="text" tabindex=5/>
                    
					
					
                </p>
                <p>
					<label>Size:
                    </label>
                    <input name="itemsize"  type="text" tabindex=6/>
					
					<label>color:
                    </label>
                    <input name="itemcolor"  type="text" tabindex=7/>
					
					
					<label>Vendor Name:
                    </label>
                    <input name="vendorname"  type="text" tabindex=8/>
                 
					
					
          </p>
                <p>
                    <label>Buy Price:
                    </label>
                    <input name="buyprice"  type="text" tabindex=9/>
                  
					<label>Sale Price:
                    </label>
                    <input name="saleprice"  type="text" tabindex=10/>
                   
					<label for="report_item">Report Item *</label>
							<select id="report_item" name="report_item" required="required" tabindex=11/>
								<option>N</option>
								<option>Y</option>
							</select>
					

				  
                </p>
				<div class="clear"></div>
            </fieldset>
			

			
            <fieldset class="row2">
				<legend>Following fields are unique to each Item</legend>
				<p> 
					<input type="button" value="Add Item Row" onClick="addRow('dataTable')" /> 
 
					<input type="button" value="Remove Item Row" onClick="deleteRow('dataTable')"  /> 
					<p>(Check checkbox next to each item and then click "Remove Item Row" to Delete.)</p>

				</p>
               <table id="dataTable" class="form" border="1">
                  <tbody>
                    <tr>
                      <p>
						<td><input type="checkbox"  name="chk[]"  tabindex=12/></td>
						<td>
							<label>Serial#</label>
							<input type="text" name="BX_SERIALNUM[]" tabindex=13>
						 </td>
						
						<td>
							<label>IMEI1</label>
							<input type="text"  name="BX_IMEI1[]" tabindex=14>
						 </td>
						 
						 <td>
							<label>IMEI2</label>
							<input type="text"  name="BX_IMEI2[]" tabindex=15>
						 </td>

						<td>
						 <label>Description
						</label>
						<input type="text" name="itemdescription[]" tabindex=16>
						</td>
						 
						 
							</p>
                    </tr>
                    </tbody>
                </table>
				<div class="clear"></div>
            </fieldset>

	
	<input class="submit" type="submit" name="Submit" value="Submit" tabindex=18 />
	<input type="checkbox"  id="chk2" name="chk2" required="required" />Check If Ready to Submit *		







			

			
			
			<div class="clear"></div>
			
			 <legend>Further Information</legend>
				<p>This form allow you to add items from your purchase order to inventory for sale.</p>
				<p>	1>All items added as supplier Jewelry and Electronics.</p>
				<p>	2>Top section of this form has common fields for all items being added to inventory.</p>
                <p>	3>The second section has fields unique to each item being added to inventory.</p>
				<p>	4>Item image load is not supported during addition of items using this panel at this time.</p>
				<p>	5>All items added using this form will not be reported to Police (default is N) You may change it.</p>
				<p> 6>Vendor Name entered is loaded to Supplier_Catalogue field on item table (field is only 60 Char long).</p>
				<p> 7>Description is added to description field. Item description has priority.</p>
				<p> 8>To print Barcodes go to Item Transactions panel and click Barcode link next to any item in this transaction.</p>

        </form>
		
		

               
		
		
    </body>

</html>




