<?php
namespace Warete;


class Cache
{
    /** @var int Время кеширования */
    protected $cacheTime = 3600;
    /** @var string Базовая директория хранения кеша */
    protected static $baseCacheDir = "/cache/";
    /** @var string Директория хранения кеша для текущего файла */
    protected $cacheDir = "";
    /** @var string Идентификатор кеша */
    protected $cacheId = "";
    /** @var int Начальное время работы скрипта (для отладки) */
    protected static $startExecutionTime = 0;

    /**
     * Cache constructor.
     * @param $cacheId
     * @param int $cacheTime
     * @param string $cacheDir
     */
    public function __construct($cacheId, $cacheTime = 0, $cacheDir = "")
    {
        $this->cacheId = $cacheId;
        if ($cacheTime && $cacheTime > 0)
        {
            $this->cacheTime = $cacheTime;
        }
        $dirs = explode("/", static::$baseCacheDir);
        if (strlen($cacheDir))
        {
            $cacheDirs = explode("/", $cacheDir);
            $dirs = array_merge($dirs, $cacheDirs);
            static::checkCacheDirs($dirs);
        }
        $dirs = array_diff($dirs, array(''));
        $this->cacheDir = "/" . implode("/", $dirs) . "/";
    }

    /**
     * Метод для проверки существования кеша и его срока годности
     *
     * @return bool
     */
    public function checkCache()
    {
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . $this->cacheDir . $this->cacheId)
            && time() - $this->cacheTime < filemtime($_SERVER["DOCUMENT_ROOT"] . $this->cacheDir . $this->cacheId)
        )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Метод для записи данных в кеш
     *
     * @param $data
     */
    public function setCache($data)
    {
        if (isset($data))
        {
            $cacheData = serialize($data);
            $cacheFile = fopen($_SERVER["DOCUMENT_ROOT"] . $this->cacheDir . $this->cacheId, 'w');
            fwrite($cacheFile, $cacheData);
            fclose($cacheFile);
        }
    }

    /**
     * Метод для получения данных из кеша
     *
     * @return bool|mixed|string
     */
    public function getCache()
    {
        $cacheFile = fopen($_SERVER["DOCUMENT_ROOT"] . $this->cacheDir . $this->cacheId, 'r');
        $cacheData = fgets($cacheFile);
        $cacheData = unserialize($cacheData);
        fclose($cacheFile);

        return $cacheData;
    }

    /**
     * Метод для очистки кеша
     *
     * @param string $cacheDir
     */
    public static function clearCache($cacheDir = "")
    {
        $dirs = explode("/", static::$baseCacheDir);
        if (strlen($cacheDir))
        {
            $cacheDirs = explode("/", $cacheDir);
            $dirs = array_merge($dirs, $cacheDirs);
            static::checkCacheDirs($dirs);
        }
        $dirs = array_diff($dirs, array(''));
        $startDir = $_SERVER["DOCUMENT_ROOT"] . "/";
        if (strlen($cacheDir))
        {
            $cacheDirs = array_diff($cacheDirs, array(''));
            foreach ($dirs as $dir)
            {
                $startDir .= $dir . "/";
                if ($dir == $cacheDirs[count($cacheDirs)])
                {
                    if (file_exists($startDir))
                    {
                        $arFiles = glob($startDir . "*");
                        foreach ($arFiles as $arFile)
                        {
                            unlink($arFile);
                        }
                    }
                }
            }
        }
        else
        {
            $arFiles = glob($startDir . static::$baseCacheDir . "*");
            foreach ($arFiles as $arFile)
            {
                unlink($arFile);
            }
        }
    }

    /**
     * Метод для проверки и созданий директорий для кеша
     *
     * @param $dirs
     */
    protected static function checkCacheDirs($dirs)
    {
        $startDir = $_SERVER["DOCUMENT_ROOT"] . "/";
        foreach ($dirs as $dir)
        {
            $startDir .= $dir . "/";
            if (!file_exists($startDir))
            {
                mkdir($startDir);
            }
        }
    }

    /**
     * Метод для запуска таймера выполнения скрипта (отладка)
     */
    public static function startExecutionTimer()
    {
        static::$startExecutionTime = microtime(true);
    }

    /**
     * Метод для остановки таймера выполнения скрипта. Возвращает длительность работы скрипта в секундах (отладка)
     *
     * @return int|mixed
     */
    public static function endExecutionTimer()
    {
        $time_end = microtime(true);
        return $time_end - static::$startExecutionTime;
    }
}