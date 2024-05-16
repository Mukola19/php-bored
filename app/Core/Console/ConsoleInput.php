<?php


namespace App\Core\Console;

class ConsoleInput implements ConsoleInputs
{
    protected array $tokens;
    protected array $parsed;

    protected array $options = [];

    public function __construct(array $argv = null)
    {
        $argv = null !== $argv ? $argv : ($_SERVER['argv'] ?? []);

        array_shift($argv);

        $this->tokens = $argv;

        $this->parse();
    }

    protected function parse()
    {
        $parseOptions = true;
        $this->parsed = $this->tokens;
        while (null !== $token = array_shift($this->parsed)) {
            if ($parseOptions && '--' == $token) {
                $parseOptions = false;
            } elseif ($parseOptions && 0 === strpos($token, '--')) {
                $this->parseLongOption($token);
            }
        }
    }

    private function parseLongOption(string $token)
    {
        $name = substr($token, 2);

        if (false !== $pos = strpos($name, '=')) {
            if (0 === \strlen($value = substr($name, $pos + 1))) {

                if (\PHP_VERSION_ID < 70000 && false === $value) {
                    $value = '';
                }
                array_unshift($this->parsed, $value);
            }
            $this->addLongOption(substr($name, 0, $pos), $value);
        } else {
            $this->addLongOption($name, null);
        }
    }

    private function addLongOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getFirstArgument()
    {
        $isOption = false;
        foreach ($this->tokens as $i => $token) {

            if ($token && '-' === $token[0]) {
                if (false !== strpos($token, '=') || !isset($this->tokens[$i + 1])) {
                    continue;
                }

                $name = '-' === $token[1] ? substr($token, 2) : substr($token, -1);

                if (!isset($this->options[$name])) {
                    // noop
                } elseif (isset($this->options[$name]) && $this->tokens[$i + 1] === $this->options[$name]) {
                    $isOption = true;
                }
                continue;
            }

            if ($isOption) {
                $isOption = false;
                continue;
            }

            return $token;
        }

        return null;
    }
}
