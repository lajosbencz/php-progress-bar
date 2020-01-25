<?php

use LajosBencz\ProgressBar\Formatter\SpinningFormatter;
use LajosBencz\ProgressBar\Progress;
use PHPUnit\Framework\TestCase;

class SpinningFormatterTest extends TestCase
{
    public function provideFormat()
    {
        $frames = ['|','/','-','\\'];
        return [
            [$frames, $progress=0, "|   0.0%"],
            [$frames, $progress=1, "/   1.0%"],
            [$frames, $progress=2, "-   2.0%"],
            [$frames, $progress=3, "\\   3.0%"],
            [$frames, $progress=4, "|   4.0%"],
        ];
    }

    /**
     * @dataProvider provideFormat
     * @param array $frames
     * @param int $progress
     * @param string $output
     */
    public function testFormat($frames, $progress, $output)
    {
        $p = new Progress(100);
        $f = new SpinningFormatter($frames);
        for($i=0; $i<$progress; $i++) {
            $p->increment();
            $f->formatBar($p);
        }
        $this->assertEquals($output, $f->formatBar($p));
    }

    public function testFramesInvalid()
    {
        $this->expectExceptionMessageRegExp('/symbol list is empty/');
        new SpinningFormatter([]);
    }

    public function testDone()
    {
        $p = new Progress(100);
        $p->update(100);
        $f = new SpinningFormatter;
        $this->assertEquals("   100.0%", $f->formatBar($p));
    }
}
