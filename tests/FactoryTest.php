<?php

use LajosBencz\ProgressBar\Factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testDefaults()
    {
        Factory::clearDefault();
        $this->assertInstanceOf(LajosBencz\ProgressBar\ProgressBar::class, Factory::createDefault());
        $c = new Factory;
        $this->assertEquals(Factory::DEFAULT_FORMATTER_CLASS, $c->formatterClass);
        $this->assertEquals([Factory::DEFAULT_WIDTH], $c->formatterArgs);
        $this->assertEquals(Factory::DEFAULT_OUTPUT, $c->output);
    }


    public function provideConfig()
    {
        return [
            [LajosBencz\ProgressBar\Formatter\SimpleFormatter::class, [4], STDERR],
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
        $c = new Factory($fc, $w, $o);
        $c->setDefault();
        $this->assertEquals($fc, $c->formatterClass);
        $this->assertEquals($w, $c->formatterArgs);
        $this->assertEquals($o, $c->output);
        /** @noinspection PhpUndefinedFieldInspection */
        $this->assertEquals(null, $c->noSuchProperty);

        $pb1 = $c->create();
        $pb2 = Factory::createDefault();
        $this->assertEquals($fc, get_class($pb1->getFormatter()));
        $this->assertEquals(get_class($pb1->getFormatter()), get_class($pb2->getFormatter()));
    }

    public function testSetPropertyException()
    {
        $c = new Factory;
        $this->expectExceptionObject(new RuntimeException());
        /** @noinspection Annotator */
        $c->formatterArgs = [];
    }

    public function testInvalidFormatterClass()
    {
        $this->expectExceptionMessageRegExp('/invalid formatter class/');
        new Factory(DateTime::class);
    }

    public function testInvalidOutput()
    {
        $this->expectExceptionMessageRegExp('/invalid output/');
        /** @noinspection PhpUnhandledExceptionInspection */
        new Factory(null, null, -1);
    }
}
