<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ИВТ-161</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mr.Warete">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<!-- Custom styles for this template -->
<link href="jumbotron-narrow.css" rel="stylesheet">

<style>  
    .warete {
        background: url("/crown.png");
        width: 30px;
        height: 20px;
        display: inline-block;
        background-size: contain;
    }
    hr {
        border-top: 2px solid #0f0a10;
    } 
    .list-group-item {
        border: 2px solid #0f0a10;
    } 
    TD, TH {
    /*background: rgba(128, 128, 128, 0.19);  Цвет фона ячеек */
    padding: 5px; /* Поля вокруг текста */    
   }
   table {
        background: rgb(31, 38, 44);
        color: rgb(251, 255, 255);
   }
   .table_ras td {
    border-top: 2px solid #0f0a10 !important;
   }
   .panel-success table {
        background: rgb(29, 35, 27);
   }
    .name {
        background: #91d575;
        margin-top: 20px;
        color: #055307;
        font-weight: bold;
    }
    body{
        font-family: arial; 
        background: #0f0a10;  
        color: #fff;        
    }
    #thead {
        display: table-row !important;
    }
    .filter {
        width: 100%;
        background: rgb(49, 54, 60);
        color: rgb(164, 158, 158);
        height: 30px;
        border: 1px solid #838a90;
        padding: 5px;
        font-size: 150%;
        margin: 5px 0;
    }
    .dis{
        opacity: 0.4;
    }
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 2px solid #0f0a10;
    }
    .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
        color: #fff;
        background-color: #58595a;
    }
    .mob_rate {
        display: none;
    }
    .panel-default>.panel-heading {
        background: rgb(185, 185, 185);
    }
    .panel-success>.panel-heading {
        color: #055307;
        background: #91d575;
        border-color: #d6e9c6;
    }
    .panel {
        margin-bottom: 20px;
        background-color: none; 
        border: none; 
        border-radius: 4px; 
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    
    @media screen and (max-width: 1024px){
        .desktop_rate {
            display: none !important;
        }
        .mob_rate {
            display: table;
        }
        .filter {
            display: none;
        }
    }
    .list-group-item-success {
        color: #3c763d;
        background-color: #91d575;
    }
    .list-group-item-info {
        color: #31708f;
        background-color: #84bdda;
    }
    .list-group-item-danger {
        color: #a94442;
        background-color: #ecb2b2;
    }
</style>
</head>
<body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="/">Главная</a></li>          
        </ul>
        <h3 class="text-muted" style="color: #e61414;">ИВТ-161</h3>
      </div>
            
<?php
    
/*
 *Выборка баллов по номеру зачётки
 */

function get_results($id, $out, $phio)
{
    $points = 0;
    
    //echo $out;
    echo "<tr><td class='name'>{$phio}</td>";
    
    $mas = explode($id, $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);
        echo "<td>{$curr_str}</td>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";  
        $points += $curr_str;
    }
    echo "<td>{$points}</td>";
    echo "</tr>";
}

/*
 *Выборка баллов по номеру зачётки для мобильных устройств
 */

function get_results_m($id, $out, $phio)
{
    $mass = explode("№ зачетной книжки", $out);
    $mas2s = explode("</tr>", $mass[1]);
    $mass = $mas2s[0];
    $mass = explode("<td>", $mass);


    $points = 0;
    
    //echo $out;
    echo "<tr data-tag='student{$id}'><td class='name' colspan='2'>{$phio}</td></tr>";
    
    $mas = explode($id, $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_strs = str_replace("</td>", "", $mass[$i+1]);
        $curr_strs = str_replace("<br>", "", $curr_strs);
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);
        echo "<tr data-tag='student{$id}'><td>{$curr_strs}</td><td>{$curr_str}</td></tr>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";  
        $points += $curr_str;
    }
    echo "<tr data-tag='student{$id}'><td><b>Всего баллов</b></td><td>{$points}</td></tr>";
}
    
/*
 *Генерация массива с предметами
 */
    
function get_subjects($out){
    //echo $out;
    //echo "<tr><td class='name'>{$phio}</td>";
    
    $mas = explode("№ зачетной книжки", $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = str_replace("<br>", "", $curr_str);
        echo "<td onclick='sort(this)'>{$curr_str}</td>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";    
    }
    echo "<td onclick='sort(this)'><b>Всего баллов</b></td>";
    echo "</tr>";
}
    if(isset($_GET['sem'])){

$students = array(
                array("Байша Юлия Геннадьевна", 579549),
                array("<div class='warete'></div> Борисовский Егор Иванович aka Мистор Варете", 283732),
                array("Бритвин Егор Валерьевич aka Мистор Брутвен", 872975),
                array("Иванюк Владислав Алексеевич aka Дядя Шнюк", 584397),
                array("Козак Ростислав Рустамович", 395729),
                array("Коноваленко Оксана Вячеславовна", 543853),
                array("Крюков Алексей Олегович", 881847),
                array("Кузнецова Виктория Алексеевна", 359879),
                array("Мельникова Анна Андреевна aka Melnyassh", 626267),
                array("Минаев Дмитрий Владимирович", 298435),
                array("Митина Юлия Игоревна aka Михайловский зашквар)0)0)", 763864),
                array("Мухаметшин Антон Эдуардович aka Мистор Тутурен", 136357),
                array("Набиев Маруф Олимхонович", 899591),
                array("Оганян Генрик Акопович", 612571),
                array("Онопко Максим Николаевич", 861896),
                array("Орлов Илья Валентинович aka Мистер Валюша", 576352),
                array("Плиско Максим Игоревич", 969672),
                array("Попов Максим Евгеньевич", 725929),
                array("Примаченко Светлана Владимировна", 933751),
                array("Смолякова Анна Дмитриевна", 326678),
                array("Солтагираев Мехди Умарович", 295988),
                array("Титовский Даниил Викторович", 498437),
                array("Фролов Глеб Романович", 631725),
                array("Чекунов Владлен Станиславович", 939342),
                array("Шатрова Алёна Андреевна", 168174),
                array("Яровой Евгений Александрович", 975223)
);

$semestr = (int)$_GET['sem'];
$ou = file_get_contents("http://volsu.ru/activities/education/eduprogs/rating.php?plan=000000843&list=13&level=03&profile=&semestr=".$semestr);
    

    
/*
 *Формирование DOM
 */
echo '<input class="filter" name="livefilter" type="text" placeholder="Поиск по именам и количеству баллов" value="" autofocus>';
echo "<table class='table table-bordered spc live_filter desktop_rate'>";
echo "<tr id='thead' style='cursor: pointer;'><td onclick='sort2(this)'>ФИО</td>";
get_subjects($ou);

for($j=0; $j < count($students); $j++)
{    
    get_results($students[$j][1], $ou, $students[$j][0]);
    // get_results_m($students[$j][1], $ou, $students[$j][0]);
}

echo "</table>";

echo "<table class='table table-bordered mob_rate'>";
for($j=0; $j < count($students); $j++)
{        
    get_results_m($students[$j][1], $ou, $students[$j][0]);
}

echo "</table>";
        
} else {?>

<div class="row marketing">
   <h2 id="raspisanie" class="cover-heading">Расписание</h2>   
<div class="container" style="    text-align: center;">
<div class="col-lg-4">
    <div data-day="1" class="panel">
        <!-- Default panel contents -->
        <div class="panel-heading">Понедельник</div>  

        <!-- Table -->
        <table class="table table_ras">
            <tr><td>8<sup>30</sup></td><td><strong>Физика (л), 4-08А</strong><br>Проф. Михайлова В.А.</td><td></td></tr>
            <tr><td>10<sup>10</sup></td><td></td><td></td></tr>
            <tr><td>12<sup>00</sup></td><td><strong>ИСТОРИЯ(л), 4-29Г</strong><br>Доц. Фурман Е.Л.</td><td></td></tr>
            <tr><td>13<sup>40</sup></td><td><strong>Языки высокого уровня (лаб), 1-06М</strong><br>доц. Хохлова С.С., ст.преп. Дьяконова Т.А.</td><td></td></tr>
            <tr><td>15<sup>20</sup></td><td colspan="2"></td></tr>
        </table>
    </div>
</div>
<div class="col-lg-4">
    <div data-day="2" class="panel">
        <!-- Default panel contents -->
        <div class="panel-heading">Вторник</div>  

        <!-- Table -->
        <table class="table table_ras">
            <tr><td>8<sup>30</sup></td><td colspan="2"><div class="chis"><strong>История (с), 2-04М</strong><br>Доц. Арчебасова Н.А.</div><hr><div class="zn">Окно</div></td></tr>
            <tr><td>10<sup>10</sup></td><td><strong>Технологии сети Интернет(лаб), 1-05М,</strong><br>Доц. Писарев А.В., асс. Грицкевич М.В.</td><td><strong>Ин.Яз., 2-04М</strong><br>Асс. Буланов Д.А.</td></tr>
            <tr><td>12<sup>00</sup></td><td colspan="2"><strong>Физика (с), 2-11М</strong><br>Доц. Федунов Р.Г.</td></tr>
            <tr><td>13<sup>40</sup></td><td colspan="2"></td></tr>
            <tr><td>15<sup>20</sup></td><td colspan="2"></td></tr>
        </table>
    </div>
</div>
<div class="col-lg-4">
    <div data-day="3" class="panel">
        <!-- Default panel contents -->
        <div class="panel-heading">Среда</div>  

        <!-- Table -->
        <table class="table table_ras">
            <tr><td>8<sup>30</sup></td><td colspan="2"><strong>Математический анализ (л), 3-02М</strong><br>Доц. Корольков С.А.</td></tr>
            <tr><td>10<sup>10</sup></td><td><strong>Ин.Яз., 3-04А</strong><br>Ст.преп. Ашихманова Н.А.</td><td><strong>Технологии сети Интернет(лаб),1-05М,</strong><br>ст.преп. Сиволобов С.В., асс. Андреева И.И.</td></tr>
            <tr><td>12<sup>00</sup></td><td colspan="2"><strong>ФИЗИЧЕСКАЯ КУЛЬТУРА</strong></td></tr>
            <tr><td>13<sup>40</sup></td><td colspan="2"></td></tr>
            <tr><td>15<sup>20</sup></td><td colspan="2"></td></tr>
        </table>
    </div>
</div>
  </div>  
    <div class="container" style="    text-align: center;">
<div class="col-lg-4">
    <div data-day="4" class="panel">
        <!-- Default panel contents -->
        <div class="panel-heading">Четверг</div>  

        <!-- Table -->
        <table class="table table_ras">
            <tr><td>8<sup>30</sup></td><td colspan="2"></td></tr>
            <tr><td>10<sup>10</sup></td><td colspan="2"></td></tr>
            <tr><td>12<sup>00</sup></td><td colspan="2"></td></tr>
            <tr><td>13<sup>40</sup></td><td colspan="2"></td></tr>
            <tr><td>15<sup>20</sup></td><td colspan="2"></td></tr>
        </table>
    </div>
</div>
<div class="col-lg-4">
    <div data-day="5" class="panel">
        <!-- Default panel contents -->
        <div class="panel-heading">Пятница</div>  

        <!-- Table -->
        <table class="table table_ras">
            <tr><td>8<sup>30</sup></td><td><strong>Языки высокого уровня (лаб),  1-12М</strong><br>Доц. Кузьмин Н.М., ст.преп. Бутенко М.А</td><td></td></tr>
            <tr><td>10<sup>10</sup></td><td colspan="2"><strong>Математический анализ (с), 33-08А</strong><br>Асс. Радчик М.В.</td></tr>
            <tr><td>12<sup>00</sup></td><td colspan="2"><div class="chis"><strong>Технологии сети Интернет (л), 3-02М</strong><br>Доц. Писарев А.В.</div><hr><div class="zn"><strong>Языки высокого уровня (л), 3-02М</strong><br>Доц. Храпов С.С.</div></td></tr>
            <tr><td>13<sup>40</sup></td><td colspan="2"><strong>ПРИКЛАДНАЯ ФИЗИЧЕСКАЯ КУЛЬТУРА</strong></td></tr>
            <tr><td>15<sup>20</sup></td><td colspan="2"></td></tr>
        </table>
    </div>
</div>
        <div class="col-lg-4">
    <div data-day="6" class="panel">
        <!-- Default panel contents -->
        <div class="panel-heading">Суббота</div>  

        <!-- Table -->
        <table class="table table_ras">
           <tr><td>8<sup>30</sup></td><td colspan="2"></td></tr>
            <tr><td>10<sup>10</sup></td><td><div class="chis"><strong>Физика (лаб), 2-07К,</strong><br>Доц. Федунов Р.Г</div><hr><div class="zn">Окно</div></td><td><div class="chis">Окно</div><hr><div class="zn"><strong>Физика (лаб), 2-07К,</strong><br>Доц. Федунов Р.Г</div></td></tr>
            <tr><td>12<sup>00</sup></td><td><div class="chis"><strong>Физика (лаб), 2-07К,</strong><br>Доц. Федунов Р.Г</div><hr><div class="zn">Окно</div></td><td><div class="chis">Окно</div><hr><div class="zn"><strong>Физика (лаб), 2-07К,</strong><br>Доц. Федунов Р.Г</div></td></tr>
            <tr><td>13<sup>40</sup></td><td colspan="2"></td></tr>
            <tr><td>15<sup>20</sup></td><td colspan="2"></td></tr> 
        </table>
    </div>
</div>
    </div>
    <div class="container" style="margin-bottom: 20px;">
    <h2 class="cover-heading">Рейтинг</h2>
    <div class="list-group">
        <div class="col-lg-6">
            <a href="/semestr/1" class="list-group-item list-group-item-success">Первый семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>
            <a href="/semestr/2" class="list-group-item list-group-item-info">Второй семестр</a>
            <a href="/semestr/3" class="list-group-item list-group-item-danger">Третий семестр</a>
            <a href="/semestr/4" class="list-group-item list-group-item-danger">Четвертый семестр</a>
        </div>
        <div class="col-lg-6">
            <a href="/semestr/5" class="list-group-item list-group-item-danger">Пятый семестр</a>
            <a href="/semestr/6" class="list-group-item list-group-item-danger">Шестой семестр</a>
            <a href="/semestr/7" class="list-group-item list-group-item-danger">Седьмой семестр</a>
            <a href="/semestr/8" class="list-group-item list-group-item-danger">Восьмой семестр</a>
        </div>
    </div>  
    </div>
</div>

 
    
        
    <? }

?>
  

    </div>
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
     if(!el.up) a.reverse();
 
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
        var show_m;
		
		// Событие для элемента ввода
		$('input.filter').keyup(function() {
			
			// Получаем значение фильтра
			filter = $(this).val();
			
			// Получаем то, что нужно спрятать, и то, что нужно показать
			hide = $(filterTarget).find(child + ':not(:Contains("' + filter + '"))');
            show = $(filterTarget).find(child + ':Contains("' + filter + '")')
            /*hide.hide();
            show.show();
            for(var u = 0; u < show.length/2; u++)
            {
                $(filterTarget).find(child + '[data-tag = '+ $(show[u]).attr("data-tag") +']').show();
                
            }*/

			
			// Анимируем пункты, которые нужно спрятать и показать
			if ( aType == 'basic' ) {
				hide.hide();
				show.show();                
			} else if ( aType == 'slide' ) {
				hide.slideUp(500);
				show.slideDown(500);
                show_m.slideDown(500);
			} else if ( aType == 'fade' ) {
				hide.fadeOut(400);
				show.fadeIn(400);   
                show_m.fadeIn(400);                                
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
            
        function y2k(number) { return (number < 1000) ? number + 1900 : number; }
        function getWeek(year,month,day) {
            var when = new Date(year,month,day);
            var newYear = new Date(year,0,1);
            var modDay = newYear.getDay();
            if (modDay == 0) modDay=6; else modDay--;
            var daynum = ((Date.UTC(y2k(year),when.getMonth(),when.getDate(),0,0,0) -
                         Date.UTC(y2k(year),0,1,0,0,0)) /1000/60/60/24) + 1;
            if (modDay < 4 ) {
                var weeknum = Math.floor((daynum+modDay-1)/7)+1;
            }
            else {
                var weeknum = Math.floor((daynum+modDay-1)/7);
                if (weeknum == 0) {
                    year--;
                    var prevNewYear = new Date(year,0,1);
                    var prevmodDay = prevNewYear.getDay();
                    if (prevmodDay == 0) prevmodDay = 6; else prevmodDay--;
                    if (prevmodDay < 4) weeknum = 53; else weeknum = 52;
                }
            }
            return + weeknum;
        }
        var now = new Date();
        var fun=getWeek(y2k(now.getYear()),now.getMonth(),now.getDate());
        // узнаем дату
        if(fun/2 == Math.floor(fun/2))
        {
        result=0 // Знаменатель
        }
        else
        {
        result=1 // Числитель
        }
        if (now.getDay() == 0) // Если ВС и ВС=ЗНАМ, ВЫВЕСТИ ЗАВТРА ЧИСЛИТЕЛЬ
        {
          if (result==0)
          {
            $("#raspisanie").append(". НА СЛЕДУЮЩЕЙ НЕДЕЛЕ - ЧИСЛИТЕЛЬ")
          }
          else
          {
          $("#raspisanie").append(". НА СЛЕДУЮЩЕЙ НЕДЕЛЕ - ЗНАМЕНАТЕЛЬ")
          }
        }
        else
        {
        if(result==0)
        {
            $("#raspisanie").append(". Текущая неделя - ЗНАМЕНАТЕЛЬ");
            $(".chis").addClass("dis");
        }
        else
        {
            $("#raspisanie").append(". Текущая неделя - ЧИСЛИТЕЛЬ");
            $(".zn").addClass("dis");
        }
        } 
        var i,
            curr_day = (new Date()).getDay();
        for(i = 1; i<=6;i++){
            if(curr_day==i){
                $('[data-day='+i+']').addClass("panel-success");
            } else {
                $('[data-day='+i+']').addClass("panel-default");
            }
        }
        
	});
    </script>
    <!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter43957684 = new Ya.Metrika({
                    id:43957684,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/43957684" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>