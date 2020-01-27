<?php

use LajosBencz\ProgressBar\Progress;
use PHPUnit\Framework\TestCase;

class ProgressTest extends TestCase
{
    public function testProgress()
    {
        $p = new Progress(100);

        $this->assertFalse($p->isDone());
        $this->assertEquals(100, $p->getTotal());
        $this->assertEquals(0, $p->getProgress());

        $this->assertFalse($p->increment());
        $this->assertEquals(1, $p->getProgress());

        $this->assertFalse($p->increment(5));
        $this->assertEquals(6, $p->getProgress());

        $this->assertFalse($p->update(5));
        $this->assertEquals(5, $p->getProgress());

        $this->assertTrue($p->increment(95));
        $this->assertEquals(100, $p->getProgress());
        $this->assertTrue($p->isDone());

        $this->assertTrue($p->update(100));
        $this->assertEquals(100, $p->getProgress());
        $this->assertTrue($p->isDone());

        $p->reset();
        $this->assertEquals(0, $p->getProgress());
        $this->assertFalse($p->isDone());

        $this->assertTrue($p->update(105));
        $this->assertEquals(100, $p->getProgress());
    }

    public function testToString()
    {
        $p = new Progress(1000);
        $this->assertEquals('  0.0%', (string)$p);
        $p->increment(505);
        $this->assertEquals(' 50.5%', (string)$p);
        $p->increment(495);
        $this->assertEquals('100.0%', (string)$p);
    }

    public function testRatio()
    {
        $p = new Progress(100);
        $p->update(50);
        $this->assertEquals(0.5, $p->getRatio());
        $this->assertEquals(5, $p->getRatio(10));
        $p->setTotal(50);
        $this->assertEquals(1, $p->getRatio());
    }

    public function testInvalidTotal()
    {
        $p = new Progress(100);
        $this->expectExceptionMessage('total must be greater than 0');
        $p->setTotal(0);
    }
}
