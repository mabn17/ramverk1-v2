<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
/* echo showEnvironment(get_defined_vars(), get_defined_functions()); */

?><div class="py-4" style="margin-bottom: 150px;">
    <h2>Användning</h2>
    <p>Exempel för att kolla ip adress - ip-json/look?ip={ip adress}</p>
    <p>IPV6 <a href="<?= url("ip-json/check?ip=2001:0db8:85a3:0000:0000:8a2e:0370:7334") ?>">exempel</a> <br> IPV4 <a href="<?= url("ip-json/check?ip=127.0.0.1") ?>">exempel</a></p>
    För mer info in på <a href="<?= url("ip-json/look") ?>">Restful APIets</a> informations-sida.
</div>
