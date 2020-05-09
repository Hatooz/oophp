<?php

namespace Hami\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceGameTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testCreateGame()
    {
        $game = new DiceGame("Hatem", "Computer");
        $res = $game->player1->name;
        $exp = "Hatem";
        $this->assertEquals($exp, $res);
    }

    public function testSwitch()
    {
        $game = new DiceGame("Hatem", "Computer");
        $game->switchTurn();
        $res = $game->getActivePlayer();
        $exp = $game->player2;
        $this->assertEquals($exp, $res);
    }
    public function testStopTurn()
    {
        $game = new DiceGame("Hatem", "Computer");
        $activeBeforeStop = $game->getActivePlayer();
        $exp  = $game->player1;
        $this->assertEquals($exp, $activeBeforeStop);
        $game->stopTurn();
        $activeAfterStop = $game->getActivePlayer();
        $exp = $game->player2;
        $this->assertEquals($exp, $activeAfterStop);
    }
    public function testThrow()
    {
        $game = new DiceGame("Hatem", "Computer");
        $activeBeforeStop = $game->getActivePlayer();
        $exp  = $game->player1;
        $this->assertEquals($exp, $activeBeforeStop);
        $game->throwDice();
        $res = $game->getActivePlayer() != $activeBeforeStop || $game->player1->unsavedPoints != 0;
        $this->assertTrue($res);
    }
}
