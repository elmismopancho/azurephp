<?php

require_once 'connection.php';

$items = loadAll();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Relational Database CRUD</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Relational Database CRUD <small><a href="additem.php">Create an item</a></small></h1>
            </div>
            <?php if (count($items) > 0): ?>
            <table class="table">
                <thead>
                    <th>Id</th><th>Name</th><th>Created</th><th></th>
                </thead>
                <tbody>
                    <?php foreach ($items as $row) : ?>
                    <tr>
                        <td><strong><?= $row['id'] ?></strong></td>
                        <td><?= $row['name'] ?></td>
                        <td><em><?= $row['date'] ?></em></td>
                        <td>
                            <a class="btn btn-primary" href="edititem.php?id=<?= $row['id'] ?>">Edit</a>
                            <a class="btn btn-danger" href="deleteitem.php?id=<?= $row['id'] ?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <h3>Items table is empty</h3>
            <?php endif; ?>
        </div>
    </body>
</html>