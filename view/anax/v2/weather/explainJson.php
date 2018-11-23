<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions,
/* echo showEnvironment(get_defined_vars(), get_defined_functions()); */

/* function getMyIp()
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

$myIp = getMyIp(); */

?><div class="py-4" style="margin-bottom: 150px;">
    <h1>Dokumentation</h1>
    <p>Detta är en en webbtjänst som hämtar väderprognosen för ett specifikt område, dag för dag. Använd REST API:fär att hämta historisk och kommande väderdata.</p></p>
    <p>All information hämtas från <a href="https://www.openstreetmap.org/">Openstreetmap</a> och <a href="https://darksky.net">Darksky.</a></p>
    <h2 class="">Prova</h2>
    <div class="row d-flex">
        <div class="col">
            <a href="<?= /** @scrutinizer ignore-call */ url("v-json/forecast/karlskrona") ?>">Exepmel</a> på hur standard svaret ser ut från Karlskrona.
        </div>
        <div class="col">
            <a href="<?= /** @scrutinizer ignore-call */ url("v-json/forecast/karlskrona?days=1") ?>">Exepmel</a> på hur standard svaret ser ut från Karlskrona med limiterade dagar.
        </div>
    </div>
    <h2>Request Parametrar</h2>
    <p>Position använder sig av <b>openstreetmap</b> och returnerar den första träffen så var <b>tydlig</b> med platsen,<br>Postkod 37138 kan t.ex returnera Tennessee, Texas om Land/Stad inte specifiseras.</p>
    <ol class="noDec pb-4">
        <li><b>Position </b><small class="text-secondary">required,</small><small> någon av följande:</small></li>
            <ul>
                <li><code>"Latitude,Longitude"</code> ex. <i>56.16156,15.58661</i></li>
                <li><code>"Land"</code> ex. <i>Sverige</i> (engelska fungerar också)</li>
                <li><code>"Län"</code> ex. <i>Blekinge län</i></li>
                <li><code>"Stad"</code> ex. <i>Ronneby</i></li>
                <li><code>"Postkod"</code> ex. <i>37138 Sweden</i></li>
                <li><code>"Adress"</code> ex. <i>Valhallavägen 1 karlskrona</i></li>
            </ul>
    </ol>
    <p>Dagar är en optionell parameter som bestämmer hur många av de tidigare dagar som skall visas,<br><i><code>dagar=6</code></i> ger även tillbaka vädret för de 6 senaste dygnen och har standardvärde 30</p>
    <ol class="noDec">
        <li><b>Dagar </b><small class="text-secondary">optionell,</small><small> max 30</small></li>
    </ol>

    <h2>API</h2>
    <h3>Användning</h3>
    Optionella parametrar läggs till som en <a href="https://en.wikipedia.org/wiki/Query_string">query</a> efter <small><i><code>[position]</code>, ex. <code>karlskrona?days=2</code></i></small>
    <h4>GET</h4>
    <pre class="hljs text-left"><span class="hljs-keyword">GET</span> /v-json/forecast/[position]<br><b>GET</b> /v-json/forecast/karlskrona</pre>
    <i>Resultat</i>
    <pre class="hljs text-left">[
    current: [
        latitude: 56.1621073,
        longitude: 15.5866422,
        timezone: "Europe/Stockholm",
        daily: [
            summary: "Ingen mätbar nederbörd u…ill 5°C under onsdagen.",
            icon: "clear-day",
            0: [
                time: 1542409200,
                summary: "Molnigt under dagen.",
                icon: "partly-cloudy-day",
                sunriseTime: 1542436832,
                sunsetTime: 1542466053,
                moonPhase: 0.31,
                precipIntensity: 0,
                precipIntensityMax: 0.0025,
                precipIntensityMaxTime: 1542423600,
                precipProbability: 0,
                temperatureHigh: 5.44,
                temperatureHighTime: 1542434400,
                temperatureLow: 2.93,
                temperatureLowTime: 1542492000,
                apparentTemperatureHigh: 5.44,
                apparentTemperatureHighTime: 1542434400,
                apparentTemperatureLow: -0.22,
                apparentTemperatureLowTime: 1542495600,
                dewPoint: 3.03,
                humidity: 0.87,
                pressure: 1040.8,
                windSpeed: 1.16,
                windGust: 5.56,
                windGustTime: 1542492000
                windBearing: 295,
                cloudCover: 0.74,
                uvIndex: 0,
                uvIndexTime: 1542409200,
                visibility: 14.4,
                ozone: 280.04,
                temperatureMin: 2.93,
                temperatureMinTime: 1542492000,
                temperatureMax: 6.44,
                temperatureMaxTime: 1542409200,
                apparentTemperatureMin: -0.19,
                apparentTemperatureMinTime: 1542492000,
                apparentTemperatureMax: 5.44,
                apparentTemperatureMaxTime: 1542430800
            ],
            ...
            7: [
                <span class="hljs-comment">Samma innehåll som ["daily"][0]</span>
            ]
        ],
        offset: 1
    ],
    previous: [
        0: [
            0: [
                <span class="hljs-comment">Samma som current["daily"]</span>
                <span class="hljs-comment">Denna arrayen kommer inte att synas om days = 0</span>
            ]
        ]
        1: [
            0: [
                ....
            ]
        ]
        ...
    ]
]</pre>
</div>
