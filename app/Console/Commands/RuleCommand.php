<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class RuleCommand extends Command
{
    protected $signature = 'game:rule {game}';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }

    public function handle()
    {
        $game = $this->argument("game");
        $gmaeClass = 'App\\Models\\' . $game;
        $rules = $gmaeClass::RULES;
        foreach ($rules as $rule) {
            $this->line($rule);
        }
        return 0;
    }
}
