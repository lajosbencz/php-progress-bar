<?php
declare (strict_types=1);

namespace LajosBencz\ProgressBar;


class Formatter implements FormatterInterface
{
    const ANSI_NEWLINE = "\n";
    const ANSI_RETURN_CARRIAGE = "\r";
    const ANSI_CURSOR_HIDE = "\e[?25l";
    const ANSI_CURSOR_SHOW = "\e[?25h";
    const ANSI_CURSOR_UP_N = "\033[%dA";

    protected $_clearLines = 0;

    public function __construct()
    {
        $this->setWidth(10);
    }

    public function setWidth(int $width): void
    {
        // ignore
    }

    public function formatBar(Progress $progress): string
    {
        return '[ ' . str_pad((string)$progress, 6, ' ', STR_PAD_LEFT) . ' ]';
    }

    public function format(Progress $progress, string $info = ''): string
    {
        $out = "";

        if ($this->_clearLines > 0) {
            $out .= sprintf(self::ANSI_CURSOR_UP_N, $this->_clearLines);
        }

        $out .= self::ANSI_CURSOR_HIDE;
        if (strlen($info) > 0) {
            $out .= rtrim($info) . self::ANSI_NEWLINE;
        }

        $out .= $this->formatBar($progress);

        if ($progress->isDone()) {
            $this->_clearLines = 0;
            $out .= self::ANSI_RETURN_CARRIAGE;
            $out .= self::ANSI_CURSOR_SHOW;
            $out .= self::ANSI_NEWLINE;
        } else {
            $out .= self::ANSI_NEWLINE;
            $nCount = substr_count($out, self::ANSI_NEWLINE);
            if ($this->_clearLines > $nCount) {
                $out .= str_repeat(self::ANSI_NEWLINE, $this->_clearLines - $nCount);
            }
            $this->_clearLines = $nCount;
        }

        return $out;
    }

    function abort(): string
    {
        return self::ANSI_CURSOR_SHOW;
    }

}
