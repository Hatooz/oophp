<?php

namespace Hami\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize(): void
    {
        // Use to initialise member variables.
        $this->db = "active";

        // Use $this->app to access the framework services.
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction(): string
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";

        return "Index!";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function initAction(): object
    {
        $game = new DiceGame("me", "computer");
        $dice = new DiceHistogram2();
        $this->app->session->set("rolls", null);
        // $_SESSION["game"] = $game;
        $this->app->session->set("game", $game);
        $this->app->session->set("dice", $dice);
        $histogram = new Histogram();
        $this->app->session->set("histogram", $histogram);

        return $this->app->response->redirect("dice1/play");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function playActionGet(): object
    {
        $title = "Play game";
        $gameSession = $this->app->session->get("game");
        $dice = $this->app->session->get("dice");
        $histogram = $this->app->session->get("histogram");
        // $rolls = 2;
        $rolls = $this->app->session->get("rolls" ?? 0);



        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $histogram->injectData($dice);



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
            "humanFail" => $gameSession->humanFail,
            "printHisto" => $histogram->getAsText(),
            "rolls" => $rolls
        ];



        $this->app->page->add("dice1/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function playActionPost(): object
    {
        $game = $_SESSION["game"];

        $savePoints = $this->app->request->getPost("savePoints");
        $roll = $this->app->request->getPost("newRoll");
        $this->app->session->set("rolls", 2);

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

        return $this->app->response->redirect("dice1/play");
    }
}
