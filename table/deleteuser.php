<?php
require_once 'connection.php';

$userId = $_REQUEST['id'];
$user = loadUser($userId);
$success = false;

$confirm = false;
if (isset($_REQUEST['confirm']) and $_REQUEST['confirm'] == 1) {
    $confirm = true;
}

if ($user !== false and $confirm) {
    deleteUser($userId);
    $success = true;
}

$userName = $user->getProperty('FirstName')->getValue().' '.$user->getProperty('LastName')->getValue();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Azure PHP Demos</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Delete user</h1>
            </div>
            <?php if ($user === false): ?>
            <div class="alert alert-danger">Error, user not found</div>
            <?php elseif ($success === true): ?>
            <div class="alert alert-success">User <strong><?= $userId ?></strong> deleted</div>
            <?php else: ?>
            <p>Are you sure you want to delete user <strong><?= $userName ?> <em>(ID#<?= $userId ?>)</em></strong>?</p>
            <p><a class="btn btn-danger" href="deleteuser.php?id=<?= $userId ?>&gender=<?= $userGender ?>&confirm=1">Yes, delete user</a></p>
            <?php endif; ?>
        <hr />
            <a href="index.php">Back to home</a>
        </div>
    </body>
</html>