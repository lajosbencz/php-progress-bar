<?php

require_once __DIR__ . '/../vendor/autoload.php';

$f = new \LajosBencz\ProgressBar\Formatter;

echo PHP_EOL;
echo $f->formatBar(4, 2), PHP_EOL;
echo PHP_EOL;

echo PHP_EOL;
echo $f->format(4, 2, 4, '');
echo $f->format(4, 2, 4, '');
echo PHP_EOL;
