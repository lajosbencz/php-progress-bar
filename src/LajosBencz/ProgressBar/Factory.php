<?php
declare(strict_types=1);

namespace LajosBencz\ProgressBar;

/**
 * @property string $formatterClass
 * @property array $formatterArgs
 * @property resource $output
 */
class Factory
{
    const DEFAULT_FORMATTER_CLASS = Formatter::class;
    const DEFAULT_WIDTH = 60;
    const DEFAULT_OUTPUT = STDOUT;

    /** @var self */
    protected static $_defaultFactory = null;
    protected $_formatterClass = self::DEFAULT_FORMATTER_CLASS;
    protected $_formatterArgs = [self::DEFAULT_WIDTH];
    protected $_output = self::DEFAULT_OUTPUT;

    public function __construct(string $formatterClass = null, ?array $formatterArgs=null, $output = null)
    {
        if ($formatterClass !== null) {
            if (is_a($formatterClass, FormatterInterface::class, true)) {
                $this->_formatterClass = $formatterClass;
            } else {
                throw new Exception('invalid formatter class: must implement ' . FormatterInterface::class);
            }
        }
        if ($formatterClass !== null) {
            $this->_formatterArgs = $formatterArgs;
        }
        if ($output !== null) {
            if (is_resource($output)) {
                $this->_output = $output;
            } else {
                throw new Exception('invalid output: not a resource');
            }
        }
        if (!self::$_defaultFactory) {
            $this->setDefault();
        }
    }

    public static function createDefault(int $total=100): ProgressBar
    {
        if (!self::$_defaultFactory) {
            self::$_defaultFactory = new static;
        }
        return self::$_defaultFactory->create($total);
    }

    public static function clearDefault(): void
    {
        self::$_defaultFactory = null;
    }

    public function setDefault(): void
    {
        self::$_defaultFactory = $this;
    }

    public function __get($name)
    {
        if (property_exists($this, '_' . $name)) {
            return $this->{'_' . $name};
        }
        return null;
    }

    public function __set($name, $value)
    {
        throw new \RuntimeException();
    }

    public function create(int $total=100): ProgressBar
    {
        return (new ProgressBar($total))
            ->setFormatterClass($this->formatterClass, $this->formatterArgs)
            ->setOutput($this->output);
    }

}
