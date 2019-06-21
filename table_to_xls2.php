<?
	$db_database = "online_store";
	$mysqli = new Mysqli('localhost', 'pasha', '643105', $db_database);
	$parametr = $_GET["page"];
	$count_record_for_one_page = 10;
	$top = $parametr*$count_record_for_one_page;
	$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
  require_once 'PHPExcel-1.8/Classes/PHPExcel.php'; // Подключаем библиотеку PHPExcel
  $phpexcel = new PHPExcel(); // Создаём объект PHPExcel
  /* Каждый раз делаем активной 1-ю страницу и получаем её, потом записываем в неё данные */
  
  $page = $phpexcel->setActiveSheetIndex(0); // Делаем активной первую страницу и получаем её
  
  /////////////////////
  $stmt2 = $mysqli->prepare('SELECT * FROM category');
	
	if (!$stmt2->execute()) {
		$errors = "Не удалось выполнить запрос: (" . $stmt2->errno . ") " . $stmt2->error;
	}
		$stmt2->bind_result($id_result,$category_result);
	while ($stmt2->fetch()) {
			$category[id][] = $id_result;
			$category[name][] = $category_result;
		}
		
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

///////////////////////////////////////////////////////////////////

$stmt = $mysqli->prepare('SELECT * FROM `product5` FORCE INDEX (PRIMARY) ORDER BY id LIMIT ?, 10');
	
	$stmt->bind_param("d", $bottom);
	if (!$stmt->execute()) {
		$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
	}
		$stmt->bind_result($id_result, $name_result, $id_category_result, $id_producing_country_result, $s_description_result, $description_result, $price_result);
		$page->setCellValue("A1", "Название");
		$page->setCellValue("B1", "Категория");
		$page->setCellValue("C1", "Страна производитель");
		$page->setCellValue("D1", "Краткое описание");
		$page->setCellValue("E1", "Полное описание");
		//$page->setCellValue("F1", "Цена");
		$position = 2;
	while ($stmt->fetch()) {
			//$users[id][] = $id_result;
			//$users[name][] = $name_result;
			$p_a = "A".$position;
			$page->setCellValue($p_a, $name_result);
			//$pdf->Cell( 46, 12, $name_result, 1, 0, 'L', false );
			//echo "123<br>";
			
			$p_b = "B".$position;
			for($i = 0;$i < count($category[id]);$i++)
			{
				if($category[id][$i] == $id_category_result)
				{
					$page->setCellValue($p_b, $category[name][$i]);
					//$pdf->Cell( 46, 12, $category[name][$i], 1, 0, 'L', false );
				}
			}
			
			
			$p_c = "C".$position;
			for($j = 0;$j < count($producing_country[id]);$j++)
			{				
				if($producing_country[id][$j] == $id_producing_country_result)
				{
					$page->setCellValue($p_c, $producing_country[name][$j]);
					//$pdf->Cell( 55, 12, $producing_country[name][$j], 1, 0, 'L', false );
				}
			}
			$p_d = "D".$position;
			$page->setCellValue($p_d, $s_description_result);
			
			$p_e= "E".$position;
			$page->setCellValue($p_e, $description_result);
			
			//$p_f = "F".$position;
			//$page->setCellValue($p_f, $price_result);
			//$pdf->Cell( 46, 12, $price_result, 1, 0, 'L', false );
			$position++;
		}
		
		
  /*$f = "A5";
  $page->setCellValue($f, "Hello"); // Добавляем в ячейку A1 слово "Hello"
  $page->setCellValue("A2", "World!"); // Добавляем в ячейку A2 слово "World!"
  $page->setCellValue("B1", "MyRusakov.ru"); // Добавляем в ячейку B1 слово "MyRusakov.ru"*/
  /////////////////////
  $title_page = "product(page ".$parametr.")";
  $page->setTitle($title_page); // Ставим заголовок "Test" на странице
  /* Начинаем готовиться к записи информации в xlsx-файл */
  $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
  /* Записываем в файл */
  $objWriter->save("test.xlsx");

?>