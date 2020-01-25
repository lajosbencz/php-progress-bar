# php-progress-bar
 [![Build Status](https://travis-ci.com/lajosbencz/php-progress-bar.svg?branch=master)](https://travis-ci.com/lajosbencz/php-progress-bar)
 [![Code Coverage](https://codecov.io/gh/lajosbencz/php-progress-bar/branch/master/graph/badge.svg)](https://codecov.io/gh/lajosbencz/php-progress-bar/branch/master/graph/badge.svg)
    
ANSI progress bar for PHP


## Install

```bash
composer require --save lajosbencz/progress-bar
```

## Simple usage

```php
$pb = LajosBencz\ProgressBar\Factory::createDefault();
for($i=0; $i<10; $i++) {
    $pb->update($i * 10);
    sleep(1);
}
```
