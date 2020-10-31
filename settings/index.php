<?php session_start();
include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");


function getFormFields() 
{
	global $cfg_company;
	global $cfg_address;
	global $cfg_phone;
	global $cfg_email;
	global $cfg_fax;
	global $cfg_website;
	global $cfg_other;
	global $cfg_default_tax_rate;
	global $cfg_currency_symbol;
	global $cfg_theme;
	global $cfg_language;
	global $cfg_numberForBarcode;
	global $cfg_store_code;
	global $cfg_startTransNum_with;
	global $cfg_configfile;  
    global $cfg_dvd_buyprice;
	global $cfg_dvd_sellprice;
	global $cfg_gamedvd_buyprice;
	global $cfg_gamedvd_sellprice;
	global $cfg_gamedvd_upc;
	global $cfg_itemimg_onpdf;
	global $cfg_supplierImage_onpdf;
	global $cfg_fingerprint_onpdf;
	global $cfg_create_check;
	global $cfg_SupplierFound_GoToUpdate;
	global $cfg_imagesnapmethod;
	global $cfg_enableimageupload_person;
	global $cfg_enableimageupload_items;
	global $cfg_enableimageupload_jewelry;
	global $cfg_enableimageupload_dvd;
	global $cfg_enableimageupload_gdvd;
	global $cfg_supplier_form_gender;
	global $cfg_supplier_form_race;
	global $cfg_supplier_form_height;
	global $cfg_supplier_form_weight;
	global $cfg_supplier_form_haircolor;
	global $cfg_supplier_form_eyecolor;
	global $cfg_makePhoneRequired;
	global $cfg_menulocation; 
	global $cfg_headerBGcolor;
	global $cfg_enable_CSAlink; 
	global $cfg_enable_SaleServices;
	global $cfg_SaleSrvPanel_enable_enter_srvname_field;
	global $cfg_SaleSrvPanel_Add_Entered_srvnameToArticleTbl;
	global $cfg_ShowTenderAmtBox_as2nd_Step;
	global $cfg_allow_salesclerk_tocreate_extractfile;
	global $cfg_allow_salesclerk_view_buyprice;
	global $cfg_enable_deleteSAPDF;
	global $cfg_enable_PopUpUpdateform;


	$formFields[0]=$cfg_company;
	$formFields[1]=$cfg_address;
	$formFields[2]=$cfg_phone;
	$formFields[3]=$cfg_email;
	$formFields[4]=$cfg_fax;
	$formFields[5]=$cfg_website;
	$formFields[6]=$cfg_other;
	$formFields[7]=$cfg_default_tax_rate;
	$formFields[8]=$cfg_currency_symbol;
	$formFields[9]=$cfg_numberForBarcode;
	$formFields[10]=$cfg_language;
	$formFields[11]=$cfg_store_code;
	$formFields[12]=$cfg_configfile;
	$formFields[13]=$cfg_dvd_buyprice;
	$formFields[14]=$cfg_dvd_sellprice;
	$formFields[15]=$cfg_gamedvd_buyprice;
	$formFields[16]=$cfg_gamedvd_sellprice;
	
     
	return $formFields;
}


function displayUpdatePage($defaultValuesAsArray) 
{

global $hDisplay;
global $cfg_theme;
global $cfg_startTransNum_with;
global $cfg_numberForBarcode;
global $cfg_itemimg_onpdf;
global $cfg_supplierImage_onpdf;
global $cfg_SupplierFound_GoToUpdate;
global $cfg_imagesnapmethod;
global $cfg_enableimageupload_person;
global $cfg_enableimageupload_items;
global $cfg_enableimageupload_jewelry;
global $cfg_enableimageupload_dvd;
global $cfg_enableimageupload_gdvd;
global $cfg_supplier_form_gender;
global $cfg_supplier_form_race;
global $cfg_supplier_form_height;
global $cfg_supplier_form_weight;
global $cfg_supplier_form_haircolor;
global $cfg_supplier_form_eyecolor;
global $cfg_makePhoneRequired; 
global $cfg_fingerprint_onpdf;
global $cfg_create_check;
global $cfg_menulocation; 
global $cfg_headerBGcolor;
global $cfg_enable_CSAlink;
global $cfg_enable_SaleServices;
global $cfg_SaleSrvPanel_enable_enter_srvname_field;
global $cfg_SaleSrvPanel_Add_Entered_srvnameToArticleTbl;
global $cfg_ShowTenderAmtBox_as2nd_Step;
global $cfg_allow_salesclerk_tocreate_extractfile;
global $cfg_allow_salesclerk_view_buyprice;
global $cfg_enable_deleteSAPDF;
global $cfg_enable_PopUpUpdateform;
global $cfg_gamedvd_upc;


$themeRowColor1=$hDisplay->rowcolor1;
$themeRowColor2=$hDisplay->rowcolor2;
$lang=new language();

?>
<?php
echo "
<html>
<head>
</head>
<body>

<table border=\"0\" width=\"550\">
  <tr>
    <td>
      <p align=\"left\"><img border=\"0\" src=\"../images/config.gif\" width=\"21\" height=\"28\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>$lang->config</b></font><br>
      <br>
      <font face=\"Verdana\" size=\"2\">$lang->configurationWelcomeMessage</font></p>
      <div align=\"center\">
        <center>
        <form action=\"index.php\" method=\"post\">
        <div align=\"left\">
        <table border=\"0\" width=\"349\" bgcolor=\"#FFFFFF\">
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->companyName</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyName\" size=\"29\" value=\"".$defaultValuesAsArray[0]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->address:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><textarea name=\"companyAddress\" rows=\"4\" cols=\"26\" style=\"border-style: solid; border-width: 1\">$defaultValuesAsArray[1]</textarea></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->phoneNumber:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyPhone\" size=\"29\" value=\"".$defaultValuesAsArray[2]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->email:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"companyEmail\" size=\"29\" value=\"".$defaultValuesAsArray[3]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->fax:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyFax\" size=\"29\" value=\"".$defaultValuesAsArray[4]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->website:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"companyWebsite\" size=\"29\" value=\"".$defaultValuesAsArray[5]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->other:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyOther\" size=\"29\" value=\"".$defaultValuesAsArray[6]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          
		  <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->theme:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"themeSelected\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_theme=='serious') 
			  {
				 	echo "
                	<option selected value=\"serious\">$lang->serious</option>
                	<option value=\"big blue\">$lang->bigBlue</option>
					";
			  }
			  elseif($cfg_theme=='big blue')
			  {
			  		echo "
			  		 <option selected value=\"big blue\">$lang->bigBlue</option>
			  		 <option value=\"serious\">$lang->serious</option>


					";
			  }

			echo "
              </select></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->taxRate:</b><br>
              &nbsp;<i>($lang->inPercent)</i></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"taxRate\" size=\"29\" value=\"".$defaultValuesAsArray[7]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
            <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->currencySymbol:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"currencySymbol\" size=\"29\" value=\"".$defaultValuesAsArray[8]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            </tr>
            
            <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->storecode:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"storecode\"29\" value=\"".$defaultValuesAsArray[11]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            </tr>
			
				<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Start_Transaction_Num_With:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"starttransnumwith\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_startTransNum_with=='yyyy') 
			  {
				 	echo "
                	<option selected value=\"yyyy\">yyyy</option>
					<option value=\"yyyymm\">yyyymm</option>
					<option value=\"yyyymmdd\">yyyymmdd</option>
                	<option value=\"yymm\">yymm</option>
					<option value=\"yymmdd\">yymmdd</option>
					<option value=\"none\">none</option>
					
					";
			  }
			  elseif($cfg_startTransNum_with=='yymm')
			  {
			  		echo "
			  		 <option selected value=\"yymm\">yymm</option>
			  		 <option value=\"yyyy\">yyyy</option>
					 <option value=\"yyyymm\">yyyymm</option>
					 <option value=\"yyyymmdd\">yyyymmdd</option>
					 <option value=\"yymmdd\">yymmdd</option>
                     <option value=\"none\">none</option> 

					";
			  }
			  elseif($cfg_startTransNum_with=='yyyymm')
			  {
			  		echo "
			  		 <option selected value=\"yyyymm\">yyyymm</option>
			  		 <option value=\"yyyy\">yyyy</option>
					 <option value=\"yyyymmdd\">yyyymmdd</option>
					 <option value=\"yymm\">yymm</option>
					 <option value=\"yymmdd\">yymmdd</option>
                     <option value=\"none\">none</option> 

					";
			 }
			 elseif($cfg_startTransNum_with=='yyyymmdd')
			  {
			  		echo "
			  		 <option selected value=\"yyyymmdd\">yyyymmdd</option>
			  		 <option value=\"yyyy\">yyyy</option>
					 <option value=\"yyyymm\">yyyymm</option>
					 <option value=\"yymm\">yymm</option>
					 <option value=\"yymmdd\">yymmdd</option>
                     <option value=\"none\">none</option> 

					";	
             }
			 elseif($cfg_startTransNum_with=='yymmdd')
			  {
			  		echo "
			  		 <option selected value=\"yymmdd\">yymmdd</option>
			  		 <option value=\"yyyy\">yyyy</option>
					 <option value=\"yyyymm\">yyyymm</option>
					 <option value=\"yymm\">yymm</option>
					 <option value=\"yyyymmdd\">yyyymmdd</option>
                     <option value=\"none\">none</option> 

					";						
			  }
             elseif($cfg_startTransNum_with=='none')
			  {
			  		echo "
			  		 <option selected value=\"none\">none</option>
					 <option value=\"yyyy\">yyyy</option>
					 <option value=\"yyyymm\">yyyymm</option>
					 <option value=\"yyyymmdd\">yyyymmdd</option>
			  		 <option value=\"yymm\">yymm</option>
					 <option value=\"yymmdd\">yymmdd</option>

					";
			  }
			echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->configfile:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"configfile\"29\" value=\"".$defaultValuesAsArray[12]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            </tr>
			
						<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->dvdbuy:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"dvdbuy\"29\" value=\"".$defaultValuesAsArray[13]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            </tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->dvdsell:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"dvdsell\"29\" value=\"".$defaultValuesAsArray[14]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            </tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->gamedvdbuy:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"gamedvdbuy\"29\" value=\"".$defaultValuesAsArray[15]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            </tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->gamedvdsell:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"gamedvdsell\"29\" value=\"".$defaultValuesAsArray[16]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            </tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>GameDVD UPC:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"gamedvdupc\" style=\"border-style: solid; border-width: 1\">";
			  
			  if($cfg_gamedvd_upc=='gamedvdupc') 
			  {
				 	echo "
                	<option selected value=\"gamedvdupc\">GameDVD-UPC</option>
                	<option value=\"storeupc\">Store-UPC</option>
					";
			  }
			  elseif($cfg_gamedvd_upc=='storeupc')
			  {
			  		echo "
			  		 <option selected value=\"storeupc\">Store-UPC</option>
			  		 <option value=\"gamedvdupc\">GameDVD-UPC</option>


					";
			  }

			echo "
              </select></p>
			
			</td>
            </tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Item_Image_OnPDF:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"itemimgonpdf\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_itemimg_onpdf=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					<option value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option>
					
					";
			  }
			  elseif($cfg_itemimg_onpdf=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>
                     <option value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option> 

					";
			  }
             elseif($cfg_itemimg_onpdf=='NotONpdf-ButOnFile')
			  {
			  		echo "
			  		 <option selected value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option>
					 <option value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }
			echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Supplier_Image_OnPDF:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"supplierimgonpdf\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_supplierImage_onpdf=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					<option value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option>
					";
			  }
			  elseif($cfg_supplierImage_onpdf=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>
					 <option value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option>


					";
			  }
			  elseif($cfg_supplierImage_onpdf=='NotONpdf-ButOnFile')
			  {
			  		echo "
			  		 <option selected value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option>
					 <option value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			

			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>FingerPrint_OnPDF:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"fingerprintonpdf\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_fingerprint_onpdf=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					<option value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option>
					";
			  }
			  elseif($cfg_fingerprint_onpdf=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>
					 <option value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option>


					";
			  }
				elseif($cfg_fingerprint_onpdf=='NotONpdf-ButOnFile')
			  {
			  		echo "
			  		 <option selected value=\"NotONpdf-ButOnFile\">NotONpdf-ButOnFile</option>
					 <option value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }
			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Create Check:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"createcheck\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_create_check=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_create_check=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Supplier_Found_GoTo_Update_Supplier_Page:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"gotoupdatesupplier\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_SupplierFound_GoToUpdate=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_SupplierFound_GoToUpdate=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			  echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Image_Snap_Method:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"imagesnapmethod\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_imagesnapmethod=='pc') 
			  {
				 	echo "
                	<option selected value=\"pc\">pc</option>
                	<option value=\"online\">online</option>
					";
			  }
			  elseif($cfg_imagesnapmethod=='online')
			  {
			  		echo "
			  		 <option selected value=\"online\">online</option>
			  		 <option value=\"pc\">pc</option>


					";
			  }
			  echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_Image_Upload_Person:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enableimageuploadperson\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enableimageupload_person=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enableimageupload_person=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }
			  
			  	echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_Image_Upload_Items:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enableimageuploaditems\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enableimageupload_items=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enableimageupload_items=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }
			  
			 echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_Image_Upload_Jewelry:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enableimageuploadjewelry\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enableimageupload_jewelry=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enableimageupload_jewelry=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }
			  
			 		  	  	echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_Image_Upload_DVD:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enableimageuploaddvd\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enableimageupload_dvd=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enableimageupload_dvd=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }
			  
			  		  	  	echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_Image_Upload_GameDVD:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enableimageuploadgdvd\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enableimageupload_gdvd=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enableimageupload_gdvd=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }
			  
			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Supplier_Form_Gender:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"supplierformgender\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_supplier_form_gender=='enabled_required') 
			  {
				 	echo "
                	<option selected value=\"enabled_required\">Enable and Required</option>
                	<option value=\"enabled_not_required\">Enable and Not Required</option>
					<option value=\"disable\">Disable</option>
					";
			  }
			  elseif($cfg_supplier_form_gender=='enabled_not_required')
			  {
			  		echo "
			  		 <option selected value=\"enabled_not_required\">Enable and Not Required</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"disable\">Disable</option>

					";
			  }
			  elseif($cfg_supplier_form_gender=='disable')
			  {
			  		echo "
			  		 <option selected value=\"disable\">Disable</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"enabled_not_required\">Enable and Not Required</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Supplier_Form_Race:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"supplierformrace\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_supplier_form_race=='enabled_required') 
			  {
				 	echo "
                	<option selected value=\"enabled_required\">Enable and Required</option>
                	<option value=\"enabled_not_required\">Enable and Not Required</option>
					<option value=\"disable\">Disable</option>
					";
			  }
			  elseif($cfg_supplier_form_race=='enabled_not_required')
			  {
			  		echo "
			  		 <option selected value=\"enabled_not_required\">Enable and Not Required</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"disable\">Disable</option>

					";
			  }
			  elseif($cfg_supplier_form_race=='disable')
			  {
			  		echo "
			  		 <option selected value=\"disable\">Disable</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"enabled_not_required\">Enable and Not Required</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Supplier_Form_Height:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"supplierformheight\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_supplier_form_height=='enabled_required') 
			  {
				 	echo "
                	<option selected value=\"enabled_required\">Enable and Required</option>
                	<option value=\"enabled_not_required\">Enable and Not Required</option>
					<option value=\"disable\">Disable</option>
					";
			  }
			  elseif($cfg_supplier_form_height=='enabled_not_required')
			  {
			  		echo "
			  		 <option selected value=\"enabled_not_required\">Enable and Not Required</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"disable\">Disable</option>

					";
			  }
			  elseif($cfg_supplier_form_height=='disable')
			  {
			  		echo "
			  		 <option selected value=\"disable\">Disable</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"enabled_not_required\">Enable and Not Required</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Supplier_Form_Weight:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"supplierformweight\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_supplier_form_weight=='enabled_required') 
			  {
				 	echo "
                	<option selected value=\"enabled_required\">Enable and Required</option>
                	<option value=\"enabled_not_required\">Enable and Not Required</option>
					<option value=\"disable\">Disable</option>
					";
			  }
			  elseif($cfg_supplier_form_weight=='enabled_not_required')
			  {
			  		echo "
			  		 <option selected value=\"enabled_not_required\">Enable and Not Required</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"disable\">Disable</option>

					";
			  }
			  elseif($cfg_supplier_form_weight=='disable')
			  {
			  		echo "
			  		 <option selected value=\"disable\">Disable</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"enabled_not_required\">Enable and Not Required</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Supplier_Form_HairColor:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"supplierformhaircolor\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_supplier_form_haircolor=='enabled_required') 
			  {
				 	echo "
                	<option selected value=\"enabled_required\">Enable and Required</option>
                	<option value=\"enabled_not_required\">Enable and Not Required</option>
					<option value=\"disable\">Disable</option>
					";
			  }
			  elseif($cfg_supplier_form_haircolor=='enabled_not_required')
			  {
			  		echo "
			  		 <option selected value=\"enabled_not_required\">Enable and Not Required</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"disable\">Disable</option>

					";
			  }
			  elseif($cfg_supplier_form_haircolor=='disable')
			  {
			  		echo "
			  		 <option selected value=\"disable\">Disable</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"enabled_not_required\">Enable and Not Required</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Supplier_Form_EyeColor:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"supplierformeyecolor\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_supplier_form_eyecolor=='enabled_required') 
			  {
				 	echo "
                	<option selected value=\"enabled_required\">Enable and Required</option>
                	<option value=\"enabled_not_required\">Enable and Not Required</option>
					<option value=\"disable\">Disable</option>
					";
			  }
			  elseif($cfg_supplier_form_eyecolor=='enabled_not_required')
			  {
			  		echo "
			  		 <option selected value=\"enabled_not_required\">Enable and Not Required</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"disable\">Disable</option>

					";
			  }
			  elseif($cfg_supplier_form_eyecolor=='disable')
			  {
			  		echo "
			  		 <option selected value=\"disable\">Disable</option>
			  		 <option value=\"enabled_required\">Enable and Required</option>
					 <option value=\"enabled_not_required\">Enable and Not Required</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Phone Required:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"phonerequired\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_makePhoneRequired=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">No</option>
                	<option value=\"yes\">Yes</option>
					<option value=\"yes-UseNameSrchCustTbl\">Yes Enter Any Number</option>
					";
			  }
			  elseif($cfg_makePhoneRequired=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">Yes</option>
			  		 <option value=\"no\">No</option>
					 <option value=\"yes-UseNameSrchCustTbl\">Yes Enter Any Number</option>

					";
			  }
			  elseif($cfg_makePhoneRequired=='yes-UseNameSrchCustTbl')
			  {
			  		echo "
			  		 <option selected value=\"yes-UseNameSrchCustTbl\">Yes Enter Any Number</option>
			  		 <option value=\"no\">No</option>
					 <option value=\"yes\">Yes</option>


					";
			  }
			echo "
              </select></p>
            </td>
			</tr>
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Menu Location:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"menulocation\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_menulocation=='top') 
			  {
				 	echo "
                	<option selected value=\"top\">top</option>
                	<option value=\"side\">side</option>
					<option value=\"header\">header</option>
					";
			  }
			  elseif($cfg_menulocation=='side')
			  {
			  		echo "
			  		 <option selected value=\"side\">side</option>
			  		 <option value=\"top\">top</option>
					 <option value=\"header\">header</option>


					";
			  }
			  elseif($cfg_menulocation=='header')
			  {
			  		echo "
			  		 <option selected value=\"header\">header</option>
			  		 <option value=\"top\">top</option>
					 <option value=\"side\">side</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Header background color:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"headerbgcolor\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_headerBGcolor=='darkorange') 
			  {
				 	echo "
                	<option selected value=\"darkorange\">Dark Orange</option>
                	<option value=\"darkblack\">Dark Black</option>
					<option value=\"darkblue\">Dark Blue</option>
					";
			  }
			  elseif($cfg_headerBGcolor=='darkblack')
			  {
			  		echo "
			  		 <option selected value=\"darkblack\">Dark Black</option>
			  		 <option value=\"darkorange\">Dark Orange</option>
					 <option value=\"darkblue\">Dark Blue</option>


					";
			  }
			  elseif($cfg_headerBGcolor=='darkblue')
			  {
			  		echo "
			  		 <option selected value=\"darkblue\">Dark Blue</option>
			  		 <option value=\"darkorange\">Dark Orange</option>
					 <option value=\"darkblack\">Dark Black</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable CSA Link:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enableCSAlink\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enable_CSAlink=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enable_CSAlink=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
						
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_Sale_Of_Services:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enablesaleservices\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enable_SaleServices=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enable_SaleServices=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
									
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>SalePanel_Enable_Enter_ServiceName_Field:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enableentersrvnamefield\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_SaleSrvPanel_enable_enter_srvname_field=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_SaleSrvPanel_enable_enter_srvname_field=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>SalePanel_Add_SrvName_Entered_to_ArticleTbl:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"addsrvnameentered\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_SaleSrvPanel_Add_Entered_srvnameToArticleTbl=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_SaleSrvPanel_Add_Entered_srvnameToArticleTbl=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
						
			<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>SalePanel_Show_TenderAmt_As2nd_Step:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"ShowTenderAmtBoxas2ndStep\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_ShowTenderAmtBox_as2nd_Step=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_ShowTenderAmtBox_as2nd_Step=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
			
			
		<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_SalesClerk_Create_TransFile:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enablesalesclerktran\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_allow_salesclerk_tocreate_extractfile=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_allow_salesclerk_tocreate_extractfile=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>	
			
					<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_SalesClerk_View_BuyPrice:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enablesalesclerkbuyprice\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_allow_salesclerk_view_buyprice=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_allow_salesclerk_view_buyprice=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>	
			
					
		<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_Delete_SAPDF:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enabledeletesapdf\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enable_deleteSAPDF=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enable_deleteSAPDF=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
								
		<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Enable_PopUp_Updateform:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"enablepopupupdateform\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_enable_PopUpUpdateform=='no') 
			  {
				 	echo "
                	<option selected value=\"no\">no</option>
                	<option value=\"yes\">yes</option>
					";
			  }
			  elseif($cfg_enable_PopUpUpdateform=='yes')
			  {
			  		echo "
			  		 <option selected value=\"yes\">yes</option>
			  		 <option value=\"no\">no</option>


					";
			  }

			echo "
              </select></p>
            </td>
			</tr>
            
        <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->numberToUseForBarcode:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><select size=\"1\" name=\"numberForBarcode\" style=\"border-style: solid; border-width: 1\">";	
			  if($cfg_numberForBarcode=='Row ID') 
			  {
				 	echo "
                	<option selected value=\"Row ID\">$lang->rowID</option>
                	<option value=\"Account/Item Number\">$lang->accountNumber/$lang->itemNumber</option>
					";
			  }
			  elseif($cfg_numberForBarcode=='Account/Item Number')
			  {
			  		echo "
                	 <option selected value=\"Account/Item Number\">$lang->accountNumber/$lang->itemNumber</option>
                	 <option value=\"Row ID\">$lang->rowID</option>
					";
			  }
			?>
              </select></p>
            </td>
          </tr>
     
           <tr>
        <td width="190" align="left" bgcolor=<?php echo "$themeRowColor2" ?>>
        <p align="center"><font face="Verdana" size="2"><b><?php echo $lang->language ?>:</b></font></td>
        <td width="242" align="center" bgcolor=<?php echo "$themeRowColor2" ?>>&nbsp;<font face="Verdana" size="5">
        <select name="language" style="border-style: solid; border-width: 1; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">
        
        <?php
        $temp_lang=ucfirst(substr($defaultValuesAsArray[10],0,strpos($defaultValuesAsArray[10],'.')));
 		echo "<option selected value='$defaultValuesAsArray[10]'>$temp_lang</option>";
        $handle = opendir('../language');
        	while (false !== ($file = readdir($handle))) 
 			{ 
    			if ($file {0}!='.' && $file!=$defaultValuesAsArray[10]) 
 				{ 
 					$temp_lang=ucfirst(substr($file,0,strpos($file,'.')));
      				echo "<option value='$file'>$temp_lang</option>"; 
    			} 
  			}
   	    	closedir($handle); 
 		
		?>
        
        </select></font></td>
      </tr>
      
       <?php   
        echo "</table>
        </div>
        </center>
        <p align=\"left\">
        <input type=\"submit\" name=\"submitChanges\" style=\"border-style: solid; border-width: 1\"><Br>
        </form>
      </div>
    </td>
  </tr>
</table>
</body>
</html>";

}

function updateSettings($companyname,$companyaddress,$companyphone,$companyemail,$companyfax,$companywebsite,$companyother,$theme,$taxrate,$currencySymbol,$numberForBarcode,$language,$storecode,$starttransnumwith,$configfile,$dvdbuy,$dvdsell,$gamedvdbuy,$gamedvdsell,$gamedvdupc,$itemimgonpdf,$supplierimgonpdf,$fingerprintonpdf,$createcheck,$gotoupdatesupplier,$imagesnapmethod,$enableimageuploadperson,$enableimageuploaditems,$enableimageuploadjewelry,$enableimageuploaddvd,$enableimageuploadgdvd,$supplierformgender,$supplierformrace,$supplierformheight,$supplierformweight,$supplierformhaircolor,$supplierformeyecolor,$phonerequired,$menulocation,$headerbgcolor,$enableCSAlink,$enablesaleservices,$enableentersrvnamefield,$addsrvnameentered,$ShowTenderAmtBoxas2ndStep,$enablesalesclerktran,$enablesalesclerkbuyprice,$enabledeletesapdf,$enablepopupupdateform) {
 
include("../settings.php");
$lang=new language();
$writeConfigurationFile="<?php
\$cfg_company=\"$companyname\";
\$cfg_address=\"$companyaddress\";
\$cfg_phone=\"$companyphone\";
\$cfg_email=\"$companyemail\";
\$cfg_fax=\"$companyfax\";
\$cfg_website=\"$companywebsite\";
\$cfg_other=\"$companyother\";
\$cfg_default_tax_rate=\"$taxrate\";
\$cfg_currency_symbol=\"$currencySymbol\";
\$cfg_theme=\"$theme\";
\$cfg_numberForBarcode=\"$numberForBarcode\";
\$cfg_language=\"$language\";
\$cfg_store_code=\"$storecode\";        
\$cfg_startTransNum_with=\"$starttransnumwith\";
\$cfg_configfile=\"$configfile\";
\$cfg_dvd_buyprice=\"$dvdbuy\";
\$cfg_dvd_sellprice=\"$dvdsell\";
\$cfg_gamedvd_buyprice=\"$gamedvdbuy\";
\$cfg_gamedvd_sellprice=\"$gamedvdsell\";
\$cfg_gamedvd_upc=\"$gamedvdupc\"; //Values are gamedvdupv or storeupc
\$cfg_itemimg_onpdf=\"$itemimgonpdf\";
\$cfg_supplierImage_onpdf=\"$supplierimgonpdf\";
\$cfg_fingerprint_onpdf=\"$fingerprintonpdf\";
\$cfg_create_check=\"$createcheck\";
\$cfg_SupplierFound_GoToUpdate=\"$gotoupdatesupplier\";
\$cfg_imagesnapmethod=\"$imagesnapmethod\";
\$cfg_enableimageupload_person=\"$enableimageuploadperson\";
\$cfg_enableimageupload_items=\"$enableimageuploaditems\";
\$cfg_enableimageupload_jewelry=\"$enableimageuploadjewelry\";
\$cfg_enableimageupload_dvd=\"$enableimageuploaddvd\";
\$cfg_enableimageupload_gdvd=\"$enableimageuploadgdvd\";
\$cfg_supplier_form_gender=\"$supplierformgender\";
\$cfg_supplier_form_race=\"$supplierformrace\";
\$cfg_supplier_form_height=\"$supplierformheight\";
\$cfg_supplier_form_weight=\"$supplierformweight\";
\$cfg_supplier_form_haircolor=\"$supplierformhaircolor\";
\$cfg_supplier_form_eyecolor=\"$supplierformeyecolor\";
\$cfg_makePhoneRequired=\"$phonerequired\";
\$cfg_company_city=\"$cfg_company_city\"; 
\$cfg_pos_version=\"$cfg_pos_version\";
\$cfg_store_state=\"$cfg_store_state\"; //il=illinois wi=wisconsin
\$cfg_dvdlookup_version=\"$cfg_dvdlookup_version\";
\$cfg_processForm_version=\"$cfg_processForm_version\"; //1=Insert by getting Autoincrement id value of table 2=Inserts dummy record then get the id value of inserted record(user single login requried)
\$cfg_menulocation=\"$menulocation\"; 
\$cfg_headerBGcolor=\"$headerbgcolor\";  //Values are darkorange, darkblack and darkblue
\$cfg_enable_CSAlink=\"$enableCSAlink\";
\$cfg_enable_SaleServices=\"$enablesaleservices\"; //Enable Sale of Services. you will Also need to create a category names Services
\$cfg_SaleSrvPanel_enable_enter_srvname_field=\"$enableentersrvnamefield\"; //If yes will enable enter service name field on sale panel for the services
\$cfg_SaleSrvPanel_Add_Entered_srvnameToArticleTbl=\"$addsrvnameentered\"; //If yes will insert the Service Name entered to article table, this will then show under dropdown of services
\$cfg_ShowTenderAmtBox_as2nd_Step=\"$ShowTenderAmtBoxas2ndStep\"; //yes=hide tender amount box until button is clicked no=will show tender amount on same page
\$cfg_allow_salesclerk_tocreate_extractfile=\"$enablesalesclerktran\";
\$cfg_allow_salesclerk_view_buyprice=\"$enablesalesclerkbuyprice\";
\$cfg_enable_deleteSAPDF=\"$enabledeletesapdf\";
\$cfg_enable_PopUpUpdateform=\"$enablepopupupdateform\";
\$cfg_maxupc_number=\"$cfg_maxupc_number\";
\$cfg_create_extractFilename=\"$cfg_create_extractFilename\";
\$cfg_sftpmsg_file_pathName=\"$cfg_sftpmsg_file_pathName\"; 
\$cfg_UnderMaintenance=\"$cfg_UnderMaintenance\";
?>";	



        
	@unlink("../settings.php");
	$hWriteConfiguration = @fopen("../settings.php", "w+" ) or die ("<br><center><img src='config_updated_failed.gif'><br><br><b>$lang->configUpdatedUnsucessfully</b></center>");
	fputs( $hWriteConfiguration, $writeConfigurationFile);
	fclose( $hWriteConfiguration );
}


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$hDisplay=new display($dbf,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

if(isset($_POST['submitChanges'])) {
	if($_POST['companyName']!="" && $_POST['companyPhone']!="" && $_POST['taxRate']!="" && $_POST['currencySymbol']!="") 
	{
		
		updateSettings($_POST['companyName'],$_POST['companyAddress'],$_POST['companyPhone'],
			$_POST['companyEmail'],$_POST['companyFax'],$_POST['companyWebsite'],$_POST['companyOther'],$_POST['themeSelected'],$_POST['taxRate'],$_POST['currencySymbol'],$_POST['numberForBarcode'],$_POST['language'],$_POST['storecode'],$_POST['starttransnumwith'],$_POST['configfile'],$_POST['dvdbuy'],$_POST['dvdsell'],$_POST['gamedvdbuy'],$_POST['gamedvdsell'],$_POST['gamedvdupc'],$_POST['itemimgonpdf'],$_POST['supplierimgonpdf'],$_POST['fingerprintonpdf'],$_POST['createcheck'],$_POST['gotoupdatesupplier'],$_POST['imagesnapmethod'],$_POST['enableimageuploadperson'],$_POST['enableimageuploaditems'],$_POST['enableimageuploadjewelry'],$_POST['enableimageuploaddvd'],$_POST['enableimageuploadgdvd'],$_POST['supplierformgender'],$_POST['supplierformrace'],$_POST['supplierformheight'],$_POST['supplierformweight'],$_POST['supplierformhaircolor'],$_POST['supplierformeyecolor'],$_POST['phonerequired'],$_POST['menulocation'],$_POST['headerbgcolor'],$_POST['enableCSAlink'],$_POST['enablesaleservices'],$_POST['enableentersrvnamefield'],$_POST['addsrvnameentered'],$_POST['ShowTenderAmtBoxas2ndStep'],$_POST['enablesalesclerktran'],$_POST['enablesalesclerkbuyprice'],$_POST['enabledeletesapdf'],$_POST['enablepopupupdateform']);
		echo "<br><center><img src='config_updated_ok.gif'><br><br><b>$lang->configUpdatedSuccessfully</b></center>";
	} 
	else 
	{
		echo "$lang->forgottenFields";
	}
} 
elseif (isset($_POST['cancelChanges'])) 
{
	header("Location: ../home.php");
} 
else 
{
	displayUpdatePage(getFormFields());
}

$dbf->closeDBlink();


?>

