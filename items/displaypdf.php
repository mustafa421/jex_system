<?php session_start(); ?>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../classes/cryptastic.php");


if(isset($_GET['spid'])){ 
   $supplierid=$_GET['spid'];
}



if(isset($_GET['pdffile'])){ 
   $filepdf=$_GET['pdffile'];
}




            if ($cfg_data_outside_storedir == "no") {
              $dirname = ".temp";     
              $pdf_filedir = "/saleagreements/{$dirname}/";     
	 
               if (file_exists($pdf_filedir)) {     
                    
                } else {     
                  mkdir($pdf_filedir, 0777);     
                    
                }     
            }
			
			if ($cfg_data_outside_storedir == "yes") {
               
			   $dirname = ".temp";     
     
                $pdf_filedir = "$cfg_data_storePDFDataTempDir"; 
               if (file_exists($pdf_filedir)) {     
                    
                } else {     
                  mkdir($pdf_filedir, 0777);    
                    
                }     
            }



	  
	  

     
	  $cryptastic = new cryptastic;
      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	     die("Failed to generate secret key.");
	
      if ($cfg_imageZipORnozip == "nozip"){	
	
          $msg 			= file_get_contents($cfg_data_csapdf_pathdir.'/'.$filepdf);
	      $decrypted = $cryptastic->decrypt($msg, $key) or
			        	die("Failed to complete decryption");

         $dencryptedFile 	= $cfg_data_supplierIMGpathdirtemp.$filepdf;
 
	     $fHandle		= fopen($dencryptedFile, 'w+');
	      fwrite($fHandle, $decrypted);
	      fclose($fHandle);

	  
	  }else{
	     $pdfile = substr("$filepdf", 0, -4); 

		 $zipnewnamepath3tempjpg=$cfg_data_csapdf_pathdir.'/'.$supplierid.'/'.$filepdf;
		 $UnzipToDir=$cfg_data_storePDFDataTempDir;

	
	     exec("unzip -jP $key $zipnewnamepath3tempjpg -d $UnzipToDir", $output1);
		 

	  }
	  
	  



$openfile=$cfg_data_storePDFDataTempDir.$pdfile;
shell_exec("chmod -R o-rwx $cfg_data_storePDFDataTempDir");



header("Location: $openfile");



exit();




?>
