<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ИВТ-161</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<style>    
    TD, TH {
    /*background: rgba(128, 128, 128, 0.19);  Цвет фона ячеек */
    padding: 5px; /* Поля вокруг текста */
   }
    .name{
        background: green;
        margin-top: 20px;
        color: white;
    }
       body{
           font-family: arial;
       }
    #thead {
        display: table-row !important;
    }
    .filter {
        width: 100%;
        height: 20px;
        font-size: 150%;
        margin: 5px 0;
    }
    
</style>
</head>
<body>
<?php

$students = array(
                array("Байша Юлия Геннадьевна", 579549),
                array("Борисовский Егор Иванович aka Пупсень", 283732),
                array("Бритвин Егор Валерьевич aka Вупсень", 872975),
                array("Дунюшкин Иван Дмитриевич", 459692),
                array("Иванюк Владислав Алексеевич aka Дядя Шнюк", 584397),
                array("Козак Ростислав Рустамович", 395729),
                array("Коноваленко Оксана Вячеславовна", 543853),
                array("Крюков Алексей Олегович", 881847),
                array("Кузнецова Виктория Алексеевна", 359879),
                array("Макаров Александр Сергеевич", 571373),
                array("Мельникова Анна Андреевна", 626267),
                array("Минаев Дмитрий Владимирович", 298435),
                array("Митина Юлия Игоревна aka Михайловский зашквар)0)0)", 763864),
                array("Мухаметшин Антон Эдуардович aka Татарин)0))", 136357),
                array("Набиев Маруф Олимхонович", 899591),
                array("Оганян Генрик Акопович", 612571),
                array("Онопко Максим Николаевич", 861896),
                array("Орлов Илья Валентинович aka Продам что угодно", 576352),
                array("Плиско Максим Игоревич", 969672),
                array("Попов Максим Евгеньевич", 725929),
                array("Примаченко Светлана Владимировна", 933751),
                array("Свериденко Никита Алексеевич", 656314),
                array("Смолякова Анна Дмитриевна", 326678),
                array("Солтагираев Мехди Умарович", 295988),
                array("Титовский Даниил Викторович", 498437),
                array("Фролов Глеб Романович", 631725),
                array("Чекунов Владлен Станиславович", 939342),
                array("Шатрова Алёна Андреевна", 168174),
                array("Яровой Евгений Александрович", 975223)
);

$ou = file_get_contents("http://volsu.ru/activities/education/eduprogs/rating.php?plan=000000843&list=13&level=03&profile=");
$subjects = array("Иностранный язык", "История", "Математический анализ", "Прикладная физическая культура", "Технологии сети Интернет", "Физика", "Физическая культура", "Языки высокого уровня");

function get_results($id, $out, $phio)
{
    
    //echo $out;
    echo "<tr><td class='name'>{$phio}</td>";
    
    $mas = explode($id, $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    for($i = 0; $i<8; $i++)
    {
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);
        echo "<td>{$curr_str}</td>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";    
    }
    echo "</tr>";
}
echo '<input class="filter" name="livefilter" type="text" placeholder="Поиск по именам и количеству баллов" value="" autofocus>';
echo "<table class='table table-striped table-bordered spc live_filter'>";
echo "<tr id='thead' style='cursor: pointer;'><td onclick='sort2(this)'>ФИО</td>";
for($p=0; $p < 8; $p++)
{
    echo "<td onclick='sort(this)'>".$subjects[$p]."</td>";
}
echo "</tr>";

for($j=0; $j < 29; $j++)
{    
    get_results($students[$j][1], $ou, $students[$j][0]);
}

echo "</table>";
//send(40139849, $total);
//echo $total;

    
    
    
function send($id , $message)
{
    $url = 'https://api.vk.com/method/messages.send';
    $params = array(
        'user_id' => $id,    // Кому отправляем
        'message' => $message,   // Что отправляем
        'access_token' => '27c914ec367f6a3329a432459b6c18df1d4b29eb571d73d3cf2cc205bd9fc72cdae8b62266a4f82675597',  // access_token можно вбить хардкодом, если работа будет идти из под одного юзера
        'peer_id' => -70821549,
        'attachment' => $imid,
        'v' => '5.60',
    );

    // В $result вернется id отправленного сообщения
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
    //echo $result;
}

?>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script>
    function sort(el) {
   var col_sort = el.innerHTML;
   var tr = el.parentNode;
   var table = tr.parentNode;
   var td, arrow, col_sort_num;
 
    for (var i=0; (td = tr.getElementsByTagName("td").item(i)); i++) {
    if (td.innerHTML == col_sort) {
            col_sort_num = i;
            if (td.prevsort == "y"){
                arrow = td.firstChild;
                el.up = Number(!el.up);
            }else{
                td.prevsort = "y";
                arrow = td.insertBefore(document.createElement("span"),td.firstChild);
                el.up = 0;
            }
            arrow.innerHTML = el.up?"↑ ":"↓ ";
        }else{
            if (td.prevsort == "y"){
                td.prevsort = "n";
                if (td.firstChild) td.removeChild(td.firstChild);
            }
        }
    }
 
     var a = new Array();
 
    for(i=1; i < table.rows.length; i++) {
        a[i-1] = new Array();
        a[i-1][0]=table.rows[i].getElementsByTagName("td").item(col_sort_num).innerHTML;
        a[i-1][1]=table.rows[i];
     }
        
 
     a.sort(function (a, b) {
  return parseInt(a, 10) - parseInt(b, 10);
});
     if(el.up) a.reverse();
 
     for(i=0; i < a.length; i++)
     table.appendChild(a[i][1]);
}
        
        
        function sort2(el) {
   var col_sort = el.innerHTML;
   var tr = el.parentNode;
   var table = tr.parentNode;
   var td, arrow, col_sort_num;
 
    for (var i=0; (td = tr.getElementsByTagName("td").item(i)); i++) {
    if (td.innerHTML == col_sort) {
            col_sort_num = i;
            if (td.prevsort == "y"){
                arrow = td.firstChild;
                el.up = Number(!el.up);
            }else{
                td.prevsort = "y";
                arrow = td.insertBefore(document.createElement("span"),td.firstChild);
                el.up = 0;
            }
            arrow.innerHTML = el.up?"↑ ":"↓ ";
        }else{
            if (td.prevsort == "y"){
                td.prevsort = "n";
                if (td.firstChild) td.removeChild(td.firstChild);
            }
        }
    }
 
     var a = new Array();
 
    for(i=1; i < table.rows.length; i++) {
        a[i-1] = new Array();
        a[i-1][0]=table.rows[i].getElementsByTagName("td").item(col_sort_num).innerHTML;
        a[i-1][1]=table.rows[i];
     }
        
 
     a.sort();
     if(el.up) a.reverse();
 
     for(i=0; i < a.length; i++)
     table.appendChild(a[i][1]);
}
        
        (function($){
	$.fn.liveFilter = function (aType) {
		
		// Определяем, что будет фильтроваться.
		var filterTarget = $(this);
		var child;
		if ($(this).is('ul')) {
			child = 'li';
		} else if ($(this).is('ol')) {
			child = 'li';
		} else if ($(this).is('table')) {
			child = 'tbody tr';
		}
		
		// Определяем переменные
		var hide;
		var show;
		var filter;
		
		// Событие для элемента ввода
		$('input.filter').keyup(function() {
			
			// Получаем значение фильтра
			filter = $(this).val();
			
			// Получаем то, что нужно спрятать, и то, что нужно показать
			hide = $(filterTarget).find(child + ':not(:Contains("' + filter + '"))');
			show = $(filterTarget).find(child + ':Contains("' + filter + '")')
			
			// Анимируем пункты, которые нужно спрятать и показать
			if ( aType == 'basic' ) {
				hide.hide();
				show.show();
			} else if ( aType == 'slide' ) {
				hide.slideUp(500);
				show.slideDown(500);
			} else if ( aType == 'fade' ) {
				hide.fadeOut(400);
				show.fadeIn(400);                                
			}            
			
		});		
		
		// Пользовательское выражение для нечувствительной к регистру текста функции contains()
		jQuery.expr[':'].Contains = function(a,i,m){
		    return jQuery(a).text().toLowerCase().indexOf(m[3].toLowerCase())>=0;
		}; 

	}

})(jQuery);
        $(document).ready(function() {
		$('table.live_filter').liveFilter('fade');
	});
    </script>
</body>
</html>