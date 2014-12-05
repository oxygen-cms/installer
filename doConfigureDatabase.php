<?php

use Doctrine\DBAL\Exception\ConnectionException;
use Oxygen\Installer\AccountConfigurer;
use Oxygen\Installer\DatabaseConfigurer;
use Oxygen\Installer\FrameworkBooter;
use Oxygen\Installer\InvalidDatabaseException;
use Oxygen\Installer\InvalidDataException;

require 'src/boot/start.php';

$booter = new FrameworkBooter();
$app = $booter->boot();

try {
    $database = new DatabaseConfigurer($app);
    $database->configure($_POST['database'] ?: []);
} catch(InvalidDataException $e) {
    echo json_encode(['content' => $e->getErrors()->first(), 'status' => 'failed']);
    exit;
} catch(ConnectionException $e) {
    echo json_encode(['content' => 'Could not connect to database.<br>' . $e->getMessage(), 'status' => 'failed']);
    exit;
} catch(InvalidDatabaseException $e) {
    echo json_encode(['content' => $e->getMessage(), 'status' => 'failed']);
    exit;
}

echo json_encode(['content' => 'Database Configured Successfully', 'status' => 'success', 'switchToTab' => 'accounts']);