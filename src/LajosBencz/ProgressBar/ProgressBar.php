<?php
declare (strict_types=1);


namespace LajosBencz\ProgressBar;


use InvalidArgumentException;

class ProgressBar
{
    /** @var string */
    protected $_info = '';
    /** @var resource */
    protected $_output = STDOUT;
    /** @var string */
    protected $_formatterClass = Formatter::class;
    /** @var array */
    protected $_formatterArgs = [];
    /** @var FormatterInterface */
    protected $_formatter;
    /** @var Progress */
    protected $_progress;

    public function __construct(int $total=100)
    {
        $this->_progress = new Progress($total);
        $this->reset();
    }

    public function __destruct()
    {
        $this->abort();
        // do NOT close the output...
    }

    public function isDone(): bool
    {
        return $this->_progress->isDone();
    }

    public function reset(): void
    {
        $this->_info = '';
        $this->_formatter = null;
        $this->_progress->reset();
    }

    public function __invoke(int $progress, string $info = ''): void
    {
        $this->update($progress, $info);
        $this->show();
    }

    public function setFormatterClass(string $formatter, ?array $args=null): self
    {
        if (!is_a($formatter, FormatterInterface::class, true)) {
            throw new \RuntimeException('must be instance of ' . FormatterInterface::class);
        }
        if($args !== null) {
            $this->_formatterArgs = $args;
        }
        $this->_formatterClass = $formatter;
        return $this;
    }

    public function getFormatter(): FormatterInterface
    {
        if (!$this->_formatter) {
            $this->_formatter = new $this->_formatterClass(...$this->_formatterArgs);
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

    public function update(int $progress, ?string $info = null): self
    {
        if ($info !== null) {
            $this->setInfo($info);
        }
        $this->_progress->update($progress);
        return $this;
    }

    public function increment(int $count = 1, ?string $info = null): self
    {
        if ($info !== null) {
            $this->setInfo($info);
        }
        $this->_progress->increment($count);
        return $this;
    }

    public function abort(): self
    {
        $this->_write($this->getFormatter()->abort());
        return $this;
    }

    public function format(): string
    {
        return $this->getFormatter()->format($this->_progress, $this->_info);
    }

    public function show(): void
    {
        $r = $this->format();
        $this->_write($r);
    }

    protected function _write(string $text): void
    {
        $l = strlen($text);
        if (!is_resource($this->_output) || fwrite($this->_output, $text) !== $l) {
            throw new Exception('failed writing to output stream');
        }
    }

}
