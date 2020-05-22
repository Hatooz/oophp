<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<style>
    .t100 {
        background-color: lightblue;
        padding: 10px;
        border-radius: 10px;
    }

    p {
        color: #16697A;
    }

    .title {
        color: #16697A;
    }

    .win {
        color: red;
    }

    input {
        border-radius: 10px;
        border: none;
        margin-top: 10px;
        margin-right: 10px;
        padding: 10px;
        width: 80px;
        background-color: #16697A;
        color: lightblue;
    }
</style>
<div class="t100">
    <h1 class="title">T100 GAME</h1>
    <p>Player 1: <?= $player1 ?></p>
    <p>Player 1 saved points:<?= $player1currentPoints ?></p>
    <p>Player 1 current pot: <?= $player1unsavedPoints ?> <span><?= $humanFail ?></span> </p>


    <h4>Rolls</h4>
    <table>
        <?php if ($currentRollHuman) : ?>
            <?php foreach ($currentRollHuman as $key => $value) : ?>
                <tr>
                    <td><?php echo $value; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <form action="" method="POST">

        <input type="submit" name="savePoints" id="savePoints" value="Save">
        <input type="submit" name="newRoll" id="newRoll" value="Roll">
    </form>
    <p>_________________________________________</p>
    <h2 class="win"><?= $winMessage ?></h2>
    <p>_________________________________________</p>


    <p>Player 2: <?= $player2 ?></p>
    <p>Computer saved points:<?= $player2currentPoints ?></p>
    <p>Computer current pot:<?= $player2unsavedPoints ?></p>
    <p><?= $computerFail ?></p>
    <p><?= $computerSuccess ?></p>

    <h1>Dice Roll Histogram</h1>



    <table>
        <?php if ($printHisto) : ?>
            <?php foreach ($printHisto as $key => $value) : ?>
                <tr>
                    <td><?php echo $key . ": " . $value; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>


</div>
