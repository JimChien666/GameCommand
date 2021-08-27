<?php

namespace App\Console\Commands;

use Exception;
use Carbon\Carbon;
use App\Utils\Utils;
use App\Models\MyGame;
use Illuminate\Console\Command;
use App\Models\UlitmatePassword;

class Game extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game {player_number?} {win_number?}';

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
        $player_number = $this->argument("player_number");
        $win_number = $this->argument("win_number");
        if ($player_number == null || $win_number == null) {
            $this->warn('終極密碼多人版');
            $this->info('規則:');
            $this->line(Utils::textWithTime('遊戲規則同終極密碼遊戲規則(猜到數字者獲勝)'));
            $this->line(Utils::textWithTime('可自訂遊戲人數(2~5人)及獲勝場數(1~5場)'));
            $this->line(Utils::textWithTime('當其中一位玩家達到或勝場數 遊戲結束'));

            $this->info('開始遊戲:');
            $this->line(Utils::textWithTime('<info>game 遊戲人數 獲勝場數</info>'));
            return 0;
        } elseif (!is_numeric($player_number) || !is_numeric($win_number)) {
            $this->line('遊戲人數或獲勝場數都要輸入數字');
            return 0;
        }

        $start = new Carbon();
        $game_first_who = rand(0, $player_number - 1);
        $player_array = array();

        for ($i = 1; $i <= $player_number; $i++) {
            $player_array[] = 0;
        }
        while (true) {
            for ($i = 0; $i < $player_number; $i++) {
                $this->info("玩家" . ($i + 1) . ":" . $player_array[$i]);
            }
            $round = new UlitmatePassword($game_first_who, $player_number);
            while (true) {
                $guess = 0;
                while ($guess == 0) {
                    $text = "請玩家" . ($round->getRoundNowWho() + 1) . "選擇數字{" . $round->getMin() . " ~ " . $round->getMax() . ":";
                    $input = $this->ask($text);
                    $guess = $round->playerGuessNumber($input);
                }
                if ($guess == $round->getAnswer()) {
                    $this->info("本局由玩家" . ($round->getRoundNowWho() + 1) . "獲勝");
                    break;
                } else {
                    $round->recountMinAndMax($guess);
                    $round->getNextPlayer();
                }
            }
            $player_array[$game_first_who] += 1;
            for ($i = 0; $i < $player_number; $i++) {
                if ($win_number == $player_array[$i]) {
                    break 2;
                }
            }
            if (($game_first_who) + 1 == count($player_array)) {
                $game_first_who = 0;
            } else {
                $game_first_who++;
            }
        }
        $this->line('遊戲結束 由玩家' . ($game_first_who + 1) . "獲勝");
        $end = new Carbon();
        $this->line("本局共花：" . ($end)->diffInSeconds($start, true) . "秒");

        return 0;
    }
}
