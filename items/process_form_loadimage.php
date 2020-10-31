<?php session_start(); ?>

<html>
<head>
	
</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
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
$upc_tablename="$cfg_tableprefix".'upc_numbers';
$transnumbertable=$cfg_tableprefix.'transaction_numbers';
$field_names=null;
$field_data=null;
$id=-1;

   
   if(isset($_POST['onlyloadimage']))
   {
     $onlyloadimage=$_POST['onlyloadimage'];
   }

	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];
	}
	

	
	elseif((isset($_POST['item_number']) and isset($_POST['category_id']) and isset($_POST['supplier_id']) and isset($_POST['buy_price']) and isset($_POST['tax_percent']) 
	and isset($_POST['id']) and isset($_POST['action']) ) or ($onlyloadimage == "yes"))
	{
		
		$action=$_POST['action'];
		$id = $_POST['id'];
			
		$workingid = $id; 
		
		
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number']; 
		$category_id = $_POST['category_id'];
		$supplier_id = $_POST['supplier_id'];
		$article_id = $_POST['article_id'];
	    $transaction_id = $_POST['transaction_id']; 
		$inventorytblrowid = $_POST['inventorytblrowid']; 
		$itemtblrowid = $_POST['itemtblrowid']; 
	    $supplier_phone = $_POST['supplier_phone'];
	    $buy_price = number_format($_POST['buy_price'],2,'.', '');
		$unit_price = number_format($_POST['unit_price'],2,'.', '');
		$tax_percent = $_POST['tax_percent']; 
		$item_gender = $_POST['item_gender'];
		$material_type = $_POST['material_type'];
		$description = $_POST['description'];
		
		$kindsize = $_POST['kindsize'];
		$numstone = $_POST['numstone'];
		$serialnumber = $_POST['serialnumber'];
		$brandname = $_POST['brandname'];
		$itemsize = $_POST['itemsize'];
		$itemcolor = $_POST['itemcolor'];
		$itemmodel = $_POST['itemmodel'];
		$transaction_from_panel = "jewelry";
		$add_toinventory = $_POST['addtoinventory'];
		$share_inventoryrowid = $_POST['inventorytblrowid'];
		
	
		$supplier_catalogue_number = $_POST['supplier_catalogue_number'];
		$quantity = $_POST['quantity'];
		$reorder_level= $_POST['reorder_level'];
		$image= $_FILES['item_image']['name']; 
		
	    $curdate = date("Y-m-d");
	    
        $curtime24=date("H:i:s"); 
		
	   $upc=$item_number;
	   $Item_row_id=$item_number;
	   $item_id=$id;
	   $trans_id_value = $transaction_id;
	
	
	  
	
	   
     $pos = strpos($supplier_id, '-', 1); 
     $supplier_id=substr($supplier_id,0,$pos);
	
	   
	   
	   
	   
	     $articletable = "$cfg_tableprefix".'articles';
	     $item_name=$dbf->idToField("$articletable",'article',"$article_id");
	     
	     if ($item_name == "Other"){
	     $item_name=substr($description,0,30);
	      }
	   
	   
	   if ($add_toinventory == ""){
	       $add_toinventory="N";   
	  }else{
	  
	  if ($item_gender == "M") { $genderdesc = "Male Item ";}
		if ($item_gender == "F") { $genderdesc = "Female Item ";}
		if ($material_type == "yg") { $mtypedesc = "yellow gold ";}
		if ($material_type == "wg") { $mtypedesc = "white gold ";}
		if ($material_type == "silver") { $mtypedesc = "silver ";}
		if ($material_type == "other") { $mtypedesc = "";}
		
		$description = $genderdesc . $mtypedesc . 'Kind: ' . $kindsize . ' Number of stone: '. $numstone . ' '. $description;
	
	  }	
	   
	   
	   
				$supplier_tablename="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);

   			$supplierphone=$supplier_row['phone_number'];
		  





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




		
		
		
		
		
		
		
		
		
		
		if(($category_id=='' or $supplier_id=='' or $buy_price=='') and ($onlyloadimage != "yes"))
		
		{
			echo "$lang->forgottenFields";
			exit();
		}
		
		
		elseif( (!is_numeric($buy_price)))
		{
			echo "$lang->mustEnterNumeric";
			exit();
		}
		else
		{
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', ''); 
			
			
	       
			
	
		}
	

    
	  
	}
	else
	{
		
		echo "$lang->mustUseForm |action: $action | id: $id";
		exit();
	}
	


switch ($action)
{
	
	case $action=="insert":
		
		
		     if ($add_toinventory == "Y"){
		      $auto_increment_table="'"."$cfg_tableprefix".'items'."'";		      
		      $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
              $row = mysql_fetch_array($r);
              $Auto_increment = $row['Auto_increment'];
              
		 
		      $next_id=$Auto_increment;
		      $Inserted_id = $next_id;
		      
		      
		      $itembarcode=$cfg_store_code.$next_id;
		      $id=$next_id;	
         	  $item_number=$itembarcode;	      
		     } 
	  
		
		  
		     
		     if ($transaction_id == "") {
		       
		      
		     
         
        
        
		      
		    
		    
		    
		      
		      
		      
		       $auto_increment_tran_numbertable="'"."$cfg_tableprefix".'transaction_numbers'."'";
		      
		      $tran_num_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_tran_numbertable ",$dbf->conn);
              $tran_num_row = mysql_fetch_array($tran_num_r);
              $Auto_increment_tranNum = $tran_num_row['Auto_increment'];
              
		
		        $trans_id_value=$Auto_increment_tranNum;
		        $avaliable_trans_number=$trans_id_value;
		        
		        $transnumbers_field_names=array('transaction_number');
	            $transnumbers_field_data=array("$avaliable_trans_number");
		        $dbf->insert($transnumbers_field_names,$transnumbers_field_data,$transnumbertable,true);
		     
		       
		       $auto_increment_table="'"."$cfg_tableprefix".'item_transactions'."'";
		      
		         $trans_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
                 $trans_row = mysql_fetch_array($trans_r);
                 $trans_Auto_increment = $trans_row['Auto_increment'];
				 $itemtranstbl_rowid=$trans_Auto_increment;
		         $Next_transactionID=$trans_Auto_increment;
		       
		       
		       
		      }else{
		      	  
		      	 $auto_increment_table="'"."$cfg_tableprefix".'item_transactions'."'";
		      
		         $trans_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
                 $trans_row = mysql_fetch_array($trans_r);
                 $trans_Auto_increment = $trans_row['Auto_increment'];
                 
		      
		         
				 
		      	  
				  
				  $Next_transactionID=$trans_Auto_increment;
				  $itemtranstbl_rowid=$trans_Auto_increment;
				  $upc=$Next_transactionID; 
		      	  $trans_id_value = $transaction_id;
				  
		      }	
		      
		      
		     $auto_increment_table="'"."$cfg_tableprefix".'items'."'";
		      
		      $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
              $row = mysql_fetch_array($r);
              $Auto_increment = $row['Auto_increment'];
              
		 
		      $next_id=$Auto_increment;
		      $Item_row_id = $next_id;
		     
		     
		     
		     
		     $auto_increment_table="'"."$cfg_tableprefix".'upc_numbers'."'";
		      
		      $upc_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
              $upc_row = mysql_fetch_array($upc_r);
              $Auto_increment_upc = $upc_row['Auto_increment'];
            
		 
		     
		        if ($add_toinventory == "Y"){
		        	$avaliable_upc_number=$cfg_store_code.'B'.$Auto_increment_upc;
		        }else{  
		           $avaliable_upc_number=$cfg_store_code.'J99'; 
		        }
		     
		     
		     
			 
			 
			 
		       if ($add_toinventory == "Y"){
			   $auto_increment_table="'".'inventory'."'";
		       $inv_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$shareINVdbf->conn);
               $row_inv = mysql_fetch_array($inv_r);
               $Auto_increment = $row_inv['Auto_increment'];
			   $next_inventorytblrowid=$Auto_increment;
			   }
		     
			 
			 
			 
			 
			 
			 
			 
		      
          
          

		      
          
          
          
          
          

		      

		  
		  
		  
		
		
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
    		
    		if ($add_toinventory == "Y"){
    			  $thisname=$cfg_store_code.$next_id;
		          
		     }else{
		     	   $thisname=$cfg_store_code.$Next_transactionID.'T'.$trans_id_value;
		     }	   
    		
		     
		       $newname = imageupload($image,$thisname);
		       $image=$newname;
		     
	  }
	   
	 
	 
	 
	  $field_names=array('item_number','category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	  $field_data=array("$avaliable_upc_number","$category_id","$supplier_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	 
	 
	  if ($add_toinventory != "Y"){
	    $Item_row_id=0;
		$next_inventorytblrowid=0;
		$totalowner = "Y";
		$itemfound = "N";
		$founddesc = "";
		
	   }
	 
	 
	   $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','item_gender','material_type','description','kindsize','numstone','brandname','serialnumber','itemmodel','totalowner','itemfound','founddesc','transaction_from_panel','addtoinventory_scrapgold','item_image','date','time');
	   $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$item_gender","$material_type","$description","$kindsize","$numstone","$brandname","$serialnumber","$itemmodel","$totalowner","$itemfound","$founddesc","$transaction_from_panel","$add_toinventory","$image","$curdate","$curtime24");	
	  
	  
	  
	  $upcnumbers_field_names=array('itemupc');
	  $upcnumbers_field_data=array("$avaliable_upc_number");	
	  
	  if ($add_toinventory == "Y"){
		   $dbf->insert($field_names,$field_data,$tablename,true);
		   $dbf->insert($trans_field_names,$trans_field_data,$trans_tablename,true);
		   $dbf->insert($upcnumbers_field_names,$upcnumbers_field_data,$upc_tablename,true);
		
		
		
		
		
		
		
		
		
		
		
		
		
		$viewinvimage="$image";
		
		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	    $sharedInventory_field_data=array("$avaliable_upc_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$viewinvimage","$curdate");
		$sharedinventory_tablename='inventory';
		$shareINVdbf->insert($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,true);
		
		}else{
			$dbf->insert($trans_field_names,$trans_field_data,$trans_tablename,true);
		}	
		
		
		
		
		  
	
	
	
	if ($add_toinventory == "Y"){
		
		echo "<meta http-equiv=refresh content=\"0; URL=form_items_jewelry.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&addjewelrytoinventory=yes\">";
	}else{	
	  echo "<meta http-equiv=refresh content=\"0; URL=form_buy_jewelry.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
	}
		
		
		
		
		
		
		
		

    
	 

     
		
	   
		
		

  

	break;
		
	case $action=="update":
	     $inupdatemode='yes'; 
         
		 
		 
        $itemtblrowid=$_POST['itemtblrowid'];
		
		
        
		
		$image=rtrim($image);
		$image=ltrim($image);
	if ($image !="" || $image != null){
    	
		
		
		
		if ($itemtblrowid == 0){
		   
		   $thisname=$cfg_store_code.$id.'T'.$transaction_id;
        }else{
		  $thisname=$cfg_store_code.$itemtblrowid;
		}
		
		
		
	     $result_image = mysql_query("SELECT item_image FROM $trans_tablename WHERE id=\"$id\"",$dbf->conn);
		 $row_image = mysql_fetch_assoc($result_image);
		 $imagefilename=$row_image['item_image'];
		if ($cfg_data_outside_storedir == "yes"){
			 $imagefile= $cfg_data_itemIMGpathdir.$imagefilename;
	   }else{  
			 $imagefile= 'images/'.$imagefilename;
	   }
		
		
		
		
		if(file_exists($imagefile)){
         unlink($imagefile);
        }   
		
		$newname = imageupload($image,$thisname);
		$image=$newname;
        
		
	     
		
		
		
	    
	      $trans_field_names=array('item_image');
	      $trans_field_data=array("$image");	
	  
        if ($itemtblrowid == 0){
		  $dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$id,true);
		}else{
		 
		 
	     
	     $field_names=array('item_image');
	     $field_data=array("$image");
		 
		 $dbf->update($field_names,$field_data,$tablename,$itemtblrowid,true);
		 $dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$id,true);
		
		
		
		
		
		
	    
		$sharedInventory_field_names=array('itemimage');
	    $sharedInventory_field_data=array("$image");
		
		$sharedinventory_tablename='inventory';
		$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,$share_inventoryrowid,true);
		
		
		}
			
		
		
	}else{
       echo "Image file name not entered therefore image not updated";
    }	
	
	
	 $runthiscode='no'; 
	if ($runthiscode == "yes"){ 
		
		if ($image=='')
		{
			
			
			
           
            
			
		}
		else
		{
		
		  $thisname=$cfg_store_code.$workingid;	
		  $nopicfile= "$thisname".'_nopic';
		     
		  $gif_file="images/$nopicfile.gif";
	     if(file_exists($gif_file)){
         unlink($gif_file);
        }   
		  
		  $gif_file="images/$thisname.gif";
	     if(file_exists($gif_file)){
         unlink($gif_file);
        }
	     
	     $jpg_file="images/$thisname.jpg";
	     if(file_exists($jpg_file)){
         unlink($jpg_file);
        }
		
		   $jpeg_file="images/$thisname.jpeg";
	     if(file_exists($jpeg_file)){
         unlink($jpeg_file);
        }
		
		  $png_file="images/$thisname.png";
	     if(file_exists($png_file)){
         unlink($png_file);
        }
		
		$newname = imageupload($image,$thisname);
		$image=$newname;
	  }
	  
		

		
		

		if ($image=='')
		{
		
	  
	  
	    $field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','Item_Image');
	    $field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image");	
	 
	 
	  
	  
	    $trans_field_names=array('itemrow_id','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','transaction_from_panel','addtoinventory_scrapgold');
	    $trans_field_data=array("$Item_row_id","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$transaction_from_panel","$add_toinventory");	
	  
	  
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone");
	    
	 
	 }
	else
		{	
		
	  
	  
	  	$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','Item_Image');
	    $field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image");	
	   
	  
	  
	    $trans_field_names=array('itemrow_id','article_id','supplier_id','supplier_phone','upc','buy_price','unit_price');
	    $trans_field_data=array("$Item_row_id","$article_id","$supplier_id","$supplierphone","$upc","$buy_price","$unit_price");	
	  
	  $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	  $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	
	  
	  }
		if ($add_toinventory == "Y"){
		   $dbf->update($field_names,$field_data,$tablename,$id,true);
		   $dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$trans_id_value,true);
		
		
		
		
				$shareINV_tablename='inventory';
				$lookupshareINVtableUPC = "'".$item_number."'";
				$shareINV_query="SELECT * FROM $shareINV_tablename where upc = $lookupshareINVtableUPC ";
				$shareINV_result=mysql_query($shareINV_query,$shareINVdbf->conn);
				$shareINV_row = mysql_fetch_assoc($shareINV_result); 
		    $shareINV_rowID = $shareINV_row['id'];
		 
		 
		 
	     $shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$shareINV_tablename,$shareINV_rowID,true);
		 }else{
		 	 $dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$trans_id_value,true); 
		 }
		 
	
		
		
		
		
		
		
		
		
		

		 
		

		
	
		
	   
		
		
	}
	
	break;
	
	case $action=="delete":
		$dbf->deleteRow($tablename,$id);
	
	break;
	
	default:
		echo "lang->noActionSpecified";
	break;
}
$dbf->closeDBlink();
$commondbf->closeDBlink();
$shareINVdbf->closeDBlink();





?>

<?php if ($inupdatemode != "yes"){ ?>
<table border="0" cellpadding="1" cellspacing="1" width="70%">
<tr>
<TD>
<?php echo "<a href=\"form_items.php?action=insert&working_on_id=$supplier_id\"><img src=\"../je_images/btgray_add_another_itemto_supplier.png\" onmouseover=\"this.src='../je_images/btgray_add_another_itemto_supplier_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_add_another_itemto_supplier.png';\" BORDER='0'></a><br>"; ?>
<a href="manage_items.php"><img src="../je_images/btgray_manage_items.png" onmouseover="this.src='../je_images/btgray_manage_items_MouseOver.png';" onmouseout="this.src='../je_images/btgray_manage_items.png';" BORDER='0'></a><br>
<a href="form_items.php?action=insert"><img src="../je_images/btgray_create_new_item.png" onmouseover="this.src='../je_images/btgray_create_new_item_MouseOver.png';" onmouseout="this.src='../je_images/btgray_create_new_item.png';" BORDER='0'></a>
</TD>


</tr>

</table>
<?php }  ?>


</body>
</html>