<?php

namespace App\Models;

use Exception;
use App\Exceptions\NumberOutOfRangeException;

class UlitmatePassword
{
    private $answer; //終極密碼
    private $min = 1;
    private $max = 100;
    private $round_now_who; //輪到誰
    private $player_number; //遊戲人數

    public function __construct($round_now_who, $player_number)
    {
        $this->round_now_who = $round_now_who;
        $this->player_number = $player_number;
        $this->answer = rand($this->min, $this->max);
    }

    public function getRoundNowWho()
    {
        return $this->round_now_who;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function setAnswer(int $input)
    {
        if($input<$this->min || $input>$this->max){
            throw new NumberOutOfRangeException("輸入錯誤，請輸入{$this->min}-{$this->max}之間的數字:");
        }
        $this->answer = $input;
    }

    public function setRoundNowWho(int $input)
    {
        if($input<0 || $input>$this->player_number-1){
            throw new NumberOutOfRangeException("輸入錯誤，請輸入{$this->min}-{$this->max}之間的數字:");
        }
        $this->round_now_who = $input;
    }


    /*
     * 換下一位玩家
     */
    public function getNextPlayer()
    {
        if ($this->round_now_who + 1 == $this->player_number) {
            $this->round_now_who = 0;
        } else {
            $this->round_now_who++;
        }
    }

    public function playerGuessNumber(string $input)
    {
        try {
            if (
                is_numeric($input)
                && (int)$input >= $this->min
                && (int)$input <= $this->max
            ) {
                return (int)$input;
            } else {
                throw new NumberOutOfRangeException("輸入錯誤，請輸入{$this->min}-{$this->max}之間的數字:");
            }
        } catch (Exception $e) {
            return 0;
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
}
