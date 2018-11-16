<?php

namespace Anax\Weather;

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
class WeatherModel
{
    public function getData(array $coords) : array
    {
        $filename = __DIR__ . "/key.txt";
        $accessKey = file($filename)[0];
        $location = $coords[0]['lat'] . ',' . $coords[0]['lon'];

        $chA = curl_init(
            'https://api.darksky.net/forecast/'.
            $accessKey . '/' . $location.
            '?exclude=minutely,hourly,currently,alerts,flags&extend=daily&lang=sv&units=auto'
        );
        curl_setopt($chA, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($chA);
        curl_close($chA);

        $apiRes = json_decode($json, true);
        return [$apiRes];
    }

    public function getDate($nrOfDays) : string
    {
        $timestamp = mktime(date('H-i-s-n-j-Y'));

        $myDate = new \Datetime();
        $myDate->setTimestamp($timestamp);

        $myDate->sub(new \DateInterval('P'. (intval($nrOfDays) + 1) .'D'));
        return $myDate->format('U');
    }

    // WORKS 
    // NOTE: only returns one day per request -> original is current + 7 days
    // -> REMEMBER: make the original + 22 sub requests.. 
    /* public function test(string $location) : array
    {
        $filename = __DIR__ . "/key.txt";
        $accessKey = file($filename)[0];
        $time = $this->getDate(10); // ','.$time.
        $chA = curl_init('https://api.darksky.net/forecast/'.$accessKey.'/'.$location.','.$time.'?exclude=minutely,hourly,currently,alerts,flags&extend=daily&lang=sv&units=auto');
        curl_setopt($chA, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($chA);
        curl_close($chA);

        $apiRes = json_decode($json, true);
        return [$apiRes];
    } */

    public function geocode(string $adrs) : array
    {
        $city = urlencode($adrs);

        // Just a random email query (not returning anything wihtout it ??)
        $url = "https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q={$city}&limit=1&email=aneamil@live.se";
        
        $chA = curl_init($url);
        curl_setopt($chA, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($chA);
        curl_close($chA);

        $apiRes = json_decode($json, true) ?? [];
        return $apiRes;
    }

    // Works wonders
    public function multiCurl()
    {
        $urls = [];

        for ($i = 0; $i < 5; $i++) { 
            $urls[] = 'http://httpbin.org/get?i=' . $i;
        }

        $multi = curl_multi_init();
        $handles = [];
        $htmls = [];

        foreach ($urls as $url)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_multi_add_handle($multi, $ch);
            $handles[$url] = $ch;
        }

        do
        {
            $mrc = curl_multi_exec($multi, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK)
        {
            if (curl_multi_select($multi) == -1) {
                usleep(100);
            }
            do
            {
                $mrc = curl_multi_exec($multi, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
        foreach ($handles as $channel) {
            $html = curl_multi_getcontent($channel);
            $htmls[] = json_decode($html, true);
            //var_dump($html);
            curl_multi_remove_handle($multi, $channel);
        }

        curl_multi_close($multi);
        return $htmls;
    }

    // Ignore (Just for testing $di)
    public function hello() : string
    {
        return 'TEST - (Taget från $di)';
    }
}
