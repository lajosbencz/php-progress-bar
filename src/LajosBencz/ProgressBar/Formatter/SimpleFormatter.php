<?php
declare (strict_types=1);

namespace LajosBencz\ProgressBar\Formatter;


use LajosBencz\ProgressBar\Formatter;
use LajosBencz\ProgressBar\FormatterInterface;

class SimpleFormatter extends Formatter implements FormatterInterface
{
    public function formatBar(int $width, int $fill=0, float $fraction=0.0): string
    {
        $out = "";

        $out .= $this->_symbols[0];
        for ($i = 0; $i < $width; $i++) {
            if ($i <= $fill) {
                $out .= $this->_symbols[1];
            } else {
                $out .= $this->_symbols[2];
            }
        }
        $out .= $this->_symbols[3];

        $out = $out . self::ANSI_NEWLINE . $out;

        return $out;
    }
}
