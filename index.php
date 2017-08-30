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

    <link href="/css/styles.css" rel="stylesheet">
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
include(__DIR__.'/config.php');   
include(__DIR__.'/functions.php');

if(isset($_GET['sem'])){
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
                <a href="/semestr/2" class="list-group-item list-group-item-success">Второй семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>
                <a href="/semestr/3" class="list-group-item list-group-item-info">Третий семестр<span class="badge"><span class="glyphicon glyphicon-star"></span></a>
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
    
        
<? } ?>  

    </div>
   <script src="/js/main.js"></script>

    <!-- Yandex.Metrika counter -->
    <noscript><div><img src="https://mc.yandex.ru/watch/43957684" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</body>
</html>