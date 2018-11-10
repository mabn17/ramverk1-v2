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
class IpJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function __construct()
    {
        $this->model = new \Anax\IpValidator\JsonValidatorModel;
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     */
    public function indexAction()
    {

        // $path = $this->di->get("router")->getMatchedPath();
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $ipB = ($session->has('ip')) ? $session->get("ip"): "Nothing is set";

        $page->add(
            "anax/v2/ip/explainJson",
            [
                "ip" => $ipB,
            ]
        );

        return $page->render([
            "title" => "Ip Json Validator",
        ]);
    }

    public function lookAction() : array
    {
        $json = [
            "Kmom01" => "Lägg in din valda ip adress efter validate/check?ip={ip adress}",
            "Kmom02" => "Lägg in din valda ip adress efter ip-json/map?ip={ip adress}",
        ];
        return [$json];
    }

    public function checkActionGet() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getGet('ip') ?? "";
        $ipB = $this->model->validateKmomOne($ipA);

        $json = [
            "message" => "$ipB",
        ];
        return [$json];
    }

    public function checkActionPost() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getPost('ip') ?? "";
        $ipB = $this->model->validateKmomOne($ipA);

        $json = [
            "message" => "$ipB",
        ];
        return [$json];
    }

    public function mapActionGet() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getGet('ip') ?? "";
        $apiRes = $this->model->validateKmomTwo($ipA);

        return [$apiRes];
    }

    public function mapActionPost() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getPost('ip') ?? "";
        $kmomOne = $request->getPost('kmom01') ?? false;
        $apiRes = [];
        $json = [];

        $apiRes = $this->model->validateKmomTwo($ipA);

        // Only for test route
        if ($kmomOne) {
            $ipB = $this->model->validateKmomOne($ipA);
            $json = [
                "message" => "$ipB",
            ];
            return [$json];
        }

        return [$apiRes];
    }
}
