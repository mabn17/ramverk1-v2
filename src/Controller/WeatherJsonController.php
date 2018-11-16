<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function initialize()
    {
        $this->model = new \Anax\Weather\WeatherJsonModel;
    }

    /**
     * Front page for the weather application
     */
    public function indexAction()
    {
        $page = $this->di->get("page");
        $page->add(
            "anax/v2/weather/explainJson",
            [
                "title" => "Väder app",
            ]
        );

        return $page->render([
            "title" => "Väder app",
        ]);
    }

    public function forecastActionGet(string $pos = "") : array
    {
        $request = $this->di->get("request");
        $days = $request->getGet('days') ?? "30";

        $res = [
            "pos" => $pos,
            "days" => $days,
        ];

        /* $apiRes = $this->model->getAllData(); */

        return [$res];
    }
}
