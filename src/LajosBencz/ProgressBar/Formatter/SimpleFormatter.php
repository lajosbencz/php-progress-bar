<?php
declare (strict_types=1);

namespace LajosBencz\ProgressBar\Formatter;


use LajosBencz\ProgressBar\Factory;
use LajosBencz\ProgressBar\Formatter;
use LajosBencz\ProgressBar\FormatterInterface;
use LajosBencz\ProgressBar\Progress;

class SimpleFormatter extends Formatter implements FormatterInterface
{
    const DEFAULT_SYMBOLS = "[= ]";

    protected $_width = Factory::DEFAULT_WIDTH;

    protected $_symbols = self::DEFAULT_SYMBOLS;

    public function __construct(int $width=0, string $symbols='')
    {
        if($width > 0) {
            $this->setWidth($width);
        }
        if(strlen($symbols) > 0) {
            $this->setSymbols($symbols);
        }
    }

    public function setWidth(int $width): void
    {
        $this->_width = max(4, $width);
    }

    public function setSymbols(string $symbols): void
    {
        $l = strlen(self::DEFAULT_SYMBOLS);
        if (strlen($symbols) < $l) {
            throw new \InvalidArgumentException('symbols string must be at least ' . $l . ' chars');
        }
        $this->_symbols = $symbols;
    }

    public function formatBar(Progress $progress): string
    {
        $width = $this->_width - 2;
        $fill = (int)$progress->getRatio($width);
        $out = "";

        $out .= $this->_symbols[0];
        $out .= str_repeat($this->_symbols[1], $fill);
        $out .= str_repeat($this->_symbols[2], $width - $fill);
        $out .= $this->_symbols[3];

        return $out;
    }
}
