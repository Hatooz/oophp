<?php

namespace Hami\Dice;

class DicePlayer
{
    public function __construct($name)
    {
        $this->name = $name;
        $this->currentPoints = 0;
        $this->unsavedPoints = 0;
        $this->activePlayer = false;
    }


    public function setPoints($points)
    {
        $this->currentPoints += $points;
    }

    public function getPoints()
    {
        return $this->currentPoints;
    }
}
