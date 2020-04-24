<?php


include(__DIR__ . "/autoloader.php");
include(__DIR__ . "/config.php");
// $game = new Guess();
// $game->makeGuess($number);
// echo $game->number();

$number = $game->number ?? null;
$tries = $game->tries ?? null;
$guess = $_POST["guess"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;

// $game->makeGuess($guess);
try {
    $res = $game->makeGuess($guess);
} catch (GuessException $e) {
    $res = "Guess has to be between 1 and 100";
}


if (isset($doInit)) {
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}


include(__DIR__ . "/view/my_post_form.php");
