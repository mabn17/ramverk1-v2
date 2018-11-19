<?php

namespace Anax\IpValidator;

/**
 * Modell class to validate IP adresses route = /validate (FORM)
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class JsonValidatorModel
{
    /**
     * IpValidator for kmom01
     *
     * @param string $ipA       The ip adress
     *
     * @return string $res      If the adress is valid and its type.
     */
    public function validateKmomOne(string $ipA) : string
    {
        $ipB = "$ipA is not a valid IP.";
        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ipB = "$ipA is a valid IPv6 adress.";
            } elseif (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ipB = "$ipA is a valid IPv4 adress.";
            }
        }

        return $ipB;
    }

    /**
     * IpValidator for kmom02
     *
     * @param string $ipA       The ip adress
     *
     * @return array $res       Information about the ip adress
     */
    public function validateKmomTwo(string $ipA) : array
    {
        /* $res = []; */
        $res = ["error" => "$ipA is not a valid ip adress"];

        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            $res = $this->getIpKmomTwo($ipA);
        }
        return $res;
    }

    /**
     * Curls http://api.ipstack.com with the given ip adress
     *
     * @param string $ipA       The ip adress
     *
     * @return array            Information about the ip adress
     */
    public function getJson(string $ipA) : array
    {
        $filename = __DIR__ . "/key.txt";
        $accessKey = file($filename)[0];

        $chA = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$accessKey.'');
        curl_setopt($chA, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($chA);
        curl_close($chA);

        $apiRes = json_decode($json, true);
        $apiRes["Map_Link"] = "https://www.openstreetmap.org/#map=13/{$apiRes['latitude']}/{$apiRes['longitude']}";

        return $apiRes;
    }

    /**
     * Gives a response that the ip adress is IPv6
     *
     * @param string $ipA       ip adress
     *
     * @return string           is valid and type IPv6
     */
    public function getIpVSixKmomOne(string $ipA) : string
    {
        return "$ipA is a valid IPv6 adress.";
    }

    /**
     * Generates a responce for kmom02
     *
     * @param string $ipA       the ip adress
     *
     * @return array            information about the ip adress
     */
    public function getIpKmomTwo(string $ipA) : array
    {
        return $this->getJson($ipA);
    }

    /**
     * Gives a response that the ip adress is IPv6
     *
     * @param string $ipA       ip adress
     *
     * @return string           is valid and type IPv6
     */
    public function getIpVFourKmomOne(string $ipA) : string
    {
        return "$ipA is a valid IPv4 adress.";
    }
}
