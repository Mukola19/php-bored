<?php

namespace App\Core\Console;

use App\Core\Helpers\Str;
use Exception;

class Parser
{
    /**
     * Parse the given console command definition into an array.
     *
     * @throws Exception
     */
    public static function parse(string $expression): array
    {
        $name = static::name($expression);

        if (preg_match_all('/\{\s*(.*?)\s*\}/', $expression, $matches)) {
            if (count($matches[1])) {
                return array_merge([$name], static::parameters($matches[1]));
            }
        }

        return [$name, []];
    }

    /**
     * Extract the name of the command from the expression.
     *
     * @throws Exception
     */

    protected static function name(string $expression): string
    {
        if (!preg_match('/[^\s]+/', $expression, $matches)) {
            throw new Exception('Unable to determine command name from signature.');
        }

        return $matches[0];
    }

    /**
     * Extract all the parameters from the tokens.
     *
     */
    protected static function parameters(array $tokens): array
    {
        $options = [];

        foreach ($tokens as $token) {
            if (preg_match('/-{2,}(.*)/', $token, $matches)) {
                $options[] = static::parseOption($matches[1]);
            }
        }

        return [$options];
    }


    /**
     * Parse an option expression.
     */
    protected static function parseOption(string $token): InputOption
    {
        [$token, $description] = static::extractDescription($token);

        $matches = preg_split('/\s*\|\s*/', $token, 2);

        if (isset($matches[1])) {
            $token = $matches[1];
        }

        switch (true) {
            case Str::endsWith($token, '='):
                return new InputOption(trim($token, '='), $description);
            case Str::endsWith($token, '=*'):
                return new InputOption(trim($token, '=*'), $description);
            case preg_match('/(.+)\=\*(.+)/', $token, $matches):
                return new InputOption($matches[1], preg_split('/,\s?/', $matches[2]));
            case preg_match('/(.+)\=(.+)/', $token, $matches):
                return new InputOption($matches[1], $matches[2]);
            default:
                return new InputOption($token);
        }
    }

    protected static function extractDescription(string $token): array
    {
        $parts = preg_split('/\s+:\s+/', trim($token), 2);

        return count($parts) === 2 ? $parts : [$token, ''];
    }
}