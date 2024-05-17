<?php


namespace App\Core\Console;


use Exception;

class ConsoleKernel
{
    protected array $commands = [];
    private array $loadedCommands = [];

    public function __construct()
    {
        $this->load();
    }

    private function load()
    {
        foreach ($this->commands as $command) {
            $instance = new $command();

            /** @var Command $instance */
            $this->loadedCommands[$instance->getName()] = $instance;
        }
    }

    public function handle(ConsoleInputs $input, ConsoleOutputs $output): void
    {
        try {
            $command = $this->findCommand($input->getFirstArgument());

            if (is_null($command)) {
                throw new Exception('Command not found!');
            }

            $command->setOptions($input->getOptions());
            $command->setOutput($output);

            $command->handle();

        } catch (\Exception $exception) {
            $output->printError(print_r($exception->getMessage(), true));
        } catch (\Throwable $exception) {
            $output->printError(print_r($exception, true));
        }
    }

    protected function findCommand(string $command): ?Command
    {
        return $this->loadedCommands[$command] ?? null;
    }
}