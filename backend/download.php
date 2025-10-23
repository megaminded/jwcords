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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-12 col-md-4">
                <h1>Download locations</h1>
                <form action="" method="post">
                    <div class="form-group my-4">
                        <label for="">Congregation</label>
                        <select class="form-control" name="congregation" id="">
                            <?php foreach ($congregations as $congregation) : ?>
                                <option value="<?= $congregation['code'] ?>"><?= $congregation['name'] ?></option>
                            <?php endforeach ?>
                        </select>

                        <div class="form-group my-3">
                            <button type="submit" class="btn btn-primary">DOWNLOAD</button>
                            <a href="/" class="btn btn-default">EXIT</a>
                        </div>
                    </div>
                </form>
                <?php include('links.php'); ?>
            </div>
            <div class="col-sm-12 col-md-8">
                <?php if ($data) : ?>
                    <h1 class="text-uppercase">Publisher Locations</h1>
                    <h2>Name of Congregation: <?= $query; ?></h2>
                    <div class="table-responsive">
                        <table class="list table table-bordered ">
                            <thead>
                                <tr class="table-warning">
                                    <th>Family Head</th>
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                    <th>Publishers</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $publishers = 0; ?>
                                <?php $index = 0; ?>
                                <?php while ($row = $data->fetch_assoc()): ?>
                                    <?php $count = is_numeric($row['publishers']) ? $row['publishers'] : 0 ?>
                                    <?php $publishers = $publishers + $count;  ?>
                                    <?php $index++; ?>
                                    <tr>
                                        <td class="text-danger">
                                            <b class="d-block text-capitalize"><?= strtoupper($row['name']) ?></b>
                                            <small><?= $row['phone']; ?></small>
                                        </td>
                                        <td class="text-danger"><?= $row['longitude'] ?></td>
                                        <td class="text-danger"><?= $row['latitude'] ?></td>
                                        <td class="text-danger"><?= $row['publishers'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <table>
                        <tr>
                            <td colspan="3">Total Family:</td>
                            <td><b><?= $index; ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="3">Total Publishers:</td>
                            <td><b><?= $publishers; ?></b></td>
                        </tr>
                    </table>
                    <script>
                        let table = new DataTable('.list', {
                            paging: false
                        });
                    </script>
                <?php else : ?>
                    <!-- FALSE -->
                <?php endif ?>
            </div>
        </div>
    </div>
</body>

</html>