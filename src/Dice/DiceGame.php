<?php

namespace Hami\Dice;

class DiceGame
{
    public function __construct($player1, $player2)
    {
        $this->player1 = new DicePlayer($player1);
        $this->player2 = new DicePlayer($player2);
        $this->player1->activePlayer = true;
        $this->players = [$this->player1, $this->player2];
        $this->currentRollHuman = null;
        $this->currentRollComputer = null;
        $this->computerFail = null;
        $this->computerSuccess = null;
        $this->winMessage = null;
        $this->humanFail = null;
        $this->debug = null;
    }


    public function switchTurn()
    {
        for ($i = 0; $i < count($this->players); $i++) {
            if ($this->players[$i]->activePlayer == true) {
                $this->players[$i]->activePlayer = false;
            } else {
                $this->players[$i]->activePlayer = true;
            }
        }
        $this->getActivePlayer()->unsavedPoints = 0;
    }

    public function getActivePlayer()
    {
        foreach ($this->players as $key => $player) {
            print($key);
            if ($player->activePlayer == true) {
                return $player;
            }
        }
    }

    public function throwDice()
    {
        $this->humanFail = null;
        $throw = new DiceHand();
        $throw->rolls();
        $throwVals = $throw->values();

        if (!in_array(1, $throwVals)) {
            $this->currentRollHuman = $throwVals;
            if ($throwVals) {
                $sumOfThrow = array_sum($throwVals);
            }
            $this->getActivePlayer()->unsavedPoints += $sumOfThrow;
        } else {
            $this->currentRollHuman = $throwVals;
            $this->humanFail = "I rolled a 1 and failed my turn! The computer will now try his luck!";
            $throwVals = null;
            $this->getActivePlayer()->unsavedPoints = 0;
            $this->switchTurn();
        }
    }

    public function computerTurn()
    {
        if ($this->getActivePlayer()->name == "computer") {
            $this->computerFail = null;
            $this->computerSuccess = null;
            while ($this->getActivePlayer()->unsavedPoints < 17) {
                $throw = new DiceHand();
                $throw->rolls();
                $throwVals = $throw->values();
                $sumOfThrow = array_sum($throwVals);
                foreach ($throwVals as $key => $value) {
                    print($key);
                    if ($value === 1) {
                        $this->currentRollComputer = $throwVals;

                        $this->computerFail = "Computer rolled 1 and failed his turn!";
                        $throwVals = 0;
                        $this->getActivePlayer()->unsavedPoints = 0;
                        $this->switchTurn();
                        return (null);
                    }
                }
                $this->getActivePlayer()->unsavedPoints += $sumOfThrow;
            }
            $this->currentRollComputer = $throwVals;

            if ($this->computerFail == null) {
                $this->computerSuccess = "Computer saves and adds " . $this->getActivePlayer()->unsavedPoints . " to his total";
            }
            $this->stopTurn();
        }
    }

    public function stopTurn()
    {
        $currentPlayer = $this->getActivePlayer();
        $currentPlayer->currentPoints += $currentPlayer->unsavedPoints;
        $currentPlayer->unsavedPoints = 0;
        $this->switchTurn();
    }

    public function checkWin()
    {
        for ($i = 0; $i < count($this->players); $i++) {
            if ($this->players[$i]->currentPoints >= 100) {
                $this->winMessage = $this->players[$i]->name . " wins the game!!!";
            }
        }
    }
}
