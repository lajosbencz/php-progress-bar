<?php

namespace LajosBencz\ProgressBar\Formatter;


use LajosBencz\ProgressBar\Factory;
use LajosBencz\ProgressBar\Progress;
use LajosBencz\ProgressBar\TimeLeft;

class AdvancedFormatter extends SimpleFormatter
{
    const DEFAULT_SYMBOLS = "[=> ]";

    protected $_timeLeft;
    protected $_symbols = self::DEFAULT_SYMBOLS;
    protected $_sOpen;
    protected $_sFill;
    protected $_sAt;
    protected $_sEmpty;
    protected $_sClose;
    protected $_oAt = 0;

    protected function _getNextAt()
    {
        $at = $this->_sAt[$this->_oAt];
        $this->_oAt++;
        if($this->_oAt >= strlen($this->_sAt)) {
            $this->_oAt = 0;
        }
        return $at;
    }

    public function __construct(int $width = Factory::DEFAULT_WIDTH, ?string $symbols = null)
    {
        parent::__construct($width, $symbols);
        $this->_timeLeft = new TimeLeft;
    }

    public function setSymbols(string $symbols): void
    {
        parent::setSymbols($symbols);
        //$l = strlen($symbols);
        $this->_sOpen = $symbols[0];
        $this->_sFill = $symbols[1];
        $this->_sAt = substr($symbols, 2, -2);
        $this->_sEmpty = substr($symbols, -2, 1);
        $this->_sClose = substr($symbols, -1, 1);
    }

    public function getSymbolList()
    {
        return [
            $this->_sOpen,
            $this->_sFill,
            $this->_sAt,
            $this->_sEmpty,
            $this->_sClose,
        ];
    }

    public function formatBar(Progress $progress): string
    {
        $width = $this->_width - 2;
        $fill = (int)$progress->getRatio($width);

        $at = $this->_getNextAt();
        $prc = ' '.trim($progress) . ' '.$at;
        $lPrc = strlen($prc);
        if($width < $lPrc) {
            $prc = '';
            $lPrc = 0;
        }

        if($lPrc > 0) {
            $tl = ' ' . $this->_timeLeft->formatRemaining($progress);
            $lTl = strlen($tl);
            if($lPrc + $lTl < $width) {
                $prc = $tl . $prc;
                $lPrc = strlen($prc);
            }
        }

        if($lPrc > 0) {
            $fill = max(0, $fill - $lPrc);
        }

        $out = "";
        $out .= $this->_sOpen;
        $out .= str_repeat($this->_sFill, $fill);
        $out .= $prc;
        $out .= str_repeat($this->_sEmpty, $width - $fill - $lPrc);
        $out .= $this->_sClose;

//        if(strlen($out) != $width) {
//            throw new \RuntimeException('out length ('.strlen($out).') and width ('.$width.') do not match');
//        }

        return $out;
    }
}
