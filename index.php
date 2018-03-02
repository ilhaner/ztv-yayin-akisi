<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<style type="text/css">
	.divYayinlar {
	background-color: #E3E3E3;
    height: 50px;
    clear: both;
    width: 665px;
    margin: 0;
}
.divYayinlar .time {background-color: #E3E3E3;
    font-size: 20px;
    width: 60px;
    height: 30px;
    float: left;
    text-align: center;
    color: #000080;
    padding-top: 20px;
}

.divYayinlar .programsInfo {
    text-align: left;
    font-size: 16px;
    font-weight: bold;
    width: 575px;
    height: 40px;
    float: left;
    background-color: #fff;
    padding: 10px;
}

	</style>
	
</head>

<body>

<?php
//   ****************************************
//   ***   İlk Pazartesini bulur
//   ****************************************

$dow = date("w");
// How many days ago was monday?
$offset = ($dow -1);
if ($offset <0) {
    $offset = 6;
}

//   ****************************************
//   ***   Ona göre gereken günleri hesaplar
//   ****************************************
$ttt= date("d-m-Y", mktime(0,0,0,date('m'), date('d')-$offset, date('Y')));
$Pazartesi = DosyaBul($ttt);

$Sali = date('Y-m-d', strtotime($ttt . '+1 day'));
$Sali = DosyaBul($Sali);

$Carsamba = date('Y-m-d', strtotime($ttt . '+2 day'));
$Carsamba = DosyaBul($Carsamba);

$Persembe = date('Y-m-d', strtotime($ttt . '+3 day'));
$Persembe = DosyaBul($Persembe);

$Cuma = date('Y-m-d', strtotime($ttt . '+4 day'));
$Cuma = DosyaBul($Cuma);

$Cumartesi = date('Y-m-d', strtotime($ttt . '+5 day'));
$Cumartesi = DosyaBul($Cumartesi);

$Pazar = date('Y-m-d', strtotime($ttt . '+6 day'));
$Pazar = DosyaBul($Pazar);



echo "Pazartesi : " . $Pazartesi . "<br/>";
echo "Salı : " . $Sali . "<br/>";
echo "Carsamba : " . $Carsamba . "<br/>";
echo "Persembe : " . $Persembe . "<br/>";
echo "Cuma : " . $Cuma . "<br/>";
echo "Cumartesi : " . $Cumartesi . "<br/>";
echo "Pazar : " . $Pazar . "<br/>";
?>
<hr/>
<hr/>
<?php
require('./PHPExcel_1.8.0/Classes/PHPExcel.php');
/*
$objReader = PHPExcel_IOFactory::createReaderForFile('2016-10-26.xlsx');
$objReader->setLoadSheetsOnly(0);
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load('2016-10-26.xlsx');

echo "<div class='divYayinlar'>";
$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow(); 
for ($row = 2; $row <= $highestRow; $row++)
{
	$Saat = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$row);
	$S = PHPExcel_Style_NumberFormat::toFormattedString($Saat->getCalculatedValue(), 'hh:mm:ss');
	$Program = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$row);
	$S = $result = substr($S, 0, 5);
	echo "<div class='time'>" .$S . "</div><div class='programsInfo'>" . $Program . "</div>";
}
echo "</div>";
*/
echo "<div>";
$eee = YayinAkisi($Persembe);
echo $eee;
echo "</div></div>";
$eee = YayinAkisi($Cuma);
echo $eee;
echo "</div>";


/*
$inndex=0;
$loadedSheetNames = $objPHPExcel->getSheetNames();
foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    // echo $sheetIndex, ' -> ', $loadedSheetName, '<br />';
	if ($loadedSheetName=='data')
	{
	$inndex = $sheetIndex;
	}
}

echo "<hr />";
*/


?>
</body>
</html>

<?php


 

 
// ****** Eğer o günün tarhli dosyası yoksa, bir önceki en ugun olanı bulur. 
function DosyaBul($tarih)
{
	if (!file_exists($tarih . '.xlsx'))
	{
		$tarih = date('Y-m-d', strtotime($tarih . '-7 day'));
		if (!file_exists($tarih . '.xlsx'))
		{
			$tarih = date('Y-m-d', strtotime($tarih . '-7 day'));
			if (!file_exists($tarih . '.xlsx'))
				{
				$tarih = date('Y-m-d', strtotime($tarih . '-7 day'));
				if (!file_exists($tarih . '.xlsx'))
					{
					$tarih = date('Y-m-d', strtotime($tarih . '-7 day'));
					}
				}
		}
	}
	return $tarih;
}
 
// ****** Excel tablosunu ekrana basar
function YayinAkisi($tarih)
{
	$Ekran = "";
	$DosyaAdi = $tarih . ".xlsx";
	$objReader = PHPExcel_IOFactory::createReaderForFile($DosyaAdi);
	$objReader->setLoadSheetsOnly(0);
	$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load($DosyaAdi);

	$Ekran = $Ekran . "<div class='divYayinlar'>";
	$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow(); 
	for ($row = 2; $row <= $highestRow; $row++)
	{
		$Saat = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$row);
		$S = PHPExcel_Style_NumberFormat::toFormattedString($Saat->getCalculatedValue(), 'hh:mm:ss');
		$Program = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$row);
		$S = $result = substr($S, 0, 5);
		$Ekran = $Ekran . "<div class='time'>" .$S . "</div><div class='programsInfo'>" . $Program . "</div>";
	}
	$Ekran = $Ekran .  "</div>";
	$objReader = null;
	$objReader = null;
	return $Ekran;	
}
?>

