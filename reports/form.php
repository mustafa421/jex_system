<?php session_start(); ?>
<html>
<head>
<SCRIPT language=JavaScript>

function reload(form){


var valcat=form.selected_category.options[form.selected_category.options.selectedIndex].value;
var valitem=form.selected_item.options[form.selected_item.options.selectedIndex].value;

self.location='form.php?displayresult=no&report=InventoryCostReport&invcatid=' +valcat+ '&artid=' +valitem


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
include ("../classes/form.php");
include ("../classes/display.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		header ("location: ../login.php");
		exit();
}


$day=date("d");
$month=date("m");
$year=date("Y");
$today=date("Y-m-d").":".date("Y-m-d");
$yesterday=date("Y-m-d",mktime(0,0,0,$month,$day-1,$year)).":".date("Y-m-d",mktime(0,0,0,$month,$day-1,$year));
$week=date("Y-m-d",mktime(0,0,0,$month,$day-6,$year)).":".date("Y-m-d",mktime(0,0,0,$month,$day,$year));
$thismonth=date("Y-m-d",mktime(0,0,0,$month,1,$year)).":".date("Y-m-d",mktime(0,0,0,$month,$day,$year));
$lastmonth=date("Y-m-d",mktime(0,0,0,$month-1,1,$year)).":".date("Y-m-d",mktime(0,0,0,$month-1,date("t",mktime(0,0,0,$month-1,1,$year)),$year));
$thisyear=date("Y-m-d",mktime(0,0,0,1,1,$year)).":".date("Y-m-d",mktime(0,0,0,$month,$day,$year));
$alltime=date("Y-m-d",mktime(0,0,0,1,1,0000)).":".date("Y-m-d",mktime(0,0,0,$month,$day,$today));


if(isset($_GET['report']))
{
	$form=$_GET['report'];
}
$display->displayTitle("$lang->inputNeeded $form");



if($form=="$lang->allCustomersReport")
{
	$f1=new form('return validateFormOnSubmit(this)','all_customers.php','POST','customers','215',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'95');
	$f1->endForm();

}
elseif($form=="$lang->allItemsReport")
{
	$f1=new form('return validateFormOnSubmit(this)','all_items.php','POST','items','215',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'95');
	$f1->endForm();
}
elseif($form=="$lang->allItemsReportDateRange")
{
        $f1=new form('return validateFormOnSubmit(this)','all_items_date_range.php','POST','items','500',$cfg_theme,$lang);
	$f1->createDateSelectField();
	$f1->endForm();
}
elseif($form=="$lang->allBrandsReport")
{
	$f1=new form('return validateFormOnSubmit(this)','all_brands.php','POST','brands','215',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'95');
	$f1->endForm();

}
elseif($form=="$lang->allCategoriesReport")
{
	$f1=new form('return validateFormOnSubmit(this)','all_categories.php','POST','categories','215',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'95');
	$f1->endForm();

}
elseif($form=="$lang->allEmployeesReport")
{
	$f1=new form('return validateFormOnSubmit(this)','all_employees.php','POST','employees','215',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'95');
	$f1->endForm();
}
elseif($form=="$lang->brandReport")
{
	$option_values=array();
    $option_titles=array();
    $brands_table=$cfg_tableprefix.'brands';
    $brand_result=mysql_query("SELECT * FROM $brands_table ORDER by brand",$dbf->conn);

    if(isset($_GET['brand_search']))
    {
    	$search=$_GET['brand_search'];
		$brand_result=mysql_query("SELECT * FROM $brands_table WHERE brand like \"%$search%\" ORDER by brand",$dbf->conn);

    }
	
	if(mysql_num_rows($brand_result)>0)
	{
		while($row=mysql_fetch_assoc($brand_result))
		{
			$option_values[]=$row['id'];
		 	$option_titles[]=$row['brand'];
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;
	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findBrand: <input type='text' size='8' name='brand_search'>
	<input type='hidden' name='report' value=$lang->brandReport value='Go'>
	<input type='submit' value='Go'>
	</form>";
	$f1=new form('return validateFormOnSubmit(this)','brand.php','POST','brand','450',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'150');
	$f1->createSelectField("<b>$lang->selectBrand</b>",'selected_brand',$option_values,$option_titles,'150');
	$f1->endForm();
}
elseif($form=="$lang->categoryReport")
{
	$option_values=array();
    $option_titles=array();
    $categories_table=$cfg_tableprefix.'categories';
    $category_result=mysql_query("SELECT * FROM $categories_table ORDER by category",$dbf->conn);

    if(isset($_GET['category_search']))
    {
    	$search=$_GET['category_search'];
		$category_result=mysql_query("SELECT * FROM $categories_table WHERE category like \"%$search%\" ORDER by category",$dbf->conn);

    }
	
	if(mysql_num_rows($category_result)>0)
	{
		while($row=mysql_fetch_assoc($category_result))
		{
			$option_values[]=$row['id'];
		 	$option_titles[]=$row['category'];
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;
	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findCategory: <input type='text' size='8' name='category_search'>
	<input type='hidden' name='report' value=$lang->categoryReport value='Go'>
	<input type='submit' value='Go'>
	</form>";
	$f1=new form('return validateFormOnSubmit(this)','category.php','POST','category','450',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'150');
	$f1->createSelectField("<b>$lang->selectCategory</b>",'selected_category',$option_values,$option_titles,'150');
	$f1->endForm();
}
elseif($form=="$lang->taxReport")
{
	$option_values=array();
    $option_titles=array();
    $sales_items_table=$cfg_tableprefix.'sales_items';
    $tax_result=mysql_query("SELECT DISTINCT item_tax_percent FROM $sales_items_table ORDER by item_tax_percent DESC",$dbf->conn);

	
	if(mysql_num_rows($tax_result)>0)
	{
		while($row=mysql_fetch_assoc($tax_result))
		{
			$option_values[]=$row['item_tax_percent'];
		 	$option_titles[]=$row['item_tax_percent'].'%';
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;
	
	}
	echo "<center>";
	$f1=new form('return validateFormOnSubmit(this)','tax.php','POST','tax','450',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'150');
	$f1->createSelectField("<b>$lang->selectTax %</b>",'selected_tax',$option_values,$option_titles,'150');
	$f1->endForm();
}
elseif($form=="$lang->customerReport")
{

    $option_values=array();
    $option_titles=array();
    $customers_table=$cfg_tableprefix.'customers';
    $customer_result=mysql_query("SELECT first_name,last_name,id FROM $customers_table ORDER by last_name",$dbf->conn);

    if(isset($_GET['customer_search']))
    {
    	$search=$_GET['customer_search'];
		$customer_result=mysql_query("SELECT first_name,last_name,id FROM $customers_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" ORDER by last_name",$dbf->conn);

    }
	
	if(mysql_num_rows($customer_result)>0)
	{
		while($row=mysql_fetch_assoc($customer_result))
		{
			$option_values[]=$row['id'];
		 	$option_titles[]=$row['last_name'].', '.$row['first_name'];
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;
	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findCustomer: <input type='text' size='8' name='customer_search'>
	<input type='hidden' name='report' value=$lang->customerReport value='Go'>
	<input type='submit' value='Go'>
	</form>";
	$f1=new form('return validateFormOnSubmit(this)','customer.php','POST','customer','450',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'150');
	$f1->createSelectField("<b>$lang->selectCustomer</b>",'selected_customer',$option_values,$option_titles,'150');
	$f1->endForm();

}
elseif($form=="$lang->customerReportDateRange")
{

    $option_values=array();
    $option_titles=array();
    $customers_table=$cfg_tableprefix.'customers';
    $customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table ORDER by last_name",$dbf->conn);

    if(isset($_GET['customer_search']))
    {

    	$search=$_GET['customer_search'];
		$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" or account_number like \"%$search%\"  ORDER by last_name",$dbf->conn);

    }
	
	if(mysql_num_rows($customer_result)>0)
	{
		while($row=mysql_fetch_assoc($customer_result))
		{			
			$option_values[]=$row['id'];
		 	$option_titles[]=$row['last_name'].', '.$row['first_name'].' ('.$row['account_number'].')';
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;
	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findCustomer: <input type='text' size='8' name='customer_search'>
	<input type='hidden' name='report' value=$lang->customerReportDateRange value='Go'>
	<input type='submit' value='Go'>
	</form>";

	$f1=new form('return validateFormOnSubmit(this)','customer_date_range.php','POST','customer','500',$cfg_theme,$lang);
	$f1->createDateSelectField();
	$f1->formBreak('500',$cfg_theme);
	$f1->createSelectField("<b>$lang->selectCustomer</b>",'selected_customer',$option_values,$option_titles,'130');
	$f1->endForm();

}
elseif($form=="$lang->itemReport")
{
	$option_values=array();
    $option_titles=array();
    $items_table=$cfg_tableprefix.'items';
    $item_result=mysql_query("SELECT item_name,id FROM $items_table ORDER by item_name",$dbf->conn);

    if(isset($_GET['item_search']))
    {
    	$search=$_GET['item_search'];
		$item_result=mysql_query("SELECT item_name,id FROM $items_table WHERE item_name like \"%$search%\" ORDER by item_name",$dbf->conn);

    }
	
	if(mysql_num_rows($item_result)>0)
	{
		while($row=mysql_fetch_assoc($item_result))
		{
			$option_values[]=$row['id'];
		 	$option_titles[]=$row['item_name'];
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;
	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findItem: <input type='text' size='8' name='item_search'>
	<input type='hidden' name='report' value=$lang->itemReport value='Go'>
	<input type='submit' value='Go'>
	</form>";
	$f1=new form('return validateFormOnSubmit(this)','item.php','POST','item','450',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'150');
	$f1->createSelectField("<b>$lang->selectItem</b>",'selected_item',$option_values,$option_titles,'150');
	$f1->endForm();

}
elseif($form=="$lang->itemReportDateRange")
{
    $option_values=array();
    $option_titles=array();
    $items_table=$cfg_tableprefix.'items';
    $item_result=mysql_query("SELECT item_name,item_number,id FROM $items_table ORDER by item_name",$dbf->conn);

    if(isset($_GET['item_search']))
    {
    	$search=$_GET['item_search'];
		$item_result=mysql_query("SELECT item_name,item_number,id FROM $items_table WHERE item_name like \"%$search%\" or item_number like \"%$search%\" ORDER by item_name",$dbf->conn);

    }
	
	if(mysql_num_rows($item_result)>0)
	{
		while($row=mysql_fetch_assoc($item_result))
		{
			$option_values[]=$row['id'];
		 	$option_titles[]=$row['item_name'].' ['.$row['item_number'].']';
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;

	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findItem: <input type='text' size='8' name='item_search'>
	<input type='hidden' name='report' value='$lang->itemReportDateRange' value='Go'>
	<input type='submit' value='Go'>
	</form>";
	$f1=new form('return validateFormOnSubmit(this)','item_date_range.php','POST','item','500',$cfg_theme,$lang);
	$f1->createDateSelectField();
	$f1->formBreak('500',$cfg_theme);
	$f1->createSelectField("<b>$lang->selectItem</b>",'selected_item',$option_values,$option_titles,'130');
	$f1->endForm();

}

elseif($form=="$lang->itemCostReportDateRange")
{
    $option_values=array();
    $option_titles=array();
    
    $article_table=$cfg_tableprefix.'articles';
    
    $article_result=mysql_query("SELECT article,id FROM $article_table ORDER by article",$dbf->conn);


    if(isset($_GET['item_search']))
    {
    $search=$_GET['item_search'];
		

     $article_result=mysql_query("SELECT article,id FROM $article_table WHERE article like \"%$search%\"  ORDER by article",$dbf->conn);


    }
	
	if(mysql_num_rows($article_result)>0)
	{
		while($row=mysql_fetch_assoc($article_result))
		{
			$option_values[]=$row['id'];
		 	
		 	$option_titles[]=$row['article'];
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;

	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findItem: <input type='text' size='8' name='item_search'>
	<input type='hidden' name='report' value='$lang->itemReportDateRange' value='Go'>
	<input type='submit' value='Go'>
	</form>";
	$f1=new form('return validateFormOnSubmit(this)','je_daterange_itemcost.php','POST','item','500',$cfg_theme,$lang);
	$f1->createDateSelectField();
	$f1->formBreak('500',$cfg_theme);
	$f1->createSelectField("<b>$lang->selectItem</b>",'selected_item',$option_values,$option_titles,'130');
	$f1->endForm();
}

elseif($form=="ServicesDateRangeReport")
{
    $option_values=array();
    $option_titles=array();
    
    
    
    


$categorytable = "$cfg_tableprefix".'categories';
$wherefield = ' showon_saleservicepanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
$resultcat = mysql_query("SELECT * FROM $categorytable WHERE $wherefield ",$dbf->conn);
$row = mysql_fetch_array($resultcat);
$catid=$row['id'];




$article_table = "$cfg_tableprefix".'articles a,'."$cfg_tableprefix".'categories b ';
$wherefield = ' a.category_id = ' ." '". "$catid"."'".' and  a.category_id = b.id and b.showon_saleservicepanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'";









$article_result = mysql_query("SELECT a.id,a.article FROM $article_table WHERE $wherefield ",$dbf->conn);
$numart_rows = mysql_num_rows($article_result);

	
	
	
	

    if(isset($_GET['item_search']))
    {
    $search=$_GET['item_search'];
	

     


    }
	
	if(mysql_num_rows($article_result)>0)
	{
		while($row=mysql_fetch_assoc($article_result))
		{

	          $option_titles[0] ="Report All Services";
	          $option_values[0] ='allservices';
			
		
		  $option_values[]=$row['id'];
		 
		 	$option_titles[]=$row['article'];

		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;

	
	}
	
	
	
	
	
	$f1=new form('return validateFormOnSubmit(this)','services_date_range.php','POST','item','500',$cfg_theme,$lang);
	$f1->createDateSelectField();
	$f1->formBreak('500',$cfg_theme);
	$f1->createSelectField("<b>Select Service</b>",'selected_item',$option_values,$option_titles,'130');
	$f1->endForm();
}

elseif($form=="InventoryCostReport")
{
    
if(isset($_GET['invcatid'])){$catid=$_GET['invcatid'];}


$categorytable = "$cfg_tableprefix".'categories';


$wherefield = ' activate_category = '."'".'Y'. "'" ;


$category_option_titles=$dbf->getAllElementswhere("$categorytable",'category',"$wherefield",'category');
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values=$dbf->getAllElementswhere("$categorytable",'id',"$wherefield",'category');
$category_option_values[0] = $category_id_value;

$category_option_titles[0] = "All categories";
$category_option_values[0] = 'allcategories';



if(isset($_GET['invcatid'])){
$category_id_value=$catid;
$category_option_titles[0] = $dbf->idToField("$categorytable",'category',"$category_id_value");
$category_option_values[0] = $category_id_value;
}else{

$category_option_titles[0] = "All categories";
$category_option_values[0] = 'allcategories';
}
	















$articletable = "$cfg_tableprefix".'articles';

$wherefield = 'activate_article = '."'".'Y'. "'" . 'and (category_id =' ." '". "$catid"."'".' or category_id =' ." '". " ". "')"; 


$article_option_titles=$dbf->getAllElementswhere("$articletable",'article',"$wherefield",'article');
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values=$dbf->getAllElementswhere("$articletable",'id',"$wherefield",'article');
$article_option_values[0] = $article_id_value;

$article_option_titles[0] ="All Items";
$article_option_values[0] ='allitems';

if ($article_id_fromtable=="yes"){
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values[0] = $article_id_value;
}


if (isset($_GET['artid']))
{
$article_id_value=$_GET['artid'];
$article_option_titles[0] = $dbf->idToField("$articletable",'article',"$article_id_value");
$article_option_values[0] = $article_id_value;
}



$article_option_titles[0] ="All Items";
$article_option_values[0] ='allitems';



$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

$display->displayTitle("Inventory On Hand Cost");

$f1=new form('return validateFormOnSubmit(this)','inventory.php','POST','items','500',$cfg_theme,$lang);
$onchange="onchange=".'"'."reload(this.form)".'"';
$f1->createDateSelectField();
$f1->formBreak('500',$cfg_theme);
$f1->createSelectField("<b>$lang->selectCategory</b>",'selected_category',$category_option_values,$category_option_titles,'150',$onchange);

$f1->createSelectField("<b>Select Artical</b>",'selected_item',$article_option_values,$article_option_titles,'130');









$option_values2=array('ALL','item_number','serialnumber','article_id','description','itemmodel','id','quantity','supplier_catalogue_number');
$option_titles2=array("ALL","$lang->itemNumber","Serial Number","$lang->itemName","Description","Item Model",'ID',"$lang->quantityStock","$lang->supplierCatalogue");





$f1->endForm();








echo " \n";
echo " \n";
echo "<b><font color='blue'>Information about Date Range entry, Category and Artical selection<br> </font></b>"; 
echo "<b><font color='green'>1- Leave both default dates (today's date) and will select all records up to current date that have the Category and Artical you selected. <br> </font></b>";
echo "<b><font color='green'>2- Only change To date and will select all records that are less then and equal to the To date entered that have the Category and Artical you selected. <br> </font></b>";
echo "<b><font color='green'>3- Only change From date and will select all records that are greater then and equal to the To date (today's date) that have the Category and Artical you selected.<br> </font></b>"; 
echo "<b><font color='green'>4- Change both From and To date will select all records between the two dates that have the Category and Artical you selected.<br> </font></b>"; 



}


elseif($form=="$lang->jecategoryCostReport")
{
    $option_values=array();
    $option_titles=array();
    
    $category_table=$cfg_tableprefix.'categories';
    
    $category_result=mysql_query("SELECT category,id FROM $category_table ORDER by category",$dbf->conn);


    if(isset($_GET['item_search']))
    {
    $search=$_GET['item_search'];
		

     $category_result=mysql_query("SELECT category,id FROM $category_table WHERE category like \"%$search%\"  ORDER by category",$dbf->conn);


    }
	
	if(mysql_num_rows($category_result)>0)
	{
		while($row=mysql_fetch_assoc($category_result))
		{
			$option_values[]=$row['id'];
		 	
		 	$option_titles[]=$row['category'];
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;

	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findItem: <input type='text' size='8' name='item_search'>
	<input type='hidden' name='report' value='$lang->itemReportDateRange' value='Go'>
	<input type='submit' value='Go'>
	</form>";
	$f1=new form('return validateFormOnSubmit(this)','je_category_date_range.php','POST','item','500',$cfg_theme,$lang);
	$f1->createDateSelectField();
	$f1->formBreak('500',$cfg_theme);
	$f1->createSelectField("<b>$lang->selectItem</b>",'selected_item',$option_values,$option_titles,'130');
	$f1->endForm();
}
elseif($form=="$lang->employeeReport")
{

	$option_values=array();
    $option_titles=array();
    $employees_table=$cfg_tableprefix.'users';
    $employee_result=mysql_query("SELECT first_name,last_name,id FROM $employees_table ORDER by last_name",$dbf->conn);

    if(isset($_GET['employee_search']))
    {
    	$search=$_GET['employee_search'];
		$employee_result=mysql_query("SELECT first_name,last_name,id FROM $employees_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" ORDER by last_name",$dbf->conn);

    }
	
	if(mysql_num_rows($employee_result)>0)
	{
		while($row=mysql_fetch_assoc($employee_result))
		{
			$option_values[]=$row['id'];
		 	$option_titles[]=$row['last_name'].', '.$row['first_name'];
		}
	}
	else
	{
		$option_values[]=$search.$lang->notFound;
		$option_titles[]='"'.$search.'"'.' '.$lang->notFound;
	
	}
	echo "<center><form name='search' action='form.php' method='GET'>
	$lang->findEmployee: <input type='text' size='8' name='employee_search'>
	<input type='hidden' name='report' value=$lang->employeeReport value='Go'>
	<input type='submit' value='Go'>
	</form>";
	$f1=new form('return validateFormOnSubmit(this)','employee.php','POST','employee','450',$cfg_theme,$lang);
	$option_values2=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles2=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values2,$option_titles2,'150');
	$f1->createSelectField("<b>$lang->selectEmployee</b>",'selected_employee',$option_values,$option_titles,'150');
	$f1->endForm();

}
elseif($form=="$lang->dateRangeReport")
{
	$f1=new form('return validateFormOnSubmit(this)','date_range.php','POST','customer','500',$cfg_theme,$lang);
	
	 $f1->createDateSelectField();
	 $f1->endForm();
}
elseif($form=="$lang->profitReport")
{
	$option_values=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");

	$f1=new form('return validateFormOnSubmit(this)','profit.php','POST','profit','200',$cfg_theme,$lang);
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values,$option_titles,'200');
	$f1->endForm();


}


elseif($form=="CostReport")
{
	$option_values=array("$today","$yesterday","$week","$thismonth","$lastmonth","$thisyear","$alltime");
	$option_titles=array("$lang->today","$lang->yesterday","$lang->last7days","$lang->thisMonth","$lang->lastMonth","$lang->thisYear","$lang->allTime");

	$f1=new form('return validateFormOnSubmit(this)','item_costreport.php','POST','profit','200',$cfg_theme,$lang);
	$f1->createSelectField("<b>$lang->dateRange</b>",'date_range',$option_values,$option_titles,'200');
	$f1->endForm();


}


elseif($form=="$lang->jeallItemsReportDateRange")
{
  
	$f1=new form('return validateFormOnSubmit(this)','je_all_items_date_range.php','POST','profit','500',$cfg_theme,$lang);
	$f1->createDateSelectField();
	$f1->endForm();
}

	$dbf->closeDBlink();


?>
</body>
</html>




