<?php session_start(); ?>
<?php
include ("../settings.php");
include ("../../../../$cfg_configfile");

include ("../../../../jeconfig/$cfg_storeDirname/settings_barcode.php");
include ("../language/$cfg_language");
include ("../classes/db_functions_dvd.php");
include ("../classes/security_functions.php");
include ("../classes/resizeimage.php");


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
	
	if ($barcfg_header == "yes"){
	  $this->SetFont('Arial','',$barcfg_textsize);
	  $this->Text($barcfg_textXpos,$barcfg_textYpox,$barcfg_header_text);
	}
	

    $this->SetFont('Arial','',$barcfg_codetextsize);
    $this->Text($xpos, $ypos + $height + $barcfg_gap, $code.'-'.$transactionDate.' '.'$'.$sellprice );

    
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

					$supplier_id=$_GET['working_on_id'];
		            $itemtrans_id=$_GET['active_trans_id'];



				$itemtransactions_tablename="$cfg_tableprefix".'item_transactions';
				$itemtransactions_query="SELECT * FROM $itemtransactions_tablename where transaction_id = $itemtrans_id ";
				$itemtransactions_result=mysql_query($itemtransactions_query,$dbf->conn);

				






$Newmoviessetup='no';
$categorytable = "$cfg_tableprefix".'categories';
$wherefieldmv = ' showon_moviespanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
$resultcatmv = mysql_query("SELECT * FROM $categorytable WHERE $wherefieldmv ",$dbf->conn);
$moviesnumcat_rows = mysql_num_rows($resultcatmv);

if ($moviesnumcat_rows < 1)
{
	$Newmoviessetup='no';
}else{
	$Newmoviessetup='yes';
}



$Newgamessetup='no';
$wherefieldgames = ' showon_gamespanel = '."'".'Y'. "'" .' and activate_category = '."'".'Y'. "'";
$resultcatgames = mysql_query("SELECT * FROM $categorytable WHERE $wherefieldgames ",$dbf->conn);
$gamesnumcat_rows = mysql_num_rows($resultcatgames);
if ($gamesnumcat_rows < 1)
{
	$Newgamessetup='no';
}else{
	$Newgamessetup='yes';
}

$pdf=new PDF_Code39('L');

while($item_transaction_row = mysql_fetch_array($itemtransactions_result)) {
$create_barcode='no';
       $articletable = "$cfg_tableprefix".'articles';
       $articleid=$item_transaction_row['article_id'];
	   $cat_id=$item_transaction_row['category_id'];
       $article_title=$dbf->idToField("$articletable",'article',"$articleid");


$moviedvd='no';
$gamedvd='no';
if ($Newmoviessetup=="yes"){ 

	$articletable = "$cfg_tableprefix".'articles a,'."$cfg_tableprefix".'categories b ';
	$wherefield = ' a.category_id = ' ." '". "$cat_id"."'".'and  a.category_id = b.id and b.showon_moviespanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'".' and a.id = ' ." '". "$articleid"."'";
	$check_arttable="SELECT a.id FROM $articletable where $wherefield";

	if(mysql_num_rows(mysql_query($check_arttable,$dbf->conn))){
		$moviedvd='yes';
	}else{
		$moviedvd='no';
	}
}

if ($Newgamessetup=="yes"){ 
 
	$articletable = "$cfg_tableprefix".'articles a,'."$cfg_tableprefix".'categories b ';
	$wherefield = ' a.category_id = ' ." '". "$cat_id"."'".'and  a.category_id = b.id and b.showon_gamespanel = '."'".'Y'. "'" .' and a.activate_article = '."'".'Y'. "'".' and a.id = ' ." '". "$articleid"."'";
	$check_arttable="SELECT a.id FROM $articletable where $wherefield";
	if(mysql_num_rows(mysql_query($check_arttable,$dbf->conn))){
		$gamedvd='yes';
	}else{
		$gamedvd='no';
	}
}



		if ($article_title == "Video DVD" && $Newmoviessetup=="no") { 
	           $create_barcode='no';
		}else if ($moviedvd=="yes" && $Newmoviessetup=="yes") {
				$create_barcode='no';
		}else if ($article_title == "Game DVD" && $cfg_gamedvd_upc=="gamedvdupc" && $Newgamessetup =="no"){ 
	           $create_barcode='no';
		}else if ($gamedvd=="yes" && $cfg_gamedvd_upc=="gamedvdupc" && $Newgamessetup =="yes"){ 
	           $create_barcode='no';
	     }else if ((($item_transaction_row['transaction_from_panel']) == "jewelry") and (($item_transaction_row['itemrow_id']) == 0)){
	           $create_barcode='no'; 
         }else if ($article_title == "Game DVD" && $cfg_gamedvd_upc=="storeupc" && $Newgamessetup =="no"){ 
	           $create_barcode='yes';  
		 }else if ($gamedvd=="yes" && $cfg_gamedvd_upc=="storeupc" && $Newgamessetup =="yes"){ 
	           $create_barcode='yes'; 
	     }else{
             $create_barcode='yes';
		}



if ($create_barcode=="yes"){

$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

$sellprice=$item_transaction_row['unit_price'];
$upccode=$item_transaction_row['upc'];
$pdf->Code39($barcfg_printXpos,$barcfg_printYpos,$upccode,$barcfg_width,$barcfg_height,date("mdy",strtotime($item_transaction_row['date'])),$sellprice); 


$create_barcode='no';
}

}

$pdf->Output();



?>