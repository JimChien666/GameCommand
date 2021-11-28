<?php

namespace Tests\Feature\Commands;

use Tests\DataProvider;
use Tests\TestCase;

class RuleCommandTest extends TestCase
{
    use DataProvider;

    /**
     * @dataProvider gameInListProvider
     */
    public function testGameRuleCommandWhenGameNameInGameList(array $games)
    {
        foreach ($games as $gameName => $gameRules) {
            $this->artisan("game:rule $gameName")->assertExitCode(0);
            foreach ($gameRules as $rule) {
                $this->artisan("game:rule $gameName")
                    ->expectsOutput($rule);
            }
        }
    }
    /**
     * @dataProvider gameNotInListProvider
     */
    public function testGameRuleCommandWhenGameNameNotInGameList(string $gameName)
    {
        $this->artisan("game:rule $gameName")->assertExitCode(1)->expectsOutput("無此遊戲");
    }
}
