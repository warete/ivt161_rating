<?php
namespace Warete;

/**
 * Class VolsuRating
 * @author Egor Borisovsky <mr-warete@mail.ru>
 * @package Warete
 */
class VolsuRating
{
    /** @var int ID рабочей программы для группы */
    protected $planId = 0;
    /** @var int Номер семестра */
    protected $semestr = 1;
    /** @var string Название группы */
    protected $group;
    /** @var array Массив с данными о рейтинге */
    protected $ratingData = [];
    /** @var array Массив со студентами */
    protected $students = [];
    /** @var array Массив с предметами */
    protected $subjects = [];
    /** @var string Адрес, по которому доступен рейтинг на сайте ВолГУ */
    protected $volsuApiUrl = "https://volsu.ru/rating/test.php";
    /** @var string Путь к файлу с хэшем рейтинга */
    protected $hashDir = "/data/rating/cron_hash.txt";

    /**
     * Rating constructor.
     * @param $planId
     * @param $semestr
     * @param $group
     */
    public function __construct($planId, $semestr, $group)
    {
        $this->planId = $planId;
        $this->semestr = $semestr;
        $this->group = $group;
    }

    /**
     * Метод для получения данных о рейтинге
     *
     * @param string $studentId
     * @return array
     */
    public function getRating($studentId = "")
    {
        $this->ratingData = $this->getVolsuData($studentId);
        return $this->ratingData;
    }

    /**
     * Метод для заполнения данных о студентах
     *
     * @param $arStudents
     */
    public function setStudents($arStudents)
    {
        $this->students = $arStudents;
    }

    /**
     * Метод для получения данных о предметах
     *
     * @return array
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * Метод для получения данных о студентах
     *
     * @return array
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Метод для проверки изменений в рейтинге
     *
     * @return array
     */
    public function checkUpdates()
    {
        $response = [
            "STATUS" => ""
        ];
        $this->ratingData = $this->getVolsuData();
        $ratingHash = md5(serialize($this->ratingData));
        $oldHash = $this->getOldHash();
        if ($ratingHash != $oldHash)
        {
            if ($this->setNewHash($ratingHash))
            {
                $response["STATUS"] = "HAS_CHANGES";
            }
            else
            {
                $response["STATUS"] = "ERROR";
            }
        }
        else
        {
            $response["STATUS"] = "NO_CHANGES";
        }

        return $response;
    }

    /**
     * Метод для получения существующего хэша из файла
     *
     * @return bool|string
     */
    protected function getOldHash()
    {
        $oldHash = false;
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . $this->hashDir))
        {
            $oldHash = file_get_contents($_SERVER["DOCUMENT_ROOT"] . $this->hashDir);
        }

        return $oldHash;
    }

    /**
     * Метод для сохранения нового хэша в файл
     *
     * @param $hash
     * @return bool
     */
    protected function setNewHash($hash)
    {
        if (file_put_contents($_SERVER["DOCUMENT_ROOT"] . $this->hashDir, $hash))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Метод для получения данных о рейтинге с сайта ВолГУ
     *
     * @param string $studentId
     * @return array
     */
    protected function getVolsuData($studentId = "All")
    {
        $arData = [];
        if ($studentId != "All" && (!strlen($studentId) || !$this->students[$studentId]))
        {
            $studentId = "All";
        }
        $arApiParams = [
            "l" => "tab",
            "id" => $this->planId . "volsu" . $studentId . "volsu" . $this->semestr . "volsu" . $this->group
        ];
        $data = file_get_contents($this->volsuApiUrl . "?" . http_build_query($arApiParams));
        if (isset($data) && strlen($data))
        {
            if (stristr($data, 'Произошел сбой работы программы. В настоящее время ведутся технические работы на сервере. Попробуйте позже.') == FALSE)
            {
                $arData = $this->parseVolsuData($data);
            }
        }
        return $arData;
    }

    /**
     * Метод для разбора данных, полученных с сайта ВолГУ
     *
     * @param $data
     * @return array
     */
    protected function parseVolsuData($data)
    {
        $arData = [];
        $data = preg_replace('/\s+/', ' ', $data);
        $dataParts = explode('<tr class="cap">', $data);
        $dataParts = explode('</tr>', $dataParts[1]);
        foreach ($dataParts as $i => $dataPart)
        {
            //Получаем информацию о предментах
            if ($i == 0 && strlen($dataPart))
            {
                $tdContent = $this->getTdContent($dataPart);
                $key = array_search("№ зачетной книжки", $tdContent);
                if ($key !== false)
                {
                    unset($tdContent[$key]);
                    $tdContent = array_values($tdContent);
                }
                foreach ($tdContent as $dataCont)
                {
                    $this->subjects[] = $this->getSubjectsData($dataCont);
                }
                continue;
            }
            //Откидываем последнюю часть
            if ($i == count($dataParts) - 1)
            {
                break;
            }
            //Обрабатываем данные рейтинга для каждого студента
            $dataPart = $this->getTdContent(trim(str_replace("<tr>", "", $dataPart)));
            $arRatingData = [
                "STUDENT" => [
                    "ID" => $dataPart[0],
                    "INFO" => $this->students[$dataPart[0]]
                ],
                "RATING" => []
            ];
            foreach ($dataPart as $i => $item)
            {
                if ($i == 0)
                {
                    continue;
                }
                $arRatingData["RATING"][] = [
                    "SUBJECT" => $this->subjects[$i - 1],
                    "RESULT" => $item
                ];
            }
            $arRatingData["RATING"][] = $this->getRatingSummary($arRatingData["RATING"]);
            if (count($arRatingData))
            {
                $arData[] = $arRatingData;
            }
        }

        return $arData;
    }

    /**
     * Возвращает содержимое ячейки таблицы <td></td>
     *
     * @param $data
     * @return mixed
     */
    protected function getTdContent($data)
    {
        $arContent = [];
        preg_match_all('/<td>(.*?)<\/td>/mu', $data, $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $match)
        {
            $arContent[] = trim($match[1]);
        }

        return $arContent;
    }

    /**
     * Метод для разбора данных о предмете
     *
     * @param $data
     * @return array
     */
    protected function getSubjectsData($data)
    {
        $arContent = [];
        preg_match_all('/<div>(.*?)<\/div>/mu', $data, $matches, PREG_SET_ORDER, 0);
        if (count($matches))
        {
            $arContent = [
                "NAME" => $matches[0][1],
                "CODE" => $matches[1][1],
                "TYPE" => $matches[2][1],
            ];
        }

        return $arContent;
    }

    /**
     * Метод для подсчета общего количества баллов
     *
     * @param $ratingData
     * @return array
     */
    protected function getRatingSummary($ratingData)
    {
        $sum = 0;
        $arSummary = [
            "SUBJECT" => [
                "NAME" => "Всего"
            ]
        ];
        foreach ($ratingData as $item)
        {
            $sum += $item["RESULT"];
        }
        $arSummary["RESULT"] = $sum;

        return $arSummary;
    }
}