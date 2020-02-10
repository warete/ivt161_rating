<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/prolog.php";
$title = "Главная";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/header.php";
?>
<body>
    <?include $_SERVER["DOCUMENT_ROOT"] . "/include/top-menu.php";?>
    <div class="container">
        <div class="row marketing">

            <?
            $scheduleData = getSchedule();
            $dayCounter = 1;
            $curDay = date("N");
            $curWeek =  date("W");
            $curWeek++;
            $curWeekText = "";
            if ($curWeek % 2 != 0)
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
                                            <td><?=$CONFIG["LESSONS_TIME"][$lessonNumber]["hours"]?><sup><?=$CONFIG["LESSONS_TIME"][$lessonNumber]["minutes"]?></sup></td>
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
                            if($u == $CONFIG["CURRENT_SEMESTR"])
                            {
                                echo '<a href="/semestr/'.$u.'/" class="list-group-item list-group-item-info col-md-12">'.$CONFIG["SEMESTR_NAMES"][$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-star"></span></span></a>';
                            }
                            else
                                if($u <= $CONFIG["CURRENT_SEMESTR"])
                                {
                                    echo '<a href="/semestr/'.$u.'/" class="list-group-item list-group-item-success col-md-12">'.$CONFIG["SEMESTR_NAMES"][$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>';
                                }
                                else
                                    if($u >= $CONFIG["CURRENT_SEMESTR"])
                                    {
                                        echo '<a href="/semestr/'.$u.'/" class="list-group-item list-group-item-danger col-md-12">'.$CONFIG["SEMESTR_NAMES"][$u-1].' семестр</a>';
                                    }
                        }
                        ?>
                    </div>
                    <div class="col-lg-6">
                        <?
                        for($u = 5; $u <= 8; $u++)
                        {
                            if($u == $CONFIG["CURRENT_SEMESTR"])
                            {
                                echo '<a href="/semestr/'.$u.'/" class="list-group-item list-group-item-info col-md-12">'.$CONFIG["SEMESTR_NAMES"][$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-star"></span></span></a>';
                            }
                            else
                                if($u <= $CONFIG["CURRENT_SEMESTR"])
                                {
                                    echo '<a href="/semestr/'.$u.'/" class="list-group-item list-group-item-success col-md-12">'.$CONFIG["SEMESTR_NAMES"][$u-1].' семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>';
                                }
                                else
                                    if($u >= $CONFIG["CURRENT_SEMESTR"])
                                    {
                                        echo '<a href="/semestr/'.$u.'/" class="list-group-item list-group-item-danger col-md-12">'.$CONFIG["SEMESTR_NAMES"][$u-1].' семестр</a>';
                                    }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?require_once $_SERVER["DOCUMENT_ROOT"] . "/include/footer.php";?>
</body>
</html>
