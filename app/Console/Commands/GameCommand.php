<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GameCommand extends Command
{
    public const LOGO = <<<LOGO
    ______                   
   / ____/___ _____ ___  ___ 
  / / __/ __ `/ __ `__ \/ _ \
 / /_/ / /_/ / / / / / /  __/
 \____/\__,_/_/ /_/ /_/\___/ 
LOGO;

    public const RULES = [
        "查看遊戲清單" => "game:list",
        "查看遊戲玩法" => "game:rule '<遊戲名稱>'",
        "開始遊戲" => "game:play '<遊戲名稱>'"
    ];

    protected $signature = 'game';
    protected $description = '遊戲指令介紹';

    public function handle()
    {
        $this->info(GameCommand::LOGO);
        $this->warn($this->description);
        foreach (GameCommand::RULES as $key => $rule) {
            $this->info($key . ':');
            $this->line($rule);
        }
        return 0;
    }
}
