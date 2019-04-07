<?php
if ($_REQUEST['action'] == 'save-materials')
{
    if (isset($_REQUEST['data']))
    {
        $arData = [];
        foreach ($_REQUEST['data'] as $item)
        {
            $arData[] = json_decode($item);
        }
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/data/materials.json', json_encode($arData));
    }
}