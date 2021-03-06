<html>
<head>

<title>Inventory System</title>

	<link rel="stylesheet" href="../classes/css/lightbox.css" type="text/css" media="screen" />
	
	<script src="../classes/js/prototype.js" type="text/javascript"></script>
	<script src="../classes/js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="../classes/js/lightbox.js" type="text/javascript"></script>

<script type="text/javascript">
	
	
	
	
		
		
		function autoFireLightbox() {
			
			
			setTimeout(function() {
				if(document.location.hash && $(document.location.hash.substr(1)).rel.indexOf('lightbox')!=-1) {
				
					myLightbox.start($(document.location.hash.substr(1)));
				}},
				250
			);
		}
		Event.observe(window, 'load', autoFireLightbox, false);
	
</script>

	<style type="text/css">
		body{ color: #333; font: 13px 'Lucida Grande', Verdana, sans-serif;	}
	</style>
	
</head>
<body>	

<?php

class display
{
	
	var $conn;
	var $lang;
	var $title_color,$list_of_color,$table_bgcolor,$cellspacing,$cellpadding,$border_style,$border_width,
	$border_color,$header_rowcolor,$header_text_color,$headerfont_face,$headerfont_size,
	$rowcolor1,$rowcolor2,$rowcolor_text,$rowfont_face,$rowcolor_link,$rowfont_size,$sale_bg;
	
	
	function display($connection,$theme,$currency_symbol,$language)
	{
		$this->conn=$connection;
		$this->lang=$language;
		$this->currency_symbol=$currency_symbol;
		switch($theme)
		{
			case $theme=='big blue':
				
				$this->title_color='#005B7F';
				$this->list_of_color='#247392';
				
				$this->table_bgcolor='white';
				$this->cellspacing='1';
				$this->cellpadding='0';
				$this->border_style='solid';
				$this->border_width='1';
				$this->border_color='#0A6184';
				
				$this->header_rowcolor='navy';
				$this->header_text_color='white';
				$this->headerfont_face='arial';
				$this->headerfont_size='2';

				
				$this->rowcolor1='#15759B';
				$this->rowcolor2='#0A6184';
				$this->rowcolor_text='white';
				$this->rowfont_face='geneva';
				
				$this->rowcolor_link='gold';
				$this->rowfont_size='2';
				$this->sale_bg='#015B7E';
				
			break;
			
			case $theme=='serious':
				
				$this->title_color='black';
				$this->list_of_color='black';
				
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

				
				$this->rowcolor1='#DDDDDD';
				$this->rowcolor2='#CCCCCC';
				$this->rowcolor_text='black';
				$this->rowfont_face='geneva';
				
				$this->rowcolor_link='blue';
				$this->rowfont_size='2';
				$this->sale_bg='#999999';
			break;
			
			
		}
	}
	
	function displayTitle($title)
	{
		
		
		
		echo "<center><h3><font color='$this->title_color'>$title</font></h3></center>";	
	}
	
	function idToField($tablename,$field,$id)
	{
		
		
		
		$result = mysql_query("SELECT $field FROM $tablename WHERE id=\"$id\"",$this->conn);
		
		$row = mysql_fetch_assoc($result);
		
		return $row[$field];
	}
	
	function getNumRows($table)
	{
		$query="SELECT id FROM $table";
		$result=mysql_query($query,$this->conn);
		
		return mysql_num_rows($result);
	
	}
	
	function displayManageTable($tableprefix,$tablename,$tableheaders,$tablefields,$wherefield,$wheredata,$orderby)
	{
		
		
		
		
		
		$userid=$_SESSION['session_user_id'];
        $usertype=$this->idToField("$tableprefix".'users','type',"$userid");
 
		
		if($tablename=='brands' or $tablename=='categories')
		{
			$tablewidth='35%';
		}
		else
		{
			$tablewidth='150%';
		}
		
		$table="$tableprefix"."$tablename";
		echo "\n".'<center>';
		
		
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
		$start_from = ($page-1) * 25;
		
		
		if($wherefield=='quantity' and $wheredata=='outofstock')
		{
			$result = mysql_query("SELECT * FROM $table WHERE quantity < 1 ORDER BY $orderby LIMIT 0,25",$this->conn);
			$resultnumrows = mysql_query("SELECT * FROM $table WHERE quantity < 1 ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);
		}
		elseif($wherefield=='quantity' and $wheredata=='reorder')
		{
			$result = mysql_query("SELECT * FROM $table WHERE quantity <= reorder_level ORDER BY $orderby LIMIT 0,25",$this->conn);
			$resultnumrows = mysql_query("SELECT * FROM $table WHERE quantity <= reorder_level ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);

		}
			
			elseif($wherefield=='unit_price' and $wheredata=='zeroprice')
		{
			$result = mysql_query("SELECT * FROM $table WHERE unit_price < 0.01  ORDER BY $orderby LIMIT 0,25",$this->conn);
            $resultnumrows = mysql_query("SELECT * FROM $table WHERE unit_price < 0.01  ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);
		}
		
			

			elseif($wherefield=='supplier_id')
		{
			$listsupplieritems=$wheredata;
			$enteredby='jex';
			
			$result = mysql_query("SELECT * FROM $table where supplier_id = $wheredata ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
            $resultnumrows = mysql_query("SELECT * FROM $table where supplier_id = $wheredata ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);
		}
		elseif($wherefield=="ALL" and $wheredata!='')
		{
		$inputdate="";
		$founddashes=substr_count($wheredata, '-');
		$foundslashes=substr_count($wheredata, '/');
		if ($founddashes=="2"){
			$inputdate=$wheredata; 
			$tranday = substr("$wheredata",0,2);
			$tranmonth = substr("$wheredata",3,2);
			$tranyear = substr("$wheredata",6,4);
			$wheredata=$tranyear.'-'.$tranday.'-'.$tranmonth;
            
		}else
		if ($foundslashes=="2"){
			$inputdate=$wheredata; 
			$tranday = substr("$wheredata",0,2);
			$tranmonth = substr("$wheredata",3,2);
			$tranyear = substr("$wheredata",6,4);
			$wheredata=$tranyear.'-'.$tranday.'-'.$tranmonth;
		}
		$wheredata=trim($wheredata);
		$searchall='yes';
		  

		if  ($wheredata=="jewelry"){
		        $result = mysql_query("SELECT * FROM $table WHERE transaction_from_panel = \"$wheredata\"   ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
			    $result2 =  mysql_query("SELECT * FROM $table WHERE transaction_from_panel = \"$wheredata\" ORDER BY $orderby DESC",$this->conn);
			    $num_rows = mysql_num_rows($result2);
		}else{ 
		    
			$result = mysql_query("SELECT * FROM $table WHERE upc like \"%$wheredata%\"  or transaction_id like \"%$wheredata%\" or supplier_phone like \"%$wheredata%\" or date like \"%$wheredata%\" ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 =  mysql_query("SELECT * FROM $table WHERE upc like \"%$wheredata%\"  or transaction_id like \"%$wheredata%\" or supplier_phone like \"%$wheredata%\" or date like \"%$wheredata%\" ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		
			if ($inputdate!="")
			{
			$wheredata=$inputdate;
			}
		}
		
		elseif($wherefield!='' and $wheredata!='')
		{
		
		if ($wherefield=="date"){
				$founddashes=substr_count($wheredata, '-');
				$foundslashes=substr_count($wheredata, '/');
			if ($founddashes=="2"){
				$tranday = substr("$wheredata",0,2);
				$tranmonth = substr("$wheredata",3,2);
				$tranyear = substr("$wheredata",6,4);
				$wheredata=$tranyear.'-'.$tranday.'-'.$tranmonth;
			}else
				if ($foundslashes=="2"){
				$tranday = substr("$wheredata",0,2);
				$tranmonth = substr("$wheredata",3,2);
				$tranyear = substr("$wheredata",6,4);
				$wheredata=$tranyear.'-'.$tranday.'-'.$tranmonth;
			}
		}
			$wheredata=trim($wheredata);
			$usingsearch='yes';

			$result = mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 =  mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		
		
		}
		elseif($this->getNumRows($table) >25)
		{
			$result = mysql_query("SELECT * FROM $table where supplier_id <> 1 ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
			
			$resultnumrows = mysql_query("SELECT * FROM $table where supplier_id <> 1 ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);
			
			$resulttotalrows = mysql_query("SELECT * FROM $table ORDER BY $orderby DESC",$this->conn);
			$totalnumrows = mysql_num_rows($resulttotalrows);
			$totalnumrows= " Total rows: " . $totalnumrows;
			
			echo "<font color=GREEN>{$this->lang->moreThan} $table".'\'s'." {$this->lang->firstDisplayed}";
	
		}
		else
		{
			$result = mysql_query("SELECT * FROM $table ORDER BY $orderby",$this->conn);
			$resultnumrows = mysql_query("SELECT * FROM $table ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);
		}
		echo '<hr>';
		if(@mysql_num_rows($result) ==0)
		{
			echo "<div align='center'>{$this->lang->noDataInTable} <b>$table</b> {$this->lang->table}.</div>";
			exit();
		}
		echo "<center><h4><font color='$this->list_of_color'>{$this->lang->listOf} $tablename Rows Returned $num_rows $totalnumrows</font></h4></center>";
		echo "<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
		<tr bgcolor=$this->header_rowcolor>\n\n";
		
		
		$total_records = $num_rows; 
		$total_pages = ceil($total_records / 25); 


		$urllinkcolor="#064A08";
		$pagenumcolor="#0D11F2";		
		
		if ($total_pages > 1) {  
			if (isset($_GET["totalpages"])) { 
			if ($nextpage <= $total_pages){  
					$nextpage = $page + 1; 
					$backpage = $page - 1;
				if ($enteredby=="jex"){ 
					if ($page=="1") {
					
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&listsupplieritems=$listsupplieritems&enteredby=$enteredby&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
				}else if ($page == $total_pages) {
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&listsupplieritems=$listsupplieritems&enteredby=$enteredby&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					
				}else{
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&listsupplieritems=$listsupplieritems&enteredby=$enteredby&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&listsupplieritems=$listsupplieritems&enteredby=$enteredby&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
				}
					}else if ($usingsearch=="yes"){ 
						if ($page=="1") {
							
							echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
							echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
						}else if ($page == $total_pages) {
							echo "using search page1 equal tptalpage";
							echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
							echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
							
						}else{
							echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
							echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
							echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
						
						}
				}else if ($searchall=="yes"){ 
						if ($page=="1") {
							
							echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
							echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
						}else if ($page==$total_pages) {
							echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
							echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
							
						}else{
							echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
							echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
							echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
						
						}
				}else
				if ($page=="1") {
					
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
				}else if ($page == $total_pages) {
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					
				}else{
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
				}
		
				}
			}else{ 
				$nextpage = $page+1;
				
				if ($enteredby=="jex") 
				{
					
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&listsupplieritems=$listsupplieritems&enteredby=$enteredby&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
				}else if ($usingsearch=="yes"){ 
					
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
				}else if ($searchall=="yes"){
					
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
				}else{
					
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
					echo "<a href='manage_item_trans.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
				}
				
			}
		}
		
		
		for($k=0;$k< count($tableheaders);$k++)
		{
			echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
		}
		echo '</tr>'."\n\n";	
		
		$rowCounter=0;
		while($row=mysql_fetch_assoc($result))
		{
			if($rowCounter%2==0)
			{
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			}
			else
			{
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter++;
			for($k=0;$k<count($tablefields);$k++)
			{
				$field=$tablefields[$k];
				$data=$this->formatData($field,$row[$field],$tableprefix);
				
         

		 include ("../settings.php"); 
		 include ("../../../../$cfg_configfile"); 
        if($tablename=='suppliers')
		      {
	
            $suppliername=$tablefields[1];
             $imagetitle=$row[$suppliername];
             
             
             $supplierRowID=$tablefields[0];
             $supplierID=$row[$supplierRowID];
             
			       $supplier_result = mysql_query("SELECT image FROM $table WHERE id = $supplierID",$this->conn);
             $supplier_row = mysql_fetch_assoc($supplier_result);
             $myimage=$supplier_row['image'];
            
             if($myimage=='')
		           {
		       	    $myimage="../../je_images/no_picture.gif";
		           }
		       }
        if($tablename=='item_transactions')
		      {

             
             
             $TranRowID=$tablefields[0];
             $TranID=$row[$TranRowID];
             
             $tran_result = mysql_query("SELECT id,itemrow_id,transaction_id,share_inventorytbl_rowid,supplier_id,article_id,item_image FROM $table WHERE id = $TranID",$this->conn);
             $tran_row = mysql_fetch_assoc($tran_result);
             $itemrowid=$tran_row['itemrow_id'];
			 $itemtranstbl_rowid=$tran_row['id'];
			 $inventorytblrowid=$tran_row['share_inventorytbl_rowid'];
			 $transtbl_ItemImage=$tran_row['item_image'];
			 $itemimage=$tran_row['item_image'];
             
			 if ($cfg_imagesnapmethod == "pc"){ 
			    if ($cfg_enable_PopUpUpdateform=="yes"){
					 $viewimagelink="<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a><a href=\"javascript:popUp('form_loadimage.php?action=update&id=$TranID&active_trans_id=$row[transaction_id]&onlyloadimage=yes&itemtblrowid=$itemrowid')\"><img src=\"../je_images/loadimage_icon.png\"width=\"20\" height=\"20\" border=\"0\" title=\"Add/Update Item Image\"  ></a></td>";
				}else{	
					$viewimagelink="<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a><a href=\"form_loadimage.php?action=update&id=$TranID&active_trans_id=$row[transaction_id]&onlyloadimage=yes&itemtblrowid=$itemrowid\"><img src=\"../je_images/loadimage_icon.png\"width=\"20\" height=\"20\" border=\"0\" title=\"Add/Update Item Image\"  ></a></td>";
			    } 
			
			}else{ 
				if ($cfg_enable_PopUpUpdateform=="yes"){
                   $viewimagelink="<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a><a href=\"javascript:popUp('../webcam/webcam.php?action=update&itemrowid=$itemrowid&active_trans_id=$tran_row[transaction_id]&itemtranstbl_rowid=$itemtranstbl_rowid&inventorytblrowid=$inventorytblrowid&comingfrom=itemtranpanel&redirectto=mitemslink1')\"><img src=\"../je_images/loadimage_icon.png\"width=\"20\" height=\"20\" border=\"0\" title=\"Add/Update Item Image\" ></a></td>";
				}else{
				  $viewimagelink="<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a><a href=\"../webcam/webcam.php?action=update&itemrowid=$itemrowid&active_trans_id=$tran_row[transaction_id]&itemtranstbl_rowid=$itemtranstbl_rowid&inventorytblrowid=$inventorytblrowid&comingfrom=itemtranpanel&redirectto=mitemslink1\"><img src=\"../je_images/loadimage_icon.png\"width=\"20\" height=\"20\" border=\"0\" title=\"Add/Update Item Image\" ></a></td>";
			 
				}
			 
			 }			
			 
	
		     
             
             
             if ($itemrowid <> 0) {
             

             
             $itemrow_id=$tran_row['itemrow_id'];
             
             $itemtable="$tableprefix".'items';
 
             $Item_result = mysql_query("SELECT article_id,item_image FROM $itemtable WHERE id = $itemrow_id",$this->conn);
             $Item_row = mysql_fetch_assoc($Item_result);
             $myimage=$Item_row['item_image'];
             
			 
			 if($myimage !='' || $myimage !=null){
			     if ($cfg_data_outside_storedir == "yes"){
			         $myimage= $cfg_data_itemIMGpathdir.$myimage;
			     }else{  
			         $myimage= 'images/'.$myimage;
			    }
			 }else{
                     $myimage="../je_images/no_picture.gif";
             }	
				

             
             $myarticleid=$Item_row['article_id'];
             $imagetitle=$this->idToField("$tableprefix".'articles','article',"$myarticleid");
             
            
             
           }else{  
             
               $Transtblrowid=$tran_row['id'];
               $Transid=$tran_row['transaction_id'];   

		           
				   
				   if($myimage !='' || $myimage !=null){ 
				      if ($cfg_data_outside_storedir == "yes"){
			             $myimage= $cfg_data_itemIMGpathdir.$transtbl_ItemImage;
			          }else{  
			             $myimage= 'images/'.$transtbl_ItemImage;
			          }
					}else{
                        $myimage="../je_images/no_picture.gif";
                    }	
				   
				   
				   
	
		      
		       }
		      
		      
		      
		      }
		       
		      
		       
        
				
				echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			}
			
			
	if ($usertype=="Admin"){

        if ($cfg_enable_PopUpUpdateform=="yes"){
         	echo "
			$viewimagelink
			<td align='center'>\n<a href=\"create_barcodePDF_code39.php?&working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>
			<td align='center'>\n<a href=\"form_items.php?action=insert&working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]\"><font color='$this->rowcolor_link'>{$this->lang->addItem}</font></a></td>
			<td align='center'>\n<a href=\"create_saleagreement_IL.php?working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]&saonly=yes\"><font color='$this->rowcolor_link'>{$this->lang->createSaleagreement}</font></a></td>
			<td align='center'>\n<a href=\"create_saleagreement_IL.php?working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]&checkonly=yes\"><font color='$this->rowcolor_link'>{$this->lang->CreateCheck}</font></a></td>
			<td align='center'>\n<a href=\"javascript:popUp('form_item_trans_update.php?action=update&id=$row[id]')\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			<td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $table {$this->lang->table}?','process_form_$tablename.php?action=delete&id=$row[id]&itemimage=$myimage')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>
			\n</tr>\n\n";	
		
		}else{
		
			echo "
			$viewimagelink
			<td align='center'>\n<a href=\"create_barcodePDF_code39.php?&working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>
			<td align='center'>\n<a href=\"form_items.php?action=insert&working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]\"><font color='$this->rowcolor_link'>{$this->lang->addItem}</font></a></td>
			<td align='center'>\n<a href=\"create_saleagreement_IL.php?working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]&saonly=yes\"><font color='$this->rowcolor_link'>{$this->lang->createSaleagreement}</font></a></td>
			<td align='center'>\n<a href=\"create_saleagreement_IL.php?working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]&checkonly=yes\"><font color='$this->rowcolor_link'>{$this->lang->CreateCheck}</font></a></td>
			<td align='center'>\n<a href=\"form_item_trans_update.php?action=update&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			<td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $table {$this->lang->table}?','process_form_$tablename.php?action=delete&id=$row[id]&itemimage=$myimage')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>
			\n</tr>\n\n";
		}
		
	}else{

		if ($cfg_enable_PopUpUpdateform=="yes"){
			echo "
			$viewimagelink
			<td align='center'>\n<a href=\"create_barcodePDF_code39.php?&working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>
			<td align='center'>\n<a href=\"form_items.php?action=insert&working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]\"><font color='$this->rowcolor_link'>{$this->lang->addItem}</font></a></td>
			<td align='center'>\n<a href=\"create_saleagreement_IL.php?working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]&saonly=yes\"><font color='$this->rowcolor_link'>{$this->lang->createSaleagreement}</font></a></td>
			<td align='center'>\n<a href=\"javascript:popUp('form_item_trans_update.php?action=update&id=$row[id]')\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			<td align='center'>\n<a href=\"create_saleagreement_IL.php?working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]&checkonly=yes\"><font color='$this->rowcolor_link'>{$this->lang->CreateCheck}</font></a></td>
			\n</tr>\n\n";
		
		}else{
			echo "
			$viewimagelink
			<td align='center'>\n<a href=\"create_barcodePDF_code39.php?&working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>
			<td align='center'>\n<a href=\"form_items.php?action=insert&working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]\"><font color='$this->rowcolor_link'>{$this->lang->addItem}</font></a></td>
			<td align='center'>\n<a href=\"create_saleagreement_IL.php?working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]&saonly=yes\"><font color='$this->rowcolor_link'>{$this->lang->createSaleagreement}</font></a></td>
			<td align='center'>\n<a href=\"form_item_trans_update.php?action=update&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			<td align='center'>\n<a href=\"create_saleagreement_IL.php?working_on_id=$row[supplier_id]&active_trans_id=$row[transaction_id]&checkonly=yes\"><font color='$this->rowcolor_link'>{$this->lang->CreateCheck}</font></a></td>
			\n</tr>\n\n";
		}
    }	
				
		
		}
			echo '</table>'."\n";
	}
	
	function displayReportTable($tableprefix,$tablename,$tableheaders,$tablefields,$wherefield,$wheredata,$date1,$date2,$orderby,$subtitle)
	{
		echo "<center><h4><font color='$this->list_of_color'>$subtitle</font></h4></center>";
		$tablewidth='85%';
		
		$table="$tableprefix"."$tablename";
		echo "\n".'<center>';
		if($wherefield!='' and $wheredata!='' and $date1=='' and $date2=='')
		{
			$result = mysql_query("SELECT * FROM $table WHERE $wherefield = \"$wheredata\" ORDER BY $orderby",$this->conn);
		}
		elseif($wherefield!='' and $wheredata!='' and $date1!='' and $date2!='')
		{
			$result = mysql_query("SELECT * FROM $table WHERE $wherefield = \"$wheredata\" and date between \"$date1\" and \"$date2\" ORDER BY $orderby",$this->conn);
		}
		elseif($date1!='' and $date2!='')
		{
			$result = mysql_query("SELECT * FROM $table WHERE date between \"$date1\" and \"$date2\" ORDER BY $orderby",$this->conn);

		}
		else
		{
			$result = mysql_query("SELECT * FROM $table ORDER BY $orderby",$this->conn);
		}
		echo '<hr>';
		if(@mysql_num_rows($result) ==0)
		{
			echo "<div align='center'>{$this->lang->noDataInTable} <b>$table</b> {$this->lang->table}.</div>";
			exit();
		}
		echo "<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
		<tr bgcolor=$this->header_rowcolor>\n\n";
		for($k=0;$k< count($tableheaders);$k++)
		{
			echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
		}
		echo '</tr>'."\n\n";	
		
		
		$rowCounter=0;
		while($row=mysql_fetch_assoc($result))
		{
			if($rowCounter%2==0)
			{
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			}
			else
			{
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter++;
			for($k=0;$k<count($tablefields);$k++)
			{
				$field=$tablefields[$k];
				
				if($field=='sale_details')
				{
					$temp_customer_id=$row['customer_id'];
					$temp_date=$row['date'];
					$temp_sale_id=$row['id'];
					$data="<a href=\"javascript:popUp('show_details.php?sale_id=$temp_sale_id&sale_customer_id=$temp_customer_id&sale_date=$temp_date')\"><font color='$this->rowcolor_link'>{$this->lang->showSaleDetails}</font></a>";

				}
				else
				{
					if($field=='brand_id' or $field=='category_id' or $field=='supplier_id' or $field=='item_id')
					{
						$field_data=$this->idToField("$tableprefix".'item_transactions',"$field",$row['item_id']);
						$data=$this->formatData($field,$field_data,$tableprefix);
					}
					else
					{
						$data=$this->formatData($field,$row[$field],$tableprefix);
					
					}
				}	
				
				
				echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			}
			
				
		}	
				echo '</table>'."\n";	
		
	}
	
	function displaySaleManagerTable($tableprefix,$where1,$where2)
	{
		$tablewidth='85%';
		$sales_table="$tableprefix"."sales";
		$sales_items_table="$tableprefix"."sales_items";

		if($where1!='' and $where2!='')
		{

			$sale_query="SELECT * FROM $sales_table WHERE id between \"$where1\" and \"$where2\" ORDER BY id DESC"; 
			$sale_result=mysql_query($sale_query,$this->conn);
			
			
		}
		else
		{
			$sale_query="SELECT * FROM $sales_table ORDER BY id DESC"; 
			$sale_result=mysql_query($sale_query,$this->conn);
			
		}
		
			$sales_tableheaders=array("{$this->lang->date}","{$this->lang->customerName}","{$this->lang->itemsPurchased}","{$this->lang->paidWith}","{$this->lang->soldBy}","{$this->lang->saleSubTotal}","{$this->lang->saleTotalCost}","{$this->lang->saleComment}");
			$sales_tablefields=array('date','customer_id','items_purchased','paid_with','sold_by','sale_sub_total','sale_total_cost','comment');
		
			$sales_items_tableheaders=array("{$this->lang->itemName}","{$this->lang->brand}","{$this->lang->category}","{$this->lang->supplier}","{$this->lang->quantityPurchased}","{$this->lang->unitPrice}","{$this->lang->tax}","{$this->lang->itemTotalCost}","{$this->lang->updateItem}","{$this->lang->deleteItem}");
			$sales_items_tablefields=array('item_id','brand_id','category_id','supplier_id','quantity_purchased','item_unit_price','item_total_tax','item_total_cost');
		

		if(@mysql_num_rows($sale_result) < 1)
		{
			echo "<div align='center'>You do not have any data in the <b>sales</b> tables.</div>";
			exit();
		}
		
		$rowCounter1=0;
		echo "<center><table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color 3 px\"><tr><td><br>";
		while($row=mysql_fetch_assoc($sale_result))
		{			

			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\"><tr><td align='center'><br><b>{$this->lang->saleID} $row[id]</b>
			[<a href='update_sale.php?id=$row[id]'>{$this->lang->updateSale}</a>]
			[<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_table {$this->lang->table}?','delete_sale.php?id=$row[id]')\">{$this->lang->deleteEntireSale}]</a>
			<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
			<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k< count($sales_tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$sales_tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
			if($rowCounter1%2==0)
			{
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			}
			else
			{
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter1++;
			for($k=0;$k<count($sales_tablefields);$k++)
			{
				$field=$sales_tablefields[$k];
				$data=$this->formatData($field,$row[$field],$tableprefix);
				
				echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
				
				
			}
			
			echo '</tr></table>';
			$sale_items_query="SELECT * FROM $sales_items_table WHERE sale_id=\"$row[id]\"";
			$sale_items_result=mysql_query($sale_items_query,$this->conn);
			echo "<br><b>{$this->lang->itemsInSale}</b><table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
					<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k<count($sales_items_tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$sales_items_tableheaders[$k]</font>\n</th>\n";
			}
			echo '</tr>';
			
			$rowCounter2=0;
			while($newrow=mysql_fetch_assoc($sale_items_result))
			{
				if($rowCounter2%2==0)
				{
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				}
				else
				{
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}
				
				
				$rowCounter2++;
				for($k=0;$k<count($sales_items_tablefields);$k++)
				{
					$field=$sales_items_tablefields[$k];
					if($field=='brand_id' or $field=='category_id' or $field=='supplier_id')
					{
						$field_data=$this->idToField("$tableprefix".'item_transactions',"$field",$newrow['item_id']);
						$data=$this->formatData($field,$field_data,$tableprefix);
					}
					else
					{
						$data=$this->formatData($field,$newrow[$field],$tableprefix);
					}
					echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
				}
			
				echo "<td align='center'>\n<a href=\"update_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			  <td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_items_table {$this->lang->table}?','delete_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>\n</tr>\n\n";

			echo '</tr>'."\n\n";
			}
			echo '</table><br></table><br>';
		}
			echo "</table></td></tr></table></center>";
	}
	function displayTotalsReport($tableprefix,$total_type,$tableheaders,$date1,$date2,$where1,$where2)
	{
		$sales_table="$tableprefix".'sales';
		$sales_items_table="$tableprefix".'sales_items';
		
		$items_table="$tableprefix".'item_transactions';
		$brands_table="$tableprefix".'brands';
		$categories_table="$tableprefix".'categories';
		$suppliers_table="$tableprefix".'suppliers';
		$customer_table="$tableprefix".'customers';
		$users_table="$tableprefix".'users';


		if($total_type=='customers')
		{
			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
			
			$query="SELECT * FROM $customer_table ORDER BY last_name";
			$customer_result=mysql_query($query,$this->conn);
			$temp_cust_id=0;
			
			$accum_sub_total=0;
			$accum_total_cost=0;
			$accum_items_purhcased=0;
			$row_counter=0;
			while($row=mysql_fetch_assoc($customer_result))
			{
				$temp_cust_id=$row['id'];
				$customer_name=$this->formatData('customer_id',$temp_cust_id,$tableprefix);
				$query2="SELECT * FROM $sales_table WHERE customer_id=\"$temp_cust_id\" and date between \"$date1\" and \"$date2\"";
				$result2=mysql_query($query2,$this->conn);
				
				$sub_total=0;
				$total_cost=0;
				$items_purchased=0;
				
				while($row2=mysql_fetch_assoc($result2))
				{
					$sub_total+=$row2['sale_sub_total'];
					$accum_sub_total+=$row2['sale_sub_total'];
					
					$total_cost+=$row2['sale_total_cost'];
					$accum_total_cost+=$row2['sale_total_cost'];
					
					$items_purchased+=$row2['items_purchased'];
					$accum_items_purhcased+=$row2['items_purchased'];
				}
				$row_counter++;
				
				$sub_total=number_format($sub_total,2,'.', '');
				$total_cost=number_format($total_cost,2,'.', '');


				if($row_counter%2==0)
				{
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				}
				else
				{
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$customer_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total=number_format($accum_sub_total,2,'.', '');
			$accum_total_cost=number_format($accum_total_cost,2,'.', '');
			
		     echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "<tr><td>{$this->lang->totalItemsPurchased}: <b>$accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b>$this->currency_symbol$accum_total_cost</b></td></tr></table>";
		}
		elseif($total_type=='employees')
		{
			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
			
			$query="SELECT * FROM $users_table ORDER BY last_name";
			$employee_result=mysql_query($query,$this->conn);
			$temp_cust_id=0;
			
			$accum_sub_total=0;
			$accum_total_cost=0;
			$accum_items_purhcased=0;
			$row_counter=0;
			while($row=mysql_fetch_assoc($employee_result))
			{
				$temp_empl_id=$row['id'];
				$employee_name=$this->formatData('user_id',$temp_empl_id,$tableprefix);
				$query2="SELECT * FROM $sales_table WHERE sold_by=\"$temp_empl_id\" and date between \"$date1\" and \"$date2\"";
				$result2=mysql_query($query2,$this->conn);
				
				$sub_total=0;
				$total_cost=0;
				$items_purchased=0;
				
				while($row2=mysql_fetch_assoc($result2))
				{
					$sub_total+=$row2['sale_sub_total'];
					$accum_sub_total+=$row2['sale_sub_total'];
					
					$total_cost+=$row2['sale_total_cost'];
					$accum_total_cost+=$row2['sale_total_cost'];
					
					$items_purchased+=$row2['items_purchased'];
					$accum_items_purhcased+=$row2['items_purchased'];
				}
				$row_counter++;
				
				$sub_total=number_format($sub_total,2,'.', '');
				$total_cost=number_format($total_cost,2,'.', '');


				if($row_counter%2==0)
				{
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				}
				else
				{
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$employee_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total=number_format($accum_sub_total,2,'.', '');
			$accum_total_cost=number_format($accum_total_cost,2,'.', '');
			
		     echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "<tr><td>{$this->lang->totalItemsPurchased}:<b> $accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b> $this->currency_symbol$accum_total_cost</b></td></tr></table>";
		
		
		
		}
		elseif($total_type=='item_transactions')
		{
					echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='70%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
			
			
			$query="SELECT * FROM $items_table ORDER BY item_name";
			$item_result=mysql_query($query,$this->conn);
			$temp_item_id=0;
			
			$accum_sub_total=0;
			$accum_total_cost=0;
			$accum_items_purhcased=0;
			$row_counter=0;
			while($row=mysql_fetch_assoc($item_result))
			{
				$temp_item_id=$row['id'];
				$item_name=$this->formatData('item_id',$temp_item_id,$tableprefix);
				$temp_brand=$this->idToField($brands_table,'brand',$this->idToField($items_table,'brand_id',$temp_item_id));
				$temp_category=$this->idToField($categories_table,'category',$this->idToField($items_table,'category_id',$temp_item_id));
				$temp_supplier=$this->idToField($suppliers_table,'supplier',$this->idToField($items_table,'supplier_id',$temp_item_id));
				
				$query2=mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by id ASC",$this->conn);
				$sale_row1=mysql_fetch_assoc($query2);
				$low_sale_id=$sale_row1['id'];
				
				$query3=mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by id DESC",$this->conn);
				$sale_row2=mysql_fetch_assoc($query3);
				$high_sale_id=$sale_row2['id'];
				
				
				$query4="SELECT * FROM $sales_items_table WHERE item_id=\"$temp_item_id\" and sale_id between \"$low_sale_id\" and \"$high_sale_id\"";
				$result4=mysql_query($query4,$this->conn);
				
				$sub_total=0;
				$total_cost=0;
				$items_purchased=0;
				
				while($row2=mysql_fetch_assoc($result4))
				{
					$sub_total+=$row2['item_total_cost']-$row2['item_total_tax'];
					$accum_sub_total+=$row2['item_total_cost']-$row2['item_total_tax'];
					
					$total_cost+=$row2['item_total_cost'];
					$accum_total_cost+=$row2['item_total_cost'];
					
					$items_purchased+=$row2['quantity_purchased'];
					$accum_items_purhcased+=$row2['quantity_purchased'];
				}
				$row_counter++;
				
				$sub_total=number_format($sub_total,2,'.', '');
				$total_cost=number_format($total_cost,2,'.', '');


				if($row_counter%2==0)
				{
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				}
				else
				{
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$item_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_brand</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_category</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_supplier</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>

		
			
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total=number_format($accum_sub_total,2,'.', '');
			$accum_total_cost=number_format($accum_total_cost,2,'.', '');
			
		     echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "<tr><td>{$this->lang->totalItemsPurchased}:<b> $accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b> $this->currency_symbol$accum_total_cost</b></td></tr></table>";
		}
		elseif($total_type=='item')
		{
			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
				
				$query="SELECT * FROM $items_table WHERE $where1=\"$where2\" ORDER BY item_name";
				$item_result=mysql_query($query,$this->conn);
				$row=mysql_fetch_assoc($item_result);
				$temp_item_id=$row['id'];
				$item_name=$this->formatData('item_id',$temp_item_id,$tableprefix);
				$temp_brand=$this->idToField($brands_table,'brand',$this->idToField($items_table,'brand_id',$temp_item_id));
				$temp_category=$this->idToField($categories_table,'category',$this->idToField($items_table,'category_id',$temp_item_id));
				$temp_supplier=$this->idToField($suppliers_table,'supplier',$this->idToField($items_table,'supplier_id',$temp_item_id));
				
				$item_name=$this->formatData('item_id',$temp_item_id,$tableprefix);
				
				$query2=mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by id ASC",$this->conn);
				$sale_row1=mysql_fetch_assoc($query2);
				$low_sale_id=$sale_row1['id'];
				
				$query3=mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by id DESC",$this->conn);
				$sale_row2=mysql_fetch_assoc($query3);
				$high_sale_id=$sale_row2['id'];
				
				
				$query4="SELECT * FROM $sales_items_table WHERE item_id=\"$temp_item_id\" and sale_id between \"$low_sale_id\" and \"$high_sale_id\"";
				$result4=mysql_query($query4,$this->conn);
				
								
				$sub_total=0;
				$total_cost=0;
				$items_purchased=0;
				
				while($row2=mysql_fetch_assoc($result4))
				{
					$sub_total+=$row2['item_total_cost']-$row2['item_total_tax'];
					$total_cost+=$row2['item_total_cost'];
					$items_purchased+=$row2['quantity_purchased'];
				}
				
				$sub_total=number_format($sub_total,2,'.', '');
				$total_cost=number_format($total_cost,2,'.', '');


				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$item_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_brand</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_category</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_supplier</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					
					
					</tr>";
			
			echo '</table>';
		
		}
		elseif($total_type=='profit')
		{
		

			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
			
			$query="SELECT DISTINCT date FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by date ASC";
			$result=mysql_query($query);
			
			$amount_sold=0;
			$profit=0;
			$total_amount_sold=0;
			$total_profit=0;
			while($row=mysql_fetch_assoc($result))
			{
			
				$amount_sold=0;
				$profit=0;
				
				$distinct_date=$row['date'];
				$result2=mysql_query("SELECT * FROM $sales_table WHERE date=\"$distinct_date\"",$this->conn);

				echo "\n<tr bgcolor=$this->rowcolor1>\n";
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$distinct_date</font>\n</td>";
				
				while($row2=mysql_fetch_assoc($result2))
				{
					$amount_sold+=$row2['sale_sub_total'];
					$total_amount_sold+=$row2['sale_sub_total'];
					$profit+=$this->getProfit($row2['id'],$tableprefix);
					$total_profit+=$this->getProfit($row2['id'],$tableprefix);
					
				}
				
				$amount_sold=number_format($amount_sold,2,'.', '');
				$profit=number_format($profit,2,'.', '');

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$amount_sold</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$profit</font>\n</td>";


				echo "</tr>";
			}
			
			echo '</table>';
			
			
			$total_amount_sold=number_format($total_amount_sold,2,'.', '');
			$total_profit=number_format($total_profit,2,'.', '');
				
			 echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "<tr><td>{$this->lang->totalAmountSold}: <b>$this->currency_symbol$total_amount_sold</b></td></tr>
			 	<tr><td>{$this->lang->totalProfit}: <b>$this->currency_symbol$total_profit</b></td></tr>
				 </table>";


		}
	}
	
	function getProfit($sale_id,$tableprefix)
	{
		$sales_items_table="$tableprefix".'sales_items';
		$query="SELECT * FROM $sales_items_table WHERE sale_id=\"$sale_id\"";
		$result=mysql_query($query,$this->conn);
		
		$profit=0;
		while($row=mysql_fetch_assoc($result))
		{
			$profit+=($row['item_unit_price']-$row['item_buy_price'])*$row['quantity_purchased'];	
		}
	
		return $profit;
	}
	
	function formatData($field,$data,$tableprefix)
	{
		if($field=='unit_price' or $field=='total_cost' or $field=='buy_price' or $field=='sale_sub_total' or $field=='sale_total_cost' or $field=='item_unit_price' or $field=='item_total_cost' or $field=='item_total_tax' )
		{
			return "$this->currency_symbol"."$data";
		}
		elseif($field=='time')
		{
		
			$data=date("g:i a", strtotime($data));
			return "$data";
		}	
		elseif($field=='date')
		{
		
				$tyear = substr("$data",0,4);
				$tmonth = substr("$data",5,2);
				$tday = substr("$data",8,2);
				$data=$tmonth.'-'.$tday.'-'.$tyear;
			return "$data";
		}	
		elseif($field=='tax_percent' or $field=='percent_off')
		{
			return "$data".'%';
		}
   		elseif($field=='brand_id')
		{
			return $this->idToField("$tableprefix".'brands','brand',$data);
		}
		elseif($field=='category_id')
		{
			return $this->idToField("$tableprefix".'categories','category',$data);
		}
		elseif($field=='supplier_id')
		{
			return $this->idToField("$tableprefix".'suppliers','supplier',$data);
		}
		
		elseif($field=='article_id')
		{
			return $this->idToField("$tableprefix".'articles','article',$data);	
	 }
	 elseif($field=='articletype_id')
		{
			return $this->idToField("$tableprefix".'articletypes','articletype',$data);	
	 }
		elseif($field=='customer_id')
		{
			$field_first_name=$this->idToField("$tableprefix".'customers','first_name',$data);
			$field_last_name=$this->idToField("$tableprefix".'customers','last_name',$data);
			return $field_first_name.' '.$field_last_name;
		}
		elseif($field=='user_id')
		{
			$field_first_name=$this->idToField("$tableprefix".'users','first_name',$data);
			$field_last_name=$this->idToField("$tableprefix".'users','last_name',$data);
			return $field_first_name.' '.$field_last_name;
		}
		elseif($field=='item_id')
		{
			return $this->idToField("$tableprefix".'item_transactions','item_name',$data);
		}
		elseif($field=='sold_by')
		{
			$field_first_name=$this->idToField("$tableprefix".'users','first_name',$data);
			$field_last_name=$this->idToField("$tableprefix".'users','last_name',$data);
			return $field_first_name.' '.$field_last_name;				
		}
		elseif($field=='supplier_id')
		{
			return $this->idToField("$tableprefix".'suppliers','supplier',$data);
		}
		elseif($field=='password')
		{
			return '*******';

		}
		else
		{
			return "$data";
		}
			
	}
	
	
		
}


?>

</body>
</html>