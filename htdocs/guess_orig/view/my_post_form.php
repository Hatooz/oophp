 
<h1>Guess my number</h1>


<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <input type="submit" name="doGuess" value="Guess!">
    <input type="submit" name="doInit" value="Restart">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<?php if ($doGuess) : ?>
    <p>Your guess <?= $guess ?> is <?= $res ?></p>
<?php endif; ?>
<?php if ($doCheat) : ?>
    <p>Secret number is <?= $number ?></p>
<?php endif; ?>
