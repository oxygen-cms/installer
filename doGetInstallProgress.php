<?php

require 'src/start.php';

$logPath = STORAGE_PATH . '/log.txt';
$progressPath = STORAGE_PATH . '/progress.json';

if(!file_exists($logPath) || !file_exists($progressPath)) {
    echo json_encode(['notification' => ['message' => 'Installation Not Started Yet', 'status' => 'failed']]);
} else {

    $log = file_get_contents($logPath);
    $response = json_decode(file_get_contents($progressPath), true);
    $response['log'] = $log;

    if(isset($response['stopPolling']) && $response['stopPolling'] === true) {
        unlink(STORAGE_PATH . '/log.txt');
        unlink(STORAGE_PATH . '/progress.json');
    }

    echo json_encode($response);

}
