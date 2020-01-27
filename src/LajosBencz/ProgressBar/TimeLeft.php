<?php


namespace LajosBencz\ProgressBar;


class TimeLeft
{
    protected $_start;

    public function __construct(?int $start = null)
    {
        $this->setStart($start);
    }

    public function setStart(?int $start = null): void
    {
        $this->_start = $start ?? time();
    }

    public function getElapsed(): int
    {
        return time() - $this->_start;
    }

    public function getRemaining(Progress $p): int
    {
        $Pr = $p->getProgress();
        if($Pr < 1) {
            return 0;
        }
        $Pt = $p->getTotal();
        $Tr = $this->getElapsed();
        return round($Pt * $Tr / $Pr) - $this->getElapsed();
    }

    public function formatRemaining(Progress $p): string
    {
        $t = $this->getRemaining($p);
        return sprintf('%02d:%02d:%02d', ($t / 3600), ($t / 60 % 60), $t % 60);
    }

}