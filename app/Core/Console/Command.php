<?php

namespace App\Core\Console;

use App\Core\Helpers\Arr;
use Exception;

abstract class Command
{
    protected string $name;
    protected string $signature;
    protected array $templateOptions;
    protected array $options = [];

    protected ConsoleOutput $output;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        list($name, $templateOptions) = Parser::parse($this->signature);

        $this->name = $name;
        $this->templateOptions = $templateOptions;
    }

    public abstract function handle();

    public function getName(): string
    {
        return $this->name;
    }

    public function setOptions(array $options)
    {
        foreach ($this->templateOptions as $templateOption) {
            /** @var InputOption $templateOption */

            $this->options[$templateOption->getName()] = Arr::get($options, $templateOption->getName(), $templateOption->getDefault());
        }
    }

    public function setOutput(ConsoleOutputs $output): void
    {
        $this->output = $output;
    }

    public function getOption($name)
    {
        return $this->options[$name] ?? null;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}