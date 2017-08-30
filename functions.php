<?php
/*
 *Выборка баллов по номеру зачётки
 */

function get_results($id, $out, $phio)
{
    $points = 0;
    
    //echo $out;
    echo "<tr><td class='name'>{$phio}</td>";
    
    $mas = explode($id, $out);    
    $mas2 = explode("</tr>", $mas[1]);    
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);
        echo "<td>{$curr_str}</td>";
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

function get_results_m($id, $out, $phio)
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

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_strs = str_replace("</td>", "", $mass[$i+1]);
        $curr_strs = str_replace("<br>", "", $curr_strs);
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = (int)str_replace("<br>", "", $curr_str);
        echo "<tr data-tag='student{$id}'><td>{$curr_strs}</td><td>{$curr_str}</td></tr>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";  
        $points += $curr_str;
    }
    echo "<tr data-tag='student{$id}'><td><b>Всего баллов</b></td><td>{$points}</td></tr>";
}
    
/*
 *Генерация массива с предметами
 */
    
function get_subjects($out){
    //echo $out;
    //echo "<tr><td class='name'>{$phio}</td>";
    
    $mas = explode("№ зачетной книжки", $out);
    $mas2 = explode("</tr>", $mas[1]);
    $mas = $mas2[0];
    $mas = explode("<td>", $mas);
    
    $TextMessage = "";
    $total = "";

    for($i = 0; $i<(count($mas)-1); $i++)
    {
        $curr_str = str_replace("</td>", "", $mas[$i+1]);
        $curr_str = str_replace("<br>", "", $curr_str);
        echo "<td onclick='sort(this)'>{$curr_str}</td>";
        //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
        $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";    
    }
    echo "<td onclick='sort(this)'><b>Всего баллов</b></td>";
    echo "</tr>";
}