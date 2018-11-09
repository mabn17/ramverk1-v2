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
<h1>Validera Ip adresser</h1>
<form class="form-inline w-100" method="post" action="<?= url("validate/update") ?>">
  <div class="form-group w-100">
    <label class="sr-only" for="ip">ip address:</label>
    <input type="ip" class="form-control w-100" name="ip" id="ip" value="<?= $myIp ?>">
  </div><br>
  <button type="submit" name="kmom01" class="btn btn-default row mt-2 w-50">Kolla IP - Kmom01</button>
  <button type="submit" name="kmom02" class="btn btn-default row mt-2 w-50 btn-secondary">Kolla IP - Kmom02</button>
</form>
<p>Exempel på ipv6: 2001:0db8:85a3:0000:0000:8a2e:0370:7334<br>Exempel på ipv4 127.0.0.1</p>
<p><?= $ip ?></p>
<?php if ($apiRes !== "") { ?>
<link rel="stylesheet" href="../view/anax/v2/ip/leaflet.css">
<table class="table">
  <thead>
    <tr>
      <th scope="col">Land</th>
      <th scope="col">Huvudstad</th>
      <th scope="col">Stad</th>
      <th scope="col">Ip adress</th>
      <th scope="col">Typ av ip adress</th>
      <th scope="col">Latitude</th>
      <th scope="col">Longitude</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?= $apiRes["country_name"] ?></td>
      <td><?= $apiRes["location"]["capital"] ?></td>
      <td><?= $apiRes["city"] ?></td>      
      <td><?= $apiRes["ip"] ?></td>
      <td><?= $apiRes["type"] ?></td>
      <td id="lat"><?= $apiRes["latitude"] ?></td>
      <td id="lng"><?= $apiRes["longitude"] ?></td>
    </tr>
  </tbody>
</table>
<div id="map" style="width: 800px; height: 450px;"></div>
<script src="../view/anax/v2/ip/leaflet.js"></script>
<script type="text/javascript">

  var ipLat = document.getElementById('lat').innerText;
  var ipLng = document.getElementById('lng').innerText;

  setTimeout(() => {
    if (ipLat && ipLng) {
      var map = new L.Map('map');

      var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        osmAttrib = 'Map data &copy; 2018 OpenStreetMap contributors',
        osm = new L.TileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib });

      map.setView(new L.LatLng(ipLat, ipLng), 13).addLayer(osm);
    }
  }, 500);

</script>
<?php } ?>
</div>
