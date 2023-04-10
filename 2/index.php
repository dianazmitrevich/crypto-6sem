<?php

header('Content-Type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require '2.php';
$l2 = new L2();

$itA = 'abcdefghilmnopqrstuvz';
$moA = 'абвгдеёжзийклмноөпрстуүфхцчшщъыьэюя';
$str = 'puss in the boots';
// $str = 'кот в сапогах';
$bin = '01';
$lat = 'Zmitrevich Diana Andreevna';
$kir = 'Змитревич Диана Андреевна';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
</head>

<body>
    <style>
    body {
        font-family: 'Ubuntu', sans-serif;
    }

    table {
        width: 500px;
        border-spacing: 0;
    }

    table td {
        padding: 5px 8px;
        border: .5px solid #000;
    }

    table tr:nth-of-type(3) {
        background: #f2f2f2;
    }
    </style>
    <table>
        <tr>
            <td colspan="3">Строка "<?php echo $str; ?>"</td>
        </tr>
        <tr>
            <td colspan="3">Энтропия – <?php echo $l2->getEntropy($str)['Entropy']; ?> </td>
        </tr>
        <tr>
            <td>Символ</td>
            <td>Частота</td>
            <td>Вероятность</td>
        </tr> <?php
            foreach ($l2->getEntropy($str)['Probabilities'] as $key => $value) {
                ?> <tr>
            <td><?php echo $key; ?></td>
            <td><?php echo $value[0]; ?></td>
            <td><?php echo $value[1]; ?></td>
        </tr> <?php
            }
        ?>
    </table>
    <p>Количество информации в сообщении на основе латиницы –
        <?php echo strlen($itA) * $l2->getEntropy($itA)['Entropy']; ?> </p>
    <p>Количество информации в сообщении на основе кириллицы –
        <mark><?php echo strlen($moA) * $l2->getEntropy($moA)['Entropy']; ?></mark></p>
    <p>Количество информации в сообщении в кодах ASCII на основе латиницы –
        <?php echo strlen($itA) * 8 * $l2->getEntropy($bin)['Entropy']; ?></p>
    <p>Количество информации в сообщении в кодах ASCII на основе кириллицы –
        <mark><?php echo strlen($moA) * 8 * $l2->getEntropy($bin)['Entropy']; ?></mark></p>
    <br><br>
    <p>Количество информации в сообщении в кодах ASCII на основе латиницы (0.1) – <?php echo $l2->getInfo($itA, 0.1); ?>
    </p>
    <p>Количество информации в сообщении в кодах ASCII на основе кириллицы (0.1) –
        <mark><?php echo $l2->getInfo($moA, 0.1); ?></mark></p>
    <br><br>
    <p>Количество информации в сообщении в кодах ASCII на основе латиницы (0.5) – <?php echo $l2->getInfo($itA, 0.5); ?>
    </p>
    <p>Количество информации в сообщении в кодах ASCII на основе кириллицы (0.5) –
        <?php echo $l2->getInfo($moA, 0.5); ?> </p>
</body>

</html>