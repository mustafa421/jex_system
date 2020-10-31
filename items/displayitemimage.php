<?php session_start(); ?>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../classes/cryptastic.php");



if(isset($_GET['itemimage'])){ 
   $itemimage=$_GET['itemimage'];
   $storecode=$_GET['scode'];


		
			
			if ($cfg_data_outside_storedir == "yes") {
               $dirname = ".temp";     
               $image_filedir = $cfg_data_storeDatapathdir."{$dirname}/"; 
               $itemimage1= $cfg_data_itemIMGpathdir.$itemimage;			   
               $showitemimage=$itemimage1;  
			
    			//Store1
				if ($storecode == "10"){
				    $showitemimage=$cfg_jedataFromitemdir.$cfg_storeDirname.'/itemimages/'.$itemimage;
	            }
				
				//Store2 11
				if ($storecode == "11"){
				    $showitemimage=$cfg_jedataFromitemdir.$cfg_storeDirname.'/itemimages/'.$itemimage;
	            }

				//Store3  12
				if ($storecode == "12"){
				    $showitemimage=$cfg_jedataFromitemdir.$cfg_storeDirname.'/itemimages/'.$itemimage;
	            }
				
				
				 //Store4 13
				 if ($storecode == "13"){
				    $showitemimage=$cfg_jedataFromitemdir.$cfg_storeDirname.'/itemimages/'.$itemimage;
	            }
				
				//Store5 99
				 if ($storecode == "99"){
				    $showitemimage=$cfg_jedataFromitemdir.$cfg_storeDirname.'/itemimages/'.$itemimage;
	            }
				
				
				
               if (file_exists($image_filedir)) {     
                  
                } else {     
 
                }  
				
				
				
                 $displayimagefile="$showitemimage";
				
            }
		
          if (($itemimage == " ") or ($itemimage=="")) {	
		    $displayimagefile="../je_images/no_picture.jpg";
			}

		
 }
 
 

 
if (file_exists($displayimagefile)) {
$image=imagecreatefromjpeg($displayimagefile);
imagejpeg($image);
header('Content-Type: image/jpeg');
}

exit;
?>

