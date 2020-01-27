<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LajosBencz\ProgressBar\Factory;

const SLP = 1000 * 100;
const W = 60;

function title(string $text, int $w = W, string $pad = '-') {
    return PHP_EOL .
        //str_repeat($pad, $w) . PHP_EOL .
        str_pad(' '.$text.' ', $w, $pad, STR_PAD_BOTH) . PHP_EOL .
        //str_repeat($pad, $w) . PHP_EOL .
        '' . PHP_EOL;
};

new Factory(LajosBencz\ProgressBar\Formatter\AdvancedFormatter::class, [60, "[=|/-\\ ]"]);
echo get_class(Factory::createDefault()->getFormatter()), PHP_EOL;

echo title('abort early');

$pb = Factory::createDefault();
$pb(0,  '');
unset($pb);

echo title('abort by unset');

$pb = Factory::createDefault();
for ($i = 0; $i < 100; $i++) {
    if ($i >= 33) {
        unset($pb);
        break;
    }
    $pb($i + 1, $i . '. item!');
    usleep(SLP);
}


echo title('abort by method');

$pb = Factory::createDefault();
for ($i = 0; $i < 100; $i++) {
    if ($i >= 66) {
        $pb->abort();
        break;
    }
    $pb($i + 1, $i . '. item!');
    usleep(SLP);
}

echo title('let it finish');

$pb = Factory::createDefault();
for ($i = 0; $i < 100; $i++) {
    $pb($i + 1, $i . '. item!');
    usleep(SLP);
}

echo title('that\'s all folks!');
