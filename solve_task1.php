<?php 

// Решение задания №1 - умножение всех целых числел в одинарных кавычках на 2
// Входные данные:
// line - строка из файла с данными
// Выходные данные:
// string - обработанная строка
function solve1($line): string
{	// для каждого совпадения по регулярному выражению в строке line вызывается анонимная функция
    return preg_replace_callback(
        '/\'[0-9]+\'/',
        function ($matches): string {
           	$newNum = intval(substr($matches[0], 1, -1)) * 2;
            return "'" . $newNum . "'";
        },
        $line
    );
}
