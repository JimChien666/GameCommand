<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class PlayCommand extends Command
{
    protected $signature = 'game:play {game}';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }

    public function handle()
    {
        $game = $this->argument("game");
        $this->call('game:rule', ['game' => $game]);
        if (!$this->confirm('玩嗎?')) {
            $this->error('下次再來玩喔！');
            return 0;
        }
        $playerNumber = $this->ask('請選擇玩家人數');
        $winNumber = $this->ask('請選擇獲勝場數');
        if (!is_numeric($playerNumber) || !is_numeric($winNumber)) {
            $this->error('遊戲人數或獲勝場數都要輸入數字');
            return 0;
        }
        $this->call($game, ["playerNumber" => $playerNumber, "winNumber" => $winNumber]);

        return 0;
    }
}
