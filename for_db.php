<?
$db_database = "programming_technology";
$mysqli = new Mysqli('localhost', 'pasha', '643105', $db_database);
/** Получаем наш ID статьи из запроса */
$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$age = intval($_POST['age']);
$parametr = trim($_POST['parametr']);
$p_name_table = trim($_POST['select_name_table']);
$select_name_table = intval($_POST['select_name_table']);
//$p_name_table = 'category';

//$name = "SELECT * FROM producing_country";
//$db_database = 'base_data';
//$name = "SELECT TABLE_NAME FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = ?";
//$parametr = 'none';
//$name = "SELECT `COLUMN_NAME`,`COLUMN_TYPE` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA` = ? AND `TABLE_NAME` = ?";
//$parametr = 'programming_technology';
//$name = $_GET['name'];
/** Если нам передали ID то обновляем */
$mode = intval($_POST['mode']);
$name_table = trim($_POST['name_table']);
$parametr = trim($_POST['parametr']);

/*$mode = 2;
$name_table = "advertising";
$parametr = "444,777,222";*/
$count_record_for_one_page = 10;
if($mode == 1){ // SELECT
	if($name_table == "INFORMATION_SCHEMA"){
		$stmt = $mysqli->prepare("SELECT TABLE_NAME FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology'");
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($table_name);
		while ($stmt->fetch()) {
			$users[TABLE_NAME][] = $table_name;
		}
		$attrib[] = "TABLE_NAME";
	}
	else if($name_table == "advertising"){ // реклама
		$stmt = $mysqli->prepare('SELECT id,name,url,price FROM advertising LIMIT 10 OFFSET ?');
		$foreign_keys[id] = null;
		$foreign_keys[name] = null;
		$foreign_keys[url] = null;
		$foreign_keys[price] = null;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d", $bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $name_result, $url_result, $price_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[name][] = $name_result;
			$users[url][] = $url_result;
			$users[price][] = $price_result;
		}
		$attrib[] = "id";
		$attrib[] = "name";
		$attrib[] = "url";
		$attrib[] = "price";
		
		$attrib2[] = "id";
		$attrib2[] = "Название фирмы";
		$attrib2[] = "Адрес сайта";
		$attrib2[] = "Цена";
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'advertising'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "category"){ // категория
		$stmt = $mysqli->prepare('SELECT * FROM category LIMIT 10 OFFSET ?');
		$foreign_keys[id] = null;
		$foreign_keys[name] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d",$bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $category_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[category][] = $category_result;
		}
		$attrib[] = "id";
		$attrib[] = "category";
		
		$attrib2[] = "id";
		$attrib2[] = "Категория";
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'category'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "competitors"){ // конкуренты
		$stmt = $mysqli->prepare('SELECT * FROM competitors LIMIT 10 OFFSET ?');
		$foreign_keys[id] = null;
		$foreign_keys[name] = null;
		$foreign_keys[url] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d",$bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $name_result, $url_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[name][] = $name_result;
			$users[url][] = $url_result;
		}
		$attrib[] = "id";
		$attrib[] = "name";
		$attrib[] = "url";
		
		$attrib2[] = "id";
		$attrib2[] = "Название фирмы";
		$attrib2[] = "Адрес сайта";
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'competitors'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "partners"){ // партнеры
		$stmt = $mysqli->prepare('SELECT * FROM partners LIMIT 10 OFFSET ?');
		$foreign_keys[id] = null;
		$foreign_keys[name] = null;
		$foreign_keys[telephone] = null;
		$foreign_keys[url] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d",$bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $name_result, $telephone_result, $url_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[name][] = $name_result;
			$users[telephone][] = $telephone_result;
			$users[url][] = $url_result;
		}
		$attrib[] = "id";
		$attrib[] = "name";
		$attrib[] = "telephone";
		$attrib[] = "url";
		
		$attrib2[] = "id";
		$attrib2[] = "Название фирмы";
		$attrib2[] = "Телефон";
		$attrib2[] = "Адрес сайта";
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'partners'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "producing_country"){ // страна производитель
		$stmt = $mysqli->prepare('SELECT * FROM producing_country LIMIT 10 OFFSET ?');
		$foreign_keys[id] = null;
		$foreign_keys[country] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d",$bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $country_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[country][] = $country_result;
		}
		$attrib[] = "id";
		$attrib[] = "country";
		
		$attrib2[] = "id";
		$attrib2[] = "Страна";
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'producing_country'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "product5"){ // продукт5
		//$stmt = $mysqli->prepare('select * from product5 JOIN (SELECT id from product5 ORDER by id LIMIT 10 OFFSET ?) as b on b.id = product5.id');
		$stmt = $mysqli->prepare('SELECT * FROM `product5` FORCE INDEX (PRIMARY) ORDER BY id LIMIT ?, 10');
		$foreign_keys[0] = null;
		$foreign_keys[1] = null;
		$foreign_keys[4] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d", $bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $name_result, $id_category_result, $id_producing_country_result, $s_description_result, $description_result, $price_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[name][] = $name_result;
			$users[id_category][] = $id_category_result;
			$users[id_producing_country][] = $id_producing_country_result;
			$users[s_description][] = $s_description_result;
			$users[description][] = $description_result;
			$users[price][] = $price_result;
		}
		$attrib[] = "id";
		$attrib[] = "name";
		$attrib[] = "id_category";
		$attrib[] = "id_producing_country";
		$attrib[] = "s_description";
		$attrib[] = "description";
		//$attrib[] = "price";
		
		$attrib2[] = "id";
		$attrib2[] = "Название";
		$attrib2[] = "Категория";
		$attrib2[] = "Страна производитель";
		$attrib2[] = "Краткое описание";
		$attrib2[] = "Полное описание";
		//$attrib2[] = "Цена";
		//////////////
		$stmt3 = $mysqli->prepare("SELECT * FROM category");
		
		if (!$stmt3->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt3->bind_result($id_result,$name_result);
		while ($stmt3->fetch()) {
			$foreign_keys[2][0][] = $id_result;
			$foreign_keys[2][1][] = $name_result;
		}
		//////////////
		$stmt4 = $mysqli->prepare("SELECT * FROM producing_country");
		
		if (!$stmt4->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt4->bind_result($id_result,$county_result);
		while ($stmt4->fetch()) {
			$foreign_keys[3][0][] = $id_result;
			$foreign_keys[3][1][] = $county_result;
		}
		//////////////
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'product5'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "product4"){ // продукт4
		//$stmt = $mysqli->prepare('select * from product4 JOIN (SELECT id from product4 ORDER by id LIMIT 10 OFFSET ?) as b on b.id = product4.id');
		$stmt = $mysqli->prepare('SELECT * FROM `product4` FORCE INDEX (PRIMARY) ORDER BY id LIMIT ?, 10');
		$foreign_keys[0] = null;
		$foreign_keys[1] = null;
		$foreign_keys[4] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d", $bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $name_result, $key_name_result, $key_word_result, $id_category_result, $id_producing_country_result, $s_description_result, $description_result, $composition_result, $price_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[name][] = $name_result;
			$users[key_name][] = $key_name_result;
			$users[key_word][] = $key_word_result;
			$users[id_category][] = $id_category_result;
			$users[id_producing_country][] = $id_producing_country_result;
			$users[s_description][] = $s_description_result;
			$users[description][] = $description_result;
			$users[composition][] = $composition_result;
			$users[price][] = $price_result;
		}
		$attrib[] = "id";
		$attrib[] = "name";
		$attrib[] = "key_name";
		$attrib[] = "key_word";
		$attrib[] = "id_category";
		$attrib[] = "id_producing_country";
		$attrib[] = "s_description";
		$attrib[] = "description";
		$attrib[] = "composition";
		$attrib[] = "price";
		
		$attrib2[] = "id";
		$attrib2[] = "Название";
		$attrib2[] = "Ключевое название";
		$attrib2[] = "Ключевое слово";
		$attrib2[] = "Категория";
		$attrib2[] = "Страна производитель";
		$attrib2[] = "Краткое описание";
		$attrib2[] = "Полное описание";
		$attrib2[] = "Состав";
		$attrib2[] = "Цена";
		//////////////
		$stmt3 = $mysqli->prepare("SELECT * FROM category");
		
		if (!$stmt3->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt3->bind_result($id_result,$name_result);
		while ($stmt3->fetch()) {
			$foreign_keys[4][0][] = $id_result;
			$foreign_keys[4][1][] = $name_result;
		}
		//////////////
		$stmt4 = $mysqli->prepare("SELECT * FROM producing_country");
		
		if (!$stmt4->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt4->bind_result($id_result,$county_result);
		while ($stmt4->fetch()) {
			$foreign_keys[5][0][] = $id_result;
			$foreign_keys[5][1][] = $county_result;
		}
		//////////////
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'product4'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "section"){ // отделы
		$stmt = $mysqli->prepare('SELECT * FROM section LIMIT 10 OFFSET ? ');
		
		
		$foreign_keys[id] = null;
		$foreign_keys[name] = null;
		
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d",$bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $name_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[name][] = $name_result;
		}
		
		$attrib[] = "id";
		$attrib[] = "name";
		
		
		$attrib2[] = "id";
		$attrib2[] = "Название отдела";
		
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'section'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "shopping_opportunities"){ // магазины
		$stmt = $mysqli->prepare('SELECT * FROM shopping_opportunities LIMIT 10 OFFSET ?');
		$foreign_keys[id] = null;
		$foreign_keys[address] = null;
		$foreign_keys[count_person] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d",$bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $address_result, $count_person_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[address][] = $address_result;
			$users[count_person][] = $count_person_result;
		}
		$attrib[] = "id";
		$attrib[] = "address";
		$attrib[] = "count_person";
		
		$attrib2[] = "id";
		$attrib2[] = "Адрес";
		$attrib2[] = "Колличество работников";
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'shopping_opportunities'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "users"){ // пользователи
		$stmt = $mysqli->prepare('SELECT * FROM users LIMIT 10 OFFSET ?');
		$foreign_keys[id] = null;
		$foreign_keys[name] = null;
		$foreign_keys[password] = null;
		$foreign_keys[address] = null;
		$foreign_keys[bonus] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d", $bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $name_result, $password_result, $address_result, $bonus_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[name][] = $name_result;
			$users[password][] = $password_result;
			$users[address][] = $address_result;
			$users[bonus][] = $bonus_result;
		}
		$attrib[] = "id";
		$attrib[] = "name";
		$attrib[] = "password";
		$attrib[] = "address";
		$attrib[] = "bonus";
		
		$attrib2[] = "id";
		$attrib2[] = "Имя";
		$attrib2[] = "Пароль";
		$attrib2[] = "Домашний адрес";
		$attrib2[] = "Бонусы";
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'users'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "developers"){ // сотрудники магазина
		$stmt = $mysqli->prepare('SELECT * FROM developers LIMIT 10 OFFSET ?');
		$foreign_keys[0] = null;
		$foreign_keys[1] = null;
		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d", $bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $name_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[name][] = $name_result;
		}
		$attrib[] = "id";
		$attrib[] = "name";
		
		$attrib2[] = "id";
		$attrib2[] = "Ф.И.О";
		
		//////////////
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'developers'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
	else if($name_table == "developers_section"){ // связь секций и сотрудников
		$stmt = $mysqli->prepare('SELECT * FROM developers_section ORDER BY id_developers LIMIT 10 OFFSET ?');
		$foreign_keys[0] = null;

		$top = $parametr*$count_record_for_one_page;
		$bottom = $parametr*$count_record_for_one_page-$count_record_for_one_page;
		$stmt->bind_param("d", $bottom);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id_result, $id_developers_result, $id_section_result);
		while ($stmt->fetch()) {
			$users[id][] = $id_result;
			$users[id_developers][] = $id_developers_result;
			$users[id_section][] = $id_section_result;
		}
		$attrib[] = "id";
		$attrib[] = "id_developers";
		$attrib[] = "id_section";
;
		
		$attrib2[] = "id";
		$attrib2[] = "Ф.И.О.";
		$attrib2[] = "Секция";
		//////////////
		$stmt3 = $mysqli->prepare("SELECT * FROM developers");
		
		if (!$stmt3->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt3->bind_result($id_result,$name_result);
		while ($stmt3->fetch()) {
			$foreign_keys[1][0][] = $id_result;
			$foreign_keys[1][1][] = $name_result;
		}
		//////////////
		$stmt4 = $mysqli->prepare("SELECT * FROM section");
		
		if (!$stmt4->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt4->bind_result($id_result,$name_result);
		while ($stmt4->fetch()) {
			$foreign_keys[2][0][] = $id_result;
			$foreign_keys[2][1][] = $name_result;
		}
		//////////////
		$stmt2 = $mysqli->prepare("SELECT TABLE_ROWS FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = 'programming_technology' AND TABLE_NAME = 'developers_section'");
		
		if (!$stmt2->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt2->bind_result($count_record_result);
		while ($stmt2->fetch()) {
			$count_record = $count_record_result;
		}
	}
}
else if($mode == 2){ // INSERT
	// INSERT INTO person(name,age)VALUES(?,?)
	$arr = explode(',',$parametr);
	if($name_table == "advertising")
	{
		$stmt2 = $mysqli->prepare('select id from advertising where name = ? and url = ? and price = ?');
		$stmt2->bind_param("ssd", $arr[0],$arr[1],$arr[2]);
		if (!$stmt2->execute())
		{
			$errors = "Не удалось выполнить запрос: (" . $stmt2->errno . ") " . $stmt2->error;
		}
		$stmt2->store_result();
		if ($stmt2->num_rows == 0)
		{
			$stmt2->close();
			$stmt = $mysqli->prepare('INSERT INTO advertising(name,url,price)VALUES(?,?,?)');
			$stmt->bind_param("ssd", $arr[0],$arr[1],$arr[2]);
			if (!$stmt->execute())
			{
				$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
			}
			$res=true;
		}
		else
		{
			$res=false;
		}	
	}
	else if($name_table == "category"){
		$stmt = $mysqli->prepare('INSERT INTO category(category)VALUES(?)');
		$stmt->bind_param("s", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "competitors"){
		$stmt = $mysqli->prepare('INSERT INTO competitors(name,url)VALUES(?,?)');
		$stmt->bind_param("ss", $arr[0],$arr[1]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "developers"){
		$stmt = $mysqli->prepare('INSERT INTO developers(name,id_section1,id_section2)VALUES(?,?,?)');
		$stmt->bind_param("sdd", $arr[0],$arr[1],$arr[2]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "developers_section"){
		$stmt = $mysqli->prepare('INSERT INTO developers_section(id_developers,id_section)VALUES(?,?)');
		$stmt->bind_param("dd", $arr[0],$arr[1]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
			$res = false;
		}else{$res = true;}
	}
	else if($name_table == "partners"){
		$stmt = $mysqli->prepare('INSERT INTO partners(name,telephone,url)VALUES(?,?,?)');
		$stmt->bind_param("sss", $arr[0],$arr[1],$arr[2]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "producing_country"){
		$stmt = $mysqli->prepare('INSERT INTO producing_country(country)VALUES(?)');
		$stmt->bind_param("s", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "product"){
		$stmt = $mysqli->prepare('INSERT INTO product(name,id_category,id_producing_country,price)VALUES(?,?,?,?)');
		$stmt->bind_param("sddd", $arr[0],$arr[1],$arr[2],$arr[3]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "section"){
		$stmt = $mysqli->prepare('INSERT INTO section(name)VALUES(?)');
		$stmt->bind_param("s", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "shopping_opportunities"){
		$stmt = $mysqli->prepare('INSERT INTO shopping_opportunities(address,count_person)VALUES(?,?)');
		$stmt->bind_param("sd", $arr[0],$arr[1]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "users"){
		$stmt = $mysqli->prepare('INSERT INTO users(name,password,address,bonus)VALUES(?,?,?,?)');
		$stmt->bind_param("sssd", $arr[0],$arr[1],$arr[2],$arr[3]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
}
else if($mode == 3){ // UPDATE
	// UPDATE person SET name = "?", age = "?" WHERE id = ?
	$arr = explode(',',$parametr);
	if($name_table == "advertising"){
		$stmt = $mysqli->prepare('UPDATE advertising SET name = ?,url = ?,price = ? WHERE id = ?');
		$stmt->bind_param("ssdd", $arr[0],$arr[1],$arr[2],$arr[3]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "category"){
		$stmt = $mysqli->prepare('UPDATE category SET category = ? WHERE id = ?');
		$stmt->bind_param("sd", $arr[0],$arr[1]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "competitors"){
		$stmt = $mysqli->prepare('UPDATE competitors SET name = ?,url = ? WHERE id = ?');
		$stmt->bind_param("ssd", $arr[0],$arr[1],$arr[2]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "developers"){
		$stmt = $mysqli->prepare('UPDATE developers SET name = ? WHERE id = ?');
		$stmt->bind_param("sd", $arr[0],$arr[1]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "developers_section"){
		$res = $stmt = $mysqli->prepare('UPDATE developers_section SET id_developers = ?, id_section = ? WHERE id = ?');
		$stmt->bind_param("ddd", $arr[0],$arr[1],$arr[2]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
			$res = false;
		}else{$res = true;}
	}
	else if($name_table == "partners"){
		$stmt = $mysqli->prepare('UPDATE partners SET name = ?,telephone = ?,url = ? WHERE id = ?');
		$stmt->bind_param("sssd", $arr[0],$arr[1],$arr[2],$arr[3]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "producing_country"){
		$stmt = $mysqli->prepare('UPDATE producing_country SET country = ? WHERE id = ?');
		$stmt->bind_param("sd", $arr[0],$arr[1]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "product"){
		$stmt = $mysqli->prepare('UPDATE product SET name = ?,id_category = ?,id_producing_country = ?,price = ? WHERE id = ?');
		$stmt->bind_param("sdddd", $arr[0],$arr[1],$arr[2],$arr[3],$arr[4]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "section"){
		$stmt = $mysqli->prepare('UPDATE section SET name = ? WHERE id = ?');
		$stmt->bind_param("sd", $arr[0],$arr[1]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "shopping_opportunities"){
		$stmt = $mysqli->prepare('UPDATE shopping_opportunities SET address = ?,count_person = ? WHERE id = ?');
		$stmt->bind_param("sdd", $arr[0],$arr[1],$arr[2]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "users"){
		$stmt = $mysqli->prepare('UPDATE users SET name = ?,password = ?,address = ?,bonus = ? WHERE id = ?');
		$stmt->bind_param("sssdd", $arr[0],$arr[1],$arr[2],$arr[3],$arr[4]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
}
else if($mode == 4){ // DELETE
	// DELETE FROM person WHERE id = "?"
	$arr = explode(',',$parametr);
	if($name_table == "advertising"){
		$stmt = $mysqli->prepare('DELETE FROM advertising WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "category"){
		$stmt = $mysqli->prepare('DELETE FROM category WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "competitors"){
		$stmt = $mysqli->prepare('DELETE FROM competitors WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "developers"){
		$stmt = $mysqli->prepare('DELETE FROM developers WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "developers_section"){
		$stmt = $mysqli->prepare('DELETE FROM developers_section WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "partners"){
		$stmt = $mysqli->prepare('DELETE FROM partners WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "producing_country"){
		$stmt = $mysqli->prepare('DELETE FROM producing_country WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "product5"){
		$stmt = $mysqli->prepare('DELETE FROM product5 WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "section"){
		$stmt = $mysqli->prepare('DELETE FROM section WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "shopping_opportunities"){
		$stmt = $mysqli->prepare('DELETE FROM shopping_opportunities WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if($name_table == "users"){
		$stmt = $mysqli->prepare('DELETE FROM users WHERE id = ?');
		$stmt->bind_param("d", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
}




/** Возвращаем ответ скрипту */

// Формируем масив данных для отправки
$out = array(
	'str' => $str,
	'attrib' => $attrib,
	'attrib2' => $attrib2,
	'foreign_keys' => $foreign_keys,
	'message' => $message,
	'users' => $users,
	'errors' => $errors,
	'str_zapros' => $name,
	'count_record' => $count_record,
	'result' => $res
);

// Устанавливаем заголовот ответа в формате json
header('Content-Type: text/json; charset=utf-8');

// Кодируем данные в формат json и отправляем
echo json_encode($out);

