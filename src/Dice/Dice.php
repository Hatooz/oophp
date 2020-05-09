<?php

namespace Hami\Dice;

class Dice
{
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
        $this->lastRoll = -1;
    }


    public function roll()
    {
        $roll = rand(1, $this->sides);
        $this->lastRoll = $roll;
        return $roll;
    }

    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
