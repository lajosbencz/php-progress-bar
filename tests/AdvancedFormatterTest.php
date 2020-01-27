<?php

use LajosBencz\ProgressBar\Formatter\AdvancedFormatter;
use LajosBencz\ProgressBar\Progress;
use PHPUnit\Framework\TestCase;

class AdvancedFormatterTest extends TestCase
{
    public function provideAdvancedFormatter()
    {
        return [
            [100, 0, 6, '12abc45', ['1', '2', 'abc', '4', '5'], '144445'],
            [100, 50, 6, '12abc45', ['1', '2', 'abc', '4', '5'], '122445'],
            [100, 0, 9, '12abc45', ['1', '2', 'abc', '4', '5'], '1 0.0% a5'],
            [100, 50, 10, '12abc45', ['1', '2', 'abc', '4', '5'], '1 50.0% a5'],
            [100, 50, 12, '12abc45', ['1', '2', 'abc', '4', '5'], '1 50.0% a445'],
            [100, 50, 20, '12abc45', ['1', '2', 'abc', '4', '5'], '1 00:00:00 50.0% a45'],
        ];
    }

    /**
     * @dataProvider provideAdvancedFormatter
     * @param int $total
     * @param int $progress
     * @param int $width
     * @param string $symbols
     * @param array $symbolList
     * @param string $formatted
     */
    public function testAdvancedFormatter($total, $progress, $width, $symbols, $symbolList, $formatted)
    {
        $p = new Progress($total);
        $p->update($progress);
        $af = new AdvancedFormatter($width, $symbols);
        $this->assertEquals($symbolList, $af->getSymbolList());
        $this->assertEquals($formatted, $af->formatBar($p));
    }

    public function testSpinner()
    {
        $p = new Progress(100);
        $p->update(50);
        $af = new AdvancedFormatter(10, '[=ab ]');
        $this->assertEquals(['[', '=', 'ab', ' ', ']'], $af->getSymbolList());
        $this->assertEquals('[ 50.0% a]', $af->formatBar($p));
        $this->assertEquals('[ 50.0% b]', $af->formatBar($p));
        $this->assertEquals('[ 50.0% a]', $af->formatBar($p));
    }
}
