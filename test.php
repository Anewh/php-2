<?php 

require_once "./solve_task1.php";
require_once "./solve_task2.php";
require_once "./solve_taskB.php";
require_once "./solve_taskC.php";

function testByLines($solveFunction, $dataPath, $answerPath): bool
{
	$dataLines = file($dataPath);
	$answerLines = file($answerPath);

	foreach ($dataLines as $i => $line) {
		$line = trim($line);
		$answer = trim($answerLines[$i]);

		$result = $solveFunction($line);

		// echo print_r([$line, $result, $answer]);
		if ($result !== $answer) {
			return false;
		}
	}
	return true;
}

function testWholeFile($solveFunction, $dataPath, $answerPath): bool
{
	$line = file_get_contents($dataPath);
	$answer = file_get_contents($answerPath);

	$result = $solveFunction($line);

	return $result === $answer;
}

function testFiles($taskToTest, $solveFunction, $isByLines)
{
	echo 'Тестирование ' . $taskToTest . ":\n";

	$dataFilesDir = './' . $taskToTest . '/dat/';
	$answerFilesDir = './' . $taskToTest . '/ans/';

	$testFunction = $isByLines ? 'testByLines' : 'testWholeFile'; 

	$dataPaths = scandir($dataFilesDir);
	$answerPaths = scandir($answerFilesDir);

	for ($i=2; $i < count($dataPaths); $i++) {
		$testResult = $testFunction(
			$solveFunction,
			$dataFilesDir . $dataPaths[$i], 
			$answerFilesDir . $answerPaths[$i]
		);

		echo 'Тест ' . ($i-1) . ($testResult ? ' ' : ' не ') . "пройден\n";
	}
	echo "\n";
}

testFiles('1', 'solve1', 1);
testFiles('2', 'solve2', 0);
testFiles('B', 'solveB', 1);
testFiles('C', 'solveC', 1);
