<?php

use Oxygen\Installer\DatabaseConfigurer;
use Oxygen\Installer\FrameworkBooter;

require 'src/boot/start.php';

$booter = new FrameworkBooter();
$app = $booter->boot();

$configurer = new DatabaseConfigurer($app);
$configurer->configure($_POST['database'] ?: []);