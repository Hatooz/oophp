<?php

namespace Hami\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testCreateD12()
    {
        $die = new Dice(12);
        $res = $die->sides;
        $exp = 12;
        $this->assertEquals($exp, $res);
    }

    public function testCreateNoArgs()
    {
        $die = new Dice();
        $res = $die->sides;
        $exp = 6;
        $this->assertEquals($exp, $res);
    }

    public function testGetLastRoll()
    {
        $die = new Dice();
        $res = $die->getLastRoll();
        $exp = $die->lastRoll;
        $this->assertEquals($exp, $res);
    }

    public function testRoll()
    {
        $die = new Dice();
        $under7 = $die->roll() < 7;
        $over0 = $die->roll() > 0;
        $this->assertTrue($under7);
        $this->assertTrue($over0);
    }
}
