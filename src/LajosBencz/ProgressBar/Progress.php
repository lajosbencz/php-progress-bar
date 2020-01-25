<?php
declare(strict_types=1);

namespace LajosBencz\ProgressBar;


class Progress
{
    protected $_progress;
    protected $_total;

    public function __construct(int $total = 100)
    {
        $this->_progress = 0;
        $this->_total = $total;
    }

    public function set(int $progress): void
    {
        $progress = max(0, $progress);
        $progress = min($this->_total, $progress);
        $this->_progress = $progress;
    }

    public function increment(int $incrementBy = 1): void
    {
        $this->set($this->_progress + $incrementBy);
    }

    public function __invoke(int $incrementBy = 1): void
    {
        $this->increment($incrementBy);
    }
}
