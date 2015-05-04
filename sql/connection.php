<?php

function connect() {
	$conn = null;
	try {
		$db = getenv('DATABASE_SERVER');
		$user = getenv('DATABASE_USER');
		$pass = getenv('DATABASE_PASSWORD');

	    $conn = new PDO ( $db, $user, $pass);
	    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	} catch ( PDOException $e ) {
	    //Error, debo logear
	    error_log("Error creating connection: ".print_r($e, true));
	}
	return $conn;
}

function createTable() {
	$conn = connect();
	$sql = "CREATE TABLE items(
			id INT NOT NULL IDENTITY(1,1) 
			PRIMARY KEY(id),
			name VARCHAR(30),
			date DATETIME)";
	try{
		$conn->query($sql);
		return true;
	}
	catch(Exception $e){
		return false;
	}
}

function dropTable() {
	$conn = connect();
	$sql = "DROP TABLE items";
	try{
		$conn->query($sql);
		return true;
	}
	catch(Exception $e){
		return false;
	}
}

function loadAll() {
	$conn = connect();
	$sql = "SELECT * FROM items";
	$stmt = $conn->query($sql);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function loadItem($item_id) {
	$conn = connect();
	$sql = "SELECT * FROM items WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(1, $item_id);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addItem($name) {
	$conn = connect();
	$date = date('Y-m-d H:i:s');
	$sql = "INSERT INTO items (name, date) VALUES (?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(1, $name);
	$stmt->bindValue(2, $date);
	$stmt->execute();
}

function updateItem($item_id, $name) {
	$conn = connect();
	$sql = "UPDATE items SET name = ?, date = ? WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(1, $name);
	$stmt->bindValue(2, date('Y-m-d H:i:s'));
	$stmt->bindValue(3, $item_id);
	$stmt->execute();
}

function deleteItem($item_id) {
	$conn = connect();
	$sql = "DELETE FROM items WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(1, $item_id);
	$stmt->execute();
}