<?php

$tablename_includefile="$cfg_tableprefix".'items';
$trans_tablename_includefile="$cfg_tableprefix".'item_transactions';
$upc_tablename_includefile="$cfg_tableprefix".'upc_numbers';
$transnumbertable_includefile=$cfg_tableprefix.'transaction_numbers';

	   
				$supplier_tablename_includefile="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename_includefile where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);

   			$supplierphone=$supplier_row['phone_number'];
		  
			
			 
		       $found_bansupplier_flag = $supplier_row['bansupplier'];
		       
		      
		       if ($found_bansupplier_flag == "Y")
            {
  	           echo "This Supplier(Customer) is Banned. If you need to buy Item from this supplier have Admin remove the Ban.";
  	           exit;
            }
		     
			
switch ($action)
{
	
	
	case $action=="update":
		
		
		     $auto_increment_table="'"."$cfg_tableprefix".'items'."'";
		      
		  $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
          $row = mysql_fetch_array($r);
          $Auto_increment = $row['Auto_increment'];
          
		 
		      $next_id=$Auto_increment;
		      $Inserted_id = $next_id;
		      
		      
		      $itembarcode=$cfg_store_code.$next_id;
		      $id=$next_id;	
         	  $item_number=$itembarcode;	      
		      
			
		  
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
	            $dbf->insert($transnumbers_field_names,$transnumbers_field_data,$transnumbertable_includefile,true);
		     
			 
			 
			 
			         
		             
                     
                     
		      	     
		      	      
		       
		      }else{
		      	  

		         
			  }	
		      
			  
			  
			  
		      
		     $auto_increment_table="'"."$cfg_tableprefix".'items'."'";
		      
		      $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
              $row = mysql_fetch_array($r);
              $Auto_increment = $row['Auto_increment'];
             
		 
		      $next_id=$Auto_increment;
		      $Item_row_id = $next_id;
		     
		     

$startofnewyear="no";		    
if (date("m")==01){


$rundate_upcrestart = date("m/d/Y");
$truncatedupctable=$cfg_jedataFromitemdir.$cfg_storeDirname.'/'.'Donetruncatingupctable.txt';

if (file_exists("$truncatedupctable")) {
  
}else{
             
    $upc_tablename_includefile="$cfg_tableprefix".'upc_numbers';
	$upctruncate_query="TRUNCATE TABLE $upc_tablename_includefile";
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
            
		 
		     
		    
		     
			 


if ($startofnewyear=="yes") {		    

  $upcletter = 'A';

}else{
  $upcid = $Auto_increment_upc - 1;		 
  $upc_tablename_includefile="$cfg_tableprefix".'upc_numbers';
  $upc_query="SELECT * FROM $upc_tablename_includefile where id = $upcid ";
  $upc_result=mysql_query($upc_query,$dbf->conn);
  $upc_row = mysql_fetch_assoc($upc_result);

  $upcletter = substr($upc_row['itemupc'],2,1);
  
}

$avaliable_upc_number=$Auto_increment_upc;

if ($Auto_increment_upc == $cfg_maxupc_number) {  

    $upctruncate_query="TRUNCATE TABLE $upc_tablename_includefile";
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


		     
		     
		     
		     
		       $auto_increment_table="'".'inventory'."'";
		      
		      $inv_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$shareINVdbf->conn);
              $row_inv = mysql_fetch_array($inv_r);
              $Auto_increment = $row_inv['Auto_increment'];
			  $next_inventorytblrowid=$Auto_increment;
		     
	





		$result_image = mysql_query("SELECT item_image FROM $trans_tablename_includefile WHERE id=\"$transTableRowID\"",$dbf->conn);
		$row_image_includefilev2 = mysql_fetch_assoc($result_image);
		 
		if ($image == "" || $image == " ")
		{
		
		$image=$row_image_includefilev2['item_image']; 
		  
			
		}
		else
		{
		
		 
		 if ($cfg_data_outside_storedir == "yes"){
	        $imagelocation=$cfg_data_itemIMGpathdir;
         }else{
	         $imagelocation='images/';
          } 
		 
		 
		 $image=$row_image_includefilev2['item_image'];
		 if ($image != "" || $image != " "){
		     $itemimage_file=$imagelocation.$image;
	         if(file_exists($itemimage_file)){
                unlink($itemimage_file);
             }   
		  }	 
			 
		  
	
		
    	
		          
		
		
		
		      $thisname=$cfg_store_code.$Item_row_id;
			  $image=$imagelocation.$thisname;
		

		

		
		
	    $newname = imageupload($image,$thisname);
		$image=$newname;
		
		


	  }

		
		

		
		
		
		
				$supplier_tablename="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);

   			$supplierphone=$supplier_row['phone_number'];
		  
	
		  
		  
		  
		  
		  $supplier_catalogue_number = '';
		  $quantity = 1;
		  $reorder_level = 0;
		
		
		
	   $field_names=array('item_number','category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	   $field_data=array("$avaliable_upc_number","$category_id","$supplier_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	 
	  
	  
	    
        $addtoinventory_scrapgold='N';
		$trans_field_names=array('itemrow_id','share_inventorytbl_rowid','supplier_id','category_id','article_id','item_gender','material_type','scrap_or_resale','upc','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','totalowner','itemfound','founddesc','addtoinventory_scrapgold','report_item','scrap_or_resale','buy_price','unit_price','item_image');
	     $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$supplier_id","$category_id","$article_id","$item_gender","$material_type","$jewelrybuy_type","$avaliable_upc_number","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$totalowner","$itemfound","$founddesc","$addtoinventory_scrapgold","$reportitem","$jewelrybuy_type","$buy_price","$unit_price","$image");	
	 
	  
	   $upcnumbers_field_names=array('itemupc');
	   $upcnumbers_field_data=array("$avaliable_upc_number");	
  
		$dbf->insert($field_names,$field_data,$tablename_includefile,true);
	
	
	$dbf->update($trans_field_names,$trans_field_data,$trans_tablename_includefile,$transTableRowID,true);
	      
	
	
	$dbf->insert($upcnumbers_field_names,$upcnumbers_field_data,$upc_tablename_includefile,true);
		
	
		
		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	    $sharedInventory_field_data=array("$avaliable_upc_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image","$curdate");
		$sharedinventory_tablename='inventory';
		$shareINVdbf->insert($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,true);
	



}		


			
?>
