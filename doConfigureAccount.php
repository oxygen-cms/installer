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
    $accounts = new AccountConfigurer($app);
    $accounts->configure($_POST['account'] ?: []);
} catch(InvalidDataException $e) {
    echo json_encode(['content' => $e->getErrors()->first(), 'status' => 'failed']);
    exit;
}

echo json_encode(['redirect' => 'done.php']);