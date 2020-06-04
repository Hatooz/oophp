<?php

namespace Hami\MyTextFilter;

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
class MyTextFilterController implements AppInjectableInterface
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
    public function indexAction()
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";
        $title = "Movie database | oophp";

        $text = file_get_contents(__DIR__ . "./text/bbcode.txt");
        $txtFilter = new MyTextFilter();
        $html = $txtFilter->parse($text, ["bbcode"]);

        $data = [
            "text" => $text,
            "html" =>  $html
        ];

        $this->app->page->add("mytextfilter/index", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function clickableAction()
    {
        $text = file_get_contents(__DIR__ . "./text/clickable.txt");
        $txtFilter = new MyTextFilter();
        $html = $txtFilter->parse($text, ["link"]);

        $data = [
            "text" => $text,
            "html" =>  $html
        ];
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";
        $title = "Movie database | oophp";

        $this->app->page->add("mytextfilter/clickable", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function markdownAction()
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";
        $title = "Movie database | oophp";
        $text = file_get_contents(__DIR__ . "./text/bbcode.txt");
        $txtFilter = new MyTextFilter();
        $html = $txtFilter->parse($text, ["markdown"]);

        $data = [
            "text" => $text,
            "html" =>  $html
        ];

        $this->app->page->add("mytextfilter/markdown", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
