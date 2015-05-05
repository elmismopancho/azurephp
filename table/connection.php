<?php

set_include_path( get_include_path() . PATH_SEPARATOR . __DIR__ . '\\pear\\');

require_once 'WindowsAzure/WindowsAzure.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Table\Models\Entity;
use WindowsAzure\Table\Models\EdmType;

function tableService() {
	$storageUsername = getenv('STORAGE_USERNAME');
	$storageKey = getenv('STORAGE_KEY');
	$connectionString = "DefaultEndpointsProtocol=http;AccountName=$storageUsername;AccountKey=$storageKey";

	$tableRestProxy = ServicesBuilder::getInstance()->createTableService($connectionString);

	createTable($tableRestProxy);

	return $tableRestProxy;
}

function createTable($tableRestProxy) {
	try {
	    $tableRestProxy->createTable("users");
	    return true;
	}
	catch(ServiceException $e){
	    $code = $e->getCode();
	    if ($code == 409) {
	        return true;
	    } else {
	    	trigger_error($e->getMessage(), E_USER_ERROR);
	        return false;
	    }
	}
}

function loadUser($id) {
	$tableRestProxy = tableService();
	try {
	    $result = $tableRestProxy->getEntity("users", "users_partition", $id);
	}
	catch(ServiceException $e){
	    trigger_error($e->getMessage(), E_USER_ERROR);
	    return false;
	}
	return $result->getEntity();
}

function loadUsers($gender = '') {
	$tableRestProxy = tableService();

	$filter = "";
	try {
	    $result = $tableRestProxy->queryEntities("users", $filter);
	}
	catch(ServiceException $e){
	    trigger_error($e->getMessage(), E_USER_ERROR);
	    return false;
	}

	return $result->getEntities();
}

function insertUser($user, $uid = "") {
	$tableRestProxy = tableService();

	if ($uid == "") {
		$uid = uniqid();
	}

	$entity = new Entity();
	$entity->setPartitionKey('users_partition');
	$entity->setRowKey($uid);

	$entity->addProperty("FirstName", EdmType::STRING, $user['FirstName']);
	$entity->addProperty("LastName", EdmType::STRING, $user['LastName']);
	$entity->addProperty("Email", EdmType::STRING, $user['Email']);
	$entity->addProperty("Gender", EdmType::STRING, $user['Gender']);
	$entity->addProperty("Birthday", EdmType::DATETIME, new DateTime($user['Birthday']));

	try{
	    $tableRestProxy->insertOrMergeEntity("users", $entity);
	    return true;
	}
	catch(ServiceException $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
	    return false;
	}
}

function deleteUser($id) {
	$tableRestProxy = tableService();
	try {
	    $result = $tableRestProxy->deleteEntity("users", "users_partition", $id);
	}
	catch(ServiceException $e){
	    trigger_error($e->getMessage(), E_USER_ERROR);
	    return false;
	}
	return true;
}
