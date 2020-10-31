<?php session_start(); ?>

<html>
<head>
<script>
  function closewindow() {
    window.close();
  }
</script>
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
    $user_result = mysql_query("SELECT id,username,type FROM $userstable WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $username=$usertable_row['username'];
	$usertype=$usertable_row['type'];
	$userid=$usertable_row['id'];



$tablename="$cfg_tableprefix".'items';
$trans_tablename="$cfg_tableprefix".'item_transactions';
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
	
	
	elseif(isset($_POST['item_number']) and isset($_POST['category_id']) and isset($_POST['supplier_id']) and isset($_POST['buy_price']) and isset($_POST['unit_price']) and isset($_POST['tax_percent']) 
	and isset($_POST['supplier_catalogue_number']) and isset($_POST['quantity']) and isset($_POST['id']) and isset($_POST['action']) )
	
	{
		
		$action=$_POST['action'];
		$id = $_POST['id'];
			
		$workingid = $id; 
		
		
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number']; 
		$category_id = $_POST['category_id'];
		$supplier_id = $_POST['supplier_id'];
		$article_id = $_POST['article_id'];
		$inventorytblrowid = $_POST['inventorytblrowid']; 
		$itemtranstbl_rowid = $_POST['itemtranstblrowid']; 
	    $transaction_id = $_POST['transaction_id']; 
		$transaction_from_panel = $_POST['transaction_from_panel']; 
		
		if ($transaction_from_panel == "jewelry"){
		
		$jewelrybuy_type = $_POST['jewelrybuy_type'];
		$item_gender = $_POST['item_gender'];
		$material_type = $_POST['material_type'];
		$kindsize = $_POST['kindsize'];
		$numstone = $_POST['numstone'];
		}
		

		$serialnumber = $_POST['serialnumber'];
		$imei1 = $_POST['imei1'];
		$imei2 = $_POST['imei2'];
		$brandname = $_POST['brandname'];
		$itemsize = $_POST['itemsize'];
		$itemcolor = $_POST['itemcolor'];
		$itemmodel = $_POST['itemmodel'];
		$description = $_POST['description'];
		
		
		
		
		
		
		
		
		$itemremovedby = $_POST['itemremovedby'];
		$qtyremovedpd = $_POST['qtyremovedpd'];
		$qtyremovedjex = $_POST['qtyremovedjex'];
		$updatelinkfrompanel=$_POST['updatelinkfrompanel'];
		
		
		
		
		if ($itemremovedby=="PD"){
		$removecommentpd = $_POST['removecomment'];
		}
		if ($itemremovedby=="JEX"){
		$removecommentjex = $_POST['removecomment'];
		}
		
		
		
		
		
		
		
		
		if($action=="insert")
		{
		  $totalowner = $_POST['totalowner'];
		  $itemfound = $_POST['itemfound'];
		  $founddesc = $_POST['founddesc'];
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




		
		
		
		
		
		
		if($category_id=='' or $supplier_id=='' or $buy_price==''  or $quantity=='' or $reorder_level=='' )
		
		{
			echo "$lang->forgottenFields";
			exit();
		}
		
		elseif( (!is_numeric($buy_price)) or (!is_numeric($unit_price)) or (!is_numeric($quantity))  or (!is_numeric($reorder_level)))
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


			
		     




            
		 
		     
		    
		    
			
				$check_upctable="SELECT id FROM $upc_tablename WHERE itemupc = '' AND processing = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_upctable,$dbf->conn))){

					$upctableresult = mysql_query("SELECT id FROM $upc_tablename WHERE itemupc = '' AND processing = \"$username\" ",$dbf->conn);
					$upctablerow = mysql_fetch_assoc($upctableresult);
					$upctablerowid=$upctablerow['id'];
					$Auto_increment_upc=$upctablerowid;
				
				}else{
					$upcfieldnames=array('processing');
					$upcfielddata=array("$username");
					$dbf->insert($upcfieldnames,$upcfielddata,$upc_tablename,true);

					$upctableresult = mysql_query("SELECT id FROM $upc_tablename WHERE itemupc = '' AND processing = \"$username\" ",$dbf->conn);
					$upctablerow = mysql_fetch_assoc($upctableresult);
					$upctablerowid=$upctablerow['id'];
					$Auto_increment_upc=$upctablerowid;
				}
			 
			 
			 


if ($startofnewyear=="yes") {

  $upcletter = 'A';

}else{
  
  $upc_tablename="$cfg_tableprefix".'upc_numbers';
  
  
  $upc_query="SELECT * FROM $upc_tablename where itemupc <> '' ORDER BY ID DESC LIMIT 1 "; 
  $upc_result=mysql_query($upc_query,$dbf->conn);
  $upc_row = mysql_fetch_assoc($upc_result);

  $upcletter = substr($upc_row['itemupc'],2,1);
  
}

$avaliable_upc_number=$Auto_increment_upc;

if ($Auto_increment_upc == $cfg_maxupc_number) {  

    $upctruncate_query="TRUNCATE TABLE $upc_tablename";
	$upctruncate_result=mysql_query($upctruncate_query,$dbf->conn);
	
	
	
    
    
	
			
				$check_upctable="SELECT id FROM $upc_tablename WHERE itemupc = '' AND processing = \"$username\" ";
				if(mysql_num_rows(mysql_query($check_upctable,$dbf->conn))){

					$upctableresult = mysql_query("SELECT id FROM $upc_tablename WHERE itemupc = '' AND processing = \"$username\" ",$dbf->conn);
					$upctablerow = mysql_fetch_assoc($upctableresult);
					$upctablerowid=$upctablerow['id'];
					$Auto_increment_upc=$upctablerowid;
				
				}else{
					$upcfieldnames=array('processing');
					$upcfielddata=array("$username");
					$dbf->insert($upcfieldnames,$upcfielddata,$upc_tablename,true);

					$upctableresult = mysql_query("SELECT id FROM $upc_tablename WHERE itemupc = '' AND processing = \"$username\" ",$dbf->conn);
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
				
		     
		      
          
          

		      
          
          
          
          
          

		      

		  
		  
		  
		
		
				$supplier_tablename="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);

   			$supplierphone=$supplier_row['phone_number'];
		  
		
		
		
		
	   $field_names=array('item_number','category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	   $field_data=array("$avaliable_upc_number","$category_id","$supplier_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	 
	   $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','kindsize','numstone','brandname','serialnumber','imei1','imei2','itemmodel','totalowner','itemfound','founddesc','transaction_from_panel','item_image','date','time');
	   $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$description","$kindsize","$numstone","$brandname","$serialnumber","$imei1","$imei2","$itemmodel","$totalowner","$itemfound","$founddesc","additem","$image","$curdate","$curtime24");	
	  
	   $upcnumbers_field_names=array('itemupc','processing');
	   $upcnumbers_field_data=array("$avaliable_upc_number","");
	  
	 if ($transaction_id == "") {
		$transnumbers_field_names=array('transaction_number','processing');
		$transnumbers_field_data=array("$avaliable_trans_number","");
		
		$dbf->update($transnumbers_field_names,$transnumbers_field_data,$transnumbertable,$trantablerowid,true); 
		}
		

		$dbf->update($field_names,$field_data,$tablename,$itemtablerowid,true);
		$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtrantablerowid,true);
		$dbf->update($upcnumbers_field_names,$upcnumbers_field_data,$upc_tablename,$upctablerowid,true);





		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	    $sharedInventory_field_data=array("$avaliable_upc_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image","$curdate");
		$sharedinventory_tablename='inventory';

		$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,$invtablerowid,true); 
		
		
		
		
		
        if ($cfg_enableimageupload_items == "yes" and $cfg_imagesnapmethod == "online"){
		   echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pitemslink1\">";
		 
		}else{
	        echo "<meta http-equiv=refresh content=\"0; URL=form_items.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
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
	  
		

		
	  
	  

	
	
	
		
	
	
	




	
	
	
	
	
	
	
	
	
	
	













		$tablename = "$cfg_tableprefix".'items';
		$result = mysql_query("SELECT removedbypd,qtyremovedpd,removecommentpd,removedatepd,removedbyjex,qtyremovedjex,removecommentjex,removedatejex FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		$row = mysql_fetch_assoc($result);

		
	
	$DoNotUpdate_ItemRemoveDate="no";

	if ($itemremovedby=="PD" && $updatelinkfrompanel=="itempanel"){
	$removedbypd="PD";
	$quantity=$quantity-1;
	$qtyremovedpd=$qtyremovedpd+1;
	$removedatepd=$curdate;
	
	$curqtyremovedpd=$row['qtyremovedpd'];
	if ($curqtyremovedpd>=1){
	$removecommentpd=$row['removecommentpd'].' '.$removecommentpd;
	}
	
	
	
	
	}
	if ($itemremovedby=="JEX" && $updatelinkfrompanel=="itempanel"){
	$removedbyjex="JEX";
	$quantity=$quantity-1;
	$qtyremovedjex=$qtyremovedjex+1;
	$removedatejex=$curdate;
	
	$curqtyremovedjex=$row['qtyremovedjex'];
	if ($curqtyremovedjex>=1){
	$removecommentjex=$row['removecommentjex'].' '.$removecommentjex;
	}

	
	
	
	
	}

	if ($itemremovedby=="PD" && $updatelinkfrompanel=="pdpanel"){
		$removedbypd="PD";
		$DoNotUpdate_ItemRemoveDate="yes";
	} else if ($itemremovedby=="JEX" && $updatelinkfrompanel=="pdpanel"){
		$removedbyjex="JEX";
		$qtyremovedjex=$qtyremovedjex+1;
		$removedatejex=$curdate;
		$removecommentjex=$row['removecommentjex'].' '.$removecommentjex;
	
		$qtyremovedpd=$qtyremovedpd-1;
		if ($qtyremovedpd<=0){
		$removedbypd="";
		$removedatepd="";
		}
		
		if ($qtyremovedpd>=1){
	$removedbypd=$row['removedbypd'];
	
	$removecommentpd=$row['removecommentpd'];
	$removedatepd=$row['removedatepd'];
		}
		
	}
	
	
	if ($itemremovedby=="JEX" && $updatelinkfrompanel=="jexpanel"){
	$removedbyjex="JEX";
	$DoNotUpdate_ItemRemoveDate="yes";
	}else if ($itemremovedby=="PD" && $updatelinkfrompanel=="jexpanel"){
		$removedbypd="PD";
		$qtyremovedpd=$qtyremovedpd+1;
		$removedatepd=$curdate;
		$removecommentpd=$row['removecommentpd'].' '.$removecommentpd;
	
		$qtyremovedjex=$qtyremovedjex-1;
		if ($qtyremovedjex<=0){
		$removedbyjex="";
		$removedatejex="";
		}
	if ($qtyremovedjex>=1){
	$removedbyjex=$row['removedbyjex'];
	
	$removecommentjex=$row['removecommentjex'];
	$removedatejex=$row['removedatejex'];
		}
	}

		if ($itemremovedby=="relistremoveditem" && $qtyremovedpd>1 && $updatelinkfrompanel=="pdpanel"){
			$qtyremovedpd=$qtyremovedpd-1;
			$quantity=$quantity+1;
			$removedbypd='PD';
			$removecommentpd = $_POST['removecomment'];
			$removedatepd=$row['removedatepd'];
			
			




		}else if ($itemremovedby=="relistremoveditem" && $qtyremovedpd==1 && $updatelinkfrompanel=="pdpanel"){
		$removecommentpd='';
		$removedatepd='';
		$removedbypd=''; 
		$qtyremovedpd=0;
		$quantity=$quantity+1;






	
	}else if ($itemremovedby=="relistremoveditem" && $qtyremovedjex>1 && $updatelinkfrompanel=="jexpanel"){
		$qtyremovedjex=$qtyremovedjex-1;
		$quantity=$quantity+1;
		$removedbyjex='JEX';
		$removecommentjex = $_POST['removecomment'];
		$removedatejex=$row['removedatejex'];
			




	}else if ($itemremovedby=="relistremoveditem" && $qtyremovedjex==1 && $updatelinkfrompanel=="jexpanel"){
		$removecommentjex='';
		$removedbyjex='';
		$removedbyjex=''; 
		$qtyremovedjex=0;
		$quantity=$quantity+1;
			




	}
	
	if (($DoNotUpdate_ItemRemoveDate=="yes") and ($itemremovedby=="PD" && $updatelinkfrompanel=="pdpanel")){
		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','removedbypd','qtyremovedpd','removecommentpd');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$removedbypd","$qtyremovedpd","$removecommentpd");
	
        $quantity1 = 0;
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity1","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 	
	
	}else if (($DoNotUpdate_ItemRemoveDate=="yes") and ($itemremovedby=="JEX" && $updatelinkfrompanel=="jexpanel")){
		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','removedbyjex','qtyremovedjex','removecommentjex');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$removedbyjex","$qtyremovedjex","$removecommentjex");
	
		$quantity1 = 0;
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity1","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 	
	
	}else if ($itemremovedby=="PD" && $updatelinkfrompanel=="itempanel"){
		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','removedbypd','qtyremovedpd','removecommentpd','removedatepd');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$removedbypd","$qtyremovedpd","$removecommentpd","$removedatepd");
	
		$quantity1 = 0;
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity1","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 	
	
	}else if ($itemremovedby=="JEX" && $updatelinkfrompanel=="itempanel"){
		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','removedbyjex','qtyremovedjex','removecommentjex','removedatejex');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$removedbyjex","$qtyremovedjex","$removecommentjex","$removedatejex");
	
		$quantity1 = 0;
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity1","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 	
	
	}else if ($itemremovedby=="JEX" && $updatelinkfrompanel=="pdpanel"){


		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','removedbypd','qtyremovedpd','removecommentpd','removedatepd','removedbyjex','qtyremovedjex','removecommentjex','removedatejex');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$removedbypd","$qtyremovedpd","$removecommentpd","$removedatepd","$removedbyjex","$qtyremovedjex","$removecommentjex","$removedatejex");

		$quantity1 = 0;
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity1","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 	
	
	
	}else if ($itemremovedby=="PD" && $updatelinkfrompanel=="jexpanel"){


		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','removedbypd','qtyremovedpd','removecommentpd','removedatepd','removedbyjex','qtyremovedjex','removecommentjex','removedatejex');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$removedbypd","$qtyremovedpd","$removecommentpd","$removedatepd","$removedbyjex","$qtyremovedjex","$removecommentjex","$removedatejex");

	
		$quantity1 = 0;
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity1","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 	
	
	}else if ($itemremovedby=="relistremoveditem" && $updatelinkfrompanel=="pdpanel"){
		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','removedbypd','qtyremovedpd','removecommentpd','removedatepd');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$removedbypd","$qtyremovedpd","$removecommentpd","$removedatepd");



	    
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 	
	
	
	}else if ($itemremovedby=="relistremoveditem" && $updatelinkfrompanel=="jexpanel"){
		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','removedbyjex','qtyremovedjex','removecommentjex','removedatejex');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$removedbyjex","$qtyremovedjex","$removecommentjex","$removedatejex");



        
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 	


	}else if ($transaction_from_panel == "jewelry" and $jewelrybuy_type == "resale") {
        
		 
        $field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image");

		
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 
	    $addtoinventory_scrapgold = 'N';
		$trans_field_names=array('itemrow_id','article_id','supplier_id','supplier_phone','upc','serialnumber','imei1','imei2','brandname','itemmodel','buy_price','unit_price','item_gender','material_type','kindsize','numstone','description','addtoinventory_scrapgold','scrap_or_resale','item_image');
		$trans_field_data=array("$id","$article_id","$supplier_id","$supplierphone","$upc","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$buy_price","$unit_price","$item_gender","$material_type","$kindsize","$numstone","$description","$addtoinventory_scrapgold","$jewelrybuy_type","$image");	
	    
	   
	 
		
	}else if ($transaction_from_panel == "jewelry" and $jewelrybuy_type == "scrap") {
		
         $quantity = 0;
		 $reorder_level = 0;
        $field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image");

		$quantity = 0;
	    $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 
	    $addtoinventory_scrapgold = 'N';
			$trans_field_names=array('itemrow_id','article_id','supplier_id','supplier_phone','upc','serialnumber','imei1','imei2','brandname','itemmodel','buy_price','unit_price','item_gender','material_type','kindsize','numstone','description','addtoinventory_scrapgold','scrap_or_resale','item_image');
			$trans_field_data=array("$id","$article_id","$supplier_id","$supplierphone","$upc","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$buy_price","$unit_price","$item_gender","$material_type","$kindsize","$numstone","$description","$addtoinventory_scrapgold","$jewelrybuy_type","$image");	
	  
		
	}else{
	



		$field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image');
		$field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image");

		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage');
	    $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$image");
	 
	    $trans_field_names=array('itemrow_id','article_id','supplier_id','supplier_phone','upc','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemmodel','buy_price','unit_price','description','item_image');
		$trans_field_data=array("$id","$article_id","$supplier_id","$supplierphone","$upc","$kindsize","$numstone","$serialnumber","$imei1","$imei2","$brandname","$itemmodel","$buy_price","$unit_price","$description","$image");	
	   
		
	 }
	 
	 

	
		if ($transaction_from_panel == "jewelry" and $jewelrybuy_type == "resale") {
		
		
		
		
	   
	   
	   }else if ($transaction_from_panel == "jewelry" and $jewelrybuy_type == "scrap") {
	    
			
			
			
	  
	   
	   
	}else{
	 
			
			
	   
	   }
	 
	 
	
	 if ($transaction_from_panel == "jewelry" and $jewelrybuy_type == "resale") {
	 
	    
	    
	    
	 
	}else if ($transaction_from_panel == "jewelry" and $jewelrybuy_type == "scrap") { 
	 
		
	    
	    
	 
	 
	}else{
	    
		
	 
	  }
	  
	  
	  
			
			
			
			
	  
	  
	
	
	  
	   
		
		$dbf->update($field_names,$field_data,$tablename,$id,true);
		$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtranstbl_rowid,true);
		
		
		
		
			
			
			
			
			
		     
		 
		 
		
        $shareINV_tablename='inventory';		
	    $shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$shareINV_tablename,$inventorytblrowid,true);
		
        if ($cfg_enableimageupload_items == "yes" and $cfg_imagesnapmethod == "online"){ 
	       echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&itemrowid=$id&inventorytblrowid=$inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pitemslink2\">";
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
<?php echo "<a href=\"form_items.php?action=insert&working_on_id=$supplier_id\"><img src=\"../je_images/btgray_add_another_itemto_supplier.png\" onmouseover=\"this.src='../je_images/btgray_add_another_itemto_supplier_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_add_another_itemto_supplier.png';\" BORDER='0'></a><br>"; ?>
<a href="manage_items.php"><img src="../je_images/btgray_manage_items.png" onmouseover="this.src='../je_images/btgray_manage_items_MouseOver.png';" onmouseout="this.src='../je_images/btgray_manage_items.png';" BORDER='0'></a><br>
<a href="form_items.php?action=insert"><img src="../je_images/btgray_create_new_item.png" onmouseover="this.src='../je_images/btgray_create_new_item_MouseOver.png';" onmouseout="this.src='../je_images/btgray_create_new_item.png';" BORDER='0'></a>
</TD>


</tr>

</table>



</body>
</html>