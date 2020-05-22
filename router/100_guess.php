<?php

/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * init game and redirect to playfield
 */
$app->router->get("guess/init", function () use ($app) {
    // echo "Some debugging information";
    $game = new Hami\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    return $app->response->redirect("guess/play");
});



/**
 * Returning a JSON message with Hello World.
 */
$app->router->get("guess/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play game";

    // $guess = $_POST["guess"] ?? 50;
    // $doInit = $_POST["doInit"] ?? null;
    // $doGuess = $_POST["doGuess"] ?? null;
    // $doCheat = $_POST["doCheat"] ?? null;
    // $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $_SESSION["res"] = null;
    $_SESSION["guess"] = null;

    // try {
    //     $game = new Hami\Guess\Guess();
    //     $res = $game->makeGuess($guess);
    // } catch (GuessException $e) {
    //     $res = "Guess has to be between 1 and 100";
    // }
    $data = [
        "guess" => $guess ?? null,
        "tries" => $tries,
        "number" => $number ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
        "res" => $res
    ];
    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("guess/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play game";

    $guess = $_POST["guess"] ?? 50;
    $doInit = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $res = null;

    if ($doGuess) {
        try {
            $game = new Hami\Guess\Guess($number, $tries);
            $res = $game->makeGuess($guess);
            $_SESSION["res"] = $res;
            $_SESSION["tries"] = $tries;
            $_SESSION["guess"] = $guess;
        } catch (Hami\Guess\GuessException $e) {
            $_SESSION["res"] = "Guess has to be between 1 and 100";
        }
    }


    return $app->response->redirect("guess/play");
});
