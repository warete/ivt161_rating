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
          <li class="active"><a href="/materials">Материалы</a></li>          
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
        
} else 
    if($_GET['action'] == 'materials'){
        echo '<div class="row marketing">
                 <h2 id="raspisanie" class="cover-heading">Материалы</h2> 
                 В данный момент раздел пуст.
              </div>';

        } else{?>

    <div class="row marketing">
       <h2 id="raspisanie" class="cover-heading">Расписание</h2>   
    <div class="container" style="    text-align: center;">
    <div class="col-lg-4">
        <div data-day="1" class="panel">
            <!-- Default panel contents -->
            <div class="panel-heading">Понедельник</div>  

            <!-- Table -->
            <table class="table table_ras">
                <tr>
                    <td>8<sup>30</sup></td>
                    <td colspan="2">
                        <strong>Физика (л), 3-01А</strong><br>Проф. Михайлова В.А.                    
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>10<sup>10</sup></td>
                    <td colspan="2">
                        <strong>Объектно-ориентированное программирование (л), 3-02 М</strong>
                        <br>
                        Проф. Феськков С.В.
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>12<sup>00</sup></td>
                    <td>
                        <div class="chis"><strong>Физика (лаб), 2-07К</strong><br>Асс. Лебедева О.С.</div>
                        <hr>
                        <div class="zn">Окно</div>
                    </td>
                    <td>
                        <div class="chis">Окно</div>
                        <hr>
                        <div class="zn"><strong>Физика (лаб), 2-07К</strong><br>Асс. Лебедева О.С.</div>
                    </td>
                </tr>
                <tr>
                    <td>13<sup>40</sup></td>
                    <td>
                        <div class="chis"><strong>Физика (лаб), 2-07К</strong><br>Асс. Лебедева О.С.</div>
                        <hr>
                        <div class="zn">Окно</div>
                    </td>
                    <td>
                        <div class="chis">Окно</div>
                        <hr>
                        <div class="zn"><strong>Физика (лаб), 2-07К</strong><br>Асс. Лебедева О.С.</div>
                    </td>
                </tr>
                <tr>
                    <td>15<sup>20</sup></td>
                    <td colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div data-day="2" class="panel">
            <!-- Default panel contents -->
            <div class="panel-heading">Вторник</div>  

            <!-- Table -->
            <table class="table table_ras">
                <tr>
                    <td>8<sup>30</sup></td>
                    <td colspan="2">
                        <strong>Математическое моделирование физических систем (л), 3-02 М</strong>
                        <br>
                        Доц. Тен А.В.
                    </td>
                </tr>
                <tr>
                    <td>10<sup>10</sup></td>
                    <td colspan="2">
                        <strong>Дискретная математика (л), 3-02 М</strong>
                        <br>
                        Доц. Лебедев В.Н.
                    </td>
                </tr>
                <tr>
                    <td>12<sup>00</sup></td>
                    <td colspan="2">
                        <strong>ПРИКЛАДНАЯ ФИЗИЧЕСКАЯ КУЛЬТУРА</strong>
                    </td>
                </tr>
                <tr>
                    <td>13<sup>40</sup></td>
                    <td>
                        <strong>Ин.Яз., 33-01 А</strong>
                        <br>
                        Ст.пр. Ашихманова Н.А.
                    </td>
                    <td>
                        <strong>Ин.Яз., 3-03 А</strong>
                        <br>
                        Асс. Павлова Е.Б.
                    </td>
                </tr>
                <tr>
                    <td>15<sup>20</sup></td>
                    <td colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div data-day="3" class="panel">
            <!-- Default panel contents -->
            <div class="panel-heading">Среда</div>  

            <!-- Table -->
            <table class="table table_ras">
                <tr>
                    <td>8<sup>30</sup></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>10<sup>10</sup></td>
                    <td colspan="2">
                        <strong>Об.ориент.программ. (лаб), 1-12М, 1-13М</strong>
                        <br>
                        Доц. Хохлова С.С., доц. Юданов В.В., асс. Шафран Ю.В.
                    </td>
                </tr>
                <tr>
                    <td>12<sup>00</sup></td>
                    <td colspan="2">
                        <strong>Физика (с), 2-11 М</strong>
                        <br>
                        Асс. Лебедева О.С.
                    </td>
                </tr>
                <tr>
                    <td>13<sup>40</sup></td>
                    <td colspan="2"><strong>ГУМАНИТАРНЫЕ КУРСЫ ПО ВЫБОРУ</strong></td>
                </tr>
                <tr>
                    <td>15<sup>20</sup></td>
                    <td colspan="2"></td>
                </tr>
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
                <tr>
                    <td>8<sup>30</sup></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>10<sup>10</sup></td>
                    <td colspan="2"><strong>ПРИКЛАДНАЯ ФИЗИЧЕСКАЯ КУЛЬТУРА</strong></td>
                </tr>
                <tr>
                    <td>12<sup>00</sup></td>
                    <td colspan="2">
                        <strong>Экономика (л), 4-29 Г</strong>
                        <br>
                        Доц. Шлевкова Т.В.
                    </td>
                </tr>
                <tr>
                    <td>13<sup>40</sup></td>
                    <td colspan="2">
                        <strong>Матем. моделирование физ.систем (с), 2-11 М</strong>
                        <br>
                        Доц. Тен А.В.
                    </td>
                </tr>
                <tr>
                    <td>15<sup>20</sup></td>
                    <td colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div data-day="5" class="panel">
            <!-- Default panel contents -->
            <div class="panel-heading">Пятница</div>  

            <!-- Table -->
            <table class="table table_ras">
                <tr>
                    <td>8<sup>30</sup></td>
                    <td>
                        <strong>Дискретная математика (с), 2-11 М</strong>
                        <br>
                        Ст.преп. Штельмах Т.В.
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>10<sup>10</sup></td>
                    <td colspan="2">
                        <strong>Метрология, стандартизация, сертификация (л), 2-04 М</strong>
                        <br>
                        Проф. Боровков Д.П.
                    </td>
                </tr>
                <tr>
                    <td>12<sup>00</sup></td>
                    <td colspan="2">
                        <div class="chis">
                            <strong>Метрология, стандартизация, сертиф. (лаб), 2-04 М</strong>
                            <br>
                            Проф. Боровков Д.П.
                        </div>
                        <hr>
                        <div class="zn">
                            Окно
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>13<sup>40</sup></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>15<sup>20</sup></td>
                    <td colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
            <div class="col-lg-4">
        <div data-day="6" class="panel">
            <!-- Default panel contents -->
            <div class="panel-heading">Суббота</div>  

            <!-- Table -->
            <table class="table table_ras">
                <tr>
                    <td>8<sup>30</sup></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>10<sup>10</sup></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>12<sup>00</sup></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>13<sup>40</sup></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>15<sup>20</sup></td>
                    <td colspan="2"></td>
                </tr>
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