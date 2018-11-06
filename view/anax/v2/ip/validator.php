<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
/* echo showEnvironment(get_defined_vars(), get_defined_functions()); */

?><div class="py-4" style="margin-bottom: 150px;">
<h1>Validera Ip adresser</h1>
<p><?= $ip ?></p>
<form class="form-inline w-100" method="post" action="<?= url("ip/update") ?>">
  <div class="form-group w-100">
    <label class="sr-only" for="ip">ip address:</label>
    <input type="ip" class="form-control w-100" name="ip" id="ip">
  </div><br>
  <button type="submit" class="btn btn-default row mt-2 w-75">Kolla IP</button>
</form>
<p>Exempel på ipv6: 2001:0db8:85a3:0000:0000:8a2e:0370:7334<br>Exempel på ipv4 127.0.0.1</p>
</div>

