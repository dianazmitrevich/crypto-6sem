<?php

$text = $_POST['text'];
$keyword = $_POST['keyword'];

function trisemusCipher($text, $keyword, $rows, $columns, $encrypt = true) {
    $start_time = microtime(true);
    $text = strtoupper($text); // переводим текст в верхний регистр
    $keyword = strtoupper($keyword); // переводим ключевое слово в верхний регистр
    $shifts = []; // массив алфавита уже с ключевым словом

    $keywordArr = str_split($keyword);
    $keywordArr = array_unique($keywordArr); // массив символов ключа

    $aplhArr = range('A', 'Z');

    $textArr = str_split($text);

    // заполнение массива в соответствии с алгоритмом
    foreach ($keywordArr as $value) {
      $shifts[] = $value;
    }
    foreach ($aplhArr as $value) {
      if (!in_array($value, $shifts)) {
          $shifts[] = $value;
      }
    }
    $shifts[] = ' ';

    // создание таблицы Трисемуса
    $count_num = 0;
    for ($i = 0; $i < $rows; $i++) {
      for ($j = 0; $j < $columns; $j++) {
        $matrix[$i][$j] = $shifts[$count_num];
        $count_num++;
      }
    }

    // шифрование и расшифрование сообщения
    $result = '';
    foreach ($textArr as $value) {
      for ($i = 0; $i < count($matrix); $i++) {
        for ($j = 0; $j < count($matrix[$i]); $j++) {
          if ($matrix[$i][$j] == $value) {
            $row = $i;
            $col = $j;

            if (!$encrypt) {
              if ($row == 0) {
                $row = $rows - 1;
              } else {
                $row -= 1;
              }
            } else {
              if ($row == $rows - 1) {
                $row = 0;
              } else {
                $row += 1;
              }
            }

            $result .= $matrix[$row][$col]; 
          }
        }
      }
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

$enc = trisemusCipher($text, $keyword, 5, 6, true);
$dec = trisemusCipher($enc['text'], $keyword, 5, 6, false);

echo json_encode([
    "enc" => $enc, 
    "dec" => $dec,
]);