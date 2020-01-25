<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LajosBencz\ProgressBar\ProgressBar;

function title(string $text, int $w = 60, string $pad = '-') {
    return PHP_EOL .
        //str_repeat($pad, $w) . PHP_EOL .
        str_pad(' '.$text.' ', $w, $pad, STR_PAD_BOTH) . PHP_EOL .
        //str_repeat($pad, $w) . PHP_EOL .
        '' . PHP_EOL;
};

const SLP = 1000 * 10;

echo title('abort early');

$pb = new ProgressBar;
$pb(0,  '');
unset($pb);

echo title('abort by unset');

$pb = new ProgressBar;
for ($i = 0; $i < 100; $i++) {
    if ($i >= 33) {
        unset($pb);
        break;
    }
    $pb($i + 1, $i . '. item!');
    usleep(SLP);
}


echo title('abort by method');

$pb = new ProgressBar;
for ($i = 0; $i < 100; $i++) {
    if ($i >= 66) {
        $pb->abort();
        break;
    }
    $pb($i + 1, $i . '. item!');
    usleep(SLP);
}

echo title('let it finish');

$pb = new ProgressBar;
for ($i = 0; $i < 100; $i++) {
    $pb($i + 1, $i . '. item!');
    usleep(SLP);
}

echo title('that\'s all folks!');
