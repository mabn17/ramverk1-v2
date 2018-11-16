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
    <p>Detta är en en webbtjänst som hämtar väderprognosen för ett specifikt område, dag för dag. Använd REST API:fär att hämta historisk och kommande väderdata.</p></p>
    <h2 class="">Prova</h2>
    <div class="row d-flex">
        <div class="col">
            <a href="<?= url("v-json/forecast/karlskrona") ?>">Exepmel</a> på hur standard svaret ser ut från Karlskrona.
        </div>
        <div class="col">
            <a href="<?= url("v-json/forecast/karlskrona?days=1") ?>">Exepmel</a> på hur standard svaret ser ut från Karlskrona med limiterade dagar.
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
    Optionella parametrar läggs till som en <a href="https://en.wikipedia.org/wiki/Query_string">query</a> efter <small><i><code>[position]</code>, ex. <code>/v-json/karlskrona?days=2</code></i></small>
    <h4>GET</h4>
    <pre class="hljs text-left"><span class="hljs-keyword">GET</span> /v-json/[position]<br><b>GET</b> /v-json/karlskrona</pre>
    <i>Resultat</i>
    <pre class="hljs text-left">{
    "message": "127.0.0.1 is a valid IPv4 adress."
}</pre>
</div>
