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

        $path = $this->di->get("router")->getMatchedPath();
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $ip = ($session->has('ip')) ? $session->get("ip"): "Nothing is set";

        $page->add(
            "anax/v2/ip/explainJson",
            [
                "ip" => $ip,
            ]
        );

        return $page->render([
            "title" => "Ip Json Validator",
        ]);
    }

    public function lookAction() : array
    {
        $json = [
            "Kmom01" => "Lägg in din valda ip adress efter ip-json/check/{ip adress}",
            "Kmom02" => "Lägg in din valda ip adress efter ip-json/map?ip={ip adress}",
        ];
        return [$json];
    }

    public function checkActionGet() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getGet('ip');
        $ip = "";

        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ip = "$ipA is a valid IPv6 adress.";
            } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = "$ipA is a valid IPv4 adress.";
            }
        } else {
            $ip = "$ipA is not a valid IP.";
        }

        $json = [
            "message" => "$ip",
        ];
        return [$json];
    }

    public function mapActionGet() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getGet('ip');
        $access_key = "59f40c392b861e29e674546a49e37b53";
        $api_result = [];
        $json = [];

        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ch = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$access_key.'');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($ch);
                curl_close($ch);
                $api_result = json_decode($json, true);
            } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = "<span class='text-success'> $ipA is a valid IPv4 adress.</span>";

                $ch = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$access_key.'');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($ch);
                curl_close($ch);
                $api_result = json_decode($json, true);
            }
            $api_result["Map_Link"] = "https://www.openstreetmap.org/#map=13/{$api_result['latitude']}/{$api_result['longitude']}";
        }

        return [$api_result];
    }

    public function mapActionPost() : array
    {
        $request = $this->di->get("request");
        $ipA = $request->getPost('ip');
        $access_key = "59f40c392b861e29e674546a49e37b53";
        $api_result = [];
        $json = [];

        if ($request->getPost('kmom01') !== null) {
            if (filter_var($ipA, FILTER_VALIDATE_IP)) {
                if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $ip = "$ipA is a valid IPv6 adress.";
                } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $ip = "$ipA is a valid IPv4 adress.";
                }
            } else {
                $ip = "$ipA is not a valid IP.";
            }
    
            $json = [
                "message" => "$ip",
            ];
            return [$json];
        }

        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ch = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$access_key.'');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($ch);
                curl_close($ch);
                $api_result = json_decode($json, true);
            } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = "<span class='text-success'> $ipA is a valid IPv4 adress.</span>";

                $ch = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$access_key.'');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($ch);
                curl_close($ch);
                $api_result = json_decode($json, true);
            }
            $api_result["Map_Link"] = "https://www.openstreetmap.org/#map=13/{$api_result['latitude']}/{$api_result['longitude']}";
        }

        return [$api_result];
    }
}
