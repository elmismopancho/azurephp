<?php

require_once 'connection.php';

$currentGender = 'male';
$entities = loadUsers($currentGender);
$users = array();
foreach ($entities as $entity) {
    $user = array(
        'Id' => $entity->getRowKey(),
        'FirstName' => $entity->getPropertyValue('FirstName'),
        'LastName' => $entity->getPropertyValue('LastName'),
        'Email' => $entity->getPropertyValue('Email'),
        'Gender' => $entity->getPropertyValue('Gender'),
        'Birthday' => $entity->getPropertyValue('Birthday')->format('Y-m-d')
    );
    $users[] = $user;
}

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
                <h1>Table Service <small><a href="user.php">Create new user</a></small></h1>
            </div>
        <?php if (empty($users)): ?>
            <h3>Users table is empty</h3>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Birthday</th>
                        <th>Gender</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['Id'] ?></td>
                        <td><?= $user['FirstName'] ?></td>
                        <td><?= $user['LastName'] ?></td>
                        <td><?= $user['Email'] ?></td>
                        <td><?= $user['Birthday'] ?></td>
                        <td><?= $user['Gender'] ?></td>
                        <td>
                            <a class="btn btn-primary" href="user.php?id=<?= $user['Id'] ?>">Edit</a>
                            <a class="btn btn-danger" href="deleteuser.php?id=<?= $user['Id'] ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
            <hr />
            <a href="..">Index</a>
        </div>
    </body>
</html>