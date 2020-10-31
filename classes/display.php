<html>
<head>

<title>Inventory System</title>

	<link rel="stylesheet" href="../../classes/css/lightbox.css" type="text/css" media="screen" />
	
	<script src="../../classes/js/prototype.js" type="text/javascript"></script>
	<script src="../../classes/js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="../../classes/js/lightbox.js" type="text/javascript"></script>
  
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
			$tablewidth='120%';
		}
		
		$table="$tableprefix"."$tablename";
		echo "\n".'<center>';
		
		
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
		$start_from = ($page-1) * 25;
		
		
		
		if($wherefield=='quantity' and $wheredata=='outofstock')
		{
			$result = mysql_query("SELECT * FROM $table WHERE quantity < 1 ORDER BY $orderby",$this->conn);
		}
		elseif($wherefield=='quantity' and $wheredata=='reorder')
		{
			$result = mysql_query("SELECT * FROM $table WHERE quantity <= reorder_level ORDER BY $orderby",$this->conn);

		}
		elseif($wherefield=="ALL" and $wheredata!='')
		{
		  $wheredata=trim($wheredata);
		  $searchall='yes';
			$result = mysql_query("SELECT * FROM $table WHERE supplier like \"%$wheredata%\" or phone_number like \"%$wheredata%\"ORDER BY $orderby LIMIT $start_from,25",$this->conn);
	

			$result2 = mysql_query("SELECT * FROM $table WHERE supplier like \"%$wheredata%\" or phone_number like \"%$wheredata%\"ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		elseif($wherefield!='' and $wheredata!='')
		{
			$wheredata=trim($wheredata);
			$usingsearch='yes';
	
			$result = mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" ORDER BY $orderby LIMIT $start_from,25",$this->conn);

			$result2 = mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		elseif($this->getNumRows($table) >25)
		{
			$result = mysql_query("SELECT * FROM $table ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);


			$resultnumrows = mysql_query("SELECT * FROM $table ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);
			echo "<font color=GREEN>{$this->lang->moreThan25} $table".'\'s'." {$this->lang->first25Displayed}";

			$resulttotalrows = mysql_query("SELECT * FROM $table ORDER BY $orderby DESC ",$this->conn);
			$totalnumrows = mysql_num_rows($resulttotalrows);
			$totalnumrows= " Total rows: " . $totalnumrows;
		
			}
		else
		{			
			$result = mysql_query("SELECT * FROM $table ORDER BY $orderby DESC",$this->conn);
		}
		echo '<hr>';
		if(@mysql_num_rows($result) ==0)
		{
			echo "<div align='center'>{$this->lang->noDataInTable} <b>$table</b> {$this->lang->table}.</div>";
			exit();
		}
		echo "<center><h4><font color='$this->list_of_color'>{$this->lang->listOf} $tablename Total Rows Returned $num_rows $totalnumrows</font></h4></center>";
		echo "<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
		<tr bgcolor=$this->header_rowcolor>\n\n";
		
						
		
		$total_records = $num_rows; 
		$total_pages = ceil($total_records / 25); 


	$urllinkcolor="#064A08";
	$pagenumcolor="#0D11F2";
	

	if ($total_pages > 1) {
	if (isset($_GET["totalpages"])){
	
	if ($nextpage <= $total_pages){ 
	   $nextpage = $page + 1; 
       $backpage = $page - 1;
	   
     if ($usingsearch=="yes"){
		
		 if ($page=="1") {
		 	
			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	  
		 }else if ($page == $total_pages) {
		 	echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

		 }else{
			echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	     echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	    }
	 
	 }else if ($searchall=="yes"){
	 
	      if ($page=="1") {
		  
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	      echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	      
		  }else if ($page == $total_pages) {
		  	echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
		  
		  }else{
	 	  echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	      echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	     }
	 
	 }else{
	   if ($page=="1") {

		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
	     echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	     
	   }else if ($page == $total_pages) {
	   	  echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
	
	     
	   
	   }else{
		echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	     echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	     }
		 }
}
	
	}else{
		$nextpage = $page+1;
		
		if ($usingsearch=="yes"){
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
		  echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		}else if ($searchall=="yes"){
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
		  echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&searchall=go&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		
		}else{
	      echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
		  echo "<a href='manage_suppliers.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
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
				
        

		 include ("../../settings.php"); 
		 include ("../../../../../$cfg_configfile"); 
        if($tablename=='suppliers')
		      {

             
             $suppliername=$tablefields[1];
             $imagetitle=$row[$suppliername];
             

             
             $supplierRowID=$tablefields[0];
             $supplierID=$row[$supplierRowID];
             
			 $supplier_result = mysql_query("SELECT imagelic,imagecust,imagethumb FROM $table WHERE id = $supplierID",$this->conn);
             $supplier_row = mysql_fetch_assoc($supplier_result);
             $myimage=$supplier_row['imagelic']; 
             $custimage=$supplier_row['imagecust']; 
             $thumbimage=$supplier_row['imagethumb']; 
			 $myimagelic= $myimage; 
             $mycustimage = $custimage;
			 $mythumbimage = $thumbimage;
			 

			
			
			
			
			if($myimage !=''){ 
			   if ($cfg_data_outside_storedir == "yes"){
			       $myimage= $cfg_data_supplierIMGpathdir.$myimage;
			   }else{
			       $myimage= 'images/'.$myimage;
              }
		   }else{
               $myimage="../../je_images/no_picture.gif";
           }		
			
			
			if($custimage !=''){ 
			   if ($cfg_data_outside_storedir == "yes"){
			       $custimage= $cfg_data_supplierIMGpathdir.$custimage;
			   }else{
			       $custimage= 'images/'.$custimage;
              }
		   }else{
               $custimage="../../je_images/no_picture.gif";
           }		
			
			
			if($thumbimage !=''){ 
			   if ($cfg_data_outside_storedir == "yes"){
			       $thumbimage= $cfg_data_supplierIMGpathdir.$thumbimage;
			   }else{
			       $thumbimage= 'images/'.$thumbimage;
              }
		   }else{
               $thumbimage="../../je_images/no_picture.gif";
           }		
			           
		           
		}
        if($tablename=='items')
		      {

             
             $itemname=$tablefields[1];
             $imagetitle=$row[$itemname];
             
             
             $ItemRowID=$tablefields[0];
             $ItemID=$row[$ItemRowID];
             
			 $Item_result = mysql_query("SELECT item_image FROM $table WHERE id = $ItemID",$this->conn);
             $Item_row = mysql_fetch_assoc($Item_result);
             $myimage=$Item_row['item_image'];
             
             if ($cfg_data_outside_storedir == "yes"){
			     $myimage= $cfg_data_itemIMGpathdir.$myimage;
			 }else{
			    $myimage= '../images/'.$myimage;
             }

             if($myimage=='')
		          {
		       	    $myimage="../je_images/no_picture.gif";
		          }
		       }
		      
			  
			  
		if ($cfg_imageZipORnozip == "nozip") {	  
			  
		      $imagelinks="<td align='center'>\n<a href=\"$myimage\" rel=\"lightbox\" title=\"View ID Image\"><font color='$this->rowcolor_link'>L </font></a><a href=\"$custimage\" rel=\"lightbox\" title=\"View Person Image\"><font color='$this->rowcolor_link'>P </font></a><a href=\"$thumbimage\" rel=\"lightbox\" title=\"View Thumb Image\"><font color='$this->rowcolor_link'>T </font></a></td>";
		}else{ 
             $imagelinks="<td align='center'>\n<a href=\"displayimage.php?&licimage=$myimagelic\" rel=\"lightbox\" title=\"View ID Image\"><font color='$this->rowcolor_link'>L </font></a><a href=\"displayimage.php?&custimg=$mycustimage\" rel=\"lightbox\" title=\"View Person Image\"><font color='$this->rowcolor_link'>P </font></a><a href=\"displayimage.php?&thumbimg=$mythumbimage\" rel=\"lightbox\" title=\"View Thumb Image\"><font color='$this->rowcolor_link'>T </font></a></td>";	 
		}
		 
	
			   

        
				
				echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			}
			
		if ($usertype=="Admin"){
			if ($cfg_enable_PopUpUpdateform=="yes"){
				$fromupdatelink='yes';
				echo "<td align='center'>\n<a href=\"javascript:popUp('form_$tablename.php?action=update&id=$row[id]&fromupdatelink=$fromupdatelink')\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
				<td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $table {$this->lang->table}?','process_form_$tablename.php?action=delete&id=$row[id]&imgnm=$myimage &custimg=$custimage &thumbimg=$thumbimage')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>
				$imagelinks
				<td align='center'>\n<a href=\"../form_items.php?action=insert&id=$row[id]&csa=yes\"><font color='$this->rowcolor_link'>{$this->lang->addItem}</font></a><a href=\"../manage_item_trans.php?listsupplieritems=$supplierID&suppliername=$suppliername&enteredby=go\"><img src=\"../../je_images/list_go.png\"width=\"20\" height=\"20\" border=\"0\" title=\"Items Purchased\" ></a></td>
				<td align='center'>\n<a href=\"manage_supplier_printedchecks.php?&id=$row[id]\"><font color='$this->rowcolor_link'>Checks</font></a></td>
				<td align='center'>\n<a href=\"../saleagreements.php?&id=$row[id]&sname=$row[$suppliername]\"><font color='$this->rowcolor_link'>{$this->lang->viewsaleagreement}</font></a></td>\n</tr>\n\n";
			}else{
				echo "<td align='center'>\n<a href=\"form_$tablename.php?action=update&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
				<td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $table {$this->lang->table}?','process_form_$tablename.php?action=delete&id=$row[id]&imgnm=$myimage &custimg=$custimage &thumbimg=$thumbimage')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>
				$imagelinks
				<td align='center'>\n<a href=\"../form_items.php?action=insert&id=$row[id]&csa=yes\"><font color='$this->rowcolor_link'>{$this->lang->addItem}</font></a><a href=\"../manage_item_trans.php?listsupplieritems=$supplierID&suppliername=$suppliername&enteredby=go\"><img src=\"../../je_images/list_go.png\"width=\"20\" height=\"20\" border=\"0\" title=\"Items Purchased\" ></a></td>
				<td align='center'>\n<a href=\"manage_supplier_printedchecks.php?&id=$row[id]\"><font color='$this->rowcolor_link'>Checks</font></a></td>
				<td align='center'>\n<a href=\"../saleagreements.php?&id=$row[id]&sname=$row[$suppliername]\"><font color='$this->rowcolor_link'>{$this->lang->viewsaleagreement}</font></a></td>\n</tr>\n\n";
			}
		}else{ 
			if ($cfg_enable_PopUpUpdateform=="yes"){
				echo "<td align='center'>\n<a href=\"javascript:popUp(\"form_$tablename.php?action=update&id=$row[id]&fromupdatelink=yes\")\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
				$imagelinks
				<td align='center'>\n<a href=\"../form_items.php?action=insert&id=$row[id]&csa=yes\"><font color='$this->rowcolor_link'>{$this->lang->addItem}</font></a></td>
				<td align='center'>\n<a href=\"manage_supplier_printedchecks.php?&id=$row[id]\"><font color='$this->rowcolor_link'>Checks</font></a></td>
				<td align='center'>\n<a href=\"../saleagreements.php?&id=$row[id]&sname=$row[$suppliername]\"><font color='$this->rowcolor_link'>{$this->lang->viewsaleagreement}</font></a></td>\n</tr>\n\n";
			}else{
				echo "<td align='center'>\n<a href=\"form_$tablename.php?action=update&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
				$imagelinks
				<td align='center'>\n<a href=\"../form_items.php?action=insert&id=$row[id]&csa=yes\"><font color='$this->rowcolor_link'>{$this->lang->addItem}</font></a></td>
				<td align='center'>\n<a href=\"manage_supplier_printedchecks.php?&id=$row[id]\"><font color='$this->rowcolor_link'>Checks</font></a></td>
				<td align='center'>\n<a href=\"../saleagreements.php?&id=$row[id]&sname=$row[$suppliername]\"><font color='$this->rowcolor_link'>{$this->lang->viewsaleagreement}</font></a></td>\n</tr>\n\n";
			}
				}	
	
	

		
			
		}
			echo '</table>'."\n";
	}
	
	function displayReportTable($tableprefix,$tablename,$tableheaders,$tablefields,$wherefield,$wheredata,$date1,$date2,$orderby,$subtitle)
	{
		
		
		
		
		
		
		
		
		echo "<center><h4><font color='$this->list_of_color'>$subtitle</font></h4></center>";
		$tablewidth='95%';
		
		$table="$tableprefix"."$tablename";
		$userid=$_SESSION['session_user_id'];
        $usertype=$this->idToField("$tableprefix".'users','type',"$userid");
		
		echo "\n".'<center>';
		if($wherefield!='' and $wheredata!='' and $date1=='' and $date2=='')
		{

		$result = mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.quantity_purchased,b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype<>'S' and a.date =\"$wheredata\" ",$this->conn);
		$result2 =mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.quantity_purchased,b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype<>'S' and a.date =\"$wheredata\" ",$this->conn);

		}
		elseif($wherefield!='' and $wheredata!='' and $date1!='' and $date2!='')
		{
			$result = mysql_query("SELECT * FROM $table WHERE $wherefield = \"$wheredata\" and date between \"$date1\" and \"$date2\" ORDER BY $orderby",$this->conn);
		}
		elseif($date1!='' and $date2!='') 
		{

			$result = mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.quantity_purchased,b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype<>'S' and a.date between \"$date1\" and \"$date2\" ",$this->conn);
			$result2 = mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.quantity_purchased,b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype<>'S' and a.date between \"$date1\" and \"$date2\" ",$this->conn);

		
		
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
					
              }else if ($field=='itemprofit') {
				

				   $data=(($row['item_unit_price'] - $row['item_buy_price']) * ($row['quantity_purchased']));  
				}
			
              else if ($field=='item_buy_price') { 
				
				   $data=(($row['item_buy_price']) * ($row['quantity_purchased']));
				}

			else if ($field=='item_unit_price') { 
				
				   $data=(($row['item_unit_price']) * ($row['quantity_purchased']));
				}
				else
				{
					if($field=='brand_id' or $field=='category_id' or $field=='supplier_id')
					{
						$field_data=$this->idToField("$tableprefix".'items',"$field",$row['item_id']);
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
				
		
		        $sub_total=0;
				$total_cost=0;
				$items_purchased=0;
				$TotalProfit=0;
				
				while($row2=mysql_fetch_assoc($result2))
				{

					$sub_total+=$row2['sale_sub_total']   * $row2['quantity_purchased']; 
		
					
					
	
					$item_unit_price_total+=$row2['item_unit_price'] * $row2['quantity_purchased']; 
					
					$Totaltax+=$row2['item_total_tax'];
					
					

					$TotalProfit+=(($row2['item_unit_price']-$row2['item_buy_price']) * ($row2['quantity_purchased'])); 
					
					

					$total_buycost+=$row2['item_buy_price'] * $row2['quantity_purchased']; 
					$total_cost+=$row2['sale_total_cost'];
					$accum_total_cost+=$row2['item_total_cost']; 
					
					$items_purchased+=$row2['items_purchased'];
					$accum_qty_purhcased+=$row2['quantity_purchased'];
					
				}
				$row_counter++;
				
				$total_buycost=number_format($total_buycost,2,'.', '');
				$sub_total=number_format($sub_total,2,'.', '');
				$total_cost=number_format($total_cost,2,'.', '');
				$TotalProfit=number_format($TotalProfit,2,'.', '');

		
				if ($usertype=="Admin"){
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
				echo "<tr><td>Total Items Sold: <b>$accum_qty_purhcased</b></td></tr>
			 	<tr><td>Total Items Cost: <b>$this->currency_symbol$total_buycost</b></td></tr>
			 	<tr><td>Total Items Price(w/o Tax): <b>$this->currency_symbol$item_unit_price_total</b></td></tr>
				<tr><td>Total Items Tax: <b>$this->currency_symbol$Totaltax</b></td></tr>
				 <tr><td>Total Item Price(w/ Tax): <b>$this->currency_symbol$accum_total_cost</b></td></tr>
				 <tr><td>Total Profit: <b>$this->currency_symbol$TotalProfit</b></td></tr>
				 </table>";
		}else{
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
				echo "<tr><td>Total Items Sold: <b>$accum_qty_purhcased</b></td></tr>
			 	<tr><td>Total Items Cost(w/o Tax): <b>$this->currency_symbol$total_buycost</b></td></tr>
			 	<tr><td>Total Items Price(w/o Tax): <b>$this->currency_symbol$item_unit_price_total</b></td></tr>
				<tr><td>Total Items Tax: <b>$this->currency_symbol$Totaltax</b></td></tr>
				 <tr><td>Total Item Price(w/ Tax): <b>$this->currency_symbol$accum_total_cost</b></td></tr>

				 </table>";
		}
		
	}
		
	function displayServicesReportTable($tableprefix,$tablename,$tableheaders,$tablefields,$wherefield,$wheredata,$date1,$date2,$orderby,$subtitle)
	{
		
		
		
		
		
		
		
		
		
		echo "<center><h4><font color='$this->list_of_color'>$subtitle</font></h4></center>";
		$tablewidth='95%';
		
		$table="$tableprefix"."$tablename";
		$userid=$_SESSION['session_user_id'];
        $usertype=$this->idToField("$tableprefix".'users','type',"$userid");
		
		echo "\n".'<center>';
		if($wherefield!='' and $wheredata!='' and $date1=='' and $date2=='')
		{

		}
		elseif($wherefield!='' and $wheredata!='' and $date1!='' and $date2!='')
		{

		}
		elseif($wheredata=='allservices' and $date1!='' and $date2!='') 
		{

			$result = mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.srvname,b.srvcost,b.quantity_purchased,b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype='S' and a.date between \"$date1\" and \"$date2\" ORDER BY b.srvname ",$this->conn);
			$result2 = mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.srvname,b.srvcost,b.quantity_purchased,b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype='S' and a.date between \"$date1\" and \"$date2\" ORDER BY b.srvname",$this->conn);

				}
		elseif($wheredata!='allservices' and $date1!='' and $date2!='') 
		{
		

           $search_servicename=$this->idToField("$tableprefix".'articles','article',"$wheredata");

			

			$result = mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.srvname,b.srvcost,b.quantity_purchased,b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype='S' and b.srvname = \"$search_servicename\" and a.date between \"$date1\" and \"$date2\" ORDER BY b.srvname ",$this->conn);
			$result2 = mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.srvname,b.srvcost,b.quantity_purchased,b.item_buy_price,b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype='S' and b.srvname = \"$search_servicename\" and a.date between \"$date1\" and \"$date2\" ORDER BY b.srvname",$this->conn);

		
		
		}
		else
		{
			
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
					
              }else if ($field=='itemprofit') {
				

				   $data=(($row['item_unit_price'] - $row['srvcost']) * ($row['quantity_purchased']));  
				
              }else if ($field=='item_unit_price') { 
                    
				$data=(($row['item_unit_price']) * ($row['quantity_purchased']));  
				
			}else if ($field=='srvcost') { 
                    
				$data=(($row['srvcost']) * ($row['quantity_purchased']));  
				
				
				}
				else
				{
					if($field=='brand_id' or $field=='category_id' or $field=='supplier_id')
					{
						$field_data=$this->idToField("$tableprefix".'items',"$field",$row['item_id']);
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
				
		
		        $sub_total=0;
				$total_cost=0;
				$items_purchased=0;
				$TotalProfit=0;
				
				while($row2=mysql_fetch_assoc($result2))
				{

				
  
				    $sub_total+=$row2['sale_sub_total']   * $row2['quantity_purchased']; 
				

					$item_unit_price_total+=$row2['item_unit_price'] * $row2['quantity_purchased']; 
					
					$Totaltax+=$row2['item_total_tax'];
					

					$TotalProfit+=(($row2['item_unit_price']-$row2['srvcost']) * ($row2['quantity_purchased'])); 
					

					$total_buycost+=$row2['srvcost'] * $row2['quantity_purchased']; 
					
					$total_cost+=$row2['sale_total_cost'];
					$accum_total_cost+=$row2['item_total_cost'];
					
					$items_purchased+=$row2['items_purchased'];
					$accum_qty_purhcased+=$row2['quantity_purchased'];
					
				}
				$row_counter++;
				
				$total_buycost=number_format($total_buycost,2,'.', '');
				$sub_total=number_format($sub_total,2,'.', '');
				$total_cost=number_format($total_cost,2,'.', '');
				$TotalProfit=number_format($TotalProfit,2,'.', '');

		
				if ($usertype=="Admin"){
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
				echo "<tr><td>Total Items Sold: <b>$accum_qty_purhcased</b></td></tr>
			 	<tr><td>Total Items Cost: <b>$this->currency_symbol$total_buycost</b></td></tr>
			 	<tr><td>Total Items Price(w/o Tax): <b>$this->currency_symbol$item_unit_price_total</b></td></tr>
				<tr><td>Total Items Tax: <b>$this->currency_symbol$Totaltax</b></td></tr>
				 <tr><td>Total Item Price(w/ Tax): <b>$this->currency_symbol$accum_total_cost</b></td></tr>
				 <tr><td>Total Profit: <b>$this->currency_symbol$TotalProfit</b></td></tr>
				 </table>";
		}else{
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
				echo "<tr><td>Total Items Sold: <b>$accum_qty_purhcased</b></td></tr>
			 	<tr><td>Total Items Cost(w/o Tax): <b>$this->currency_symbol$total_buycost</b></td></tr>
			 	<tr><td>Total Items Price(w/o Tax): <b>$this->currency_symbol$item_unit_price_total</b></td></tr>
				<tr><td>Total Items Tax: <b>$this->currency_symbol$Totaltax</b></td></tr>
				 <tr><td>Total Item Price(w/ Tax): <b>$this->currency_symbol$accum_total_cost</b></td></tr>

				 </table>";
		}
		
	}
			
	function displayInventoryCostReportTable($tableprefix,$tablename,$tableheaders,$tablefields,$wherefield,$wheredata1,$wheredata2,$date1,$date2,$orderby,$subtitle)
	{
		echo "<center><h4><font color='$this->list_of_color'>$subtitle</font></h4></center>";
		$tablewidth='95%';
		
		$table="$tableprefix"."$tablename";
		$userid=$_SESSION['session_user_id'];
        $usertype=$this->idToField("$tableprefix".'users','type',"$userid");
		
		$curdate = date("Y-m-d");

		
		if (($date1 == $curdate) and ($date2 == $curdate))
		{
		  $runningfortoday='yes';

		}else{
		$runningfortoday='no';

		}
		
		
		 if ($date1 == $curdate)
		 { 
		  $DateOneTodaysdate = 'yes';
		 }else{
           $DateOneTodaysdate = 'no';
         }		 
		
		
		  if ($date2 == $curdate)
		 { 
		  $DateTwoTodaysdate = 'yes';
		 }else{
           $DateTwoTodaysdate = 'no';
         }		  
		 

		
		echo "\n".'<center>';
		
		if(($wheredata1=='allcategories') and ($wheredata2=='allitems') and ($DateOneTodaysdate=='yes') and ($DateTwoTodaysdate=='yes') )
		{

			 $result = mysql_query("select * from jestore_items where quantity > 0   ORDER BY date DESC ",$this->conn);
		     $result2 = mysql_query("select * from jestore_items where quantity > 0  ORDER BY date DESC ",$this->conn);
	
			 
			 
		}
		elseif(($wheredata1=='allcategories') and ($wheredata2=='allitems') and ($DateOneTodaysdate=='no') and ($DateTwoTodaysdate=='no'))
		{
		   $result = mysql_query("select * from jestore_items  where  date between \"$date1\" and \"$date2\"   ORDER BY date DESC ",$this->conn);
		   $result2 = mysql_query("select * from jestore_items  where  date between \"$date1\" and \"$date2\"  ORDER BY date DESC ",$this->conn);
	
		}

		elseif(($wheredata1=='allcategories') and ($wheredata2=='allitems') and ($DateOneTodaysdate=='no') and ($DateTwoTodaysdate=='yes'))
		{
           

	
	       $result = mysql_query("select * from jestore_items  where  date between \"$date1\" and \"$date2\"  ORDER BY date DESC ",$this->conn);
		   $result2 = mysql_query("select * from jestore_items where  date between \"$date1\" and \"$date2\"   ORDER BY date DESC ",$this->conn);
	
		   
			
		}
		elseif(($wheredata1=='allcategories') and ($wheredata2=='allitems') and ($DateOneTodaysdate=='yes') and ($DateTwoTodaysdate=='no'))
		{
           

	       $result = mysql_query("select * from jestore_items  where  date <= \"$date2\"   ORDER BY date DESC ",$this->conn);
		   $result2 = mysql_query("select * from jestore_items where  date <= \"$date2\"   ORDER BY date DESC ",$this->conn);
	

	
			
		}
		
		elseif(($wheredata1!='allcategories') and ($wheredata2=='allitems') and ($DateOneTodaysdate=='yes') and ($DateTwoTodaysdate=='yes') )
		{
         
			
			 $result = mysql_query("select * from jestore_items  where quantity > 0   and category_id = \"$wheredata1\"  ORDER BY date DESC ",$this->conn);
		     $result2 = mysql_query("select * from jestore_items  where quantity > 0   and category_id = \"$wheredata1\" ORDER BY date DESC ",$this->conn);
	
			
			
			
		}
		elseif(($wheredata1!='allcategories') and ($wheredata2=='allitems') and ($DateOneTodaysdate=='yes') and ($DateTwoTodaysdate=='no') )
		{
         
			
			 $result = mysql_query("select * from jestore_items  where date <= \"$date2\"   and category_id = \"$wheredata1\"  ORDER BY date DESC ",$this->conn);
		     $result2 = mysql_query("select * from jestore_items  where date <= \"$date2\"    and category_id = \"$wheredata1\" ORDER BY date DESC ",$this->conn);
	
			
			
			
		}
		elseif(($wheredata1!='allcategories') and ($wheredata2=='allitems') and ($DateOneTodaysdate=='no') and ($DateTwoTodaysdate=='yes') )
		{
         
			
			 $result = mysql_query("select * from jestore_items  where date between \"$date1\" and \"$date2\"   and category_id = \"$wheredata1\"  ORDER BY date DESC ",$this->conn);
		     $result2 = mysql_query("select * from jestore_items  where date between \"$date1\" and \"$date2\"    and category_id = \"$wheredata1\" ORDER BY date DESC ",$this->conn);
	
			
			
			
		}
		elseif(($wheredata1!='allcategories') and ($wheredata2=='allitems') and ($DateOneTodaysdate=='no') and ($DateTwoTodaysdate=='no') )
		{
         
			
			 $result = mysql_query("select * from jestore_items  where date between \"$date1\" and \"$date2\"   and category_id = \"$wheredata1\"  ORDER BY date DESC ",$this->conn);
		     $result2 = mysql_query("select * from jestore_items  where date between \"$date1\" and \"$date2\"    and category_id = \"$wheredata1\" ORDER BY date DESC ",$this->conn);
	
			
			
			
		}
		elseif(($wheredata1!='allcategories') and ($wheredata2!='allitems') and ($DateOneTodaysdate=='yes') and ($DateTwoTodaysdate=='yes') )
		{
          	
			$result = mysql_query("select * from jestore_items  where quantity > 0 and category_id = \"$wheredata1\"  and article_id = \"$wheredata2\"  ORDER BY date DESC ",$this->conn);
			$result2 = mysql_query("select * from jestore_items  where quantity > 0 and category_id = \"$wheredata1\" and article_id = \"$wheredata2\"  ORDER BY date DESC ",$this->conn);
			
			
		}
		elseif(($wheredata1!='allcategories') and ($wheredata2!='allitems') and ($DateOneTodaysdate=='no') and ($DateTwoTodaysdate=='no') )
		{
		
			
			$result = mysql_query("select * from jestore_items  where  category_id = \"$wheredata1\"  and article_id = \"$wheredata2\" and date between \"$date1\" and \"$date2\"  ORDER BY date DESC ",$this->conn);
			$result2 = mysql_query("select * from jestore_items  where  category_id = \"$wheredata1\" and article_id = \"$wheredata2\"  and date between \"$date1\" and \"$date2\" ORDER BY date DESC ",$this->conn);
			
		
		}
		elseif(($wheredata1!='allcategories') and ($wheredata2!='allitems') and ($DateOneTodaysdate=='yes') and ($DateTwoTodaysdate=='no') )
		{
		
		
			
			$result = mysql_query("select * from jestore_items  where  category_id = \"$wheredata1\"  and article_id = \"$wheredata2\"  and date <= \"$date2\"  ORDER BY date DESC ",$this->conn);
			$result2 = mysql_query("select * from jestore_items  where  category_id = \"$wheredata1\" and article_id = \"$wheredata2\"  and date <=  \"$date2\" ORDER BY date DESC ",$this->conn);
		
		}
		elseif(($wheredata1!='allcategories') and ($wheredata2!='allitems') and ($DateOneTodaysdate=='no') and ($DateTwoTodaysdate=='yes') )
		{
		
		
			
			$result = mysql_query("select * from jestore_items  where  category_id = \"$wheredata1\"  and article_id = \"$wheredata2\"  and date between \"$date1\" and \"$date2\"  ORDER BY date DESC ",$this->conn);
			$result2 = mysql_query("select * from jestore_items  where  category_id = \"$wheredata1\" and article_id = \"$wheredata2\"  and date between \"$date1\" and \"$date2\" ORDER BY date DESC ",$this->conn);
			
			
			
		
		
		}
		else
		{
			
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
		   
			   $salerec_found = 'N';
			   $zeroqty='N';
			   $skiprec = 'N';
			   $salequantity = 0;
			   $buyprice = 0;

			   $itemupc = $row['item_number'];
			   
				if  ( ($row['quantity']) <= 0 )
				 {
				  $zeroqty='Y';
				  
				 }else{
				   $zeroqty='N';
				  
				 }
				  
				  
				  
				  $checksale= "select b.quantity_purchased from jestore_sales a , jestore_sales_items b where a.date >= \"$date2\" and b.upc = trim(\"$itemupc\") and a.id = b.sale_id and b.refundtype='' and b.saletype<>'S' ORDER BY a.date DESC ";
			       if(mysql_num_rows(mysql_query($checksale,$this->conn))){
         

					 $salerec_found = 'Y'; 
		             $sale_result=mysql_query($checksale,$this->conn);			 
		             $sale_row = mysql_fetch_assoc($sale_result);
			         $salequantity = $sale_row['quantity_purchased']; 
					 $zeroqty='N';
					 $skiprec = 'N';
					 
			        }else{
					    
					   $salerec_found = 'N';
					   
					}
				    
				  
				  if ($salerec_found == 'N' and $zeroqty == 'Y')
				  {
				    $skiprec = 'Y'; 
					$salerec_found = 'N';
			        $zeroqty='N';

				  }
				  
		 
		
			if($rowCounter%2==0)
			{
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			}
			else
			{
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter++;
			
	
			
			if ($skiprec != 'Y') { 
			
			for($k=0;$k<count($tablefields);$k++)
			{
				$field=$tablefields[$k];
				
				if($field=='sale_details')
				{
					$temp_customer_id=$row['customer_id'];
					$temp_date=$row['date'];
					$temp_sale_id=$row['id'];
					
              }else if ($field=='itemprofit') {

				   $data=$row['item_unit_price'] - $row['srvcost'];
				}
				else
				{
					if($field=='brand_id' or $field=='category_id' or $field=='supplier_id')
					{
						$field_data=$this->idToField("$tableprefix".'items',"$field",$row['item_id']);
						$data=$this->formatData($field,$field_data,$tableprefix);
					}
					else
					{
						$data=$this->formatData($field,$row[$field],$tableprefix);
					
					}
				}	
				
				if($field=='quantity')
				{
			
				 $data= $row['quantity'] + $salequantity;
				 
				 $accum_qty_purhcased2+=$row['quantity'] + $salequantity;;
				 
				}
				
				
				if($field=='buy_price')
				{
			
				 $data= $row['buy_price'] ;
				 
				 $accum_buyprice+=$row['buy_price'];
				 
				}
				
				
				       echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			
			          
				  
				  
			}
			
			$salerec_found = 'N';
			$zeroqty = 'N';
			$salequantity = 0; 
			 $skiprec = 'N';
			} 
			
			
		
				
		}	
				echo '</table>'."\n";	
				
		
		        $sub_total=0;
				$total_cost=0;
				$items_purchased=0;
				$TotalProfit=0;
				
				while($row2=mysql_fetch_assoc($result2))
				{

				
					$accum_qty_purhcased+=$row2['quantity'];
					$total_buycost+=$row2['buy_price'];
	
				}
				
				
				$accum_qty_purhcased= $accum_qty_purhcased2; 
				$total_buycost = $accum_buyprice;            
				
				
				$row_counter++;
				
				$total_buycost=number_format($total_buycost,2,'.', '');
				$sub_total=number_format($sub_total,2,'.', '');
				$total_cost=number_format($total_cost,2,'.', '');
				$TotalProfit=number_format($TotalProfit,2,'.', '');
				
		
				if ($usertype=="Admin"){
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
				echo "<tr><td>Total quantity: <b>$accum_qty_purhcased</b></td></tr>
			 	<tr><td>Total Items Cost: <b>$this->currency_symbol$total_buycost</b></td></tr>
			 	
				 </table>";
		}else{
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
				echo "<tr><td>Total Items Sold: <b>$accum_qty_purhcased</b></td></tr>
			 	<tr><td>Total Items Cost(w/o Tax): <b>$this->currency_symbol$total_buycost</b></td></tr>
			 	

				 </table>";
		}
		
	}
	function displaySaleManagerTable($tableprefix,$where1,$where2)
	{
		$tablewidth='99%'; 
		$sales_table="$tableprefix"."sales";
		$sales_items_table="$tableprefix"."sales_items";
		

		if(isset($_GET['cursaleid']))
		{
		  $where1=$_GET['cursaleid'];
		  $where2=$where1; 
		}
		
		if($where1!='' and $where2!='')
		{

			$sale_query="SELECT * FROM $sales_table WHERE id between \"$where1\" and \"$where2\" ORDER BY id DESC"; 
			$sale_result=mysql_query($sale_query,$this->conn);
			
			
		}
		else
		{
			$sale_query="SELECT * FROM $sales_table ORDER BY id DESC LIMIT 0,10"; 
			$sale_result=mysql_query($sale_query,$this->conn);
			
		}
		
			$sales_tableheaders=array("{$this->lang->date}","{$this->lang->customerName}","{$this->lang->itemsPurchased}","{$this->lang->paidWith}","{$this->lang->soldBy}","{$this->lang->saleSubTotal}","{$this->lang->saleTotalCost}","{$this->lang->saleComment}");
			$sales_tablefields=array('date','customer_id','items_purchased','paid_with','sold_by','sale_sub_total','sale_total_cost','comment');
		
		    $sales_items_tableheaders=array("{$this->lang->itemName}","UPC","{$this->lang->brand}","{$this->lang->category}","{$this->lang->supplier}","{$this->lang->quantityPurchased}","{$this->lang->unitPrice}","{$this->lang->tax}","{$this->lang->itemTotalCost}","Refund Type","Refund Unit Price","Refund Tax","Refund Total","Refund Comment","Refund Date","Process Refund","{$this->lang->updateItem}","{$this->lang->deleteItem}");
			$sales_items_tablefields=array('item_id','upc','brand_id','category_id','supplier_id','quantity_purchased','item_unit_price','item_total_tax','item_total_cost','refundtype','refundunitprice','refundtax','refundtotal','refundcomment','refunddate');
	

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
						$field_data=$this->idToField("$tableprefix".'items',"$field",$newrow['item_id']);
						$data=$this->formatData($field,$field_data,$tableprefix);
					}
					else
					{
						$data=$this->formatData($field,$newrow[$field],$tableprefix);
					}
					echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
				}
				
				if(isset($_SESSION['items_in_return']))
					{
						$curkvalue=count($_SESSION['items_in_return']);
					}else{
						$curkvalue = 0;
					}
					
					echo "<td align='center'>\n<a href=\"../returns/return_ui.php?sale_id=$newrow[sale_id]&upc=$newrow[upc]&item_id=$newrow[item_id]&row_id=$newrow[id]&curkvalue=$curkvalue&unit_price=$newrow[item_unit_price]&tax=$newrow[item_total_tax]&total_cost=$newrow[item_total_cost]&quantity=$newrow[quantity_purchased]\"><font color='$this->rowcolor_link'>Refund</font></a></td>
			  <td align='center'>\n<a href=\"update_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			  <td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_items_table {$this->lang->table}?','delete_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>\n</tr>\n\n";


			
			echo '</tr>'."\n\n";
			}
			echo '</table><br></table><br>';
		}
			echo "</table></td></tr></table></center>";
	}
		function displaySaleManagerTableJex($tableprefix,$where1,$where2)
	{
	
	
		$tablewidth='99%'; 
		$sales_table="$tableprefix"."sales";
		$sales_items_table="$tableprefix"."sales_items";

		
		if($where1!='' and $where2!='')
		{
			$sale_query=$where2; 
			$sale_result=mysql_query($sale_query,$this->conn);

	
			
		}
		else
		{
			$sale_query="SELECT * FROM $sales_table ORDER BY id DESC LIMIT 0,10"; 
			$sale_result=mysql_query($sale_query,$this->conn);
			
		}
		
			$sales_tableheaders=array("{$this->lang->date}","{$this->lang->customerName}","{$this->lang->itemsPurchased}","{$this->lang->paidWith}","{$this->lang->soldBy}","{$this->lang->saleSubTotal}","{$this->lang->saleTotalCost}","{$this->lang->saleComment}");
			$sales_tablefields=array('date','customer_id','items_purchased','paid_with','sold_by','sale_sub_total','sale_total_cost','comment');
		

		    $sales_items_tableheaders=array("{$this->lang->itemName}","UPC","{$this->lang->brand}","{$this->lang->category}","{$this->lang->supplier}","SaleType","SrvName","srvcost","{$this->lang->quantityPurchased}","{$this->lang->unitPrice}","{$this->lang->tax}","{$this->lang->itemTotalCost}","Refund Type","Refund Unit Price","Refund Tax","Refund Total","Refund Comment","Refund Date","Process Refund","{$this->lang->updateItem}","{$this->lang->deleteItem}");
			$sales_items_tablefields=array('item_id','upc','brand_id','category_id','supplier_id','saletype','srvname','srvcost','quantity_purchased','item_unit_price','item_total_tax','item_total_cost','refundtype','refundunitprice','refundtax','refundtotal','refundcomment','refunddate');
	
			
		

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
						$field_data=$this->idToField("$tableprefix".'items',"$field",$newrow['item_id']);
						$data=$this->formatData($field,$field_data,$tableprefix);
					}
					else
					{
						$data=$this->formatData($field,$newrow[$field],$tableprefix);
					}
					echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
				}
				
				if(isset($_SESSION['items_in_return']))
					{
						$curkvalue=count($_SESSION['items_in_return']);
					}else{
						$curkvalue = 0;
					}
					
				echo "<td align='center'>\n<a href=\"../returns/return_ui.php?sale_id=$newrow[sale_id]&upc=$newrow[upc]&item_id=$newrow[item_id]&row_id=$newrow[id]&curkvalue=$curkvalue&unit_price=$newrow[item_unit_price]&itemtaxpercent=$newrow[item_tax_percent]&tax=$newrow[item_total_tax]&total_cost=$newrow[item_total_cost]&quantity=$newrow[quantity_purchased]&saletype=$newrow[saletype]&srvname=$newrow[srvname]\"><font color='$this->rowcolor_link'>Refund</font></a></td>
			  <td align='center'>\n<a href=\"update_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
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
		$items_table="$tableprefix".'items';
		$brands_table="$tableprefix".'brands';
		$categories_table="$tableprefix".'categories';
		$suppliers_table="$tableprefix".'suppliers';
		$customer_table="$tableprefix".'customers';
		$users_table="$tableprefix".'users';
    $itemTransaction_table="$tableprefix"."item_transactions"; 



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
		elseif($total_type=='items')
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
			

			$query = "select DISTINCT a.date from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype='' and b.saletype<>'S' and a.date between \"$date1\" and \"$date2\" ORDER by date ASC";
			
			
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

				
				$result2=mysql_query("select a.id,a.date,a.customer_id,a.sale_sub_total ,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment,b.upc,b.item_id,b.saletype,b.quantity_purchased,b.item_buy_price,b.srvcost, b.item_unit_price,b.item_tax_percent,b.item_total_tax,b.item_total_cost from jestore_sales a , jestore_sales_items b where a.id = b.sale_id and b.refundtype=''  and a.date=\"$distinct_date\" ",$this->conn);
				
				
				
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$distinct_date</font>\n</td>";
				
				while($row2=mysql_fetch_assoc($result2))
				{
					
					$saletype=$row2['saletype']; 


					$amount_sold+=$row2['item_unit_price'] * $row2['quantity_purchased']; 

					$total_amount_sold+=$row2['item_unit_price'] * $row2['quantity_purchased']; 
					
					
					$itemtax+=$row2['item_total_tax'];
					$Totaltax+=$row2['item_total_tax'];
					
					
					
					
					if ($saletype=='S') {
					
					$profit+=(($row2['item_unit_price'] * $row2['quantity_purchased']) -  $row2['srvcost']); 
					}else{
						$profit+=(($row2['item_unit_price'] * $row2['quantity_purchased']) - $row2['item_buy_price']); 
				
					}	
					
					
					
					
					
					
					if ($saletype=='S') {
					$total_profit+=(($row2['item_unit_price'] * $row2['quantity_purchased']) -  $row2['srvcost']); 
					
					}else{
						$total_profit+=(($row2['item_unit_price'] * $row2['quantity_purchased']) - $row2['item_buy_price']); 
					
					}	
					
					
					

					
					
					if ($saletype=='S') {
					$buycost+= $row2['srvcost'] * $row2['quantity_purchased'];  
					$total_buycost+=$row2['srvcost'] * $row2['quantity_purchased']; 
					
					}else{
					$buycost+=$row2['item_buy_price'] * $row2['quantity_purchased'];  
					$total_buycost+=$row2['item_buy_price'] * $row2['quantity_purchased']; 
					
					}	
					
					
					
					
					
					
					$totalpricewithtax+=$row2['item_total_cost'];
					$accum_total_cost+=$row2['item_total_cost'];
					
				}
				
				$buycost=number_format($buycost,2,'.', '');
				$amount_sold=number_format($amount_sold,2,'.', '');
				$itemtax=number_format($itemtax,2,'.', '');
				$totalpricewithtax=number_format($totalpricewithtax,2,'.', '');
				$profit=number_format($profit,2,'.', '');
				
                
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$buycost</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$amount_sold</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$itemtax</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$totalpricewithtax</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$profit</font>\n</td>";


				echo "</tr>";
				
				$buycost =0;
				$amount_sold =0;
				$itemtax =0;
				$totalpricewithtax=0;
				$profit =0;
			}
			
			echo '</table>';
			
			$total_buycost=number_format($total_buycost,2,'.', '');
			$total_amount_sold=number_format($total_amount_sold,2,'.', '');
			$accum_total_cost=number_format($accum_total_cost,2,'.', '');
			$total_profit=number_format($total_profit,2,'.', '');
				
				
			 echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "
			    <tr><td>Total Items Cost: <b>$this->currency_symbol$total_buycost</b></td></tr>
			    <tr><td>Item Price(w/o Tax): <b>$this->currency_symbol$total_amount_sold</b></td></tr>
				<tr><td>Total Items Tax: <b>$this->currency_symbol$Totaltax</b></td></tr>
				<tr><td>Total Items Price(w/ Tax): <b>$this->currency_symbol$accum_total_cost</b></td></tr>
			 	<tr><td>{$this->lang->totalProfit}: <b>$this->currency_symbol$total_profit</b></td></tr>
				 </table>"; 



		}
		
				elseif($total_type=='costreport')
		{
		

			echo "<center><b>{$this->lang->costtotalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
			
			$query="SELECT DISTINCT date FROM $itemTransaction_table WHERE date between \"$date1\" and \"$date2\" ORDER by date ASC";
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
				$result2=mysql_query("SELECT * FROM $itemTransaction_table WHERE date=\"$distinct_date\" and addtoinventory_scrapgold = 'N' and supplier_id <> '1' ",$this->conn);

				echo "\n<tr bgcolor=$this->rowcolor1>\n";
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$distinct_date</font>\n</td>";
				
				while($row2=mysql_fetch_assoc($result2))
				{
					$amount_sold+=$row2['buy_price'];
					$total_amount_sold+=$row2['buy_price'];
					$profit+=$this->getProfit($row2['id'],$tableprefix);
					$total_profit+=$this->getProfit($row2['id'],$tableprefix);
					
				}
				
				$amount_sold=number_format($amount_sold,2,'.', '');
				$profit=number_format($profit,2,'.', '');

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$amount_sold</font>\n</td>";
			


				echo "</tr>";
			}
			
			echo '</table>';
			
			
			$total_amount_sold=number_format($total_amount_sold,2,'.', '');
			$total_profit=number_format($total_profit,2,'.', '');
				
			
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "<tr><td>{$this->lang->totalAmountCost}: <b>$this->currency_symbol$total_amount_sold</b></td></tr>
			 	
				 </table>";


		}
		
			
				elseif($total_type=='costreport')
		{
		

			echo "<center><b>{$this->lang->costtotalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
			
			$query="SELECT DISTINCT date FROM $itemTransaction_table WHERE date between \"$date1\" and \"$date2\" ORDER by date ASC";
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
				$result2=mysql_query("SELECT * FROM $itemTransaction_table WHERE date=\"$distinct_date\" and addtoinventory_scrapgold = 'N' and supplier_id <> '1' ",$this->conn);

				echo "\n<tr bgcolor=$this->rowcolor1>\n";
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$distinct_date</font>\n</td>";
				
				while($row2=mysql_fetch_assoc($result2))
				{
					$amount_sold+=$row2['buy_price'];
					$total_amount_sold+=$row2['buy_price'];
					$profit+=$this->getProfit($row2['id'],$tableprefix);
					$total_profit+=$this->getProfit($row2['id'],$tableprefix);
					
				}
				
				$amount_sold=number_format($amount_sold,2,'.', '');
				$profit=number_format($profit,2,'.', '');

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$amount_sold</font>\n</td>";
				


				echo "</tr>";
			}
			
			echo '</table>';
			
			
			$total_amount_sold=number_format($total_amount_sold,2,'.', '');
			$total_profit=number_format($total_profit,2,'.', '');
				
			
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "<tr><td>{$this->lang->totalAmountCost}: <b>$this->currency_symbol$total_amount_sold</b></td></tr>
			 	
				 </table>";


		}
		
		
				elseif($total_type=='articlecostreport')
		{
		

			echo "<center><b>{$this->lang->costtotalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			$articlename=$this->idToField("$tableprefix".'articles','article',"$where2");
			echo "<center><b><font color=white> Cost for Article: $articlename (Only $articlename)  </font></b></center>";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			
			echo '</tr>'."\n\n";
			
			$query="SELECT DISTINCT date FROM $itemTransaction_table WHERE date between \"$date1\" and \"$date2\" and article_id=\"$where2\"ORDER by date ASC";
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
				$result2=mysql_query("SELECT * FROM $itemTransaction_table WHERE date=\"$distinct_date\" and article_id =\"$where2\" and addtoinventory_scrapgold = 'N' ",$this->conn);

				echo "\n<tr bgcolor=$this->rowcolor1>\n";
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$distinct_date</font>\n</td>";
				
				while($row2=mysql_fetch_assoc($result2))
				{
					$amount_sold+=$row2['buy_price'];
					$total_amount_sold+=$row2['buy_price'];
					$profit+=$this->getProfit($row2['id'],$tableprefix);
					$total_profit+=$this->getProfit($row2['id'],$tableprefix);
					
				}
				
				$amount_sold=number_format($amount_sold,2,'.', '');
				$profit=number_format($profit,2,'.', '');

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$amount_sold</font>\n</td>";
	


				echo "</tr>";
			}
			
			echo '</table>';
			
			
			$total_amount_sold=number_format($total_amount_sold,2,'.', '');
			$total_profit=number_format($total_profit,2,'.', '');
				
			
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "<tr><td>{$this->lang->totalAmountCost}: <b>$this->currency_symbol$total_amount_sold</b></td></tr>
			 	
				 </table>";


		}
		
		
				elseif($total_type=='categorycostreport')
		{
		

			echo "<center><b>{$this->lang->costtotalsShownBetween} $date1 {$this->lang->and} $date2</b></center>"; 
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";
			
			echo "<tr bgcolor=$this->header_rowcolor>\n\n";
			
			$categoryname=$this->idToField("$tableprefix".'categories','category',"$where2");
			echo "<center><b><font color=white> Cost for Category: $categoryname (Only $categoryname)</font></b></center>";
			
			for($k=0;$k< count($tableheaders);$k++)
			{
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}
			

				
			echo '</tr>'."\n\n";
			
			
			$query="SELECT DISTINCT date FROM $itemTransaction_table WHERE date between \"$date1\" and \"$date2\" and category_id=\"$where2\"ORDER by date ASC";
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
				$result2=mysql_query("SELECT * FROM $itemTransaction_table WHERE date=\"$distinct_date\" and category_id =\"$where2\" and addtoinventory_scrapgold = 'N' ",$this->conn);

				echo "\n<tr bgcolor=$this->rowcolor1>\n";
				
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$distinct_date</font>\n</td>";
				
				while($row2=mysql_fetch_assoc($result2))
				{
					$amount_sold+=$row2['buy_price'];
					$total_amount_sold+=$row2['buy_price'];
					$profit+=$this->getProfit($row2['id'],$tableprefix);
					$total_profit+=$this->getProfit($row2['id'],$tableprefix);
					
				}
				
				$amount_sold=number_format($amount_sold,2,'.', '');
				$profit=number_format($profit,2,'.', '');

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$amount_sold</font>\n</td>";



				echo "</tr>";
			}
			
			echo '</table>';
			
			
			$total_amount_sold=number_format($total_amount_sold,2,'.', '');
			$total_profit=number_format($total_profit,2,'.', '');
			
			
				echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			 echo "<tr><td>{$this->lang->totalAmountCost}: <b>$this->currency_symbol$total_amount_sold</b></td></tr>
			 	
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
		elseif($field=='tax_percent' or $field=='percent_off')
		{
			return "$data".'%';
		}
		elseif($field=='date') 
		{
		
				$tyear = substr("$data",0,4);
				$tmonth = substr("$data",5,2);
				$tday = substr("$data",8,2);
				$data=$tmonth.'-'.$tday.'-'.$tyear;
			return "$data";
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
			return $this->idToField("$tableprefix".'items','item_name',$data);
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