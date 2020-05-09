<?php

namespace Hami\Dice;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     */
    public $dices;
    public $values;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $dices = 2)
    {
        $this->nOfDice = $dices;
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[$i]  = new Dice();
        }
    }

    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function rolls()
    {
        for ($i = 0; $i < count($this->dices); $i++) {
            $res = $this->dices[$i]->roll();
            array_push($this->values, $res);
        }
    }

    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
    }

    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        return array_sum($this->values());
    }

    /**
     * Get the average of all dices.
     *
     * @return float as the average of all dices.
     */
    public function average()
    {
        return $this->sum() / count($this->values);
    }
}
