<?php session_start(); ?>
<?php
include ("../../settings.php");


  if(isset($_GET['action'])) { 
  	$action=$_GET['action'];
	  if($action=="insert") { 
	  	$UploadLicImage = "yes";
	  	
	  	}
}
?>
<html>
<head>
	
<script type="text/javascript">
function validateFormOnSubmit(theForm) {
var reason = "";

  
 
  reason += validateFirstname(theForm.firstname);
 
  reason += validateLastname(theForm.lastname);
  
 var supplierformgender = "<?php echo($cfg_supplier_form_gender);?>"; 
  if (supplierformgender == "enabled_required") { 
     reason += validateGender(theForm.gender);
  }
  
 
  
  
    var supplierformrace = "<?php echo($cfg_supplier_form_race);?>"; 
  if (supplierformrace == "enabled_required") { 
   reason += validateRace(theForm.race);
  }
  
  reason += validateDob(theForm.dob);
  
    
     var supplierformheight = "<?php echo($cfg_supplier_form_height);?>"; 
  if (supplierformheight == "enabled_required") { 
     reason += validateHeight(theForm.height);
  }
  
       var supplierformweight = "<?php echo($cfg_supplier_form_weight);?>"; 
  if (supplierformweight == "enabled_required") { 
  reason += validateWeight(theForm.weight);
  }
    
     var supplierformhaircolor = "<?php echo($cfg_supplier_form_haircolor);?>"; 
  if (supplierformhaircolor == "enabled_required") { 
  reason += validateHair_color(theForm.hair_color);
  }
  
  var supplierformeyecolor = "<?php echo($cfg_supplier_form_eyecolor);?>"; 
  
  if (supplierformeyecolor == "enabled_required") {
  reason += validateEyes_color(theForm.eyes_color);
  }
  reason += validateAddress(theForm.address);
  reason += validateCity(theForm.city); 
  reason += validateState(theForm.state);
  reason += validateZip(theForm.zip);
 
  reason += validateDriver_lic_num(theForm.driver_lic_num,theForm.itisid,theForm.id_num);
  
  reason += validateisaidbox(theForm.itisid,theForm.driver_lic_num,theForm.id_num,theForm.licstate,theForm.idstate,theForm.idtype);
  
  
  reason += validatePhone(theForm.phone_number);
 
  reason += validateContact(theForm.contact);
  reason += validateEmail(theForm.email);
  reason += validateOther(theForm.other);
  
  reason += validateLicexpdate(theForm.licexpdate);
    
  
  
  var InsertLicImage = "<?php echo($UploadLicImage);?>"; 
      
   if (InsertLicImage == "yes"){
       reason += validateImageLic(theForm.imagelic); 
       }  
 
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
function validateFirstname(fld) {
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
function validateMiddlename(fld) {
    var error = "";
   
   var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
  
  if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Middle Name.\n";
 }else if (fld.value != "") {
     if ((fld.value.length < 1) || (fld.value.length > 30)) {
        fld.style.background = 'Yellow'; 
        error = "The middle name is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The middle name contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
        var casechanged=fld.value.toUpperCase();
        fld.value = casechanged; 
    }
  }  
    return error;
}
function validateLastname(fld) {
    var error = "";
   
   var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a last Name.\n";
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

function validateDLstate(fld) {
    var error = "";
   
   var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter DL State.\n";
    } else if ((fld.value.length < 2) || (fld.value.length > 30)) {
        fld.style.background = 'Yellow'; 
        error = "The DL State is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The DL State contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
        var casechanged=fld.value.toUpperCase();
        fld.value = casechanged; 
    }
    return error;
}


function validateGender1(fld) {
var error = "";


myOption = -1;
for (i=fld.length-1; i > -1; i--) {
if (fld[i].checked) {
myOption = i; i = -1;
}
}
if (myOption == -1) {
	
  
  error = "You must select a Gender.\n";


}







return error;
}

function validateGender(fld) {
    var error = "";
    
    
    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
       if (fld.value == "null") {
              fld.style.background = 'Yellow';
              error = "Select Gender from the dropdown box.\n";      	 
    } else {
        fld.style.background = 'White';
       
    }
    
    return error;
}


function validateIDtype(fld,fld2) {
var error = "";



myOption = -1;
for (i=fld.length-1; i > -1; i--) {
if (fld[i].checked) {
myOption = i; i = -1;
}
}
if (myOption == -1) {
	
  
  
  error = "You must Select/Enter a ID Type.\n";
  


} 
if ((myOption == 2) && (fld2.value == "")) {
	
  
  fld2.style.background = 'Yellow';
  error = "Enter the other ID Type.\n";


} 
if ((myOption != 2) && (fld2.value != "")) {
	
  
  fld2.style.background = 'Yellow';
  error = "You have enter other Type please select ID-Type other radio button.\n";

}







return error;
}

function validateRaceOld(fld) {  
    var error = "";
    
    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Race.\n";
    } else if ((fld.value.length < 2) || (fld.value.length > 25)) {
        fld.style.background = 'Yellow'; 
        error = "The Race is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The Race contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}

function validateRace(fld) {
    var error = "";
    
    
    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
       if (fld.value == "null") {
              fld.style.background = 'Yellow';
              error = "Select Race from the dropdown box.\n";      	 
    } else {
        fld.style.background = 'White';
       
    }
    
    return error;
}



function validateDob(fld) {
var error = "";
var today=new Date(); 
var dobdate_good = "no";

var enterbdate =  fld.value; 


var dashorsalash = enterbdate.substring(2,3);














if (dashorsalash == "/") {
   var bdate = enterbdate;
   var bmonth = bdate.substring(0,2);
   var bday = bdate.substring(3,5);
   var byear = bdate.substring(6,10);
   var dobdate_good = "yes";

} 
  
  
  
  
















 





var mybdate = bday+'/'+bmonth+'/'+byear;

var mysqlformatedbdate = byear+bmonth+bday;



var d = mybdate.split('/');



var by = Number(d[2]); var bm = Number(d[1])-1; var bd = Number(d[0]); 

var bday = new Date(by,bm,bd) 
var age=0; var dif=bday; 
while(dif<today){ 
var dif = new Date(by+age,bm,bd); 
age++; 
} 
age +=-2 ; 


if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "The DOB field is blank.\n";
       
} else if (fld.value == "0000-00-00") {
        fld.style.background = 'Yellow';
        error = "Enter correct DOB.\n";
       
} else if(dashorsalash == "-") {
       fld.style.background = 'Yellow';
        error = "DOB format is MM/DD/YYYY.\n";
} else if (dobdate_good == "no") {
        fld.style.background = 'Yellow';
        error = "DOB format is MM/DD/YYYY.\n";
       

} else if (age < 18) {
        fld.style.background = 'Red';
        
        error = " Under Age.\n";
        
} else {
        fld.style.background = 'Green';
        
        
       
}

return error;

} 

function validateHeight(fld) {
   var error = "";
    
    
    
 
 var myheight = fld.value;
 var isitdash = myheight.substring(1,2);
  

 
 
 
 
 
    
     if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Height.\n";
     } else if (isitdash != '-') {
     	  fld.style.background = 'Yellow'; 
        error = "The Height contains illegal characters. This is a numaric field. E.g if height is 5' and 03\" enter 5-03\n";
     } else if ((fld.value.length < 1) || (fld.value.length > 4)) {
        fld.style.background = 'Yellow'; 
        error = "Wrong lenght of Height field.\n";
     } else {
        fld.style.background = 'White';
    }
 









 





    return error;
}
function validateWeight(fld) {
    var error = "";
    
    
    

    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Weight.\n";
     } else if (isNaN(fld.value)) {
     	  fld.style.background = 'Yellow'; 
        error = "The Weight contains illegal characters. This is a numaric field.\n";
     } else {
        fld.style.background = 'White';
    }
 
 
 
 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
   
    return error;
}

function validateHair_color(fld) {
    var error = "";
    var illegalChars = /\W/; 
    var illegalChars2= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a hair color.\n";
    } else if ((fld.value.length < 2) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The hair color is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The hair color contains illegal characters.\n";
    } else if (illegalChars2.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The hair color contains illegal characters.\n";    
    } else {
        fld.style.background = 'White';
		var casechanged=fld.value.toUpperCase();
        fld.value = casechanged; 
    }
    return error;
}


function validateEyes_color(fld) {
    var error = "";
    var illegalChars = /\W/; 
    var illegalChars2= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a eyes color.\n";
    } else if ((fld.value.length < 2) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The eyes color is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The eyes color contains illegal characters.\n";
    } else if (illegalChars2.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The eyes color contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
		var casechanged=fld.value.toUpperCase();
        fld.value = casechanged; 
    }
    return error;
}
function validateAddress(fld) {
    var error = "";
    
   
   var illegalChars2= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Address.\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 50)) {
        fld.style.background = 'Yellow'; 
        error = "The Address is the wrong length.\n";
    } else if (illegalChars2.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The Address contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}
function validateCity(fld) {
    var error = "";
    
    var illegalChars2= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a City.\n";
    } else if ((fld.value.length < 4) || (fld.value.length > 25)) {
        fld.style.background = 'Yellow'; 
        error = "The City is the wrong length.\n";
    } else if (illegalChars2.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The City contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
		
    }
    return error;
}
function validateState(fld) {
    var error = "";
    
    var illegalChars2= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a State.\n";
    } else if ((fld.value.length < 2) || (fld.value.length > 25)) {
        fld.style.background = 'Yellow'; 
        error = "The State is the wrong length.\n";
    } else if (illegalChars2.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The State contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
		var casechanged=fld.value.toUpperCase();
        fld.value = casechanged; 
    }
    return error;
}
function validateZip(fld) {
    var error = "";
    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    
    
   if (fld.value == "") {
        error = "You didn't enter a Zip code.\n";
        fld.style.background = 'Yellow';
    } else if (isNaN(parseInt(stripped))) {
        error = "The Zip code contains illegal characters.\n";
        fld.style.background = 'Yellow';
   
	} else if ((stripped.length < 5) || (stripped.length > 9)) {
        error = "The Zip code is the wrong length.\n";
        fld.style.background = 'Yellow';
    } else {
        fld.style.background = 'White';
    }    
    return error;
}
function validateDriver_lic_num(fld,itisidbox,idnumfld) {
    var error = "";
    
    
    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
 
   if (itisidbox.checked == true && idnumfld.value != "" ) 
	{
	
	    fld.style.background = 'White';
      	
	}else if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a Driver Lic#.\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 30)) {
        fld.style.background = 'Yellow'; 
        error = "The Driver Lic# is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The Driver Lic# contains illegal characters.\n";   
	
	} else {
        fld.style.background = 'White';
        var casechanged=fld.value.toUpperCase();
        fld.value = casechanged; 
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
    } else {
        fld.style.background = 'White';
        
        fld.value =  stripped;
    }
    return error;
}
function validateContact(fld) {
    var error = "";
    
      var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/
 
    if (fld.value != "") { 
        if ((fld.value.length < 2) || (fld.value.length > 30)) {
            fld.style.background = 'Yellow'; 
            error = "The contact is the wrong length.\n";
        } else if (illegalChars.test(fld.value)) {
            fld.style.background = 'Yellow'; 
            error = "The conatct contains illegal characters.\n";
        } else {
            fld.style.background = 'White';
        }
     }   
   
    return error;
}
function validateEmail(fld) {
    var error="";
    var tfld = trim(fld.value);                        
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/
   
    if (fld.value != "") {
        if (!emailFilter.test(tfld)) {              
            fld.style.background = 'Yellow';
            error = "Please enter a valid email address.\n";
        } else if (illegalChars.test(fld.value)) {
            fld.style.background = 'Yellow';
            error = "The email address contains illegal characters.\n";
        } else {
            fld.style.background = 'White';
        }
      }  
    return error;
}
function validateOther(fld) {
    var error = "";
    
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/
 
    if (fld.value != "") {
        if ((fld.value.length < 2) || (fld.value.length > 100)) {
             fld.style.background = 'Yellow'; 
             error = "The contact is the wrong length.\n";
        } else if (illegalChars.test(fld.value)) {
             fld.style.background = 'Yellow'; 
             error = "The conatct contains illegal characters.\n";
        } else {
             fld.style.background = 'White';
        }
     }   
    return error;
}
function validateLicexpdate(fld) {
var error = "";
var today=new Date(); 
entered_Licexpdate = fld.value;
var dashorsalash = entered_Licexpdate.substring(2,3);


  if (fld.value == "") {
        error = "You didn't enter a Driver License expiration.\n";
        fld.style.background = 'Yellow';
  }else if (Date.parse(today) > Date.parse(fld.value)) {
    
    fld.style.background = 'red'; 
    error = "Driver License is Expired.\n";
  } else if (dashorsalash == "-") {
       fld.style.background = 'Yellow'; 
       error = "Driver License expiration date format MM/DD/YYYY.\n";
  } else {
     	fld.style.background = 'green'; 
      
    }  

return error;
}






function validateImageLic(fld) {
    var error = "";
    
    
 
    if (fld.value != "") {
        if ((fld.value.length < 5) || (fld.value.length > 80)) {
             fld.style.background = 'Yellow'; 
             error = "The image path is the wrong length.\n";
        
        } else {
             fld.style.background = 'White';
        }
     } else {
     	fld.style.background = 'Yellow'; 
      error = "Enter Driver Lic Image by browser.\n";
    }  
    return error;
  
    
}
function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}


function validateisaidbox(itisidbox,licfld,idfld,licstatefld,idstatefld,idtypefld) {

var error = "";
	if (
	itisidbox.checked == true && (idfld.value == "" || idfld.value == " " ) 
	) 
	{
	
	    idfld.style.background = 'Yellow';
        licstatefld.style.background = 'white';	

       if  (idstatefld.value == "" || idstatefld.value == " "){ 
            idstatefld.style.background = 'yellow';
       }else{
	         idstatefld.style.background = 'white';
	   }
	   
	   if (idtypefld.value == "" || idtypefld.value == " "){
	       idtypefld.style.background = 'yellow';
        }else{
		   idtypefld.style.background = 'white';
		}
		
       
		
		   idfld.value = licfld.value;
		   idfld.style.background = 'white';
		   
		   if (idfld.value == "" || idfld.value == " " || idstatefld.value == "" || idstatefld.value == " " || idtypefld.value == "" || idtypefld.value == " " )
		   { 
			error = "Enter ID Number.\n";
		   }
		   
		  
		
		 
		
		
		
	} else if (
	itisidbox.checked == true && (idstatefld.value == "" || idstatefld.value == " " )) 
	{
	
	    idstatefld.style.background = 'yellow';
		licstatefld.style.background = 'white';
        idfld.style.background = 'white';
        		
        if (idtypefld.value == "" || idtypefld.value == " "){
	         idtypefld.style.background = 'yellow';
        }else{		  
     		idtypefld.style.background = 'white';		
        }
		
		error = "Enter ID State.\n";
		
		
	} else if (
	itisidbox.checked == true && (idstatefld.value != "" || idstatefld.value != " " ) && ((idstatefld.value.length < 2) || (idstatefld.value.length > 2))) 
	{
	
	    idstatefld.style.background = 'yellow';
		licstatefld.style.background = 'white';
        idfld.style.background = 'white';
        
		if (idtypefld.value == "" || idtypefld.value == " "){
	         idtypefld.style.background = 'yellow';
        }else{		  
     		idtypefld.style.background = 'white';		
        }
		
		error = "ID state lenght wrong. Enter ID State Abbreviation.\n";
		
		
	} else if (
	itisidbox.checked == true && (idtypefld.value == "" || idtypefld.value == " " )) 
	{
	
	
		licstatefld.style.background = 'white';
        idfld.style.background = 'white';
        idtypefld.style.background = 'yellow';
		
		if  (idstatefld.value == "" || idstatefld.value == " "){ 
            idstatefld.style.background = 'yellow';
       }else{
	         idstatefld.style.background = 'white';
	   }
		
        error = "Enter ID Type.\n";
		
		
	} else if (
	      itisidbox.checked == false && (licstatefld.value != "" || licstatefld.value != " " || licstatefld.value != null) && ((licstatefld.value.length < 2) || (licstatefld.value.length > 2))) 
	{
	
	    licstatefld.style.background = 'Yellow';
        idfld.style.background = 'white';
		idtypefld.style.background = 'white';
		idstatefld.style.background = 'white';
		idfld.value = '';
	    idstatefld.value = '';
	    idtypefld.value = '';
        error = "Lic state lenght wrong. Enter Lic State Abbreviation.\n";
		
		
	


	










	}else {

         	
	    idfld.style.background = 'white'; 
		idtypefld.style.background = 'white';
		
		
		var casechangedidfld=idfld.value.toUpperCase();
	
		var casechangedlicstatefld=licstatefld.value.toUpperCase();
        idfld.value = casechangedidfld; 
       
		licstatefld.value = casechangedlicstatefld; 
        
	}
	return error;
}



</script>

</head>

<body>
	
<?php

include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/db_functions.php");
include ("../../classes/security_functions.php");
include ("../../classes/form.php");
include ("../../classes/display.php");
include ("../../classes/cryptastic.php");


$lang=new language();

$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);


$sec=new security_functions($dbf,'Sales Clerk',$lang);
$display= new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		
		
		       
		       echo "<center><FONT COLOR=blue><b> $cfg_company_city</b></FONT></center>";
			   echo "<br>";
               echo "<center><FONT COLOR=red><b> You are not logged in to the JEX System or Your IE Web Browser is not sharing session across windows.</b></FONT></center>";
               echo "<br><br>";
			   echo "<center><FONT COLOR=blue><b><u>Solutions</u></b></FONT></center>";
			   echo "<br><br>";
			   echo "<center><FONT COLOR=blue><b> Windows XP – </b></FONT>Open IE session and login to JEX POS System.</center>";
			   $storeloginurl=$cfg_storespage_url.'/'.$cfg_storeDirname;
			   echo "<center><a href=\"$storeloginurl\" target=\"_blank\">Goto store Login Page</a></center>";
               echo "<br><br>";
			   echo "<center><FONT COLOR=blue><b> Windows 7 - </b></FONT>Session sharing may not be working to resolve this you need to close all IE sessions.</center>";
               echo "<center> Open new session by pointing to IE icon and click right mouse button and then select 'Run as administrator' and login JEX System of your store.</center>";
			   echo "<br><br>";
               echo "<center><FONT COLOR=green><b> After taking the above action re-scan the ID. </b></FONT></center>";
			   
		exit();
}

$supplier_value='';
$address_value='';
$phone_number_value='';
$contact_value='';
$email_value='';
$other_value='';
$imagelic_value=''; 
$imagecust_value=''; 
$imagethumb_value=''; 
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
	$display->displayTitle("$lang->updateSupplier");
	 
	 $noimageupdate = "yes";
	 
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		
		   
		   $tablename = "$cfg_tableprefix".'suppliers';	
		   $result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$supplier_value=$row['supplier'];
		$firstname_value=$row['firstname'];
		$middlename_value=$row['middlename'];
		$lastname_value=$row['lastname'];
		$gender_value1=$row['gender'];
		
		
		
		
		
   
   
		
		$race_value1 = $row['race'];
		$dob_value1 = $row['dob'];
		$height_value1 = $row['height'];
		$weight_value1 = $row['weight'];
		$hair_color_value1 = $row['hair_color'];
		$eyes_color_value1 = $row['eyes_color'];
		
		$address_value1=$row['address'];
		$apartment_value1=$row['apartment'];
		
		$city_value1 = $row['city'];
		$state_value1 = $row['state'];
		$zip_value1 = $row['zip'];
		$driver_lic_num_value1 = $row['driver_lic_num'];
		$licstate_value1 = $row['licstate'];
		if ($row['itisid'] == 'Y'){$itisid_checked = 'checked'; }else {$itisid_checked = 'unchecked'; }
		$id_num_value1 = $row['idnumber'];
		$idstate_value1 = $row['idstate'];
		$idtype_value1 = $row['idtype'];
		$licexpdate_value1 = $row['licexpdate'];
		
		$phone_number_value=$row['phone_number'];
		$contact_value=$row['contact'];
		$email_value=$row['email'];
		$other_value=$row['other'];
		$imagelic_value=$row['imagelic']; 
		$imagecust_value=$row['imagecust']; 
		$imagethumb_value=$row['imagethumb']; 
		$bansupplier_value=$row['bansupplier']; 
		if ($row['bansupplier'] == 'Y'){$bansupplier_checked = 'checked';}
		
		$curimageLic=$imagelic_value;
		
		if ($cfg_data_outside_storedir == "yes"){
            $curimageLic=$cfg_data_supplierIMGpathdir.$curimageLic;
	        
        }else{
	        $curimageLic="images/".$curimageLic;
	        
        }
		

if ($cfg_dencrypt == "yes")
 {
       
       $cryptastic = new cryptastic;

        $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
               die("Failed to generate secret key.");




           if (($gender_value1 != "") and ($gender_value1 != " ")){  
				$gender_decryption="ok";
				$decryptedgender = $cryptastic->decrypt($gender_value1, $key, true) or
                              
			                  $gender_decryption="Failed to complete decryption of gender";
							  
					 if ($gender_decryption == "ok"){
	                       $gender_value=$decryptedgender;		
					}else{
					     echo "<center><b><font color='red'>$gender_decryption</font></b></center>";
	                     $gender_value=$gender_value1;
					}
			}else{
						$gender_value=$gender_value1;
			}
			
			if (($height_value1 != "") and ($height_value1 != " ")){ 
				$height_decryption="ok";
				$decryptedheight = $cryptastic->decrypt($height_value1, $key, true) or
                               
			                   $height_decryption="Failed to complete decryption of height";
					
					if ($height_decryption == "ok"){
	                      $height_value=$decryptedheight;		
					}else{
					     echo "<center><b><font color='red'>$height_decryption</font></b></center>";
	                     $height_value=$height_value1;
					}	   
			}else{
					$height_value=$height_value1;
			}
			
			if (($weight_value1 != "") and ($weight_value1 != " ")){ 
				$weigh_decryption="ok";
				$decryptedweight = $cryptastic->decrypt($weight_value1, $key, true) or
                               
			                   $weigh_decryption="Failed to complete decryption of weight";
			       
				   if ($weigh_decryption == "ok"){
	                     $weight_value=$decryptedweight;		
					}else{
					     echo "<center><b><font color='red'>$weigh_decryption</font></b></center>";
	                    $weight_value=$weight_value1;
					}
			}else{
					$weight_value=$weight_value1;
			}
			
			if (($hair_color_value1 != "") and ($hair_color_value1 != " ")){
				$haircolor_decryption="ok";
				$decryptedhaircolor = $cryptastic->decrypt($hair_color_value1, $key, true) or
                                  
			                      $haircolor_decryption="Failed to complete decryption of hair color";
			
			        if ($haircolor_decryption == "ok"){
	                    $hair_color_value=$decryptedhaircolor;		
					}else{
					    echo "<center><b><font color='red'>$haircolor_decryption</font></b></center>";
	                    $hair_color_value=$hair_color_value1;
					}	
			}else{
					$hair_color_value=$hair_color_value1;
			}
			
			if (($eyes_color_value1 != "") and ($eyes_color_value1 != " ")){
				$eyescolor_decryption="ok";
				$decryptedeyescolor = $cryptastic->decrypt($eyes_color_value1, $key, true) or
                                  
			                      $eyescolor_decryption="Failed to complete decryption of eyes color";
								  
					if ($eyescolor_decryption == "ok"){
	                    $eyes_color_value=$decryptedeyescolor;		
					}else{
					    echo "<center><b><font color='red'>$eyescolor_decryption</font></b></center>";
	                    $eyes_color_value=$eyes_color_value1;
					}
			}else{
					$eyes_color_value=$eyes_color_value1;
			}
			
			if (($race_value1 != "") and ($race_value1 != " ")){
				$race_decryption="ok";
				$decryptedrace = $cryptastic->decrypt($race_value1, $key, true) or
                            
			                $race_decryption="Failed to complete decryption of race";
							
					if ($race_decryption=="ok"){
	                    $race_value=$decryptedrace;		
					}else{
					    echo "<center><b><font color='red'>$race_decryption</font></b></center>";
	                    $race_value=$race_value1;
					}
			}else{
					$race_value=$race_value1;
			}
			
			if (($driver_lic_num_value1 != "") and ($driver_lic_num_value1 != " ")){
				$licnum_decryption="ok";
				$decryptedlic = $cryptastic->decrypt($driver_lic_num_value1, $key, true) or
                           
			               $licnum_decryption="Failed to complete decryption of Lic Number";
						
						
					if ($licnum_decryption=="ok"){
	                    $driver_lic_num_value=$decryptedlic;
					}else{
					    echo "<center><b><font color='red'>$licnum_decryption</font></b></center>";
	                    $driver_lic_num_value=$driver_lic_num_value1;
					}
			}else{
					$driver_lic_num_value=$driver_lic_num_value1;
			}
			
			
		  if (($licstate_value1 != "") and ($licstate_value1 != " ")){
                $licstate_decryption="ok";
				$decryptedlicstate = $cryptastic->decrypt($licstate_value1, $key, true) or
                           
			               $licstate_decryption="Failed to complete decryption of Lic State";
                
				if ($licstate_decryption=="ok"){
	                   $licstate_value=$decryptedlicstate;
				}else{
					echo "<center><b><font color='red'>$licstate_decryption</font></b></center>";
	                $licstate_value=$licstate_value1;
				}		
                       
						   
			}else{
                $decryptedlicstate = $licstate_value1; 
            }
			


 		    if (($id_num_value1 != "") and ($id_num_value1 != " ")){ 
						$idnum_decryption="ok";
                       $decryptedidnumber = $cryptastic->decrypt($id_num_value1, $key, true) or
                                        
			                           $idnum_decryption="Failed to complete decryption of ID Number";
					
					if ($idnum_decryption=="ok"){
	                   $id_num_value=$decryptedidnumber;	
				   }else{
					   echo "<center><b><font color='red'>$idnum_decryption</font></b></center>";
	                   $id_num_value=$id_num_value1;
				    }						   
									   
									   
		    }else{
                $decryptedidnumber = $id_num_value1; 
            }							  
							  
			
            if (($idstate_value1 != "") and ($idstate_value1 != " ")){
							$idstate_decryption="ok";
                            $decryptedidstate = $cryptastic->decrypt($idstate_value1, $key, true) or
                                          
			                              $idstate_decryption="Failed to complete decryption of ID State";
			
        			if ($idstate_decryption=="ok"){
	                     $idstate_value=$decryptedidstate;	
			    	}else{
				    	echo "<center><b><font color='red'>$idstate_decryption</font></b></center>";
	                    $idstate_value=$idstate_value1;
				    }						  
										  
			}else{
                $decryptedidstate = $idstate_value1; 
            }	

			
			if (($idtype_value1 != "") and ($idtype_value1 != " ")){
							$idtype_decryption="ok";
                            $decryptedidtype = $cryptastic->decrypt($idtype_value1, $key, true) or
                                          
			                              $idtype_decryption="Failed to complete decryption of ID Type";
			
                			if ($idtype_decryption=="ok"){
	                            $idtype_value=$decryptedidtype;	
				            }else{
					            echo "<center><b><font color='red'>$idtype_decryption</font></b></center>";
	                        $idtype_value=$idtype_value1;
				            }
			
			}else{
                $decryptedidtype = $idtype_value1; 
         }	
		 
		 
			if (($apartment_value1 != "") and ($apartment_value1 != " ")){
							$apartment_decryption="ok";
                            $decryptedapartment = $cryptastic->decrypt($apartment_value1, $key, true) or
                                          
			                              $apartment_decryption="Failed to complete decryption of Apartment";
				
				         if ($apartment_decryption=="ok"){
	                         $apartment_value=$decryptedapartment;	
				         }else{
					        echo "<center><b><font color='red'>$apartment_decryption</font></b></center>";
	                        $apartment_value=$apartment_value1;
				         }
				
				
			 }else{
                $decryptedapartment = $apartment_value1; 
			}
			
			if (($licexpdate_value1 != "") and ($licexpdate_value1 != " ")){
				$licexpdate_decryption="ok";
				$decryptedlicexpdate = $cryptastic->decrypt($licexpdate_value1, $key, true) or
                                   
                                   $licexpdate_decryption="Failed to complete decryption of Lic exp date";
			
              			if ($licexpdate_decryption=="ok"){
	                           $licexpdate_value=$decryptedlicexpdate;	
				        }else{
					          echo "<center><b><font color='red'>$licexpdate_decryption</font></b></center>";
	                          $licexpdate_value=$licexpdate_value1;
				        }
			}else{
					$licexpdate_value=$licexpdate_value1;
			}
			
			if (($dob_value1 != "") and ($dob_value1 != " ")){
				$dob_decryption="ok"; 
				$decrypteddob = $cryptastic->decrypt($dob_value1, $key, true) or
                           
                           $dob_decryption="Failed to complete decryption of DOB";
			
        			if ($dob_decryption=="ok"){
	                    $dob_value=$decrypteddob;
			    	}else{
				    	echo "<center><b><font color='red'>$dob_decryption</font></b></center>";
	                    $dob_value=$dob_value1;
				    }
			}else{
					$dob_value=$dob_value1;
			}
			
			if (($address_value1 != "") and ($address_value1 != " ")){
				$address_decryption="ok";  
				$decryptedaddress = $cryptastic->decrypt($address_value1, $key, true) or
                                
			                    $address_decryption="Failed to complete decryption of Address";
			
				      if ($address_decryption=="ok"){
	                       $address_value=$decryptedaddress;
				      }else{
					       echo "<center><b><font color='red'>$address_decryption</font></b></center>";
	                       $address_value=$address_value1;
				      }
			}else{
					$address_value=$address_value1;
			}
			
			if (($city_value1 != "") and ($city_value1 != " ")){
				$city_decryption="ok";
				$decryptedcity = $cryptastic->decrypt($city_value1, $key, true) or
                            
							$city_decryption="Failed to complete decryption of City";
							
			    	if ($city_decryption=="ok"){
	                    $city_value=$decryptedcity;
				   }else{
					   echo "<center><b><font color='red'>$city_decryption</font></b></center>";
	                  $city_value = $city_value1;
				   }
			}else{
					$city_value = $city_value1;
			}
			
			if (($state_value1 != "") and ($state_value1 != " ")){
				$state_decryption="ok";	
				$decryptedstate = $cryptastic->decrypt($state_value1, $key, true) or
                             
							 $state_decryption="Failed to complete decryption of State";
			
			          if ($state_decryption=="ok"){
	                      $state_value=$decryptedstate;
				      }else{
					       echo "<center><b><font color='red'>$state_decryption</font></b></center>";
	                       $state_value = $state_value1;
					}
			}else{
					$state_value = $state_value1;
			}
			
			if (($zip_value1 != "") and ($zip_value1 != " ")){
				$zip_decryption="ok";
				$decryptedzip = $cryptastic->decrypt($zip_value1, $key, true) or
                           
						   $zip_decryption="Failed to complete decryption of Zip";
						   
			        if ($zip_decryption=="ok"){
	                    $zip_value=$decryptedzip;
				    }else{
					    echo "<center><b><font color='red'>$zip_decryption</font></b></center>";
	                    $zip_value = $zip_value1;
				    }
			}else{
					$zip_value = $zip_value1;
			}
			
		

		
	
		


}else{

$gender_value=$gender_value1;
$race_value=$race_value1;
$height_value=$height_value1;
$weight_value=$weight_value1;
$hair_color_value=$hair_color_value1;
$eyes_color_value=$eyes_color_value1;
$dob_value=$dob_value1;
$driver_lic_num_value=$driver_lic_num_value1;
$licstate_value=$licstate_value1;
$id_num_value=$id_num_value1;
$idstate_value=$idstate_value1;
$idtype_value=$idtype_value1;
$licexpdate_value=$licexpdate_value1;

$address_value=$address_value1;
$apartment_value=$apartment_value1;
$city_value = $city_value1;
$state_value = $state_value1;
$zip_value = $zip_value;		



}
 






	  
	  $dob_value = str_replace("/", "", "$dob_value");
      $dob_value = str_replace("-", "", "$dob_value");
	
	  $dob_year = substr("$dob_value",0,4);
	  $dob_month = substr("$dob_value",4,2);
      $dob_day = substr("$dob_value",6,2);
 
      $dob_value=$dob_month.'/'.$dob_day.'/'.$dob_year;
	
	 
	  $licexpdate_value = str_replace("/", "", "$licexpdate_value");
      $licexpdate_value = str_replace("-", "", "$licexpdate_value");
	
	  $licexpdate_year = substr("$licexpdate_value",0,4);
	  $licexpdate_month = substr("$licexpdate_value",4,2);
      $licexpdate_day = substr("$licexpdate_value",6,2);
 
      $licexpdate_value=$licexpdate_month.'/'.$licexpdate_day.'/'.$licexpdate_year;
	
	


	
	}

}
else
{
	$display->displayTitle("$lang->addSupplier");

}















if (isset($_GET['fromupdatelink']))
{
$fromupdatelinkval=$_GET['fromupdatelink'];
$varfromupdatelink='fromupdatelink='."$fromupdatelinkval";
}

$f1=new form('return validateFormOnSubmit(this)',"process_form_suppliers.php?$varfromupdatelink",'POST','suppliers','300',$cfg_theme,$lang);



$f1->createInputField("<b>$lang->firstName:</b>",'text','firstname',"$firstname_value",'24','150');
$f1->createInputField("<b>$lang->middleName:</b>",'text','middlename',"$middlename_value",'24','150');
$f1->createInputField("<b>$lang->lastName:</b>",'text','lastname',"$lastname_value",'24','150');


  
  
 
  

 if ($gender_value == "null" or $gender_value == " " or $gender_value == ""){
   $gender_option_titles[0] = "";
   $gender_option_values[0] = 'null';
}else{
   $gender_option_titles[0] = "$gender_value";
   $gender_option_values[0] = "$gender_value";
}   
$gender_option_titles[1] = "MALE";
$gender_option_values[1] = 'MALE';
$gender_option_titles[2] = "FEMALE";
$gender_option_values[2] = 'FEMALE'; 


if ($cfg_supplier_form_gender == "disable"){
  
 echo "<input type='hidden' name='gender' value='$gender_value'>";
}else if ($cfg_supplier_form_gender == "enabled_not_required"){

 $f1->createSelectField("$lang->gender:",'gender',$gender_option_values,$gender_option_titles,'160');
}else{
$f1->createSelectField("<b>$lang->gender:</b>",'gender',$gender_option_values,$gender_option_titles,'160');
} 
  
  
if ($race_value == "null" or $race_value == " " or $race_value == ""){
   $race_option_titles[0] = "";
   $race_option_values[0] = 'null';
}else{
   $race_option_titles[0] = "$race_value";
   $race_option_values[0] = "$race_value";
}   
$race_option_titles[1] = "WHITE/NON-HISPANIC";
$race_option_values[1] = 'WHITE/NON-HISPANIC';
$race_option_titles[2] = "BLACK";
$race_option_values[2] = 'BLACK';
$race_option_titles[3] = "INDIAN";
$race_option_values[3] = 'INDIAN';
$race_option_titles[4] = "ASIAN";
$race_option_values[4] = 'ASIAN';
$race_option_titles[5] = "HISPANIC";
$race_option_values[5] = 'HISPANIC';
$race_option_titles[6] = "OTHER";
$race_option_values[6] = 'OTHER';
$race_option_titles[7] = "UNKNOWN";
$race_option_values[7] = 'UNKNOWN';




if ($cfg_supplier_form_race == "disable"){

 echo "<input type='hidden' name='race' value='$race_value'>";
}else if ($cfg_supplier_form_race == "enabled_not_required"){
 $f1->createSelectField("Race:",'race',$race_option_values,$race_option_titles,'160');
}else{
$f1->createSelectField("<b>Race:</b>",'race',$race_option_values,$race_option_titles,'160');
}
  
  
  
  $f1->createInputField("<b>$lang->supplierDOB:</b>",'text','dob',"$dob_value",'24','150');
  
if ($cfg_supplier_form_height == "disable"){
     
 echo "<input type='hidden' name='height' value='$height_value'>";
  }else if ($cfg_supplier_form_height == "enabled_not_required"){
$f1->createInputField("$lang->supplierHeight:",'text','height',"$height_value",'24','150');
}else{
$f1->createInputField("<b>$lang->supplierHeight:</b>",'text','height',"$height_value",'24','150');
} 

   if ($cfg_supplier_form_weight == "disable"){
     
      echo "<input type='hidden' name='weight' value='$weight_value'>";
      
   }else if ($cfg_supplier_form_weight == "enabled_not_required"){
      $f1->createInputField("$lang->supplierWeight:",'text','weight',"$weight_value",'24','150');
   }else{
      $f1->createInputField("<b>$lang->supplierWeight:</b>",'text','weight',"$weight_value",'24','150');
   } 

  if ($cfg_supplier_form_haircolor == "disable"){
     
     echo "<input type='hidden' name='hair_color' value='$hair_color_value'>";
 }else if ($cfg_supplier_form_haircolor == "enabled_not_required"){
  $f1->createInputField("$lang->supplierHair:",'text','hair_color',"$hair_color_value",'24','150');
}else{
 $f1->createInputField("<b>$lang->supplierHair:</b>",'text','hair_color',"$hair_color_value",'24','150');
 }

if ($cfg_supplier_form_eyecolor == "disable"){
     
     echo "<input type='hidden' name='eyes_color' value='$eyes_color_value'>";
 }else if ($cfg_supplier_form_eyecolor == "enabled_not_required"){
      $f1->createInputField("$lang->supplierEyes:",'text','eyes_color',"$eyes_color_value",'24','150');
}else{
	$f1->createInputField("<b>$lang->supplierEyes:</b>",'text','eyes_color',"$eyes_color_value",'24','150');
	  }



$f1->createInputField("<b>$lang->address:</b>",'text','address',"$address_value",'24','150');
$f1->createInputField("Apartment:",'text','apartment',"$apartment_value",'24','150');

  $f1->createInputField("<b>$lang->city:</b>",'text','city',"$city_value",'24','150');
  $f1->createInputField("<b>$lang->state:</b>",'text','state',"$state_value",'24','150');
  $f1->createInputField("<b>$lang->zip:</b>",'text','zip',"$zip_value",'24','150');
  $f1->createInputField("<b>$lang->licensenum:</b>",'text','driver_lic_num',"$driver_lic_num_value",'24','150');
  $f1->createInputField("<b>DL State:</b>",'text','licstate',"$licstate_value",'24','150');
  $f1->createInputField("It is a ID:",'checkbox','itisid',"Y",'10','160',"$itisid_checked");
  $f1->createInputField("<b>ID Number:</b>",'text','id_num',"$id_num_value",'24','150');
  $f1->createInputField("<b>ID State:</b>",'text','idstate',"$idstate_value",'24','150');
  $f1->createInputField("<b>ID Type:</b>",'text','idtype',"$idtype_value",'24','150');
  $f1->createInputField("<b>$lang->licExpDate:</b>",'text','licexpdate',"$licexpdate_value",'24','150');
  
 
  
  
  	



$f1->createInputField("<b>$lang->phoneNumber:</b>",'text','phone_number',"$phone_number_value",'24','150');
$f1->createInputField("$lang->contact:",'text','contact',"$contact_value",'24','150');

$f1->createInputField("$lang->email: ",'text','email',"$email_value",'24','150');
$f1->createInputField("$lang->other: ",'text','other',"$other_value",'24','150');

$f1->createInputField("<b>DriverLicPic: </b>",'file','imagelic',"$imagelic_value",'24','150'); 

if ($cfg_enableimageupload_person=="yes"and $cfg_imagesnapmethod=="pc"){
$f1->createInputField("CustomerPic: ",'file','imagecust',"$imagecust_value",'24','150'); 
}

if ($cfg_fingerprint_onpdf!="no"){
  $f1->createInputField("CustThumbPic: ",'file','imagethumb',"$imagethumb_value",'24','150'); 
}
if ($usertype=="Admin"){
    $f1->createInputField("Ban Supplier:",'checkbox','bansupplier',"Y",'10','160',"$bansupplier_checked");
}


echo "		
		<input type='hidden'  name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>
		<input type='hidden' name='supplier' value='$supplier_value'>";
$f1->endForm();




$dbf->closeDBlink();



?>

<?php  ?>

</body>


<script language="javascript" defer type="text/javascript">

</script>


</html>	





