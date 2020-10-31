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



	$userstable="$cfg_tableprefix".'users';
	$userid=$_SESSION['session_user_id'];
    $user_result = mysql_query("SELECT type FROM $userstable WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $usertype=$usertable_row['type'];
    
	




$tablename="$cfg_tableprefix".'item_transactions';

$upc_tablename="$cfg_tableprefix".'upc_numbers';
$transnumbertable=$cfg_tableprefix.'transaction_numbers';
$field_names=null;
$field_data=null;
$id=-1;

	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];

	}
	
	
	
	
	

	elseif(isset($_POST['id']) and isset($_POST['action']) )
	
	
	{
			
		$action=$_POST['action'];
		$id = $_POST['id'];
			
		$workingid = $id; 
		
		
		$Item_row_id = $_POST['itemrowid'];
		$supplier_id = $_POST['supplier_id'];
		$category_id = $_POST['category_id'];
		$article_id = $_POST['article_id'];
		$item_gender = $_POST['item_gender'];
		$material_type = $_POST['material_type'];
		$jewelrybuy_type = $_POST['jewelrybuy_type'];
		$kindsize = $_POST['kindsize'];
		$numstone = $_POST['numstone'];
		$description = $_POST['description'];
		$brandname = $_POST['brandname'];
		$serialnumber = $_POST['serialnumber'];
		$imei1 = $_POST['imei1'];
		$imei2 = $_POST['imei2'];
		$itemmodel = $_POST['itemmodel'];
		$totalowner = $_POST['totalowner'];
		$itemfound = $_POST['itemfound'];
		$founddesc = $_POST['founddesc'];
		$reportitem = $_POST['reportitem'];
		
		$transactionfrom_panel = $_POST['transaction_from_panel'];
		$addtoinventory_scrapgold = $_POST['addtoinventory_scrapgold'];


 if ($usertype=="Admin"){				
	$purchasedate1 = $_POST['purchasedate']; 
	$purchasedate1 = str_replace("/", "", "$purchasedate1");
    $purchasedate1 = str_replace("-", "", "$purchasedate1");
	$purchasedate_month = substr("$purchasedate1",0,2);
	$purchasedate_day = substr("$purchasedate1",2,2);
	$purchasedate_year = substr("$purchasedate1",4,4);
	$purchasedate=$purchasedate_year.$purchasedate_month.$purchasedate_day;
		
        $purchasetime1 = $_POST['purchasetime'];		
        $purchasetime  = date("H:i:s", strtotime("$purchasetime1")); 
     
        

		
		
	
		if(isset($_SERVER['HTTP_USER_AGENT'])){
         $agent = $_SERVER['HTTP_USER_AGENT'];
    }

    if(strlen(strstr($agent,"Chrome")) > 0 ){
        $browser = 'chrome';
    }
    if($browser=='chrome'){
       
		
    }
	
	
		
		
		
	}				

				
				
				
		
		
		
		
		
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number']; 
		
	
		
		$inventorytblrowid = $_POST['inventorytblrowid']; 
		$itemtranstbl_rowid = $_POST['itemtranstblrowid']; 
	    $transaction_id = $_POST['transaction_id']; 

		
		
	
	
		
		
		
		
		if($action=="insert")
		{
		 
		 
		 
		}
		
		$buy_price = number_format($_POST['buy_price'],2,'.', '');
		
		$enteredunitprice=$_POST['unit_price'];
		if (($enteredunitprice == "") or ($enteredunitprice == " "))
         {		
		   $enteredunitprice = 0;
		 } 
		 $unit_price = number_format($enteredunitprice,2,'.', '');
		 
		
		
		$tax_percent = $_POST['tax_percent'];
		$supplier_catalogue_number = $_POST['supplier_catalogue_number'];
		$quantity = $_POST['quantity'];
		$reorder_level= $_POST['reorder_level'];
		
		
		$image= $_FILES['item_image']['name']; 
		
	    $curdate = date("Y-m-d");
	    
		
        $curtime24=date("H:i:s"); 
		
        
		
		
		
		
	   
	   $upc=$item_number;
	 
	 
	 
	
	   
	   
	
	
	   
        $pos = strpos($supplier_id, '-', 1); 
        $supplier_id=substr($supplier_id,0,$pos);
	
	   
	   
	   
	   
	     $articletable = "$cfg_tableprefix".'articles';
	     $item_name=$dbf->idToField("$articletable",'article',"$article_id");
	     
	     if ($item_name == "Other"){
	     $item_name=substr($description,0,30);
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




		
		
		
		
		
		
		
		if($category_id=='' or $supplier_id=='' )
		
		{
			echo "$lang->forgottenFields";
			exit();
		}
		
		
		elseif( (!is_numeric($buy_price)) or (!is_numeric($unit_price)) )
		{
			echo "$lang->mustEnterNumeric";
			exit();
		}
		else
		{
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', ''); 
			
			
	        $field_names=array('item_number','category_id','supplier_id','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image');
			$field_data=array("$item_number","$category_id","$supplier_id","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image");	
	
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
		      $Inserted_id = $next_id;
		      
		      
		      $itembarcode=$cfg_store_code.$next_id;
		      $id=$next_id;	
         	  $item_number=$itembarcode;	      
		      
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
		     
			 
			 
			 
			          $auto_increment_table="'"."$cfg_tableprefix".'item_transactions'."'";
		              $trans_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
                      $trans_row = mysql_fetch_array($trans_r);
                      $trans_Auto_increment = $trans_row['Auto_increment'];
		      	      $itemtranstbl_rowid=$trans_Auto_increment;
		      	      
		       
		      }else{
		      	  
		      	  $auto_increment_table="'"."$cfg_tableprefix".'item_transactions'."'";
		      
		         $trans_r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ",$dbf->conn);
                 $trans_row = mysql_fetch_array($trans_r);
                 $trans_Auto_increment = $trans_row['Auto_increment'];
             
		      
		         $trans_next_id=$trans_Auto_increment;
		      	 $upc=$trans_next_id; 
		      	  $itemtranstbl_rowid=$trans_Auto_increment;
		      	  $trans_id_value = $transaction_id;
		         
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
		  
		
		
		
		
	   
	   
	  
	  
	  $field_names=array('item_number','category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','brandname','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	  $field_data=array("$avaliable_upc_number","$category_id","$supplier_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber","$brandname","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	 
	 
	   $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','kindsize','numstone','brandname','serialnumber','itemmodel','totalowner','itemfound','founddesc','transaction_from_panel','item_image','date','time');
	   $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$description","$kindsize","$numstone","$brandname","$serialnumber","$itemmodel","$totalowner","$itemfound","$founddesc","additem","$image","$curdate","$curtime24");	
	  
	   $upcnumbers_field_names=array('itemupc');
	   $upcnumbers_field_data=array("$avaliable_upc_number");	
	  
		$dbf->insert($field_names,$field_data,$tablename,true);
		$dbf->insert($trans_field_names,$trans_field_data,$trans_tablename,true);
		$dbf->insert($upcnumbers_field_names,$upcnumbers_field_data,$upc_tablename,true);
		
		
		
        if ($cfg_enableimageupload_items == "yes" and $cfg_imagesnapmethod == "online"){
		   echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pitemslink1\">";
		 
		}else{
	        echo "<meta http-equiv=refresh content=\"0; URL=form_items.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
	    } 
		
		
		
		
		
		
		
		

    
	 

     
		
	   
	   
	   

  

	break;
		
	case $action=="update":
		
	
	$addjewelryforresale = 'N'; 
	if ($cfg_processForm_version=="1" and $transactionfrom_panel == "jewelry" and $Item_row_id == 0 and $jewelrybuy_type == "resale"){
	    $transTableRowID=$id; 
		require 'process_form_include_v1.php';
	    $addjewelryforresale = 'Y'; 	  
	}
	
	
	if ($cfg_processForm_version=="2" and $transactionfrom_panel == "jewelry" and $Item_row_id == 0 and $jewelrybuy_type == "resale"){
	    $transTableRowID=$id; 
		require 'process_form_include_v2.php';
		 $addjewelryforresale = 'Y'; 
	}
	
	
	
		
		
		
		
	if ($addjewelryforresale == "N"){	
		$result_image = mysql_query("SELECT item_image FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		$row_image = mysql_fetch_assoc($result_image);
		 
		if ($image == "" || $image == " ")
		{
		
		$image=$row_image['item_image']; 
		  
			
		}
		else
		{
		
		 
		 if ($cfg_data_outside_storedir == "yes"){
	        $imagelocation=$cfg_data_itemIMGpathdir;
         }else{
	         $imagelocation='images/';
          } 
		 
		 
		 $image=$row_image['item_image'];
		 if ($image != "" || $image != " "){
		     $itemimage_file=$imagelocation.$image;
	         if(file_exists($itemimage_file)){
                unlink($itemimage_file);
             }   
		  }	 
			 
		  
	
		if ($transactionfrom_panel == "jewelry" and $Item_row_id == 0){
    	     $thisname=$cfg_store_code.$id.'T'.$transaction_id;
			 $image=$imagelocation.$thisname;
		          
		
		}else {
		      $thisname=$cfg_store_code.$Item_row_id;
			  $image=$imagelocation.$thisname;
		}
		
		
		
		
		
		
		$newname = imageupload($image,$thisname);
		$image=$newname;
	  }
	}  
	  
		
        
	   
	   
	   
	     $articletable = "$cfg_tableprefix".'articles';
	     $item_name=$dbf->idToField("$articletable",'article',"$article_id");
	     
	     if ($item_name == "Other"){
	     $item_name=substr($description,0,30);
	      }
	  	
		
		
		
		
		


 if ($usertype=="Admin"){
	 
	
	 

if ($transactionfrom_panel == "jewelry" and $jewelrybuy_type == "resale") {
		
			$quantity = 1;
		    $reorder_level = 0;
			
			
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');
			$field_names=array('category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','buy_price','unit_price','total_cost','quantity','reorder_level','item_image','date');
			$field_data=array("$category_id","$supplier_id","$article_id","$inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$buy_price","$unit_price","$total_cost","$quantity","$reorder_level","$image","$purchasedate");	
		 
		 	$sharedInventory_field_names=array('article','description','price','storecode','storelocation','storephone','quantity','itemimage','date');
			$sharedInventory_field_data=array("$item_name","$description","$unit_price","$cfg_store_code","$cfg_address","$cfg_phone","$quantity","$image","$purchasedate");
	    
		}else if ($transactionfrom_panel == "jewelry" and $jewelrybuy_type == "scrap") { 
				$quantity = 0;
		    $reorder_level = 0;
			
			
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');
			$field_names=array('category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','buy_price','unit_price','total_cost','quantity','reorder_level','item_image','date');
			$field_data=array("$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$buy_price","$unit_price","$total_cost","$quantity","$reorder_level","$image","$purchasedate");	
		 
		 $sharedInventory_field_names=array('article','description','price','storecode','storelocation','storephone','quantity','itemimage','date');
			$sharedInventory_field_data=array("$item_name","$description","$unit_price","$cfg_store_code","$cfg_address","$cfg_phone","$quantity","$image","$purchasedate");
	 
	 }else if ($transactionfrom_panel == "jewelry" and $jewelrybuy_type == " " and $addtoinventory_scrapgold == "Y") { 
			$quantity = 1;
		    $reorder_level = 0;
			
			
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');
			$field_names=array('category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','buy_price','unit_price','total_cost','quantity','reorder_level','item_image','date');
			$field_data=array("$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$buy_price","$unit_price","$total_cost","$quantity","$reorder_level","$image","$purchasedate");	
		 
		 
			$sharedInventory_field_names=array('article','description','price','storecode','storelocation','storephone','quantity','itemimage','date');
			$sharedInventory_field_data=array("$item_name","$description","$unit_price","$cfg_store_code","$cfg_address","$cfg_phone","$quantity","$image","$purchasedate");
	  
		
		
		}else{
	      
		  
		    
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');
			$field_names=array('category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','buy_price','unit_price','total_cost','item_image','date');
			$field_data=array("$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$buy_price","$unit_price","$total_cost","$image","$purchasedate");	
		 
			$sharedInventory_field_names=array('article','description','price','storecode','storelocation','storephone','itemimage','date');
			$sharedInventory_field_data=array("$item_name","$description","$unit_price","$cfg_store_code","$cfg_address","$cfg_phone","$image","$purchasedate");
	    }
	  
		 
		 

	 
	    if ($transactionfrom_panel == "jewelry" and $addtoinventory_scrapgold == "Y"  and $jewelrybuy_type == ""){
	
	       $trans_field_names=array('itemrow_id','supplier_id','category_id','article_id','item_gender','material_type','scrap_or_resale','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','totalowner','itemfound','founddesc','addtoinventory_scrapgold','report_item','buy_price','unit_price','item_image','date','time');
	       $trans_field_data=array("$Item_row_id","$supplier_id","$category_id","$article_id","$item_gender","$material_type","$jewelrybuy_type","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$totalowner","$itemfound","$founddesc","$addtoinventory_scrapgold","$reportitem","$buy_price","$unit_price","$image","$purchasedate","$purchasetime");	
	   
	     
		 }else{
		$trans_field_names=array('itemrow_id','supplier_id','category_id','article_id','item_gender','material_type','scrap_or_resale','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','totalowner','itemfound','founddesc','addtoinventory_scrapgold','report_item','buy_price','unit_price','item_image','date','time');
	     $trans_field_data=array("$Item_row_id","$supplier_id","$category_id","$article_id","$item_gender","$material_type","$jewelrybuy_type","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$totalowner","$itemfound","$founddesc","$addtoinventory_scrapgold","$reportitem","$buy_price","$unit_price","$image","$purchasedate","$purchasetime");	
	    }
 
 
 
 
 
 
		
		
}else{		

		if ($transactionfrom_panel == "jewelry" and $jewelrybuy_type == "resale") {
			
			
			
			$quantity = 1;
		    $reorder_level = 0;
			
			
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');
			$field_names=array('category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','buy_price','unit_price','total_cost','quantity','reorder_level','item_image');
			$field_data=array("$category_id","$supplier_id","$article_id","$inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$buy_price","$unit_price","$total_cost","$quantity","$reorder_level","$image");	
		 
		 
			
			
			$sharedInventory_field_names=array('article','description','price','storecode','storelocation','storephone','quantity','itemimage');
			$sharedInventory_field_data=array("$item_name","$description","$unit_price","$cfg_store_code","$cfg_address","$cfg_phone","$quantity","$image");
	    
		}else if ($transactionfrom_panel == "jewelry" and $jewelrybuy_type == "scrap") { 
			
			
			
			$quantity = 0;
		    $reorder_level = 0;
			
			
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');
			$field_names=array('category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','buy_price','unit_price','total_cost','quantity','reorder_level','item_image');
			$field_data=array("$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$buy_price","$unit_price","$total_cost","$quantity","$reorder_level","$image");	
		 
		 
			
			
			$sharedInventory_field_names=array('article','description','price','storecode','storelocation','storephone','quantity','itemimage');
			$sharedInventory_field_data=array("$item_name","$description","$unit_price","$cfg_store_code","$cfg_address","$cfg_phone","$quantity","$image");
	 
	 }else if ($transactionfrom_panel == "jewelry" and $jewelrybuy_type == " " and $addtoinventory_scrapgold == "Y") { 
			
			
			
			
			$quantity = 1;
		    $reorder_level = 0;
			
			
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');
			$field_names=array('category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','buy_price','unit_price','total_cost','quantity','reorder_level','item_image');
			$field_data=array("$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$buy_price","$unit_price","$total_cost","$quantity","$reorder_level","$image");	
		 
		 
			
			
			$sharedInventory_field_names=array('article','description','price','storecode','storelocation','storephone','quantity','itemimage');
			$sharedInventory_field_data=array("$item_name","$description","$unit_price","$cfg_store_code","$cfg_address","$cfg_phone","$quantity","$image");
	  
		
		
		}else{
	      
		  
		    
			$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');
			$field_names=array('category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','buy_price','unit_price','total_cost','item_image');
			$field_data=array("$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$buy_price","$unit_price","$total_cost","$image");	
		 
			$sharedInventory_field_names=array('article','description','price','storecode','storelocation','storephone','itemimage');
			$sharedInventory_field_data=array("$item_name","$description","$unit_price","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	    }
	  
		 
		 

	 
	    if ($transactionfrom_panel == "jewelry" and $addtoinventory_scrapgold == "Y"  and $jewelrybuy_type == ""){
	
	       $trans_field_names=array('itemrow_id','supplier_id','category_id','article_id','item_gender','material_type','scrap_or_resale','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','totalowner','itemfound','founddesc','addtoinventory_scrapgold','report_item','buy_price','unit_price','item_image');
	       $trans_field_data=array("$Item_row_id","$supplier_id","$category_id","$article_id","$item_gender","$material_type","$jewelrybuy_type","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$totalowner","$itemfound","$founddesc","$addtoinventory_scrapgold","$reportitem","$buy_price","$unit_price","$image");	
	   
	     
		 }else{
		
	    
	    
		$trans_field_names=array('itemrow_id','supplier_id','category_id','article_id','item_gender','material_type','scrap_or_resale','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','description','totalowner','itemfound','founddesc','addtoinventory_scrapgold','report_item','buy_price','unit_price','item_image');
	     $trans_field_data=array("$Item_row_id","$supplier_id","$category_id","$article_id","$item_gender","$material_type","$jewelrybuy_type","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$description","$totalowner","$itemfound","$founddesc","$addtoinventory_scrapgold","$reportitem","$buy_price","$unit_price","$image");	
	    }

} 
	  
	  
	  
			
			
			
			
	  
	  
	
	
	  
	   
		
		
		
		
		if ($addjewelryforresale == "N"){
		 	$trans_tablename="$cfg_tableprefix".'item_transactions';
			$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$id,true);
		}
		
		
		if ($Item_row_id > 0 and $addjewelryforresale == "N"){ 
		$tablename="$cfg_tableprefix".'items';
		$dbf->update($field_names,$field_data,$tablename,$Item_row_id,true);
		}
		
		
		
		
		
		
		
		
		
		
		
		
			
			
			
			
			
		     
		 
		 
		 
	
			$shareINV_tablename1='inventory';
			$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$shareINV_tablename1,$inventorytblrowid,true);
			
	
		
        if ($cfg_enableimageupload_items == "yes" and $cfg_imagesnapmethod == "online"){ 
		
		    if ($addjewelryforresale == "Y" ){ 
				$inventorytblrowid = $next_inventorytblrowid;
			}
		
	       echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&itemrowid=$Item_row_id&inventorytblrowid=$inventorytblrowid&itemtranstbl_rowid=$id&comingfrom=processitems&redirectto=mitemslink1\">";
	    
       
		
	     
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


if(($action=="update") and ($cfg_enable_PopUpUpdateform=="yes") and ($cfg_imagesnapmethod == "pc"))
{
	echo "<meta http-equiv=refresh content=\"0; URL=updatedone.php\">";
}






?>

<table border="0" cellpadding="1" cellspacing="1" width="70%">
<tr>
<TD>


<br />
<br />
<center><a href="manage_item_trans.php">Go Back to Manage Item Transactions</a></center>

</TD>


</tr>

</table>



</body>
</html>