<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UlitmatePassword;
use App\Exceptions\NumberOutOfRangeException;

class UlitmatePasswordCommand extends Command
{
    protected $signature = 'UlitmatePassword {playerNumber} {winNumber}';
    protected $description = '終極密碼';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $playerNumber = $this->argument("playerNumber");
        $winNumber = $this->argument("winNumber");
        $game = new UlitmatePassword($playerNumber, $winNumber);
        while (!$game->isGameOver()) {
            $this->showPlayerPoints($game->getPlayerList());
            while (true) {
                $guess = $this->playerGuessNumber($game);
                if ($guess === $game->getAnswer()) {
                    $this->info("本局由玩家" . ($game->getRoundNowWho() + 1) . "獲勝");
                    break;
                } else {
                    $game->recountMinAndMax($guess);
                    $game->getNextPlayer();
                }
            }
            $game->giveOnePoint($game->getRoundNowWho());
            $game->turnOnNextOnePlayer();
        }
        $this->line('遊戲結束 由玩家' . ($game->getRoundNowWho()) . "獲勝");

        return 0;
    }

    private function showPlayerPoints($playerList)
    {
        $this->line("目前比數");
        foreach ($playerList as $player => $point) {
            $this->line("玩家" . ($player + 1) . ":" . $point);
        }
    }

    private function playerGuessNumber(UlitmatePassword $game)
    {
        $guess = null;
        while ($guess === null) {
            try {
                $text = "請玩家" . ($game->getRoundNowWho() + 1) . "選擇數字{" . $game->getMin() . " ~ " . $game->getMax() . "}";
                $input = $this->ask($text);
                $input = $input === null ? "" : $input;
                $guess = $game->playerGuessNumber($input);
            } catch (NumberOutOfRangeException $e) {
                $this->warn($e->getMessage());
            }
        }
        return $guess;
    }
}
