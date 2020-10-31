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
				$itemtransactions_query="SELECT * FROM $transactions_tablename where transaction_id = $itemtrans_id ";
				$itemtransactions_result=mysql_query($itemtransactions_query,$dbf->conn);
	
				
               
				$selectimageforprinting_query="SELECT * FROM $transactions_tablename where transaction_id = $itemtrans_id and (transaction_from_panel = 'additem' or transaction_from_panel = 'jewelry')";
				$imagesforprinting_result=mysql_query($selectimageforprinting_query,$dbf->conn);
				
				$selectitemimageloaded_query="SELECT item_image FROM $transactions_tablename WHERE item_image <> ''AND transaction_id = $itemtrans_id and (transaction_from_panel = 'additem' or transaction_from_panel = 'jewelry')";
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
            }
			
			if ($cfg_data_outside_storedir == "yes") {
               $dirname = "$supplier_id";     
               $pdf_filedir = "$cfg_data_csapdf_pathdir/{$dirname}/";     
     
               if (file_exists($pdf_filedir)) {     
                       
                } else {     
                  mkdir("$cfg_data_csapdf_pathdir/{$dirname}", 0775);    
                      
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
		  
		  $custimagefile=$supplierIMGDir.$supplier_row['imagecust'];
		  $custfilename=$supplier_row['imagecust'];
          $custimage_extension = getExtension($custimagefile);
          $custpicType = strtolower($custimage_extension);
		  $custpic= $custimagefile;
		
		}else{
		  $licimagefile='suppliers/images/'.$supplier_row['imagelic'];
          $licimage_extension = getExtension($licimagefile);
          $licpicType = strtolower($licimage_extension);
		  $licpic= $licimagefile;
		  
		  $custimagefile='suppliers/images/'.$supplier_row['imagecust'];
          $custimage_extension = getExtension($custimagefile);
          $custpicType = strtolower($custimage_extension);
		  $custpic= $custimagefile;
		 }  
	  

  
    $pdf =& new FPDI();   
  
    $pagecount = $pdf->setSourceFile('saleagreement.pdf');   
 
   $tplidx = $pdf->importPage(1, '/ArtBox');

  
    $pdf->addPage(); 


     $pdf->useTemplate($tplidx);
    
    
 

 $pdf->SetFont('Arial','',12);
 $pdf->SetXY(6, 14);
 $pdf->Cell(150,0, $cfg_address); 

 
 $pdf->SetFont('Arial','',14);
 $pdf->SetXY(11, 22);
 $pdf->Cell(20,0, $cfg_phone); 

 
 $pdf->SetFont('Arial','',7);   

  
 $pdf->SetXY(4, 41); 

 $pdf->Write(0, $pdf_supplier_name);
  
 $pdf->SetXY(80, 41);

 $pdf->Write(0, $suppliergender);
 
 $pdf->SetXY(90, 41);
 if ($supplierrace == "WHITE/NON-HISPANIC"){ $supplierrace='WHITE';}

 $pdf->Write(0, $supplierrace);
 



$supplierdob = str_replace("/", "", "$supplierdob");
$supplierdob = str_replace("-", "", "$supplierdob");
$dob_year = substr("$supplierdob",0,4);
$dob_month = substr("$supplierdob",4,2);
$dob_day = substr("$supplierdob",6,2);
$newdob_format="$dob_month".'-'."$dob_day".'-'."$dob_year"; 

$pdf->SetXY(105, 41);
$pdf->Write(0, $newdob_format);
 
$pdf->SetXY(132, 41);

$sheightstring=$supplierheight;
$sfoot=$sheightstring[0];
$sinches=substr($sheightstring, -2); 
$sheight="$sfoot"."'".' '."$sinches".'"';   

$pdf->Write(0, $sheight);

$pdf->SetXY(148, 41);

$pdf->Write(0, $supplierweight.' '.'LB');
 
$pdf->SetXY(165, 41);
 
$pdf->Write(0, $supplierhaircolor);

$pdf->SetXY(190, 41);
 
$pdf->Cell(15,1,$suppliereyescolor);
 
$pdf->SetXY(4, 52);

$pdf->Write(0, $supplieraddress); 
 
$pdf->SetXY(80, 52);
 
$pdf->Write(0, $suppliercity);
 
$pdf->SetXY(109, 52);

$pdf->Write(0, $supplierstate);
 
$pdf->SetXY(130, 52);

$pdf->Write(0, $supplierzip); 

$pdf->SetXY(150, 52);

$pdf->Write(0, $supplierdlic);

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

	  
$pdf->image("$dencryptedFile",25,180,100,50,"$licpicType");

}

if ($cfg_supplierImage_onpdf=="yes") {
if ($custpicType != ''){

	 
     $cryptastic = new cryptastic;

      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	          die("Failed to generate secret key.");
	if ($cfg_imageZipORnozip == "nozip"){	
           $msg 			= file_get_contents($supplierIMGDir.$custfilename);
	       $decrypted = $cryptastic->decrypt($msg, $key) or
			         	die("Failed to complete decryption supplier image");

           $dencryptedFile 	= "$cfg_data_csapdf_pathdir/temp/$custfilename";
 
	       $fHandle		= fopen($dencryptedFile, 'w+');
	        fwrite($fHandle, $decrypted);
	        fclose($fHandle);
	
	  }else{
        $zippedimg=$supplierIMGDir.$custfilename.'.zip';
		
		exec("unzip -jP $key $zippedimg -d $imageunziptemp", $output1);
		$dencryptedFile=$imageunziptemp.$custfilename; 
        
   }

	  
$pdf->image("$dencryptedFile",130,180,50,50,"$custpicType");
}
} 

$pdf->SetXY(45, 269);

$pdf->Write(0, $itemtrans_id);

$pdf->SetXY(138, 269);
$curdatetime = date('m-d-Y H:i:s');
$pdf->Write(0, $curdatetime);


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

		$pdf->image("$dencryptedFile",140,200,20,30,"$thumbimage_extension");
      }
		
}

$num_rows = mysql_num_rows($itemtransactions_result); 


$pdf->SetFont('Arial','',7.5);
$pdf->SetXY(18, 57.7);
$text_tab=12;
$text_line=60;
$linenum=1;
$newpageheader_written = 'no';

$totalitemsbuyprice=0;
$writen_once='no';
while($item_transaction_row = mysql_fetch_array($itemtransactions_result)) {
         $pdf->SetXY($text_tab, $text_line);
         $ArticalID = $item_transaction_row['article_id'];
         $transaction_from_panel = $item_transaction_row['transaction_from_panel'];
         $ArticleTable="$cfg_tableprefix".'articles';
         $ArticalName=$dbf->idToField("$ArticleTable",'article',"$ArticalID");
         $tranTable_item_id = $item_transaction_row['itemrow_id'];
         $tranTable_upc = $item_transaction_row['upc']; 
         
         
         $Buyprice = $item_transaction_row['buy_price'];
         $totalitemsbuyprice=$totalitemsbuyprice + $Buyprice;



if ($writen_once=='no') {
if ($item_transaction_row['totalowner'] == 'Y'){
    $pdf->SetXY(74.2, 146);
    $totalowneryes='X'; 
    $pdf->Write(0, $totalowneryes);
}else{
   $pdf->SetXY(86.2, 146);
   $totalownerno='X'; 
   $pdf->Write(0, $totalownerno);
}

if ($item_transaction_row['itemfound'] == 'Y'){
    $pdf->SetXY(70, 163.2);
    $itemfoundyes='X'; 
    $pdf->Write(0, $itemfoundyes);
	$pdf->SetXY(42, 172);
    $pdf->Write(0, $item_transaction_row['founddesc']); 
}else{
    $pdf->SetXY(83, 163.2);
    $itemfoundno='X'; 
    $pdf->Write(0, $itemfoundno);
}
$writen_once='yes';
$pdf->SetXY($text_tab, $text_line);
}



$maxline=$text_line;
if ($maxline <= 120) { 

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

   
   }else if ($transaction_from_panel == "jewelry") {
        $articletable = "$cfg_tableprefix".'articles';
       
       $article = $dbf->idToField("$articletable",'article',$item_transaction_row['article_id']);
       
   
       if ($item_transaction_row['brandname'] != ''){$ibrand = 'Brand: '.$item_transaction_row['brandname'];}
       if ($item_transaction_row['itemmodel'] != ''){$imodel = 'Model: '.$item_transaction_row['itemmodel'];} 
       if ($item_transaction_row['material_type'] != ''){$itype = 'Type: '.$item_transaction_row['material_type'];}
       if ($item_transaction_row['serialnumber'] != ''){$iserial = 'Serial#: '.$item_transaction_row['serialnumber'];}
       if ($item_transaction_row['kindsize'] != ''){$ikind = 'Size: '.$item_transaction_row['kindsize'];}
       if ($item_transaction_row['numstone'] != '0'){$inumofstones = '# Of stons: '.$item_transaction_row['numstone'];}
        

        
        $itemdetail=$linenum.'- '.$article.' '.$itype.' '.$ibrand.' '.$imodel.' '.$ikind.' '.$iserial.' '.$inumofstones;
         

       
       $pdf->Write(0, $itemdetail);
       $defalut_text_tab = $text_tab;
       $text_tab=$text_tab + 3;  
       $text_line = $text_line + 3;
       
       $jewelrydisc='Description: '.$item_transaction_row['description'];
       $pdf->SetXY($text_tab, $text_line);
       $pdf->Write(0, $jewelrydisc);
       
       $text_tab=$defalut_text_tab;
       $linenum=$linenum + 1;  
       $text_line = $text_line + 5; 
   }else{

       $articletable = "$cfg_tableprefix".'articles';

       $items_tablename="$cfg_tableprefix".'items';
       
       $items_query="SELECT * FROM  $items_tablename WHERE id = $tranTable_item_id";
       $items_result=mysql_query($items_query,$dbf->conn);
       $items_row = mysql_fetch_assoc($items_result);
       
       $article = $dbf->idToField("$articletable",'article',$items_row['article_id']);

   
       if ($items_row['brandname'] != ''){$ibrand = 'Brand: '.$items_row['brandname'];}
       if ($items_row['itemmodel'] != ''){$imodel = 'Model: '.$items_row['itemmodel'];} 
       if ($items_row['itemcolor'] != ''){$icolor = 'color: '.$items_row['itemcolor'];}
       if ($items_row['itemsize'] != ''){$isize = 'Size: '.$items_row['itemsize'];}
       if ($items_row['serialnumber'] != ''){$iserial = 'Serial#: '.$items_row['serialnumber'];}
       if ($items_row['kindsize'] != ''){$ikind = 'Kind: '.$items_row['kindsize'];}
       if ($items_row['numstone'] != '0'){$inumofstones = '# Of stons: '.$items_row['numstone'];}
        
        $itemdetail=$linenum.'- '.$article.' '.$ibrand.' '.$imodel.' '.$icolor.' '.$isize.' '.$iserial.' '.$ikind.' '.$inumofstones;
          

       
       $pdf->Write(0, $itemdetail);
       $defalut_text_tab = $text_tab;
       $text_tab=$text_tab + 3;  
       $text_line = $text_line + 3;
       
       $itemdisc='Description: '.$items_row['description'];
       $pdf->SetXY($text_tab, $text_line);
       $pdf->Write(0, $itemdisc);
       
       $text_tab=$defalut_text_tab;
       $linenum=$linenum + 1;  
       $text_line = $text_line + 5; 

  }            


}else{ 

if ($newpageheader_written == "no"){

$pdf->addPage();
$pdf->SetXY(2, 2);
 
$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');

$text_tab=5;
$text_line=8;
#$linenum=1;
$newpageheader_written = 'yes';
}

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
     



   }else{

       $articletable = "$cfg_tableprefix".'articles';
       $articletypetable = "$cfg_tableprefix".'articletypes';
       $items_tablename="$cfg_tableprefix".'items';
       
       $items_query="SELECT * FROM  $items_tablename WHERE id = $tranTable_item_id";
       $items_result=mysql_query($items_query,$dbf->conn);
       $items_row = mysql_fetch_assoc($items_result);
       
       $article = $dbf->idToField("$articletable",'article',$items_row['article_id']);
       $articletype = $dbf->idToField("$articletypetable",'articletype',$items_row['articletype_id']);
          
       $itemdetail=$linenum.'- '.$article. ' '.$articletype.'Serial#:'.$items_row['serialnumber'];
       
       $pdf->Write(0, $itemdetail);
       $defalut_text_tab = $text_tab;
       $text_tab=$text_tab + 3;  
       $text_line = $text_line + 3;
       
       $itemdisc='Description: '.$items_row['description'];
       $pdf->SetXY($text_tab, $text_line);
       $pdf->Write(0, $itemdisc);
       
       $text_tab=$defalut_text_tab;
       $linenum=$linenum + 1;  
       $text_line = $text_line + 5; 

  } 


}

}

	 
    if ($cfg_itemimg_onpdf == "yes"){  
      $piccount =1;
      $pictab = 4;
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
				
if ($piccount == 1){$pictab = 4; $picrow = 15;
$pdf->addPage();
$pdf->SetFont('Arial','',7);
$pdf->SetXY(2, 2);

$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
}
				
      
                  if ($piccount == 2){$pictab = 106; $picrow = 15;}
                  if ($piccount == 3){$pictab = 4; $picrow = 70;}
                  if ($piccount == 4){$pictab = 106; $picrow = 70;}
                  if ($piccount == 5){$pictab = 4; $picrow = 125;}
                  if ($piccount == 6){$pictab = 106; $picrow = 125;}
                  if ($piccount == 7){$pictab = 4; $picrow = 180;}
                  if ($piccount == 8){$pictab = 106; $picrow = 180;}
                  if ($piccount == 9){$pictab = 4; $picrow = 235;}
                  if ($piccount == 10){$pictab = 106; $picrow = 235;}
	
                  
if ($piccount == 11){$pictab = 4; $picrow = 15;
$pdf->addPage();
$pdf->SetFont('Arial','',7);
$pdf->SetXY(2, 2);

$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
}
                  
                  if ($piccount == 12){$pictab = 106; $picrow = 15;}
                  if ($piccount == 13){$pictab = 4; $picrow = 70;}
                  if ($piccount == 14){$pictab = 106; $picrow = 70;}
                  if ($piccount == 15){$pictab = 4; $picrow = 125;}
                  if ($piccount == 16){$pictab = 106; $picrow = 125;}
                  if ($piccount == 17){$pictab = 4; $picrow = 180;}
                  if ($piccount == 18){$pictab = 106; $picrow = 180;}
                  if ($piccount == 19){$pictab = 4; $picrow = 235;}
                  if ($piccount == 20){$pictab = 106; $picrow = 235;}
                  
if ($piccount == 21){$pictab = 4; $picrow = 15;
$pdf->addPage();
$pdf->SetFont('Arial','',7);
$pdf->SetXY(2, 2);

$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
}
                  
                  
                  
                  if ($piccount == 22){$pictab = 106; $picrow = 15;}
                  if ($piccount == 23){$pictab = 4; $picrow = 70;}
                  if ($piccount == 24){$pictab = 106; $picrow = 70;}
                  if ($piccount == 25){$pictab = 4; $picrow = 125;}
                  if ($piccount == 26){$pictab = 106; $picrow = 125;}
                  if ($piccount == 27){$pictab = 4; $picrow = 180;}
                  if ($piccount == 28){$pictab = 106; $picrow = 180;}
                  if ($piccount == 29){$pictab = 4; $picrow = 235;}
                  if ($piccount == 30){$pictab = 106; $picrow = 235;}
if ($piccount == 31){$pictab = 4; $picrow = 15;
$pdf->addPage();
$pdf->SetFont('Arial','',7);
$pdf->SetXY(2, 2);
 
$pdf->Write(0, $cfg_company.'   '.$cfg_address.'          '.'Transaction Number: '.$itemtrans_id.'                '.'Date & Time: '.$curdatetime); 
$pdf->SetXY(1, 3);
$pdf->Write(0, '________________________________________________________________________________________________________________________________________________________');
}
                  if ($piccount == 32){$pictab = 106; $picrow = 15;}
                  if ($piccount == 33){$pictab = 4; $picrow = 70;}
                  if ($piccount == 34){$pictab = 106; $picrow = 70;}
                  if ($piccount == 35){$pictab = 4; $picrow = 125;}
                  if ($piccount == 36){$pictab = 106; $picrow = 125;}
                  if ($piccount == 37){$pictab = 4; $picrow = 180;}
                  if ($piccount == 38){$pictab = 106; $picrow = 180;}
                  if ($piccount == 39){$pictab = 4; $picrow = 235;}
                  if ($piccount == 40){$pictab = 106; $picrow = 235;}   
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
	    $checkpdf_pathandname="$cfg_data_csapdf_pathdir/printcheck_$username.pdf";
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
			    echo "<br>"; 
                echo "<center>Check PDF created for this Transaction.</center>";
                echo "<center>Number of items in this transaction: $num_rows</center>";
                echo "<center>Click the Link below to view and print Check</center>";
                echo "<br><br>";
			 
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
