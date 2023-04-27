<?php

$text = $_POST['text'];
$keyword = $_POST['keyword'];

function caesarCipher($text, $keyword, $encrypt=true) {
    $start_time = microtime(true);
    $text = strtoupper($text); // переводим текст в верхний регистр
    $keyword = strtoupper($keyword); // переводим ключевое слово в верхний регистр
    $shifts = []; // массив алфавита уже с ключевым словом

    $keywordArr = str_split($keyword);
    $keywordArr = array_unique($keywordArr); // массив символов ключа

    $aplhArr = range('A', 'Z');

    // заполнение массива в соответствии с алгоритмом
    foreach ($keywordArr as $value) {
        $shifts[] = $value;
    }
    foreach ($aplhArr as $value) {
        if (!in_array($value, $shifts)) {
            $shifts[] = $value;
        }
    }

    // создание ассоциативного массива с парами
    $count_num = 0;
    foreach ($aplhArr as $value) {
      $newArr[$value] = $shifts[$count_num];
      $count_num++;
    }
    $newArr[' '] = ' ';

    $result = '';
    if (!$encrypt) {
      $newArr = array_flip($newArr);
    }

    for ($i = 0; $i < strlen($text); $i++) {
      $result .= $newArr[$text[$i]]; // шифрование или расшифрование сообщения
    }

    $end_time = microtime(true);
    $time = ($end_time - $start_time) * 1000;

    return ['text' => $result, 'time' => $time, 'sym' => characterFrequencyHistogram($result)];
}

function characterFrequencyHistogram($string) {
    $char_count = array();
    $string_length = strlen($string);
    $strSymCount = count(str_split($string));
  
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
        $table_html .= "<td>" . bcdiv($count / $strSymCount, 1, 2) . "</td>";
    }
    $table_html .= "</tr></tbody></table>";
  
    return $table_html;
}

$enc = caesarCipher($text, $keyword, true);
$dec = caesarCipher($enc['text'], $keyword, false);

echo json_encode([
    "enc" => $enc, 
    "dec" => $dec
]);