<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
/* echo showEnvironment(get_defined_vars(), get_defined_functions()); */

$sLocation = "";
if ($search !== null) {
    $sLocation = $search;
}
?><div class="container justify-content-center pb-2">
    <h1 class="text-center"><?= $weather ?></h1>
    <form class="form" method="post" action="<?= /** @scrutinizer ignore-call */ url("vader/location") ?>">
        <div class="form-group my-3">
            <label class="" for="location"><b>Sök på valfi Position som Adress, Land, Stad m.m</b> <small><i>ex. <u>"Valhallavägen 1 karlskrona", "Sverige eller Sweden", "ronneby"</u></i></small></label>
            <div class="d-flex">
                <input type="text" class="form-control" id="location" name="location" value="<?= $sLocation ?>">
                <button type="submit" class="btn btn-primary ml-2">Kolla Väder</button>
            </div>
        </div>
    </form>
</div>
<div class="py-2" style="margin-bottom: 150px;">
<?php if ($jsonData !== null && $locationData !== null) { ?>
    <?php if (sizeof($locationData) !== 0) { ?>
<link rel="stylesheet" href="../view/anax/v2/ip/leaflet.css">
  <h2 class="text-center">Platsinformation för <?= $search ?></h2>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
  <tr>
        <?php foreach ($locationData[0]["address"] as $key => $row) :
            echo "<th class='col'>";
            echo $key;
            echo "</th>";
        endforeach; ?>
  </tr>
  </thead>
  <tbody>
    <tr>
        <?php foreach ($locationData[0]["address"] as $row) :
            echo "<td class=''>";
            echo $row;
            echo "</td>";
        endforeach; ?> 
    </tr>
  </tbody>
</table>
</div>
<input type="hidden" id="lat" name="lat" value="<?= $locationData[0]["lat"] ?>">
<input type="hidden" id="lng" name="lng" value="<?= $locationData[0]["lon"] ?>">
<div id="map" class="rounded" style="width: 822px; height: 450px;"></div>
<script src="../view/anax/v2/ip/leaflet.js"></script>
<script type="text/javascript">

  var ipLat = document.getElementById('lat').value;
  var ipLng = document.getElementById('lng').value;

  setTimeout(() => {
    if (ipLat && ipLng) {
      var map = new L.Map('map');

      var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        osmAttrib = 'Map data &copy; 2018 OpenStreetMap contributors',
        osm = new L.TileLayer(osmUrl, { maxZoom: 30, attribution: osmAttrib });

      map.setView(new L.LatLng(ipLat, ipLng), 16).addLayer(osm);
    }
  }, 500);
</script>
<h1 class="text-center">Veckans Prognos</h1>
<p class="text-center"><?= $jsonData[0]["daily"]["summary"]?></p>
<div class="row d-flex">
        <?php foreach ($jsonData[0]["daily"]["data"] as $day) :
            $avgTemp = (round($day["temperatureHigh"]) + round($day["temperatureLow"])) / 2;
            ?>
      <div class="col col-md-4 hvr" title="<?= $day["summary"] ?>">
        <div class="card p-4 mb-4">
          <h2 class="h4 text-center"><?= date('d M', $day["time"]) ?></h2>
          <h3 class="display-4 h3 text-center"><?= $avgTemp ?>&deg;</h3>
          <div class="d-flex justify-content-around">
            <p class="lead">H <?= round($day["temperatureHigh"]) ?>&deg;</p>
            <p class="lead">L <?= round($day["temperatureLow"]) ?>&deg;</p>
          </div>
          <p class="lead m-0">Luftfuktighet <?= $day["humidity"]*100 ?>%</p>
        </div>
      </div>
        <?php endforeach; ?>
</div>
<h1 class="text-center">Väder för de senaste 30 dagarna</h1>
<div class="row d-flex">
        <?php foreach ($test as $days) :
            $avgTemp = (round($day["temperatureHigh"]) + round($day["temperatureLow"])) / 2; $day = $days["daily"]["data"][0]
            ?>
      <div class="col col-md-4 hvr" title="<?= $day["summary"] ?>">
        <div class="card p-4 mb-4">
          <h2 class="h4 text-center"><?= date('d M', $day["time"]) ?></h2>
          <h3 class="display-4 h3 text-center"><?= $avgTemp ?>&deg;</h3>
          <div class="d-flex justify-content-around">
            <p class="lead">H <?= round($day["temperatureHigh"]) ?>&deg;</p>
            <p class="lead">L <?= round($day["temperatureLow"]) ?>&deg;</p>
          </div>
          <p class="lead m-0">Luftfuktighet <?= $day["humidity"]*100 ?>%</p>
        </div>
      </div>
        <?php endforeach; ?>
</div>
    <?php } else { ?>
        <h1>Ingen träff</h1>
        <p>Kunde inte hitta platsen: "<?= $search ?>"</p>
    <?php } ?>
<?php } ?>
</div>
