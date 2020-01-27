<?php

use LajosBencz\ProgressBar\ProgressBar;
use PHPUnit\Framework\TestCase;

class ProgressBarTest extends TestCase
{
    public function testFormatterClassInvalid()
    {
        $pb = new ProgressBar;
        $this->expectExceptionMessageRegExp('/must be instance of /');
        $pb->setFormatterClass(self::class);
    }

    public function testOutputInvalid()
    {
        $pb = new ProgressBar;
        $this->expectExceptionMessageRegExp('/invalid output/');
        $pb->setOutput(-1);
    }

    public function testOutputClosed()
    {
        $b = fopen('php://memory', 'w+');
        $pb = new ProgressBar;
        $pb->setOutput($b);
        fclose($b);
        $this->expectExceptionMessageRegExp('/failed writing to output stream/');
        $pb->update(10)->show();
    }

    public function testProgressBar()
    {
        $b = fopen('php://memory', 'w+');
        $pb = new ProgressBar(1);
        $this->assertEquals(1, $pb->getTotal());
        $pb->setTotal(100);
        $this->assertEquals(100, $pb->getTotal());
        $this->assertFalse($pb->isDone());
        $pb->setOutput($b);
        $pb->increment()->show();
        $this->assertFalse($pb->isDone());
        $pb->increment(5, 'stands at 6')->show();
        $this->assertFalse($pb->isDone());
        $pb->update(10, 'set to 10')->show();
        $this->assertFalse($pb->isDone());
        $pb(50, 'set to 50');
        $this->assertFalse($pb->isDone());
        $pb(100, 'done');
        $this->assertTrue($pb->isDone());
        unset($pb);
        rewind($b);
        $this->assertNotEmpty(stream_get_contents($b));
        // @todo properly test output
        fclose($b);
    }
}
