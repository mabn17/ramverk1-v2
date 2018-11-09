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



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
        $this->data = [];
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

        // $path = $this->di->get("router")->getMatchedPath();
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
     * This sample method action it the handler for route:
     * POST mountpoint/create
     *
     * @return string
     */
    public function updateActionPost() : object
    {
        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $ipA = $request->getPost('ip');
        $ipB = "null";
        $accessKey = "59f40c392b861e29e674546a49e37b53";
        $apiRes = "";

        if ($request->getPost('kmom02') !== null) {
            if (filter_var($ipA, FILTER_VALIDATE_IP)) {
                if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $ipB = "<span class='text-success'> $ipA is a valid IPv6 adress.</span>";

                    $ch = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$accessKey.'');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $json = curl_exec($ch);
                    curl_close($ch);
                    $apiRes = json_decode($json, true);
                } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $ipB = "<span class='text-success'> $ipA is a valid IPv4 adress.</span>";

                    $ch = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$accessKey.'');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $json = curl_exec($ch);
                    curl_close($ch);
                    $apiRes = json_decode($json, true);
                }
            } else {
                $ipB = "<span class='text-danger'> $ipA is not a valid IP.</span>";
            }
        } elseif ($request->getPost('kmom01') !== null) {
            if (filter_var($ipA, FILTER_VALIDATE_IP)) {
                if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $ipB = "<span class='text-success'> $ipA is a valid IPv6 adress.</span>";
                } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $ipB = "<span class='text-success'> $ipA is a valid IPv4 adress.</span>";
                }
            } else {
                $ipB = "<span class='text-danger'> $ipA is not a valid IP.</span>";
            }
        }

        $session->set("ip", $ipB);
        $session->set("ipA", $ipA);
        $session->set("apiRes", $apiRes);

        return $response->redirect("validate");
    }
}
