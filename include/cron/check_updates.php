<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/bot.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/prolog.php";
use Warete\VolsuRating,
    Warete\Cache;

if (isset($_GET["token"]) && $_GET["token"] == $BOT_CONFIG["COMMON"]["CRON_ACCESS"])
{
    $rating = new VolsuRating($CONFIG["PLAN_ID"], $CONFIG["CURRENT_SEMESTR"], $CONFIG["GROUP_NAME"]);
    $rating->setStudents($arStudents);
    $updatesInfo = $rating->checkUpdates();
    if ($updatesInfo["STATUS"] == "HAS_CHANGES")
    {
        $ratingData = $rating->getRating($BOT_CONFIG["COMMON"]["ADMIN_STUDENT_ID"]);
        $message = "⚡Обновилась информация о рейтинге!⚡\n\r";
        $message .= "Рейтинг для студента " . strip_tags($ratingData[0]["STUDENT"]["INFO"]) . ":\n\r";
        $ratingData = $ratingData[0];
        foreach ($ratingData["RATING"] as $item)
        {
            $message .= "ℹ" . $item["SUBJECT"]["NAME"] . (strlen($item["SUBJECT"]["TYPE"]) ? " (" . $item["SUBJECT"]["TYPE"] . ")" : "") . ": " . strip_tags($item["RESULT"]) . "\n\r";
        }
        Cache::clearCache("/rating/");
        $response = send($BOT_CONFIG["VK"]["ADMIN_ID"], $message);
        echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($response, true) . '</pre>';
    }
}
else
{
    header('HTTP/1.0 403 Forbidden');
}

