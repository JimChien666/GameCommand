<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListCommand extends Command
{
    protected $signature = 'game:list';
    protected $description = '遊戲列表';
    private $gameList = [
        'UltimatePassword'
    ];

    public function handle()
    {
        $this->warn($this->description);
        foreach ($this->gameList as $game) {
            $this->line($game);
        }
        return 0;
    }
}
