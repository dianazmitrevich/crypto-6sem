<?php

class L2 {
    public function getEntropy(string $message) {
        $probabilities = [];
        $repeatedChars = '';
        $entropy = 0;

        for ($i = 0; $i < strlen($message); $i++) {
            $sym = mb_substr($message, $i, 1);
            $repeats = 0;
            $isRepeated = false;
            $isTheSameLetter = false;

            for ($j = 0; $j < strlen($message); $j++) {
                if ($sym == mb_substr($message, $j, 1)) {
                    $isRepeated = true;
                    $repeats++;
                }
            }

            for ($d = 0; $d < strlen($repeatedChars); $d++) {
                if ($sym == mb_substr($repeatedChars, $d, 1)) {
                    $isTheSameLetter = true;
                }
            }

            if ($isRepeated) {
                $repeatedChars .= $sym;
            }

            if (!$isTheSameLetter) {
                $entropy += ((-1) * ($repeats / strlen($message)) * log($repeats / strlen($message), 2));
                $probabilities[$sym] = [$repeats, $repeats / strlen($message)];
            }
        }

        return [
            'Entropy' => $entropy,
            'Probabilities' => $probabilities,
        ];
    }

    public function getInfo(string $message, $p) {
        $q = 1 - $p;
        
        return strlen($message) * 8 * (1 - (-$p * log($p, 2) - $q * log($q, 2)));
    }
}