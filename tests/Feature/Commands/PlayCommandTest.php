<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Tests\DataProvider;

class PlayCommandTest extends TestCase
{
    use DataProvider;
    /**
     * @dataProvider gameInListProvider
     */
    public function testGamePlayCommandWhenGameNameInGameListAndNoPlay(array $games)
    {
        foreach ($games as $gameName => $gameRules) {
            $this->artisan("game:play $gameName")
                ->expectsConfirmation('玩嗎?', 'no')
                ->expectsOutput('下次再來玩喔！')
                ->assertExitCode(0);
        }
    }

    /**
     * @dataProvider gameInListWrongInputProvider
     */
    public function testGamePlayCommandWhenGameNameInGameListAndYesPlayButWrongInput(array $games)
    {
        foreach ($games as $gameName => $inputs) {
            $this->artisan("game:play $gameName")
                ->expectsConfirmation('玩嗎?', 'yes')
                ->expectsQuestion('請選擇玩家人數', $inputs['palyNumber'])
                ->expectsQuestion('請選擇獲勝場數', $inputs['winNumber'])
                ->expectsOutput('遊戲人數或獲勝場數都要輸入數字')
                ->assertExitCode(1);
        }
    }

    // /**
    //  * @dataProvider gameInListProvider
    //  */
    // public function testGamePlayCommandWhenGameNameInGameListAndYesPlayAndRightInput(array $games)
    // {

    //     foreach ($games as $gameName => $gameRules) {
    //         $this->artisan("game:play $gameName")
    //             ->expectsConfirmation('玩嗎?', 'yes')
    //             ->expectsQuestion('請選擇玩家人數', '2')
    //             ->expectsQuestion('請選擇獲勝場數', '2')
    //             ->assertExitCode(0);
    //     }
    // }
}
