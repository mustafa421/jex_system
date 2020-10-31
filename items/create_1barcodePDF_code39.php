<?php session_start(); ?>
<?php
include ("../settings.php");
include ("../../../../$cfg_configfile");

include ("../../../../jeconfig/$cfg_storeDirname/settings_barcode.php");
include ("../language/$cfg_language");
include ("../classes/db_functions_dvd.php");
include ("../classes/security_functions.php");



$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);



if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit ();
}
require('createPDF/fpdf.php');
class PDF_Code39 extends FPDF
{
function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5, $transactionDate, $sellprice){

    $wide = $baseline;
    $narrow = $baseline / 3 ; 
    $gap = $narrow;

    $barChar['0'] = 'nnnwwnwnn';
    $barChar['1'] = 'wnnwnnnnw';
    $barChar['2'] = 'nnwwnnnnw';
    $barChar['3'] = 'wnwwnnnnn';
    $barChar['4'] = 'nnnwwnnnw';
    $barChar['5'] = 'wnnwwnnnn';
    $barChar['6'] = 'nnwwwnnnn';
    $barChar['7'] = 'nnnwnnwnw';
    $barChar['8'] = 'wnnwnnwnn';
    $barChar['9'] = 'nnwwnnwnn';
    $barChar['A'] = 'wnnnnwnnw';
    $barChar['B'] = 'nnwnnwnnw';
    $barChar['C'] = 'wnwnnwnnn';
    $barChar['D'] = 'nnnnwwnnw';
    $barChar['E'] = 'wnnnwwnnn';
    $barChar['F'] = 'nnwnwwnnn';
    $barChar['G'] = 'nnnnnwwnw';
    $barChar['H'] = 'wnnnnwwnn';
    $barChar['I'] = 'nnwnnwwnn';
    $barChar['J'] = 'nnnnwwwnn';
    $barChar['K'] = 'wnnnnnnww';
    $barChar['L'] = 'nnwnnnnww';
    $barChar['M'] = 'wnwnnnnwn';
    $barChar['N'] = 'nnnnwnnww';
    $barChar['O'] = 'wnnnwnnwn'; 
    $barChar['P'] = 'nnwnwnnwn';
    $barChar['Q'] = 'nnnnnnwww';
    $barChar['R'] = 'wnnnnnwwn';
    $barChar['S'] = 'nnwnnnwwn';
    $barChar['T'] = 'nnnnwnwwn';
    $barChar['U'] = 'wwnnnnnnw';
    $barChar['V'] = 'nwwnnnnnw';
    $barChar['W'] = 'wwwnnnnnn';
    $barChar['X'] = 'nwnnwnnnw';
    $barChar['Y'] = 'wwnnwnnnn';
    $barChar['Z'] = 'nwwnwnnnn';
    $barChar['-'] = 'nwnnnnwnw';
    $barChar['.'] = 'wwnnnnwnn';
    $barChar[' '] = 'nwwnnnwnn';
    $barChar['*'] = 'nwnnwnwnn';
    $barChar['$'] = 'nwnwnwnnn';
    $barChar['/'] = 'nwnwnnnwn';
    $barChar['+'] = 'nwnnnwnwn';
    $barChar['%'] = 'nnnwnwnwn';

	
	include ("../settings.php");
    include ("../../../../$cfg_configfile");

	include ("../../../../jeconfig/$cfg_storeDirname/settings_barcode.php");
	
	if ($bar1cfg_header == "yes"){
	  $this->SetFont('Arial','',$bar1cfg_textsize);
	  $this->Text($bar1cfg_textXpos,$bar1cfg_textYpox,$bar1cfg_header_text);
	} 
	

	$this->SetFont('Arial','',$bar1cfg_codetextsize);
    $this->Text($xpos, $ypos + $height + $bar1cfg_gap, $code.'-'.$transactionDate.' '.'$'.$sellprice );
		
    $this->SetFillColor(0);
  
    $code = '*'.strtoupper($code).'*';
    for($i=0; $i<strlen($code); $i++){
        $char = $code[$i];
        if(!isset($barChar[$char])){
            $this->Error('Invalid character in barcode: '.$char);
        }
        $seq = $barChar[$char];
        for($bar=0; $bar<9; $bar++){
            if($seq[$bar] == 'n'){
                $lineWidth = $narrow;
            }else{
                $lineWidth = $wide;
            }
            if($bar % 2 == 0){
                $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
            }
            $xpos += $lineWidth;
        }
        $xpos += $gap;
    }
}
}



	$id=$_GET['id'];
	$item_tablename="$cfg_tableprefix".'items';
	$item_query="SELECT * FROM $item_tablename where id = $id ";  
	  
	$item_result=mysql_query($item_query,$dbf->conn);
	$item_row = mysql_fetch_assoc($item_result);



$itemrowid=$id;
$itemtransactions_tablename="$cfg_tableprefix".'item_transactions';
$itemtransactions_query="SELECT * FROM $itemtransactions_tablename where itemrow_id = $itemrowid ";
$itemtransactions_result=mysql_query($itemtransactions_query,$dbf->conn);
$itemtransactions_row = mysql_fetch_assoc($itemtransactions_result);


$categorytable = "$cfg_tableprefix".'categories';
$cat_id=$item_row['category_id'];
$cat_title=$dbf->idToField("$categorytable",'category',"$cat_id");


$wherefield = ' showon_moviespanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
$resultcat = mysql_query("SELECT * FROM $categorytable WHERE $wherefield ",$dbf->conn);
$numcat_rows = mysql_num_rows($resultcat);

if ($numcat_rows < 1) 
{
	 
      if ($cat_title != "DVD"){ 
	   
	           $create_barcode='yes';
	     }else{
             $create_barcode='no';
			 $msg='This is a DVD UPC. Can not create barcode for this item';

             require_once('createPDF/fpdi/fpdi.php');  
      }

}else{ 
	$art_id=$item_row['article_id'];
	$articletable = "$cfg_tableprefix".'articles a,'."$cfg_tableprefix".'categories b ';
	$wherefield = ' a.category_id = ' ." '". "$cat_id"."'".'and  a.category_id = b.id and b.showon_moviespanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'".' and a.id = ' ." '". "$art_id"."'";



			$check_arttable="SELECT a.id FROM $articletable where $wherefield";
			if(mysql_num_rows(mysql_query($check_arttable,$dbf->conn))){
				
				 $create_barcode='no';
				 $msg='This is a DVD UPC. Can not create barcode for this item';
				require_once('createPDF/fpdi/fpdi.php');  
			}else{
				
				$create_barcode='yes';
			}
	

}



$categorytable = "$cfg_tableprefix".'categories';
$wherefield = ' showon_gamespanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
$resultcat = mysql_query("SELECT * FROM $categorytable WHERE $wherefield ",$dbf->conn);
$numcat_rows = mysql_num_rows($resultcat);

if ($numcat_rows < 1) 
{

	  $myarticleid=$itemtransactions_row['article_id'];  
	  $article_tablename="$cfg_tableprefix".'articles';
      $article_query="SELECT * FROM $article_tablename where id = $myarticleid";
      $article_result=mysql_query($article_query,$dbf->conn);
      $article_row = mysql_fetch_assoc($article_result);
	  $articlename=$article_row['article'];
	
	  if ($articlename == "Game DVD" && $cfg_gamedvd_upc=="storeupc"){
	      $create_barcode='yes';
	  }
	  
	if ($articlename == "Game DVD" && $cfg_gamedvd_upc=="gamedvdupc"){
	      $create_barcode='no';
		  $msg='Your store is setup to use Game UPC. Therefore can not create barcode for this item';
		  require_once('createPDF/fpdi/fpdi.php'); 
	  }  
}else{ 
	$myarticleid=$itemtransactions_row['article_id']; 
	$articletable = "$cfg_tableprefix".'articles a,'."$cfg_tableprefix".'categories b ';
	$wherefield = ' a.category_id = ' ." '". "$cat_id"."'".'and  a.category_id = b.id and b.showon_gamespanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'".' and a.id = ' ." '". "$myarticleid"."'";
	$check_arttable="SELECT a.id FROM $articletable where $wherefield";
	if(mysql_num_rows(mysql_query($check_arttable,$dbf->conn))){
	  
	 if ($cfg_gamedvd_upc=="storeupc"){
	      $create_barcode='yes';
	  }
	  
	if ($cfg_gamedvd_upc=="gamedvdupc"){
	      $create_barcode='no';
		  $msg='Your store is setup to use Game UPC. Therefore can not create barcode for this item';
		  require_once('createPDF/fpdi/fpdi.php'); 
	  }  
}

}



	  


if ($create_barcode=="yes"){
$pdf=new PDF_Code39();
$pdf->AddPage('L');
$pdf->SetAutoPageBreak(true);

$upccode=$item_row['item_number'];
$sellprice=$item_row['unit_price'];

$pdf->Code39($bar1cfg_printXpos,$bar1cfg_printYpos,$upccode,$bar1cfg_width,$bar1cfg_height,date("mdy",strtotime($itemtransactions_row['date'])),$sellprice); 


}else{

$pdf =& new FPDI();  
$pdf->addPage(); 

$pdf->SetFont('Arial','',12);
$pdf->SetXY(11, 15);

$pdf->Write(0, $msg);
}

$pdf->Output();



?>