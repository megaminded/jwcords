<?php
include('config.php');
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = $_POST['congregation'];
    $db = new DBConnection();
    $data = $db->congregation($query);
} else {
    $data = NULL;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row mt-4">
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
                            <button type="submit" class="btn btn-primary">DOWNLOAD</button>
                            <a href="/" class="btn btn-default">EXIT</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-8">
                <?php if ($data) : ?>
                    <h1><?= $query; ?></h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Family Head</th>
                                <th>Longitude</th>
                                <th>Latitude</th>
                                <th>Publishers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $data->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <b class="d-block"><?= strtoupper($row['name']) ?></b>
                                        <small><?= $row['phone']; ?></small>
                                    </td>
                                    <td><?= $row['longitude'] ?></td>
                                    <td><?= $row['latitude'] ?></td>
                                    <td><?= $row['publishers'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <!-- FALSE -->
                <?php endif ?>
            </div>
        </div>
    </div>
</body>

</html>