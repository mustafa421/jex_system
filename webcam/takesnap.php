<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/resizeimage.php");
include ("../classes/cryptastic.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$shareINVdbf=new db_functions($cfg_server,$cfg_shareINVdbuser,$cfg_shareINVdbpwd,$cfg_shareINVdbname,$cfg_tableprefix,$cfg_theme,$lang);


if(isset($_GET['itemrowid'])){ 
     	 $itemrowid=$_GET['itemrowid'];
	
	
}else{
$itemrowid='';
}		   

if(isset($_GET['supplierid'])){ 
     	 $supplierid=$_GET['supplierid'];
	
	  
}else{
$supplierid='';
}	


if(isset($_GET['inventorytblrowid'])){ 
     	 $inventorytblrowid=$_GET['inventorytblrowid'];
	   
}else{
$inventorytblrowid='';
}

if(isset($_GET['itemtranstbl_rowid'])){ 
     	 $itemtranstbl_rowid=$_GET['itemtranstbl_rowid'];
	   
}else{
$itemtranstbl_rowid='';
}	   

if(isset($_GET['trans_id'])){ 
     	 $trans_id=$_GET['trans_id'];
	  
	
	   
}else{
$trans_id='';
}

if(isset($_GET['comingfrom'])){ 
     	 $comingfrom=$_GET['comingfrom'];
	   
}else{
$comingfrom='';
}


if ($itemrowid <> "0"){
$filename = $cfg_store_code.$itemrowid.'.jpg';
if ($cfg_data_outside_storedir == "yes"){
     $newnamepath=$cfg_data_itemIMGpathdir.$filename;
   }else{
	 $newnamepath="items/images/".$filename;
   }
}

if ($itemrowid=="0"){ 

$filename = $cfg_store_code.$itemtranstbl_rowid.'T'.$trans_id.'.jpg';
if ($cfg_data_outside_storedir == "yes"){
     $newnamepath=$cfg_data_itemIMGpathdir.$filename;
   }else{
	 $newnamepath="items/images/".$filename;
   }
}

if ($supplierid <> "" and $itemrowid == ""){
$filename = $cfg_store_code.$supplierid.'p.jpg';
if ($cfg_data_outside_storedir == "yes"){
                $newnamepath=$cfg_data_supplierIMGpathdirwebcam.$filename;
				
	        
           }else{
	            $newnamepath="images/".$filename;
	        
          }   
}   
   


if ($comingfrom != "processsupplier"){
$trans_tablename="$cfg_tableprefix".'item_transactions';
$result_image = mysql_query("SELECT item_image FROM $trans_tablename WHERE id=\"$itemtranstbl_rowid\"",$dbf->conn);
$row_image = mysql_fetch_assoc($result_image);
$imageonfile=$row_image['item_image'];


if ($imageonfile != "" || $imageonfile != " "){		 
		 if ($cfg_data_outside_storedir == "yes"){
	        $imagelocation=$cfg_data_itemIMGpathdir;
         }else{
	         $imagelocation='images/';
          } 
	
		     $itemimage_file=$imagelocation.$imageonfile;
			 	
				
	         if(file_exists($itemimage_file)){
                unlink($itemimage_file);
             }   
}
} 


   

$showfilename = '../webcampics/'.$id.date('YmdHis') . '.jpg';
$result = file_put_contents( $newnamepath, file_get_contents('php://input') );


if (!$result) {
	print "ERROR: Failed to write data to $newnamepath, check permissions\n";
	exit();
}else{

   
   
   

shell_exec("cp -f $newnamepath $showfilename");


if ($itemrowid <> 0 and $comingfrom=="processitems"){



$field_names=null;
$field_data=null;
$field_names=array('item_image');
$field_data=array("$filename");	
$tablename="$cfg_tableprefix".'items';
$dbf->update($field_names,$field_data,$tablename,$itemrowid,true);


$sharedInventory_field_names=null;
$sharedInventory_field_data=null;
$sharedInventory_field_names=array('itemimage');
$sharedInventory_field_data=array("$filename");	
$shareINV_tablename='inventory';		

$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$shareINV_tablename,$inventorytblrowid,true);


$trans_field_names=null;
$trans_field_data=null;
$trans_field_names=array('item_image');
$trans_field_data=array("$filename");	
$trans_tablename="$cfg_tableprefix".'item_transactions';		
$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtranstbl_rowid,true);		  	 
}

if ($itemrowid > 0 and $comingfrom=="itemtranpanel"){



$field_names=null;
$field_data=null;
$field_names=array('item_image');
$field_data=array("$filename");	
$tablename="$cfg_tableprefix".'items';
$dbf->update($field_names,$field_data,$tablename,$itemrowid,true);


$sharedInventory_field_names=null;
$sharedInventory_field_data=null;
$sharedInventory_field_names=array('itemimage');
$sharedInventory_field_data=array("$filename");	
$shareINV_tablename='inventory';		

$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$shareINV_tablename,$inventorytblrowid,true);


$trans_field_names=null;
$trans_field_data=null;
$trans_field_names=array('item_image');
$trans_field_data=array("$filename");	
$trans_tablename="$cfg_tableprefix".'item_transactions';		
$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtranstbl_rowid,true);		  	 




}


if ($itemrowid=="0"){ 

$trans_field_names=null;
$trans_field_data=null;
$trans_field_names=array('item_image');
$trans_field_data=array("$filename");	
$trans_tablename="$cfg_tableprefix".'item_transactions';		
$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtranstbl_rowid,true);

}

if ($supplierid <> "" and $comingfrom=="processsupplier"){

$field_names=null;
$field_data=null;
$field_names=array('imagecust');
$field_data=array("$filename");	
$tablename="$cfg_tableprefix".'suppliers';
$dbf->update($field_names,$field_data,$tablename,$supplierid,true);

        $cryptastic = new cryptastic;
        $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	           die("Failed to generate secret key.");
 if ($cfg_imageZipORnozip == "nozip"){ 
 
 }else{
 $newnamepathtempjpg= $newnamepath;
 $newnamepathtempjpgzip = $newnamepath.'.zip';
system("zip -jP $key $newnamepathtempjpgzip  $newnamepathtempjpg"); 
system ("chmod o-rwx $newnamepathtempjpgzip"); 
unlink($newnamepathtempjpg);
}	



	  	 
}




}




$url = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $showfilename;
print "$url\n";
 



?>
