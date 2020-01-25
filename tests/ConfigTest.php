<?php

use LajosBencz\ProgressBar\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testDefaults()
    {
        $c = new Config;
        $this->assertEquals(Config::DEFAULT_FORMATTER_CLASS, $c->formatterClass);
        $this->assertEquals(Config::DEFAULT_WIDTH, $c->width);
        $this->assertEquals(Config::DEFAULT_OUTPUT, $c->output);
    }


    public function provideConfig()
    {
        return [
            [\LajosBencz\ProgressBar\Formatter\SimpleFormatter::class, 4, STDERR],
        ];
    }

    /**
     * @dataProvider provideConfig
     * @param $fc
     * @param $w
     * @param $o
     * @throws \LajosBencz\ProgressBar\Exception
     */
    public function testConfig($fc, $w, $o)
    {
        $c = new Config($fc, $w, $o);
        $this->assertEquals($fc, $c->formatterClass);
        $this->assertEquals($w, $c->width);
        $this->assertEquals($o, $c->output);
    }

    public function testInvalidFormatterClass()
    {
        $this->expectExceptionMessageRegExp('/invalid formatter class/');
        new Config(DateTime::class);
    }

    public function testInvalidOutput()
    {
        $this->expectExceptionMessageRegExp('/invalid output/');
        new Config(null, null, -1);
    }
}
