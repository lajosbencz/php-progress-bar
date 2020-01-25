<?php
declare(strict_types=1);

namespace LajosBencz\ProgressBar;


interface FormatterInterface
{
    function format(int $total, int $progress, int $width, string $info): string;
    function abort(): string;
}
