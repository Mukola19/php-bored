#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';


try {
    (new \App\Console\ConsoleKernel())->handle(
        new \App\Core\Console\ConsoleInput(),
        new \App\Core\Console\ConsoleOutput()
    );
} catch (Exception $e) {
    print_r($e->getMessage() . PHP_EOL);
}















