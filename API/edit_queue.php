<?php
require_once __DIR__ . '/../videos/configuration.php';
header('Content-Type: application/json');

require_once __DIR__ . '/API.php';

$object = API::checkCredentials();

if(empty($_REQUEST['queue_id'])){
    $object->msg = 'queue_id is empty';
    die(json_encode($object));
}

if(!isset($_REQUEST['priority'])){
    $object->msg = 'priority is not set';
    die(json_encode($object));
}

if(!API::isAdmin()){
    $object->msg = 'Only encoder admin can change priority';
    die(json_encode($object));
}

$object->queue_id = intval($_REQUEST['queue_id']);
$encoder = new Encoder($object->queue_id);
$encoder->setPriority($_REQUEST['priority']);
$object->error = !$encoder->save();

die(json_encode($object));