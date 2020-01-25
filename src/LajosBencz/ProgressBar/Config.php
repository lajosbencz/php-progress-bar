<?php
declare(strict_types=1);

namespace LajosBencz\ProgressBar;

/**
 * @property-read string $formatterClass
 * @property-read int $width
 * @property-read resource $output
 */
class Config
{
    const DEFAULT_FORMATTER_CLASS = Formatter::class;
    const DEFAULT_WIDTH = 60;
    const DEFAULT_OUTPUT = STDOUT;

    protected $_formatterClass = self::DEFAULT_FORMATTER_CLASS;
    protected $_width = self::DEFAULT_WIDTH;
    protected $_output = self::DEFAULT_OUTPUT;

    public function __construct(string $formatterClass=null, ?int $width=null, $output=null)
    {
        if($formatterClass !== null) {
            if(is_a($formatterClass, FormatterInterface::class, true)) {
                $this->_formatterClass = $formatterClass;
            } else {
                throw new Exception('invalid formatter class: must implement ' . FormatterInterface::class);
            }
        }
        if($output !== null) {
            if (is_resource($output)) {
                $this->_output = $output;
            } else {
                throw new Exception('invalid output: not a resource');
            }
        }
        if($width > 0) {
            $this->_width = $width;
        }
    }

    public function __get($name)
    {
        if(property_exists($this, '_'. $name)) {
            return $this->{'_'.$name};
        }
        return null;
    }

    public function __set($name, $value)
    {
        throw new \RuntimeException();
    }

}
