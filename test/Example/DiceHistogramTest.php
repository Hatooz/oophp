<?php

namespace Hami\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceHistogramTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testInjectData()
    {
        $dice = new DiceHistogram2();
        $histogram = new Histogram();
        for ($i = 0; $i < 2; $i++) {
            $dice->roll();
        }
        $histogram->injectData($dice);

        $res = $histogram->getAsText();
        $this->assertTrue($res != null);
    }

    public function testArray()
    {
        $dice = new DiceHistogram2();
        $histogram = new Histogram();
        for ($i = 0; $i < 2; $i++) {
            $dice->roll();
        }
        $histogram->injectData($dice);

        $res = $histogram->getSerie();
        $this->assertEquals(gettype($res), "array");
    }

    public function testGetMax()
    {
        $dice = new DiceHistogram2();
        $histogram = new Histogram();
        for ($i = 0; $i < 99; $i++) {
            $dice->roll();
        }
        $histogram->injectData($dice);

        $res = $dice->getHistogramMax();
        $exp =  6;
        $this->assertEquals($res, $exp);
    }
}
