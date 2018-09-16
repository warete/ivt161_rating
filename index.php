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

    <link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicons/android-icon-192x192.png">
    <link rel="shortcut icon" href="/favicons/favicon.ico">
    <link rel="shortcut icon" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/manifest.json">

    <link href="/css/styles.css" rel="stylesheet">
</head>
<body>
<?
include(__DIR__.'/config.php');
include(__DIR__.'/functions.php');
?>
<nav class="navbar navbar-inverse">
    <div class="container">
        <!-- Brand и toggle сгруппированы для лучшего отображения на мобильных дисплеях -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/" style="color: #e61414;">ИВТ-161</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/">Главная</a></li>
                <li><a href="/#schedule">Расписание</a></li>
                <li><a href="/semestr/<?=$current_semestr?>">Рейтинг</a></li>
                <li><a href="/materials">Материалы</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


    <div class="container">
<?php
if(isset($_GET['sem'])){
    $semestr = (int)$_GET['sem'];
    $ou = file_get_contents("http://volsu.ru/activities/education/eduprogs/rating.php?plan=000000843&list=13&level=03&profile=&semestr=".$semestr);  

    if(stristr($ou, 'Произошел сбой работы программы. В настоящее время ведутся технические работы на сервере. Попробуйте позже.') != FALSE) {
        echo '<br><div class="alert alert-danger">
                    <strong>Произошел сбой работы программы.</strong> В настоящее время ведутся технические работы на сервере университета. Попробуйте позже.
                </div>';
    }
    else
    {
        /*
         *Формирование DOM
         */
        echo '<br><div class="row">';
        for($u = 1; $u <= 8; $u++)
        {
            if($u == $semestr)
            {
                echo '<a href="/semestr/'.$u.'" class="list-group-item list-group-item-success col-md-3">'.$sem_names[$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>';
            }
            else
            {
                echo '<a href="/semestr/'.$u.'" class="list-group-item list-group-item-info col-md-3">'.$sem_names[$u-1].' семестр</a>';
            }
        }
        echo '</div>';
        echo '<input class="filter" name="livefilter" type="text" placeholder="Поиск по именам и количеству баллов" value="" autofocus>';
        echo "<table class='table table-bordered spc live_filter desktop_rate'>";
        echo "<tr id='thead' style='cursor: pointer;'><td onclick='sort2(this)'>ФИО</td>";
        $null_subjects = array();
        $null_subjects = get_subjects($ou, $semestr, $subjects);
        // print_r($null_subjects);

        for($j=0; $j < count($students); $j++)
        {    
            get_results($students[$j][1], $ou, $students[$j][0], $null_subjects, $semestr);
            // get_results_m($students[$j][1], $ou, $students[$j][0]);
        }

        echo "</table>";

        echo "<table class='table table-bordered mob_rate'>";
        for($j=0; $j < count($students); $j++)
        {        
            get_results_m($students[$j][1], $ou, $students[$j][0], $null_subjects, $semestr);
        }

        echo "</table>";
    }         
    
        
} else 
    if($_GET['action'] == 'materials'){ ?>
        <div class="row marketing">
            <h2 class="cover-heading">Материалы</h2> 
            <div class="container" style="    text-align: center;">
                <!-- <div class="col-md-4">
                    <div data-day="1" class="panel">
                        Default panel contents
                        <div class="panel-heading">Базы данных</div>  
                        <iframe src="https://drive.google.com/embeddedfolderview?id=0B0qZTJhiu6hrckNJSUxrS21YeG8#grid" style="width:100%; height:600px; border:0;"></iframe>
                
                        <a href="https://yadi.sk/d/IGOJBOFa3RYipR">https://yadi.sk/d/IGOJBOFa3RYipR</a>
                    </div>  
                </div>
                <div class="col-md-4">
                    <div data-day="1" class="panel">
                        Default panel contents
                        <div class="panel-heading">Операционные системы</div>  
                        <iframe src="https://drive.google.com/embeddedfolderview?id=0B0qZTJhiu6hrckNJSUxrS21YeG8#grid" style="width:100%; height:600px; border:0;"></iframe>
                
                        <a href="https://yadi.sk/d/XHqvTN-L3RYis6">https://yadi.sk/d/XHqvTN-L3RYis6</a>
                    </div>
                </div>
                <div class="col-md-4">                    
                    <div data-day="1" class="panel">
                        Default panel contents
                        <div class="panel-heading">Численные методы</div>  
                        <iframe src="https://drive.google.com/embeddedfolderview?id=0B0qZTJhiu6hrckNJSUxrS21YeG8#grid" style="width:100%; height:600px; border:0;"></iframe>
                
                        <a href="https://yadi.sk/d/7CQXd3vd3RYith">https://yadi.sk/d/7CQXd3vd3RYith</a>
                    </div>
                </div> -->
            </div>
        </div>

        <? } else
                if(isset($_GET['student'])){
                    $semestr = $_GET['semestr']?$_GET['semestr']:1;
                    $ou = file_get_contents("http://volsu.ru/activities/education/eduprogs/rating.php?plan=000000843&list=13&level=03&profile=&semestr=".$semestr);  

                    if(stristr($ou, 'Произошел сбой работы программы. В настоящее время ведутся технические работы на сервере. Попробуйте позже.') != FALSE) {
                        echo '<br><div class="alert alert-danger">
                                    <strong>Произошел сбой работы программы.</strong> В настоящее время ведутся технические работы на сервере университета. Попробуйте позже.
                                </div>';
                    }
                    else
                    {
                        $null_subjects = array();
                        $null_subjects = get_subjects_s($ou, $semestr, $subjects);
                        $student_fio = "Неизвестный студент";
                        for($j=0; $j < count($students); $j++)
                        {    
                            if($students[$j][1] == $_GET['student'])
                                $student_fio = $students[$j][0];
                        }
                        /*
                         *Формирование DOM
                         */
                        /*echo '<br><div class="row"><a href="/student/'.$_GET['student'].'/1" class="list-group-item list-group-item-info col-md-3">Первый семестр</a>
                            <a href="/student/'.$_GET['student'].'/2" class="list-group-item list-group-item-info col-md-3">Второй семестр</a>
                            <a href="/student/'.$_GET['student'].'/3" class="list-group-item list-group-item-info col-md-3">Третий семестр</a>
                            <a href="/student/'.$_GET['student'].'/4" class="list-group-item list-group-item-info col-md-3">Четвертый семестр</a>
                            <a href="/student/'.$_GET['student'].'/5" class="list-group-item list-group-item-info col-md-3">Пятый семестр</a>
                            <a href="/student/'.$_GET['student'].'/6" class="list-group-item list-group-item-info col-md-3">Шестой семестр</a>
                            <a href="/student/'.$_GET['student'].'/7" class="list-group-item list-group-item-info col-md-3">Седьмой семестр</a>
                            <a href="/student/'.$_GET['student'].'/8" class="list-group-item list-group-item-info col-md-3">Восьмой семестр</a></div>';*/                        
                        echo '<br><div class="col-md-4">';
                        echo '<a href="/semestr/'.$semestr.'" class="list-group-item list-group-item-danger col-md-12">Перейти к общему рейтингу<span class="badge"><span class="glyphicon glyphicon-th-list"></span></span></a>';
                        for($u = 1; $u <= 8; $u++)
                        {
                            if($u == $semestr)
                            {
                                echo '<a href="/student/'.$_GET['student'].'/'.$u.'" class="list-group-item list-group-item-success col-md-12">'.$sem_names[$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>';
                            }
                            else
                            {
                                echo '<a href="/student/'.$_GET['student'].'/'.$u.'" class="list-group-item list-group-item-info col-md-12">'.$sem_names[$u-1].' семестр</a>';
                            }
                        }
                        echo '</div>';
                        echo "<div class='col-md-8'><table class='table table-bordered'>";
                        get_results_m($_GET['student'], $ou, $student_fio, $null_subjects, $semestr);

                        echo "</table></div>";
                    }      

                } else{?>

    <div class="row marketing">

        <?
        $scheduleData = getSchedule();
        $dayCounter = 1;
        $curDay = date("N");
        $curWeek =  date("W");
        $curWeekText = "";
        if ($curWeek % 2 == 0)
        {
            if ($curDay == 7)
                $curWeekText = "Следующая неделя - ЧИСЛИТЕЛЬ";
            else
                $curWeekText = "Текущая неделя - ЗНАМЕНАТЕЛЬ";
        }
        else
        {
            if ($curDay == 7)
                $curWeekText = "Следующая неделя - ЗНАМЕНАТЕЛЬ";
            else
                $curWeekText = "Текущая неделя - ЧИСЛИТЕЛЬ";
        }
        if ($curDay == 7)
            $curWeek++;
        ?>
        <div class="container">
            <h2 id="schedule" class="cover-heading">Расписание <span class="pull-right"><?=$curWeekText?></span></h2>
        </div>
        <div class="row row-flex row-flex-wrap">
        <?foreach ($scheduleData as $dayData):?>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div data-day="<?=$dayCounter?>" class="panel<?echo($curDay == $dayCounter ? " panel-success" : " panel-default");?>">
                        <div class="panel-heading"><?=$dayData["name"]?></div>
                        <?if (count($dayData["lessons"]) > 0):?>
                            <table class="table table_ras">
                                <?foreach ($dayData["lessons"] as $lessonNumber => $lessonData):?>
                                    <tr>
                                        <td><?=$lessonsTime[$lessonNumber]["hours"]?><sup><?=$lessonsTime[$lessonNumber]["minutes"]?></sup></td>
                                        <td>
                                            <?if ($lessonData["hasChildren"]):?>
                                                <?
                                                $childrenCounter = 0;
                                                foreach ($lessonData["children"] as $childrenData):?>
                                                    <div class="row<?
                                                    if ($childrenCounter == 0 && $curWeek % 2 == 0)
                                                        echo " text-muted";
                                                    elseif ($childrenCounter == 1 && $curWeek % 2 != 0)
                                                        echo " text-muted";
                                                    ?>">
                                                        <?if ($childrenData["hasGroups"]):?>
                                                            <?foreach ($childrenData["groups"] as $groupData):?>
                                                                <div class="col-xs-6">
                                                                    <?=getSubjectHtml($groupData)?>
                                                                </div>
                                                            <?endforeach;?>
                                                        <?else:?>
                                                            <div class="col-sm-12">
                                                                <?=getSubjectHtml($childrenData)?>
                                                            </div>
                                                        <?endif;?>
                                                    </div>
                                                    <?echo($childrenCounter == 0 ? "<hr>" : "");?>
                                                <?
                                                $childrenCounter++;
                                                endforeach;?>
                                            <?else:?>
                                                <?=getSubjectHtml($lessonData)?>
                                            <?endif;?>
                                        </td>
                                    </tr>
                                <?endforeach;?>
                            </table>
                        <?endif;?>
                    </div>
                </div>
            <?$dayCounter++;?>
        <?endforeach;?>
        </div>
        <div class="container" style="margin-bottom: 20px;">
            <h2 class="cover-heading">Рейтинг</h2>
            <div class="list-group">
                <div class="col-lg-6">
                    <?
                    for($u = 1; $u <= 4; $u++)
                    {
                        if($u == $current_semestr)
                        {
                            echo '<a href="/semestr/'.$u.'" class="list-group-item list-group-item-info col-md-12">'.$sem_names[$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-star"></span></span></a>';
                        }
                        else
                            if($u <= $current_semestr)
                            {
                                echo '<a href="/semestr/'.$u.'" class="list-group-item list-group-item-success col-md-12">'.$sem_names[$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>';
                            }
                            else
                                if($u >= $current_semestr)
                                {
                                    echo '<a href="/semestr/'.$u.'" class="list-group-item list-group-item-danger col-md-12">'.$sem_names[$u-1].' семестр</a>';
                                }
                    }
                    ?>
                </div>
                <div class="col-lg-6">
                    <?
                    for($u = 5; $u <= 8; $u++)
                    {
                        if($u == $current_semestr)
                        {
                            echo '<a href="/semestr/'.$u.'" class="list-group-item list-group-item-info col-md-12">'.$sem_names[$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-star"></span></span></a>';
                        }
                        else
                            if($u <= $current_semestr)
                            {
                                echo '<a href="/semestr/'.$u.'" class="list-group-item list-group-item-success col-md-12">'.$sem_names[$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>';
                            }
                            else
                                if($u >= $current_semestr)
                                {
                                    echo '<a href="/semestr/'.$u.'" class="list-group-item list-group-item-danger col-md-12">'.$sem_names[$u-1].' семестр</a>';
                                }
                    }
                    ?>
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