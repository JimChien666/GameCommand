<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;

class ListCommandTest extends TestCase
{
    public function testGameListCommand()
    {
        $this->artisan("game:list")
            ->expectsOutput('遊戲列表')
            ->expectsOutput('UltimatePassword')
            ->assertExitCode(0);
    }
}
