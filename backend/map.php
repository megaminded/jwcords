<?php
include('config.php');
include('db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = $_POST['congregation'] ?? "GRA";
    $db = new DBConnection();
    $data = $db->congregation($query);

    $items = [];
    while ($row = $data->fetch_assoc()) {
        array_push($items, [
            "name" => $row['name'],
            "lat" => $row['latitude'],
            "lng" => $row['longitude']
        ]);
    }
    $markers = json_encode($items, JSON_PRETTY_PRINT);
} else {
    $data = NULL;
}


?>

<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <form action="" method="post">
                    <div class="form-group my-4">
                        <label for="">Congregation</label>
                        <select class="form-control" name="congregation" id="">
                            <?php foreach ($congregations as $name => $congregation) : ?>
                                <option value="<?= $name ?>"><?= $congregation ?></option>
                            <?php endforeach ?>
                        </select>

                        <div class="form-group my-3">
                            <button type="submit" class="btn btn-primary">PREVIEW</button>
                            <a href="/" class="btn btn-default">EXIT</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-12">
                <?php if ($data) : ?>
                    <h1>Locations of <?= $congregation; ?> members</h1>
                    <div id="map" style="height: 440px; border: 1px solid #AAA;"></div>

                    <script>
                        const markers = <?= $markers; ?>;
                        console.log(markers);

                        var map = L.map('map', {
                            center: [20.0, 5.0],
                            minZoom: 3,
                            zoom: 2
                        });

                        for (var i = 0; i < markers.length; ++i) {
                            L.marker([markers[i].lat, markers[i].lng])
                                .bindPopup('<a href="' + markers[i].url + '" target="_blank" rel="noopener">' + markers[i].name + '</a>')
                                .addTo(map);
                        }

                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map);
                    </script>
                <?php else : ?>

                <?php endif ?>
            </div>
        </div>
    </div>
</body>

</html>