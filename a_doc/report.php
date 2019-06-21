<?php
require_once("fpdf/fpdf.php");
//$text = iconv('utf-8', 'windows-1251', $text);
// подключаем шрифты
    define('FPDF_FONTPATH',"fpdf/font/");
// добавляем шрифт ариал
	$pdf=new FPDF();
    $pdf->AddFont('Arial','','arial.php'); 
// устанавливаем шрифт Ариал
    $pdf->SetFont('Arial');
	
	$pdf->Write(0,iconv('utf-8', 'windows-1251',"Коммерческое предложение"));

$db_database = "online_store";
$mysqli = new Mysqli('localhost', 'pasha', '643105', $db_database);

$count_record_for_one_page = 10;
$parametr = $_GET["page"];
$top = $parametr*$count_record_for_one_page;
$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
// Начало конфигурации

$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );
$tableHeaderTopTextColour = array( 255, 255, 255 );
$tableHeaderTopFillColour = array( 125, 152, 179 );
$tableHeaderTopProductTextColour = array( 0, 0, 0 );
$tableHeaderTopProductFillColour = array( 143, 173, 204 );
$tableHeaderLeftTextColour = array( 99, 42, 57 );
$tableHeaderLeftFillColour = array( 184, 207, 229 );
$tableBorderColour = array( 50, 50, 50 );
$tableRowFillColour = array( 213, 170, 170 );
$reportName = "Save table product in pdf";
$reportNameYPos = 160;
$logoFile = "widget-company-logo.png";
$logoXPos = 50;
$logoYPos = 108;
$logoWidth = 110;
$columnLabels = array( "Q1", "Q2", "Q3", "Q4" );
$rowLabels = array( "SupaWidget", "WonderWidget", "MegaWidget", "HyperWidget" );
$chartXPos = 20;
$chartYPos = 250;
$chartWidth = 160;
$chartHeight = 80;
$chartXLabel = "Product";
$chartYLabel = "2009 Sales";
$chartYStep = 20000;

$chartColours = array(
                  array( 255, 100, 100 ),
                  array( 100, 255, 100 ),
                  array( 100, 100, 255 ),
                  array( 255, 255, 100 ),
                );

$data = array(
          array( 9940, 10100, 9490, 11730 ),
          array( 19310, 21140, 20560, 22590 ),
          array( 25110, 26260, 25210, 28370 ),
          array( 27650, 24550, 30040, 31980 ),
        );

// Конец конфигурации

$pdf = new FPDF( 'L', 'mm', 'A4' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->AddPage();


// таблица

$pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
$pdf->Ln( 15 );

$pdf->SetFont( 'Arial', 'B', 15 );

// 1 ячейка
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 46, 12, " Название", 1, 0, 'L', true );
// 2 ячейка
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 46, 12, " Категория", 1, 0, 'L', true );
// 3 ячейка
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 55, 12, " Страна производитель", 1, 0, 'L', true );
// 4 ячейка
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 46, 12, " Краткое описание", 1, 0, 'L', true );
// 5 ячейка
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 46, 12, " Полное описание", 1, 0, 'L', true );
// 6 ячейка
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 46, 12, " Цена", 1, 0, 'L', true );
$pdf->Ln( 12 );
//////////////////////////////

$stmt2 = $mysqli->prepare('SELECT * FROM category');
	
	if (!$stmt2->execute()) {
		$errors = "Не удалось выполнить запрос: (" . $stmt2->errno . ") " . $stmt2->error;
	}
		$stmt2->bind_result($id_result,$category_result);
	while ($stmt2->fetch()) {
			$category[id][] = $id_result;
			$category[name][] = $category_result;
		}

/*echo $category[id][0]." ".$category[name][0]."<br>";
echo $category[id][1]." ".$category[name][1]."<br>";
echo $category[id][2]." ".$category[name][2]."<br>";
echo $category[id][3]." ".$category[name][3]."<br>";*/
//////////////////////////////

$stmt3 = $mysqli->prepare('SELECT * FROM producing_country');
	
	if (!$stmt3->execute()) {
		$errors = "Не удалось выполнить запрос: (" . $stmt3->errno . ") " . $stmt3->error;
	}
		$stmt3->bind_result($id_result,$country_result);
	while ($stmt3->fetch()) {
			$producing_country[id][] = $id_result;
			$producing_country[name][] = $country_result;
		}

/*echo $producing_country[id][0]." ".$producing_country[name][0]."<br>";
echo $producing_country[id][1]." ".$producing_country[name][1]."<br>";
echo $producing_country[id][2]." ".$producing_country[name][2]."<br>";
echo $producing_country[id][3]." ".$producing_country[name][3]."<br>";*/
//////////////////////////////
//echo count($category[id])."<br>";
//echo count($producing_country[id])."<br>";

$stmt = $mysqli->prepare('SELECT * FROM `product5` FORCE INDEX (PRIMARY) ORDER BY id LIMIT ?, 10');
	
	$stmt->bind_param("d",$bottom);
	if (!$stmt->execute()) {
		$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
	}
		$stmt->bind_result($id_result, $name_result, $id_category_result, $id_producing_country_result, $s_description_result, $description_result, $price_result);
	while ($stmt->fetch()) {
			//$users[id][] = $id_result;
			//$users[name][] = $name_result;
			$pdf->Cell( 46, 12, $name_result, 1, 0, 'L', false );
			//echo "123<br>";
			
			
			for($i = 0;$i < count($category[id]);$i++)
			{
				if($category[id][$i] == $id_category_result)
				{
					//$pdf->Cell( 46, 12, $id_category_result, 1, 0, 'L', true );
					//$users[category][] = $producing_country[name][$i];
					$pdf->Cell( 46, 12, $category[name][$i], 1, 0, 'L', false );
				}
			}
			
			
			
			for($j = 0;$j < count($producing_country[id]);$j++)
			{				
				if($producing_country[id][$j] == $id_producing_country_result)
				{
					//$pdf->Cell( 46, 12, $id_producing_country_result, 1, 0, 'L', true );
					//$users[producing_country][] = $producing_country[name][$i];
					$pdf->Cell( 55, 12, $producing_country[name][$j], 1, 0, 'L', false );
				}
			}
			//$users[producing_country][] = $id_producing_country_result;
			//$users[price][] = $price_result;
			$pdf->Cell( 46, 12, $price_result, 1, 0, 'L', false );
			$pdf->Ln( 12 );
		}
		
$pdf->Output( "report.pdf", "I" );

