<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/prolog.php";
use Warete\VolsuRating;

$title = "Материалы";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/header.php";
?>
<body>
<?include $_SERVER["DOCUMENT_ROOT"] . "/include/top-menu.php";?>
<div class="container">
    <div class="row marketing">
        <h2 class="cover-heading">Материалы</h2>
        <?
        $arMaterials = getJsonFileContent("/data/materials.json");
        ?>
        <div class="container" style="text-align: center;">
            <?if (count($arMaterials)):?>
                <?foreach ($arMaterials as $item):?>
                    <div class="col-md-4">
                        <div data-day="1" class="panel panel-default">
                            <div class="panel-heading"><?=$item["name"]?></div>
                            <div class="panel-body">
                                <?foreach ($item["materials"] as $material):?>
                                    <a href="<?=$material?>" target="_blank"><?=$material?></a>
                                <?endforeach;?>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            <?else:?>
                <?=showAlert("К сожалению, сейчас данный раздел пуст :(", "warning")?>
            <?endif;?>
        </div>
    </div>
</div>
<?require_once $_SERVER["DOCUMENT_ROOT"] . "/include/footer.php";?>
</body>
</html>
