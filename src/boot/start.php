<?php

require __DIR__ . '/../../vendor/autoload.php';

require 'error.php';

define('INSTALL_PATH', __DIR__ . '/../../../');
define('STORAGE_PATH', __DIR__ . '/../../storage');
define('LOG_PATH', STORAGE_PATH . '/log.txt');
define('PROGRESS_PATH', STORAGE_PATH . '/progress.json');