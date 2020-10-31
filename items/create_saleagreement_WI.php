<?php session_start(); ?>

<html>
<head>
	
</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions_dvd.php");
include ("../classes/security_functions.php");
include ("../classes/resizeimage.php");
include ("../classes/cryptastic.php");



$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$commondbf=new db_functions($cfg_server,$cfg_commondbuser,$cfg_commondbpwd,$cfg_commondbname,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);




if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit ();
}


$tablename="$cfg_tableprefix".'items';
$trans_tablename="$cfg_tableprefix".'item_transactions';
$field_names=null;
$field_data=null;
$id=-1;


    
	
	
	
	
	
    
    
	
	
	


 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

 
 if(isset($_GET['checkonly'])){ 
   $onlycheck=$_GET['checkonly'];
}else{
   $onlycheck='no';
}	

if(isset($_GET['saonly'])){ 
   $onlysa=$_GET['saonly'];
}else{
   $onlysa='no';
}	

		  
		if(isset($_GET['working_on_id']) and isset($_GET['active_trans_id'])){  
		    
		    
		      if (($_GET['working_on_id'] != "") and ($_GET['active_trans_id'] != "")){
		     
		            $supplier_id=$_GET['working_on_id'];
		            $itemtrans_id=$_GET['active_trans_id'];
		            $saleagreement = 'Yes';
		       }else{
		       	echo "Missing Supplier ID and Transaction ID. Please process at lease one item before clicking on Done create saleagreement link.";
		      }     
		  }else{
		   
		   echo "Missing Supplier ID and Transaction ID";
	  }
		
		
		
		if ($saleagreement == 'Yes'){
				
				
				$itemIMGnumber = 0;
         
				$supplier_tablename="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);
				
				
				$transactions_tablename="$cfg_tableprefix".'item_transactions';
				
				

				$itemtransactions_query="SELECT * FROM $transactions_tablename where transaction_id = $itemtrans_id and transaction_from_panel = 'additem'";
				$itemtransactions_result=mysql_query($itemtransactions_query,$dbf->conn);
				
				$jewelrytransactions_query="SELECT * FROM $transactions_tablename where transaction_id = $itemtrans_id and transaction_from_panel = 'jewelry'";
				$jewelrytransactions_result=mysql_query($jewelrytransactions_query,$dbf->conn);
				
				$dvdtransactions_query="SELECT * FROM $transactions_tablename where transaction_id = $itemtrans_id and (transaction_from_panel = 'adddvd' or transaction_from_panel = 'addvgdvd') ";
				$dvdtransactions_result=mysql_query($dvdtransactions_query,$dbf->conn);
				
				
				
				$selectimageforprinting_query="SELECT * FROM $transactions_tablename where transaction_id = $itemtrans_id and (transaction_from_panel = 'additem' or transaction_from_panel = 'jewelry') ";
				$imagesforprinting_result=mysql_query($selectimageforprinting_query,$dbf->conn);
				
				$selectitemimageloaded_query="SELECT item_image FROM $transactions_tablename WHERE item_image <> ''AND transaction_id = $itemtrans_id and (transaction_from_panel = 'additem' or transaction_from_panel = 'jewelry') ";
                $itemimagesloaded_result=mysql_query($selectitemimageloaded_query,$dbf->conn); 
				$numofimagesloaded_rows = mysql_num_rows($itemimagesloaded_result);
				
				
            
        
       
          $supplier_full_name = $supplier_row['supplier'];
         
          $SupplierNameArrary = explode(" ", $supplier_full_name);
          $NumberOfNames = sizeof($SupplierNameArrary);

       
        if($NumberOfNames == 3) {
           $supplier_lastname = $SupplierNameArrary[2];
           $supplier_firstname = $SupplierNameArrary[0];
           $supplier_mi= $SupplierNameArrary[1];
           $pdf_supplier_name = "$supplier_lastname".' '."$supplier_firstname".' '."$supplier_mi";

        }else if ($NumberOfNames == 2) {
           $supplier_lastname = $SupplierNameArrary[1];
           $supplier_firstname = $SupplierNameArrary[0];
           $supplier_mi= '';
           $pdf_supplier_name = "$supplier_lastname".' '."$supplier_firstname".' '."$supplier_mi";

        }else if ($NumberOfNames == 1) {
           $supplier_lastname = $SupplierNameArrary[0];
           $supplier_firstname = '';
           $supplier_mi= '';
           $pdf_supplier_name = "$supplier_lastname".' '."$supplier_firstname".' '."$supplier_mi";

        }
        
        $pdf_supplier_name= $supplier_row['lastname'].' '.$supplier_row['firstname'].' '.$supplier_row['middlename'];
        $checkpdf_supplier_name= $supplier_row['firstname'].' '.$supplier_row['middlename']. ' ' . $supplier_row['lastname'];
      
	  
	  

		   $supplierIDpic=$cfg_store_code.$supplier_id;	
		   
		   if ($cfg_data_outside_storedir == "yes") {
		        $pdfwith_id_path="$cfg_data_csapdf_pathdir/$supplier_id/";
				$pdfwith_id_pathtmp=$cfg_data_storePDFDataTempDir;
				$imageunziptemp=$cfg_data_imageunziptemp;

		   }else{
		       $pdfwith_id_path="saleagreements/$supplier_id/";
			   $pdfwith_id_pathtmp="saleagreements/temp/";
	       }
            
      if ($onlycheck == "no" || $onlysa == "no"){
	 
            
            if ($cfg_data_outside_storedir == "no") {
            $dirname = "$supplier_id";     
            $pdf_filedir = "/saleagreements/{$dirname}/";     
     
               if (file_exists($pdf_filedir)) {     
    
                } else {     
                  mkdir("saleagreements/{$dirname}", 0775);     
    
                }  
                
				$temppdf_filedir = "/saleagreements/temp";
				if (file_exists($temppdf_filedir)) {

				  }else{
				      mkdir("$temppdf_filedir", 0775);
				  }
				
            }
			
			if ($cfg_data_outside_storedir == "yes") {
               $dirname = "$supplier_id";     
               $pdf_filedir = "$cfg_data_csapdf_pathdir/{$dirname}/";     
     
               if (file_exists($pdf_filedir)) {     
    
                } else {     
                  mkdir("$cfg_data_csapdf_pathdir/{$dirname}", 0775);    
    
                } 
				

				$temppdf_filedir = "$cfg_data_storePDFDataTempDir";
				if (file_exists($temppdf_filedir)) {

				  }else{
				      mkdir("$temppdf_filedir", 0775);
				  }
            }

			
			

if ($cfg_supplierImage_onpdf=="yes") {

  
  if ($cfg_data_outside_storedir == "yes") {
		
		  $supplierIMGDir = substr($cfg_data_supplierIMGpathdir, 3); 
		  $supplierimagefile=$supplierIMGDir.$supplier_row['imagecust'];
		  $supplierpicfilename=$supplier_row['imagecust'];
          $supplierimage_extension = getExtension($supplierimagefile);
          $supplierpicType = strtolower($supplierimage_extension);
		  $supplierpic= $supplierimagefile; 
		
		}else{
		  $supplierimagefile='suppliers/images/'.$supplier_row['imagecust'];
		  $supplierfilename=$supplier_row['imagecust'];
          $supplierimage_extension = getExtension($supplierimagefile);
          $supplierpicType = strtolower($supplierimage_extension);
		  $supplierpic= $supplierimagefile;
		 }  
  
  
  
	  
     $cryptastic = new cryptastic;

      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	                      die("Failed to generate secret key.");
	if ($cfg_imageZipORnozip == "nozip"){	    
                $msg 			= file_get_contents($supplierIMGDir.$supplierpicfilename);
	            $decrypted = $cryptastic->decrypt($msg, $key) or
				             die("Failed to complete decryption supplier Image");

                   $dencryptedFile 	= $cfg_data_supplierIMGpathdirtemp.$supplierpicfilename;
 
	              $fHandle		= fopen($dencryptedFile, 'w+');
	              fwrite($fHandle, $decrypted);
	              fclose($fHandle);


   }else{
        
		$zippedimg=$supplierIMGDir.$supplierpicfilename.'.zip';
		
		exec("unzip -jP $key $zippedimg -d $imageunziptemp", $output1);
		$dencryptedsupplierpicFile=$imageunziptemp.$supplierpicfilename; 
   
   }
				 
	  
	  
  
  

}
		
			if ($cfg_dencrypt == "yes")
             {
      
                    $cryptastic = new cryptastic;

                   $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
                          die("Failed to generate secret key.");




			if (($supplier_row['gender'] != "") and ($supplier_row['gender'] != " ")){
				$suppliergender = $cryptastic->decrypt($supplier_row['gender'], $key, true) or
                             die("Failed to complete decryption of gender");
			}else{
					$suppliergender = $supplier_row['gender'];
			}
			
			if (($supplier_row['height'] != "") and ($supplier_row['height'] != " ")){
				$supplierheight = $cryptastic->decrypt($supplier_row['height'], $key, true) or
                             die("Failed to complete decryption of height");
			}else{
						$supplierheight = $supplier_row['height'];
			}
			
			if (($supplier_row['weight'] != "") and ($supplier_row['weight'] != " ")){
				$supplierweight = $cryptastic->decrypt($supplier_row['weight'], $key, true) or
                             die("Failed to complete decryption of weight");
			}else{
					$supplierweight = $supplier_row['weight'];
			}
			
			if (($supplier_row['hair_color'] != "") and ($supplier_row['hair_color'] != " ")){
				$supplierhaircolor = $cryptastic->decrypt($supplier_row['hair_color'], $key, true) or
                                die("Failed to complete decryption of hair color");
			}else{
					$supplierhaircolor = $supplier_row['hair_color'];
			}
			
			if (($supplier_row['eyes_color'] != "") and ($supplier_row['eyes_color'] != " ")){
				$suppliereyescolor = $cryptastic->decrypt($supplier_row['eyes_color'], $key, true) or
                                 die("Failed to complete decryption of eyes color");
			}else{
					$suppliereyescolor = $supplier_row['eyes_color'];
			}
			
			if (($supplier_row['race'] != "") and ($supplier_row['race'] != " ")){
				$supplierrace = $cryptastic->decrypt($supplier_row['race'], $key, true) or
                           die("Failed to complete decryption of race");
			}else{
						$supplierrace = $supplier_row['race'];
			}
			
			if (($supplier_row['driver_lic_num'] != "") and ($supplier_row['driver_lic_num'] != " ")){
				$supplierdlic = $cryptastic->decrypt($supplier_row['driver_lic_num'], $key, true) or
                           die("Failed to complete decryption of Lic");
			}else{
						$supplierdlic = $supplier_row['driver_lic_num'];
			}
			
			
			if (($supplier_row['licstate'] != "") and ($supplier_row['licstate'] != " ")){
                  $supplierlicstate = $cryptastic->decrypt($supplier_row['licstate'], $key, true) or
                                     die("Failed to complete decryption of Lic State");			
			}else{
                    $supplierlicstate = $supplier_row['licstate'];

             }			
						   
			if (($supplier_row['idnumber'] != "") and ($supplier_row['idnumber'] != " ")){  
			       $supplieridnumber = $cryptastic->decrypt($supplier_row['idnumber'], $key, true) or
                                     die("Failed to complete decryption of ID Number");			 
        			  
			}else{
                    $supplieridnumber = $supplier_row['idnumber'];

             }					   
						   
						   
			if (($supplier_row['idstate'] != "") and ($supplier_row['idstate'] != " ")){  
			       $supplieridstate = $cryptastic->decrypt($supplier_row['idstate'], $key, true) or
                                     die("Failed to complete decryption of ID State");			 
        			  
			}else{
                    $supplieridstate = $supplier_row['idstate'];

             }						   
						   
			if (($supplier_row['idtype'] != "") and ($supplier_row['idtype'] != " ")){  
			       $supplieridtype = $cryptastic->decrypt($supplier_row['idtype'], $key, true) or
                                     die("Failed to complete decryption of ID Type");			 
        			  
			}else{
                    $supplieridtype = $supplier_row['idtype'];

             }						   
					
			if (($supplier_row['licexpdate'] != "") and ($supplier_row['licexpdate'] != " ")){ 
				$supplierlicexpdate = $cryptastic->decrypt($supplier_row['licexpdate'], $key, true) or
                                  die("Failed to complete decryption of Lic exp date"); 
			}else{
						$supplierlicexpdate = $supplier_row['licexpdate'];
			}
			
			if (($supplier_row['dob'] != "") and ($supplier_row['dob'] != " ")){
				$supplierdob = $cryptastic->decrypt($supplier_row['dob'], $key, true) or
                          die("Failed to complete decryption of DOB");
			}else{
						$supplierdob = $supplier_row['dob'];
			}
			
			if (($supplier_row['address'] != "") and ($supplier_row['address'] != " ")){
				$supplieraddress = $cryptastic->decrypt($supplier_row['address'], $key, true) or
                                die("Failed to complete decryption of Address");
			}else{
						$supplieraddress = $supplier_row['address'];
			}
			
			if (($supplier_row['city'] != "") and ($supplier_row['city'] != " ")){
				$suppliercity = $cryptastic->decrypt($supplier_row['city'], $key, true) or
                             die("Failed to complete decryption of City");
			}else{
						$suppliercity = $supplier_row['city'];
			}
			
			if (($supplier_row['state'] != "") and ($supplier_row['state'] != " ")){
				$supplierstate = $cryptastic->decrypt($supplier_row['state'], $key, true) or
                             die("Failed to complete decryption of State");
			}else{
						$supplierstate = $supplier_row['state'];
			}
			
			if (($supplier_row['zip'] != "") and ($supplier_row['zip'] != " ")){
				$supplierzip = $cryptastic->decrypt($supplier_row['zip'], $key, true) or
                            die("Failed to complete decryption of Zip");
			}else{
					$supplierzip = $supplier_row['zip'];
			}



}else{

$suppliergender=$supplier_row['gender'];
$supplierrace=$supplier_row['race'];
$supplierheight=$supplier_row['height'];
$supplierweight=$supplier_row['weight'];
$supplierhaircolor=$supplier_row['hair_color'];
$suppliereyescolor=$supplier_row['eyes_color'];
$supplierdob=$supplier_row['dob'];
$supplierdlic=$supplier_row['driver_lic_num'];
$supplierlicstate=$supplier_row['licstate'];
$supplieridnumber=$supplier_row['idnumber'];
$supplieridstate=$supplier_row['idstate'];
$supplieridtype=$supplier_row['idtype'];
$supplierlicexpdate=$supplier_row['licexpdate'];
$supplieraddress=$supplier_row['address'];
$suppliercity=$supplier_row['city'];
$supplierstate=$supplier_row['state'];
$supplierzip=$supplier_row['zip'];
}
 
			
			
			            
            
		require_once('createPDF/fpdf.php');   
        require_once('createPDF/fpdi/fpdi.php');   
    
        
		
		if ($cfg_data_outside_storedir == "yes") {
		
		  $supplierIMGDir = substr($cfg_data_supplierIMGpathdir, 3); 
		  $licimagefile=$supplierIMGDir.$supplier_row['imagelic'];
		  $licfilename=$supplier_row['imagelic'];
          $licimage_extension = getExtension($licimagefile);
          $licpicType = strtolower($licimage_extension);
		  $licpic= $licimagefile; 
		
		}else{
		  $licimagefile='suppliers/images/'.$supplier_row['imagelic'];
		  $licfilename=$supplier_row['imagelic'];
          $licimage_extension = getExtension($licimagefile);
          $licpicType = strtolower($licimage_extension);
		  $licpic= $licimagefile;
		 }  
		   
		
  
    $pdf =& new FPDI();   
  
    $pagecount = $pdf->setSourceFile('saleagreement_wisconsin.pdf');     
   $tplidx = $pdf->importPage(1, '/ArtBox');

  
    $pdf->addPage(); 

     $pdf->useTemplate($tplidx);
   

$itemtotal_rows = mysql_num_rows($itemtransactions_result); 
$jewelrytotal_rows = mysql_num_rows($jewelrytransactions_result);
$dvdtotal_rows = mysql_num_rows($dvdtransactions_result);
 
$totaltransrows=$itemtotal_rows + $jewelrytotal_rows + $dvdtotal_rows;
$num_rows=$totaltransrows;


$firstpage='yes';

$totalitemsbuyprice=0;
while($item_transaction_row = mysql_fetch_array($itemtransactions_result)) {
        $ArticalID = $item_transaction_row['article_id'];
         $transaction_from_panel = $item_transaction_row['transaction_from_panel'];
         $ArticleTable="$cfg_tableprefix".'articles';
         $ArticalName=$dbf->idToField("$ArticleTable",'article',"$ArticalID");
         $tranTable_item_id = $item_transaction_row['itemrow_id'];
         $tranTable_upc = $item_transaction_row['upc'];  
         
         
         $Buyprice = $item_transaction_row['buy_price'];
         $totalitemsbuyprice=$totalitemsbuyprice + $Buyprice;
          

if ($firstpage=="no") {
   $pdf->addPage();
   $pdf->useTemplate($tplidx);
}
$firstpage='no';
       $articletable = "$cfg_tableprefix".'articles';
       $categorytable = "$cfg_tableprefix".'categories';

       $items_tablename="$cfg_tableprefix".'items';
       
       $items_query="SELECT * FROM  $items_tablename WHERE id = $tranTable_item_id";
       $items_result=mysql_query($items_query,$dbf->conn);
       $items_row = mysql_fetch_assoc($items_result);
       
       $article = $dbf->idToField("$articletable",'article',$items_row['article_id']);
       $category = $dbf->idToField("$categorytable",'category',$item_transaction_row['category_id']);


$pdf->SetFont('Arial','',7);   

  
 $pdf->SetXY(6, 40); 

 $pdf->Write(0, $pdf_supplier_name);
  
 $pdf->SetXY(80, 40);
 $pdf->Write(0, $suppliergender);

 
 $pdf->SetXY(95, 40);
 if ($supplierrace == "WHITE/NON-HISPANIC"){ $supplierrace='WHITE';}
 $pdf->Write(0, $supplierrace);


$supplierdob = str_replace("/", "", "$supplierdob");
$supplierdob = str_replace("-", "", "$supplierdob");
$dob_year = substr("$supplierdob",0,4);
$dob_month = substr("$supplierdob",4,2);
$dob_day = substr("$supplierdob",6,2);
$newdob_format="$dob_month".'-'."$dob_day".'-'."$dob_year"; 



$pdf->SetXY(115, 40);
$pdf->Write(0, $newdob_format);
 
$pdf->SetXY(137, 40);

$sheightstring=$supplierheight;
$sfoot=$sheightstring[0];
$sinches=substr($sheightstring, -2); 
$sheight="$sfoot"."'".' '."$sinches".'"';   
 
$pdf->Write(0, $sheight);

$pdf->SetXY(158, 40);
$pdf->Write(0, $supplierweight.' '.'LB');

 
$pdf->SetXY(172, 40);
$pdf->Write(0, $supplierhaircolor);
 

$pdf->SetXY(192, 40);

$pdf->Cell(15,1,$suppliereyescolor); 
 
$pdf->SetXY(6, 48);

$pdf->Write(0, $supplieraddress);  
 
$pdf->SetXY(75, 48);
 
$pdf->Write(0, $suppliercity);  
 
$pdf->SetXY(105, 48);

$pdf->Write(0, $supplierstate);
 
$pdf->SetXY(120, 48);

$pdf->Write(0, $supplierzip); 

$pdf->SetXY(140, 48);

$pdf->Write(0, $supplierdlic);

if ($supplier_row['itisid'] == 'Y') {
   $pdf->SetXY(192, 48);

   $pdf->Write(0, $supplieridstate);
}else{
     $pdf->SetXY(192, 48);

      $pdf->Write(0, $supplierlicstate);
}





$ckmens = '';
$ckwg = '';
$cksilver = '';
$ckring = '';
$ckchain = '';
$ckcharm = '';
$ckwomens = '';
$ckyg = '';
$ckother1 = '';
$ckpendant = '';
$ckbracelet = '';
$ckother2 = '';
$jkindsize = '';
$jnumstone = '';
$jdescription = '';   
$ckwatch = '';   
$jbrandname = '';
$ckwristwatch = '';
$ckwatchpendant = '';
$ckpocketwatch = '';
$cklapelwatch = '';
$jserialnumber = '';
$cktv = '';
$ckmusicins = '';
$ckelectricaltool = '';
$ckcomputer = '';
$ckpowermower = '';
$ckstereo = '';
$ckoutboardmotor = '';
$ckvideoequipment = '';
$ckcdplayer = '';
$ckcellphone = '';
$ckcamera = '';
$cksnowblower = '';
$cktypewriter = '';
$ckcbradio = '';
$ckother3 = '';


$articlecheckboxfound = 'N'; 

$pdf->SetXY(16.5, 80.5);
if (trim($article) == "TV"){$cktv = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $cktv);

$pdf->SetXY(37.5, 80.5);
if (trim($category) == "MUSICAL INSTRUMENT"){$ckmusicins = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckmusicins);

$pdf->SetXY(76.5, 80.5);
if (trim($article) == "ELECTRICAL TOOLS"){$ckelectricaltool = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckelectricaltool);

$pdf->SetXY(113, 80.5);
if (trim($article) == "COMPUTER"){$ckcomputer = 'X'; $articlecheckboxfound = 'Y';}
if (trim($article) == "LAPTOP"){$ckcomputer = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckcomputer);

$pdf->SetXY(145, 80.4);
if (trim($article) == "POWER MOWER"){$ckpowermower = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckpowermower);

$pdf->SetXY(16.5, 85);
if (trim($article) == "STEREO EQUIPMENT/SPEAKERS"){$ckstereo = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckstereo);

$pdf->SetXY(37.3, 85);
if (trim($article) == "OUTBOARD MOTOR"){$ckoutboardmotor = 'X'; $articlecheckboxfound = 'Y';}
$pdf->Write(0, $ckoutboardmotor);

$pdf->SetXY(76.5, 85);
if (trim($article) == "VIDEO EQUIPMENT"){$ckvideoequipment = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckvideoequipment);

$pdf->SetXY(113, 85);
if (trim($article) == "CD PLAYER/DISC"){$ckcdplayer = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckcdplayer);

$pdf->SetXY(145, 85);
if (trim($article) == "CELLPHONE/PDA"){$ckcellphone = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckcellphone);

$pdf->SetXY(16.5, 88.8);
if (trim($article) == "CAMERA"){$ckcamera = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckcamera);

$pdf->SetXY(37.6, 88.8);
if (trim($article) == "SNOW BLOWER"){$cksnowblower = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $cksnowblower);

$pdf->SetXY(76.5, 88.8);
if (trim($article) == "TYPEWRITER"){$cktypewriter = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $cktypewriter);

$pdf->SetXY(113.3, 88.8);
if (trim($article) == "CB RADIO"){$ckcbradio = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckcbradio);

$pdf->SetXY(145, 88.8);
if (trim($article) == "OTHER"){$ckother3 = 'X'; $articlecheckboxfound = 'Y';}

$pdf->Write(0, $ckother3);


if ($articlecheckboxfound == "N"){$ckother3 = 'X';}
$pdf->Write(0, $ckother3);


$pdf->SetXY(16, 97.3);
$pdf->Write(0, $items_row['serialnumber']);

$pdf->SetXY(83, 97.3);
$pdf->Write(0, $items_row['brandname']);

$pdf->SetXY(113.5, 97.3);
$pdf->Write(0, $items_row['itemsize']);

$pdf->SetXY(131, 97.3);
$pdf->Write(0, $items_row['itemcolor']);

$pdf->SetXY(152, 97.3);
$pdf->Write(0, $items_row['itemmodel']);

$pdf->SetXY(16, 105);
$pdf->MultiCell(120,2.5,$items_row['description']);


$pdf->SetXY(6, 260);

$pdf->Write(0, $cfg_company);


$pdf->SetXY(70, 260);

$pdf->Write(0, $cfg_address);


if ($cfg_fingerprint_onpdf=="yes") {


  if ($cfg_data_outside_storedir == "yes") {
     $thumbimagefilename=$supplier_row['imagethumb'];
     $thumbimagefile=$supplierIMGDir.$supplier_row['imagethumb'];
     $thumbimage_extension = getExtension($thumbimagefile);
     $thumbimage_extension = strtolower($thumbimage_extension);
  }else{  
     $thumbimagefile='suppliers/images/'.$supplier_row['imagethumb'];
     $thumbimage_extension = getExtension($thumbimagefile);
     $thumbimage_extension = strtolower($thumbimage_extension);
  }

  
  
	  

     $cryptastic = new cryptastic;

      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	                      die("Failed to generate secret key.");
	if ($cfg_imageZipORnozip == "nozip"){	    
                $msg 			= file_get_contents($supplierIMGDir.$thumbimagefile);
	            $decrypted = $cryptastic->decrypt($msg, $key) or
				             die("Failed to complete decryption Thumb Image");

                   $dencryptedFile 	= $cfg_data_supplierIMGpathdirtemp.$thumbimagefile;
 
	              $fHandle		= fopen($dencryptedFile, 'w+');
	              fwrite($fHandle, $decrypted);
	              fclose($fHandle);


   }else{
        
		$zippedimg=$supplierIMGDir.$thumbimagefilename.'.zip';

		
		exec("unzip -jP $key $zippedimg -d $imageunziptemp", $output1);
		$dencryptedFile=$imageunziptemp.$thumbimagefilename; 
   
   }
				 
	  
	  
  
  
  
  if ((($supplier_row['imagethumb']) != null) || (($supplier_row['imagethumb']) != "")){ 
  
    $pdf->image("$dencryptedFile",180,240,20,30,"$thumbimage_extension");
   }
}


if ($item_transaction_row['totalowner'] == 'Y'){
    $pdf->SetXY(89.6, 164.3);
    $totalowneryes='X'; 
    $pdf->Write(0, $totalowneryes);
}else{
   $pdf->SetXY(101.8, 164.3);
   $totalownerno='X'; 
   $pdf->Write(0, $totalownerno);
}

if ($item_transaction_row['itemfound'] == 'Y'){
    $pdf->SetXY(85.8, 181.5);
    $itemfoundyes='X'; 
    $pdf->Write(0, $itemfoundyes);
	$pdf->SetXY(46, 190);
    $pdf->Write(0, $item_transaction_row['founddesc']); 
}else{
    $pdf->SetXY(98.2, 181.5);
    $itemfoundno='X'; 
    $pdf->Write(0, $itemfoundno);
}


$pdf->SetXY(7.2, 268.2);
$transactiontype_buy='X'; 
$pdf->Write(0, $transactiontype_buy);

$pdf->SetXY(50, 268);

$pdf->Write(0, $itemtrans_id);

$pdf->SetXY(100, 265);

$curdate = date('m-d-Y');
$pdf->Write(0, $curdate);

$pdf->SetXY(140, 265);
$curtime = date('H:i:s');
$pdf->Write(0, $curtime);


$found_itempic='no';
$itemIMGnumber= $itemIMGnumber + 1;
$itempic=$cfg_store_code.$tranTable_item_id;


      $item_gif_file="../je_images/$nopicfile.gif";
	     if(file_exists($item_gif_file)){
         $itempicfile=$item_gif_file;
         $itempicType='gif';

        }   
		  
		  $item_gif_file="images/$itempic.gif";
	     if(file_exists($item_gif_file)){
         $itempicfile=$item_gif_file;
         $itempicType='gif';
         $found_itempic='yes';
        }
	     
	     $item_jpg_file="images/$itempic.jpg";
	     if(file_exists($item_jpg_file)){
         $itempicfile=$item_jpg_file;
         $itempicType='jpg';
         $found_itempic='yes';
        }
		
		   $item_jpeg_file="images/$itempic.jpeg";
	     if(file_exists($item_jpeg_file)){
         $itempicfile=$item_jpeg_file;
         $itempicType='jpeg';
         $found_itempic='yes';
        }
		
		  $item_png_file="images/$itempic.png";
	     if(file_exists($item_png_file)){
         $itempicfile=$item_png_file;
         $itempicType='png';
         $found_itempic='yes';
        }
        
      if ($found_itempic=="yes") {  
         if ($itemIMGnumber == 1){
           $itempicfile1=$itempicfile;
          }
         
         if ($itemIMGnumber == 2){
           $itempicfile2=$itempicfile;
          }
          if ($itemIMGnumber == 3){
           $itempicfile3=$itempicfile;
          }
          if ($itemIMGnumber == 4){
           $itempicfile4=$itempicfile;
          }
          if ($itemIMGnumber == 5){
           $itempicfile5=$itempicfile;
          }
          if ($itemIMGnumber == 6){
           $itempicfile6=$itempicfile;
          }
          if ($itemIMGnumber == 7){
           $itempicfile7=$itempicfile;
          }
          if ($itemIMGnumber == 8){
           $itempicfile8=$itempicfile;
          }
          if ($itemIMGnumber == 9){
           $itempicfile9=$itempicfile;
          }
      }
      

    




}

while($item_transaction_row = mysql_fetch_array($jewelrytransactions_result)) {
        $ArticalID = $item_transaction_row['article_id'];
         $transaction_from_panel = $item_transaction_row['transaction_from_panel'];
         $ArticleTable="$cfg_tableprefix".'articles';
         $ArticalName=$dbf->idToField("$ArticleTable",'article',"$ArticalID");
         $tranTable_item_id = $item_transaction_row['itemrow_id'];
         $tranTable_upc = $item_transaction_row['upc'];  
         
         $Buyprice = $item_transaction_row['buy_price'];
         $totalitemsbuyprice=$totalitemsbuyprice + $Buyprice; 

if ($firstpage=="no") {
   $pdf->addPage();
   $pdf->useTemplate($tplidx);
}
$firstpage='no';
        $articletable = "$cfg_tableprefix".'articles';
        $categorytable = "$cfg_tableprefix".'categories';
       
       
       $article = $dbf->idToField("$articletable",'article',$item_transaction_row['article_id']);
       $category = $dbf->idToField("$categorytable",'category',$item_transaction_row['category_id']);
   


$pdf->SetFont('Arial','',7);   

  
 $pdf->SetXY(6, 40); 

 $pdf->Write(0, $pdf_supplier_name);
  
 $pdf->SetXY(80, 40);
 $pdf->Write(0, $suppliergender);

 
 $pdf->SetXY(95, 40);
 if ($supplierrace == "WHITE/NON-HISPANIC"){ $supplierrace='WHITE';}
 $pdf->Write(0, $supplierrace);


$supplierdob = str_replace("/", "", "$supplierdob");
$supplierdob = str_replace("-", "", "$supplierdob");
$dob_year = substr("$supplierdob",0,4);
$dob_month = substr("$supplierdob",4,2);
$dob_day = substr("$supplierdob",6,2);
$newdob_format="$dob_month".'-'."$dob_day".'-'."$dob_year"; 


$pdf->SetXY(115, 40);
$pdf->Write(0, $newdob_format);
 
$pdf->SetXY(137, 40);
$sheightstring=$supplierheight;

$sfoot=$sheightstring[0];
$sinches=substr($sheightstring, -2); 
$sheight="$sfoot"."'".' '."$sinches".'"';   

$pdf->Write(0, $sheight);

$pdf->SetXY(158, 40);

$pdf->Write(0, $supplierweight.' '.'LB');
 
$pdf->SetXY(172, 40);
 
$pdf->Write(0, $supplierhaircolor);

$pdf->SetXY(192, 40);
 
$pdf->Cell(15,1,$suppliereyescolor);
 
$pdf->SetXY(6, 48);

$pdf->Write(0, $supplieraddress); 
 
$pdf->SetXY(75, 48);
 
 $pdf->Write(0, $suppliercity);
 
$pdf->SetXY(105, 48);

$pdf->Write(0, $supplierstate);
 
$pdf->SetXY(120, 48);
 
$pdf->Write(0, $supplierzip);

$pdf->SetXY(140, 48);

$pdf->Write(0, $supplierdlic);



if ($supplier_row['itisid'] == 'Y') {
   $pdf->SetXY(192, 48);

   $pdf->Write(0, $supplieridstate);
}else{
     $pdf->SetXY(192, 48);

      $pdf->Write(0, $supplierlicstate);
}




$ckmens = '';
$ckwg = '';
$cksilver = '';
$ckring = '';
$ckchain = '';
$ckcharm = '';
$ckwomens = '';
$ckyg = '';
$ckother1 = '';
$ckpendant = '';
$ckbracelet = '';
$ckother2 = '';
$jkindsize = '';
$jnumstone = '';
$jdescription = '';   
$ckwatch = '';   
$jbrandname = '';
$ckwristwatch = '';
$ckwatchpendant = '';
$ckpocketwatch = '';
$cklapelwatch = '';
$jserialnumber = '';
$cktv = '';
$ckmusicins = '';
$ckelectricaltool = '';
$ckcomputer = '';
$ckpowermower = '';
$ckstereo = '';
$ckoutboardmotor = '';
$ckvideoequipment = '';
$ckcdplayer = '';
$ckcellphone = '';
$ckcamera = '';
$cksnowblower = '';
$cktypewriter = '';
$ckcbradio = '';
$ckother3 = '';

$jewelrycheckboxfound = 'N';

$pdf->SetXY(16.2, 53.3);
if ($item_transaction_row['item_gender'] == "MEN'S"){$ckmens = 'X';}

$pdf->Write(0, $ckmens);

$pdf->SetXY(49.8, 52.7);
if ($item_transaction_row['material_type'] == "WHITE GOLD"){$ckwg = 'X';}

$pdf->Write(0, $ckwg);  

$pdf->SetXY(61.6, 52.7);
if ($item_transaction_row['material_type'] == "SILVER"){$cksilver = 'X';}

$pdf->Write(0, $cksilver);    
   
$pdf->SetXY(81.3, 52.7);
if (strtoupper($article) == "RING"){$ckring = 'X'; $jewelrycheckboxfound = 'Y';}

$pdf->Write(0, $ckring);     

$pdf->SetXY(98.5, 52.7);	
if (strtoupper($article) == "CHAIN"){$ckchain = 'X'; $jewelrycheckboxfound = 'Y';}

$pdf->Write(0, $ckchain);  

$pdf->SetXY(118.5, 52.7);
if (strtoupper($article) == "CHARM"){$ckcharm = 'X'; $jewelrycheckboxfound = 'Y';}

$pdf->Write(0, $ckcharm);

$pdf->SetXY(16.2, 57);
if ($item_transaction_row['item_gender'] == "LADIE'S"){$ckwomens = 'X';}

$pdf->Write(0, $ckwomens);
      
$pdf->SetXY(49.8, 57);
if ($item_transaction_row['material_type'] == "YELLOW GOLD"){$ckyg = 'X';}

$pdf->Write(0, $ckyg);      
   
$pdf->SetXY(61.8, 57);
if ($item_transaction_row['material_type'] == "OTHER"){$ckother1 = 'X';}

$pdf->Write(0, $ckother1);      
   
$pdf->SetXY(81.4, 57);
if (strtoupper($article) == "PENDANT"){$ckpendant = 'X'; $jewelrycheckboxfound = 'Y';}

$pdf->Write(0, $ckpendant);   
   
$pdf->SetXY(98.6, 57);
if (strtoupper($article) == "BRACELET"){$ckbracelet = 'X'; $jewelrycheckboxfound = 'Y';}

$pdf->Write(0, $ckbracelet);

$pdf->SetXY(118.5, 57);
if (strtoupper($article) == "OTHER"){$ckother2 = 'X'; $jewelrycheckboxfound = 'Y';}

$pdf->Write(0, $ckother2);


$pdf->SetXY(118.5, 57);
if ($jewelrycheckboxfound == "N"){$ckother2 = 'X';}
$pdf->Write(0, $ckother2);


$pdf->SetXY(145, 57);
if ($item_transaction_row['kindsize'] != ''){$jkindsize = $item_transaction_row['kindsize'];}
$pdf->Write(0, $jkindsize);

$pdf->SetXY(185, 57);
if ($item_transaction_row['numstone'] != ''){$jnumstone = $item_transaction_row['numstone'];}
$pdf->Write(0, $jnumstone);
   
$pdf->SetXY(16.2, 65);
if ($item_transaction_row['description'] != ''){$jdescription = $item_transaction_row['description'];}
$pdf->Write(0, $jdescription);   



if ($category == "Watch"){   
    $pdf->SetXY(16.9, 71.9);
   if (strtoupper($category) == "WATCH"){$ckwatch = 'X';}
      
    $pdf->Write(0, $ckwatch);   

    $pdf->SetXY(35, 75);
   if ($item_transaction_row['brandname'] != ''){$jbrandname = $item_transaction_row['brandname'];}
     $pdf->Write(0, $jbrandname);

      $pdf->SetXY(84.5, 71.5);
   if (strtoupper($article) == "WRIST"){$ckwristwatch = 'X';}

      $pdf->Write(0, $ckwristwatch);

         $pdf->SetXY(106.5, 71.5);
		if (strtoupper($article) == "PENDANT"){$ckwatchpendant = 'X';}

				$pdf->Write(0, $ckwatchpendant);

				$pdf->SetXY(84.5, 76);
		if (strtoupper($article) == "POCKET"){$ckpocketwatch = 'X';}
	
				$pdf->Write(0, $ckpocketwatch);

				$pdf->SetXY(106.5, 76);
		if (strtoupper($article) == "LAPEL"){$cklapelwatch = 'X';}

				$pdf->Write(0, $cklapelwatch);

				$pdf->SetXY(130, 75);
		if ($item_transaction_row['serialnumber'] != ''){$jserialnumber = $item_transaction_row['serialnumber'];}
				$pdf->Write(0, $jserialnumber);
  
}

   

$pdf->SetXY(6, 260);
 
$pdf->Write(0, $cfg_company);


$pdf->SetXY(70, 260);
 
$pdf->Write(0, $cfg_address);


if ($cfg_fingerprint_onpdf=="yes") {


  if ($cfg_data_outside_storedir == "yes") {
     $thumbimagefilename=$supplier_row['imagethumb'];
     $thumbimagefile=$supplierIMGDir.$supplier_row['imagethumb'];
     $thumbimage_extension = getExtension($thumbimagefile);
     $thumbimage_extension = strtolower($thumbimage_extension);
  }else{  
     $thumbimagefile='suppliers/images/'.$supplier_row['imagethumb'];
     $thumbimage_extension = getExtension($thumbimagefile);
     $thumbimage_extension = strtolower($thumbimage_extension);
  }

  
	  

     $cryptastic = new cryptastic;

      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	         die("Failed to generate secret key.");
		
		if ($cfg_imageZipORnozip == "nozip"){
         $msg 			= file_get_contents($supplierIMGDir.$thumbimagefile);
	     $decrypted = $cryptastic->decrypt($msg, $key) or
		        		die("Failed to complete decryption thumb image 2nd location");

            $dencryptedFile 	= $cfg_data_supplierIMGpathdirtemp.$thumbimagefile;
 
	        $fHandle		= fopen($dencryptedFile, 'w+');
	        fwrite($fHandle, $decrypted);
	        fclose($fHandle);

	  }else{
	       $zippedimg=$supplierIMGDir.$thumbimagefilename.'.zip';

		  
		  exec("unzip -jP $key $zippedimg -d $imageunziptemp", $output1);
		  $dencryptedFile=$imageunziptemp.$thumbimagefilename; 

	  }
	  

  
     if ((($supplier_row['imagethumb']) != null) || (($supplier_row['imagethumb']) != "")){ 
         $pdf->image("$dencryptedFile",180,240,20,30,"$thumbimage_extension");
     }
}



if ($item_transaction_row['totalowner'] == 'Y'){
    $pdf->SetXY(89.6, 164.3);
    $totalowneryes='X'; 
    $pdf->Write(0, $totalowneryes);
}else{
   $pdf->SetXY(101.8, 164.3);
   $totalownerno='X'; 
   $pdf->Write(0, $totalownerno);
}

if ($item_transaction_row['itemfound'] == 'Y'){
    $pdf->SetXY(85.8, 181.5);
    $itemfoundyes='X'; 
    $pdf->Write(0, $itemfoundyes);
}else{
    $pdf->SetXY(98.2, 181.5);
    $itemfoundno='X'; 
    $pdf->Write(0, $itemfoundno);
}


$pdf->SetXY(7.2, 268.2);
$transactiontype_buy='X'; 
$pdf->Write(0, $transactiontype_buy);

$pdf->SetXY(50, 268);

$pdf->Write(0, $itemtrans_id);

$pdf->SetXY(100, 265);

$curdate = date('m-d-Y');
$pdf->Write(0, $curdate);

$pdf->SetXY(140, 265);
$curtime = date('H:i:s');
$pdf->Write(0, $curtime);
}




$pdf->SetFont('Arial','',8);
$pdf->SetXY(10, 6);

$text_tab=5;
$text_line=7;
$linenum=1;
$newpageheader_written = 'no';
$dvdrecordfound = 'no'; 
$supplierinfo_printed='no';
$printlicpage=="no"; 
while($item_transaction_row = mysql_fetch_array($dvdtransactions_result)) {

	
         $pdf->SetXY($text_tab, $text_line);
         $ArticalID = $item_transaction_row['article_id'];
         $transaction_from_panel = $item_transaction_row['transaction_from_panel'];
         $ArticleTable="$cfg_tableprefix".'articles';
         $ArticalName=$dbf->idToField("$ArticleTable",'article',"$ArticalID");
         $tranTable_item_id = $item_transaction_row['itemrow_id'];
         $tranTable_upc = $item_transaction_row['upc'];   
         
         $Buyprice = $item_transaction_row['buy_price'];
         $totalitemsbuyprice=$totalitemsbuyprice + $Buyprice;

$linenumber = $linenumber + 1;
if ($supplierinfo_printed=="no") {
   

$pdf->SetFont('Arial','',7);   
 
  
 $pdf->SetXY(6, 40); 

 $pdf->Write(0, $pdf_supplier_name);
  
 $pdf->SetXY(80, 40);

 $pdf->Write(0, $suppliergender);
 
 $pdf->SetXY(95, 40);
 if ($supplierrace == "WHITE/NON-HISPANIC"){ $supplierrace='WHITE';}

 $pdf->Write(0, $supplierrace);
 



$supplierdob = str_replace("/", "", "$supplierdob");
$supplierdob = str_replace("-", "", "$supplierdob");
$dob_year = substr("$supplierdob",0,4);
$dob_month = substr("$supplierdob",4,2);
$dob_day = substr("$supplierdob",6,2);
$newdob_format="$dob_month".'-'."$dob_day".'-'."$dob_year"; 

$pdf->SetXY(115, 40);
$pdf->Write(0, $newdob_format);
 
$pdf->SetXY(137, 40);

$sheightstring=$supplierheight;
$sfoot=$sheightstring[0];
$sinches=substr($sheightstring, -2); 
$sheight="$sfoot"."'".' '."$sinches".'"';   
 
$pdf->Write(0, $sheight);

$pdf->SetXY(158, 40);

$pdf->Write(0, $supplierweight.' '.'LB');
 
$pdf->SetXY(172, 40);

$pdf->Write(0, $supplierhaircolor);

$pdf->SetXY(192, 40);
 
$pdf->Cell(15,1,$suppliereyescolor);
 
$pdf->SetXY(6, 48);

$pdf->Write(0, $supplieraddress); 
 
$pdf->SetXY(75, 48);
 
$pdf->Write(0, $suppliercity);
 
$pdf->SetXY(105, 48);

$pdf->Write(0, $supplierstate);
 
$pdf->SetXY(120, 48);

$pdf->Write(0, $supplierzip); 

$pdf->SetXY(140, 48);

$pdf->Write(0, $supplierdlic);


if ($supplier_row['itisid'] == 'Y') {
   $pdf->SetXY(192, 48);

   $pdf->Write(0, $supplieridstate);
}else{
     $pdf->SetXY(192, 48);

      $pdf->Write(0, $supplierlicstate);
}




$ckmens = '';
$ckwg = '';
$cksilver = '';
$ckring = '';
$ckchain = '';
$ckcharm = '';
$ckwomens = '';
$ckyg = '';
$ckother1 = '';
$ckpendant = '';
$ckbracelet = '';
$ckother2 = '';
$jkindsize = '';
$jnumstone = '';
$jdescription = '';   
$ckwatch = '';   
$jbrandname = '';
$ckwristwatch = '';
$ckwatchpendant = '';
$ckpocketwatch = '';
$cklapelwatch = '';
$jserialnumber = '';
$cktv = '';
$ckmusicins = '';
$ckelectricaltool = '';
$ckcomputer = '';
$ckpowermower = '';
$ckstereo = '';
$ckoutboardmotor = '';
$ckvideoequipment = '';
$ckcdplayer = '';
$ckcellphone = '';
$ckcamera = '';
$cksnowblower = '';
$cktypewriter = '';
$ckcbradio = '';
$ckother3 = '';


$pdf->SetXY(145.2, 88.9);
if (trim($article) == "Other"){$ckother3 = 'X';}
$ckother3 = 'X';
$pdf->Write(0, $ckother3);

$pdf->SetXY(16, 108);

$pdf->Write(0, 'Please see the attached sheet for the DVD title.');

  
 
$pdf->SetXY(6, 260);

$pdf->Write(0, $cfg_company);


$pdf->SetXY(70, 260);

$pdf->Write(0, $cfg_address);


if ($cfg_fingerprint_onpdf=="yes") {


  if ($cfg_data_outside_storedir == "yes") {
     $thumbimagefilename=$supplier_row['imagethumb'];
     $thumbimagefile=$supplierIMGDir.$supplier_row['imagethumb'];
     $thumbimage_extension = getExtension($thumbimagefile);
     $thumbimage_extension = strtolower($thumbimage_extension);
  }else{  
     $thumbimagefile='suppliers/images/'.$supplier_row['imagethumb'];
     $thumbimage_extension = getExtension($thumbimagefile);
     $thumbimage_extension = strtolower($thumbimage_extension);
  }
  
  
	  

     $cryptastic = new cryptastic;

      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	          die("Failed to generate secret key.");
		
		if ($cfg_imageZipORnozip == "nozip"){
          $msg 			= file_get_contents($supplierIMGDir.$thumbimagefile);
	      $decrypted = $cryptastic->decrypt($msg, $key) or
			        	die("Failed to complete decryption thumb image  3rd location");

          $dencryptedFile 	= $cfg_data_supplierIMGpathdirtemp.$thumbimagefile;
 
	      $fHandle		= fopen($dencryptedFile, 'w+');
	      fwrite($fHandle, $decrypted);
	      fclose($fHandle);
	
	   }else{
        $zippedimg=$supplierIMGDir.$thumbimagefilename.'.zip';

		
		 exec("unzip -jP $key $zippedimg -d $imageunziptemp", $output1);
		$dencryptedFile=$imageunziptemp.$thumbimagefilename; 
   
   }

	  
  
 
       if ((($supplier_row['imagethumb']) != null) || (($supplier_row['imagethumb']) != "")){ 
         $pdf->image("$dencryptedFile",180,240,20,30,"$thumbimage_extension");
        }
}


if ($item_transaction_row['totalowner'] == 'Y'){
    $pdf->SetXY(89.6, 164.3);
    $totalowneryes='X'; 
    $pdf->Write(0, $totalowneryes);
}else{
   $pdf->SetXY(101.8, 164.3);
   $totalownerno='X'; 
   $pdf->Write(0, $totalownerno);
}

if ($item_transaction_row['itemfound'] == 'Y'){
    $pdf->SetXY(85.8, 181.5);
    $itemfoundyes='X'; 
    $pdf->Write(0, $itemfoundyes);
}else{
    $pdf->SetXY(98.2, 181.5);
    $itemfoundno='X'; 
    $pdf->Write(0, $itemfoundno);
}

$pdf->SetXY(7.2, 268.2);
$transactiontype_buy='X'; 
$pdf->Write(0, $transactiontype_buy);

$pdf->SetXY(50, 268);

$pdf->Write(0, $itemtrans_id);

$pdf->SetXY(100, 265);

$curdate = date('m-d-Y');
$pdf->Write(0, $curdate);

$pdf->SetXY(140, 265);
$curtime = date('H:i:s');
$pdf->Write(0, $curtime);



$supplierinfo_printed='yes';
}



if ($dvdrecordfound == "no"){
    $pdf->addPage();
    $pdf->SetFont('Arial','',7);
    $pdf->SetXY(2, 2);
    $curdatetime = $curdate.'  '.$curtime;
 
    $pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
    $pdf->SetXY(1, 3);
    $pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
	
    $dvdrecordfound='yes';
 }

$maxline=$text_line;
if ($maxline <= 270) { 

   if ($ArticalName == "Video DVD") {

       
       $dvd_query = "SELECT * FROM  dvd_catalog WHERE upc = $tranTable_upc";
       $dvd_result = mysql_query($dvd_query,$commondbf->conn);
       $dvd_row = mysql_fetch_assoc($dvd_result);
      

       $dvdtitle=$linenum.'- '.'DVD Title: '.$dvd_row['title'];
       $pdf->SetXY($text_tab, $text_line);
       $pdf->Write(0, $dvdtitle);
       
       $linenum=$linenum + 1;
       $text_line = $text_line + 3;
         
   }else if ($ArticalName == "Game DVD") {

        $vgdvd_query="SELECT * FROM  gamedvd_catalog WHERE upc = $tranTable_upc";
        $vgdvd_result=mysql_query($vgdvd_query,$commondbf->conn);
        $vgdvd_row = mysql_fetch_assoc($vgdvd_result);
          
       $vgdvdtitle=$linenum.'- '.'Game DVD Title: '.$vgdvd_row['title'];
       $pdf->SetXY($text_tab, $text_line);
       $pdf->Write(0, $vgdvdtitle);
       
       $linenum=$linenum + 1;
       $text_line = $text_line + 3;
 


}
}else{
	
	
$text_tab=5;
$text_line=7;

    $pdf->addPage();
    $pdf->SetFont('Arial','',7);
    $pdf->SetXY(2, 2);
    $curdatetime = $curdate.'  '.$curtime;
 
    $pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
    $pdf->SetXY(1, 3);
    $pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
	
$maxline=$text_line;
if ($maxline <= 270) { 

   if ($ArticalName == "Video DVD") {
 
       
       $dvd_query = "SELECT * FROM  dvd_catalog WHERE upc = $tranTable_upc";
       $dvd_result = mysql_query($dvd_query,$commondbf->conn);
       $dvd_row = mysql_fetch_assoc($dvd_result);
      

       $dvdtitle=$linenum.'- '.'DVD Title: '.$dvd_row['title'];
       $pdf->SetXY($text_tab, $text_line);
       $pdf->Write(0, $dvdtitle);
       
       $linenum=$linenum + 1;
       $text_line = $text_line + 3;
         
   }else if ($ArticalName == "Game DVD") {

        $vgdvd_query="SELECT * FROM  gamedvd_catalog WHERE upc = $tranTable_upc";
        $vgdvd_result=mysql_query($vgdvd_query,$commondbf->conn);
        $vgdvd_row = mysql_fetch_assoc($vgdvd_result);
          
       $vgdvdtitle=$linenum.'- '.'Game DVD Title: '.$vgdvd_row['title'];
       $pdf->SetXY($text_tab, $text_line);
       $pdf->Write(0, $vgdvdtitle);
       
       $linenum=$linenum + 1;
       $text_line = $text_line + 3;	
}	
}	
}	
}


$printitempicsnextpage='no';
$licprintedalready='no';

if (($maxline < 250) && ($dvdrecordfound=="yes")){
     if ($licpicType != ''){

		
		
	  

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
        $zippedimg=$supplierIMGDir.$licfilename.'.zip';
 
		
		exec("unzip -jP $key $zippedimg -d $imageunziptemp", $output1);
		$dencryptedFile=$imageunziptemp.$licfilename; 
   
   }

	  
		
		
          $pdf->image("$dencryptedFile",4,$text_line,100,50,"$licpicType");
		  
		  $printitempicsnextpage='yes';
          $licprintedalready='yes';		

		  
          if ($cfg_supplierImage_onpdf=="yes") {
              if ((($supplier_row['imagecust']) != null) || (($supplier_row['imagecust']) != "")){ 
	          $pdf->image("$dencryptedsupplierpicFile",106,$text_line,50,50,"$supplierpicType");
	
              }
          }
		  
		  
      }	
}else{
    $printlicpage='yes';
}	



if ($dvdrecordfound=="no" || $printlicpage=="yes" || $printitempicsnextpage == "yes"){



if ($licprintedalready=="no"){ 
$pdf->addPage();
$pdf->SetFont('Arial','',7);
$pdf->SetXY(2, 2);
$curdatetime = $curdate.'  '.$curtime;

$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
}	
     if ($licpicType != ''){

          
		  
		  
		  
		  
		  if ($printitempicsnextpage == "no" || $printlicpage=="yes" ){ 
		  
		     
	  

     $cryptastic = new cryptastic;

      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	          die("Failed to generate secret key.");
	 if ($cfg_imageZipORnozip == "nozip"){	
        $msg 			= file_get_contents($supplierIMGDir.$licfilename);
	    $decrypted = $cryptastic->decrypt($msg, $key) or
		    		die("Failed to complete decryption Lic image 2 location");

         $dencryptedFile 	= "$cfg_data_csapdf_pathdir/temp/$licfilename";
 
	     $fHandle		= fopen($dencryptedFile, 'w+');
	      fwrite($fHandle, $decrypted);
	      fclose($fHandle);
	
	  }else{
        $zippedimg=$supplierIMGDir.$licfilename.'.zip';

		
		 exec("unzip -jP $key $zippedimg -d $imageunziptemp", $output1);
		$dencryptedFile=$imageunziptemp.$licfilename; 
   
   }

	  

		    		  
		    $pdf->image("$dencryptedFile",4,15,100,50,"$licpicType");
		  
		  
          if ($cfg_supplierImage_onpdf=="yes") {
              if ((($supplier_row['imagecust']) != null) || (($supplier_row['imagecust']) != "")){ 
	          $pdf->image("$dencryptedsupplierpicFile",106,15,50,50,"$supplierpicType");
	
              }
          }
		  
		  
		  
		  
		  }
      }	
      
      
	  
    if ($cfg_itemimg_onpdf == 'yes'){  
      $piccount =1;
      $pictab = 106;
      $picrow = 15;
 
      while($imageforprinting_row = mysql_fetch_array($imagesforprinting_result)) {

                  
                   $ItemImageName = $imageforprinting_row['item_image'];
				   $ItemImageName=rtrim($ItemImageName);
				   $ItemImageName=ltrim($ItemImageName);

		if ($ItemImageName != null || $ItemImageName != "" ){ 
		
					if ($cfg_data_outside_storedir == "yes"){
                        $ItemImageName=$cfg_data_itemIMGpathdir.$ItemImageName;
                    }else{
	                    $ItemImageName="images/".$ItemImageName;
                    }
					
				
              if ($printitempicsnextpage == "no" || $printlicpage=="yes" ){              

                  if ($piccount == 1){$pictab = 4; $picrow = 70;}
                  if ($piccount == 2){$pictab = 106; $picrow = 70;}
                  if ($piccount == 3){$pictab = 4; $picrow = 125;}
                  if ($piccount == 4){$pictab = 106; $picrow = 125;}
                  if ($piccount == 5){$pictab = 4; $picrow = 180;}
                  if ($piccount == 6){$pictab = 106; $picrow = 180;}
                  if ($piccount == 7){$pictab = 4; $picrow = 235;}
                  if ($piccount == 8){$pictab = 106; $picrow = 235;}
				}else{

                  if ($piccount == 1){$pictab = 4; $picrow = 70;}
                  if ($piccount == 2){$pictab = 106; $picrow = 70;}
                  if ($piccount == 3){$pictab = 4; $picrow = 125;}
                  if ($piccount == 4){$pictab = 106; $picrow = 125;}
                  if ($piccount == 5){$pictab = 4; $picrow = 180;}
                  if ($piccount == 6){$pictab = 106; $picrow = 180;}
                  if ($piccount == 7){$pictab = 4; $picrow = 235;}
				  if ($piccount == 8){$pictab = 106; $picrow = 235;}
				}				
                  
if ($piccount == 9){$pictab = 4; $picrow = 15;
$pdf->addPage();
$pdf->SetFont('Arial','',7);
$pdf->SetXY(2, 2);
$curdatetime = $curdate.'  '.$curtime;

$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
}
                  
                  if ($piccount == 10){$pictab = 106; $picrow = 15;}
                  if ($piccount == 11){$pictab = 4; $picrow = 70;}
                  if ($piccount == 12){$pictab = 106; $picrow = 70;}
                  if ($piccount == 13){$pictab = 4; $picrow = 125;}
                  if ($piccount == 14){$pictab = 106; $picrow = 125;}
                  if ($piccount == 15){$pictab = 4; $picrow = 180;}
                  if ($piccount == 16){$pictab = 106; $picrow = 180;}
                  if ($piccount == 17){$pictab = 4; $picrow = 235;}
                  if ($piccount == 18){$pictab = 106; $picrow = 235;}
                  
if ($piccount == 19){$pictab = 4; $picrow = 15;
$pdf->addPage();
$pdf->SetFont('Arial','',7);
$pdf->SetXY(2, 2);
$curdatetime = $curdate.'  '.$curtime;
 
$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
}
                  
                  
                  
                  if ($piccount == 20){$pictab = 106; $picrow = 15;}
                  if ($piccount == 21){$pictab = 4; $picrow = 70;}
                  if ($piccount == 22){$pictab = 106; $picrow = 70;}
                  if ($piccount == 23){$pictab = 4; $picrow = 125;}
                  if ($piccount == 24){$pictab = 106; $picrow = 125;}
                  if ($piccount == 25){$pictab = 4; $picrow = 180;}
                  if ($piccount == 26){$pictab = 106; $picrow = 180;}
                  if ($piccount == 27){$pictab = 4; $picrow = 235;}
                  if ($piccount == 28){$pictab = 106; $picrow = 235;}
if ($piccount == 29){$pictab = 4; $picrow = 15;
$pdf->addPage();
$pdf->SetFont('Arial','',7);
$pdf->SetXY(2, 2);
$curdatetime = $curdate.'  '.$curtime;

$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
}
                  if ($piccount == 30){$pictab = 106; $picrow = 15;}
                  if ($piccount == 31){$pictab = 4; $picrow = 70;}
                  if ($piccount == 32){$pictab = 106; $picrow = 70;}
                  if ($piccount == 33){$pictab = 4; $picrow = 125;}
                  if ($piccount == 34){$pictab = 106; $picrow = 125;}
                  if ($piccount == 35){$pictab = 4; $picrow = 180;}
                  if ($piccount == 36){$pictab = 106; $picrow = 180;}
                  if ($piccount == 37){$pictab = 4; $picrow = 235;}
                  if ($piccount == 38){$pictab = 106; $picrow = 235;}   
                  if ($ItemImageName <> ""){
                     $pdf->image("$ItemImageName","$pictab","$picrow",100,50,"$itempicType");
                     $piccount= $piccount + 1;
                  }
                  
      }
    }
  }
   
}	




$sapdf_file="$pdfwith_id_path/saleagreement.pdf";
if(file_exists($sapdf_file)){
         unlink($sapdf_file);
        } 



$pdf_file_name=$itemtrans_id."-$supplier_id-".date('mdY-His').'.pdf';


 

   $pdf->Output("$pdfwith_id_path/$pdf_file_name", 'F'); 
  }
  







  
  
ob_implicit_flush(true);
echo "\n"; 
echo "<center><FONT COLOR=blue><b>Creating Sale Agreement PDF.</b></FONT></center>";
for($i=0; $i<8; $i++) {
    
    echo "<span style='width:20px; background:blue'> </span>";
    
    for($k = 0; $k < 40000; $k++)

        echo ' '; 

}
echo "\n"; 

  





  






if ($cfg_create_check == 'yes' && $onlysa == "no" ){

$nwords = array(    "zero", "one", "two", "three", "four", "five", "six", "seven", 
                     "eight", "nine", "ten", "eleven", "twelve", "thirteen", 
                     "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", 
                     "nineteen", "twenty", 30 => "thirty", 40 => "forty", 
                     50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty", 
                     90 => "ninety" ); 

function int_to_words($x) 
{ 
     global $nwords; 
     if(!is_numeric($x)) 
     { 
         $w = '#'; 
     }else if(fmod($x, 1) != 0) 
     { 
         $w = '#'; 
     }else{ 
         if($x < 0) 
         { 
             $w = 'minus '; 
             $x = -$x; 
         }else{ 
             $w = ''; 
         } 
         if($x < 21) 
         { 
             $w .= $nwords[$x]; 
         }else if($x < 100) 
         { 
             $w .= $nwords[10 * floor($x/10)]; 
             $r = fmod($x, 10); 
             if($r > 0) 
             { 
                 $w .= '-'. $nwords[$r]; 
             } 
         } else if($x < 1000) 
         { 
             $w .= $nwords[floor($x/100)] .' hundred'; 
             $r = fmod($x, 100); 
             if($r > 0) 
             { 
                 $w .= ' and '. int_to_words($r); 
             } 
         } else if($x < 1000000) 
         { 
             $w .= int_to_words(floor($x/1000)) .' thousand'; 
             $r = fmod($x, 1000); 
             if($r > 0) 
             { 
                 $w .= ' '; 
                 if($r < 100) 
                 { 
                     $w .= 'and '; 
                 } 
                 $w .= int_to_words($r); 
             } 
         } else { 
             $w .= int_to_words(floor($x/1000000)) .' million'; 
             $r = fmod($x, 1000000); 
             if($r > 0) 
             { 
                 $w .= ' '; 
                 if($r < 100) 
                 { 
                     $word .= 'and '; 
                 } 
                 $w .= int_to_words($r); 
             } 
         } 
     } 
     return $w; 
} 


    $pdf =& new FPDI(); 

  
   $pagecount = $pdf->setSourceFile('blank.pdf');   
 
   $tplidx = $pdf->importPage(1, '/ArtBox');


$pdf->addPage(); 
$pdf->useTemplate($tplidx);
  
$pdf->SetFont('Arial','',7);



     
     $tamount= $totalitemsbuyprice;
     
     
     $pos = strpos($tamount, '.', 1); 
	 $pos=ltrim($pos);
	 $pos=rtrim($pos);
	 
	 if ($pos != ""){
	 
	   $dollaramount=substr($tamount,0,$pos);
        $cents=substr($tamount,$pos+1,2);
         

	 
        $w = int_to_words($dollaramount);
        $dollaramount=$w;
     
        $w = int_to_words($cents);
        $cents=$w;
	 }else{ 

	 
        $w = int_to_words($tamount);
        $dollaramount=$w;
        
		$cents='0';
        $w = int_to_words($cents);
        $cents=$w;
		
		$tamount=$tamount.'.00';
		
	}	
        
	 
    
    $usertablename = $cfg_tableprefix.'users';

    $username= $dbf->idToField($usertablename,'username',$_SESSION['session_user_id']);
   
     
     
     $checkprint_tablename="$cfg_tableprefix".'checkprinting_coordinates';
     $checkprint_query="SELECT * FROM $checkprint_tablename where id = 1";
	 $checkprint_result=mysql_query($checkprint_query,$dbf->conn);
     $checkprint_row = mysql_fetch_assoc($checkprint_result);
     $datexpos = $checkprint_row['date_xpos'];
     $dateypos = $checkprint_row['date_ypos'];
     $namexpos = $checkprint_row['name_xpos'];
     $nameypos = $checkprint_row['name_ypos'];
     $amountinwordsxpos = $checkprint_row['amount_inwords_xpos'];
     $amountinwordsypos = $checkprint_row['amount_inwords_ypos'];
     $amountxpos = $checkprint_row['amount_xpos'];
     $amountypos = $checkprint_row['amount_ypos'];
     $notexpos = $checkprint_row['note_xpos'];
     $noteypos = $checkprint_row['note_ypos'];
     
     $pdf->SetFont('Arial','',7);
     $pdf->SetXY($datexpos, $dateypos);
     $curdate = date('m-d-Y');
     $pdf->Write(0, $curdate);
     
     $pdf->SetFont('Arial','',7);
     $pdf->SetXY($namexpos, $nameypos);
     $pdf->Write(0, $checkpdf_supplier_name);
     
     $pdf->SetFont('Arial','',7);
     $pdf->SetXY($amountinwordsxpos, $amountinwordsypos); 
     $pdf->Write(0, $dollaramount . ' dollars and '. $cents . ' Cents');
     
     $pdf->SetFont('Arial','',7);
     $pdf->SetXY($amountxpos, $amountypos);
     $pdf->Write(0, $tamount); 
     
     $pdf->SetFont('Arial','',7);
     $pdf->SetXY($notexpos, $noteypos);
     $pdf->Write(0, 'Transaction Number: '.$itemtrans_id); 
     
     
     
     
     if ($cfg_data_outside_storedir == "yes"){
	    $checkpdf_pathandname="$cfg_data_storePDFDataTempDir/printcheck_$username.pdf";

	 }else{
	    $checkpdf_pathandname="saleagreements/printcheck_$username.pdf";
     }
	 $pdf->Output("$checkpdf_pathandname", 'F');
    
    
     $checknumber_tablename="$cfg_tableprefix".'checknumber';
     $currentchecknumber_query="SELECT * FROM $checknumber_tablename where id = 1";
		 $checknumber_result=mysql_query($currentchecknumber_query,$dbf->conn);
     $checknumber_row = mysql_fetch_assoc($checknumber_result);
     $usechecknumber = $checknumber_row['next_check_number'];
     $bankname=$checknumber_row['bank_name'];
     $nextchecknumber = $usechecknumber + 1; 
     $checkid=1;
     $field_names=array('next_check_number');
	   $field_data=array("$nextchecknumber");	
	
    $dbf->update($field_names,$field_data,$checknumber_tablename,$checkid,true); 
    
    $curdate = date("Y-m-d");
    $printedchecks_tablename="$cfg_tableprefix".'printed_checks'; 
    $pcheckfield_names=array('checknumber','supplierid','transactionid','checkamount','bankname','date');
	  $pcheckfield_data=array("$usechecknumber","$supplier_id","$itemtrans_id","$tamount","$bankname","$curdate");	
	  
	  $dbf->insert($pcheckfield_names,$pcheckfield_data,$printedchecks_tablename,false); 
		        
	}
    





               
            
            $store_prefix = substr("$cfg_tableprefix", 0, -1);  
            
            
            
            


if($_SERVER['HTTPS']){ 

$full_url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];



$QuestionMarkPos = strpos($full_url, '?', 1);
$needed_url_lenght=$QuestionMarkPos - 28; 
$url=substr($full_url,0,$needed_url_lenght);
$saleagreementpdf="https://".$url.'/'.$pdfwith_id_path.$pdf_file_name;
$saleagreementpdftmp="https://".$url.'/'.$pdfwith_id_pathtmp.$pdf_file_name;
$printcheckpdf="https://".$url.'/'.$checkpdf_pathandname;

}else{ 

$full_url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$QuestionMarkPos = strpos($full_url, '?', 1);
$needed_url_lenght=$QuestionMarkPos - 28; 
$url=substr($full_url,0,$needed_url_lenght);
$saleagreementpdf="http://".$url.'/'.$pdfwith_id_path.$pdf_file_name;
$saleagreementpdftmp="http://".$url.'/'.$pdfwith_id_pathtmp.$pdf_file_name;
$printcheckpdf="http://".$url.'/'.$checkpdf_pathandname;

} 
                      

				

				
				
              if ($onlycheck == "no"){
               echo "<br>"; 
               echo "<center>Sale Agreement form created for this Transaction.</center>";
               echo "<center>Number of items in this transaction: $num_rows</center>";
               echo "<center>Click the button below to view and print PDF</center>";
               echo "<br><br>";
               echo "<center><a href=\"$saleagreementpdftmp\" target=\"_blank\"><img src=\"../je_images/btgray_viewprint_saleagreement.png\" onmouseover=\"this.src='../je_images/btgray_viewprint_saleagreement_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_viewprint_saleagreement.png';\" BORDER='0'></a></center><br>"; 
			  
             }else{
			 
			    if ($cfg_create_check == "yes" && $onlysa == "no"){
			    echo "<br>"; 
                echo "<center>Check PDF created for this Transaction.</center>";
                echo "<center>Number of items in this transaction: $num_rows</center>";
                echo "<center>Click the Link below to view and print Check</center>";
                echo "<br><br>";
			 }else{
			     echo "<center>Check creating is turned off.</center>";
				 echo "<center>Setup checks before turning it ON.</center>";
			 }
			 }
			 
             
             if ($cfg_create_check == "yes" && $onlysa == "no"){
 
              echo "<center><a href=\"$printcheckpdf\" target=\"_blank\">Click here to View and Print Check</a><center>";
              echo "<center> Check#: $usechecknumber For Amount: $tamount<center>";
			  echo "<br><br>";
            }
            
			if ($onlycheck == "no" && $onlysa == "no"){
              echo "<center><a href=\"create_barcodePDF_code39.php?&working_on_id=$supplier_id&active_trans_id=$itemtrans_id\">Click here to Create Items Barcode</a><center>";
            }      
      
     


  
	}
		
		
		
$dbf->closeDBlink();
$commondbf->closeDBlink();






      $encryptPath = $pdfwith_id_path;
      $cryptastic = new cryptastic;

      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	         die("Failed to generate secret key.");
	
	  $filenameIn = $pdfwith_id_pathtmp.$pdf_file_name;
    
	if ($cfg_imageZipORnozip == "nozip"){
	      $msg 			= file_get_contents($filenameIn);
	      $encrypted	= $cryptastic->encrypt($msg, $key) or
			     		  die("Failed to complete encryption.");

          $encryptedFile 	= $encryptPath.$pdf_file_name;
 
	      $fHandle		= fopen($encryptedFile, 'w+');
	      fwrite($fHandle, $encrypted);
	      fclose($fHandle);

	}else{
	
       $zippedpdf =$encryptPath.$pdf_file_name.'.zip';
	   $unzippedpdf =$encryptPath.$pdf_file_name;


	   exec("zip -jP $key $zippedpdf  $unzippedpdf  >/dev/null 0"); 
	   exec ("chmod o-rwx $zippedpdf"); 
	   system ("chmod o-rwx $unzippedpdf"); 
	   exec ("mv -f  $unzippedpdf $cfg_data_storePDFDataTempDir"); 
	   

	   
   }
				 
				 



$delimagefiles= $imageunziptemp.$cfg_store_code.'*';

exec("rm -f $delimagefiles");



?>


</body>
</html>
