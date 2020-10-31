<?php
include ("./settings.php");
include ("../../../$cfg_configfile");

if ($cfg_store_state=="il") {   


$createdfilenames=$cfg_xmlfilecreatedir.'/'.'transcreatedfilenames.php';

if (file_exists("$createdfilenames")) {
   include ("$createdfilenames");


$iszipdir=$_GET['iszipdir'];
if ($iszipdir=="yes"){
  $file=$cfg_copyxmlfiletodir.$cfg_zipoutputdir;  
}else{
 $file=$cfg_copyxmlfiletodir.$cfg_csvoutputfile; 
}

if (file_exists("$file")) {
  
}else{
      $outputpathandfilename=$cfg_xmlfilecreatedir.'/'.$file;
	
      if (file_exists("$outputpathandfilename")) {
	  
	    shell_exec("cp -f $outputpathandfilename $cfg_copyxmlfiletodir");
		exit;
	  }
}






}else{
  echo "Transaction file names unknown. This could because include file $createdfilenames not found.";
  exit;
}


} 


if ($cfg_store_state =="wi") {   



$rundate=$_GET['rundate'];
$xmlfilename=$cfg_companyname.$rundate.'.xml';

$file=$cfg_copyxmlfiletodir.'/'.$xmlfilename;

} 
 
 
 
 
 
 if(is_file($file))
{


	switch(strtolower(substr(strrchr($file,'.'),1)))
	{
		case 'txt': $mime = 'text/plain'; break;
		case 'pdf': $mime = 'application/pdf'; break;
		case 'zip': $mime = 'application/zip'; break;
		case 'jpeg':
		case 'jpg': $mime = 'image/jpg'; break;
		default: $mime = 'application/force-download';
	}

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);	

	
	}else{
	header("Location: home.php");
	
	}
	
	
	unlink("$file");

	shell_exec("rm -f $cfg_xmlfilecreatedir/requesttransfile.php");

	exit;
?>	