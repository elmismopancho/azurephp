<?php
require_once 'connection.php';

$success = false;

$isCreate = true;
$user = array(
    'FirstName' => '',
    'LastName'  => '',
    'Email'     => '',
    'Birthday'  => '',
    'Gender'    => ''
);

$userId = "";
if (isset($_REQUEST['id'])) {
    $userId = $_REQUEST['id'];
    $isCreate = false;
}

if (isset($_POST['postback'])) {

    $birthday = date(DateTime::ATOM, strtotime($_POST['Birthday']));

    $user = array(
        'FirstName' => $_POST['FirstName'],
        'LastName'  => $_POST['LastName'],
        'Email'     => $_POST['Email'],
        'Gender'    => $_POST['Gender'],
        'Birthday'  => $birthday
    );

    $success = insertUser($user, $userId);

} else if ($userId != "") {
    $entity = loadUser($_REQUEST['id']);
    $user = array(
        'FirstName' => $entity->getPropertyValue('FirstName'),
        'LastName'  => $entity->getPropertyValue('LastName'),
        'Email'     => $entity->getPropertyValue('Email'),
        'Birthday'  => $entity->getPropertyValue('Birthday')->format('Y-m-d'),
        'Gender'    => $entity->getPropertyValue('Gender')
    );
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
            <?php if ($isCreate): ?>
                <h1>New User</h1>
            <?php else: ?>
                <h1>Edit User</h1>
            <?php endif; ?>
            </div>
        <?php if (isset($_POST['postback'])): ?>
            <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                <?php if ($isCreate): ?>
                    New user created
                <?php else: ?>
                    User updated
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-danger" role="alert">
                Error creating user
            </div>
            <?php endif; ?>
        <?php else: ?>
            <form method="post" action="user.php">
            	<input type="hidden" name="postback" value="1" />
            	<div class="form-group">
                    <label class="control-label" for="FirstName">First Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="FirstName" 
                        name="FirstName" 
                        value="<?= $user['FirstName'] ?>" 
                        placeholder="Enter first name" 
                        required="required"/>
                </div>
                <div class="form-group">
                    <label class="control-label" for="LastName">Last Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="LastName" 
                        name="LastName" 
                        value="<?= $user['LastName'] ?>" 
                        placeholder="Enter first name" 
                        required="required"/>
                </div>
                <div class="form-group">
                    <label class="control-label" for="Email">Email</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="Email" 
                        name="Email" 
                        value="<?= $user['Email'] ?>" 
                        placeholder="Enter email" 
                        required="required"/>
                </div>
                <div class="form-group">
                    <label class="control-label" for="Birthday">Birthday</label>
                    <input 
                        type="date" 
                        class="form-control" 
                        id="Birthday" 
                        name="Birthday" 
                        value="<?= $user['Birthday'] ?>" 
                        placeholder="Enter your birthday" 
                        required="required"/>
                </div>
                <div class="form-group">
                    <label class="control-label" for="Gender">Gender</label>
                    <select class="form-control" id="Gender" name="Gender">
                    	<option value="Male" <?= $user['Gender'] == 'Male'?'selected="selected"':'' ?>>Male</option>
                    	<option value="Female" <?= $user['Gender'] == 'Female'?'selected="selected"':'' ?>>Female</option>
                    </select>
                </div>
            <?php if ($isCreate): ?>
                <button type="submit" class="btn btn-primary">Create</button>
            <?php else: ?>
                <input type="hidden" name="id" value="<?= $userId ?>" />
                <button type="submit" class="btn btn-primary">Edit</button>
            <?php endif; ?>
            </form>
        <?php endif; ?>
            <hr />
            <a href="index.php">Back to home</a>
        </div>
    </body>
</html>