<?php 

// регулярное выражение для номера закона внутри ссылки
define('BILL_ID_REGEX', '/[0-9]+(-[0-9]+)?/');

// Решение задания №2 - замена старых ссылок в html
// Входные данные:
// line - содержимое всего файла с входными данными
// Выходные данные:
// string - обработанная line
function solve2($line): string
{
	return preg_replace_callback(
    '/http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent\&RN=[0-9]+(-[0-9]+)?&[0-9]+/',
    function ($matches): string {
      $billIdMatch = array();
      preg_match(BILL_ID_REGEX, $matches[0], $billIdMatch);
    	return 'http://sozd.parlament.gov.ru/bill/'.$billIdMatch[0];
    },
    $line
  );
}
