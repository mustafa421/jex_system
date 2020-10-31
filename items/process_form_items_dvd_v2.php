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


$userstable = $cfg_tableprefix.'users';
$userid=$_SESSION['session_user_id'];
$auth = $dbf->idToField($userstable,'type',$_SESSION['session_user_id']);
$username = $dbf->idToField($userstable,'username',$_SESSION['session_user_id']);




$tablename="$cfg_tableprefix".'items';
$trans_tablename="$cfg_tableprefix".'item_transactions';
$transnumbertable=$cfg_tableprefix.'transaction_numbers';
$upc_tablename="$cfg_tableprefix".'upc_numbers';
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
	
    $dvdupc=$item_number;
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
		
		
		   




          
		 


		
		
		  
		  
		
				$check_itemtable="SELECT id FROM $tablename WHERE item_name = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_itemtable,$dbf->conn))){
				
				$itemtableresult = mysql_query("SELECT id FROM $tablename WHERE item_name = \"$username\" ",$dbf->conn);
				$itemtablerow = mysql_fetch_assoc($itemtableresult);
				$itemtablerowid=$itemtablerow['id'];

				$next_id=$itemtablerowid;
				$Item_row_id = $next_id;
				
				}else{

		 		$itemstable_field_names=array('item_name');
				$itemtable_field_data=array("$username");
				$dbf->insert($itemstable_field_names,$itemtable_field_data,$tablename,true);
				
				$itemtableresult = mysql_query("SELECT id FROM $tablename WHERE item_name = \"$username\" ",$dbf->conn);
				$itemtablerow = mysql_fetch_assoc($itemtableresult);
				$itemtablerowid=$itemtablerow['id'];

				$next_id=$itemtablerowid;
				$Item_row_id = $next_id;
				}

		
		     
		     if ($transaction_id == "") {
		     	
			
			
			
			
			
		
			
			
			




				
		



			
			$check_trannumtable="SELECT id FROM $transnumbertable WHERE processing = \"$username\"";
			if(mysql_num_rows(mysql_query($check_trannumtable,$dbf->conn))){
				$trannumberresult = mysql_query("SELECT id FROM $transnumbertable WHERE processing = \"$username\" ",$dbf->conn);
				$trantablerow = mysql_fetch_assoc($trannumberresult);
				$trantablerowid=$trantablerow['id'];
				$avaliable_trans_number=$trantablerowid;
				$trans_id_value=$trantablerowid;
			}else{

				$transnumbers_field_names=array('processing');
				$transnumbers_field_data=array("$username");
				$dbf->insert($transnumbers_field_names,$transnumbers_field_data,$transnumbertable,true);

				$trannumberresult = mysql_query("SELECT id FROM $transnumbertable WHERE processing = \"$username\" ",$dbf->conn);
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
				
	
				
				$check_trantable="SELECT id FROM $trans_tablename WHERE supplier_phone = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_trantable,$dbf->conn))){
				$itemtranresult = mysql_query("SELECT id FROM $trans_tablename WHERE supplier_phone = \"$username\" ",$dbf->conn);
				$itemtrantablerow = mysql_fetch_assoc($itemtranresult);
				$itemtrantablerowid=$itemtrantablerow['id'];
				$itemtranstbl_rowid=$itemtrantablerowid;
				
				
				}else{
				$itemtransfieldnames=array('supplier_phone');
	            $itemtransfielddata=array("$username");
	            $dbf->insert($itemtransfieldnames,$itemtransfielddata,$trans_tablename,true);

				$itemtranresult = mysql_query("SELECT id FROM $trans_tablename WHERE supplier_phone = \"$username\" ",$dbf->conn);
				$itemtrantablerow = mysql_fetch_assoc($itemtranresult);
				$itemtrantablerowid=$itemtrantablerow['id'];
				$itemtranstbl_rowid=$itemtrantablerowid;
				}
				
			  
		
		      }else{
			  
			  

		      




			  


			
				$check_trantable="SELECT id FROM $trans_tablename WHERE supplier_phone = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_trantable,$dbf->conn))){
				
				$itemtranresult = mysql_query("SELECT id FROM $trans_tablename WHERE supplier_phone = \"$username\" ",$dbf->conn);
				$itemtrantablerow = mysql_fetch_assoc($itemtranresult);
				$itemtrantablerowid=$itemtrantablerow['id'];
				$itemtranstbl_rowid=$itemtrantablerowid;
				
				  $trans_next_id=$itemtranstbl_rowid;
		      	 $trans_id_value = $transaction_id;
				
				}else{
				$itemtransfieldnames=array('supplier_phone');
	            $itemtransfielddata=array("$username");
	            $dbf->insert($itemtransfieldnames,$itemtransfielddata,$trans_tablename,true);

				$itemtranresult = mysql_query("SELECT id FROM $trans_tablename WHERE supplier_phone = \"$username\" ",$dbf->conn);
				$itemtrantablerow = mysql_fetch_assoc($itemtranresult);
				$itemtrantablerowid=$itemtrantablerow['id'];
				$itemtranstbl_rowid=$itemtrantablerowid;
				
				 $trans_next_id=$itemtranstbl_rowid;
		      	 $trans_id_value = $transaction_id;
				 }
			


				  }	
		      
		      
		      
          
          

		      
          
          
          
          
          

		      $curdate = date("Y-m-d"); 

		  
		  
		  
		  
		  
		    





		     
		
		
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
	   
	   
	   
	  
	   $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','brandname','serialnumber','totalowner','itemfound','founddesc','transaction_from_panel','item_image','date','time');
	   $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$dvdupc","$buy_price","$unit_price","$description","$brandname","$serialnumber","$totalowner","$itemfound","$founddesc","adddvd","$image","$curdate","$curtime24");	

	 if ($transaction_id == "") {
		$transnumbers_field_names=array('transaction_number','processing'); 
		$transnumbers_field_data=array("$avaliable_trans_number",""); 
		$dbf->update($transnumbers_field_names,$transnumbers_field_data,$transnumbertable,$trantablerowid,true); 
		}
	
		$dbf->update($field_names,$field_data,$tablename,$id,true);
		$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtrantablerowid,true); 

   	
   	
		
		
		 $shareINV_tablename='inventory';
	     $invtable_query="SELECT * FROM $shareINV_tablename WHERE upc = $item_number";
		 $invtable_result=mysql_query($invtable_query,$shareINVdbf->conn);
		 $invtable_row = mysql_fetch_assoc($invtable_result);
   	     $invtable_rowid=$invtable_row['id'];
		 
		 
		 $sharedInventory_field_names=array('quantity');
	     $sharedInventory_field_data=array("$quantity");
		 
		 $shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$shareINV_tablename,$invtable_rowid,true);

	    
	
	    
		 
	   
   	
   	
   	 $dvdtitleINcatalog=$_POST['dvdtitle_in_catalog'];
		 
   	
   	  if ($dvdtitleINcatalog=="no") {
   	 
   	       $dvdcatalog_field_names=array('title','upc');
	       $dvdcatalog_field_data=array("$description","$item_number");	
	       $dvdcatalog_tablename='dvd_catalog';
   	     $commondbf->insert($dvdcatalog_field_names,$dvdcatalog_field_data,$dvdcatalog_tablename,true);
   	  
   	  
   	     $jedvdcatalog_field_names=array('title','upc');
	       $jedvdcatalog_field_data=array("$description","$item_number");	
	       $jedvdcatalog_tablename='jeentered_dvdtitles';
   	     $commondbf->insert($jedvdcatalog_field_names,$jedvdcatalog_field_data,$jedvdcatalog_tablename,true);
   	  
   	      
   	  
   	  }
   	
   	
   	
		  
	    


        if ($cfg_enableimageupload_dvd == "yes" and $cfg_imagesnapmethod == "online"){  
		   
            
            if ($cfg_dvdlookup_version=="2"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pdvdlink1\">";
            }else if ($cfg_dvdlookup_version=="3"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pdvdlink1v3\">";

			}else{
	            
				echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pdvdlink2\">";
	        }	  			
			
		    
		}else{ 
		
            
		    if ($cfg_dvdlookup_version=="2"){ 
		         echo "<meta http-equiv=refresh content=\"0; URL=form_items_dvd_v2.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
		    }else if ($cfg_dvdlookup_version=="3"){ 
		         echo "<meta http-equiv=refresh content=\"0; URL=form_items_dvd_v3.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";

				 }else{
	             echo "<meta http-equiv=refresh content=\"0; URL=form_items_dvd.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
	        }	 
   			
         }
  
  
  } else {

   
		
	  
	  
	  
	  $field_names=array('item_number','category_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','supplier_id','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	  $field_data=array("$item_number","$category_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$supplier_id","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	  
	  
	    
	    
	  
	   $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','brandname','serialnumber','transaction_from_panel','item_image','date','time');
	   $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$dvdupc","$buy_price","$unit_price","$description","$brandname","$serialnumber","adddvd","$image","$curdate","$curtime24");	

	 if ($transaction_id == "") {
		$transnumbers_field_names=array('transaction_number','processing'); 
		$transnumbers_field_data=array("$avaliable_trans_number",""); 
		$dbf->update($transnumbers_field_names,$transnumbers_field_data,$transnumbertable,$trantablerowid,true); 
		}
		


		
		
		$dbf->update($field_names,$field_data,$tablename,$itemtablerowid,true);
		$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtrantablerowid,true);
		

		
		
		
		
		
		$viewinvimage="$image";
		$item_catogory='Video DVD';
		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	    $sharedInventory_field_data=array("$item_number","$item_catogory","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$viewinvimage","$curdate");
		$sharedinventory_tablename='inventory';

		$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,$invtablerowid,true);
		
		
		
		
		
   	 $dvdtitleINcatalog=$_POST['dvdtitle_in_catalog'];
		 
   	
   	  if ($dvdtitleINcatalog=="no") {
   	 
   	     $dvdcatalog_field_names=array('title','upc');
	       $dvdcatalog_field_data=array("$description","$item_number");	
	       $dvdcatalog_tablename='dvd_catalog';
   	     $commondbf->insert($dvdcatalog_field_names,$dvdcatalog_field_data,$dvdcatalog_tablename,true);
   	  
   	  
   	  
   	     $jedvdcatalog_field_names=array('title','upc');
	       $jedvdcatalog_field_data=array("$description","$item_number");	
	       $jedvdcatalog_tablename='jeentered_dvdtitles';
   	     $commondbf->insert($jedvdcatalog_field_names,$jedvdcatalog_field_data,$jedvdcatalog_tablename,true);
   	  
   	  
   	  }
   	
		
		
		
		
		
		
		
		
   
   if ($cfg_enableimageupload_dvd == "yes" and $cfg_imagesnapmethod == "online"){  
		   
            
            if ($cfg_dvdlookup_version=="2"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pdvdlink1\">";
            }else if ($cfg_dvdlookup_version=="3"){ 
		         
				 echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pdvdlink1v3\">";

				 }else{
	            
				echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pdvdlink2\">";
	        }	  			
		
		}else{ 


            if ($cfg_dvdlookup_version=="2"){
		        echo "<meta http-equiv=refresh content=\"0; URL=form_items_dvd_v2.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
            }else if ($cfg_dvdlookup_version=="3"){
		        echo "<meta http-equiv=refresh content=\"0; URL=form_items_dvd_v3.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";

				}else{
                echo "<meta http-equiv=refresh content=\"0; URL=form_items_dvd.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
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
	  
		

		
		

	



	  
	 
	 
	 
	
	
	   $field_names=array('item_number','category_id','article_id','supplier_id','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	   $field_data=array("$item_number","$category_id","$article_id","$supplier_id","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	  
	
	
	
	
	  $trans_field_names=array('itemrow_id','article_id','supplier_id','supplier_phone','upc','buy_price','unit_price','item_image','date');
	  $trans_field_data=array("$id","$article_id","$supplier_id","$supplierphone","$upc","$buy_price","$unit_price","$image","$curdate");	
	  
	  $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	  $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image","$curdate");
	
	 
	 
	  
		$dbf->update($field_names,$field_data,$tablename,$id,true);
		
		
		$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtranstbl_rowid,true);
		$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$shareINV_tablename,$inventorytblrowid,true);
		
		
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