<?php session_start(); ?>
<?php
include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions_dvd.php");
include ("../classes/security_functions.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);

$tablename = "$cfg_tableprefix".'items';


if(isset($_GET['getClientId'])){  
 
  $enteredupc=$_GET['getClientId'];
  $res1 = "select * from gamedvd_catalog where upc = $enteredupc";
  $commondbf=new db_functions($cfg_server,$cfg_commondbuser,$cfg_commondbpwd,$cfg_commondbname,$cfg_tableprefix,$cfg_theme,$lang);
  $res2 = mysql_query($res1,$commondbf->conn);  
  
 


  $check_item_table="SELECT item_number FROM $tablename WHERE item_number = $enteredupc";
  if(mysql_num_rows(mysql_query($check_item_table,$dbf->conn))){
       
        $items_table_query="SELECT * FROM $tablename WHERE item_number = $enteredupc";
				$items_table_result=mysql_query($items_table_query,$dbf->conn);
				$items_table_row = mysql_fetch_assoc($items_table_result);

   			$item_table_quantity=$items_table_row['quantity'];   			
   			$item_table_buyprice=$items_table_row['buy_price'];
   			$item_table_unitprice=$items_table_row['unit_price'];
   		  $quantity = $item_table_quantity + 1;
   			
      }else {
      	$item_table_buyprice = 1;
      	$item_table_unitprice = 5;
      	$quantity = 1;
      }
 
  
  if($inf = mysql_fetch_array($res2)){  
  
    
   
  
   
    $title_value=$inf['title'];
    $gdvdtitle = str_replace("'", "", "$title_value"); 
	  $gdvdtitle = str_replace(":", "", "$gdvdtitle");
	  $gdvdtitle = str_replace("/", "", "$gdvdtitle");
	  
	  
	  $gdvdtitle = str_replace(",", "", "$gdvdtitle");
	  $gdvdtitle = str_replace("[", "", "$gdvdtitle");
	  $gdvdtitle = str_replace("]", "", "$gdvdtitle");
	  $gdvdtitle = str_replace('"', "", "$gdvdtitle");
   
   
   
   
   echo "formObj.description.value = \"$gdvdtitle\";\n";
   echo "formObj.buy_price.value = \"$item_table_buyprice\";\n";
   echo "formObj.unit_price.value = \"$item_table_unitprice\";\n";
   echo "formObj.quantity.value = \"$quantity\";\n";
   echo "formObj.gamedvdtitle_in_catalog.value = 'yes';\n" ;
  
  }else{
    
     echo "formObj.description.value = 'NotFound';\n" ;
     echo "formObj.buy_price.value = \"$item_table_buyprice\";\n";
     echo "formObj.unit_price.value = \"$item_table_unitprice\";\n";
     echo "formObj.quantity.value = \"$quantity\";\n";
     echo "formObj.gamedvdtitle_in_catalog.value = 'no';\n" ;    
    
   
  }    
}
?> 