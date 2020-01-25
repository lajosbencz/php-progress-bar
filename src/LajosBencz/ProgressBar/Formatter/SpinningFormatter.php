<?php

namespace LajosBencz\ProgressBar\Formatter;


use LajosBencz\ProgressBar\Formatter;
use LajosBencz\ProgressBar\Progress;

class SpinningFormatter extends Formatter
{
    const DEFAULT_FRAMES = [
        ' -',
        ' \\',
        ' |',
        ' /',
    ];

    protected $_offset = 0;
    protected $_frames = self::DEFAULT_FRAMES;
    protected $_frameCount = 0;

    public function __construct(?array $frames = null)
    {
        parent::__construct();
        if($frames !== null) {
            if(count($frames) < 1) {
                throw new \InvalidArgumentException('symbol list is empty');
            }
            $this->_frames = $frames;
        }
        $this->_frameCount = count($this->_frames);
    }

    public function formatBar(Progress $progress): string
    {
        $out = '';
        if($progress->getProgress() === 0) {
            $this->_offset = 0;
        }
        if($progress->isDone()) {
            $out .= str_repeat(' ', strlen($this->_frames[0]));
        } else {
            $out .= $this->_frames[$this->_offset];
        }
        $this->_offset++;
        if($this->_offset >= $this->_frameCount) {
            $this->_offset = 0;
        }
        $out .= ' ' . $progress;
        return $out;
    }

}
