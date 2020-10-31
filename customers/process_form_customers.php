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
include ("../classes/cryptastic.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit ();
}


$tablename="$cfg_tableprefix".'customers';
$field_names=null;
$field_data=null;
$id=-1;



	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];
		
	}
	
	elseif(isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['account_number']) 
	and isset($_POST['phone_number']) and isset($_POST['email']) and isset($_POST['street_address']) and isset($_POST['comments']) and isset($_POST['id']) and isset($_POST['action']) )
	{
		
		$action=$_POST['action'];
		$id = $_POST['id'];
		
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$account_number = $_POST['account_number'];
		$phone_number = $_POST['phone_number'];
		$email = $_POST['email'];
		$street_address1 = $_POST['street_address'];
		$comments = $_POST['comments'];
		$bancustomer = $_POST['bancustomer'];
		if ($_POST['bancustomer'] == ''){$bancustomer = 'N';}
		$todays_date = date("Y-m-d");
		
		
		if (trim($street_address1) == ""){
		    $street_address1="No Address";   
		}
		
		
        if ($cfg_encrypt == "yes")
           {
              $AbleToecrypt="yes"; 
              $cryptastic = new cryptastic;

              $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
                      die("Failed to generate secret key.");
        
		      $encryptedaddress = $cryptastic->encrypt($street_address1, $key, true) or

                            $AbleToecrypt= "Failed to complete Address encryption.";	  
		
		
		      if ($AbleToecrypt == "yes")
	            {
		          
                  $street_address=$encryptedaddress;				  
		          
		        }else{
				   echo "<center><b><font color='red'>$AbleToecrypt</font></b></center>";
				   $street_address=$street_address1;
				}
		
		}else{
		
		 $street_address=$street_address1;
		
		}
		 
		
		
		if($first_name=='' or $last_name=='' or $phone_number=='')
		{
			echo "$lang->forgottenFields";
			exit();
		}
		else
		{
			$field_names=array('first_name','last_name','account_number','phone_number','email','street_address','comments','date','bancustomer');
			$field_data=array("$first_name","$last_name","$account_number","$phone_number","$email","$street_address","$comments","$todays_date","$bancustomer");	
	
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
	
	
	      $getnextid_tablename="'".$tablename."'";

        $r = mysql_query("SHOW TABLE STATUS LIKE $getnextid_tablename ");
        $row = mysql_fetch_array($r);
        $Auto_increment = $row['Auto_increment'];

		    $id=$Auto_increment;
		    
	  
	
		$dbf->insert($field_names,$field_data,$tablename,true);
	break;
		
	case $action=="update":
		$dbf->update($field_names,$field_data,$tablename,$id,true);
				
	break;
	
	case $action=="delete":
		$dbf->deleteRow($tablename,$id);
	
	break;
	
	default:
		echo "$lang->noActionSpecified";
	break;
}
$dbf->closeDBlink();
echo "<a href=\"../sales/sale_ui.php?&woringcustomerid=$id\"><img src=\"../je_images/btgray_sale_itemsto_customer.png\" onmouseover=\"this.src='../je_images/btgray_sale_itemsto_customer_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_sale_itemsto_customer.png';\" BORDER='0'></a>";
?>
<br>
<a href="manage_customers.php"><img src="../je_images/btgray_manage_customers.png" onmouseover="this.src='../je_images/btgray_manage_customers_MouseOver.png';" onmouseout="this.src='../je_images/btgray_manage_customers.png';" BORDER='0'></a>
<br>
<a href="form_customers.php?action=insert"><img src="../je_images/btgray_create_new_customer.png" onmouseover="this.src='../je_images/btgray_create_new_customer_MouseOver.png';" onmouseout="this.src='../je_images/btgray_create_new_customer.png';" BORDER='0'></a>
</body>
</html>