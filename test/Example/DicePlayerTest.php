<?php

namespace Hami\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DicePlayerTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testCreatePlayer()
    {
        $player = new DicePlayer("Hatem");
        $res = $player->name;
        $exp = "Hatem";
        $this->assertEquals($exp, $res);
    }

    public function testSetPoints()
    {
        $player = new DicePlayer("Hatem");
        $player->setPoints(99);
        $res = $player->currentPoints;
        $exp = 99;
        $this->assertEquals($exp, $res);
    }

    public function testGetPoints()
    {
        $player = new DicePlayer("Hatem");
        $player->setPoints(88);
        $res = $player->getPoints();
        $exp = 88;
        $this->assertEquals($exp, $res);
    }
}
