<?php 

// Решение задания B - преобразователь IPv6 адресов из сокращенного в полный вид
// Входные данные:
// line - строка из файла с данными
// Выходные данные:
// string - обработанная строка
function solveB($line): string
{
	$parts = explode('::', $line);

	// если line не содержит ::
	if (count($parts) === 1) {
		$parts[] = '';
	}

	[$parts1, $parts2] = array_map(
		function ($strPart)
		{
			// убираем пустую строку после explode, если :: стоит с краю
			return !strcmp($strPart, '') ? 
				[] : 
				explode(':', $strPart);
		},
		$parts
	);

	$additionalPartsCount = 8 - count($parts1) - count($parts2);

	//генерируем пустые блоки, которые в дальнейшем заполнятся как "0000"
	$additionalParts = ($additionalPartsCount === 0) ? [] : array_fill(0, $additionalPartsCount, '');

	//добавляем нули во все блоки, в которых меньше 4 символов
	$allParts = array_map(
		function ($part)
		{
			return str_repeat('0', 4 - strlen($part)) . $part;
		}, 
		array_merge($parts1, $additionalParts, $parts2)
	);

	//соединяем обратно блоки
	return implode(':', $allParts);
}
