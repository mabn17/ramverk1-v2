<?php

namespace Anax\IpValidator;

/**
 * Modell class to validate IP adresses route = /validate (FORM)
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ValidateModel
{
    /**
     * IpValidator for kmom01
     *
     * @param string $ipA       The ip adress
     *
     * @return string $res      If the adress is valid and its type.
     */
    public function validateKmomOne(string $ipA)
    {
        $res = "";
        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $res = $this->getIpVSixKmomOne($ipA);
            } else {
                $res = $this->getIpVFourKmomOne($ipA);
            }
        } else {
            $res = "<span class='text-danger'> $ipA is not a valid IP.</span>";
        }

        return [
            "ipB" => $res,
            "apiRes" => "",
        ];
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
        $res = [];
        if (filter_var($ipA, FILTER_VALIDATE_IP)) {
            if (filter_var($ipA, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $res = $this->getIpVSixKmomTwo($ipA);
            } else {
                $res = $this->getIpVFourKmomTwo($ipA);
            }
        } else {
            $res = [
                "apiRes" => null,
                "ipB" => "<span class='text-danger'> $ipA is not a valid IP.</span>"
            ];
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
        $accessKey = "59f40c392b861e29e674546a49e37b53";

        $chA = curl_init('http://api.ipstack.com/'.$ipA.'?access_key='.$accessKey.'');
        curl_setopt($chA, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($chA);
        curl_close($chA);
        return json_decode($json, true);
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
        return "<span class='text-success'> $ipA is a valid IPv6 adress.</span>";
    }

    /**
     * Generates a responce for IPv6 kmom02
     *
     * @param string $ipA       the ip adress
     *
     * @return array            information about the ip adress
     */
    public function getIpVSixKmomTwo(string $ipA) : array
    {
        $ipB = "<span class='text-success'> $ipA is a valid IPv6 adress.</span>";

        $apiRes = $this->getJson($ipA);

        return [
            "apiRes" => $apiRes,
            "ipB" => $ipB
        ];
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
        return "<span class='text-success'> $ipA is a valid IPv4 adress.</span>";
    }

    /**
     * Generates a responce for OPv4 kmom02
     *
     * @param string $ipA       the ip adress
     *
     * @return array            information about the ip adress
     */
    public function getIpVFourKmomTwo(string $ipA) : array
    {
        $ipB = "<span class='text-success'> $ipA is a valid IPv4 adress.</span>";
        $apiRes = $this->getJson($ipA);

        return [
            "apiRes" => $apiRes,
            "ipB" => $ipB
        ];
    }

    public function checkPost($kmomOne, $kmomTwo, $ipA) : array
    {
        if ($kmomTwo !== null) {
            return $this->validateKmomTwo($ipA);
        } elseif ($kmomOne !== null) {
            return $this->validateKmomOne($ipA);
        }

        return [
            "ipB" => "wtf",
            "apiRes" => "",
        ];
    }
}