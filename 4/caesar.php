<?php

$text = $_POST['text'];
$keyword = $_POST['keyword'];

function caesarCipher($text, $keyword, $encrypt=true) {
    $start_time = microtime(true);
    $text = strtoupper($text); // переводим текст в верхний регистр
    $keyword = strtoupper($keyword); // переводим ключевое слово в верхний регистр
    $shifts = []; // массив сдвигов

    for ($i = 0; $i < strlen($keyword); $i++) {
        $shifts[] = ord($keyword[$i]) - 65;
    }

    $result = '';
    $j = 0; // счетчик сдвигов

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];

        if (ctype_alpha($char)) { // проверяем, является ли символ буквой
            $shift = $shifts[$j];

            if (!$encrypt) {
                $shift = 26 - $shift; // если расшифровываем текст, инвертируем сдвиг
            }

            $ascii = ord($char);

            if ($ascii >= 65 && $ascii <= 90) { // шифруем только буквы
                $ascii = (($ascii + $shift - 65) % 26) + 65; // шифруем символ
                $result .= chr($ascii);
                $j = ($j + 1) % strlen($keyword); // переходим к следующему сдвигу
            }
        } else {
            $result .= $char; // если символ не является буквой, оставляем его без изменений
        }
    }

    $end_time = microtime(true);
    $time = ($end_time - $start_time) * 1000;

    return ['text' => $result, 'time' => $time, 'sym' => characterFrequencyHistogram($result)];
}

function characterFrequencyHistogram($string) {
    $char_count = array();
    $string_length = strlen($string);
  
    // Подсчитываем количество вхождений каждого символа
    for ($i = 0; $i < $string_length; $i++) {
      $char = $string[$i];
      if (!isset($char_count[$char])) {
        $char_count[$char] = 0;
      }
      $char_count[$char]++;
    }
  
    // Создаем HTML таблицу
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

$enc = caesarCipher($text, $keyword, true);
$dec = caesarCipher($enc['text'], $keyword, false);

echo json_encode([
    "enc" => $enc, 
    "dec" => $dec
]);