<?php


namespace App\Console;

use App\Console\Commands\GetAdvicesCommand;
use App\Core\Console\ConsoleKernel as Kernel;

class ConsoleKernel extends Kernel
{

    protected array $commands = [
        GetAdvicesCommand::class
    ];

}