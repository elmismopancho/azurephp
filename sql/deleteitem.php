<?php
require_once 'connection.php';

$itemId = $_REQUEST['id'];
$item = loadItem($itemId);
$success = false;

if ($item !== false and $_REQUEST['confirm'] == 1) {
    deleteItem($itemId);
    $success = true;
}

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
                <h1>Delete item</h1>
            </div>
            <?php if ($item === false): ?>
            <div class="alert alert-danger">Error, item not found</div>
            <?php elseif ($success === true): ?>
            <div class="alert alert-success">Item <strong><?= $item['name'] ?></strong> deleted</div>
            <?php else: ?>
            <p>Are you sure you want to delete item <strong><?= $item['name'] ?></strong>?</p>
            <p><a class="btn btn-danger" href="deleteitem.php?id=<?= $item['id'] ?>&confirm=1">Yes, delete item</a></p>
            <?php endif; ?>
        <hr />
            <a href="index.php">Back to home</a>
        </div>
    </body>
</html>