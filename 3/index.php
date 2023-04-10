<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <?php
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);

        $m = 367;
        $n = 401;

        function searchSimple($start, $end) {
            $count = 0;
            $numbers = [];

            for ($i = $start; $i <= $end; $i++) {
                $flag = true;

                for ($j = 2; $j < $i; $j++) {
                    if ($i % $j == 0 && $i % 1 == 0) {
                        $flag = false;
                    }
                }

                if ($flag) {
                    $numbers[] = $i;
                    $count++;
                }
            }
            
            return [$count, implode(', ', $numbers)];
        }

        function gcd(...$numbers) {
            $result = $numbers[0];
            
            for ($i = 1; $i < count($numbers); $i++) {
              $result = gcd_two_numbers($result, $numbers[$i]);
            }
            
            return $result;
        }
          
        function gcd_two_numbers($a, $b) {
            while ($b != 0) {
              $t = $b;
              $b = $a % $b;
              $a = $t;
            }
            
            return $a;
        }

        function sieveOfEratosthenes($start, $end) {
            $numbers = range($start, $end);
          
            for ($i = 2; $i <= sqrt($end); $i++) {
              for ($j = $i * $i; $j <= $end; $j += $i) {
                if (in_array($j, $numbers)) {
                  unset($numbers[array_search($j, $numbers)]);
                }
              }
            }

            return implode(', ', array_values($numbers));
        }

        function primeFactorization($n) {
            $factors = array();
            $divisor = 2;

            while ($n >= $divisor) {
              if ($n % $divisor == 0) {
                $n /= $divisor;
                array_push($factors, $divisor);
              } else {
                $divisor++;
              }
            }

            $result = implode(' x ', $factors);
            return $result;
        }

        function isPrime($n) {
            if ($n <= 1) {
              return false;
            }

            for ($i = 2; $i <= sqrt($n); $i++) {
              if ($n % $i == 0) {
                return false;
              }
            }

            return true;
        }

        function euler($n) {
            $result = $n;

            for ($i = 2; $i <= sqrt($n); $i++) {
              if ($n % $i == 0) {
                while ($n % $i == 0) {
                  $n /= $i;
                }

                $result -= $result / $i;
              }
            } if ($n > 1) {
              $result -= $result / $n;
            }

            return $result;
        }
    ?>

    <p>Вариант 3, m=367, n=401</p>
    <p><b>Задание №1</b><br>
    Простые числа в интервале [2, n] – <?php echo searchSimple(2, $n)[1]; ?><br>
    Количество – <?php echo searchSimple(2, $n)[0]; ?><br>
    Число n/ln(n) – <?php echo $n/log($n); ?></p>

    <p><b>Задание №2</b><br>
    Простые числа в интервале [m, n] – <?php echo searchSimple($m, $n)[1]; ?><br>
    Количество – <?php echo searchSimple($m, $n)[0]; ?><br>
    Вычисления полученные при помощи решета Эратосфена – <?php print_r(sieveOfEratosthenes($m, $n)); ?>

    <p><b>Задание №3</b><br>
    Запись чисел m и n в виде произведения простых множителей – <?php echo(primeFactorization($m) . ' и ' . primeFactorization($n)); ?><br>

    <p><b>Задание №4</b><br>
    Число <?php echo $m . $n; ?> является простым? – <?php echo(isPrime($m . $n) ? 'Да' : 'Нет'); ?><br>

    <p><b>Задание №5</b><br>
    НОД чисел <?php echo $m . ' и ' . $n ?> – <?php echo gcd($m, $n); ?><br>
</body>
</html>