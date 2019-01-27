<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/prolog.php";
use Warete\VolsuRating;

$title = "Рейтинг";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/header.php";
?>
<body>
<?include $_SERVER["DOCUMENT_ROOT"] . "/include/top-menu.php";?>
<div class="container">
    <?
    $semestr = intval($_GET['sem']);
    if ($semestr > 0 && $semestr <= 8)
    {
        $rating = new VolsuRating("000000843", $semestr, $CONFIG["GROUP_NAME"]);
        $rating->setStudents($arStudents);
        $ratingData = $rating->getRating();
        if ((isset($_GET["sort"]) && strlen($_GET["sort"]) > 0)
            && (isset($_GET["direction"]) && strlen($_GET["direction"]) > 0))
        {
            usort($ratingData, function ($a, $b) {
                $direction = 1;
                if ($_GET["direction"] == "asc")
                {
                    $direction = -1;
                }
                if ($_GET["sort"] == "name")
                {
                    return strcmp($a["STUDENT"]["INFO"], $b["STUDENT"]["INFO"]) * $direction;
                }
                else
                {
                    return strcmp($a["RATING"][count($a["RATING"]) - 1]["RESULT"], $b["RATING"][count($b["RATING"]) - 1]["RESULT"]) * $direction;
                }
            });
        }
        if (!count($ratingData))
        {
            showAlert('<strong>Произошел сбой работы программы.</strong> В настоящее время ведутся технические работы на сервере университета. Попробуйте позже.', 'danger');
        }
        else
        {
            ?>
            <div class="row">
                <?for($u = 1; $u <= 8; $u++):?>
                    <?if ($u == $CONFIG["CURRENT_SEMESTR"]):?>
                        <a href="/semestr/<?=$u?>" class="list-group-item list-group-item-success col-md-3"><?=$CONFIG["SEMESTR_NAMES"][$u - 1]?> семестр<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></a>
                    <?else:?>
                        <a href="/semestr/<?=$u?>" class="list-group-item list-group-item-info col-md-3"><?=$CONFIG["SEMESTR_NAMES"][$u - 1]?> семестр</a>
                    <?endif;?>
                <?endfor;?>
            </div>
            <div class="row">
                <input class="filter form-control" name="livefilter" type="text" placeholder="Поиск по именам и количеству баллов" value="" autofocus>
                <a href="/semestr/<?=$semestr?>/name/desc/" class="list-group-item list-group-item-<?=($_GET["sort"] == "name" && $_GET["direction"] == "desc" ? "success" : "default")?> col-sm-6 col-md-3">По алфавиту <span class="glyphicon glyphicon-arrow-up"></span></a>
                <a href="/semestr/<?=$semestr?>/name/asc/" class="list-group-item list-group-item-<?=($_GET["sort"] == "name" && $_GET["direction"] == "asc" ? "success" : "default")?> col-sm-6 col-md-3">По алфавиту <span class="glyphicon glyphicon-arrow-down"></span></a>
                <a href="/semestr/<?=$semestr?>/summary/desc/" class="list-group-item list-group-item-<?=($_GET["sort"] == "summary" && $_GET["direction"] == "desc" ? "success" : "default")?> col-sm-6 col-md-3">По количеству баллов <span class="glyphicon glyphicon-arrow-up"></span></a>
                <a href="/semestr/<?=$semestr?>/summary/asc/" class="list-group-item list-group-item-<?=($_GET["sort"] == "summary" && $_GET["direction"] == "asc" ? "success" : "default")?> col-sm-6 col-md-3">По количеству баллов <span class="glyphicon glyphicon-arrow-down"></span></a>
            </div>
            <div class="row rating">
                <?foreach ($ratingData as $dataItem):?>
                    <div class="panel panel-success rating__student">
                        <div class="panel-heading"><a href="/student/<?=$dataItem["STUDENT"]["ID"]?>/<?=$semestr?>/"><?=(strlen($dataItem["STUDENT"]["INFO"]) ? $dataItem["STUDENT"]["INFO"] . " (" . $dataItem["STUDENT"]["ID"] . ")" : $dataItem["STUDENT"]["ID"])?></a></div>
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
