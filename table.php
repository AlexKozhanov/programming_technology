<?/*
$db_host   = 'localhost';
$db_user   = 'pasha';
$db_pass   = '643105';
$db_database = "programming_technology";
$name_table = $_GET["name_table"];

$link = mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_database,$link);
mysql_select_db($db_database,$link) or die("Нет соединения с БД".mysql_error());
mysql_query("SET NAMES utf8");
*/?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?echo $_GET["name"]?></title>
<script src="jquery-1.7.2.min.js"></script>
<script type="text/JavaScript">
var js_name_table = "<?echo $_GET["name_table"];?>";
var span_name_base_data = '';
var span_name_table = '';
var select_id_str = '';
var count_on_one_page = 10;
//var select_id = 0;

var g;
function button_obzor(page){

		jQuery('.change_attrib tr').remove();
		jQuery('.add_atrib tr').remove();
		
        jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:1,name_table:js_name_table,parametr:page}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
				console.log(result);
                if (result){ 
					jQuery('.rows tr').remove();
                    jQuery('.rows').append(function(){
						var res = '';
						if(result.message != null)
						{
							res+='<tr><td>'+ result.message +'</td></tr>';
						}
						if(result.errors != null)
						{
							res+='<tr><td><b>Текст ошибки: </b>'+ result.errors +'</td></tr>';
						}
						else
						{
							g = result;
								if(result.users != null)
								{
									res+= '<tr>';
									for(var i = 1; i< result.attrib2.length; i++)
									{
										res+= '<td><b>' + result.attrib2[i] + '</b></td>';
									}
									res+= '</tr>';
									var id = "id";
									for(var i = 0; i < result.users[result.attrib[0]].length; i++){
										res += '<tr>';
										for(var c = 1; c < result.attrib.length; c++)
										{
											if(typeof result.users[result.attrib[c]] !== 'undefined')
											{
												if(result.foreign_keys[c] != null)
												{
													res += '<td><select class="'+result.attrib[c]+result.users[result.attrib[0]][i]+'">';
													for(var x = 0;x<result.foreign_keys[c][0].length;x++)
													{
														if(result.users[result.attrib[c]][i] == result.foreign_keys[c][0][x])
														{
															res += '<option selected value="'+result.users[result.attrib[c]][i]+'">'+result.foreign_keys[c][1][x]+'</option>';
														}
														else
														{
															res += '<option value ="'+result.foreign_keys[c][0][x]+'">'+result.foreign_keys[c][1][x]+'</option>';
														}
												
													}
													res += '</select></td>';
												}
												else
												{
													res += '<td><textarea name="text_b" cols="20" rows="4" class="'+result.attrib[c]+result.users[result.attrib[0]][i]+'">'+ result.users[result.attrib[c]][i] +'</textarea></td>';
												}
											}
											else
											{
												res += '<td></td>';
											}
										}
										res += '<td><input type="button" value="Сохранить изменения" name="structure" OnClick="update_data('+result.users[result.attrib[0]][i]+','+page+');"></td>';
										res += '<td><input type="button" value="Удалить запись" name="structure" OnClick="delete_data('+result.users[result.attrib[0]][i]+','+page+');"></td></tr>';
										//res += '<tr><td>' + result.users[id] + '</td><td>' + result.users.name[i] + '</td><td>' + result.users.surname[i] + '</td><td>' + result.users.age[i] + '</td></tr>';
									}
									res += '<tr><td>';
									if(page > 4)
									{
										res += '<a href="#" onClick="button_obzor(1)";>1</a> ... ';
										for(var i = page - 4;i<page;i++)
										{
											res += '<a href="#" onClick="button_obzor('+i+');"> '+i+' </a>';
										}
									}
									else
									{
										for(var i = 1;i<page;i++)
										{
											res += '<a href="#" onClick="button_obzor('+i+');"> '+i+' </a>';
										}
									}
									res += " " + page + " ";
									var count_last_page = Math.floor( result.count_record / count_on_one_page ) + 1;
									if(count_last_page - page < 4)
									{
										for(var i = page + 1;i<count_last_page;i++)
										{
											res += '<a href="#" onClick="button_obzor('+i+');"> '+i+' </a>';
										}
									}
									else
									{
										for(var i = page + 1;i<page + 5;i++)
										{
											res += '<a href="#" onClick="button_obzor('+i+');"> '+i+' </a>';
										}
										res += ' ... <a href="#" onClick="button_obzor('+count_last_page+');"> '+count_last_page+' </a>';
									}
									res += '</td></tr>';
									if(js_name_table == "product5"){
										res += '<tr><td><a href="to_pdf.php?page='+page+'" target="_blank">PDF</a></td>';
										res += '<td><a href="table_to_xls2.php?page='+page+'" target="_blank">XLS</a></td></tr>';
									}
								}else
								{
									res += '<tr><td>В таблице нет записей</td></tr>';
								}
							
						}
						// ошибки
							return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
        });
	return false;
}
function sleep(milliseconds) { // убрать есть стандартное
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}
function delete_data(select_id,page)
{
	if(confirm("Вы действительно хотете удалить запись с id = " + select_id + " ?"))
	{
		jQuery.ajax({
			url: "for_db.php",
			type: "POST",
			data: {mode:4,name_table:js_name_table,parametr:select_id}, // Передаем данные для записи
			dataType: "json",
			success: function(result) {
				if (result){ 
					alert("\"Запись успешно удалена\"");
					button_obzor(page);
				}else{
					alert(result.message);
				}
				return false;
			}
		});
	}
}
function update_data(select_id,page)
{
        jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:1,name_table:js_name_table,parametr:1}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){
					var update_value_record = '';
					for(var i = 1; i< result.attrib.length;i++)
					{
						update_value_record += document.querySelector("."+result.attrib[i]+select_id).value + ',';
					}
					update_value_record += select_id;
					//
					console.log(update_value_record);
					jQuery.ajax({
						url: "for_db.php",
						type: "POST",
						data: {mode:3,name_table:js_name_table,parametr:update_value_record}, // Передаем данные для записи
						dataType: "json",
						success: function(result) {
							if (result){ 
								if(result.result){
									alert("Запись обновлена");
									button_obzor(page);
								}
								else{alert("Такая запись уже существует!");}
							}else{
								alert(result.message);
							}
							return false;
						}
					});
                }else{
                    alert(result.message);
                }
				return false;
            }
        });
}

function insert_data(){
	
		jQuery('.change_attrib tr').remove();
		jQuery('.add_atrib tr').remove();
        jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:1,name_table:js_name_table,parametr:1}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
					jQuery('.rows tr').remove();
					jQuery('.rows').append(function(){
						var res = '<tr><td><b>Вставить значение</b></td></tr>';
						console.log(result);
						
							for(var i = 1; i< result.attrib2.length;i++)
							{
								res += '<tr><td>'+result.attrib2[i]+'</td>';
								if(result.foreign_keys[i] != null)
								{
									res += '<td><select class="'+result.attrib[i]+'">';
									for(var x = 0;x<result.foreign_keys[i][0].length;x++)
									{
										res += '<option value="'+result.foreign_keys[i][0][x]+'">'+result.foreign_keys[i][1][x]+'</option>';
									}
									res += '</select></td>';
								}
								else
								{
									res += '<td><input type="text" size="10" class="' + result.attrib[i] +'"/></td></tr>';
								
									//res += '<td><textarea name="text_b" cols="20" rows="4" class="'+result.attrib[c]+result.users[result.attrib[0]][i]+'">'+ result.users[result.attrib[c]][i] +'</textarea></td>';
								}
							
							}
							res += '<tr><td><input type="button" size="10" value="Заполнить" OnClick="add_record();"/></td></tr>';
						
						return res;
					});
					////////////////
					
					////////////////
                }else{
                    alert(result.message);
                }
				return false;
            }
        });
}
function add_record(){
        jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:1,name_table:js_name_table,parametr:1},
            dataType: "json",
            success: function(result) {
                if (result){ 
					var str_add_value = '';
					for(var i =1;i<result.attrib.length;i++)
					{
						str_add_value += document.querySelector("." + result.attrib[i]).value + ',';
					}
					str_add_value = str_add_value.substring(0,str_add_value.length-1);
					console.log(str_add_value);
					jQuery.ajax({
						url: "for_db.php",
						type: "POST",
						data: {mode:2,name_table:js_name_table,parametr:str_add_value}, // Передаем данные для записи
						dataType: "json",
						success: function(result) {
							if (result){ 
								if(result.result){
									document.querySelector('#elem').textContent = "Запись добавлена";
									$("#elem").show('slow');
									setTimeout(function() { $("#elem").hide('slow'); }, 2000);
								}
								else
								{
									alert("Запись уже существует!");
								}
							}else{
								alert(result.message);
							}
							return false;
						}
					});
                }else{
                    alert(result.message);
                }
				return false;
            }
        });
}
</script>
</head>

<body>
<div style="height:20px;"></div>
<a href="base_data.php"  class="knopka" style="margin-left:4px;">Назад</a>
<p style="background:#000; color:#fff;" id="elem" align="center">Элемент</p>
<h1 align="center"><span class="span_name_table"><?echo $_GET["name"]?></span></h1>
<table width="80%" border="0" align="center"><!-- таблица -->
	<tr><!-- стрка -->
		<td><!-- стлбц -->
			<input type="button" value="Обзор данных" onClick="button_obzor(1);" ><!-- ячка 11 -->
		</td>
		<td>
			<input type="button" value="Вставить данные" name="Insert" OnClick="insert_data();"><!-- ячка 12 -->
		</td>

	</tr>
	</table>
	<table class="rows" style="margin-left:130px;">
	
	<script>button_obzor(1);</script>
	
	</table>
	<table class="add_atrib" style="margin-left:130px;">
	
	</table>
	
	<table class="change_attrib" style="margin-left:130px;">
	
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