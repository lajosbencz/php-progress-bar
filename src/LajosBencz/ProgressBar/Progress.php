<?php
declare(strict_types=1);

namespace LajosBencz\ProgressBar;


class Progress
{
    protected $_progress;
    protected $_total;

    public function __construct(int $total = 100)
    {
        $this->_total = $total;
        $this->reset();
    }

    public function isDone(): bool
    {
        return $this->_progress >= $this->_total;
    }

    public function update(int $progress): bool
    {
        $progress = max(0, $progress);
        $progress = min($this->_total, $progress);
        $this->_progress = $progress;
        return $this->isDone();
    }

    public function increment(int $count = 1): bool
    {
        $this->update($this->_progress + $count);
        return $this->isDone();
    }

    public function reset(): void
    {
        $this->_progress = 0;
    }

    public function getTotal(): int
    {
        return $this->_total;
    }

    public function getProgress(): int
    {
        return min($this->_total, $this->_progress);
    }

    public function getRatio(float $q=1): float
    {
        return ($this->_progress / $this->_total) * $q;
    }

    public function __toString()
    {
        return str_pad(sprintf("%0.1f%%", $this->getRatio(100)), 6, ' ', STR_PAD_LEFT);
    }

}
