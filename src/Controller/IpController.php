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
class IpController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function __construct()
    {
        $this->model = new \Anax\IpValidator\ValidateModel;
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     */
    public function indexAction()
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $ipB = ($session->has('ip')) ? $session->get("ip"): "";
        $ipA = ($session->has('ip')) ? $session->get("ipA"): "";
        $apiRes = ($session->has('apiRes')) ? $session->get("apiRes") : "";

        $page->add(
            "anax/v2/ip/validator",
            [
                "ip" => $ipB,
                "ipA" => $ipA,
                "apiRes" => $apiRes,
            ]
        );

        return $page->render([
            "title" => "Ip Validator",
        ]);
    }

    /**
     * Displays a view that shows the response for kmom01 and kmom02
     * /update (TODO: change (BAD route name))
     *
     * @return string
     */
    public function updateActionPost() : object
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $ipA = $request->getPost('ip') ?? "";
        $kmomOne = $request->getPost('kmom01');
        $kmomTwo = $request->getPost('kmom02');

        $myRes = $this->model->checkPost($kmomOne, $kmomTwo, $ipA);
        $apiRes = $myRes["apiRes"];
        $ipB = $myRes["ipB"];

        $session->set("ip", $ipB);
        $session->set("ipA", $ipA);
        $session->set("apiRes", $apiRes);

        return $this->di->get("response")->redirect("validate");
    }
}
