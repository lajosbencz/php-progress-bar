<?php

namespace LajosBencz\ProgressBar\Formatter;


use LajosBencz\ProgressBar\Progress;

class AdvancedFormatter extends SimpleFormatter
{
    public function formatBar(Progress $progress): string
    {
        $p = ' ' . $progress . ' |';
        $l = strlen($p);

        $width = max($l + 2, $this->_width);
        $lim = $width - 2;
        $fill = (int)$progress->getRatio($lim);
        $out = "";

        $out .= $this->_symbols[0];

        if($fill <= $l) {
            $out .= $p . str_repeat($this->_symbols[2], $lim - $l);
        } else {
            $out .= str_repeat($this->_symbols[1], $fill - $l);
            $out .= $p;
            $out .= str_repeat($this->_symbols[2], $lim - $fill);
        }

        $out .= $this->_symbols[3];

        return $out;
    }
}
