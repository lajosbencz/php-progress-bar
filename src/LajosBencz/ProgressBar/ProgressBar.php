<?php


namespace LajosBencz\ProgressBar;


class ProgressBar
{
    protected $_info;
    protected $_width;
    protected $_output = STDOUT;
    protected $_total = 100;
    protected $_progress = 0;

    protected function _setProgress(int $progress)
    {
        $progress = max(0, $progress);
        $progress = min($this->_total, $progress);
        $this->_progress = $progress;
    }

    public function __construct(string $info = '', int $width=54)
    {
        $this->setInfo($info);
        $this->_width = $width;
    }

    public function setOutput($resource): self
    {
        if(!is_resource($resource)) {
            throw new \InvalidArgumentException('invalid resource');
        }
        $this->_output = $resource;
        return $this;
    }

    public function setInfo(string $info): self
    {
        $this->_info = $info;
        return $this;
    }

    public function setTotal(int $total): self
    {
        $this->_total = $total;
        return $this;
    }

    public function reset(): self
    {
        $this->_progress = 0;
        return $this;
    }

    public function increment(int $count=1, ?string $info=null): self
    {
        if($info !== null) {
            $this->setInfo($info);
        }
        $this->_setProgress($this->_progress = $count);
        return $this;
    }

    public function update(int $progress, ?string $info=null): self
    {
        if($info !== null) {
            $this->setInfo($info);
        }
        $this->_setProgress($progress);
        return $this;
    }
}
