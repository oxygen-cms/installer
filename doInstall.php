<?php

use Oxygen\Installer\Installer;

require 'src/boot/start.php';

$installer = new Installer();
$installer->run();

echo json_encode(['success' => true]);