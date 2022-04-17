<?php 

define('DATE_FORMAT', 'd.m.Y H:i');
define('PHONE_REGEX', '/^\+7 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/');
define('EMAIL_REGEX', '/^[a-zA-Z0-9][a-zA-Z0-9_]{3,29}+@[a-zA-Z]{2,30}\.[a-z]{2,10}$/');

// Решение задания С - валидация
// Входные данные:
// line - строка из файла с данными
// Выходные данные:
// string - обработанная строка
function solveC($line): string
{
    $parts = explode('>', $line);
    // тестируемое значение в первой части после <
    $testingValue = substr($parts[0], 1);
    // остальное - параметры через пробел
    $params = explode(' ', $parts[1]);

    // пропускаем первое значение до пробела
    $validationRule = $params[1];

    $result = true;

    if (in_array($validationRule, ['S', 'N'])) {
        $min = intval($params[2]);
        $max = intval($params[3]);

        $testingValue;
        if ($validationRule === 'S') {
            $testingValue = strlen($testingValue);
        } else { // если тип валидации N
            $testingValueOld = $testingValue;
            $testingValue = intval($testingValue);
            $result = strval($testingValue) === $testingValueOld;
        }
        $result = $result && ($testingValue >= $min && $testingValue <= $max);
        
    } else if ($validationRule === 'D') {
        $newDate = date_create_from_format(DATE_FORMAT, $testingValue)
                ->format(DATE_FORMAT);
        $result = !strcmp($testingValue, $newDate);
        
        // простой рандомный критерий проверки корректности дат, который отсекает неправильные даты
        // суммируем значения всех полей для каждой из дат - новой(newDate) и старой(testingValue)
        // если переформатированная дата не совпала с входной, проверяем корректность входных данных
        [$dateSum1, $dateSum2] = array_map(
            function ($strDate)
            {
                return array_sum(array_map(
                    "intval", 
                    preg_split('/[.:\s]/', $strDate)
                ));
            },
            [$testingValue, $newDate]
        );
        $result = $result || ($dateSum1 === $dateSum2);
        // год тут меньше 1000 не выдает ошибку при парсинге даты в date_create_from_format, по условию это неправильно
        $year = intval(explode('.', explode(' ', $testingValue)[0])[2]);
        $result = $result && $year >= 1000;

    } else if (in_array($validationRule, ['P', 'E'])) {
        $regex = ($validationRule === 'P') ? PHONE_REGEX : EMAIL_REGEX;
        $result = preg_match($regex, $testingValue);

    } else {
        $result = false;
    }

    return $result ? 'OK' : 'FAIL';
}
