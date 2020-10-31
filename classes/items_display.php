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
	

	function displayManageTable($tableprefix,$tablename,$tableheaders,$tablefields,$wherefield,$wheredata,$orderby,$wheredata2,$searchfor,$searchby,$frompanel)
	{

	    $updatelinkfrompanel="itempanel";
		
		$userid=$_SESSION['session_user_id'];
		$usertype=$this->idToField("$tableprefix".'users','type',"$userid");
   
		
		
		
		
		$searchfor=$wheredata;
	    $searchby=$wherefield;
	    
		
		
		
		
		
		
		
		if($tablename=='brands' or $tablename=='categories')
		{
			$tablewidth='35%';
		}
		else
		{
			$tablewidth='140%';
		}
		
		$table="$tableprefix"."$tablename";
		echo "\n".'<center>';
				
		
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
		$start_from = ($page-1) * 25;
		
		
		if($wherefield=='quantity' and $wheredata=='outofstock')
		{
		   
			$result = mysql_query("SELECT * FROM $table WHERE quantity < 1 AND removedbypd = '' AND removedbyjex = '' ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE quantity < 1 AND removedbypd = '' AND removedbyjex = '' ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		elseif($wherefield=='quantity' and $wheredata=='reorder')
		{
			$result = mysql_query("SELECT * FROM $table WHERE quantity <= reorder_level AND removedbypd = '' AND removedbyjex = '' ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE quantity <= reorder_level AND removedbypd = '' AND removedbyjex = '' ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
			
			elseif($wherefield=='unit_price' and $wheredata=='zeroprice')
		{
			$result = mysql_query("SELECT * FROM $table WHERE unit_price < 0.01 or buy_price < 0.01 AND removedbypd = '' AND removedbyjex = '' ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE unit_price < 0.01 or buy_price < 0.01 AND removedbypd = '' AND removedbyjex = '' ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		elseif($wherefield=='removedbypd' and $wheredata=='removedbypd')
		{
			$updatelinkfrompanel="pdpanel";
		     $removedbypdjex='yes';
			$result = mysql_query("SELECT * FROM $table WHERE removedbypd = 'PD' ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE removedbypd = 'PD' ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		elseif($wherefield=='removedbyjex' and $wheredata=='removedbyjex')
		{
			$updatelinkfrompanel="jexpanel";
			$removedbypdjex='yes';
			$result = mysql_query("SELECT * FROM $table WHERE removedbyjex = 'JEX' ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE removedbyjex = 'JEX' ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($result2);
			}

		elseif(($wherefield=='ALL') and ($frompanel==''))
		{
		    
			$wheredata=trim($wheredata);
			
			$articletable = "$cfg_tableprefix".'articles';
			$article_query="SELECT article_id FROM $articletable where article = '$wheredata' ";
			$article_result=mysql_query($article_query,$dbf->conn);
			$article_row = mysql_fetch_assoc($article_result);
			$searchID=$article_row ['article_id'];
		
			if ($searchID <> ''){
			$result = mysql_query("SELECT * FROM $table WHERE  quantity > 0 and item_name like \"%$wheredata%\" or description like \"%$wheredata%\" or itemmodel like \"%$wheredata%\" or serialnumber = \"$wheredata\" or item_number = \"$wheredata\" or article_id = \"$searchID\"  ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE quantity > 0 and  item_name like \"%$wheredata%\" or description like \"%$wheredata%\" or itemmodel like \"%$wheredata%\" or serialnumber = \"$wheredata\" or item_number = \"$wheredata\" or article_id = \"$searchID\"  ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
			}else{
			 $result = mysql_query("SELECT * FROM $table WHERE quantity > 0 and  item_name like \"%$wheredata%\" or description like \"%$wheredata%\" or itemmodel like \"%$wheredata%\" or serialnumber = \"$wheredata\" or item_number = \"$wheredata\"  ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			 $result2 = mysql_query("SELECT * FROM $table WHERE quantity > 0 and  item_name like \"%$wheredata%\" or description like \"%$wheredata%\" or itemmodel like \"%$wheredata%\" or serialnumber = \"$wheredata\" or item_number = \"$wheredata\"  ORDER BY $orderby",$this->conn);
			 $num_rows = mysql_num_rows($result2);
			}
		}
		
		elseif(($wherefield=='catogory') and ($frompanel==''))
		{
	
			$result = mysql_query("SELECT * FROM $table WHERE  category_id like \"%$wheredata%\" and article_id like \"%$wheredata2%\"  ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE  category_id like \"%$wheredata%\" and article_id like \"%$wheredata2%\"  ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		elseif(($wherefield=='catogory') and ($frompanel=='bycategory'))
		{

		$searchfor=trim($searchfor);
			$articletable = "$cfg_tableprefix".'articles';
			$article_query="SELECT article_id FROM $articletable where article like = '%$searchfor%' ";
			$article_result=mysql_query($article_query,$dbf->conn);
			$article_row = mysql_fetch_assoc($article_result);
			$searchID=$article_row ['article_id'];
			
			if (($searchfor=='') and ($searchby=='ALL'))
			{
			    $andsearfor='';
			
			}elseif (($searchfor!='') and ($searchby=='ALL'))
			{
				$andsearchfor = " and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\")";

			}elseif (($searchfor!='') and ($searchby=='ALL'))
			{
			$andsearchfor = " and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\")";
			
			}else{
			  
			    $searchfor=trim($searchfor);
				$andsearchfor = " and $searchby like \"%$searchfor%\" ";

			}
			$result = mysql_query("SELECT * FROM $table WHERE  category_id like \"%$wheredata%\" and article_id like \"%$wheredata2%\"  $andsearchfor ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE  category_id like \"%$wheredata%\" and article_id like \"%$wheredata2%\"  $andsearchfor ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);

			}
		
		elseif($wherefield!='' and $wheredata!='')
		{
			$wheredata=trim($wheredata);
			$usingsearch='yes';
			$result = mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" and quantity > 0 ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" and quantity > 0 ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);


		}
		elseif($this->getNumRows($table) >25)
		{
			$result = mysql_query("SELECT * FROM $table WHERE quantity > 0  ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
			$resultnumrows = mysql_query("SELECT * FROM $table WHERE quantity > 0 ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);
			echo "<font color=GREEN>{$this->lang->moreThan} $table".'\'s'." {$this->lang->firstDisplayed}";

		   
		   	$resulttotalrows = mysql_query("SELECT * FROM $table WHERE quantity > 0 ORDER BY $orderby DESC",$this->conn);
			$totalnumrows = mysql_num_rows($resulttotalrows);
			$totalnumrows= " Total rows: " . $totalnumrows;
		
		
		}
		else
		{
			$result = mysql_query("SELECT * FROM $table ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result);
		}
		echo '<hr>';
		if(@mysql_num_rows($result) ==0)
		{
			echo "<div align='center'>{$this->lang->noDataInTable} <b>$table</b> {$this->lang->table}.</div>";
			exit();
		}
		
		
		if ($frompanel=="bycategory"){ 
			echo "<center><a href=manage_items_by_categories.php?catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel>Reload above form with Search Values Used</a></center>";
		}
		
		echo "<center><h4><font color='$this->list_of_color'>{$this->lang->listOf} $tablename Total Rows Returned $num_rows $totalnumrows</font></h4></center>";
		echo "<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">


		<tr bgcolor=$this->header_rowcolor>\n\n";
		

		
		
		$total_records = $num_rows; 
		$total_pages = ceil($total_records / 25); 


	$urllinkcolor="#064A08";
	$pagenumcolor="#0D11F2";
	
	if ($total_pages > 1) {
	
	
	if (isset($_GET["totalpages"]))
	{
	if ($nextpage <= $total_pages){ 
	   $nextpage = $page + 1; 
       $backpage = $page - 1;

        if ($wheredata=='outofstock'){
		   if ($page=="1") { 
				
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		 }else if ($wheredata=='reorder'){
		 	if ($page=="1") { 
				
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
			}else if ($wheredata=='removedbypd'){
		 	if ($page=="1") { 
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbypd=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbypd=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbypd=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbypd=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
			}else if ($wheredata=='removedbyjex'){
		 	if ($page=="1") { 
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbyjex=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbyjex=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbyjex=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbyjex=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		 }else if ($wheredata=='zeroprice'){
		 	if ($page=="1") { 
				
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
	
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
			
			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
	
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		}else if ($usingsearch=="yes"){ 
		 	if ($page=="1") { 
				
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&search_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&search_by=$wherefield&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&search_by=$wherefield&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&search_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		}else if (($wherefield=='catogory') and ($frompanel!="bycategory")){
				if ($page=="1") { 
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";


			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
			}else if ($frompanel=="bycategory"){ 
				if ($page=="1") { 
					
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

					echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
					echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a> ";
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
					echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a> ";
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

					echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		}else{

		 	if ($page=="1") { 

				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&search=$searchfor&search_by=$searchby&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&search=$searchfor&search_by=$searchby&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&search=$searchfor&search_by=$searchby&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&search=$searchfor&search_by=$searchby&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		 }
	}
	
	}else{
	
	$nextpage = $page+1;

	    if ($wheredata=='outofstock'){

		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	      echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	     }else if ($wheredata=='reorder'){

		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	      echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	     
		 }else if ($wheredata=='zeroprice'){

		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	      echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		 }else if ($wheredata=='removedbypd'){
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
	      echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbypd=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		  }else if ($wheredata=='removedbyjex'){
		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
	      echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&removedbyjex=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		  }else if ($usingsearch=="yes"){ 
		
			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&search_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		}else if (($wherefield=='catogory') and ($frompanel!="bycategory")){

			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		}else if ($frompanel=="bycategory"){
			
			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		}else{
	      echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
		  echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&search=$searchfor&search_by=$searchby&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";

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
            
			
			if($myimage !=''){ 
			   if ($cfg_data_outside_storedir == "yes"){
			       $myimage= $cfg_data_supplierIMGpathdir.$myimage;
			 
			  }else{
			       $myimage= 'suppliers/images/'.$myimage;
			  
			  }
			 }else{
                $myimage="../je_images/no_picture.gif";
             }		
			}
             
        if($tablename=='items')
		      {

             
             $ItemRowID=$tablefields[0];
             $ItemID=$row[$ItemRowID];
             
             
			 $Item_result = mysql_query("SELECT article_id,item_image FROM $table WHERE id = $ItemID",$this->conn);
             $Item_row = mysql_fetch_assoc($Item_result);
             $myimage=$Item_row['item_image'];
			 $itemimage=$Item_row['item_image'];
             
			 
			 
		if($myimage !=''){ 
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
            
   
             
		       } 
        

		
		    
        
				
				echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			}
			
			if ($usertype=="Admin"){
			
			if ($cfg_enable_PopUpUpdateform=="yes"){
			echo "<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a></td>
				<td align='center'>\n<a href=\"javascript:popUp('form_$tablename.php?action=update&id=$row[id]&removedbypdjex=$removedbypdjex&updatelinkfrompanel=$updatelinkfrompanel')\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
				<td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $table {$this->lang->table}?','process_form_$tablename.php?action=delete&id=$row[id]&itemimage=$myimage')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>
				<td align='center'>\n<a href=\"create_1barcodePDF_code39.php?&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>\n</tr>\n\n";
			}else{
				echo "<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a></td>
				<td align='center'>\n<a href=\"form_$tablename.php?action=update&id=$row[id]&removedbypdjex=$removedbypdjex&updatelinkfrompanel=$updatelinkfrompanel\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
				<td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $table {$this->lang->table}?','process_form_$tablename.php?action=delete&id=$row[id]&itemimage=$myimage')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>
				<td align='center'>\n<a href=\"create_1barcodePDF_code39.php?&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>\n</tr>\n\n";
			}
		
	}else {
	
		if ($cfg_enable_PopUpUpdateform=="yes"){
		echo "<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a></td>
		<td align='center'>\n<a href=\"javascript:popUp('form_$tablename.php?action=update&id=$row[id]&removedbypdjex=$removedbypdjex&updatelinkfrompanel=$updatelinkfrompanel')\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>				 
		<td align='center'>\n<a href=\"create_1barcodePDF_code39.php?&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>
		\n</tr>\n\n";
		}else{
		echo "<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a></td>
		<td align='center'>\n<a href=\"form_$tablename.php?action=update&id=$row[id]&removedbypdjex=$removedbypdjex&updatelinkfrompanel=$updatelinkfrompanel\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>				 
		<td align='center'>\n<a href=\"create_1barcodePDF_code39.php?&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>
		\n</tr>\n\n";
		}
		
	}	
	
		
		}
			echo '</table>'."\n";
	}
	
	
	function displayManageTableJex($tableprefix,$tablename,$tableheaders,$tablefields,$wherefield,$wheredata,$orderby,$wheredata2,$searchfor,$searchby,$frompanel,$date1,$date2)
	{
		
		
		$userid=$_SESSION['session_user_id'];
		$usertype=$this->idToField("$tableprefix".'users','type',"$userid");
    
		
		
		
		
		
		if($tablename=='brands' or $tablename=='categories')
		{
			$tablewidth='35%';
		}
		else
		{
			$tablewidth='140%';
		}
		
		$table="$tableprefix"."$tablename";
		echo "\n".'<center>';
				
		
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
		$start_from = ($page-1) * 25;
		
		
		if($wherefield=='quantity' and $wheredata=='outofstock')
		{
		   
			$result = mysql_query("SELECT * FROM $table WHERE quantity < 1  ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE quantity < 1 ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		elseif($wherefield=='quantity' and $wheredata=='reorder')
		{
			$result = mysql_query("SELECT * FROM $table WHERE quantity <= reorder_level ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE quantity <= reorder_level ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
			
			elseif($wherefield=='unit_price' and $wheredata=='zeroprice')
		{
			$result = mysql_query("SELECT * FROM $table WHERE unit_price < 0.01 AND quantity > 0 ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE unit_price < 0.01 AND quantity > 0 ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}

		elseif(($wherefield=='ALL') and ($frompanel==''))
		{
			$wheredata=trim($wheredata);
			
			$articletable = "$cfg_tableprefix".'articles';
			$article_query="SELECT article_id FROM $articletable where article like = '%$search%' ";
			$article_result=mysql_query($article_query,$dbf->conn);
			$article_row = mysql_fetch_assoc($article_result);
			$searchID=$article_row ['article_id'];
		
			if ($searchID <> ''){
			$result = mysql_query("SELECT * FROM $table WHERE  item_name like \"%$wheredata%\" or description like \"%$wheredata%\" or itemmodel like \"%$wheredata%\" or serialnumber = \"$wheredata\" or item_number = \"$wheredata\" or article_id = \"$searchID\" and quantity > 0 ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE  item_name like \"%$wheredata%\" or description like \"%$wheredata%\" or itemmodel like \"%$wheredata%\" or serialnumber = \"$wheredata\" or item_number = \"$wheredata\" or article_id = \"$searchID\" and quantity > 0 ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2); 
			}else{
			$result = mysql_query("SELECT * FROM $table WHERE  item_name like \"%$wheredata%\" or description like \"%$wheredata%\" or itemmodel like \"%$wheredata%\" or serialnumber = \"$wheredata\" or item_number = \"$wheredata\"  and quantity > 0 ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE  item_name like \"%$wheredata%\" or description like \"%$wheredata%\" or itemmodel like \"%$wheredata%\" or serialnumber = \"$wheredata\" or item_number = \"$wheredata\" and quantity > 0 ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2); 
			}

		}

		elseif(($wherefield=='catogory') and ($frompanel==''))
		{
				
			$result = mysql_query("SELECT * FROM $table WHERE  category_id like \"%$wheredata%\" and article_id like \"%$wheredata2%\" and quantity > 0  ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE  category_id like \"%$wheredata%\" and article_id like \"%$wheredata2%\" and quantity > 0 ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);
		}
		
		
		elseif(($wherefield=='catogory') and ($frompanel=='bycategory'))
		{

			$searchfor=trim($searchfor);
			$articletable = "$cfg_tableprefix".'articles';
			$article_query="SELECT article_id FROM $articletable where article like = '%$searchfor%' ";
			$article_result=mysql_query($article_query,$dbf->conn);
			$article_row = mysql_fetch_assoc($article_result);
			$searchID=$article_row ['article_id'];
			

			if ($searchby=='ALL')
			{

				if (($date1 != 0) and ($date2 == 0)  and ($searchfor =='') and ($wheredata=='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = "  date = \"$date1\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}
				if (($date1 != 0) and ($date2 != 0)  and ($searchfor=='') and ($wheredata=='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = " date between \"$date1\" and \"$date2\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC ",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}
				if (($date1 != 0) and ($date2 == 0)  and ($searchfor !='') and ($wheredata=='blank') and ($wheredata2 =="blank"))
				{
			         $andsearchfor = " date = \"$date1\"  and quantity > 0  and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\")";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC ",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}
				if (($date1 != 0) and ($date2 != 0)  and ($searchfor !='')and ($wheredata=='blank') and ($wheredata2 =="blank"))
				{
			         $andsearchfor = " date between \"$date1\" and \"$date2\"  and quantity > 0  and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\")";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}

				if (($date1==0) and ($date2==0)  and ($searchfor=='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
				
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\") ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
				
			         $andsearchfor = " category_id = \"$wheredata\" and date = \"$date1\"  and quantity > 0  and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\") ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and date between \"$date1\" and \"$date2\" and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\") ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor=='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and article_id like \"%$wheredata2%\" and date = \"$date1\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1==0) and ($date2==0)  and ($searchfor=='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and article_id like \"%$wheredata2%\"  and quantity > 0 ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1 == 0) and ($date2 == 0)  and ($searchfor !='') and ($wheredata=='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = "quantity > 0  and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\")";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}
				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and article_id like \"%$wheredata2%\" and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\")";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and article_id like \"%$wheredata2%\" and date = \"$date1\" and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\")";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and article_id like \"%$wheredata2%\" and date between \"$date1\" and \"$date2\" and (item_name like \"%$searchfor%\" or description like \"%$searchfor%\" or itemmodel like \"%$searchfor%\" or serialnumber = \"$searchfor\" or item_number = \"$searchfor\")";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
					
					
			}
			if ($searchby=='item_number') 
			{

				$searchby=trim($searchby);
				if (($date1 != 0) and ($date2 == 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date = \"$date1\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}
				if (($date1 != 0) and ($date2 != 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = " category_id = \"$wheredata\" and $searchby = \"$searchfor\"  and quantity > 0  ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
				
			         $andsearchfor = " category_id = \"$wheredata\" and date = \"$date1\" and $searchby = \"$searchfor\"  and quantity > 0  ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"  and quantity > 0  ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
					

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and article_id like \"%$wheredata2%\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and article_id like \"%$wheredata2%\" and date = \"$date1\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and article_id like \"%$wheredata2%\" and date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					 $num_rows = mysql_num_rows($result2);
					 }
					
					
			}
			if ($searchby=='serialnumber') 
			{

				$searchby=trim($searchby);
				if (($date1 != 0) and ($date2 == 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date = \"$date1\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC  LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					 $num_rows = mysql_num_rows($result2);
					}
				if (($date1 != 0) and ($date2 != 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					 $num_rows = mysql_num_rows($result2);
					}

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = " category_id = \"$wheredata\" and $searchby = \"$searchfor\"  and quantity > 0  ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
				
			         $andsearchfor = " category_id = \"$wheredata\" and date = \"$date1\" and $searchby = \"$searchfor\"  and quantity > 0  ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
					
				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and article_id like \"%$wheredata2%\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0  and article_id like \"%$wheredata2%\" and date = \"$date1\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"   and quantity > 0 and article_id like \"%$wheredata2%\" and date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
			}
			if ($searchby=='itemmodel') 
			{

				$searchby=trim($searchby);
				if (($date1 != 0) and ($date2 == 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date = \"$date1\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}
				if (($date1 != 0) and ($date2 != 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = " category_id = \"$wheredata\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
				
			         $andsearchfor = " category_id = \"$wheredata\" and date = \"$date1\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"  and quantity > 0 ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
					

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and article_id like \"%$wheredata2%\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and article_id like \"%$wheredata2%\" and date = \"$date1\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and article_id like \"%$wheredata2%\" and date between \"$date1\" and \"$date2\" and $searchby = \"$searchfor\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
			}
			if ($searchby=='description') 
			{

				$searchby=trim($searchby);
				if (($date1 != 0) and ($date2 == 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date = \"$date1\" and $searchby like \"%$searchfor%\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}
				if (($date1 != 0) and ($date2 != 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date between \"$date1\" and \"$date2\" and $searchby like \"%$searchfor%\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = " category_id = \"$wheredata\" and $searchby like \"%$searchfor%\"  and quantity > 0 ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
				      $andsearchfor = " category_id = \"$wheredata\" and date = \"$date1\" and $searchby like \"%$searchfor%\"  and quantity > 0 ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and date between \"$date1\" and \"$date2\" and $searchby like \"%$searchfor%\"  and quantity > 0 ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
					

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and article_id like \"%$wheredata2%\" and $searchby like \"%$searchfor%\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and article_id like \"%$wheredata2%\" and date = \"$date1\" and $searchby like \"%$searchfor%\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and article_id like \"%$wheredata2%\" and date between \"$date1\" and \"$date2\" and $searchby like \"%$searchfor%\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
			}
			if ($searchby=='article_id') 
			{

				$searchby=trim($searchby);
				if (($date1 != 0) and ($date2 == 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date = \"$date1\"  and quantity > 0 and $searchby like \"%$searchID%\" ";

					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}
				if (($date1 != 0) and ($date2 != 0)  and ($searchfor !=''))
				{
			         $andsearchfor = " date between \"$date1\" and \"$date2\"  and quantity > 0  and $searchby like \"%$searchID%\" ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					}

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
					$andsearchfor = " category_id = \"$wheredata\"  and quantity > 0 and $searchby like \"%$searchID%\" ";
					$result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					$result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
				
			         $andsearchfor = " category_id = \"$wheredata\" and date = \"$date1\"  and quantity > 0 and $searchby like \"%$searchID%\" ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 =="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and date between \"$date1\" and \"$date2\"  and quantity > 0 and $searchby like \"%$searchID%\" ";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
					

				if (($date1==0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and article_id like \"%$wheredata2%\"  and quantity > 0 and $searchby like \"%$searchID%\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2==0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and article_id like \"%$wheredata2%\" and date = \"$date1\"  and quantity > 0  and $searchby like \"%$searchID%\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
				if (($date1!=0) and ($date2!=0)  and ($searchfor!='') and ($wheredata!='blank') and ($wheredata2 !="blank"))
				{
			         $andsearchfor = " category_id = \"$wheredata\" and article_id like \"%$wheredata2%\" and date between \"$date1\" and \"$date2\"  and quantity > 0 and $searchby like \"%$searchID%\"";
					 $result = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
					 $result2 = mysql_query("SELECT * FROM $table WHERE  $andsearchfor ORDER BY $orderby DESC",$this->conn);
					$num_rows = mysql_num_rows($result2);
					 }
			}
					




			}
			
		
		elseif($wherefield!='' and $wheredata!='')
		{
			$wheredata=trim($wheredata);
			$usingsearch='yes';
			$result = mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" and quantity > 0 ORDER BY $orderby LIMIT $start_from,25",$this->conn);
			$result2 = mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" and quantity > 0 ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result2);


		}
		elseif($this->getNumRows($table) >25)
		{
			$result = mysql_query("SELECT * FROM $table WHERE quantity > 0 ORDER BY $orderby DESC LIMIT $start_from,25",$this->conn);
			$resultnumrows = mysql_query("SELECT * FROM $table WHERE quantity > 0 ORDER BY $orderby DESC",$this->conn);
			$num_rows = mysql_num_rows($resultnumrows);
			echo "<font color=GREEN>{$this->lang->moreThan} $table".'\'s'." {$this->lang->firstDisplayed}";

		   
		   	$resulttotalrows = mysql_query("SELECT * FROM $table WHERE quantity > 0 ORDER BY $orderby DESC",$this->conn);
			$totalnumrows = mysql_num_rows($resulttotalrows);
			$totalnumrows= " Total rows: " . $totalnumrows;
		
		
		}
		else
		{
			$result = mysql_query("SELECT * FROM $table ORDER BY $orderby",$this->conn);
			$num_rows = mysql_num_rows($result);
		}
		echo '<hr>';
		if(@mysql_num_rows($result) ==0)
		{
			echo "<div align='center'>{$this->lang->noDataInTable} <b>$table</b> {$this->lang->table}.</div>";
			exit();
		}
		
		
		if ($frompanel=="bycategory"){ 
			echo "<center><a href=manage_items_by_categories.php?catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel>Reload above form with Search Values Used</a></center>";
		}
		
		echo "<center><h4><font color='$this->list_of_color'>{$this->lang->listOf} $tablename Total Rows Returned $num_rows $totalnumrows</font></h4></center>";
		echo "<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">


		<tr bgcolor=$this->header_rowcolor>\n\n";
		
		
		
		$total_records = $num_rows; 
		$total_pages = ceil($total_records / 25); 
			

	$urllinkcolor="#FF9900";
	$pagenumcolor="#99FF66";
	
	if ($total_pages > 1) {
	
	
	if (isset($_GET["totalpages"]))
	{
	if ($nextpage <= $total_pages){ 
	   $nextpage = $page + 1; 
       $backpage = $page - 1;

        if ($wheredata=='outofstock'){
		   if ($page=="1") { 

				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		 }else if ($wheredata=='reorder'){
		 	if ($page=="1") { 

				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		 }else if ($wheredata=='zeroprice'){
		 	if ($page=="1") { 

				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		}else if ($usingsearch=="yes"){ 
		 	if ($page=="1") { 
				
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		}else if (($wherefield=='catogory') and ($frompanel!="bycategory")){
		echo "catNbycat";
				if ($page=="1") { 
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
				
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
				
			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
			}else if ($frompanel=="bycategory"){

				if ($date1==0){$date1='';}
				if ($date2==0){$date2='';}
				if ($page=="1") { 
					
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

					echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&dateone=$date1&datetwo=$date2&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
					echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&dateone=$date1&datetwo=$date2&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a> ";
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
			
			}else{
					echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&dateone=$date1&datetwo=$date2&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a> ";
					echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

					echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&dateone=$date1&datetwo=$date2&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		}else{

		 	if ($page=="1") { 

				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}else if ($page == $total_pages) {
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
			
			}else{
				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&page=".$backpage."'><font color=$urllinkcolor>".BackPage."</font></a>";
				echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
			}
		 }
	}
	
	}else{
	
	$nextpage = $page+1;

	    if ($wheredata=='outofstock'){

		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	      echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&outofstock=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	     }else if ($wheredata=='reorder'){

		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	      echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&reorder=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
	     
		 }else if ($wheredata=='zeroprice'){

		  echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

	      echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&zeroprice=go&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		}else if ($usingsearch=="yes"){ 
			
			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

				echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&usingsearch=go&searching_by=$wherefield&search=$wheredata&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		}else if (($wherefield=='catogory') and ($frompanel!="bycategory")){
			
			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&selected_item=$wheredata2&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";
		}else if ($frompanel=="bycategory"){

			if ($date1==0){$date1='';}
			if ($date2==0){$date2='';}
			 
			
			echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";

			echo "<a href='manage_items_by_categories.php?nextrec=yes&totalpages=$total_pages&catid=$wheredata&artid=$wheredata2&search=$searchfor&search_by=$searchby&frompanel=$frompanel&dateone=$date1&datetwo=$date2&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";


			}else{
		echo "elseBycat";
	      echo " <a><font color=$pagenumcolor>|Page:$page of $total_pages|</font></a>";
		  echo "<a href='manage_items.php?nextrec=yes&totalpages=$total_pages&page=".$nextpage."'><font color=$urllinkcolor>".NextPage."</font></a> ";

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
            
			
			if($myimage !=''){ 
			   if ($cfg_data_outside_storedir == "yes"){
			       $myimage= $cfg_data_supplierIMGpathdir.$myimage;
			 
			  }else{
			       $myimage= 'suppliers/images/'.$myimage;
			  
			  }
			 }else{
                $myimage="../je_images/no_picture.gif";
             }		
			}
             
        if($tablename=='items')
		      {

             
             $ItemRowID=$tablefields[0];
             $ItemID=$row[$ItemRowID];
             
             
			 $Item_result = mysql_query("SELECT article_id,item_image FROM $table WHERE id = $ItemID",$this->conn);
             $Item_row = mysql_fetch_assoc($Item_result);
             $myimage=$Item_row['item_image'];
			 $itemimage=$Item_row['item_image'];
             
			 
			 
		if($myimage !=''){ 
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
            

             
		       } 
        		    
        
				
				echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			}
			
			if ($usertype=="Admin"){
			
			
			echo "<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a></td>
			     
				 <td align='center'>\n<a href=\"form_$tablename.php?action=update&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			   
				 <td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $table {$this->lang->table}?','process_form_$tablename.php?action=delete&id=$row[id]&itemimage=$myimage')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>
		
		         <td align='center'>\n<a href=\"create_1barcodePDF_code39.php?&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>\n</tr>\n\n";
		
		         
	
	}else {
		echo "<td align='center'>\n<a href=\"displayitemimage.php?&itemimage=$itemimage\" rel=\"lightbox\" title=\"$imagetitle\"><font color='$this->rowcolor_link'>ViewImage</font></a></td>
		
		<td align='center'>\n<a href=\"form_$tablename.php?action=update&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>				 
		
		<td align='center'>\n<a href=\"create_1barcodePDF_code39.php?&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->itembarcode}</font></a></td>
		
		\n</tr>\n\n";
	
		
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
						$field_data=$this->idToField("$tableprefix".'items',"$field",$newrow['item_id']);
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
		$items_table="$tableprefix".'items';
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
		elseif($field=='date')
		{
		
				$tyear = substr("$data",0,4);
				$tmonth = substr("$data",5,2);
				$tday = substr("$data",8,2);
				$data=$tmonth.'-'.$tday.'-'.$tyear;
			return "$data";
		}	
		elseif($field=='description')
		{
		
		


			$data = wordwrap($data, 24, "<br />");
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