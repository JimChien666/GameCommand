<?php

namespace App\Models;

use App\Exceptions\NumberOutOfRangeException;

class UltimatePassword extends Game
{
    const RULES = [
        '遊戲規則同終極密碼遊戲規則(猜到數字者獲勝)',
        '可自訂遊戲人數(2~5人)及獲勝場數(1~5場)',
        '當其中一位玩家達到或勝場數 遊戲結束',
    ];

    private $answer; //終極密碼
    private $min = 1;
    private $max = 100;
    private $roundNowWho; //這回合輪到誰


    public function __construct($playerNumber, $winNumber)
    {
        parent::__construct($playerNumber, $winNumber, self::RULES);
        $this->playerNumber = $playerNumber;
        $this->roundNowWho = $this->getGameNowWho();
        $this->answer = rand($this->min, $this->max);
    }

    public function getRoundNowWho()
    {
        return $this->roundNowWho;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function setAnswer(int $input)
    {
        if ($input < $this->min || $input > $this->max) {
            throw new NumberOutOfRangeException("輸入錯誤，請輸入{$this->min}-{$this->max}之間的數字:");
        }
        $this->answer = $input;
    }

    public function setRoundNowWho(int $input)
    {
        if ($input < 0 || $input > $this->playerNumber - 1) {
            throw new NumberOutOfRangeException("輸入錯誤，請輸入{$this->min}-{$this->max}之間的數字:");
        }
        $this->roundNowWho = $input;
    }


    /*
     * 換下一位玩家
     */
    public function getNextPlayer()
    {
        if ($this->roundNowWho + 1 == count($this->getPlayerList())) {
            $this->roundNowWho = 0;
        } else {
            $this->roundNowWho++;
        }
    }

    public function playerGuessNumber(string $input)
    {
        if (
            is_numeric($input)
            && (int)$input >= $this->min
            && (int)$input <= $this->max
        ) {
            return (int)$input;
        } else {
            throw new NumberOutOfRangeException("輸入錯誤，請輸入{$this->min}-{$this->max}之間的數字:");
        }
    }

    public function recountMinAndMax($guess)
    {
        if ($guess > $this->answer) {
            $this->max = $guess;
        } else {
            $this->min = $guess;
        }
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    public function turnOnNextOnePlayer()
    {
        parent::turnOnNextOnePlayer();
        $this->min = 1;
        $this->max = 100;
        $this->answer = rand($this->min, $this->max);
        $this->roundNowWho = $this->getGameNowWho();
    }
}
