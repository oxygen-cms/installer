<?php

use Oxygen\Installer\InstallationException;
use Oxygen\Installer\Installer;

require 'src/boot/start.php';

try {
    $installer = new Installer();
    $installer->run();
} catch(InstallationException $e) {
    $installer->progress->section('Failed');
    $installer->progress->notification('<h2 class="heading-gamma">Installation Failed</h2>
        <p>The installation failed. Check the log above to see what went wrong.</p>', 'failed');
    $installer->progress->stopPolling();
    exit;
}

$installer->progress->section('Complete');
$installer->progress->notification('<h2 class="heading-gamma">Installation Complete!</h2>
    <p>Oxygen is installed! But you now need to configure it...</p>
    <a href="configure.php" class="Button Button-color--blue">Configure</a>');
$installer->progress->stopPolling();

echo json_encode(['success' => true]);