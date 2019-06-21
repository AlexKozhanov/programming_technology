<?php
$db_database = "online_store";
	$mysqli = new Mysqli('localhost', 'pasha', '643105', $db_database);
	$count_record_for_one_page = 10;
	$parametr = $_GET["page"];
	$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;

	// подключаем шрифты
		define('FPDF_FONTPATH',"fpdf/font/");
	// подключаем библиотеку
		require('fpdf/fpdf.php');

	// создаем PDF документ
		$pdf=new FPDF('L');
	// устанавливаем заголовок документа
		$pdf->SetTitle("pdf_document");

	// создаем страницу
		$pdf->AddPage('P');
		$pdf->SetDisplayMode(real,'default');
		
	// добавляем шрифт ариал
		$pdf->AddFont('Arial','','arial.php'); 
	// устанавливаем шрифт Ариал
		$pdf->SetFont('Arial');
	// устанавливаем цвет шрифта
		$pdf->SetTextColor(250,60,100);
	// устанавливаем размер шрифта
		$pdf->SetFontSize(10);

	// добавляем текст
		//$pdf->SetXY(10,10);
		//$pdf->Write(0,iconv('utf-8', 'windows-1251',"Коммерческое предложение"));
		

	// 1 ячейка
$pdf->SetTextColor( 0, 0, 0 );
$pdf->SetFillColor( 143, 173, 204 );
$pdf->Cell( 20, 12, iconv('utf-8', 'windows-1251',"Название"), 1, 0, 'L', true );
// 2 ячейка
$pdf->SetTextColor(  0, 0, 0  );
$pdf->SetFillColor( 143, 173, 204  );
$pdf->Cell( 42, 12, iconv('utf-8', 'windows-1251',"Категория"), 1, 0, 'L', true );
// 3 ячейка
$pdf->SetTextColor(  0, 0, 0  );
$pdf->SetFillColor( 143, 173, 204  );
$pdf->Cell( 41, 12,iconv('utf-8', 'windows-1251',"Страна производитель"), 1, 0, 'L', true );
// 4 ячейка
$pdf->SetTextColor(  0, 0, 0  );
$pdf->SetFillColor( 143, 173, 204  );
$pdf->Cell( 33, 12, iconv('utf-8', 'windows-1251'," Краткое описание"), 1, 0, 'L', true );
// 5 ячейка
$pdf->SetTextColor(  0, 0, 0  );
$pdf->SetFillColor( 143, 173, 204  );
//$pdf->Write(0,iconv('utf-8', 'windows-1251'," Полное описание"));
$pdf->Cell( 33, 12, iconv('utf-8', 'windows-1251'," Полное описание"), 1, 0, 'L', true );
// 6 ячейка
/*$pdf->SetTextColor(  0, 0, 0  );
$pdf->SetFillColor( 143, 173, 204  );
$pdf->Cell( 30, 12, iconv('utf-8', 'windows-1251'," Цена"), 1, 0, 'L', true );*/
$pdf->Ln( 12 );
	// добавляем на страницу изображение    
		//$pdf->Image(dirname(__FILE__) .'/logo.jpg', 100, 250, 100, 49, 'JPG');
		
		
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
			$pdf->Cell( 20, 12, iconv('utf-8', 'windows-1251',$name_result), 1, 0, 'L', true );
			//echo "123<br>";
			
			
			for($i = 0;$i < count($category[id]);$i++)
			{
				if($category[id][$i] == $id_category_result)
				{
					//$pdf->Cell( 46, 12, $id_category_result, 1, 0, 'L', true );
					//$users[category][] = $producing_country[name][$i];
					$pdf->Cell( 42, 12, iconv('utf-8', 'windows-1251',$category[name][$i]), 1, 0, 'L', true );
				}
			}
			
			
			
			for($j = 0;$j < count($producing_country[id]);$j++)
			{				
				if($producing_country[id][$j] == $id_producing_country_result)
				{
					//$pdf->Cell( 46, 12, $id_producing_country_result, 1, 0, 'L', true );
					//$users[producing_country][] = $producing_country[name][$i];
					$pdf->Cell( 41, 12,iconv('utf-8', 'windows-1251',$producing_country[name][$j]), 1, 0, 'L', true );
				}
			}
			$pdf->Cell( 33, 12, iconv('utf-8', 'windows-1251',$s_description_result), 1, 0, 'L', true );
			$pdf->Cell( 33, 12, iconv('utf-8', 'windows-1251',$description_result), 1, 0, 'L', true );
			//$users[producing_country][] = $id_producing_country_result;
			//$users[price][] = $price_result;
			//$pdf->Cell( 30, 12, iconv('utf-8', 'windows-1251',$price_result), 1, 0, 'L', true );
			$pdf->Ln( 12 );
		}
	// выводим документа в браузере
	   $pdf->Output('iskspb.ru.pdf','I'); 
	   
	   ?>