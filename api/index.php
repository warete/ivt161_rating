<?
header("Access-Control-Allow-Origin: *");
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/prolog.php";
use Warete\VolsuRating,
    Warete\Cache;
$semestr = intval($_GET['sem']) ? intval($_GET['sem']) : $CONFIG["CURRENT_SEMESTR"];

$cacheId = md5($_SERVER["SCRIPT_NAME"] . $semestr);
$cache = new Cache($cacheId, 3600 * 24, "/rating/");
if ($cache->checkCache())
{
    $ratingData = $cache->getCache();
}
else
{
    $rating = new VolsuRating($CONFIG["PLAN_ID"], $semestr, $CONFIG["GROUP_NAME"]);
    $rating->setStudents($arStudents);
    $ratingData = $rating->getRating();
    $cache->setCache($ratingData);
}

header('Content-Type: application/json');
echo json_encode($ratingData);