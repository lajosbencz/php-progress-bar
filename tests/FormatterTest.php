<?php

use LajosBencz\ProgressBar\Formatter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    public function provideFormat()
    {
        return [
            ["|+-|", "|+-|", "|+-|"],
        ];
    }

    /**
     * @dataProvider provideFormat
     * @param string $symbols
     * @param string $bar
     * @param string $formatted
     * @param int $width
     * @param int $fill
     * @param string $info
     */
    public function testFormat($symbols, $bar, $formatted, $width = 4, $fill = 2, $info = '')
    {
        $f = new Formatter;
        $f->setSymbols($symbols);
        $this->assertEquals($bar, $f->formatBar($width, $fill));
        $this->assertEquals($formatted, $f->format($width, $fill, $width, $info));
    }

    public function testAbort()
    {

    }
}
