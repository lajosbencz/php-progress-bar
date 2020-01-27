<?php

use PHPUnit\Framework\TestCase;
use LajosBencz\ProgressBar\Progress;
use LajosBencz\ProgressBar\TimeLeft;

class TimeLeftTest extends TestCase
{
    public function provideTimeLeft()
    {
        return [
            [100, 1, 1, '00:01:39'],
            [100, 50, 50, '00:00:50'],
            [100, 25, 25, '00:01:15'],
            [100, 100, 100, '00:00:00'],
        ];
    }

    /**
     * @dataProvider provideTimeLeft
     * @param int $total
     * @param int $progress
     * @param int $elapsed
     * @param string $formatted
     */
    public function testTimeLeft($total, $progress, $elapsed, $formatted)
    {
        $p = new Progress($total);
        $p->update($progress);
        $tl = new TimeLeft(time() - $elapsed);
        $this->assertEquals($elapsed, $tl->getElapsed());
        $this->assertEquals($total - $progress, $tl->getRemaining($p));
        $this->assertEquals($formatted, $tl->formatRemaining($p));
    }

    public function testTimeLeft0()
    {
        $p = new Progress(100);
        $p->update(0);
        $tl = new TimeLeft(time());
        $this->assertEquals(0, $tl->getElapsed());
        $this->assertEquals(0, $tl->getRemaining($p));
        $this->assertEquals('00:00:00', $tl->formatRemaining($p));
    }
}
