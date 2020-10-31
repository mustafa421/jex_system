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


$userstable = $cfg_tableprefix.'users';
$userid=$_SESSION['session_user_id'];
$auth = $dbf->idToField($userstable,'type',$_SESSION['session_user_id']);
$username = $dbf->idToField($userstable,'username',$_SESSION['session_user_id']);



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
		$jewelrybuy_type = $_POST['jewelrybuy_type'];
		$supplier_id = $_POST['supplier_id'];
		$article_id = $_POST['article_id'];
	    $transaction_id = $_POST['transaction_id']; 
		$inventorytblrowid = $_POST['inventorytblrowid']; 
		$itemtblrowid = $_POST['itemtblrowid']; 
	    $supplier_phone = $_POST['supplier_phone'];
	    $buy_price = number_format($_POST['buy_price'],2,'.', '');
		
		$enteredunitprice=$_POST['unit_price'];
		if (($enteredunitprice == "") or ($enteredunitprice == " "))
         {		
		   $enteredunitprice = 0;
		 } 
		 $unit_price = number_format($enteredunitprice,2,'.', '');
		
		
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
		
		$addscrapgoldforresale = $_POST['addscrapgoldforresale'];
		
		if($action=="insert")
		{
		  $totalowner = $_POST['totalowner'];
		  $itemfound = $_POST['itemfound'];
		  $founddesc = $_POST['founddesc'];
		}
		
	      if ($addscrapgoldforresale == "Y"){ 
		     $totalowner = "Y";
		      $itemfound = "N";
		     $founddesc = "";
		    }
	
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
			 
			 
			 
			 
			 
		        if ($add_toinventory == "Y"){
		         
		        

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

                     
				
				}else{  
		           $avaliable_upc_number=$cfg_store_code.'J99'; 
		        }
		     
		     
		     
			 
			 
			 
		       if ($add_toinventory == "Y"){
			   





			   
							
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
			      
		     	  
				   $thisname=$cfg_store_code.$itemtranstbl_rowid.'T'.$trans_id_value;
		     }	   
    		
		     
		       $newname = imageupload($image,$thisname);
		       $image=$newname;
		     
	  }
	   
	 
	 
	 
	  $field_names=array('item_number','category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	  $field_data=array("$avaliable_upc_number","$category_id","$supplier_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	 
	 
	  if ($add_toinventory != "Y"){
	    $Item_row_id=0;
		$next_inventorytblrowid=0;
		
		
		
		
		 
	   }
	 
	 
	   
	   if ($jewelrybuy_type == "ScrapGold" or $jewelrybuy_type == "ReSaleJewelry")
	    {
		
	      $add_toinventory1 = 'N';  
          $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','item_gender','material_type','description','kindsize','numstone','brandname','serialnumber','itemmodel','totalowner','itemfound','founddesc','transaction_from_panel','addtoinventory_scrapgold','item_image','date','time');
	      $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$item_gender","$material_type","$description","$kindsize","$numstone","$brandname","$serialnumber","$itemmodel","$totalowner","$itemfound","$founddesc","$transaction_from_panel","$add_toinventory1","$image","$curdate","$curtime24");	
	  		  
	   }else{
	   
	   $report_item='N';
	   $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','item_gender','material_type','description','kindsize','numstone','brandname','serialnumber','itemmodel','totalowner','itemfound','founddesc','transaction_from_panel','addtoinventory_scrapgold','report_item','item_image','date','time');
	   $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$item_gender","$material_type","$description","$kindsize","$numstone","$brandname","$serialnumber","$itemmodel","$totalowner","$itemfound","$founddesc","$transaction_from_panel","$add_toinventory","$report_item","$image","$curdate","$curtime24");	
	  }
	  
	  $upcnumbers_field_names=array('itemupc','processing');
	  $upcnumbers_field_data=array("$avaliable_upc_number","");	

	 if ($transaction_id == "") {
		$transnumbers_field_names=array('transaction_number','processing');
		$transnumbers_field_data=array("$avaliable_trans_number","");
		
		$dbf->update($transnumbers_field_names,$transnumbers_field_data,$transnumbertable,$trantablerowid,true); 
		}
		
	  if ($add_toinventory == "Y"){
		$dbf->update($field_names,$field_data,$tablename,$itemtablerowid,true);
		$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtrantablerowid,true);
		$dbf->update($upcnumbers_field_names,$upcnumbers_field_data,$upc_tablename,$upctablerowid,true);



		
		
		
		
		
		
		
		
		
		
		
		
		
		$viewinvimage="$image";
		
		$sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone','itemimage','date');
	    $sharedInventory_field_data=array("$avaliable_upc_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone","$viewinvimage","$curdate");
		$sharedinventory_tablename='inventory';

		$shareINVdbf->update($sharedInventory_field_names,$sharedInventory_field_data,$sharedinventory_tablename,$invtablerowid,true); 
		
		}else{
			$dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$itemtrantablerowid,true); 

		}	
		
		

		
		
		
		
		
		  
	
	
	   if ($cfg_enableimageupload_jewelry == "yes" and $cfg_imagesnapmethod == "online"){  
		   
            
			 if ($add_toinventory == "Y" and $addscrapgoldforresale == "Y"){
		         
		        
	            echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pjewelrylink1\">";
		    }else{	
	            
                echo "<meta http-equiv=refresh content=\"0; URL=../webcam/webcam.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&itemrowid=$Item_row_id&inventorytblrowid=$next_inventorytblrowid&itemtranstbl_rowid=$itemtranstbl_rowid&comingfrom=processitems&redirectto=pjewelrylink2\">";	     
		    }
					    
		}else{ 
	
	      if ($add_toinventory == "Y" and $addscrapgoldforresale == "Y"){
		     
		     echo "<meta http-equiv=refresh content=\"0; URL=form_items_jewelry.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&addjewelrytoinventory=yes\">";
	      }else{	
	         echo "<meta http-equiv=refresh content=\"0; URL=form_buy_jewelry.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">";
	      }
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
		
		
		if ($cfg_data_outside_storedir == "yes"){
			 $imagefile= $cfg_data_itemIMGpathdir.$thisname;
	   }else{  
			 $imagefile= 'images/'.$thisname;
	   }
		
		
		if(file_exists($imagefile)){
         unlink($imagefile);
        }   
		
		$newname = imageupload($image,$thisname);
		$image=$newname;
        
		
	     
		
		
		$trans_field_names=array('item_image','date');
	    $trans_field_data=array("$image","$curdate");	
	  
        if ($itemtblrowid == 0){
		  $dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$id,true);
		}else{
		 
		 $field_names=array('item_image','date');
	     $field_data=array("$image","$curdate");
	     $dbf->update($field_names,$field_data,$tablename,$itemtblrowid,true);
		 $dbf->update($trans_field_names,$trans_field_data,$trans_tablename,$id,true);
		
		
		
		
	    
		
		
		
		
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
		
	  $field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','Item_Image','date');
	  $field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	 
	 
	  $trans_field_names=array('itemrow_id','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','transaction_from_panel','addtoinventory_scrapgold','date');
	  $trans_field_data=array("$Item_row_id","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$transaction_from_panel","$add_toinventory","$curdate");	
	  
	  
	   $sharedInventory_field_names=array('upc','article','description','price','quantity','storecode','storelocation','storephone');
	   $sharedInventory_field_data=array("$item_number","$item_name","$description","$unit_price","$quantity","$cfg_store_code","$cfg_address","$cfg_phone");
	
	 
	 }
	else
		{	
		
	  $field_names=array('item_number','category_id','supplier_id','article_id','item_name','kindsize','numstone','serialnumber','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','Item_Image','date');
	  $field_data=array("$item_number","$category_id","$supplier_id","$article_id","$item_name","$kindsize","$numstone","$serialnumber","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	  	 
	  
	  $trans_field_names=array('itemrow_id','article_id','supplier_id','supplier_phone','upc','buy_price','unit_price','date');
	  $trans_field_data=array("$Item_row_id","$article_id","$supplier_id","$supplierphone","$upc","$buy_price","$unit_price","$curdate");	
	  
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