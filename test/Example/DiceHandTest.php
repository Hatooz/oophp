<?php

namespace Hami\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceHandTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testCreateHandNoArgs()
    {
        $hand = new DiceHand();
        $res = $hand->nOfDice;
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    public function testCreateHand()
    {
        $hand = new DiceHand(12);
        $res = $hand->nOfDice;
        $exp = 12;
        $this->assertEquals($exp, $res);
    }

    public function testRolls()
    {
        $hand = new DiceHand(6);
        $hand->rolls();
        $res = count($hand->dices) == count($hand->values);
        $this->assertTrue($res);
    }

    public function testValues()
    {
        $hand = new DiceHand();
        $res = $hand->values() == $hand->values;
        $this->assertTrue($res);
    }

    public function testAverageTyp()
    {
        $hand = new DiceHand();
        $hand->rolls();
        $res = gettype($hand->average());
        $exp = "double";
        $this->assertEquals($res, $exp);
    }
    public function testSumTypee()
    {
        $hand = new DiceHand();
        $hand->rolls();
        $res = gettype($hand->sum());
        $exp = "integer";
        $this->assertEquals($res, $exp);
    }
}
