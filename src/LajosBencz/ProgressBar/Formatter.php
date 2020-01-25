<?php
declare (strict_types=1);

namespace LajosBencz\ProgressBar;


class Formatter implements FormatterInterface
{
    const DEFAULT_SYMBOLS = "[= ]";

    const ANSI_NEWLINE = "\n";
    const ANSI_RETURN_CARRIAGE = "\r";
    const ANSI_CURSOR_HIDE = "\e[?25l";
    const ANSI_CURSOR_SHOW = "\e[?25h";
    const ANSI_CURSOR_UP_N = "\033[%dA";

    protected $_symbols = self::DEFAULT_SYMBOLS;
    protected $_clearLines = 0;

    public function setSymbols(string $symbols): void
    {
        $l = strlen(self::DEFAULT_SYMBOLS);
        if (strlen($symbols) < $l) {
            throw new \InvalidArgumentException('symbols string must be at least ' . $l . ' chars');
        }
        $this->_symbols = $symbols;
    }

    public function formatBar(int $width, int $fill=0, float $fraction=0.0): string
    {
        $width = max(2, $width);
        $out = "";

        $out .= $this->_symbols[0];
        for ($i = 1; $i < $width-1; $i++) {
            if ($i < $fill) {
                $out .= $this->_symbols[1];
            } else {
                $out .= $this->_symbols[2];
            }
        }
        $out .= $this->_symbols[3];

        return $out;
    }

    public function format(int $total, int $progress, int $width, string $info): string
    {
        $progress = min($total, $progress);
        $width = max(4, $width);

        $out = "";

        if ($this->_clearLines > 0) {
            $out .= sprintf(self::ANSI_CURSOR_UP_N, $this->_clearLines);
        }

        $out .= self::ANSI_CURSOR_HIDE;
        if(strlen($info) > 0) {
            $out .= rtrim($info) . self::ANSI_NEWLINE;
        }

        $w = $width - 2;
        $out .= $this->formatBar($w, (int)floor(($w / $total) * $progress));

        if ($total === $progress) {
            $this->_clearLines = 0;
            $out .= self::ANSI_RETURN_CARRIAGE;
            $out .= self::ANSI_CURSOR_SHOW;
            $out .= self::ANSI_NEWLINE;
        } else {
            $out .= self::ANSI_NEWLINE;
            $nCount = substr_count($out, self::ANSI_NEWLINE);
            if ($this->_clearLines > $nCount) {
                $out .= str_repeat(self::ANSI_NEWLINE, $nCount - $this->_clearLines);
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
