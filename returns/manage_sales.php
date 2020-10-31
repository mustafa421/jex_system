<?php session_start(); ?>

<html>
<head>
<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url)
{
  if(confirm(message) )
  {
    location.href = url;
  }
}
// --->
</SCRIPT> 

</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");
include ("../classes/form.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);

if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$lang->manageSales");


$f1=new form('return validateFormOnSubmit(this)','manage_sales.php','POST','sales','450',$cfg_theme,$lang);
$f1->createDateSelectFieldModfied();
$f1->formBreak('500',$cfg_theme);
$f1->createInputField("<b>Search for Sale</b>",'text','search','','24','150');




$option_values2=array('ALL','sale_id','upc','itemname','saletotalamt');
$option_titles2=array("ALL","Sale ID","UPC","Item Name","Sale Total Amount");

$f1->createSelectField("<b>$lang->searchBy</b>",'searching_by',$option_values2,$option_titles2,100);
$f1->endForm();


if((isset($_POST['search'])) or (($_POST['day1']) !=0 ))
{
	$search=$_POST['search'];
	$searchby=$_POST['searching_by'];
	
	$day1 = $_POST['day1'];
	$month1 = $_POST['month1'];
	$year1 = $_POST['year1'];
	
	$day2 = $_POST['day2'];
	$month2 = $_POST['month2'];
	$year2 = $_POST['year2'];
	
	
	
	
	
	
	
	
	
	
	
	
	


	if ($searchby=="ALL"){
	
	if (($day1 == 0) and ($day2 == 0)  and ($search !=''))
	{
		 $search=trim($search);
		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
		$itemstable = "$cfg_tableprefix".'items';
		$id1=2;
		$id2=1;
		$runstatement="ALL";
		
		$sqlstatement="select distinct a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from jestore_sales a , jestore_sales_items b , jestore_items c  where a.id = b.sale_id  and b.item_id=c.id  and (c.item_name like '$search'  or a.id = '$search'  or b.upc = '$search'  or a.sale_total_cost = '$search')    ORDER BY a.id DESC";
		
		
		
		
	}
	
	if (($day1 != 0) and ($day2 == 0)  and ($search ==''))
	{
	    $date1=$year1.'-'.$month1.'-'.$day1;
		$sales_table= "$cfg_tableprefix".'sales';
		
		$id1=2;
		$id2=1;
		$runstatement="ALL";
		$sqlstatement="SELECT * FROM $sales_table where date ='$date1' ORDER BY id DESC";
		
		
	}
	
	if (($day1 != 0) and ($day2 != 0)  and ($search ==''))
	{
	    
		$date1=$year1.'-'.$month1.'-'.$day1;
		$date2=$year2.'-'.$month2.'-'.$day2;
		$sales_table= "$cfg_tableprefix".'sales';
		
		$id1=2;
		$id2=1;
		$runstatement="ALL";
		$sqlstatement="SELECT * FROM $sales_table where date between '$date1' and '$date2' ORDER BY id DESC";
		

	}
	
	
		if (($day1 != 0) and ($day2 == 0)  and ($search !=''))
	{
	     $date1=$year1.'-'.$month1.'-'.$day1;
		 $search=trim($search);
		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
		$itemstable = "$cfg_tableprefix".'items';
		$id1=2;
		$id2=1;
		$runstatement="ALL";
		
		$sqlstatement="select distinct a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from $salestable a , $saleitemstable b , $itemstable c  where a.id = b.sale_id  and b.item_id=c.id and a.date = '$date1' and (c.item_name like '$search'  or a.id = '$search'  or b.upc = '$search'  or a.sale_total_cost = '$search')    ORDER BY a.id DESC";
		
	}
	
		
		if (($day1 != 0) and ($day2 != 0)  and ($search !=''))
	{
	     $date1=$year1.'-'.$month1.'-'.$day1;
		 $date2=$year2.'-'.$month2.'-'.$day2;
		 $search=trim($search);
		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
		$itemstable = "$cfg_tableprefix".'items';
		$id1=2;
		$id2=1;
		$runstatement="ALL";
		
		$sqlstatement="select distinct a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from $salestable a , $saleitemstable b , $itemstable c  where a.id = b.sale_id  and b.item_id=c.id and a.date between '$date1' and '$date2' and (c.item_name like '$search'  or a.id = '$search'  or b.upc = '$search'  or a.sale_total_cost = '$search')    ORDER BY a.id DESC";

	}
}
	
	
	if (($searchby=="sale_id") and ($search !='')){
		$search=trim($search);
		if (($day1 == 0) and ($day2 == 0)) {
			
			$sales_table= "$cfg_tableprefix".'sales';
		$id1=2;
		$id2=1;
		$runstatement="sale_id";
		$sqlstatement="SELECT * FROM $sales_table where id = '$search' ORDER BY id DESC";
		
			
		}
		if (($day1 != 0) and ($day2 == 0)) {
			$date1=$year1.'-'.$month1.'-'.$day1;
		    $date2=$year2.'-'.$month2.'-'.$day2;
			
			$search=trim($search);
			$sales_table= "$cfg_tableprefix".'sales';
		$id1=2;
		$id2=1;
		$runstatement="sale_id";
		$sqlstatement="SELECT * FROM $sales_table where date = '$date1' and id = '$search' ORDER BY id DESC";
		}
		
		if (($day1 != 0) and ($day2 != 0)) {
			$date1=$year1.'-'.$month1.'-'.$day1;
		    $date2=$year2.'-'.$month2.'-'.$day2;
			
			$search=trim($search);
			$sales_table= "$cfg_tableprefix".'sales';
			$id1=2;
			$id2=1;
			$runstatement="sale_id";
			$sqlstatement="SELECT * FROM $sales_table where date between '$date1' and '$date2' and id = '$search' ORDER BY id DESC";
		}
	}
	
	if (($searchby=="upc") and ($search !='')){
		if (($day1 == 0) and ($day2 == 0)) {

		$search=trim($search);
		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
			$id1=2;
			$id2=1;
			$runstatement="upc";
			$sqlstatement="select a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from $salestable a , $saleitemstable b where a.id = b.sale_id and b.upc = '$search' ORDER BY a.id DESC";




		}
		if (($day1 != 0) and ($day2 == 0)) {
			$date1=$year1.'-'.$month1.'-'.$day1;
		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
		$id1=2;
		$id2=1;
		$runstatement="upc";
		$sqlstatement="select a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from $salestable a , $saleitemstable b where a.id = b.sale_id and a.date = '$date1' and b.upc = '$search' ORDER BY a.id DESC";

		}
		
		if (($day1 != 0) and ($day2 != 0)) {
			$date1=$year1.'-'.$month1.'-'.$day1;
		    $date2=$year2.'-'.$month2.'-'.$day2;
		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
		$id1=2;
		$id2=1;
		$runstatement="upc";
		$sqlstatement="select a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from $salestable a , $saleitemstable b where a.id = b.sale_id and a.date between '$date1' and '$date2' and b.upc = '$search' ORDER BY a.id DESC ";

		}
	}
	
	
		if (($searchby=="itemname") and ($search !='')){
		
		 $search=trim($search);
		
		$itemstable = "$cfg_tableprefix".'items';
	    $items_query="SELECT id FROM $itemstable where item_name like '%$search%' ";
		$item_result=mysql_query($items_query,$dbf->conn);
		$items_row = mysql_fetch_assoc($item_result);
		$itemid=$items_row ['id'];
		
		if (($day1 == 0) and ($day2 == 0)) {
		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
		$itemstable = "$cfg_tableprefix".'items';
		$id1=2;
		$id2=1;
		$runstatement="itemname";
		$sqlstatement="select a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from $salestable a , $saleitemstable b , $itemstable c where a.id = b.sale_id and b.item_id=c.id and c.item_name like '%$search%' ORDER BY a.id DESC";
		
		
		
		}
		if (($day1 != 0) and ($day2 == 0)) {
			$date1=$year1.'-'.$month1.'-'.$day1;

		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
		$itemstable = "$cfg_tableprefix".'items';
		$id1=2;
		$id2=1;
		$runstatement="itemname";
		$sqlstatement="select a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from $salestable a , $saleitemstable b , $itemstable c where a.id = b.sale_id and a.date = '$date1' and b.item_id=c.id and c.item_name like '%$search%' ORDER BY a.id DESC";
		
		}
		
		if (($day1 != 0) and ($day2 != 0)) {
			$date1=$year1.'-'.$month1.'-'.$day1;
		    $date2=$year2.'-'.$month2.'-'.$day2;
		
		$salestable = "$cfg_tableprefix".'sales';
		$saleitemstable = "$cfg_tableprefix".'sales_items';
		$itemstable = "$cfg_tableprefix".'items';
		$id1=2;
		$id2=1;
		$runstatement="itemname";
		$sqlstatement="select a.id,a.date,a.customer_id,a.sale_sub_total,a.sale_total_cost,a.paid_with,a.items_purchased,a.sold_by,a.comment from $salestable a , $saleitemstable b , $itemstable c where a.id = b.sale_id and a.date between '$date1' and '$date2' and b.item_id=c.id and c.item_name like '%$search%' ORDER BY a.id DESC";
		
		}
	}
		
	if (($searchby=="saletotalamt") and ($search !='')){
		$search=trim($search);
		if (($day1 == 0) and ($day2 == 0)) {
			
			$sales_table= "$cfg_tableprefix".'sales';
		$id1=2;
		$id2=1;
		$runstatement="saletotalamt";
		$sqlstatement="SELECT * FROM $sales_table where sale_total_cost = '$search' ORDER BY id DESC";
		
			
		}
		if (($day1 != 0) and ($day2 == 0)) {
			$date1=$year1.'-'.$month1.'-'.$day1;

			
			$search=trim($search);
			$sales_table= "$cfg_tableprefix".'sales';
		$id1=2;
		$id2=1;
		$runstatement="saletotalamt";
		$sqlstatement="SELECT * FROM $sales_table where date = '$date1' and sale_total_cost = '$search' ORDER BY id DESC ";
		}
		
		if (($day1 != 0) and ($day2 != 0)) {
			$date1=$year1.'-'.$month1.'-'.$day1;
		    $date2=$year2.'-'.$month2.'-'.$day2;
			
			$search=trim($search);
			$sales_table= "$cfg_tableprefix".'sales';
			$id1=2;
			$id2=1;
			$runstatement="saletotalamt";
			$sqlstatement="SELECT * FROM $sales_table where date between '$date1' and '$date2' and sale_total_cost = '$search' ORDER BY id DESC ";
		}
	}

if($id1 =='')
	{
	echo "<br/><br/><br/>";
	echo "<center><b><font color=blue>Your search returned Zero result. Please check search criteria and try again.</font></b></center>";
	exit;
	}
	
	if($id1 < $id2)
	{
		echo "<center><b>$lang->incorrectSearchFormat(ex: $id2-$id1)</b></center>";
		exit();
	
	}


	if ($search!=''){$searchingfor=' Searching: '.$search;}else{$searchingfor='';}
	if ($date1!='' and $date2!=''){$ForDate=' For Date Between: ' .$date1.' and '.$date2;}else if ($date1!=''){ $ForDate=' For Date: '.$date1;}else{$ForDate='';}
	
	$Displaysearchfor=$searchingfor. ' SearchBy: '.$searchby.$ForDate;
	
	
	echo "<center>$Displaysearchfor</center><br/>";
	
	
	
	$display->displaySaleManagerTableJex("$cfg_tableprefix",$runstatement,$sqlstatement,'id');

}
else
   
   if((isset($_GET['cursaleid'])) and (isset($_GET['kvalue']))){

		$search=$_GET['cursaleid'];
		$searchby='sale_id';
		  
	if (($searchby=="sale_id") and ($search !='')){
		$search=trim($search);
		if (($day1 == 0) and ($day2 == 0)) {
			
			$sales_table= "$cfg_tableprefix".'sales';
		$id1=2;
		$id2=1;
		$runstatement="sale_id";
		$sqlstatement="SELECT * FROM $sales_table where id = '$search' ORDER BY id DESC";
		}
		}
		$display->displaySaleManagerTableJex("$cfg_tableprefix",$runstatement,$sqlstatement,'id');
   }else{
   
   
	$display->displaySaleManagerTableJex("$cfg_tableprefix",'','','id');
	}

$dbf->closeDBlink();

?>
</body>
</html>