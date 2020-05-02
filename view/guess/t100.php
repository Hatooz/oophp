<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());




?><h1>Play the game</h1>



<h1>Guess my number</h1>


<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <input type="submit" name="doGuess" value="Guess!">

</form>

<?php if ($res) : ?>
    <p>Your guess <?= $guess ?> is <?= $res ?></p>
<?php endif; ?>
<?php if ($doCheat) : ?>
    <p>Secret number is <?= $number ?></p>
<?php endif; ?>
