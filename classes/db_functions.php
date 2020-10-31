<?php

class db_functions
{	
	
	var $conn;
	var $lang;
	var $tblprefix;
	
	var $table_bgcolor,$cellspacing,$cellpadding,$border_style,$border_width,
	$border_color,$header_rowcolor,$header_text_color,$headerfont_face,$headerfont_size,
	$rowcolor,$rowcolor2,$rowcolor_text,$rowfont_face,$rowfont_size;
	
	
	function db_functions($server,$username,$password,$database,$tableprefix,$theme,$language)
	{
		
		
		
		$this->tblprefix=$tableprefix;
		$this->lang=$language;
	
		$this->conn = mysql_connect("$server", "$username", "$password") or die("Could not connect : " . mysql_error());
		mysql_select_db("$database",$this->conn) or die("Could not select database <b>$database</b>");
		
		switch($theme)
		{
			
			
			case $theme=='serious':
				$this->table_bgcolor='white';
				$this->cellspacing='1';
				$this->cellpadding='0';
				$this->border_style='solid';
				$this->border_width='1';
				$this->border_color='black';
				
				$this->header_rowcolor='black';
				$this->header_text_color='white';
				$this->headerfont_face='arial';
				$this->headerfont_size='2';

				
				$this->rowcolor='#DDDDDD';
				$this->rowcolor_text='black';
				$this->rowfont_face='geneva';
				$this->rowfont_size='2';
			break;
			
			case $theme=='big blue':
			
				$this->table_bgcolor='white';
				$this->cellspacing='1';
				$this->cellpadding='0';
				$this->border_style='solid';
				$this->border_width='1';
				$this->border_color='black';
				
				$this->header_rowcolor='navy';
				$this->header_text_color='white';
				$this->headerfont_face='arial';
				$this->headerfont_size='2';

				
				$this->rowcolor='#15759B';
				$this->rowcolor_text='white';
				$this->rowfont_face='geneva';
				$this->rowfont_size='2';
				
				
			break;
		
		}
	}
	function getUserID($username,$password)
	{
		
		
		
		$tablename = "$this->tblprefix".'users';
		$result = mysql_query("SELECT * FROM $tablename WHERE username=\"$username\" and password=\"$password\"",$this->conn);
		$row = mysql_fetch_assoc($result);
		
		return $row['id'];
	}
	
	
	function getmaxid($tablename)
	{
		
		
		

		$suppliersTable="$tableprefix".'suppliers';
		$r = mysql_query("SHOW TABLE STATUS LIKE $suppliersTable ");
    $row = mysql_fetch_array($r);
     $Auto_increment = $row['Auto_increment'];

		 
		$max_id=$Auto_increment;

		
		
		return $max_id;

		
		
	}
	
	
	function getAllElementswhere($tablename,$field,$wherefield,$orderby)
	{
		
		
		
		$result = mysql_query("SELECT $field FROM $tablename where $wherefield ORDER BY $orderby",$this->conn);
		$numRows = mysql_num_rows($result);
		$data = array();
		
		$data[0]='';
		for($k=1; $k< $numRows+1; $k++)
		{
			$data[$k]= mysql_result($result,$k-1);	
			
		}
		
		return $data;
	}
	
	
	
	function getAllElements($tablename,$field,$orderby)
	{
		
		/*post: returns all elements in an array of specified table
		and sets first position to an empty string.  This function will be used for filling
		select fields, which requires the first position for the selected value
		*/
		
		$result = mysql_query("SELECT $field FROM $tablename ORDER BY $orderby",$this->conn);
		$numRows = mysql_num_rows($result);
		$data = array();
		
		$data[0]='';
		for($k=1; $k< $numRows+1; $k++)
		{
			$data[$k]= mysql_result($result,$k-1);	
			
		}
		
		return $data;
	}
	
	function idToField($tablename,$field,$id)
	{
		
		
		
		$result = mysql_query("SELECT $field FROM $tablename WHERE id=\"$id\"",$this->conn);
		
		$row = mysql_fetch_assoc($result);
		
		return $row[$field];
	}
	
	function fieldToid($tablename,$field,$value)
	{
		
		

		$result = mysql_query("SELECT * FROM $tablename WHERE $field=\"$value\"",$this->conn);
		
		$row=mysql_fetch_assoc($result);
		
		return $row['id'];

	}
	
	function getFields($database,$tablename)
	{	
		
	
		$fields=array();
		$fieldsRef=mysql_list_fields ($database, $tablename);
		$columns=mysql_num_fieldsfieldsRef;
		
		for($k=0;$k<$columns;$k++)
		{
			$fields[]=mysql_field_name($fieldsRef,$k);
		}

		return $fields;
	}
	
	function insert($field_names,$field_data,$tablename,$output)
	{
		
		
		
		if(!($this->isValidData($field_data)))
		{
			echo "{$this->lang->invalidCharactor}";
			exit();
		}
		
		$query = "INSERT INTO $tablename ($field_names[0]";
			
		for($k=1;$k< count($field_names);$k++)
		{
			$query.=', '."$field_names[$k]";
		
		}
		
		$query.=") VALUES (\"$field_data[0]\"";
		
		for($k=1;$k< count($field_data);$k++)
		{
			$query.=', '."\"$field_data[$k]\"";
		
		}
			$query.=')';
			mysql_query($query,$this->conn);
			
			
			if($output)
			{
				echo "<center><b>{$this->lang->successfullyAdded} $tablename</b></center><br>";
				
				echo "<center><table width=350 cellspacing=$this->cellspacing cellpadding=$this->cellpadding bgcolor=$this->table_bgcolor style=\"border: $this->border_style $this->border_color $this->border_width px\">
				<tr bgcolor=$this->header_rowcolor>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->field}</th></font>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->data}</th></font>
				</tr>";
				for($k=0;$k<count($field_names);$k++)
				{
					
					if($field_names[$k]!="password")
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_data[$k]</font></td></tr>\n";
					}
					else
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>*******</font></td></tr>\n";
					
					}
				}
				echo '</table></center>';
	
			}
			
			
			$iLastID = mysql_insert_id();

			
			
		}
	
	function update($field_names,$field_data,$tablename,$id,$output)
	{
		
		
		
		if($id=='')
		{
			echo "{$this->lang->didNotEnterID}";
			exit();
		}
		if(!($this->isValidData($field_data)))
		{
			echo "{$this->lang->invalidCharactor}";
			exit();
		}
			$query="UPDATE $tablename SET $field_names[0]=\"$field_data[0]\"";
			
			
		for($k=1;$k< count($field_names);$k++)
		{
			$query.=', '."$field_names[$k]=\"$field_data[$k]\"";
		
		}
		
			$sales_items_table=$this->tblprefix.'sales_items';
			if($output)
			{
				$query.=" WHERE id=\"$id\"";
			}
			else
			{
				$query.=" WHERE sale_id=\"$id\"";
			}
			
					
			mysql_query($query,$this->conn);
	
	
		if($output)
		{
			echo "<center><b>{$this->lang->successfullyUpdated} $tablename</b></center><br>";	
			
				echo "<center><table width=350 cellspacing=$this->cellspacing cellpadding=$this->cellpadding bgcolor=$this->table_bgcolor style=\"border: $this->border_style $this->border_color $this->border_width px\">
				<tr bgcolor=$this->header_rowcolor>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->field}</th></font>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->data}</th></font>
				</tr>";
				for($k=0;$k<count($field_names);$k++)
				{
					
					if($field_names[$k]!="password")
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_data[$k]</font></td></tr>\n";
					}
					else
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>*******</font></td></tr>\n";
					
					}
				}
				echo '</table></center>';
	
		}
	}	
	
	function updatereturn($field_names,$field_data,$tablename,$id,$output)
	{
		
		
		
		if($id=='')
		{
			echo "{$this->lang->didNotEnterID}";
			exit();
		}
		if(!($this->isValidData($field_data)))
		{
			echo "{$this->lang->invalidCharactor}";
			exit();
		}
			$query="UPDATE $tablename SET $field_names[0]=\"$field_data[0]\"";
			
			
		for($k=1;$k< count($field_names);$k++)
		{
			$query.=', '."$field_names[$k]=\"$field_data[$k]\"";
		
		}
		
			$sales_items_table=$this->tblprefix.'sales_items';
			if($output)
			{
				$query.=" WHERE id=\"$id\"";
			}
			else
			{
				
				$query.=" WHERE id=\"$id\"";
			}
			
					
			mysql_query($query,$this->conn);
	
	
		if($output)
		{
			echo "<center><b>{$this->lang->successfullyUpdated} $tablename</b></center><br>";	
			
				echo "<center><table width=350 cellspacing=$this->cellspacing cellpadding=$this->cellpadding bgcolor=$this->table_bgcolor style=\"border: $this->border_style $this->border_color $this->border_width px\">
				<tr bgcolor=$this->header_rowcolor>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->field}</th></font>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->data}</th></font>
				</tr>";
				for($k=0;$k<count($field_names);$k++)
				{
					
					if($field_names[$k]!="password")
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_data[$k]</font></td></tr>\n";
					}
					else
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>*******</font></td></tr>\n";
					
					}
				}
				echo '</table></center>';
	
		}
	}	
	
	function deleteRow($tablename,$id)
	{
		
		
		
		$deleteitemimage='no';  
		
		if($this->tblprefix=='')
		{
			$baseTable=$tablename;
		}
		else
		{
			$splitTable= explode ("$this->tblprefix",$tablename);
			$baseTable=$splitTable[1];
		}
			
		$canDelete=true;
		$errmessage='';
		
		if($id=='')
		{
			echo "{$this->lang->didNotEnterID}";
			exit();
		}
		elseif($baseTable=='brands')
		{

			$checkTable = "$this->tblprefix".'items';
			$result = mysql_query("SELECT brand_id FROM $checkTable WHERE brand_id=\"$id\"",$this->conn);
			if(@mysql_num_rows($result) >= 1)
			{ 
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteBrand}";

			} 	
		
		}
		elseif($baseTable=='articles')
		{

			$checkTable = "$this->tblprefix".'items';
			$result = mysql_query("SELECT article_id FROM $checkTable WHERE article_id=\"$id\"",$this->conn);
			
			if(@mysql_num_rows($result) >= 1)
			{ 
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteArticle}";

			} 	
		
		}

		elseif($baseTable=='categories')
		{
			$checkTable = "$this->tblprefix".'items';
			$result = mysql_query("SELECT category_id FROM $checkTable WHERE category_id=\"$id\"",$this->conn);
			
			if(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;	
				$errmessage="{$this->lang->cantDeleteCategory}";

			} 	
		
		}
		elseif($baseTable=='customers')
		{
			$checkTable = "$this->tblprefix".'sales';
			$result = mysql_query("SELECT customer_id FROM $checkTable WHERE customer_id=\"$id\"",$this->conn);
			
			if(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteCustomer}";
			} 	
		
		}
		elseif($baseTable=='items')
		{
			$checkTable = "$this->tblprefix".'sales_items';
			$result = mysql_query("SELECT item_id FROM $checkTable WHERE item_id=\"$id\"",$this->conn);
			
			if(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteItem}";
			} 	
			
			
		    $checkTable = "$this->tblprefix".'item_transactions';
			$result = mysql_query("SELECT itemrow_id FROM $checkTable WHERE itemrow_id=\"$id\"",$this->conn);
			
			if(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;
				
				$errmessage="You can not delete this item because it has been purchased at least once or Transaction row exists.";
			} 	
		
		   
		}
		elseif($baseTable=='suppliers')
		{

			$checkTable = "$this->tblprefix".'items';
			$result = mysql_query("SELECT supplier_id FROM $checkTable WHERE supplier_id=\"$id\"",$this->conn);
			if(@mysql_num_rows($result) >= 1)
			{ 
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteSupplier}";

			} 	
			
			
			$checkTable = "$this->tblprefix".'item_transactions';
			$result = mysql_query("SELECT supplier_id FROM $checkTable WHERE supplier_id=\"$id\"",$this->conn);
			if(@mysql_num_rows($result) >= 1)
			{ 
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteSupplier}";

			} 	
			
		
		}
		elseif($baseTable=='sales')
		{
			$sales_items_table="$this->tblprefix".'sales_items';
			$items_table="$this->tblprefix".'items';
			$result=mysql_query("SELECT * FROM $sales_items_table WHERE sale_id=\"$id\"");
			
			while($row=mysql_fetch_assoc($result))
			{
				$quantityToAdd =$row['quantity_purchased'];
				$newQuantity=$this->idToField($items_table,'quantity',"$row[item_id]")+$quantityToAdd;
				$this->updateItemQuantity($row['item_id'],$newQuantity);
			}
		    mysql_query("DELETE FROM $sales_items_table WHERE sale_id=\"$id\"",$this->conn);	
		
		
		
		
		}
		elseif($baseTable=='item_transactions')  
		{
		    $updateqty='no';
			$fromtranstable= 'yes';

	  		$itemtrans_table="$this->tblprefix".'item_transactions';
			$items_table="$this->tblprefix".'items';
			$item_transresult=mysql_query("SELECT * FROM $itemtrans_table WHERE id=\"$id\"",$this->conn);
			
			$Itemtrans_row = mysql_fetch_assoc($item_transresult);
            $myimage=$Itemtrans_row['item_image'];
			$itemrowid=$Itemtrans_row['itemrow_id'];
			$shareinvrowid=$Itemtrans_row['share_inventorytbl_rowid'];
			$articleid=$Itemtrans_row['article_id'];
			$itemupc=$Itemtrans_row['upc'];
			
			include ("../settings.php");
            include ("../../../../$cfg_configfile");
		    
			$ArticleTable="$cfg_tableprefix".'articles';
			$ArticalName=$this->idToField("$ArticleTable",'article',"$articleid");
			
			if (($ArticalName == "Game DVD") or ($ArticalName == "Video DVD")){
			
			    $checkTable = "$this->tblprefix".'items';
			    $result = mysql_query("SELECT * FROM $checkTable WHERE item_number=\"$itemupc\"",$this->conn);
				$Itemtblrow = mysql_fetch_assoc($result);
				$qtyonhand=$Itemtblrow['quantity'];
			    if($qtyonhand > 1)
			     {
			         $updateqty='yes';
					 $newqty=$qtyonhand - 1;
				     $deleteitemimage='no';
				     $fromtranstable= 'no';
			     }else{
				      $fromtranstable= 'yes';
					  $deleteitemimage='yes';
			          
			     }
			
			}

			
			if ($itemrowid > 0) { 
		       $checkTable = "$this->tblprefix".'sales_items';
			   $result = mysql_query("SELECT * FROM $checkTable WHERE item_id=\"$itemrowid\"",$this->conn);
			}
	
		   if(@mysql_num_rows($result) >= 1)
			{
			    $canDelete=false;
		
				$errmessage="You can not delete this item because it has been purchased.";
				$deleteitemimage='no';
				$fromtranstable= 'no';
			}else{
			    
				if ($updateqty == "no"){
                    $fromtranstable= 'yes';
			        $deleteitemimage='yes';
                 }
			}

    

		    
			
			
		
		}
		elseif($baseTable=='users')
		{
			
			$checkTable = "$this->tblprefix".'sales';

			$result = mysql_query("SELECT sold_by FROM $checkTable WHERE sold_by=\"$id\"",$this->conn);
			if($_SESSION['session_user_id']==$id)
			{
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteUserLoggedIn}";
	

			}
			elseif(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteUserEnteredSales}";
			}
			
			
				
		} 	
		
		if($canDelete==true)
		{
		$query="DELETE FROM $tablename WHERE id=\"$id\"";
	 	 mysql_query($query,$this->conn);
	
	
	   if ($fromtranstable == "yes") {

           if ($itemrowid <> "0") { 
    	       include ("../settings.php");
                include ("../../../../$cfg_configfile");
		        $shareINVdbf=new db_functions($cfg_server,$cfg_shareINVdbuser,$cfg_shareINVdbpwd,$cfg_shareINVdbname,$cfg_tableprefix,$cfg_theme,$lang);
                $shareINV_tablename='inventory';
		
	            $query="DELETE FROM $items_table WHERE id=\"$itemrowid\"";
	 	        mysql_query($query,$this->conn); 
 
       		    $query="DELETE FROM $shareINV_tablename WHERE id=\"$shareinvrowid\"";
 	            mysql_query($query,$shareINVdbf->conn);
	        }		
				 
	   
	   }
	   
	   if ($updateqty == "yes"){  
	          include ("../settings.php");
              include ("../../../../$cfg_configfile");
			  $shareINVdbf=new db_functions($cfg_server,$cfg_shareINVdbuser,$cfg_shareINVdbpwd,$cfg_shareINVdbname,$cfg_tableprefix,$cfg_theme,$lang);
		      $shareINV_tablename='inventory';
	          $query="UPDATE $items_table SET quantity=\"$newqty\" WHERE item_number=\"$itemupc\"";
	 	      mysql_query($query,$this->conn); 
 

 
                
	            $invtable_query="SELECT * FROM $shareINV_tablename WHERE upc = $itemupc";
				$invtable_result=mysql_query($invtable_query,$shareINVdbf->conn);
				$invtable_row = mysql_fetch_assoc($invtable_result);

   			     $invtable_rowid=$invtable_row['id'];
 
 
 
       		   $query="UPDATE $shareINV_tablename SET quantity=\"$newqty\" WHERE id=\"$invtable_rowid\"";
 	            mysql_query($query,$shareINVdbf->conn);
	   
	   
	   }
	
	    
	    
	    
	    
	 if(isset($_GET['imgnm']) and isset($_GET['custimg']) and isset($_GET['thumbimg']) )
	 {
    
	    $rmlicimagefile=$_GET['imgnm'];
	    $rmcustimagefile=$_GET['custimg'];
	    $rmthumbimagefile=$_GET['thumbimg'];
		
	  
	    
		$rmlicimagefile =rtrim($rmlicimagefile);
		$rmcustimagefile=rtrim($rmcustimagefile);
		$rmthumbimagefile=rtrim($rmthumbimagefile);
		
		
	   
		system ("rm -f $rmlicimagefile $rmcustimagefile $rmthumbimagefile");  
	    echo "<center>Deleted picture name: $rmlicimagefile | $rmcustimagefile | $rmthumbimagefile</center>";
	  
	    echo "<center>{$this->lang->successfullyDeletedRowandpics} <b>$id</b> {$this->lang->fromThe} <b>$tablename</b> {$this->lang->table}</center>";
	   

	   }elseif ((isset($_GET['itemimage'])) && ($deleteitemimage=="yes")) {	      
		      $rmitemimagefile=$_GET['itemimage'];
		      $rmitemimagefile=rtrim($rmitemimagefile);
		      system ("rm -f $rmitemimagefile");
	          echo "<center>Deleted Item picture name: $rmitemimagefile</center>";
	  
	         echo "<center>{$this->lang->successfullyDeletedRowandpics} <b>$id</b> {$this->lang->fromThe} <b>$tablename</b> {$this->lang->table}</center>";
	   
	   }else{
	        echo "<center>{$this->lang->successfullyDeletedRow} <b>$id</b> {$this->lang->fromThe} <b>$tablename</b> {$this->lang->table}</center>";	
	   }  
	     
	     
	      
	    
	
	

		}
		else
		{
			echo "<center>$errmessage</center><br>";
		}
	}
	
	
	function isValidData($data_to_check)
	{
		
	
		for($k=0;$k<count($data_to_check);$k++)
		{
			if(ereg('\"',$data_to_check[$k]) or ereg('<',$data_to_check[$k]) or ereg('>',$data_to_check[$k]) )
			{
				return false;
			}
		}
		
		return true;
	
	}
	
	function isValidItem($item)
	{
		$table=$this->tblprefix.'items';
		$result=mysql_query("SELECT id FROM $table WHERE id=\"$item\"",$this->conn);
		
		if(mysql_num_rows($result)==0)
		{
			return false;
		}
		
		return true;
	}
	
	function isItemOnDiscount($itemID)
	{
		$table=$this->tblprefix.'discounts';
		$query="SELECT item_id FROM $table WHERE item_id=\"$itemID\"";
		$result=mysql_query($query,$this->conn);
		
		if(mysql_num_rows($result) >0)
		{
			return true;
		}
		return false;

	}
	
	function getPercentDiscount($itemID)
	{
		$table=$this->tblprefix.'discounts';
		$query="SELECT percent_off FROM $table WHERE item_id=\"$itemID\"";
		$result=mysql_query($query,$this->conn);
		
		if(mysql_num_rows($result) >0)
		{
			$row=mysql_fetch_assoc($result);
			return $row['percent_off'];
		}
		return -1;
	}
	
	function getDiscountedPrice($itemID)
	{
		$itemtable=$this->tblprefix.'items';
		$discounttable=$this->tblprefix.'discounts';
		
		$query1="SELECT * FROM $discounttable WHERE item_id=\"$itemID\"";
		$row=mysql_fetch_assoc(mysql_query($query1,$this->conn));
		$percent_off=$row['percent_off'];
		
		$query2="SELECT * FROM $itemtable WHERE id=\"$itemID\"";
		$row=mysql_fetch_assoc(mysql_query($query2,$this->conn));
		$discounted_price=$row['unit_price']*(1-($percent_off/100));
		
		return number_format($discounted_price,2,'.', '');

		

	}
	
	function isValidCustomer($customer)
	{
		$table=$this->tblprefix.'customers';
		$result=mysql_query("SELECT id FROM $table WHERE id=\"$customer\"",$this->conn);
		
		if(mysql_num_rows($result)==0)
		{
			return false;
		}
		
		return true;
	}
		
	function getNumRows($table)
	{
		
		
		$query="SELECT id FROM $table";
		$result=mysql_query($query,$this->conn);
		
		return mysql_num_rows($result);
	
	}
	
	
	
	function updateSaleTotals($sale_id)
	{
		
		
		$sales_items_table=$this->tblprefix.'sales_items';
		$sales_table=$this->tblprefix.'sales';
		
		$query="SELECT item_total_cost,item_total_tax,quantity_purchased FROM $sales_items_table WHERE sale_id=\"$sale_id\"";
		
		$result=mysql_query($query,$this->conn);
		
		
		
		if(@mysql_num_rows($result) > 0)
		{
			$sale_sub_total=0;
			$sale_total_cost=0;
			$items_purchased=0;
		
			while($row=mysql_fetch_assoc($result))
			{
				$sale_sub_total+=$row['item_total_cost']-$row['item_total_tax'];
				$sale_total_cost+=$row['item_total_cost'];
				$items_purchased+=$row['quantity_purchased'];
			}
			
			$sale_sub_total=number_format($sale_sub_total,2,'.', '');
			$sale_total_cost=number_format($sale_total_cost,2,'.', '');
			
			$query2="UPDATE $sales_table SET sale_sub_total=\"$sale_sub_total\",sale_total_cost=\"$sale_total_cost\",items_purchased=\"$items_purchased\" WHERE id=\"$sale_id\"";
			mysql_query($query2,$this->conn);
		}
		else
		{
			$this->deleteRow($sales_table,$sale_id);	
		}
	}
	
	function updateItemQuantity($item_id,$newQuantity)
	{
		$items_table=$this->tblprefix.'items';
		$query="UPDATE $items_table SET quantity=\"$newQuantity\" WHERE id=\"$item_id\"";
		mysql_query($query,$this->conn);
		
	}
	
	function optimizeTables()
	{
		
		
		$tableprefix=$this->tblprefix;
		$brandsTable="$tableprefix".'brands';
		$categorieTable="$tableprefix".'categories';
		$customersTable="$tableprefix".'customers';
		$itemsTable="$tableprefix".'items';
		$salesTable="$tableprefix".'sales';
		$sales_itemsTable="$tableprefix".'sales_items';
		$suppliersTable="$tableprefix".'suppliers';
		$usersTable="$tableprefix".'users';
		
		$articlesTable="$tableprefix".'articles';
		$articlestypeTable="$tableprefix".'articletypes';
		$checknumberTable="$tableprefix".'checknumber';
		$ckprintingTable="$tableprefix".'checkprinting_coordinates';
		$discountsTable="$tableprefix".'discounts';
		$itemtransTable="$tableprefix".'item_transactions';
		$printedchecksTable="$tableprefix".'printed_checks';
		$transnumTable="$tableprefix".'transaction_numbers';
		$upcnumTable="$tableprefix".'upc_numbers';
		
		$query="OPTIMIZE TABLE $brandsTable, $categorieTable, $customersTable, $itemsTable, $salesTable, $sales_itemsTable,$suppliersTable, $usersTable,$articlesTable,$articlestypeTable,$checknumberTable,$ckprintingTable,$discountsTable,$itemtransTable,$printedchecksTable,$transnumTable,$upcnumTable";
		mysql_query($query,$this->conn);
	}
	
	function closeDBlink()
	{
		mysql_close($this->conn);
	}
	
	

}

?>