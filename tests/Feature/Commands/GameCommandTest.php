<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use App\Console\Commands\GameCommand;

class GameCommandTest extends TestCase
{
    public function testCommandGame()
    {
        $this->artisan('game')->assertExitCode(0)
            ->expectsOutput(GameCommand::LOGO)
            ->expectsOutput('遊戲指令介紹');
        foreach (GameCommand::RULES as $key => $rule) {
            $this->artisan('game')->expectsOutput($key . ':')
                ->expectsOutput($rule);
        }
    }
}
