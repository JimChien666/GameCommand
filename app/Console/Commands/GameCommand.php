<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GameCommand extends Command
{
    private static $logo = <<<LOGO
     ______                   
    / ____/___ _____ ___  ___ 
   / / __/ __ `/ __ `__ \/ _ \
  / /_/ / /_/ / / / / / /  __/
  \____/\__,_/_/ /_/ /_/\___/ 

LOGO;



    protected $signature = 'game';

    protected $description = 'guideline of game command';

    public function handle()
    {
        $this->line(static::$logo);
        $this->warn("Game version");
        return 0;
    }
}