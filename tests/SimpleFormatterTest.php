<?php

use LajosBencz\ProgressBar\Formatter\SimpleFormatter;
use PHPUnit\Framework\TestCase;

class SimpleFormatterTest extends TestCase
{
    public function provideFormat()
    {
        return [
            ["1234", "1234", "\e[?25l1234\n"],
            ["1234", "1222233334", "\e[?25l1222233334\n", 10, 5],
            ["|+-|", "|+-|", "\e[?25l|+-|\n"],
            ["|+-|", "|+++++++++---------|", "\e[?25l|+++++++++---------|\n", 20, 10],
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
        $p = new LajosBencz\ProgressBar\Progress($width);
        $p->update($fill);
        $f = new SimpleFormatter($width);
        $f->setSymbols($symbols);
        $this->assertEquals($bar, $f->formatBar($p));
        $this->assertEquals($formatted, $f->format($p, $info));
    }

}
