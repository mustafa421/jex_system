<?php session_start();?>

<html>
<head>
<script>
  function closewindow() {
    window.close();
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
include ("../../classes/resizeimage.php");
include ("../../classes/cryptastic.php");


$cfg_common_supplierNcustomers_allstores='no';


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
if ($cfg_common_supplierNcustomers_allstores == "yes"){
$commondbf=new db_functions($cfg_server,$cfg_commondbuser,$cfg_commondbpwd,$cfg_commondbname,$cfg_tableprefix,$cfg_theme,$lang);
}

$sec=new security_functions($dbf,'Sales Clerk',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../../login.php");
	exit ();
}


if ($cfg_common_supplierNcustomers_allstores == "yes"){
   $tablename='suppliers';
   $customer_tablename='customers';
}else{
  $tablename="$cfg_tableprefix".'suppliers';
  $customer_tablename="$cfg_tableprefix".'customers';
}

$field_names=null;
$field_data=null;
$id=-1;


	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];
	}
	
	elseif(isset($_POST['supplier']) and isset($_POST['address']) and isset($_POST['phone_number']) and isset($_POST['contact']) and isset($_POST['email']) and isset($_POST['other']) and isset($_POST['id']) and isset($_POST['action']) )
	{
		
		$action=$_POST['action'];
		$id = $_POST['id'];
		
		$workingid = $id; 
		
		
		
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		
		$supplier=$firstname.' '.$middlename.' '.$lastname; 
		$gender1 = $_POST['gender'];
		$phone_number=$_POST['phone_number'];
		$address1 = $_POST['address'];
		$apartment1 = $_POST['apartment'];
		$city1 = $_POST['city'];
		$state1 = $_POST['state'];
		$zip1 = $_POST['zip'];
		$contact = $_POST['contact'];
		$email = $_POST['email'];
		$other = $_POST['other'];
		
		
		
		$race1 = $_POST['race'];
		$dob = $_POST['dob'];
		$height1 = $_POST['height'];
		$weight1 = $_POST['weight'];
		$hair_color1 = $_POST['hair_color'];
		$eyes_color1 = $_POST['eyes_color'];
		$driver_lic_num1 = $_POST['driver_lic_num'];
		$licstate1 = $_POST['licstate'];
		if ($_POST['itisid'] == ''){$itisid = 'N'; }else {$itisid = $_POST['itisid']; }
		$idnum1 = $_POST['id_num'];
	    $idstate1 = $_POST['idstate'];
		$idtype1 = $_POST['idtype'];
		$licexpdate = $_POST['licexpdate'];
		$licimage = $_FILES['imagelic']['name'];
		$custimage = $_FILES['imagecust']['name'];
		$thumbimage = $_FILES['imagethumb']['name'];
		$bansupplier = $_POST['bansupplier'];
		if ($_POST['bansupplier'] == ''){$bansupplier = 'N';}
		
		


       $cust_address1 = $address1 . ' ' . $city1 . ' ' . $state1 . ' ' . $zip1;
 

	
   
    $todays_date = date("Y-m-d");
 
 
 

 

 
 
 
 $dob = str_replace("/", "", "$dob");
 $dob = str_replace("-", "", "$dob");
 $dob_month = substr("$dob",0,2);
 $dob_day = substr("$dob",2,2);
 $dob_year = substr("$dob",4,4);
 $dob1=$dob_year.$dob_month.$dob_day;







 $licexpdate = str_replace("/", "", "$licexpdate");
 $licexpdate = str_replace("-", "", "$licexpdate");
 $licexpdate_month = substr("$licexpdate",0,2);
 $licexpdate_day = substr("$licexpdate",2,2);
 $licexpdate_year = substr("$licexpdate",4,4);
 $licexpdate1=$licexpdate_year.$licexpdate_month.$licexpdate_day;
 


$licexpdate2=$licexpdate_year.'-'.$licexpdate_month.'-'.$licexpdate_day;
$today = strtotime($todays_date);
$expiration_date = strtotime($licexpdate2);

if ($expiration_date > $today) {
     $licvalid = "yes";
} else {
     $licvalid = "no";
}

 
 if ($cfg_encrypt == "yes")
 {

      
	   $AbleToecrypt="yes";
       $cryptastic = new cryptastic;

       $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
                  die("Failed to generate secret key.");
        
		 if (($gender1 != "") and ($gender1 != " ")){ 
				$encryptedgender = $cryptastic->encrypt($gender1, $key, true) or
                           
				           $AbleToecrypt= "Failed to complete gender encryption.";
		}else{
				$encryptedgender = $gender1;
		}
		
		if (($race1 != "") and ($race1 != " ")){ 
				$encryptedrace = $cryptastic->encrypt($race1, $key, true) or
                         
                         $AbleToecrypt= "Failed to complete Race encryption.";
		}else{
				$encryptedrace = $race1;
		}
		
		$encrypteddob = $cryptastic->encrypt($dob1, $key, true) or
                        
				        $AbleToecrypt= "Failed to complete DOB encryption.";
			
		if (($height1 != "") and ($height1 != " ")){ 
				$encryptedheight = $cryptastic->encrypt($height1, $key, true) or
                           
                           $AbleToecrypt= "Failed to complete height encryption.";
		}else{
				$encryptedheight = $height1;
		}
		
		if (($weight1 != "") and ($weight1 != " ")){ 
				$encryptedweight = $cryptastic->encrypt($weight1, $key, true) or
                           
						   $AbleToecrypt= "Failed to complete weight encryption.";
		}else{
				$encryptedweight = $weight1;
		}
		
		if (($hair_color1 != "") and ($hair_color1 != " ")){ 
				$encryptedhaircolor = $cryptastic->encrypt($hair_color1, $key, true) or
                              
							  $AbleToecrypt= "Failed to complete hair color encryption.";
		}else{
				$encryptedhaircolor = $hair_color1;
		}
		
		if (($eyes_color1 != "") and ($eyes_color1 != " ")){
				$encryptedeyescolor = $cryptastic->encrypt($eyes_color1, $key, true) or
                              
                              $AbleToecrypt= "Failed to complete eyes color encryption."; 
		}else{
					$encryptedeyescolor = $eyes_color1;
		}
       $encryptedlic = $cryptastic->encrypt($driver_lic_num1, $key, true) or
                       
					   $AbleToecrypt= "Failed to complete DL encryption.";
		
       if (($licstate1 != "") and ($licstate1 != " ")){ 		
            	   $encryptedlicstate = $cryptastic->encrypt($licstate1, $key, true) or
                                  
			            		   $AbleToecrypt= "Failed to complete Lic State encryption.";
		}else{
		       $encryptedlicstate = $licstate1; 
		}


		if (($idnum1 != "") and ($idnum1 != " ")){ 
	               $encryptedidnumber = $cryptastic->encrypt($idnum1, $key, true) or
                                      
					                 $AbleToecrypt= "Failed to complete ID Number encryption.";
		}else{
		       $encryptedidnumber = $idnum1; 
		}							 
									 
		
        if (($idstate1 != "") and ($idstate1 != " ")){							   
	                 $encryptedidstate = $cryptastic->encrypt($idstate1, $key, true) or
                                       
					                  $AbleToecrypt= "Failed to complete ID State encryption.";
		}else{
		       $encryptedidstate = $idstate1; 
		}	
		
		
		
		if (($idtype1 != "") and ($idtype1 != " ")){							   
	                 $encryptedidtype = $cryptastic->encrypt($idtype1, $key, true) or
                                       
					                  $AbleToecrypt= "Failed to complete ID Type encryption.";
		}else{
		       $encryptedidtype = $idtype1; 
		}	
		
		
		
		if (($apartment1 != "") and ($apartment1 != " ")){ 
	                 $encryptedapartment = $cryptastic->encrypt($apartment1, $key, true) or
                                       
					                  $AbleToecrypt= "Failed to complete Apartment encryption.";
		}else{
		       $encryptedapartment = $apartment1; 
		}	
		
		if (($licexpdate1 != "") and ($licexpdate1 != " ")){   
				$encryptedlicexpdate = $cryptastic->encrypt($licexpdate1, $key, true) or
                               
                               $AbleToecrypt= "Failed to complete DL Exp Date encryption.";							   
		}else{
				$encryptedlicexpdate = $licexpdate1;
		}
	
     

		if (($address1 != "") and ($address1 != " ")){
				$encryptedaddress = $cryptastic->encrypt($address1, $key, true) or
                            
                            $AbleToecrypt= "Failed to complete Address encryption.";	
		}else{
				$encryptedaddress = $address1;
		}

		if (($city1 != "") and ($city1 != " ")){
				$encryptedcity = $cryptastic->encrypt($city1, $key, true) or
                         
						$AbleToecrypt= "Failed to complete City encryption.";
		}else{
				$encryptedcity = $city1;
		}

		if (($state1 != "") and ($state1 != " ")){
				$encryptedstate = $cryptastic->encrypt($state1, $key, true) or
                          
							$AbleToecrypt= "Failed to complete State encryption.";
		}else{
				$encryptedstate = $state1;
		}
		
		if (($zip1 != "") and ($zip1 != " ")){
				$encryptedzip = $cryptastic->encrypt($zip1, $key, true) or
                        
						$AbleToecrypt= "Failed to complete Zip encryption.";
		}else{
				$encryptedzip = $zip1;
		}
		
		if (($cust_address1 != "") and ($cust_address1 != " ")){
				$encryptedcustaddress = $cryptastic->encrypt($cust_address1, $key, true) or
                                
                                $AbleToecrypt= "Failed to complete Cust_address encryption.";								
		}else{
				$encryptedcustaddress = $cust_address1;
		}





     
     

     
     

	 
	if ($AbleToecrypt == "yes")
	   {
          $gender=$encryptedgender;
          $race=$encryptedrace;	 
          $dob=$encrypteddob;
          $height=$encryptedheight;
          $weight=$encryptedweight;
          $hair_color=$encryptedhaircolor;
          $eyes_color=$encryptedeyescolor;	 
          $driver_lic_num=$encryptedlic;
		  $licstate=$encryptedlicstate;
		  $idnum=$encryptedidnumber;
          $idstate=$encryptedidstate;
		  $idtype=$encryptedidtype;
          $licexpdate=$encryptedlicexpdate;
          
          $address = $encryptedaddress;
		  $apartment = $encryptedapartment;
          $city = $encryptedcity;
          $state = $encryptedstate;
          $zip = $encryptedzip;
          $cust_address= $encryptedcustaddress;
        }else{
		     echo "<center><b><font color='red'>$AbleToecrypt</font></b></center>";
		     $gender=$gender1;
             $race=$race1;
             $dob=$dob1;
             $height=$height1;
             $weight=$weight1;
             $hair_color=$hair_color1;
             $eyes_color=$eyes_color1;
             $driver_lic_num=$driver_lic_num1;
			 $licstate=$licstate1;
		     $idnum=$idnum1;
	         $idstate=$idstate1;
		     $idtype=$idtype1;
             $licexpdate=$licexpdate1;
             
             $address = $address1;
			 $apartment = $apartment1;
             $city = $city1;
             $state = $state1;
             $zip = $zip1;
             $cust_address= $cust_address1;
		}


}else{

$gender=$gender1;
$race=$race1;
$dob=$dob1;
$height=$height1;
$weight=$weight1;
$hair_color=$hair_color1;
$eyes_color=$eyes_color1;
$driver_lic_num=$driver_lic_num1;
$licstate=$licstate1;
$idnum=$idnum1;
$idstate=$idstate1;
$idtype=$idtype1;
$licexpdate=$licexpdate1;

$address = $address1;
$apartment = $apartment1;
$city = $city1;
$state = $state1;
$zip = $zip1;
$cust_address= $cust_address1;
}

 







ob_implicit_flush(true);
echo "\n"; 

echo "<center><img src=\"../../je_images/processingdata.gif\" ></center>";
echo "\n"; 
echo "\n"; 

for($i=0; $i<8; $i++) {
    
    echo "<span style='width:20px; background:white'></span>";
	
	
    
    
    for($k = 0; $k < 40000; $k++)

        echo ' '; 

}
echo "\n"; 


function imageupload($uploadstr,$str2){
	include ("../../settings.php"); 
	include ("../../../../../$cfg_configfile"); 
	$imagenewname=$str2;
	
	
	
	
	

 define ("MAX_SIZE","3000"); 


 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }




 $errors=0;

 if(isset($_POST['Submit'])) 
 {
 	
 	
 
     $imagelic=$_FILES['imagelic']['name'];
   

     $imagecust=$_FILES['imagecust']['name'];
   
   
     $imagethumb=$_FILES['imagethumb']['name'];
 
    $process_image_load = 'no'; 
    if ($imagelic != "" or  $imagecust != "" or $imagethumb <> "")
       {
       	$process_image_load = 'yes';
       }	
 
 
 
 
 	
 	if ($process_image_load == "yes") 
 	{
 	
 	
 	  
 	     $filename = stripslashes($_FILES['imagelic']['name']);
 	     $filename2 = stripslashes($_FILES['imagecust']['name']);
 	     $filename3 = stripslashes($_FILES['imagethumb']['name']);
   
 	
 
 	
 	
  		  $extension = getExtension($filename);
 		  $extension = strtolower($extension);
 		  
 		  $extension2 = getExtension($filename2);
 		  $extension2 = strtolower($extension2);
 		  
 		  $extension3 = getExtension($filename3);
 		  $extension3 = strtolower($extension3);
 		  
 	
	
  
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "bmp") && ($imagelic != "")) 
 		{
		
 			echo '<h1>Unknown extension! Record NOT Loaded - Please try again by clicking Browser back button</h1>';
 			$errors=1;
 			exit;
 		}else
 		   if (($extension2 != "jpg") && ($extension2 != "jpeg") && ($extension2 != "png") && ($extension2 != "gif") && ($extension2 != "bmp") && ($imagecust != "")) 
 		{
		
 			echo '<h1>Unknown extension! Record NOT Loaded - Please try again by clicking Browser back button</h1>';
 			$errors=1;
 			exit;
 		}else
 		 if (($extension3 != "jpg") && ($extension3 != "jpeg") && ($extension3 != "png") && ($extension3 != "gif") && ($extension3 != "bmp") && ($imagethumb != "")) 
 		{
		
 			echo '<h1>Unknown extension! Record NOT Loaded - Please try again by clicking Browser back button</h1>';
 			$errors=1;
 			exit;
 		}
 		else
 		{

 
 
     
     
       $size=filesize($_FILES['imagelic']['tmp_name']);
     
     
       $size2=filesize($_FILES['imagecust']['tmp_name']);
     
     
       $size3=filesize($_FILES['imagethumb']['tmp_name']);
    
 
 
 



if ($size > MAX_SIZE*1024)
{
	echo '<h1>You have exceeded the size limit for Lic image!</h1>';
	$errors=1;
	exit;
} else if ($size2 > MAX_SIZE*1024){
	echo '<h1>You have exceeded the size limit for Supplier image!</h1>';
	$errors=1;
	exit;
}else if ($size3 > MAX_SIZE*1024){
	echo '<h1>You have exceeded the size limit for FingerPrint image!</h1>';
	$errors=1;
	exit;
}



$image_name=$imagenewname.'l'.'.'.$extension; 

$image_name2=$imagenewname.'p'.'.'.$extension2; 
	
$image_name3=$imagenewname.'t'.'.'.$extension3; 


if ($filename != ""){
   
   if ($cfg_data_outside_storedir == "yes"){
     $newnamepath=$cfg_data_supplierIMGpathdir.$image_name;
	 $imagelocation=$cfg_data_supplierIMGpathdir;
	 $newnamepathtemp=$cfg_data_supplierIMGpathdirtemp.$image_name;
	 $imagelocationtemp=$cfg_data_supplierIMGpathdirtemp;
   }else{
	 $newnamepath="images/".$image_name;
	 $imagelocation='images/';
	 $newnamepathtemp="images/temp/".$image_name;
	 $imagelocationtemp='images/temp/';
   }
}else{$newnamepath='';}

if ($filename2 != ""){
  if ($cfg_data_outside_storedir == "yes"){
     $newnamepath2=$cfg_data_supplierIMGpathdir.$image_name2;
	 $imagelocation=$cfg_data_supplierIMGpathdir;
	 $newnamepath2temp=$cfg_data_supplierIMGpathdirtemp.$image_name2;
	 $imagelocationtemp=$cfg_data_supplierIMGpathdirtemp;
  }else{
	 $newnamepath2="images/".$image_name2;
	 $imagelocation='images/';
	 $newnamepath2temp="images/temp/".$image_name2;
	 $imagelocationtemp='images/temp/';
  } 
}else{$newnamepath2='';}


if ($filename3 != ""){
   if ($cfg_data_outside_storedir == "yes"){
      $newnamepath3=$cfg_data_supplierIMGpathdir.$image_name3;
	  $imagelocation=$cfg_data_supplierIMGpathdir;
	   $newnamepath3temp=$cfg_data_supplierIMGpathdirtemp.$image_name3;
	  $imagelocationtemp=$cfg_data_supplierIMGpathdirtemp;
	}else{
	   $newnamepath3="images/".$image_name3;
	   $imagelocation='images/';
	   $newnamepath3temp="images/temp/".$image_name3;
	   $imagelocationtemp='images/temp/';
    } 
}else{$newnamepath3='';}



            if ($cfg_data_outside_storedir == "no") {
            
               if (file_exists(images/temp)) {     
                   
                } else {     
                  mkdir("images/temp", 0770);     
                   
                }     
            }
			
			if ($cfg_data_outside_storedir == "yes") {
               if (file_exists($cfg_data_supplierIMGpathdirtemp)) {  
                  
                } else {     
                   mkdir("$cfg_data_supplierIMGpathdirtemp", 0770);   
                   
                }     
            }
			


     if ($imagelic != ""){ 
       
       
       $nopicfile= "$imagenewname".'_nopic';  
		   $gif_file="images/$nopicfile.gif";
	     if(file_exists($gif_file)){
         unlink($gif_file);
        }   
		   
		   
		   
		   
		   $gif_file=$imagelocation.$imagenewname.'.gif';
	       if(file_exists($gif_file)){
            unlink($gif_file);
         }
	     
	     $jpg_file=$imagelocation.$imagenewname.'.jpg';
	      if(file_exists($jpg_file)){
           unlink($jpg_file);
        }
		
		   $jpeg_file=$imagelocation.$imagenewname.'.jpeg';
	     if(file_exists($jpeg_file)){
         unlink($jpeg_file);
        }
		
		 $png_file=$imagelocation.$imagenewname.'.png';
	     if(file_exists($png_file)){
         unlink($png_file);
        }
		
		$bmp_file=$imagelocation.$imagenewname.'.bmp';
	     if(file_exists($bmp_file)){
         unlink($bmp_file);
        }
		   
		   
        $gif_file=$imagelocation.$imagenewname.'l'.'.gif';
	       if(file_exists($gif_file)){
            unlink($gif_file);
         }
	     
	  +   $jpg_file=$imagelocation.$imagenewname.'l'.'.jpg';
	      if(file_exists($jpg_file)){
           unlink($jpg_file);
        }
		
		   $jpeg_file=$imagelocation.$imagenewname.'l'.'.jpeg';
	     if(file_exists($jpeg_file)){
         unlink($jpeg_file);
        }
		
		 $png_file=$imagelocation.$imagenewname.'l'.'.png';
	     if(file_exists($png_file)){
         unlink($png_file);
        }
		
		$bmp_file=$imagelocation.$imagenewname.'l'.'.bmp';
	     if(file_exists($bmp_file)){
         unlink($bmp_file);
        }
     
      $imagelic = new SimpleImage();
      $imagelic->load($_FILES['imagelic']['tmp_name']);
      $imagelic->resizeToWidth(400);
      
      $imagelic->save($newnamepathtemp);
	  
	  
	  
	  if ($extension == "bmp" or $extension == "png" or $extension == "gif"){
	      
	      $newnamepathtempjpg=$imagelocationtemp.$imagenewname.'l'.'.'.'jpg'; 
	      system ("convert $newnamepathtemp -resize 50% $newnamepathtempjpg"); 
	      
	      unlink($newnamepathtemp);
		  $newnamepath=$imagelocation.$imagenewname.'l'.'.'.'jpg';
		  $image_name= $imagenewname.'l'.'.'.'jpg';
	  }else{
	   $newnamepathtempjpg = $newnamepathtemp;
	  }
	  
	   if ($cfg_imageZipORnozip == "zip"){ 
	     $newnamepathtempjpgzip=$imagelocation.$imagenewname.'l'.'.'.'jpg.zip';
	     $newnamepath=$newnamepathtempjpgzip;
		 }else{
		    $newnamepathtempjpg=$imagelocation.$imagenewname.'l'.'.'.'jpg';
			$newnamepath=$newnamepathtempjpg;
		 }

	  
	  
	  
	  
	  
        $cryptastic = new cryptastic;
        $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	           die("Failed to generate secret key.");
	
	    if ($cfg_imageZipORnozip == "nozip"){ 
           
	       
		  

         
 
	     
	     
	     
         
         
        }else{
			 system("zip -jP $key $newnamepathtempjpgzip  $newnamepathtempjpg"); 
	         system ("chmod o-rwx $newnamepathtempjpgzip"); 
			 unlink($newnamepathtempjpg);
		}	
	  
	  
	   
	  
    }
    
     if ($imagecust <> ""){ 
     	
        $gif_file=$imagelocation.$imagenewname.'p'.'.gif';
	       if(file_exists($gif_file)){
            unlink($gif_file);
         }
	     
	     $jpg_file=$imagelocation.$imagenewname.'p'.'.jpg';
	      if(file_exists($jpg_file)){
           unlink($jpg_file);
        }
		
		 $jpeg_file=$imagelocation.$imagenewname.'p'.'.jpeg';
	     if(file_exists($jpeg_file)){
         unlink($jpeg_file);
        }
		
		 $png_file=$imagelocation.$imagenewname.'p'.'.png';
	     if(file_exists($png_file)){
         unlink($png_file);
        }
		
		$bmp_file=$imagelocation.$imagenewname.'p'.'.bmp';
	     if(file_exists($bmp_file)){
         unlink($bmp_file);
        }
     
      $imagecust = new SimpleImage();
      $imagecust->load($_FILES['imagecust']['tmp_name']);
      $imagecust->resizeToWidth(300);
      
      $imagecust->save($newnamepath2temp);
	  
	   
	   
	  
	  if ($extension2 == "bmp" or $extension2 == "png" or $extension2 == "gif"){
	      
	      $newnamepath2tempjpg=$imagelocationtemp.$imagenewname.'p'.'.'.'jpg'; 
	      system ("convert $newnamepath2temp -resize 50% $newnamepath2tempjpg"); 
	      
	      unlink($newnamepath2temp);
		  $newnamepath2=$imagelocation.$imagenewname.'p'.'.'.'jpg';
		  $image_name2 = $imagenewname.'p'.'.'.'jpg';
	  }else{
	   $newnamepath2tempjpg = $newnamepath2temp;
	  }
	  
	   if ($cfg_imageZipORnozip == "zip"){ 
	     $newnamepath2tempjpgzip=$imagelocation.$imagenewname.'p'.'.'.'jpg.zip';
	     $newnamepath2=$newnamepath2tempjpgzip;
		 }else{
		    $newnamepath2tempjpg=$imagelocation.$imagenewname.'p'.'.'.'jpg';
			$newnamepath2=$newnamepath2tempjpg;
		 }

	  
	  
	  
        $cryptastic = new cryptastic;
        $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	           die("Failed to generate secret key.");
	
		if ($cfg_imageZipORnozip == "nozip"){ 
           
	       
			

           
 
	       
	       
	       
          
          
		}else{
	         system("zip -jP $key $newnamepath2tempjpgzip  $newnamepath2tempjpg");
	         system ("chmod o-rwx $newnamepath2tempjpgzip");
             unlink($newnamepath2tempjpg);			 
		}	
			 
	  
	  
      
    }
      
    if ($imagethumb <> ""){
    	  
        $gif_file=$imagelocation.$imagenewname.'t'.'.gif';
		
	       if(file_exists($gif_file)){
            unlink($gif_file);
         }
	     
	     $jpg_file=$imagelocation.$imagenewname.'t'.'.jpg';
	      if(file_exists($jpg_file)){
           unlink($jpg_file);
        }
		
		 $jpeg_file=$imagelocation.$imagenewname.'t'.'.jpeg';
	     if(file_exists($jpeg_file)){
         unlink($jpeg_file);
        }
		
		 $png_file=$imagelocation.$imagenewname.'t'.'.png';
	     if(file_exists($png_file)){
         unlink($png_file);
        }
		
		$bmp_file=$imagelocation.$imagenewname.'t'.'.bmp';
	     if(file_exists($bmp_file)){
         unlink($bmp_file);
        }
    
         $imagethumb = new SimpleImage();
         $imagethumb->load($_FILES['imagethumb']['tmp_name']);
	     $imagethumb->resizeToWidth(300);
         
         $imagethumb->save($newnamepath3temp); 
	  
	  
	  
	  if ($extension3 == "bmp" or $extension3 == "png"  or $extension3 == "gif"){
	      
	      $newnamepath3tempjpg=$imagelocationtemp.$imagenewname.'t'.'.'.'jpg'; 
	      system ("convert $newnamepath3temp -resize 50% $newnamepath3tempjpg"); 
	      
	      unlink($newnamepath3temp);
		  $newnamepath3=$imagelocation.$imagenewname.'t'.'.'.'jpg';
		  $image_name3=$imagenewname.'t'.'.'.'jpg';
	  }else{
	    $newnamepath3tempjpg = $newnamepath3temp;
	  }
	  
	    if ($cfg_imageZipORnozip == "zip"){ 
	     $newnamepath3tempjpgzip=$imagelocation.$imagenewname.'t'.'.'.'jpg.zip';
	     $newnamepath3=$newnamepath3tempjpgzip;
		 }else{
		    $newnamepath3tempjpg=$imagelocation.$imagenewname.'t'.'.'.'jpg';
			$newnamepath3=$newnamepath3tempjpg;
		 }
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	  
	  
	  
       	$cryptastic = new cryptastic;
        $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
	           die("Failed to generate secret key.");
	
      
        
        if ($cfg_imageZipORnozip == "nozip"){ 		
	      
	      
		

         
 
	      
	     
	     
         
	     
        }else{  	   
	         system("zip -jP $key $newnamepath3tempjpgzip  $newnamepath3tempjpg");
	         system ("chmod o-rwx $newnamepath3tempjpgzip");
             unlink($newnamepath3tempjpg);			 
			 
	    }
	  
	  
	 
	 }


	 
	 
if ($newnamepath != "" && $newnamepath != " "){
if(file_exists($newnamepath)){
   
} else {
	   echo '<h1>Lic Image Copy unsuccessfull! Please Reload Image</h1>';
    $errors=1;
    exit;
}	
}

if ($newnamepath2 != "" && $newnamepath2 != " "){
 
if(file_exists($newnamepath2)){
   
} else {
	   echo '<h1>Supplier Image Copy unsuccessfull! Please Reload Image</h1>';
    $errors=1;
    exit;
}	
}
if ($newnamepath3 != "" && $newnamepath3 != " "){
if(file_exists($newnamepath3)){
   
} else {
	   echo '<h1>Finger Print Image Copy unsuccessfull! Please Reload Image</h1>';
    $errors=1;
    exit;
}	
}


}}}


 if(isset($_POST['Submit']) && !$errors) 
 {
 	echo "<center>Following Image Uploaded Successfully!</center>";
 
 	
 	  $imgresult = array($image_name, $image_name2, $image_name3);
       return  $imgresult;
		

 	
 }

}







		
		if($supplier=='' or $address=='' or $phone_number=='')
		{
			echo "$lang->forgottenFields";
			exit();
		}
		else
		{
     
	$field_names=array('supplier','firstname','middlename','lastname','gender','race','dob','height','weight','hair_color','eyes_color','address','apartment','city','state','zip','driver_lic_num','licstate','itisid','idnumber','idstate','idtype','licexpdate','phone_number','contact','email','other','imagelic','date','bansupplier');
	$field_data=array("$supplier","$firstname","$middlename","$lastname","$gender","$race","$dob","$height","$weight","$hair_color","$eyes_color","$address","$apartment","$city","$state","$zip","$driver_lic_num","$licstate","$itisid","$idnum","$idstate","$idtype","$licexpdate","$phone_number","$contact","$email","$other","$imagelic","$todays_date","$bansupplier");	
	
		}
		
	}
	else
	{
		
		
		
	}
	

switch ($action)
{
	
	case $action=="insert":
		
		
		
		
		 if ($cfg_common_supplierNcustomers_allstores == "yes"){
 		     $auto_increment_table="'".'customers'."'"; 
		     $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ");
             $row = mysql_fetch_array($r);
             $Auto_increment = $row['Auto_increment'];
		 }else{
		     $auto_increment_table="'"."$cfg_tableprefix".'customers'."'"; 
		     $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ");
             $row = mysql_fetch_array($r);
             $Auto_increment = $row['Auto_increment'];
          
		 }
		 
		 $next_id=$Auto_increment;
    		
		 $accountnum=$cfg_store_code.$next_id;	
         $system_assigned_acctnum=$accountnum; 
     	   $account_number=$accountnum;
     	   $customer_comments ="";
     	
  
		if ($cfg_common_supplierNcustomers_allstores == "yes"){ 
		    $auto_increment_table="'".'suppliers'."'";
		    $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ");
            $row = mysql_fetch_array($r);
            $Auto_increment = $row['Auto_increment'];
		}else{
	      	$auto_increment_table="'"."$cfg_tableprefix".'suppliers'."'";
		    $r = mysql_query("SHOW TABLE STATUS LIKE $auto_increment_table ");
            $row = mysql_fetch_array($r);
            $Auto_increment = $row['Auto_increment'];
 		    
		} 
		      $next_id=$Auto_increment;
		
		if ($licimage=='')
		{
			$defaultpic = '../../je_images/no_picture.gif';
			
      
      
			
			$licimage=$defaultpic;
			
		}
		else
		{
    		
		     $thisname=$cfg_store_code.$next_id;	
		     $imgnewname = imageupload($imagelic,$thisname);
		     
	        $licimage=$imgnewname[0];
	        $custimage=$imgnewname[1];
	        $thumbimage=$imgnewname[2];
			
		
			$checkimagelic=$_FILES['imagelic']['name'];
		  if ($checkimagelic == "" || $checkimagelic == " "){
		     $licimage=$row_image['imagelic']; 
		  }
		  
		  $checkimagecust=$_FILES['imagecust']['name'];
		  if ($checkimagecust == '' || $checkimagecust == ' '){
		     $custimage=$row_image['imagecust']; 
		  }
		  
		  $checkimagethumb=$_FILES['imagethumb']['name'];
		  if ($checkimagethumb == '' || $checkimagethumb == ' '){
		     $thumbimage=$row_image['imagethumb']; 
		  }
		  
			
			
			if ($cfg_data_outside_storedir == "yes"){
                $curimageLic=$cfg_data_supplierIMGpathdir.$licimage;
	        
           }else{
	            $curimageLic="images/".$licimage;
	        
          }
			
			
	  }
	  
	  
		$supplier_tablename="$cfg_tableprefix".'suppliers';
		$findphonevalue = "'".$phone_number."'";
		$findfirstnamevalue = "'".$firstname."'";
		$findlastnamevalue = "'".$lastname."'";
		
		if ($cfg_makePhoneRequired=="yes")
		{
		  
		  $check_supplier_table="SELECT * FROM $supplier_tablename where phone_number = trim($findphonevalue) and firstname = trim($findfirstnamevalue) and lastname = trim($findlastnamevalue)";  
         
		
		}else if ($cfg_makePhoneRequired=="yes-UseNameSrchCustTbl")
		{
		   $check_supplier_table="SELECT * FROM $supplier_tablename where firstname = trim($findfirstnamevalue) and lastname = trim($findlastnamevalue)";
		
		}else{
	    
		  $check_supplier_table="SELECT * FROM $supplier_tablename where firstname = trim($findfirstnamevalue) and lastname = trim($findlastnamevalue)";  
        
		} 
		 
		 if(mysql_num_rows(mysql_query($check_supplier_table,$dbf->conn))){
         
		    
			
		     $supplier_result=mysql_query($check_supplier_table,$dbf->conn);			 
		     $supplier_row = mysql_fetch_assoc($supplier_result);
			 $driverlicnum_onfile = $supplier_row['driver_lic_num']; 
			 
			 
			  $cryptastic = new cryptastic;
              $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
                     die("Failed to generate secret key.");  
			 
			         $decryptedlic = $cryptastic->decrypt($driverlicnum_onfile, $key, true) or
                           
			               $AbleTodecrypt="Failed to complete decryption of Lic";
			 
			
		     
			 if (trim($driver_lic_num1) == trim($decryptedlic)) {
			 $supplierINdatabase='yes';
			 $found_supplierid = $supplier_row['id'];
		     $trans_id_value='SupplierLicInDB';
		    
		     $supplier_licexpdate = $supplier_row['licexpdate'];
	         $cryptastic = new cryptastic;
             $key = $cryptastic->pbkdf2($cfg_pass, $cfg_salt, 1000, 32) or
                     die("Failed to generate secret key.");
	         $decryptedlicexpdate = $cryptastic->decrypt($supplier_licexpdate, $key, true) or
                                   
                                   $AbleTodecrypt="Failed to complete decryption of Lic exp date";
	   
	   
	    
	   
	       $today = strtotime($todays_date);
           $supplier_licexpdate = strtotime($decryptedlicexpdate);

          if ($supplier_licexpdate > $today) {
               $onfile_licvalid = "yes";
          } else {
               $onfile_licvalid = "no";
         }
	   
	       
		       $found_bansupplier_flag = $supplier_row['bansupplier'];
		       if ($found_bansupplier_flag == "Y")
            {
  	           echo "This Supplier(Customer) is Banned. If you need to buy Item from this supplier have Admin remove the Ban.";
  	           exit;
            }
		     
	   	   }else{
		      $supplierINdatabase='no';
		   }
	    }else{
		      
	       $supplierINdatabase='no';
		  
     	}
		
	
	
	  
	
  	
	$field_names=array('supplier','firstname','middlename','lastname','gender','race','dob','height','weight','hair_color','eyes_color','address','apartment','city','state','zip','driver_lic_num','licstate','itisid','idnumber','idstate','idtype','licexpdate','phone_number','contact','email','other','imagelic','imagecust','imagethumb','date','bansupplier');
	$field_data=array("$supplier","$firstname","$middlename","$lastname","$gender","$race","$dob","$height","$weight","$hair_color","$eyes_color","$address","$apartment","$city","$state","$zip","$driver_lic_num","$licstate","$itisid","$idnum","$idstate","$idtype","$licexpdate","$phone_number","$contact","$email","$other","$licimage","$custimage","$thumbimage","$todays_date","$bansupplier");	
	
	if ($supplierINdatabase == "no"){
	    if ($cfg_common_supplierNcustomers_allstores == "yes"){ 
		    $commondbf->insert($field_names,$field_data,$tablename,true);
			$dbfconn='$commondbf->conn';
        }else{		
		  $dbf->insert($field_names,$field_data,$tablename,true);
		  $dbfconn='$dbf->conn';
	    }
	       
		  
		  $check_customer_table="SELECT * FROM $customer_tablename where phone_number = trim($phone_number)";
		  
		  
		  if(mysql_num_rows(mysql_query($check_customer_table,$dbfconn))){
         
		     
	    }else{
		     
		     
	         $customer_field_names=array('first_name','last_name','account_number','phone_number','email','street_address','comments','date');
             $customer_field_data=array("$firstname","$lastname","$account_number","$phone_number","$email","$cust_address","$customer_comments","$todays_date");	
	      
		  if ($cfg_common_supplierNcustomers_allstores == "yes"){ 
		      $commondbf->insert($customer_field_names,$customer_field_data,$customer_tablename,true);
		  }else{
	       $dbf->insert($customer_field_names,$customer_field_data,$customer_tablename,true);
     	  }
		}	
	
	
	    
	    
	    
	    $inserted_id = $next_id;
		
		if ($cfg_enableimageupload_person=="yes"and $cfg_imagesnapmethod=="online"){ 
           echo "<meta http-equiv=refresh content=\"0; URL=../../webcam/webcam.php?action=insert&working_on_id=$inserted_id&active_trans_id=$trans_id_value&comingfrom=processsupplier&redirectto=psupplierslink1\">";
        }else{ 
      		echo "<meta http-equiv=refresh content=\"0; URL=../form_items.php?action=insert&working_on_id=$inserted_id&active_trans_id=$trans_id_value\">";
	 	}
		
   }else{
   	  
         if ($onfile_licvalid == "yes"){
            
			  if ($cfg_SupplierFound_GoToUpdate == "yes"){ 
			      echo "<meta http-equiv=refresh content=\"0; URL=form_suppliers.php?action=update&id=$found_supplierid\">"; 
			   }else{ 
			      
				  
				  if ($cfg_enableimageupload_person=="yes"and $cfg_imagesnapmethod=="online"){ 
				      echo "<meta http-equiv=refresh content=\"0; URL=../../webcam/webcam.php?action=insert&working_on_id=$found_supplierid&active_trans_id=$trans_id_value&comingfrom=processsupplier&redirectto=psupplierslink2\">";
				  }else{ 
                      echo "<meta http-equiv=refresh content=\"0; URL=../form_items.php?action=insert&working_on_id=$found_supplierid&active_trans_id=$trans_id_value\">";
	              }
			   }
		  
		  }else{
             echo "<meta http-equiv=refresh content=\"0; URL=form_suppliers.php?action=update&id=$found_supplierid\">";
          }
     
  }	  
	
	break;
		
	case $action=="update":

	 
		if ($licimage=='' && $custimage=='' && $thumbimage=='')
		{
		   
		
			
         
	     
	     $field_names=array('supplier','firstname','middlename','lastname','gender','race','dob','height','weight','hair_color','eyes_color','address','apartment','city','state','zip','driver_lic_num','licstate','itisid','idnumber','idstate','idtype','licexpdate','phone_number','contact','email','other','bansupplier');
	     $field_data=array("$supplier","$firstname","$middlename","$lastname","$gender","$race","$dob","$height","$weight","$hair_color","$eyes_color","$address","$apartment","$city","$state","$zip","$driver_lic_num","$licstate","$itisid","$idnum","$idstate","$idtype","$licexpdate","$phone_number","$contact","$email","$other","$bansupplier");	
	
	
			
		}
		else
		{
    
		   $thisname=$cfg_store_code.$workingid;
		   $imgnewname = imageupload($imagelic,$thisname);     
	     
		   $licimage=$imgnewname[0];
	       $custimage=$imgnewname[1];
	       $thumbimage=$imgnewname[2];
		 
		 
		
		 
		 
		 
		  
		  if ($cfg_common_supplierNcustomers_allstores == "yes"){ 
		      $result_image = mysql_query("SELECT imagelic, imagecust, imagethumb FROM $tablename WHERE id=\"$id\"",$commondbf->conn);
		      $row_image = mysql_fetch_assoc($result_image);
		  }else{
		    $result_image = mysql_query("SELECT imagelic, imagecust, imagethumb FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		    $row_image = mysql_fetch_assoc($result_image);
		  }
		  
		  $checkimagelic=$_FILES['imagelic']['name'];
		  if ($checkimagelic == "" || $checkimagelic == " "){
		     $licimage=$row_image['imagelic']; 
		  }
		  
		  $checkimagecust=$_FILES['imagecust']['name'];
		  if ($checkimagecust == '' || $checkimagecust == ' '){
		     $custimage=$row_image['imagecust']; 
		  }
		  
		  $checkimagethumb=$_FILES['imagethumb']['name'];
		  if ($checkimagethumb == '' || $checkimagethumb == ' '){
		     $thumbimage=$row_image['imagethumb']; 
		  }
		  
		 
		 
		 
		  
   	  
  	  
	    $field_names=array('supplier','firstname','middlename','lastname','gender','race','dob','height','weight','hair_color','eyes_color','address','apartment','city','state','zip','driver_lic_num','licstate','itisid','idnumber','idstate','idtype','licexpdate','phone_number','contact','email','other','imagelic','imagecust','imagethumb','bansupplier');
  	    $field_data=array("$supplier","$firstname","$middlename","$lastname","$gender","$race","$dob","$height","$weight","$hair_color","$eyes_color","$address","$apartment","$city","$state","$zip","$driver_lic_num","$licstate","$itisid","$idnum","$idstate","$idtype","$licexpdate","$phone_number","$contact","$email","$other","$licimage","$custimage","$thumbimage","$bansupplier");	
	
	
	
	  }
	  
		
		
		
		
		
	if ($cfg_common_supplierNcustomers_allstores == "yes"){ 
        $commondbf->update($field_names,$field_data,$tablename,$id,true);
     }else{
        $dbf->update($field_names,$field_data,$tablename,$id,true);
		
		
		
		$supplier_tablename="$cfg_tableprefix".'suppliers';
		$findphonevalue = "'".$phone_number."'";
		$findfirstnamevalue = "'".$firstname."'";
		$findlastnamevalue = "'".$lastname."'";
		
		
		 echo "Phone: $phone_number FirstName: $firstname Lastname: $lastname PhoneRequred: $cfg_makePhoneRequired __";
		
		if ($cfg_makePhoneRequired=="yes")
		{
		  
		  $custtable_query="SELECT * FROM $customer_tablename where phone_number = trim($findphonevalue) and first_name = trim($findfirstnamevalue) and last_name = trim($findlastnamevalue)";  
         
		
		}else if ($cfg_makePhoneRequired=="yes-UseNameSrchCustTbl")
		{
		   $custtable_query="SELECT * FROM $customer_tablename where first_name = trim($findfirstnamevalue) and last_name = trim($findlastnamevalue)";
		
		}else{
	    
		  $custtable_query="SELECT * FROM $customer_tablename where first_name = trim($findfirstnamevalue) and last_name = trim($findlastnamevalue)";  
        
		} 
		
		
		
		$custtable_result=mysql_query($custtable_query,$dbf->conn);
		$custtable_row = mysql_fetch_assoc($custtable_result);  
	    $custtableid = $custtable_row['id'];
        $account_number = $custtable_row['account_number'];		
		
		
		
        
	    
		
        
	   
       
	   $customer_field_names=array('first_name','last_name','account_number','phone_number','email','street_address','comments');
        $customer_field_data=array("$firstname","$lastname","$account_number","$phone_number","$email","$cust_address","$customer_comments");	
	    
		
		
		$dbf->update($customer_field_names,$customer_field_data,$customer_tablename,$custtableid,true);
	
		
	}			
	break;
	
	case $action=="delete":
	  if ($cfg_common_supplierNcustomers_allstores == "yes"){ 
		   $commondbf->deleteRow($tablename,$id);
	   }else{	
		  $dbf->deleteRow($tablename,$id);
	   }
	break;
	
	default:
		echo "$lang->noActionSpecified";
	break;
}
$dbf->closeDBlink();
if ($cfg_common_supplierNcustomers_allstores == "yes"){ 
$commondbf->closeDBlink();
}


if ($action=="insert"){
echo "<a href=\"../form_items.php?action=insert&working_on_id=$next_id\"><img src=\"../../je_images/btgray_add_item_tothis_supplier.png\" onmouseover=\"this.src='../../je_images/btgray_add_item_tothis_supplier_MouseOver.png';\" onmouseout=\"this.src='../../je_images/btgray_add_item_tothis_supplier.png';\" BORDER='0'></a>";
}
if ($action=="update"){

   if ($cfg_SupplierFound_GoToUpdate == "yes"){ 
      
	   if ($cfg_enableimageupload_person=="yes" and $cfg_imagesnapmethod == "online"){
          echo "<meta http-equiv=refresh content=\"0; URL=../../webcam/webcam.php?action=insert&working_on_id=$id&active_trans_id=$trans_id_value&comingfrom=processsupplier&redirectto=psupplierslink3\">"; 
	   }else{ 
	    
		

		
			
			if(($action=="update") and ($cfg_enable_PopUpUpdateform=="yes") and isset($_GET['fromupdatelink'])) { 
				echo "<meta http-equiv=refresh content=\"0; URL=updatedone.php\">";
			}else{
				echo "<meta http-equiv=refresh content=\"0; URL=../form_items.php?action=insert&working_on_id=$id&active_trans_id=$trans_id_value\">"; 
			}
				}
   
   }else{ 
     echo "<a href=\"../form_items.php?action=insert&working_on_id=$workingid\"><img src=\"../../je_images/btgray_add_item_tothis_supplier.png\" onmouseover=\"this.src='../../je_images/btgray_add_item_tothis_supplier_MouseOver.png';\" onmouseout=\"this.src='../../je_images/btgray_add_item_tothis_supplier.png';\" BORDER='0'></a>";
    } 

}

?>


<br>
<a href="manage_suppliers.php"><img src="../../je_images/btgray_manage_suppliers.png" onmouseover="this.src='../../je_images/btgray_manage_suppliers_MouseOver.png';" onmouseout="this.src='../../je_images/btgray_manage_suppliers.png';" BORDER='0'></a>
<br>
<a href="form_suppliers.php?action=insert"><img src="../../je_images/btgray_create_new_supplier.png" onmouseover="this.src='../../je_images/btgray_create_new_supplier_MouseOver.png';" onmouseout="this.src='../../je_images/btgray_create_new_supplier.png';" BORDER='0'></a>


</body>
</html>