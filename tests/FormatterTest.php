<?php

use LajosBencz\ProgressBar\Formatter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    public function provideFormat()
    {
        return [
            [  11, "[   1.1% ]", "\e[?25l[   1.1% ]\n"],
            [ 111, "[  11.1% ]", "\e[?25l[  11.1% ]\n"],
            [1111, "[ 100.0% ]", "\e[?25l[ 100.0% ]\r\e[?25h\n"],
        ];
    }

    /**
     * @dataProvider provideFormat
     * @param string $progress
     * @param string $bar
     * @param string $formatted
     * @param string $info
     */
    public function testFormat($progress, $bar, $formatted, $info = '')
    {
        $p = new LajosBencz\ProgressBar\Progress(1000);
        $p->update($progress);
        $f = new Formatter;
        $this->assertEquals($bar, $f->formatBar($p));
        $this->assertEquals($formatted, $f->format($p, $info));
    }

    public function testAbort()
    {
        $f = new Formatter;
        $this->assertEquals(Formatter::ANSI_CURSOR_SHOW, $f->abort());
    }
}
