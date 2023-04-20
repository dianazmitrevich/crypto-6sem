<?php

$text = $_POST['text'];
$keyword = $_POST['keyword'];

function encrypt($text, $keyword) {
    $start_time = microtime(true);
    $alphabet = range('a', 'z'); // cоздаем массив с алфавитом
    $keyArr = str_split(str_replace(' ', '', $keyword)); // разбиваем ключевое слово на массив символов
    $keyLength = count($keyArr); // определяем длину ключа
    $textArr = str_split(str_replace(' ', '', $text)); // разбиваем исходный текст на массив символов
    $textLength = count($textArr); // определяем длину текста
  
    $keyIndex = 0; // устанавливаем начальный индекс ключа
    $result = '';
  
    for ($i = 0; $i < $textLength; $i++) { // проходимся по всем символам текста
      $letter = $textArr[$i]; // получаем текущий символ
      
      if (!in_array($letter, $alphabet)) { // если символ не находится в алфавите, то добавляем его в результат и переходим к следующему символу
        $result .= $letter;
        continue;
      }
  
      $shift = array_search($keyArr[$keyIndex], $alphabet);  // ищем сдвиг символа по ключу
      $keyIndex = ($keyIndex + 1) % $keyLength; // обновляем индекс ключа
  
      // ищем индекс зашифрованного символа в алфавите и добавляем его к результату
      $index = (array_search($letter, $alphabet) + $shift) % 26;
      $result .= $alphabet[$index];
    }

    $end_time = microtime(true);
    $time = ($end_time - $start_time) * 1000;
    
    return ['text' => $result, 'time' => $time, 'sym' => characterFrequencyHistogram($result)];
}
  
function decrypt($text, $keyword) {
    $start_time = microtime(true);
    $alphabet = range('a', 'z');
    $keyArr = str_split(str_replace(' ', '', $keyword));
    $keyLength = count($keyArr);
    $textArr = str_split(str_replace(' ', '', $text));
    $textLength = count($textArr);
  
    $keyIndex = 0;
    $result = '';
  
    for ($i = 0; $i < $textLength; $i++) {
      $letter = $textArr[$i];
      if (!in_array($letter, $alphabet)) {
        $result .= $letter;
        continue;
      }
  
      $shift = array_search($keyArr[$keyIndex], $alphabet);
      $keyIndex = ($keyIndex + 1) % $keyLength;
  
      $index = (array_search($letter, $alphabet) - $shift + 26) % 26;
      $result .= $alphabet[$index];
    }

    $end_time = microtime(true);
    $time = ($end_time - $start_time) * 1000;

    return ['text' => $result, 'time' => $time, 'sym' => characterFrequencyHistogram($result)];
}

function characterFrequencyHistogram($string) {
  $char_count = array();
  $string_length = strlen($string);

  // подсчитываем количество вхождений каждого символа
  for ($i = 0; $i < $string_length; $i++) {
    $char = $string[$i];
    if (!isset($char_count[$char])) {
      $char_count[$char] = 0;
    }
    $char_count[$char]++;
  }

  // создаем HTML таблицу
  $table_html = "<table class='sym-table'><tbody><tr>";
  foreach ($char_count as $char => $count) {
    $table_html .= "<td>" . htmlspecialchars($char) . "</td>";
  }
  $table_html .= "</tr><tr>";
  foreach ($char_count as $char => $count) {
      $table_html .= "<td>" . bcdiv($count / 26, 1, 2) . "</td>";
    }
  $table_html .= "</tr></tbody></table>";

  return $table_html;
}

$enc = encrypt($text, $keyword);
$dec = decrypt($enc['text'], $keyword);

echo json_encode([
    "enc" => $enc, 
    "dec" => $dec,
]);