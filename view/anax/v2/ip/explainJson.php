<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
/* echo showEnvironment(get_defined_vars(), get_defined_functions()); */

function getMyIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $tes = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $tes = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $tes = $_SERVER['REMOTE_ADDR'];
    }
    return $tes;
}

$myIp = getMyIp();

?><div class="py-4" style="margin-bottom: 150px;">
    <h1>Dokumentation</h1>
    <p>Detta är ett <b>REST API</b> som validerar ip adresser.<p>APIet hanterar frågor för GET och POST och returnerar information om den givna ip adressen t.ex IPv4, IPv6, invalid</p></p>
    <h2>Prova</h2>
    <div class="row d-flex">
        <div class="col">
        <h4>Kmom01 GET</h4>
            <p>IPV6 <a href="<?= url("ip-json/check?ip=2001:0db8:85a3:0000:0000:8a2e:0370:7334") ?>">exempel</a> <br> IPV4 <a href="<?= url("ip-json/check?ip=127.0.0.1") ?>">exempel</a></p>
        </div>
        <div class="col">
        <h4>Kmom02 GET</h4>
            <p>Testa med <a href="<?= url("ip-json/map?ip=$myIp")?>">din egen</a> ip adress <br>Eller använd ett <a href="<?= url("ip-json/map?ip=83.252.52.131")?>">färdigt</a> exempel</p>
        </div>
    </div>
    <p>Post:</p>
    <form class="form-inline w-100" method="post" action="<?= url("ip-json/map") ?>">
    <div class="form-group w-100">
        <label class="sr-only" for="ip">ip address:</label>
        <input type="ip" class="form-control w-100" name="ip" id="ip" value="<?= $myIp ?>">
    </div><br>
    <button type="submit" name="kmom01" class="btn btn-default row mt-2 w-50">Kolla IP - Kmom01</button>
    <button type="submit" name="kmom02" class="btn btn-default row mt-2 w-50 btn-secondary">Kolla IP - Kmom02</button>
    </form>
    <h2>API</h2>
    <h3>Användning Kmom01</h3>
    <h4>GET</h4>
    <pre class="hljs text-left"><span class="hljs-keyword">GET</span> /ip-json/check?ip=[ip adress]<br><b>GET</b> /ip-json/check?ip=127.0.0.1</pre>
    <i>Resultat</i>
    <pre class="hljs text-left">{
    "message": "127.0.0.1 is a valid IPv4 adress."
}</pre>
    <h4>POST</h4>
    <p><small>Skicka frågorna i <b>Body</b> och försäkra dig om att <b>x-www-form-urlencoded</b> är satt</small></p>
    <pre class="hljs text-left"><span class="hljs-keyword">POST</span> /ip-json/check<br><b>POST</b> /ip-json/check
    <span class="hljs-comment">{ip: 127.0.0.1}</span></pre>
    <i>Resultat</i>
    <pre class="hljs text-left">{
    "message": "127.0.0.1 is a valid IPv4 adress."
}</pre>
    <h3>Användning Kmom02</h3>
    <h4>GET</h4>
    <pre class="hljs text-left"><span class="hljs-keyword">GET</span> /ip-json/map?ip=[ip adress]<br><b>GET</b> /ip-json/map?ip=83.252.52.131</pre>
    <i>Resultat</i>
    <pre class="hljs text-left">{
    "ip": "83.252.52.131",
    "type": "ipv4",
    "continent_code": "EU",
    "continent_name": "Europe",
    "country_code": "SE",
    "country_name": "Sweden",
    "region_code": "K",
    "region_name" "Blekinge",
    "city": "Karlskrona",
    "zip": "371 31",
    "latitude": 56.1616,
    "longitude": 15.5866,
    "location": [
        "geoname_id": 2701713,
        "capital": "Stockholm",
        "languages": [
            0: [
                "code": "sv",
                "name": "Swedish",
                "native": "Svenska",
                "contry_flag": "http://assets.ipstack.com/flags/se.svg",
                "country_flag_emoji": "🇸🇪",
                "country_flag_emoji_unicode": "U+1F1F8 U+1F1EA",
                "calling_code": "46",
                "is_eu": true
            ]
        ]
    ],
    "Map_Link": "https://www.openstreetmap.org/#map=13/56.1616/15.5866"
}</pre>
    <h4>POST</h4>
    <p><small>Skicka frågorna i <b>Body</b> och försäkra dig om att <b>x-www-form-urlencoded</b> är satt</small></p>
    <pre class="hljs text-left"><span class="hljs-keyword">POST</span> /ip-json/map<br><b>POST</b> /ip-json/map
    <span class="hljs-comment">{ip: 83.252.52.131}</span></pre>
    <i>Resultat</i>
    <pre class="hljs text-left">{
    "ip": "83.252.52.131",
    "type": "ipv4",
    "continent_code": "EU",
    "continent_name": "Europe",
    "country_code": "SE",
    "country_name": "Sweden",
    "region_code": "K",
    "region_name" "Blekinge",
    "city": "Karlskrona",
    "zip": "371 31",
    "latitude": 56.1616,
    "longitude": 15.5866,
    "location": [
        "geoname_id": 2701713,
        "capital": "Stockholm",
        "languages": [
            0: [
                "code": "sv",
                "name": "Swedish",
                "native": "Svenska",
                "contry_flag": "http://assets.ipstack.com/flags/se.svg",
                "country_flag_emoji": "🇸🇪",
                "country_flag_emoji_unicode": "U+1F1F8 U+1F1EA",
                "calling_code": "46",
                "is_eu": true
            ]
        ]
    ],
    "Map_Link": "https://www.openstreetmap.org/#map=13/56.1616/15.5866"
}</pre>
</div>
