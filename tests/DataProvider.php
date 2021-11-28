<?php

namespace Tests;

trait DataProvider
{
    public function gameInListProvider()
    {
        yield [[
            'UltimatePassword' =>
            [
                '遊戲規則同終極密碼遊戲規則(猜到數字者獲勝)',
                '可自訂遊戲人數(2~5人)及獲勝場數(1~5場)',
                '當其中一位玩家達到或勝場數 遊戲結束',
            ]
        ]];
    }

    public function gameNotInListProvider()
    {
        yield ['Whatever'];
    }

    public function gameInListWrongInputProvider()
    {
        yield [[
            'UltimatePassword' => [
                'palyNumber' => '3',
                'winNumber' => 'notANumber'
            ]
        ]];
        yield [[
            'UltimatePassword' => [
                'palyNumber' => 'notANumber',
                'winNumber' => '3'
            ]
        ]];
        yield [[
            'UltimatePassword' => [
                'palyNumber' => 'notANumber',
                'winNumber' => 'notANumber'
            ]
        ]];
    }
}
