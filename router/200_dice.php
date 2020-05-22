<?php

/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * init game and redirect to playfield
 */
$app->router->get("dice/init", function () use ($app) {
    // echo "Some debugging information";
    $game = new Hami\Dice\DiceGame("me", "computer");
    $_SESSION["game"] = $game;
    return $app->response->redirect("dice/play");
});



/**
 * Returning a JSON message with Hello World.
 */
$app->router->get("dice/play", function () use ($app) {

    $title = "Play game";
    $gameSession = $_SESSION["game"];

    $data = [
        "player1" => $gameSession->player1->name,
        "player2" => $gameSession->player2->name,
        "player1currentPoints" => $gameSession->player1->currentPoints,
        "player2currentPoints" => $gameSession->player2->currentPoints,
        "player1unsavedPoints" => $gameSession->player1->unsavedPoints,
        "player2unsavedPoints" => $gameSession->player2->unsavedPoints,
        "currentRollHuman" => $gameSession->currentRollHuman,
        "currentRollComputer" => $gameSession->currentRollComputer,
        "computerFail" => $gameSession->computerFail,
        "computerSuccess" => $gameSession->computerSuccess,
        "winMessage" => $gameSession->winMessage,
        "humanFail" => $gameSession->humanFail
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("dice/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play game";
    $game = $_SESSION["game"];

    $savePoints = $_POST["savePoints"] ?? null;
    $_POST["unsavedPoints"] = $pointsToSave ?? null;
    $roll = $_POST["newRoll"] ?? null;

    if ($roll) {
        $game->throwDice();
    }
    if ($savePoints) {
        $game->stopTurn();
        $game->checkWin();
    }

    if ($game->getActivePlayer()->name == "computer") {
        $game->computerTurn();
        $game->checkWin();
    }

    return $app->response->redirect("dice/play");
});
