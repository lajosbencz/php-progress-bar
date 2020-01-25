<?php
declare(strict_types=1);

namespace LajosBencz\ProgressBar;


interface FormatterInterface
{
    function setWidth(int $width): void;
    function format(Progress $progress, string $info): string;
    function abort(): string;
}
