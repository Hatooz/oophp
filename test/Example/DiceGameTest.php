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
    public function testIntelligenceHigh()
    {
        $game = new DiceGame("Hatem", "Computer");
        $game->player1->currentPoints = 90;
        $game->player2->currentPoints = 10;
        $computerIntellect = $game->computerIntelligence();
        $exp = "high";
        $this->assertEquals($exp, $computerIntellect);
    }
    public function testIntelligenceMedium()
    {
        $game = new DiceGame("Hatem", "Computer");
        $game->player1->currentPoints = 40;
        $game->player2->currentPoints = 9;
        $computerIntellect = $game->computerIntelligence();
        $exp = "medium";
        $this->assertEquals($exp, $computerIntellect);
    }
    public function testIntelligenceLow()
    {
        $game = new DiceGame("Hatem", "Computer");
        $game->player1->currentPoints = 10;
        $game->player2->currentPoints = 9;
        $computerIntellect = $game->computerIntelligence();
        $exp = false;
        $this->assertEquals($exp, $computerIntellect);
    }
}
