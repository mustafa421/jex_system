<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>JPEGCam Page</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Joseph Huckaby">
	<!-- Date: 2008-03-15 -->
	
<script>
  function closewindow() {
    window.close();
  }
</script>
	
</head>
<body>



<?php

if(isset($_GET['redirectto'])){ 
     	 $redirect_to=$_GET['redirectto'];
	     
}else{
$redirect_to='';
}

 if(isset($_GET['working_on_id'])){
	      $woid=$_GET['working_on_id'];
		  $supplier_id=$woid;
	      
				
}				
if(isset($_GET['active_trans_id'])){ 
     	 $trans_id_value=$_GET['active_trans_id'];
	     
}else{
$transaction_id_value='';
}

if(isset($_GET['storecode'])){ 
     	 $storecode=$_GET['storecode'];
	       
}else{
$storecode='';
}

if(isset($_GET['itemrowid'])){ 
     	 $itemrowid=$_GET['itemrowid'];
	     
}else{
$itemrowid='';
}

if(isset($_GET['inventorytblrowid'])){ 
     	 $inventorytblrowid=$_GET['inventorytblrowid'];
	    
}else{
$inventorytblrowid='';
}

if(isset($_GET['itemtranstbl_rowid'])){ 
     	 $itemtranstbl_rowid=$_GET['itemtranstbl_rowid'];
	     
}else{
$itemtranstbl_rowid='';
}


if(isset($_GET['comingfrom'])){ 
     	 $comingfrom=$_GET['comingfrom'];
	    
}else{
$comingfrom='';
}






if ($comingfrom=="processitems"){ 
 echo "<center><b><font color='green'>Item Image Upload <br><br> </font></b></center>";

 }


if ($comingfrom=="processsupplier"){ 
 echo "<center><b><font color='green'>Person(Supplier) Image Upload <br><br> </font></b></center>";
}
 	   
?>

	<table><tr><td valign=top>
	<h1></h1>
	<?php echo "<center><b><font color='blue'>Camera View (Live) <br> </font></b></center>";?>
	<h3></h3>
	
	<!-- First, include the JPEGCam JavaScript Library -->
	<script type="text/javascript" src="webcam.js"></script>
	
	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( 'takesnap.php?&itemrowid=<?php echo($itemrowid); ?>&trans_id=<?php echo($trans_id_value); ?>&supplierid=<?php echo($woid); ?>&inventorytblrowid=<?php echo($inventorytblrowid); ?>&itemtranstbl_rowid=<?php echo($itemtranstbl_rowid); ?>&comingfrom=<?php echo($comingfrom); ?>' );
	
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
	
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(320, 240) );
	</script>
	
	<!-- Some buttons for controlling things -->
	<br/><form>
		<input type=button value="Configure..." onClick="webcam.configure()">
		&nbsp;&nbsp;
		<input type=button value="Take Snapshot" onClick="take_snapshot()">
		
	</form>
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function take_snapshot() {
			
			
			
			
			document.getElementById('upload_results').innerHTML = "<?php echo "<center><b><font color='blue'>Taking SnapShot... <br> </font></b></center>";?>";
			
			webcam.snap();
		}
		
		function my_completion_handler(msg) {
				
			
			if (msg.match(/(https\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				
				document.getElementById('upload_results').innerHTML = 
				
				
            	
				"<?php echo "<br> <center><b><font color='blue'>SnapShot View <br> <br></font></b></center>";?>" +
					'<img src="' + image_url + '">';					
		
				
				webcam.reset();
			}
			else alert("PHP Error: " + msg);
		}
		

		
	</script>
	
	
	</td><td width=50>&nbsp;</td><td valign=top>
		<div id="upload_results" style="background-color:#eee;"></div>
		
<?php
			
			
	       
?>		
	</td></tr></table>
<?php
include ("../settings.php");

if ($redirect_to=="psupplierslink1"){

echo "<center><b><a href=\"../items/form_items.php?action=insert&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";

}

if ($redirect_to=="psupplierslink2"){

echo "<center><b><a href=\"../items/form_items.php?action=insert&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";

}

if ($redirect_to=="psupplierslink3"){ 
	if ($cfg_enable_PopUpUpdateform=="yes"){
		
		echo "<center><b><a href=\"javascript:closewindow()\">Done with Image Close PopUp Window</a></b></center>";
		}else{
		
		echo "<center><b><a href=\"../items/form_items.php?action=insert&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
	}
}

if ($redirect_to=="pitemslink1"){ 

  echo "<center><b><a href=\"../items/form_items.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
}

if ($redirect_to=="pitemslink2"){ 
	if ($cfg_enable_PopUpUpdateform=="yes"){
		
		
		echo "<center><b><a href=\"javascript:closewindow()\">Done with Image Close PopUp Window</a></b></center>";
	}else{
		echo "<center><b><a href=\"../items/manage_items.php\">Done with Image Continue</a></b></center>";
	}
}





if ($redirect_to=="mitemslink1"){ 
   if ($cfg_enable_PopUpUpdateform=="yes"){
      echo "<center><b><a href=\"javascript:closewindow()\">Done with Image Close PopUp Window</a></b></center>";
   }else{  
      echo "<center><b><a href=\"../items/manage_item_trans.php\">Done with Image Continue</a></b></center>";

	  }
}

if ($redirect_to=="pdvdlink1"){ 

  echo "<center><b><a href=\"../items/form_items_dvd_v2.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
}

if ($redirect_to=="pdvdlink1v3"){ 

  echo "<center><b><a href=\"../items/form_items_dvd_v3.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
}

if ($redirect_to=="pdvdlink2"){ 

  echo "<center><b><a href=\"../items/form_items_dvd.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
}


if ($redirect_to=="pgdvdlink1"){ 
  
  echo "<center><b><a href=\"../items/form_items_videogame_dvd_v2.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
}

if ($redirect_to=="pgdvdlink1v3"){ 
  
  echo "<center><b><a href=\"../items/form_items_videogame_dvd_v3.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
}

if ($redirect_to=="pgdvdlink2"){ 
   
   echo "<center><b><a href=\"../items/form_items_videogame_dvd.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
}


if ($redirect_to=="pjewelrylink1"){ 
  
  echo "<center><b><a href=\"../items/form_items_jewelry.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value&addjewelrytoinventory=yes\">Done with Image Continue</a></b></center>";
}

if ($redirect_to=="pjewelrylink2"){ 
  
   echo "<center><b><a href=\"../items/form_buy_jewelry.php?&working_on_id=$supplier_id&active_trans_id=$trans_id_value\">Done with Image Continue</a></b></center>";
}



 ?>		
</body>
</html>
