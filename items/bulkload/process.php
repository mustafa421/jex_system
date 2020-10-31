<?php session_start(); ?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Inventory Bulk Item Load</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="css/default.css"/>
    </head>
    <body> 

	
        <form action="" class="register">
            <h1>Review Item Information</h1>
			<?php if(isset($_POST)==true && empty($_POST)==false): 
				
include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/db_functions.php");
include ("../../classes/security_functions.php");
include ("../../classes/form.php");
include ("../../classes/display.php");
include ("../../classes/resizeimage.php");
include ("../../classes/cryptastic.php");




$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$commondbf=new db_functions($cfg_server,$cfg_commondbuser,$cfg_commondbpwd,$cfg_commondbname,$cfg_tableprefix,$cfg_theme,$lang);
$shareINVdbf=new db_functions($cfg_server,$cfg_shareINVdbuser,$cfg_shareINVdbpwd,$cfg_shareINVdbname,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);

$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

$transaction_id="";

$loopnum=0;

				
		    
		      
		    
            
            
		    
				
				
				$mycat = $_POST['Mycat'];
				$category_id = $mycat;
				
				
				
				
				
				$myart = $_POST['Myart'];
				$articletable = "$cfg_tableprefix".'articles';
				$article_id=$dbf->fieldtoid("$articletable",'article',"$myart");
				
				
				

				
				
				$brandname = $_POST['brandname'];
				$itemmodel = $_POST['itemmodel'];
				$itemcolor = $_POST['itemcolor'];
				$itemsize = $_POST['itemsize'];
				$supplier_catalogue_number = $_POST['vendorname'];
				$report_item = $_POST['report_item'];
				$buy_price = $_POST['buyprice'];
				$unit_price = $_POST['saleprice'];
				$commmondescription = $_POST['description'];
				
				
				
				

				$chkbox = $_POST['chk'];
				$serialnumber=$_POST['BX_SERIALNUM'];
				$BX_IMEI1=$_POST['BX_IMEI1'];
				$BX_IMEI2=$_POST['BX_IMEI2'];
				$itemdescription = $_POST['itemdescription'];
	
	
			   
				$articletable = "$cfg_tableprefix".'articles';
				$item_name=$dbf->idToField("$articletable",'article',"$article_id");
				if ($item_name == "Other"){
					$item_name=substr($description,0,30);
				}
			  
	
	
	
	
	    
	
	
				
	
				 
				
			
								
			?>
			<fieldset class="row1">
                <legend>Item Information</legend>
				<p>
                    <label>Category 
                    </label>
                    <input name="mycat" type="text" readonly="readonly" value="<?php echo $category_id ?>"/>

                    <label>Artical
                    </label>
                    <input name="myart" type="text" readonly="readonly" value="<?php echo $article_id ?>"/>
					
					<label>Brand
                    </label>
                    <input name="brandname" type="text" readonly="readonly" value="<?php echo $brandname ?>"/>
					
					
                </p>
                <p>
					<label>Model
                    </label>
                    <input name="itemmodel" type="text" readonly="readonly" value="<?php echo $itemmodel ?>"/>
					<label>Color
                    </label>
                    <input name="itemcolor" type="text" readonly="readonly" value="<?php echo $itemcolor ?>"/>
					<label>Size
                    </label>
                    <input name="itemsize" type="text" readonly="readonly" value="<?php echo $itemsize ?>"/>
					 
					 
                </p>
                <p>
					
					<label>BuyPrice
                    </label>
                    <input name="buyprice" type="text" readonly="readonly" value="<?php echo $buy_price ?>"/>
					<label>SalePrice
                    </label>
                    <input name="saleprice" type="text" readonly="readonly" value="<?php echo $unit_price ?>"/>
					 
					 
                </p>
		
				<div class="clear"></div>
            </fieldset>
            <fieldset class="row2">
                <legend>Items Information
                </legend>				
                <table id="dataTable" class="form" border="1">
					<tbody>
					<?php foreach($serialnumber as $a => $b){   ?>
					<tr>
							<p>
								<td >
									<?php echo $a+1; ?>
								</td>
								<td>
									<label>Serial#</label>
									<input type="text" readonly="readonly" name="serialnumber[$a]" value="<?php echo $serialnumber[$a]; ?>">
								</td>

								<td>
									<label>IMEI1</label>
									<input type="text" readonly="readonly" name="BX_IMEI1[$a]" value="<?php echo $BX_IMEI1[$a]; ?>">
								</td>
								
								<td>
									<label>IMEI2</label>
									<input type="text" readonly="readonly" name="BX_IMEI2[$a]" value="<?php echo $BX_IMEI2[$a]; ?>">
								</td>
								
								<td>
									<label>Description</label>
									<input type="text" readonly="readonly" name="itemdescription[$a]" value="<?php echo $itemdescription[$a]; ?>">
								</td>
								
							</p>
							
							
							
						</tr>
						 
<!---
********************************************************************************************************************************
********************************************************************************************************************************
-->								

<?php






$tablename="$cfg_tableprefix".'items';
$trans_tablename="$cfg_tableprefix".'item_transactions';
$upc_tablename="$cfg_tableprefix".'upc_numbers';
$transnumbertable=$cfg_tableprefix.'transaction_numbers';


	$userstable="$cfg_tableprefix".'users';
	$userid=$_SESSION['session_user_id'];
    $user_result = mysql_query("SELECT id,username,type FROM $userstable WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $username=$usertable_row['username'];
	$usertype=$usertable_row['type'];
	$userid=$usertable_row['id'];


$curdate = date("Y-m-d");
$curtime24=date("H:i:s"); 

$quantity=1;
$reorder_level=0;
$tax_percent=$cfg_default_tax_rate;
$total_cost = number_format($unit_price*(1+($tax_percent/100)),2,'.', '');








		





	

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
			
		      $supplier_id=1;
		
				$supplier_tablename="$cfg_tableprefix".'suppliers';
				$supplier_query="SELECT * FROM $supplier_tablename where id = $supplier_id ";
				$supplier_result=mysql_query($supplier_query,$dbf->conn);
				$supplier_row = mysql_fetch_assoc($supplier_result);

   			$supplierphone=$supplier_row['phone_number'];

			
			
			
			
			
	
				$serialnumber[$a] = str_replace("'", "", "$serialnumber[$a]"); 
				$serialnumber[$a] = str_replace(":", "", "$serialnumber[$a]");
				$serialnumber[$a] = str_replace("/", "", "$serialnumber[$a]");
				$serialnumber[$a] = str_replace("(", "", "$serialnumber[$a]");
				$serialnumber[$a] = str_replace(")", "", "$serialnumber[$a]");
				$serialnumber[$a] = str_replace(",", "", "$serialnumber[$a]");
				$serialnumber[$a] = str_replace("[", "", "$serialnumber[$a]");
				$serialnumber[$a] = str_replace("]", "", "$serialnumber[$a]");
				$serialnumber[$a] = str_replace('"', "", "$serialnumber[$a]");
	
				$BX_IMEI1[$a] = str_replace("'", "", "$BX_IMEI1[$a]"); 
				$BX_IMEI1[$a] = str_replace(":", "", "$BX_IMEI1[$a]");
				$BX_IMEI1[$a] = str_replace("/", "", "$BX_IMEI1[$a]");
				$BX_IMEI1[$a] = str_replace("(", "", "$BX_IMEI1[$a]");
				$BX_IMEI1[$a] = str_replace(")", "", "$BX_IMEI1[$a]");
				$BX_IMEI1[$a] = str_replace(",", "", "$BX_IMEI1[$a]");
				$BX_IMEI1[$a] = str_replace("[", "", "$BX_IMEI1[$a]");
				$BX_IMEI1[$a] = str_replace("]", "", "$BX_IMEI1[$a]");
				$BX_IMEI1[$a] = str_replace('"', "", "$BX_IMEI1[$a]");
				
				$BX_IMEI2[$a] = str_replace("'", "", "$BX_IMEI2[$a]"); 
				$BX_IMEI2[$a] = str_replace(":", "", "$BX_IMEI2[$a]");
				$BX_IMEI2[$a] = str_replace("/", "", "$BX_IMEI2[$a]");
				$BX_IMEI2[$a] = str_replace("(", "", "$BX_IMEI2[$a]");
				$BX_IMEI2[$a] = str_replace(")", "", "$BX_IMEI2[$a]");
				$BX_IMEI2[$a] = str_replace(",", "", "$BX_IMEI2[$a]");
				$BX_IMEI2[$a] = str_replace("[", "", "$BX_IMEI2[$a]");
				$BX_IMEI2[$a] = str_replace("]", "", "$BX_IMEI2[$a]");
				$BX_IMEI2[$a] = str_replace('"', "", "$BX_IMEI2[$a]");
	
	
			
			
			
			
			
			
		
			
	      if ($itemdescription[$a] <> ''){

				$itemdescription[$a] = str_replace("'", "", "$itemdescription[$a]"); 
				$itemdescription[$a] = str_replace(":", "", "$itemdescription[$a]");
				$itemdescription[$a] = str_replace("/", "", "$itemdescription[$a]");
				$itemdescription[$a] = str_replace("(", "", "$itemdescription[$a]");
				$itemdescription[$a] = str_replace(")", "", "$itemdescription[$a]");
				$itemdescription[$a] = str_replace(",", "", "$itemdescription[$a]");
				$itemdescription[$a] = str_replace("[", "", "$itemdescription[$a]");
				$itemdescription[$a] = str_replace("]", "", "$itemdescription[$a]");
				$itemdescription[$a] = str_replace('"', "", "$itemdescription[$a]");
				$description=$itemdescription[$a];
    		}else{
                $description = $commmondescription;
			
			}		   
			

	
			
		
	   $field_names=array('item_number','category_id','supplier_id','article_id','share_inventorytbl_rowid','itemtranstbl_rowid','item_name','kindsize','numstone','serialnumber','imei1','imei2','brandname','itemsize','itemcolor','itemmodel','description','buy_price','unit_price','tax_percent','supplier_catalogue_number','total_cost','quantity','reorder_level','item_image','date');
	   $field_data=array("$avaliable_upc_number","$category_id","$supplier_id","$article_id","$next_inventorytblrowid","$itemtranstbl_rowid","$item_name","$kindsize","$numstone","$serialnumber[$a]","$BX_IMEI1[$a]","$BX_IMEI2[$a]","$brandname","$itemsize","$itemcolor","$itemmodel","$description","$buy_price","$unit_price","$tax_percent","$supplier_catalogue_number","$total_cost","$quantity","$reorder_level","$image","$curdate");	
	 
	   $totalowner='Y'; 
	   $trans_field_names=array('itemrow_id','share_inventorytbl_rowid','category_id','article_id','transaction_id','supplier_id','supplier_phone','upc','buy_price','unit_price','description','kindsize','numstone','brandname','serialnumber','imei1','imei2','itemmodel','totalowner','itemfound','founddesc','transaction_from_panel','report_item','item_image','date','time');
	   $trans_field_data=array("$Item_row_id","$next_inventorytblrowid","$category_id","$article_id","$trans_id_value","$supplier_id","$supplierphone","$avaliable_upc_number","$buy_price","$unit_price","$description","$kindsize","$numstone","$brandname","$serialnumber[$a]","$BX_IMEI1[$a]","$BX_IMEI2[$a]","$itemmodel","$totalowner","$itemfound","$founddesc","additem","$report_item","$image","$curdate","$curtime24");	
	  
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
		
		
		
		
		

$transaction_id=$trans_id_value;


?>
								

					<?php } 
								
   echo "<meta http-equiv=refresh content=\"0; URL=../manage_item_trans.php?listsupplieritems=1&enteredby=jex\">";
	    					
					
					?>
			
					</tbody>
                </table>
				<div class="clear"></div>
            </fieldset>

                <p>
				
					<a class="submit" href="index.php" type="button"> Go Back <a/>

	</p>
				<div class="clear"></div>
            </fieldset>
		<?php else: ?>
		<fieldset class="row1">
			<legend>Sorry</legend>
			 <p>Some things went wrong please try again.</p>
		</fieldset>
		<?php endif; ?>
			<div class="clear"></div>
        </form>
    </body>
	


</html>





