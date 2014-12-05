<?php

require __DIR__ . '/../../vendor/autoload.php';

require 'error.php';

define('INSTALL_PATH', dirname($_SERVER['DOCUMENT_ROOT']));
define('STORAGE_PATH', __DIR__ . '/../../storage');
define('LOG_PATH', STORAGE_PATH . '/log.txt');
define('PROGRESS_PATH', STORAGE_PATH . '/progress.json');
define('DOWNLOAD_URL', 'https://api.github.com/repos/oxygen-cms/application/zipball');