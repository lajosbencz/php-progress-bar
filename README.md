# php-progress-bar
 [![Build Status](https://travis-ci.com/lajosbencz/php-progress-bar.svg?branch=master)](https://travis-ci.com/lajosbencz/php-progress-bar)
 [![Code Coverage](https://codecov.io/gh/lajosbencz/php-progress-bar/branch/master/graph/badge.svg)](https://codecov.io/gh/lajosbencz/php-progress-bar/branch/master)
    
Extensible ANSI (only for terminals) progress bar for PHP


## Install
```bash
composer require --save lajosbencz/progress-bar
```

## Default usage
```php
use LajosBencz\ProgressBar;

$pb = ProgressBar\Factory::createDefault(10);

for($i=0; $i<10; $i++) {
    sleep(1);
    $pb($i);
}
```

## Customized usage
```php
use LajosBencz\ProgressBar;

$pb = new ProgressBar\ProgressBar(10);
$pb->setFormatterClass(ProgressBar\Formatter\SimpleFormatter::class, [60]);
$pb->setOutput(STDOUT);

for($i=0; $i<10; $i++) {
    sleep(1);
    $pb($i);
}
```

## Factory usage
```php
use LajosBencz\ProgressBar;

$pbf = new ProgressBar\Factory(
    // formatter class name:
    ProgressBar\Formatter\SimpleFormatter::class,
    // formatter args, will be passed into the constructor:
    [10, "|O-|"],
    // output stream to write to:
    STDERR
);

$pb = $pbf->create(10);
for($i=0; $i<10; $i++) {
    sleep(1);
    $pb($i);
}
```

## TODO
 - Comments
 - Interface with PSR logging facility
 - Meaningful tests
