<?php

use LajosBencz\ProgressBar\Formatter\SpinningFormatter;
use LajosBencz\ProgressBar\Progress;
use PHPUnit\Framework\TestCase;

class AdvancedFormatterTest extends TestCase
{
    public function testSymbols()
    {
        $p = new Progress(100);
        $p->update(0);
        $af = new \LajosBencz\ProgressBar\Formatter\AdvancedFormatter(5, "12abc45");
        $this->assertEquals(['1', '2', 'abc', '4', '5'], $af->getSymbolList());
        $this->assertEquals('14445', $af->formatBar($p));
    }
}
