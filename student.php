<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/prolog.php";
use Warete\VolsuRating,
    Warete\Cache;

$semestr = intval($_GET['sem']) ? $_GET["sem"] : 1;
$studentId = $_GET['student'];
$title = "Рейтинг студента " . $arStudents[$studentId];
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/header.php";
?>
<body>
<?include $_SERVER["DOCUMENT_ROOT"] . "/include/top-menu.php";?>
<div class="container">
    <h2 class="cover-heading">Рейтинг студента <strong><?=$arStudents[$studentId]?></strong></h2>
    <?
    if ($semestr > 0 && $semestr <= 8)
    {
        $cacheId = md5($_SERVER["SCRIPT_NAME"] . $semestr . $studentId);
        $cache = new Cache($cacheId, 3600 * 24, "/rating/student/");
        if ($cache->checkCache())
        {
            $ratingData = $cache->getCache();
        }
        else
        {
            $rating = new VolsuRating("000000843", $semestr, $CONFIG["GROUP_NAME"]);
            $rating->setStudents($arStudents);
            $ratingData = $rating->getRating($studentId);
            $cache->setCache($ratingData);
        }
        if (!count($ratingData))
        {
            showAlert('<strong>Произошел сбой работы программы.</strong> В настоящее время ведутся технические работы на сервере университета. Попробуйте позже.', 'danger');
        }
        else
        {
            ?>
            <div class="row">
                <div class="col-md-4">
                    <?for($u = 1; $u <= 8; $u++):?>
                        <?if ($u == $semestr):?>
                            <a href="/student/<?=$studentId?>/<?=$u?>/" class="list-group-item list-group-item-success col-md-12"><?=$CONFIG["SEMESTR_NAMES"][$u - 1]?> семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>
                        <?else:?>
                            <a href="/student/<?=$studentId?>/<?=$u?>/" class="list-group-item list-group-item-info col-md-12"><?=$CONFIG["SEMESTR_NAMES"][$u - 1]?> семестр</a>
                        <?endif;?>
                    <?endfor;?>
                </div>
                <div class="col-md-8 rating">
                    <?foreach ($ratingData as $dataItem):?>
                        <div class="panel panel-success rating__student">
                            <table class="table">
                                <?foreach ($dataItem["RATING"] as $arRating):?>
                                    <tr>
                                        <td><strong><?=$arRating["SUBJECT"]["NAME"]?></strong></td>
                                        <td><?=(isset($arRating["SUBJECT"]["TYPE"]) ? '<span class="label label-' . $CONFIG["SUBJECT_TYPE_CLASSES"][$arRating["SUBJECT"]["TYPE"]] . '">' . $arRating["SUBJECT"]["TYPE"] . '</span>' : "")?></td>
                                        <td><?=$arRating["RESULT"]?></td>
                                    </tr>
                                <?endforeach;?>
                            </table>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
            <?
        }
    }
    else
    {
        echo showAlert("<strong>Ошибка!</strong> Не существует семестра с номером " . $semestr . "!");
    }
    ?>
</div>
<?require_once $_SERVER["DOCUMENT_ROOT"] . "/include/footer.php";?>
</body>
</html>
