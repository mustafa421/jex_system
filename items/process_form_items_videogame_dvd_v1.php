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


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$commondbf=new db_functions($cfg_server,$cfg_commondbuser,$cfg_commondbpwd,$cfg_commondbname,$cfg_tableprefix,$cfg_theme,$lang);
$shareINVdbf=new db_functions($cfg_server,$cfg_shareINVdbuser,$cfg_shareINVdbpwd,$cfg_shareINVdbname,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit ();
}


$tablename="$cfg_tableprefix".'items';
$trans_tablename="$cfg_tableprefix".'item_transactions';
$transnumbertable=$cfg_tableprefix.'transaction_numbers';
$field_names=null;
$field_data=null;
$id=-1;



	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];
	}
	
	
	
	
	
	elseif(isset($_POST['item_number']) and isset($_POST['category_id']) and isset($_POST['supplier_id']) and isset($_POST['article_id']) and isset($_POST['buy_price']) and isset($_POST['unit_price']) and isset($_POST['tax_percent']) 
	and isset($_POST['supplier_catalogue_number']) and isset($_POST['quantity']) and isset($_POST['id']) and isset($_POST['action']) )
	
	
	{
		
		$action=$_POST['action'];
		$id = $_POST['id'];
	
		$workingid = $id; 
		
		
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$category_id = $_POST['category_id'];
		$article_id = $_POST['article_id'];
		$supplier_id = $_POST['supplier_id'];
	    $transaction_id = $_POST['transaction_id'];
		$inventorytblrowid = $_POST['inventorytblrowid']; 
		$itemtranstbl_rowid = $_POST['itemtranstblrowid']; 
		$serialnumber = $_POST['serialnumber'];
		$brandname = $_POST['brandname'];
		$itemsize = $_POST['itemsize'];
		$itemcolor = $_POST['itemcolor'];
		$itemmodel = $_POST['itemmodel'];
		$description = $_POST['description'];
		if($action=="insert")
		{
		  $totalowner = $_POST['totalowner'];
		  $itemfound = $_POST['itemfound'];
		  $founddesc = $_POST['founddesc'];
		}
		$buy_price = number_format($_POST['buy_price'],2,'.', '');
		$unit_price = number_format($_POST['unit_price'],2,'.', '');
		$tax_percent = $_POST['tax_percent'];
		$supplier_catalogue_number = $_POST['supplier_catalogue_number'];
		$quantity = $_POST['quantity'];
		$reorder_level= $_POST['reorder_level'];
		$image= $_FILES['item_image']['name']; 
		
		$curdate = date("Y-m-d");
		
        $curtime24=date("H:i:s"); 
	
	    $item_name=substr($description,0,30);
		$gamedvdupc=$item_number;
		$pos = strpos($supplier_id, '-', 1); 
		$supplier_id=substr($supplier_id,0,$pos);
		

	
	
	




function imageupload($uploadstr,$str2){
    include ("../settings.php"); 
	include ("../../../../$cfg_configfile"); 
	$itemimagename=$str2;
	

 define ("MAX_SIZE","100"); 


 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }




 $errors=0;

 if(isset($_POST['Submit'])) 
 {	
 	
 	$itemimage=$_FILES['item_image']['name'];
 
 	if ($itemimage != "" ) 
 	{
 	
 		$filename = stripslashes($_FILES['item_image']['name']);
 	
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 	
	
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
		
 			echo '<h1>Unknown extension! Record not loaded/Updated. Please click browser back button and re-try. Thanks</h1>';
 			$errors=1;
 			exit;
 		}
 		else
 		{

 
 
 $size=filesize($_FILES['image']['tmp_name']);


if ($size > MAX_SIZE*1024)
{
	echo '<h1>You have exceeded the size limit!</h1>';
	$errors=1;
	exit;
}



$image_name=$itemimagename.'.'.$extension;



if ($cfg_data_outside_storedir == "yes"){
     $newnamepath=$cfg_data_itemIMGpathdir.$image_name;
   }else{
	 $newnamepath="images/".$image_name;
   }
















      $image = new SimpleImage();
      $image->load($_FILES['item_image']['tmp_name']);
      $image->resizeToWidth(200);
      
     $image->save($newnamepath);
   
if(file_exists($newnamepath)){
   
} else {
	   echo '<h1>Image Copy unsuccessfull! Please Reload Image</h1>';
   $errors=1;
   exit;
}	

}}}


 if(isset($_POST['Submit']) && !$errors) 
 {
 	echo "<center>Following Image Uploaded Successfully!</center>";
 	return $image_name;
 }
}




		
		
		
		
		
		
		
		
		if($category_id=='' or $supplier_id=='' or $buy_price=='' or $tax_percent=='' or $quantity=='' or $reorder_level=='' )
		
		{
			echo "$lang->forgottenFields";
			exit();
		}
		elseif( (!is_numeric($buy_price)) or (!is_numeric($unit_price)) or (!is_numeric($tax_percent)) or (!is_numeric($quantity))  or (!is_numeric($reorder_level)))
		{
			echo "$lang->mustEnterNumeric";
			exit();
		}
		else
		{
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', ''); 
			
			
	        $field_names=array('item_number','category_id','article','supplier_id','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
			$field_data=array("$item_number","$category_id","$article","$supplier_id","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	
	
		}
		
	}
	else
	{
		
		echo "$lang->mustUseForm";
		exit();
	}
	


switch ($action)
{
	
	case $action=="insert":
		
		
		   
		     $auto_increment_table="'"."$cfg_tableprefix".'items'."'";
		      
		      $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
              $row = mysql_fetch_array($r);
              $Auto_increment = $row['Auto_increment'];
          
		 
		      $next_id=$Auto_increment;
		      $Item_row_id = $next_id;
		     
		  
		  
		  
		     
		     if ($transaction_id == "") {
		      
		      
		      
          
          
          
		      
		      
		      
		      
		      
		       $auto_increment_tran_numbertable="'"."$cfg_tableprefix".'transaction_numbers'."'";
		      
		        $tran_num_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_tran_numbertable ",$dbf->conn);
                $tran_num_row = mysql_fetch_array($tran_num_r);
                $Auto_increment_tranNum = $tran_num_row['Auto_increment'];
               
		
		        $trans_id_value=$Auto_increment_tranNum;
		        $avaliable_trans_number=$trans_id_value;
		        
				
				if ($cfg_startTransNum_with=="yyyy"){	
				
				  $trans_id_value = date("Y") . $trans_id_value;
			    
				}else 
				 if ($cfg_startTransNum_with=="yymm"){
				   	   
				   $trans_id_value = substr(date("Y"),2,2) . date("m") . $trans_id_value;
				
				}else
				  if ($cfg_startTransNum_with=="yyyymm"){	
				
				  $trans_id_value = date("Y") . date("m") . $trans_id_value;
			    
				}else
				  if ($cfg_startTransNum_with=="yyyymmdd"){	
				
				  $trans_id_value = date("Y") . date("m") . date("d") . $trans_id_value;
				
				}else
				  if ($cfg_startTransNum_with=="yymmdd"){	
				
				  $trans_id_value = substr(date("Y"),2,2) . date("m") . date("d") . $trans_id_value;
				
				}else{ 
				 
				 
				} 
				
					
				
		        $transnumbers_field_names=array('transaction_number');
	            $transnumbers_field_data=array("$avaliable_trans_number");
		        $dbf->insert($transnumbers_field_names,$transnumbers_field_data,$transnumbertable,true);
		     
		      
		      
		      }else{
			  
			      
			      $auto_increment_table="'"."$cfg_tableprefix".'item_transactions'."'";
		      
		          $trans_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
                  $trans_row = mysql_fetch_array($trans_r);
                  $trans_Auto_increment = $trans_row['Auto_increment'];
		      	  $itemtranstbl_rowid=$trans_Auto_increment;
			      
			  
		      	  $trans_id_value = $transaction_id;
		      }	




$startofnewyear="no";		    
if (date("m")==01){


$rundate_upcrestart = date("m/d/Y");
$truncatedupctable=$cfg_jedataFromitemdir.$cfg_storeDirname.'/'.'Donetruncatingupctable.txt';

if (file_exists("$truncatedupctable")) {
  
}else{
             
    $upc_tablename="$cfg_tableprefix".'upc_numbers';
	$upctruncate_query="TRUNCATE TABLE $upc_tablename";
	$upctruncate_result=mysql_query($upctruncate_query,$dbf->conn);
	$startofnewyear="yes";
	shell_exec("echo 'New Year start Restarted upc Number. UPC Table Truncated on '$rundate_upcrestart > $truncatedupctable"); 
}

}else{
  unlink($truncatedupctable); 
}


			
		     
		     $auto_increment_table="'"."$cfg_tableprefix".'upc_numbers'."'";
		     $upc_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
             $upc_row = mysql_fetch_array($upc_r);
             $Auto_increment_upc = $upc_row['Auto_increment'];
            
		 
		     
		    
		     
			 

If ($cfg_gamedvd_upc=="storeupc"){
if ($startofnewyear=="yes") {		    

  $upcletter = 'A';

}else{
  $upcid = $Auto_increment_upc - 1;		 
  $upc_tablename="$cfg_tableprefix".'upc_numbers';
  $upc_query="SELECT * FROM $upc_tablename where id = $upcid ";
  $upc_result=mysql_query($upc_query,$dbf->conn);
  $upc_row = mysql_fetch_assoc($upc_result);

  $upcletter = substr($upc_row['itemupc'],2,1);
  
}

$avaliable_upc_number=$Auto_increment_upc;

if ($Auto_increment_upc == $cfg_maxupc_number) {  

    $upctruncate_query="TRUNCATE TABLE $upc_tablename";
	$upctruncate_result=mysql_query($upctruncate_query,$dbf->conn);
	
	
	$upc_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
    $upc_row = mysql_fetch_array($upc_r);
    $Auto_increment_upc = $upc_row['Auto_increment'];
	
   if ($upcletter == "A") {
       $upcletter = "B";
	} else 
	if ($upcletter == "B") { 
	   $upcletter = "C";
    } else 
	if ($upcletter == "C") { 
	   $upcletter = "D";
    } else 
	if ($upcletter == "D") { 
	   $upcletter = "E";
    } else 
	if ($upcletter == "E") { 
	   $upcletter = "F";
    } else 
	if ($upcletter == "F") { 
	   $upcletter = "G";
    } else 
	if ($upcletter == "G") { 
	   $upcletter = "H";
    } else 
	if ($upcletter == "H") { 
	   $upcletter = "I";
     } else 
	if ($upcletter == "I") { 
	   $upcletter = "J";
     } else 
	if ($upcletter == "J") { 
	   $upcletter = "K";
    } else 
	if ($upcletter == "K") { 
	   $upcletter = "L";	   
    } else 
	if ($upcletter == "L") { 
	   $upcletter = "M";
	} else 
	if ($upcletter == "M") { 
	   $upcletter = "N";
	} else 
	if ($upcletter == "N") { 
	   $upcletter = "O";
	} else 
	if ($upcletter == "O") { 
	   $upcletter = "P";
	} else 
	if ($upcletter == "P") { 
	   $upcletter = "Q";   
	} else 
	if ($upcletter == "Q") { 
	   $upcletter = "R";
	} else 
	if ($upcletter == "R") { 
	   $upcletter = "S";
	} else 
	if ($upcletter == "S") { 
	   $upcletter = "T";
	} else 
	if ($upcletter == "T") { 
	   $upcletter = "U";
	} else 
	if ($upcletter == "U") { 
	   $upcletter = "V";
	} else 
	if ($upcletter == "V") { 
	   $upcletter = "W";
	} else 
	if ($upcletter == "W") { 
	   $upcletter = "X";
    } else 
	if ($upcletter == "X") { 
	   $upcletter = "Y";
    } else { 
	   $upcletter = "Z";
    } 
	$avaliable_upc_number=date("y").$upcletter.$Auto_increment_upc;
	
}else{
   $avaliable_upc_number=date("y").$upcletter.$Auto_increment_upc;
} 	   

$upcnumbers_field_names=array('itemupc');
$upcnumbers_field_data=array("$avaliable_upc_number");
$dbf->insert($upcnumbers_field_names,$upcnumbers_field_data,$upc_tablename,true);

} 

		      
			
		       

			  
		       $auto_increment_table="'".'inventory'."'";
		      
		      $inv_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$shareINVdbf->conn);
              $row_inv = mysql_fetch_array($inv_r);
              $Auto_increment = $row_inv['Auto_increment'];
			  $next_inventorytblrowid=$Auto_increment;
		     
		  
		  
		  
		  
		  
		  
		  
		  
				$supplier_tablename="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);

   			$supplierphone=$supplier_row['phone_number'];
		  
		  
		       $found_bansupplier_flag = $supplier_row['bansupplier'];
		       
		      
		       if ($found_bansupplier_flag == "Y")
            {
  	           echo "This Supplier(Customer) is Banned. If you need to buy Item from this supplier have Admin remove the Ban.";
  	           exit;
            }
		     
		      
		      
		if ($image=='')
		{
		$image="";
		
			
			
      
      
			
			
			
		}
		else
		{
    		
		     $thisname=$cfg_store_code.$next_id;	
		     $newname = imageupload($image,$thisname);
		     $image=$newname;
	  }
	  

	  If ($cfg_gamedvd_upc=="gamedvdupc"){		
		
	 
	  $check_item_table="SELECT item_number FROM $tablename WHERE item_number = $item_number";		
		if(mysql_num_rows(mysql_query($check_item_table,$dbf->conn))){
       
	   
	   
                $items_table_query="SELECT * FROM $tablename WHERE item_number = $item_number";
				$items_table_result=mysql_query($items_table_query,$dbf->conn);
				$items_table_row = mysql_fetch_assoc($items_table_result);

   			$item_table_rowid=$items_table_row['id'];
   			
   			
   			$item_table_item_number=$items_table_row['item_number']; 
   			$item_table_quantity=$items_table_row['quantity'];
			$shareINV_rowID=$items_table_row['share_inventorytbl_rowid'];
   			
   			
   			$quantity = $item_table_quantity + 1;
   			$id=$item_table_rowid;
   		    $Item_row_id=$item_table_rowid;
   		
   		$field_names=array('quantity');
	    $field_data=array("$quantity");	
	  
	    $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','totalowner','itemfound','founddesc','transaction_from_panel','item_image','date','time');
	    $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$gamedvdupc","$buy_price","$unit_price","$description","$totalowner","$itemfound","$founddesc","addvgdvd","$image","$curdate","$curtime24");	
	    
	   
	 
		
		$dbf->update($field_names,$field_data,$tablename,$id,true);
		
		$dbf->insert($trans_field_names,$trans_field_data,$trans_tablename,true);
   	
   	
   	
		 
		
		 $shareINV_tablename='inventory';
	     $invtable_query="SELECT * FROM $shareINV_tablename WHERE upc = $item_number";
		 $invtable_result=mysql_query($invtable_query,$shareINVdbf->conn);
		 $invtable_row = mysql_fetch_assoc($invtable_result);
   	     $invtable_rowid=$invtable_row['id'];
		
		 $sharedInventory_field_names=array('quantity');
	     $sharedInventory_field_data=array("$quantity");
	
	     $shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$shareINV_tablename,$invtable_rowid,true);

	    
	 
       
		 
		 
		 
	
   	
   	
   	
   	 $gdvdtitleINcatalog=$_POST['gamedvdtitle_in_catalog'];
		 
   	
   	  if ($gdvdtitleINcatalog=="no") {
   	 
   	       $gdvdcatalog_field_names=array('title','upc');
	       $gdvdcatalog_field_data=array("$description","$item_number");	
	       $gdvdcatalog_tablename='gamedvd_catalog';
   	       $commondbf->insert($gdvdcatalog_field_names,$gdvdcatalog_field_data,$gdvdcatalog_tablename,true);
   	  }
   	
   	
   	
		
	  
         if (($cfg_enableimageupload_gdvd == "yes") and ($cfg_imagesnapmethod == "online")){  
		   
            
            if ($cfg_dvdlookup_version=="2"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink1\">";
            }else if ($cfg_dvdlookup_version=="3"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink1v3\">";

			}else{
	            
				echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink2\">";
	        }	  			
			
		    
		}else{ 

        	  if ($cfg_dvdlookup_version=="2"){
		          echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd_v2.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
        	  }else if ($cfg_dvdlookup_version=="3"){
		          echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd_v3.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";

				  }else{
      	          echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
              }		
   		}
  } else {
      	
    
		
	
		
		
		
	
	 
	 
	  
	  $field_names=array('item_number','category_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','supplier_id','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	  $field_data=array("$item_number","$category_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$supplier_id","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	  
	  
	  
	  
	  
	  
	  $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','transaction_from_panel','item_image','date','time');
	  $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$gamedvdupc","$buy_price","$unit_price","$description","addvgdvd","$image","$curdate","$curtime24");	
	  
	  
		$dbf->insert($field_names,$field_data,$tablename,true);
		$dbf->insert($trans_field_names,$trans_field_data,$trans_tablename,true);
		
		
		
		$viewinvimage="$image";
		$item_catogory='Game DVD';
		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	    $sharedInventory_field_data=array("$item_number","$item_catogory","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$viewinvimage","$curdate");
		$sharedinventory_tablename='inventory';
		$shareINVdbf->insert($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,true);
		
		
		
		
   	 $gdvdtitleINcatalog=$_POST['gamedvdtitle_in_catalog'];
		 
   	
   	  if ($gdvdtitleINcatalog=="no") {
   	 
   	       $gdvdcatalog_field_names=array('title','upc');
	       $gdvdcatalog_field_data=array("$description","$item_number");	
	       $gdvdcatalog_tablename='gamedvd_catalog';
   	       $commondbf->insert($gdvdcatalog_field_names,$gdvdcatalog_field_data,$gdvdcatalog_tablename,true);
   	  }
   	
		
		
		
		
		
		
		
	  
    
	   
     
        if ($cfg_enableimageupload_gdvd == "yes" and $cfg_imagesnapmethod == "online"){  
		   
            
            if ($cfg_dvdlookup_version=="2"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink1\">";
            }else if ($cfg_dvdlookup_version=="3"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink1v3\">";

			}else{
	            
				echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink2\">";
	        }	  			
			
		    
		}else{ 

        	   if ($cfg_dvdlookup_version=="2"){
                   echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd_v2.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
        	   }else if ($cfg_dvdlookup_version=="3"){
                   echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd_v3.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";

				   }else{
	    	       echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
	          }	
	
	   }
}

} 


If ($cfg_gamedvd_upc=="storeupc"){		
      $field_names=array('item_number','category_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','supplier_id','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	  $field_data=array("$avaliable_upc_number","$category_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$supplier_id","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	   
	  $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','transaction_from_panel','item_image','date','time');
	  $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$description","addvgdvd","$image","$curdate","$curtime24");	
	  
	  $dbf->insert($field_names,$field_data,$tablename,true);
	  $dbf->insert($trans_field_names,$trans_field_data,$trans_tablename,true);
		
		
		
		$viewinvimage="$image";
		$item_catogory='Game DVD';
		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	    $sharedInventory_field_data=array("$avaliable_upc_number","$item_catogory","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$viewinvimage","$curdate");
		$sharedinventory_tablename='inventory';
		$shareINVdbf->insert($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,true);
		
		
		
		
   	      $gdvdtitleINcatalog=$_POST['gamedvdtitle_in_catalog'];
		 
   	
   	  if ($gdvdtitleINcatalog=="no") {
   	 
   	       $gdvdcatalog_field_names=array('title','upc');
	       $gdvdcatalog_field_data=array("$description","$item_number");	
	       $gdvdcatalog_tablename='gamedvd_catalog';
   	       $commondbf->insert($gdvdcatalog_field_names,$gdvdcatalog_field_data,$gdvdcatalog_tablename,true);
   	  }
   	
		
		
		
		
		
		
		
	    
        
	   
     
        if ($cfg_enableimageupload_gdvd == "yes" and $cfg_imagesnapmethod == "online"){  
		   
            
            if ($cfg_dvdlookup_version=="2"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink1\">";
            }else if ($cfg_dvdlookup_version=="3"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink1v3\">";

				 }else{
	            
				echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pgdvdlink2\">";
	        }	  			
			
		    
		}else{ 

        	   if ($cfg_dvdlookup_version=="2"){
                   echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd_v2.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
        	   }else if ($cfg_dvdlookup_version=="3"){
                   echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd_v3.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";

				   }else{
	    	       echo "<meta http-equiv=refresh content=\"0; URL=form_items_videogame_dvd.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
	          }	
	
	   }

} 
	break;
		
	case $action=="update":
		
		
		
		
		
		
		if ($image == "" || $image == " ")
		{
		
		$result_image = mysql_query("SELECT item_image FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		$row_image = mysql_fetch_assoc($result_image);
		$image=$row_image['item_image']; 
		  
			
			
			
      
      
			
		}
		else
		{
		
		   $thisname=$cfg_store_code.$workingid;	
		   $nopicfile= "$thisname".'_nopic';
		 
		 if ($cfg_data_outside_storedir == "yes"){
	        $imagelocation=$cfg_data_itemIMGpathdir;
         }else{
	         $imagelocation='images/';
          } 
		 
		 $gif_file=$imagelocation.$nopicfile.'.gif';
	     if(file_exists($gif_file)){
         unlink($gif_file);
        }   
		  
		  $gif_file=$imagelocation.$thisname.'.gif';
	     if(file_exists($gif_file)){
         unlink($gif_file);
        }
	     
	     $jpg_file=$imagelocation.$thisname.'.jpg';
	     if(file_exists($jpg_file)){
         unlink($jpg_file);
        }
		
		   $jpeg_file=$imagelocation.$thisname.'.jpeg';
	     if(file_exists($jpeg_file)){
         unlink($jpeg_file);
        }
		
		  $png_file=$imagelocation.$thisname.'.png';
	     if(file_exists($png_file)){
         unlink($png_file);
        }
		
		$newname = imageupload($image,$thisname);
		$image=$newname;
		
		
	  }
	  
		

		
		

		if ($image == "" || $image == " ")
		{
		
	  $field_names=array('item_number','category_id','article_id','supplier_id','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	  $field_data=array("$item_number","$category_id","$article_id","$supplier_id","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	  
	 
	 
	 }
	else
		{	
		
	  $field_names=array('item_number','category_id','article_id','supplier_id','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	  $field_data=array("$item_number","$category_id","$article_id","$supplier_id","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	  
	 
	  }
		$dbf->update($field_names,$field_data,$tablename,$id,true);
		
		
	break;
	
	case $action=="delete":
		
		$dbf->deleteRow($trans_tablename,$id);
	
	break;
	
	default:
		echo "lang->noActionSpecified";
	break;
}
$dbf->closeDBlink();
$commondbf->closeDBlink();
$shareINVdbf->closeDBlink();





?>

<table border="0" cellpadding="1" cellspacing="1" width="70%">
<tr>
<TD>
<?php echo "<a href=\"form_items.php?action=insert&working_on_id=$supplier_id\"><img src=\"../je_images/btgray_add_another_itemto_supplier.png\" onmouseover=\"this.src='../je_images/btgray_add_another_itemto_supplier_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_add_another_itemto_supplier.png';\" BORDER='0'></a><br>"; ?>
<a href="manage_items.php"><img src="../je_images/btgray_manage_items.png" onmouseover="this.src='../je_images/btgray_manage_items_MouseOver.png';" onmouseout="this.src='../je_images/btgray_manage_items.png';" BORDER='0'></a><br>
<a href="form_items.php?action=insert"><img src="../je_images/btgray_create_new_item.png" onmouseover="this.src='../je_images/btgray_create_new_item_MouseOver.png';" onmouseout="this.src='../je_images/btgray_create_new_item.png';" BORDER='0'></a>
</TD>


</tr>

</table>



</body>
</html>