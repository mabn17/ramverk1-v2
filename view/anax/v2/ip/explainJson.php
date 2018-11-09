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
    <h2>Användning Kmom01</h2>
    <p>Exempel för att kolla ip adress - ip-json/look?ip={ip adress}</p>
    <p>IPV6 <a href="<?= url("ip-json/check?ip=2001:0db8:85a3:0000:0000:8a2e:0370:7334") ?>">exempel</a> <br> IPV4 <a href="<?= url("ip-json/check?ip=127.0.0.1") ?>">exempel</a></p>
    För mer info in på <a href="<?= url("ip-json/look") ?>">Restful APIets</a> informations-sida.

    <h2>Användning Kmom02</h2>
    <p>Exempel för att kolla ip adress - ip-json/map?ip={ip adress}</p>
    <p>Testa med <a href="<?= url("ip-json/map?ip=$myIp")?>">din egen</a> ip adress <br>Eller använd ett <a href="<?= url("ip-json/map?ip=83.252.52.131")?>">färdigt</a> exempel</p>
    För mer info in på <a href="<?= url("ip-json/look") ?>">Restful APIets</a> informations-sida.
    
    <hr>
    <p><b>Eller använd Post</b>:</p>
    
    <form class="form-inline w-100" method="post" action="<?= url("ip-json/map") ?>">
    <div class="form-group w-100">
        <label class="sr-only" for="ip">ip address:</label>
        <input type="ip" class="form-control w-100" name="ip" id="ip" value="<?= $myIp ?>">
    </div><br>
    <button type="submit" name="kmom01" class="btn btn-default row mt-2 w-50">Kolla IP - Kmom01</button>
    <button type="submit" name="kmom02" class="btn btn-default row mt-2 w-50 btn-secondary">Kolla IP - Kmom02</button>
    </form>
</div>
