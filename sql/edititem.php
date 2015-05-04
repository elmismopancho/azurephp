<?php
require_once 'connection.php';

$itemId = $_REQUEST['id'];
$item = loadItem($itemId);
$success = false;
$name_error = false;
if ($item !== false and isset($_POST['postback'])) {
    $item['name'] = $_POST['itemName'];
    if ($item['name'] == "" or strlen($item['name']) > 30) {
        $name_error = true;
    } else {
        updateItem($itemId, $item['name']);
        $success = true;
    }
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
                <h1>Edit item <strong><?= $item['name'] ?></strong></h1>
            </div>
            <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                Item <strong><?= $name ?></strong> updated
            </div>
            <?php endif; ?>
            <?php if ($item === false): ?>
            <div class="alert alert-danger">Error, item not found</div>
            <?php else: ?>
            <form method="post" action="edititem.php?id=<?= $item['id'] ?>">
                <input type="hidden" name="postback" value="1" />
                <div class="form-group <?php echo $name_error?'has-error has-feedback':'' ?>">
                    <label class="control-label" for="itemName">Item name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="itemName" 
                        name="itemName" 
                        value="<?= $item['name'] ?>"
                        maxlength="30" />
                    <?php if ($name_error): ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
            <?php endif; ?>
            <hr />
            <a href="index.php">Back to home</a>
        </div>
    </body>
</html>