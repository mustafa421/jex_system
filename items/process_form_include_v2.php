<?php

	$userstable_includefilev2="$cfg_tableprefix".'users';
	$userid=$_SESSION['session_user_id'];
    $user_result = mysql_query("SELECT id,username,type FROM $userstable_includefilev2 WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $username=$usertable_row['username'];
	$usertype=$usertable_row['type'];
	$userid=$usertable_row['id'];



$tablename_includefilev2="$cfg_tableprefix".'items';
$trans_tablename_includefilev2="$cfg_tableprefix".'item_transactions';
$upc_tablename_includefilev2="$cfg_tableprefix".'upc_numbers';
$transnumbertable_includefilev2=$cfg_tableprefix.'transaction_numbers';

	   
	     $articletable_includefilev2 = "$cfg_tableprefix".'articles';
	     $item_name=$dbf->idToField("$articletable_includefilev2",'article',"$article_id");
	     
	     if ($item_name == "Other"){
	     $item_name=substr($description,0,30);
	      }
	   
	   
	   
				$supplier_tablename_includefilev2="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename_includefilev2 where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);

   			$supplierphone=$supplier_row['phone_number'];
		  
			
			 
		       $found_bansupplier_flag = $supplier_row['bansupplier'];
		       
		      
		       if ($found_bansupplier_flag == "Y")
            {
  	           echo "This Supplier(Customer) is Banned. If you need to buy Item from this supplier have Admin remove the Ban.";
  	           exit;
            }
		     
			


			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', ''); 
			
			
	        $field_names=array('item_number','category_id','supplier_id','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image');
			$field_data=array("$item_number","$category_id","$supplier_id","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image");	
	

		
	
	
switch ($action)
{
	
	
	case $action=="update":
		
  
				$check_itemtable="SELECT id FROM $tablename_includefilev2 WHERE item_name = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_itemtable,$dbf->conn))){
				
				$itemtableresult = mysql_query("SELECT id FROM $tablename_includefilev2 WHERE item_name = \"$username\" ",$dbf->conn);
				$itemtablerow = mysql_fetch_assoc($itemtableresult);
				$itemtablerowid=$itemtablerow['id'];

				$next_id=$itemtablerowid;
				$Item_row_id = $next_id;

				}else{
                   
		 		$itemstable_field_names=array('item_name');
				$itemtable_field_data=array("$username");
				$dbf->insert($itemstable_field_names,$itemtable_field_data,$tablename_includefilev2,true);
				
				$itemtableresult = mysql_query("SELECT id FROM $tablename_includefilev2 WHERE item_name = \"$username\" ",$dbf->conn);
				$itemtablerow = mysql_fetch_assoc($itemtableresult);
				$itemtablerowid=$itemtablerow['id'];

				$next_id=$itemtablerowid;
				$Item_row_id = $next_id;

				
	
			}
	





		$result_image = mysql_query("SELECT item_image FROM $trans_tablename_includefilev2 WHERE id=\"$id\"",$dbf->conn);
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


	  
		
		  
		  
		 
		
		     if ($transaction_id == "") {

				
			$check_trannumtable="SELECT id FROM $transnumbertable_includefilev2 WHERE processing = \"$username\"";
			if(mysql_num_rows(mysql_query($check_trannumtable,$dbf->conn))){
				$trannumberresult = mysql_query("SELECT id FROM $transnumbertable_includefilev2 WHERE processing = \"$username\" ",$dbf->conn);
				$trantablerow = mysql_fetch_assoc($trannumberresult);
				$trantablerowid=$trantablerow['id'];
				$avaliable_trans_number=$trantablerowid;
				$trans_id_value=$trantablerowid;
			}else{

				$transnumbers_field_names=array('processing');
				$transnumbers_field_data=array("$username");
				$dbf->insert($transnumbers_field_names,$transnumbers_field_data,$transnumbertable_includefilev2,true);

				$trannumberresult = mysql_query("SELECT id FROM $transnumbertable_includefilev2 WHERE processing = \"$username\" ",$dbf->conn);
				$trantablerow = mysql_fetch_assoc($trannumberresult);
				$trantablerowid=$trantablerow['id'];
				$avaliable_trans_number=$trantablerowid;
				$trans_id_value=$trantablerowid;
				}
	
				
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
				 

					  
		       
		      }else{

		
			
				

				 } 
		      

		     

$startofnewyear="no";		    
if (date("m")==01){


$rundate_upcrestart = date("m/d/Y");
$truncatedupctable=$cfg_jedataFromitemdir.$cfg_storeDirname.'/'.'Donetruncatingupctable.txt';

if (file_exists("$truncatedupctable")) {
  
}else{
             
    $upc_tablename_includefilev2="$cfg_tableprefix".'upc_numbers';
	$upctruncate_query="TRUNCATE TABLE $upc_tablename_includefilev2";
	$upctruncate_result=mysql_query($upctruncate_query,$dbf->conn);
	$startofnewyear="yes";
	shell_exec("echo 'New Year start Restarted upc Number. UPC Table Truncated on '$rundate_upcrestart > $truncatedupctable"); 
}

}else{
  unlink($truncatedupctable); 
}


				$check_upctable="SELECT id FROM $upc_tablename_includefilev2 WHERE itemupc = '' AND processing = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_upctable,$dbf->conn))){

					$upctableresult = mysql_query("SELECT id FROM $upc_tablename_includefilev2 WHERE itemupc = '' AND processing = \"$username\" ",$dbf->conn);
					$upctablerow = mysql_fetch_assoc($upctableresult);
					$upctablerowid=$upctablerow['id'];
					$Auto_increment_upc=$upctablerowid;
				
				}else{
					$upcfieldnames=array('processing');
					$upcfielddata=array("$username");
					$dbf->insert($upcfieldnames,$upcfielddata,$upc_tablename_includefilev2,true);

					$upctableresult = mysql_query("SELECT id FROM $upc_tablename_includefilev2 WHERE itemupc = '' AND processing = \"$username\" ",$dbf->conn);
					$upctablerow = mysql_fetch_assoc($upctableresult);
					$upctablerowid=$upctablerow['id'];
					$Auto_increment_upc=$upctablerowid;
				}


if ($startofnewyear=="yes") {

  $upcletter = 'A';

}else{
  
  $upc_tablename_includefilev2="$cfg_tableprefix".'upc_numbers';
  
  
  $upc_query="SELECT * FROM $upc_tablename_includefilev2 where itemupc <> '' ORDER BY ID DESC LIMIT 1 "; 
  $upc_result=mysql_query($upc_query,$dbf->conn);
  $upc_row = mysql_fetch_assoc($upc_result);

  $upcletter = substr($upc_row['itemupc'],2,1);
  
}

$avaliable_upc_number=$Auto_increment_upc;

if ($Auto_increment_upc == $cfg_maxupc_number) {  

    $upctruncate_query="TRUNCATE TABLE $upc_tablename_includefilev2";
	$upctruncate_result=mysql_query($upctruncate_query,$dbf->conn);
	

				$check_upctable="SELECT id FROM $upc_tablename_includefilev2 WHERE itemupc = '' AND processing = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_upctable,$dbf->conn))){

					$upctableresult = mysql_query("SELECT id FROM $upc_tablename_includefilev2 WHERE itemupc = '' AND processing = \"$username\" ",$dbf->conn);
					$upctablerow = mysql_fetch_assoc($upctableresult);
					$upctablerowid=$upctablerow['id'];
					$Auto_increment_upc=$upctablerowid;
				
				}else{
					$upcfieldnames=array('processing');
					$upcfielddata=array("$username");
					$dbf->insert($upcfieldnames,$upcfielddata,$upc_tablename_includefilev2,true);

					$upctableresult = mysql_query("SELECT id FROM $upc_tablename_includefilev2 WHERE itemupc = '' AND processing = \"$username\" ",$dbf->conn);
					$upctablerow = mysql_fetch_assoc($upctableresult);
					$upctablerowid=$upctablerow['id'];
					$Auto_increment_upc=$upctablerowid;
				}
			
	
	
	
	
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


				$sharedinventory_tablename='inventory';
			 	$check_invtable="SELECT id FROM $sharedinventory_tablename WHERE upc = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_invtable,$shareINVdbf->conn))){

					$invtableresult = mysql_query("SELECT id FROM $sharedinventory_tablename WHERE upc = \"$username\" ",$shareINVdbf->conn);
					$invtablerow = mysql_fetch_assoc($invtableresult);
					$invtablerowid=$invtablerow['id'];
					$next_inventorytblrowid=$invtablerowid;
				
				}else{
					$invfieldnames=array('upc');
					$invfielddata=array("$username");
					$shareINVdbf->insert($invfieldnames,$invfielddata,$sharedinventory_tablename,true);

					$invtableresult = mysql_query("SELECT id FROM $sharedinventory_tablename WHERE upc = \"$username\" ",$shareINVdbf->conn);
					$invtablerow = mysql_fetch_assoc($invtableresult);
					$invtablerowid=$invtablerow['id'];
					$next_inventorytblrowid=$invtablerowid;
				
				}

	 
				
				
		
		
				$supplier_tablename_includefilev2="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename_includefilev2 where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);

   			$supplierphone=$supplier_row['phone_number'];
		  
		
		
		
		  $supplier_catalogue_number = '';
		  $quantity = 1;
		  $reorder_level = 0;
		
		
		
		
	   $field_names=array('item_number','category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	   $field_data=array("$avaliable_upc_number","$category_id","$supplier_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	 
	  
	  
	  
	   $addtoinventory_scrapgold='N';
	   $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','kindsize','numstone','brandname','serialnumber','imei1','imei2','itemmodel','totalowner','itemfound','founddesc','addtoinventory_scrapgold','report_item','scrap_or_resale','item_image');
	   $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$description","$kindsize","$numstone","$brandname","$serialnumber","$imei1","$imei2","$itemmodel","$totalowner","$itemfound","$founddesc","$addtoinventory_scrapgold","$reportitem","$jewelrybuy_type","$image");	
	   
	  
	   $upcnumbers_field_names=array('itemupc','processing');
	   $upcnumbers_field_data=array("$avaliable_upc_number","");
	  
	 if ($transaction_id == "") {
		$transnumbers_field_names=array('transaction_number','processing');
		$transnumbers_field_data=array("$avaliable_trans_number","");
		
		
		}

		$dbf->update($field_names,$field_data,$tablename_includefilev2,$itemtablerowid,true);
		$dbf->update($trans_field_names,$trans_field_data,$trans_tablename_includefilev2,$transTableRowID,true);
		$dbf->update($upcnumbers_field_names,$upcnumbers_field_data,$upc_tablename_includefilev2,$upctablerowid,true);


		
		
		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	    $sharedInventory_field_data=array("$avaliable_upc_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image","$curdate");
		$sharedinventory_tablename='inventory';
		$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,$invtablerowid,true); 

	

	  
}
		
?>