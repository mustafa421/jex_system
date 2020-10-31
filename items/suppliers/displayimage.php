<?php session_start(); ?>
<?php

include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../classes/cryptastic.php");



if(isset($_GET['licimage'])){ 
   $viewimage=$_GET['licimage'];
}
if(isset($_GET['custimg'])){ 
   $viewimage=$_GET['custimg'];
}

$thumbimage= "no";
if(isset($_GET['thumbimg'])){ 
   $viewimage=$_GET['thumbimg'];
   $thumbimage= "yes";
}



   
            if ($cfg_data_outside_storedir == "no") {
              $dirname = ".temp";     
              $image_filedir = "/images/{$dirname}/";     
	 
               if (file_exists($image_filedir)) {     
                   
                } else {     
                  mkdir($image_filedir, 0777);     
                   
                }     
            }
			
			if ($cfg_data_outside_storedir == "yes") {
               $dirname = ".temp";     
               $image_filedir = $cfg_data_storeDatapathdir."{$dirname}/";   
     
               if (file_exists($image_filedir)) {     
                  
                } else {     
                  mkdir($image_filedir, 0777);    
                   
                }     
            }

	  
	  
	 
	 if  ($viewimage != ""){
    
	 
	                                      
    
    
	$cryptastic = new cryptastic;

      $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	         die("Failed to generate secret key.");
    
     
	
     if ($cfg_imageZipORnozip == "nozip"){	
     
       
       
	   
		

        
 
	    
	    
	    
	    
      
    
      }else{
	
	     $zipnewnamepath3tempjpg=$cfg_data_supplierIMGpathdir.$viewimage.'.zip';
	     exec("unzip -jP $key $zipnewnamepath3tempjpg -d $cfg_data_storeDataTempDir", $output1);
	  
	  
	    
	    
	    
	  
	    
	    
	     
	  
	   $displayimagefile=$cfg_data_storeDataTempDir.$viewimage;
	   
      } 	  
	  
	  

            
} else{

  $displayimagefile=$cfg_data_suppliernoimageloaded;
}


 
shell_exec("chmod -R o-rwx $cfg_data_storeDataTempDir"); 
 
if (file_exists($displayimagefile)) {

$image=imagecreatefromjpeg($displayimagefile);
imagejpeg($image);
header('Content-Type: image/jpeg');
}

unlink($displayimagefile);
exit;
?>

