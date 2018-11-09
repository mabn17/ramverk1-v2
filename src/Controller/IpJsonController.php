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
        $ipA = $request->getGet('ip');
        $ipB = "";

        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ipB = "$ipA is a valid IPv6 adress.";
            } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ipB = "$ipA is a valid IPv4 adress.";
            }
        } else {
            $ipB = "$ipA is not a valid IP.";
        }

        $json = [
            "message" => "$ipB",
        ];
        return [$json];
    }

    public function mapActionGet() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getGet('ip');
        $accessKey = "59f40c392b861e29e674546a49e37b53";
        $apiRes = [];
        $json = [];

        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $chR = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$accessKey.'');
                curl_setopt($chR, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($chR);
                curl_close($chR);
                $apiRes = json_decode($json, true);
            } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                // $ipB = "<span class='text-success'> $ipA is a valid IPv4 adress.</span>";

                $chR = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$accessKey.'');
                curl_setopt($chR, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($chR);
                curl_close($chR);
                $apiRes = json_decode($json, true);
            }
            $apiRes["Map_Link"] = "https://www.openstreetmap.org/#map=13/{$apiRes['latitude']}/{$apiRes['longitude']}";
        }

        return [$apiRes];
    }

    public function mapActionPost() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getPost('ip');
        $accessKey = "59f40c392b861e29e674546a49e37b53";
        $apiRes = [];
        $json = [];

        if ($request->getPost('kmom01') !== null) {
            if (filter_var($ipA, FILTER_VALIDATE_IP)) {
                if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $ipB = "$ipA is a valid IPv6 adress.";
                } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $ipB = "$ipA is a valid IPv4 adress.";
                }
            } else {
                $ipB = "$ipA is not a valid IP.";
            }
    
            $json = [
                "message" => "$ipB",
            ];
            return [$json];
        }

        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $chR = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$accessKey.'');
                curl_setopt($chR, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($chR);
                curl_close($chR);
                $apiRes = json_decode($json, true);
            } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ipB = "<span class='text-success'> $ipA is a valid IPv4 adress.</span>";

                $chR = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$accessKey.'');
                curl_setopt($chR, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($chR);
                curl_close($chR);
                $apiRes = json_decode($json, true);
            }
            $apiRes["Map_Link"] = "https://www.openstreetmap.org/#map=13/{$apiRes['latitude']}/{$apiRes['longitude']}";
        }

        return [$apiRes];
    }
}
