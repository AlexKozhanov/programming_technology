<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>База данных <?echo $db_database;?></title>
<script src="jquery-1.7.2.min.js"></script>
<script type="text/JavaScript">
var select_table = '';
var spann_name_basa = 'online_store';

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}
var old_name_table = '';
function update_page()
{
	//spann_name_basa = document.querySelector(".spann_name_basa").textContent;
	console.log(spann_name_basa);
	//var str_prepare = "SELECT TABLE_NAME FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = ?";
	//var parametr = "";
	console.log(name);
	jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:1, name_table:'INFORMATION_SCHEMA', parametr:null}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
					jQuery('.rowss tr').remove();
                    jQuery('.rowss').append(function(){
						var res = '<tr><td><b>Таблицы</b></td></tr>';
						console.log(result);
						for(var i = 0; i < result.users['TABLE_NAME'].length; i++){
							res += '<tr>';
							
							res += "<td><a href=\"table.php?name_table=" + result.users['TABLE_NAME'][i] + "&name_basa="+ spann_name_basa +"\">"+ result.users['TABLE_NAME'][i] +"</a></td>";
							//res+="<td><span style='margin-left:100px;'></span><a href='#' onClick=\"select_database='"+ result.users['TABLE_NAME'][i].Database +"'; delete_database();\">Удалить</a></td>";
							//res += "<td><a href='#' onClick=\"select_table='"+result.users["TABLE_NAME"][i]+"'; remove_table(); update_page();\">Удалить</a></td>";
							//res += "<td><a href='#' onClick=\"old_name_table='"+result.users['TABLE_NAME'][i]+"'; rename_table();\">Переименовать</a></td>";
							
							res += '</tr>';
							//res += '<tr><td>' + result.users[id] + '</td><td>' + result.users.name[i] + '</td><td>' + result.users.surname[i] + '</td><td>' + result.users.age[i] + '</td></tr>';
						}
							return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
    });
}


jQuery(document).ready(function() {
    jQuery(".button").bind("click", function() {
		var count_attrib = +jQuery(".length_table").val();
		var res = '';
		jQuery('.rows tr').remove();
		jQuery('.rows').append(function(){
			res += '<tr><td>Имя атрибута</td><td>Тип занчения</td><td>Длина значения</td><td>NULL</td><td>AUTO_INCREMENT</td><tr>';
			for(var i = 0;i<count_attrib;i++)
			{
				res+="<tr><td><input type='text' size='30' class='name_attrib" + i +"'/></td>";
				res+="<td><select name='hero' class='type_attrib" + i +"'><option value='INT'>INT</option><option>VARCHAR</option><option>FLOAT</option><option>TEXT</option></select></td>";
				//res+="<select class='type_attrib" + i +"' name='select_type'><option>INT</option><option>VARCHAR</option><option>FLOAT</option><option>TEXT</option></select>";
				
				//res+="<td><input type='text' size='20' class='type_attrib" + i +"'/></td>"; // int varchar float text
				res+="<td><input type='text' size='10' class='len_attrib" + i +"'/></td>";
				res+="<td><input type ='checkbox' class='checkbox_null"+ i +"'/></td>";
				res+="<td><input type ='checkbox' class='checkbox_autoincrement"+ i +"'/></td></tr>";
			}
			res+= "<tr><td align='center'><input type='submit' name='nazvanie_knopki' value='Создать' class='button2' onClick='ht();'/></td><tr>";
			return res;
		});
		
	});
	
});
</script>
</head>

<body>
<div style="height:20px;"></div>
<h1 align="center">База данных "<i class="spann_name_basa"><?echo "online store";?></i>"</h1>
<table width="80%" border="0" align="center" style="margin:0 auto;">
	
</table>
<table class="rowss" style="margin-left:130px;">		
		<tr><td><h2>Таблицы</h2></td></tr>
		<tr><td><a href='table.php?name_table=advertising&name=Реклама'>Реклама</a></td></tr>
		<tr><td><a href="table.php?name_table=category&name=Категории товаров">Категории товаров</a></td></tr>
		<tr><td><a href="table.php?name_table=competitors&name=Конкуренты">Конкуренты</a></td></tr>
		<tr><td><a href="table.php?name_table=developers&name=Работники">Работники</a></td></tr>
		<tr><td><a href="table.php?name_table=developers_section&name=Кто где работает">Кто где работает</a></td></tr>
		<tr><td><a href="table.php?name_table=partners&name=Партнеры">Партнеры</a></td></tr>
		<tr><td><a href="table.php?name_table=producing_country&name=Страны производители">Страны производители</a></td></tr>
		<tr><td><a href="table.php?name_table=product5&name=Товары">Товары</a></td></tr>
		<tr><td><a href="table.php?name_table=section&name=Секции">Секции</a></td></tr>
		<tr><td><a href="table.php?name_table=shopping_opportunities&name=Магазины">Магазины</a></td></tr>
		<tr><td><a href="table.php?name_table=users&name=Пользователи">Пользователи</a></td></tr>
		
		
		<? //№1 структура
			/*$name_attrib = mysql_query("SELECT TABLE_NAME FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA`='$db_database'");
			while($name_attrib_list = mysql_fetch_array($name_attrib))
			{
				printf("
				<tr>
					<td><a href='table.php?name_basa=$db_database&name_table=$name_attrib_list[0]'>$name_attrib_list[0]</a></td>
					<td>тип</td>
					<td><a href='base_data.php'>Изменить</a></td>
					<td><a href='#' onclick='remove_table();name_table = $name_attrib_list[0];'>Удалить</a></td>
					<td><a href='base_data.php'>Описаниее таблицы DESCRIBE table1;</a></td>
				</tr>
				");
			}*/
		?>
		<!--<script>update_page();</script>-->
	
	</table>
	<table border="0" width="80%" style="margin-top:50px; margin-left:130px;">
	<!-- <div style="margin-left:50px;">
	<h2>Создать новую таблицу</h2>
	<span> </span>Имя таблицы: <input type="text" size="50" name="name_table" class="name_table" /> <span> </span>Количество столбцов: <input type="text" size="5" name="length_table" class="length_table"/></p>
	<input type="submit" name="nazvanie_knopki" value="Заполнить" class="button"/>
	<table class="rows" style="margin-left:100px; margin-bottom:50px;">
	
	</table>
	</div> -->
	






        
</table>
</body>
<style>
a{color:#000; }
body{
	background-image:url(img/background-6.jpg);
}
.text_index{color:#026B90;
font-family:"Times New Roman", Times, serif;}
#elem{
	display:none;
}
a.knopka {
  color: #fff; /* цвет текста */
  text-decoration: none; /* убирать подчёркивание у ссылок */
  user-select: none; /* убирать выделение текста */
  background: rgb(37,37,37); /* фон кнопки */
  padding: .7em 1.5em; /* отступ от текста */
  outline: none; /* убирать контур в Mozilla */
} 
a.knopka:hover { background: rgb(37,37,37); } /* при наведении курсора мышки */
a.knopka:active { background: rgb(184,184,184); } /* при нажатии */
</style>
</html>