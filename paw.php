<style>    
    TD, TH {
    background: gray; /* Цвет фона ячеек */
    padding: 5px; /* Поля вокруг текста */
   }
</style>
<?php
$out = file_get_contents("http://volsu.ru/activities/education/eduprogs/rating.php?plan=000000843&list=13&level=03&profile=");
//echo $out;

$mas = explode(283732, $out);
$mas2 = explode("</tr>", $mas[1]);
$mas = $mas2[0];
$mas = explode("<td>", $mas);
$subjects = array("Алгебра и геометрия", "Иностранный язык", "Информатика", "Математический анализ", "Основы математического моделирования", "Прикладная физическая культура", "Русский язык и культура речи", "Физическая культура", "Языки высокого уровня");
$TextMessage = "";
$image = imageCreate(550, 270);
$total = "";

// Регистрируем используемые цвета
$colorBackgr       = imageColorAllocate($image, 192, 192, 192);
$colorForegr       = imageColorAllocate($image, 255, 255, 255);
$colorGrid         = imageColorAllocate($image, 0, 0, 0);
$colorCross        = imageColorAllocate($image, 0, 0, 0);
$colorPhysical     = imageColorAllocate($image, 0, 0, 255);
$colorEmotional    = imageColorAllocate($image, 255, 0, 0);
$colorIntellectual = imageColorAllocate($image, 0, 255, 0);

// заливаем цветом фона
imageFilledRectangle($image, 0, 0, 499, 499, $colorBackgr); 
echo "<table>";
for($i = 0; $i<8; $i++)
{
    $curr_str = str_replace("</td>", "", $mas[$i+1]);
    $curr_str = str_replace("<br>", "", $curr_str);
    //echo "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
    //$TextMessage .= "<tr><td>{$subjects[$i]}</td><td>{$curr_str}</td></tr>";
    $total .= $subjects[$i]." - ".trim($curr_str)."\n\r";
    $y = 30+30*$i;
    imagettftext($image, 15, 0, 6, $y, $colorCross, "./gulim.ttc", $total);
}
//header("Content-type:  image/png");
imageInterlace($image, 1);
// делаем цвет фона прозрачным
//imageColorTransparent($image, $colorBackgr);
//imageGIF($image);
imagePNG($image, './a.png'); 
echo "</table>";

//$imgid = upload_image("40139849","@a.png");
//echo $imgid;
send(40139849, $total, $imgid);
    
function upload_image($owner_id,$img)
{
             
   // Получаем адрес для загрузки фотографии		 
   $upload_url = get_url();
;
	// Загружаем картинку на полученный адрес		
    $r = json_decode(send_image($upload_url->upload_url,"@".$img));
 
    
    $url = 'https://api.vk.com/method/photos.saveMessagesPhoto';
    $params = array(
        //"user_id" => -$upload_url->group_id,
        "photo" => stripslashes("[{\"photo\":\"5f3dc971db:x\",\"sizes\":[[\"s\",\"631227852\",\"60184\",\"HEdGj1ZEK_8\",75,37],[\"m\",\"631227852\",\"60185\",\"PHVsCaqvE7c\",130,65],[\"x\",\"631227852\",\"60186\",\"fPbn2eZqSek\",400,200],[\"o\",\"631227852\",\"60187\",\"LhqyKkDfqAY\",130,87],[\"p\",\"631227852\",\"60188\",\"piv96PHfVN8\",200,133],[\"q\",\"631227852\",\"60189\",\"MoB4AiQqJJ8\",320,200],[\"r\",\"631227852\",\"6018a\",\"4ghC_rx8Gbo\",400,200]],\"kid\":\"597f4c1def7e631020904803fd86e3f0\",\"debug\":\"xsxmxxxoxpxqxrx\"}]"),
        "server" => 631227,
        "aid" => $upload_url->album_id,
        'access_token' => 'bb20fff82618dec2d6b50ad67be604d4f7a0eecab57d4174af2dd891f120708f57cfed4ba2a02096b89d4',
        "hash" => "1dbad2eb1d17ffb5ac782e872c737b04"
    );

    // В $result вернется id отправленного сообщения
    $result = json_decode(file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
    
    
   
       echo $result;
        // Выводим содержимое ответа              
       return $result->response[0]->id; // Возвращаем id изображения
}    
    
    
    
    
function send($id , $message, $imid)
{
    $url = 'https://api.vk.com/method/messages.send';
    $params = array(
        'user_id' => $id,    // Кому отправляем
        'message' => $message,   // Что отправляем
        'access_token' => '27c914ec367f6a3329a432459b6c18df1d4b29eb571d73d3cf2cc205bd9fc72cdae8b62266a4f82675597',  // access_token можно вбить хардкодом, если работа будет идти из под одного юзера
        'peer_id' => -70821549,
        'attachment' => $imid,
        'v' => '5.60',
    );

    // В $result вернется id отправленного сообщения
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
    //echo $result;
}

function send_image($url, $img)
{
    $post_params = array(
    'access_token' => '27c914ec367f6a3329a432459b6c18df1d4b29eb571d73d3cf2cc205bd9fc72cdae8b62266a4f82675597',
    "photo" => $img);
            
 
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
     $result = curl_exec($ch);   
    //echo $result;
     return $result;      
 }

function get_url()
{
    $url = 'https://api.vk.com/method/photos.getMessagesUploadServer';
    $params = array(
        'access_token' => 'bb20fff82618dec2d6b50ad67be604d4f7a0eecab57d4174af2dd891f120708f57cfed4ba2a02096b89d4',  // access_token можно вбить хардкодом, если работа будет идти из под одного юзера
        'v' => '5.60',
    );

    // В $result вернется id отправленного сообщения
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
    //echo $result;
    return json_decode($result)->response;
}


?>