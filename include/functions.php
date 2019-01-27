<?php
/*
 *Выборка баллов по номеру зачётки
 */

function get_results($id, $out, $phio, $null_subjects, $semestr)
{
    $points = 0;
    
    //echo $out;
    echo "<tr><td class='name'><a href='/student/{$id}/{$semestr}'>{$phio}</a></td>";
    
    $mas = explode($id, $out);    
    $mas2 = explode("</tr>", $mas[1]);    
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    $td_class = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);
        if($null_subjects[$i] == 1)
            $td_class = "";
        else
            $td_class = "display:none;";
        echo "<td style=\"{$td_class}\">{$curr_str}</td>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";  
        $points += $curr_str;
    }
    echo "<td>{$points}</td>";
    echo "</tr>";
}

/*
 *Выборка баллов по номеру зачётки для мобильных устройств
 */

function get_results_m($id, $out, $phio, $null_subjects, $semestr)
{
    $mass = explode("№ зачетной книжки", $out);
    $mas2s = explode("</tr>", $mass[1]);
    $mass = $mas2s[0];
    $mass = explode("<td>", $mass);


    $points = 0;
    
    //echo $out;
    echo "<tr data-tag='student{$id}'><td class='name' colspan='2'><a href='/student/{$id}/{$semestr}'>{$phio}</a></td></tr>";
    
    $mas = explode($id, $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";
    $td_class = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_strs = str_replace("</td>", "", $mass[$i+1]);
        $curr_strs = str_replace("<br>", "", $curr_strs);
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);
        if($null_subjects[$i] == 1)
            $td_class = "";
        else
            $td_class = "display:none;";
        echo "<tr style=\"{$td_class}\" data-tag='student{$id}'><td>{$curr_strs}</td><td>{$curr_str}</td></tr>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";  
        $points += $curr_str;
    }
    echo "<tr data-tag='student{$id}'><td><b>Всего баллов</b></td><td>{$points}</td></tr>";
}

/*
 *Выборка баллов по номеру зачётки для отдельного студента
 */

function get_results_special($id, $out, $phio, $null_subjects)
{
    $mass = explode("№ зачетной книжки", $out);
    $mas2s = explode("</tr>", $mass[1]);
    $mass = $mas2s[0];
    $mass = explode("<td>", $mass);


    $points = 0;
    
    //echo $out;
    echo "<tr data-tag='student{$id}'><td class='name' colspan='2'>{$phio}</td></tr>";
    
    $mas = explode($id, $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";
    $td_class = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_strs = str_replace("</td>", "", $mass[$i+1]);
        $curr_strs = str_replace("<br>", "", $curr_strs);
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);
        if($null_subjects[$i] == 1)
            $td_class = "";
        else
            $td_class = "display:none;";
        echo "<tr style=\"{$td_class}\" data-tag='student{$id}'><td>{$curr_strs}</td><td>{$curr_str}</td></tr>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";  
        $points += $curr_str;
    }
    echo "<tr data-tag='student{$id}'><td><b>Всего баллов</b></td><td>{$points}</td></tr>";
}

function get_results_special_api($id, $out, $phio, $null_subjects)
{
    $mass = explode("№ зачетной книжки", $out);
    $mas2s = explode("</tr>", $mass[1]);
    $mass = $mas2s[0];
    $mass = explode("<td>", $mass);

    $points = 0;

    $arStudent = array();
    $arStudent['fio'] = strip_tags($phio);
    $arStudent['id'] = $id;

    $mas = explode($id, $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_strs = str_replace("</td>", "", $mass[$i+1]);
        $curr_strs = str_replace("<br>", "", $curr_strs);
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);

        $arStudent["rating"][] = array(
            "subject" => trim(strip_tags($curr_strs)),
            "result" => $curr_str
        );
        $points += $curr_str;
    }
    $arStudent["rating"][] = array(
        "subject" => "Всего баллов",
        "result" => $points
    );

    return $arStudent;
}
    
/*
 *Генерация массива с предметами
 */
    
function get_subjects($out, $semestr, $subjects){
    //echo $out;
    //echo "<tr><td class='name'>{$phio}</td>";
    
    $mas = explode("№ зачетной книжки", $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    $null_subjects = array();
    $td_class = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = str_replace("<br>", "", $curr_str);
        /*if($semestr == 3){
            if(check_subject($curr_str, $subjects[$semestr]) == true){                
                echo "<td onclick='sort(this)'>{$curr_str}</td>";
                //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
                $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";
            }
        } else {
            echo "<td onclick='sort(this)'>{$curr_str}</td>";
            $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";
        }*/
        if($semestr == 3 && check_subject($curr_str, $subjects[3]) == false){
            $td_class = "display:none;";
            $null_subjects[$i] = 0;
        }
        else {
            $td_class = "";
            $null_subjects[$i] = 1;        
        }      
        
        echo "<td style=\"{$td_class}\" onclick='sort(this)'>{$curr_str}</td>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";
    }
    echo "<td onclick='sort(this)'><b>Всего баллов</b></td>";
    echo "</tr>";
    return $null_subjects;
}

/*
 *Генерация массива с предметами чистая функция
 */
    
function get_subjects_s($out, $semestr, $subjects){
    //echo $out;
    //echo "<tr><td class='name'>{$phio}</td>";
    
    $mas = explode("№ зачетной книжки", $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    $null_subjects = array();
    $td_class = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = str_replace("<br>", "", $curr_str);
        /*if($semestr == 3){
            if(check_subject($curr_str, $subjects[$semestr]) == true){                
                echo "<td onclick='sort(this)'>{$curr_str}</td>";
                //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
                $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";
            }
        } else {
            echo "<td onclick='sort(this)'>{$curr_str}</td>";
            $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";
        }*/
        if($semestr == 3 && check_subject($curr_str, $subjects[3]) == false){
            $td_class = "display:none;";
            $null_subjects[$i] = 0;
        }
        else {
            $td_class = "";
            $null_subjects[$i] = 1;        
        }              
        
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";
    }
    return $null_subjects;
}

/*
 * Проверка предметов
 */
function check_subject($subject_str, $subjectss){
    $subjects = array("Дискретная математика", "Иностранный язык", "Культура общения", "Математическое моделирование физических систем", "Метрология, стандартизация, сертификация", "Объектно-ориентированное программирование", "Прикладная физическая культура", "Физика", "Экономика");
    for($i = 0; $i < count($subjects); $i++){
        if(strpos($subject_str, $subjects[$i]) === false){
            // echo $subjects[$i]." не найдена в ".$subject_str."<br>=======================<br>";            
        }
        else
        {
            // echo $subjects[$i]." найдена в ".$subject_str."<br>!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!<br>";   
            // break;
            return true; 
        }
        /*if(strpos($subject_str, "Дискретная математика") === true){
            echo "МАМКУ ЕБАЛ";
            break;
            return true;
        }*/
    }
    // return false;
}

/*
 * Получение расписания из json-файла
 */
function getSchedule()
{
    return getJsonFileContent("/data/schedule.json");
}

function getJsonFileContent($filePath)
{
    $jsonFileName = $filePath;
    $filePath = $_SERVER['DOCUMENT_ROOT'] . $jsonFileName;

    $fileData = file_get_contents($filePath);

    $jsonData = json_decode($fileData, true);

    return $jsonData;
}

function getIndexArray($array)
{
    if ($array)
    {
        $array = array_values($array);
    }
    return $array;
}

function getSubjectHtml($data)
{
    $templateStr = "<strong>";
    $data["rooms"] = getIndexArray($data["rooms"]);
    $data["teachers"] = getIndexArray($data["teachers"]);
    if (strlen($data["name"]) > 0):
        $name = $data["name"];
        if (count($data["rooms"]) > 0)
            $name .= ", ";
        $templateStr .= $name;
    else:
        $templateStr .= "Окно";
    endif;
    if($data["rooms"] && count($data["rooms"]) > 0):
        $templateStr .= implode(", ", $data["rooms"]);
    endif;
    $templateStr .= "</strong><br>";
    if($data["teachers"] && count($data["teachers"]) > 0):
        $templateStr .= implode(", ", $data["teachers"]);
    endif;

    return $templateStr;
}

function showAlert($message, $type = "danger")
{
    return '<div class="alert alert-' . $type . '" role="alert">' . $message . '</div>';
}