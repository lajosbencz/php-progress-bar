<?php
declare (strict_types=1);


namespace LajosBencz\ProgressBar;


use InvalidArgumentException;

class ProgressBar
{
    protected $_progress = 0;
    protected $_total = 100;
    protected $_info = '';
    protected $_width = 60;
    protected $_output = STDOUT;
    protected $_formatterClass;
    /** @var FormatterInterface */
    protected $_formatter;

    public function __construct(string $formatterClass = Formatter::class)
    {
        $this->setFormatterClass($formatterClass);
    }

    public function __destruct()
    {
        if($this->_progress < $this->_total) {
            $this->abort();
        }
        // do NOT close the output...
    }

    public function __invoke(int $progress, string $info=''): void
    {
        $this->update($progress, $info);
        $this->show();
    }

    public function setFormatterClass(string $formatter): self
    {
        if(!is_a($formatter, FormatterInterface::class, true)) {
            throw new \RuntimeException('must be instance of ' . FormatterInterface::class);
        }
        $this->_formatterClass = $formatter;
        return $this;
    }

    public function getFormatter(): FormatterInterface
    {
        if(!$this->_formatter) {
            $this->_formatter = new $this->_formatterClass();
        }
        return $this->_formatter;
    }

    public function setOutput($resource): self
    {
        if (!is_resource($resource)) {
            throw new InvalidArgumentException('invalid output');
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

    public function setWidth(int $width): self
    {
        $this->_width = $width;
        return $this;
    }

    public function reset(): self
    {
        $this->_info = '';
        $this->_progress = 0;
        $this->_formatter = null;
        return $this;
    }

    public function update(int $progress, ?string $info = null): self
    {
        if ($info !== null) {
            $this->setInfo($info);
        }
        $this->_setProgress($progress);
        return $this;
    }

    public function increment(int $count = 1, ?string $info = null): self
    {
        if ($info !== null) {
            $this->setInfo($info);
        }
        $this->_setProgress($count);
        return $this;
    }

    public function abort(): self
    {
        $this->_write($this->getFormatter()->abort());
        return $this;
    }

    public function spin(?int $progress=null, ?string $info = null): self
    {
        if($progress !== null) {
            $this->_setProgress($progress);
        }
        if($info !== null) {
            $this->setInfo($info);
        }
        $this->show();
        return $this;
    }

    public function format(): string
    {
        return $this->getFormatter()->format($this->_total, $this->_progress, $this->_width, $this->_info);
    }

    public function show(): void
    {
        $r = $this->format();
        $this->_write($r);
    }

    protected function _write(string $text): void
    {
        $l = strlen($text);
        if (fwrite($this->_output, $text) !== $l) {
            throw new Exception('failed writing to output stream');
        }
    }

    protected function _setProgress(int $progress): void
    {
        $progress = max(0, $progress);
        $progress = min($this->_total, $progress);
        $this->_progress = $progress;
    }
}
