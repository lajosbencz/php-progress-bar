<?php

use LajosBencz\ProgressBar\ProgressBar;
use PHPUnit\Framework\TestCase;

class ProgressBarTest extends TestCase
{
    public function testProgressBar()
    {
        $b = fopen('php://memory', 'w+');
        $pb = new ProgressBar();
        $pb->setOutput($b);
        for($i=0; $i<100; $i++) {
            $pb->update($i);
            $pb->show();
            //usleep(1000 * 100);
        }
        rewind($b);
        $this->assertNotEmpty(stream_get_contents($b));
    }
}
