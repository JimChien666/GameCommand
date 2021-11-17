<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UlitmatePassword;
use App\Exceptions\NumberOutOfRangeException;

class UltimatePasswordCommand extends Command
{

    private $game;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:ultimate-password {player_number?} {win_number?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'let\'s play a game';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $playerNumber = $this->argument("player_number");
        $winNumber = $this->argument("win_number");
        if ($playerNumber == null || $winNumber == null) {
            return $this->showRole();
        } elseif (!is_numeric($playerNumber) || !is_numeric($winNumber)) {
            $this->line('遊戲人數或獲勝場數都要輸入數字');
            return 0;
        }
        $this->game = new UlitmatePassword($playerNumber, $winNumber);
        while(!$this->game->isGameOver()){
            $this->showPlayerPoints($this->game->getPlayerList());
            while (true) {
                $guess = $this->playerGuessNumber();
                if ($guess === $this->game->getAnswer()) {
                    $this->info("本局由玩家" . ($this->game->getRoundNowWho() + 1) . "獲勝");
                    break;
                } else {
                    $this->game->recountMinAndMax($guess);
                    $this->game->getNextPlayer();
                }
            }
            $this->game->giveOnePoint($this->game->getRoundNowWho());
            $this->game->turnOnNextOnePlayer();
        }
        $this->line('遊戲結束 由玩家' . ($this->game->getRoundNowWho()) . "獲勝");

        return 0;
    }

    private function showRole()
    {
        $this->warn('終極密碼多人版');
        $this->info('規則:');
        $this->line('遊戲規則同終極密碼遊戲規則(猜到數字者獲勝)');
        $this->line('可自訂遊戲人數(2~5人)及獲勝場數(1~5場)');
        $this->line('當其中一位玩家達到或勝場數 遊戲結束');
        $this->info('開始遊戲:');
        $this->line('<info>game 遊戲人數 獲勝場數</info>');
        return 0;
    }

    private function showPlayerPoints($playerList)
    {
        $this->line("目前比數");
        foreach($playerList as $player => $point){
            $this->line("玩家". ($player + 1) . ":" . $point);
        }
    }

    private function playerGuessNumber()
    {
        $guess = null;
        while ($guess === null){
            try {
                $text = "請玩家" . ($this->game->getRoundNowWho() + 1) . "選擇數字{" . $this->game->getMin() . " ~ " . $this->game->getMax() . "}";
                $input = $this->ask($text);
                $input = $input === null ? "" : $input;
                $guess = $this->game->playerGuessNumber($input);
            } catch (NumberOutOfRangeException $e){
                $this->warn($e->getMessage());
            }
        }
        return $guess;
    }
}
