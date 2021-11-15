<?php

namespace App\Models;

class Game
{
    /**
     * @var array
     */
    private $playerList;
    private $winNumber;
    private $gameNowWho;

    public function __construct($playerNumber, $winNumber)
    {
        $this->playerList = $this->setPlayerList($playerNumber);
        $this->winNumber = $winNumber;
        $this->gameNowWho = rand(0, $playerNumber - 1);
    }

    public function setPlayerList($playerNumber)
    {
        $playerList = [];
        for($i = 0;$i < $playerNumber; $i++){
            $playerList[$i] = 0;
        }
        return $playerList;
    }

    public function getPlayerList()
    {
        return $this->playerList;
    }

    public function isGameOver(): bool
    {
        foreach($this->playerList as $player=>$point){
            if($point == $this->winNumber){
                return true;
            }
        }
        return false;
    }

    public function getWinner(): string
    {
        foreach($this->playerList as $player=>$point){
            if($point === $this->winNumber){
                return $player;
            }
        }
    }

    public function setGameNowWho($gameNowWho)
    {
        $this->gameNowWho = $gameNowWho;
    }

    public function turnOnNextOnePlayer()
    {
        if ($this->gameNowWho + 1 === count($this->playerList)) {
            $this->setGameNowWho(0);
        } else {
            $this->setGameNowWho($this->gameNowWho + 1);
        }
    }

    public function giveOnePoint($player)
    {
        $this->playerList[$player] = $this->playerList[$player] + 1;
    }

    public function getGameNowWho()
    {
        return $this->gameNowWho;
    }
}