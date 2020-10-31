<?php session_start(); ?>

<html>
<head>
<script type="text/javascript">
function validateFormOnSubmit(theForm) {
var reason = "";

  
 
 
  reason += validateFirstName(theForm.first_name);
  reason += validateLastName(theForm.last_name);
  reason += validateAccountNumber(theForm.account_number,theForm.system_gen_acctnum);
  reason += validatePhone(theForm.phone_number);
  reason += validateEmail(theForm.email);
  reason += validateAddress(theForm.street_address);
  reason += validateComments(theForm.comments); 
   
 
  if (reason != "") {
    alert("Some fields need correction:\n" + reason);
    return false;
  }

 
  
}
function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "The required fields have not been filled in.\n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}
function validateFirstName(fld) {
    var error = "";

   var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a First Name.\n";
    } else if ((fld.value.length < 3) || (fld.value.length > 30)) {
        fld.style.background = 'Yellow'; 
        error = "The first name is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The first name contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
        var casechanged=fld.value.toUpperCase();
        fld.value = casechanged; 
    }
    return error;
}
function validateLastName(fld) {
    var error = "";

   var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Last Name.\n";
    } else if ((fld.value.length < 3) || (fld.value.length > 30)) {
        fld.style.background = 'Yellow'; 
        error = "The last name is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The last name contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
        var casechanged=fld.value.toUpperCase();
        fld.value = casechanged; 
    }
    return error;
}
function validateAccountNumber(fld,fld2) {
    var error = ""; 
    var illegalChars = /\W/; 
    var system_assigned_acctnum = fld2.value; 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "Account Number is blank This should fill Automatically. Cancle and come back to this screen again.\n";

      } else if (fld.value != system_assigned_acctnum) {
        fld.style.background = 'Yellow'; 
        error = 'The account number value should be '+system_assigned_acctnum+'.\n';
        alert('The account number value should be '+system_assigned_acctnum+'. Please correct it');
    } else if ((fld.value.length < 3) || (fld.value.length > 10)) {
        fld.style.background = 'Yellow'; 
        error = "The account number is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The account number contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}
function validatePhone(fld) {
    var error = "";

    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    

   if (fld.value == "") {
        error = "You didn't enter a phone number.\n";
        fld.style.background = 'Yellow';
    } else if (isNaN(parseInt(stripped))) {
        error = "The phone number contains illegal characters.\n";
        fld.style.background = 'Yellow';
    } else if (!(stripped.length == 10)) {
        error = "The phone number is the wrong length. Make sure you included an area code.\n";
        fld.style.background = 'Yellow';
    }
    return error;
}
function validateEmail(fld) {
    var error="";
    var tfld = trim(fld.value);                        
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
   
    if (fld.value != "") {
			       if (fld.value == "") {
			           fld.style.background = 'Yellow';
			           error = "You didn't enter an email address.\n";
			       } else if (!emailFilter.test(tfld)) {              
			           fld.style.background = 'Yellow';
			           error = "Please enter a valid email address.\n";
			       } else if (fld.value.match(illegalChars)) {
			            fld.style.background = 'Yellow';
			            error = "The email address contains illegal characters.\n";
			       } else {
			            fld.style.background = 'White';
			       }
			       return error;
    } else {
      fld.style.background = 'White';
    }
  return error;
}
function validateAddress(fld) {
    var error = "";

      var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
      
      if (fld.value != "") {
		       	if (fld.value == "") {
		            fld.style.background = 'Yellow'; 
		            error = "You didn't enter a Address.\n";
			      } else if ((fld.value.length < 5) || (fld.value.length > 80)) {
			          fld.style.background = 'Yellow'; 
			          error = "The Address is the wrong length.\n";
			      } else if (illegalChars.test(fld.value)) {
			           fld.style.background = 'Yellow'; 
			           error = "The Address contains illegal characters.\n";
			      } else {
			           fld.style.background = 'White';
			      }
			          return error;
			 } else {
         fld.style.background = 'White';
       }
   return error;  
}
function validateComments(fld) {
    var error = "";

        var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
      if (fld.value != "") {
				    if (fld.value == "") {
				        fld.style.background = 'Yellow'; 
				        error = "You didn't enter a comments\n";
				    } else if ((fld.value.length < 5) || (fld.value.length > 100)) {
				        fld.style.background = 'Yellow'; 
				        error = "The comments is the wrong length.\n";
				    } else if (illegalChars.test(fld.value)) {
				        fld.style.background = 'Yellow'; 
				        error = "The comments contains illegal characters.\n";
				    } else {
				        fld.style.background = 'White';
				    }
				       return error;
				} else {
         fld.style.background = 'White';
       }
  return error;       
}
  
function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}

</script>
</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/form.php");
include ("../classes/display.php");
include ("../classes/cryptastic.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		header ("location: ../login.php");
		exit();
}

$first_name_value='';
$last_name_value='';
$account_number_value='';
$phone_number_value='';
$email_value='';
$street_address_value='';
$comments_value='';
$id=-1;


		$userstable="$cfg_tableprefix".'users';
		$userid=$_SESSION['session_user_id'];
    $user_result = mysql_query("SELECT type FROM $userstable WHERE id = $userid ",$dbf->conn);
    $usertable_row = mysql_fetch_assoc($user_result);
    $usertype=$usertable_row['type'];






if(isset($_GET['action']))
{
	$action=$_GET['action'];
}
else
{
	$action="insert";
}


if($action=="update")
{
	$display->displayTitle("$lang->updateCustomer");
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'customers';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$first_name_value=$row['first_name'];
		$last_name_value=$row['last_name'];
		$account_number_value=$row['account_number'];
		$phone_number_value=$row['phone_number'];
		$email_value=$row['email'];
		$street_address_value1=$row['street_address'];
		$comments_value=$row['comments'];
		$bancustomer_value=$row['bancustomer']; 
		if ($row['bancustomer'] == 'Y'){$bancustomer_checked = 'checked';}
		
	  $system_assigned_acctnum=$account_number_value;
	  
	  
	
	  
     if ($cfg_dencrypt == "yes")
     {
       $cryptastic = new cryptastic;

        $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
               die("Failed to generate secret key.");

              $AbleTodecrypt="yes";
              $decryptedaddress = $cryptastic->decrypt($street_address_value1, $key, true) or
			                      $AbleTodecrypt="Failed to complete decryption of Street Address";   

         if ($AbleTodecrypt=="yes")
		 {
              $street_address_value=$decryptedaddress;

         }else{
		      echo "<center><b><font color='red'>$AbleTodecrypt</font></b></center>";
              $street_address_value=$street_address_value1;
         }		 
}else{

$street_address_value=$street_address_value1;

}
 
	  
	  
	    
	  
	}

}
else
{
	$display->displayTitle("$lang->addCustomer");
	
		     $auto_increment_table="'"."$cfg_tableprefix".'customers'."'";
		      
		      $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ");
          $row = mysql_fetch_array($r);
          $Auto_increment = $row['Auto_increment'];

		 
		      $next_id=$Auto_increment;
    		
		     $accountnum=$cfg_store_code.$next_id;	
         $system_assigned_acctnum=$accountnum; 
     	   $account_number_value=$accountnum;
     	
  
}


$f1=new form('return validateFormOnSubmit(this)','process_form_customers.php','POST','customers','450',$cfg_theme,$lang);


$f1->createInputField("<b>$lang->firstName:</b> ",'text','first_name',"$first_name_value",'24','150');
$f1->createInputField("<b>$lang->lastName:</b> ",'text','last_name',"$last_name_value",'24','150');
$f1->createInputField("$lang->accountNumber: ",'text','account_number',"$account_number_value",'24','150');
$f1->createInputField("<b>$lang->phoneNumber</b> ",'text','phone_number',"$phone_number_value",'24','150');
$f1->createInputField("$lang->email:",'text','email',"$email_value",'24','150');
$f1->createInputField("$lang->streetAddress:",'text','street_address',"$street_address_value",'24','150');
$f1->createInputField("$lang->commentsOrOther:",'text','comments',"$comments_value",'40','150');
if ($usertype=="Admin"){
    $f1->createInputField("Ban Customer:",'checkbox','bancustomer',"Y",'10','160',"$bancustomer_checked");
}




echo "		
		<input type='hidden' name='system_gen_acctnum' value='$system_assigned_acctnum'>
		<input type='hidden' name='action' value='$action'>		 
		<input type='hidden' name='id' value='$id'>";
		
$f1->endForm();
$dbf->closeDBlink();


?>
</body>
</html>




