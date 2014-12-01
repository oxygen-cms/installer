<?php

use Illuminate\Filesystem\Filesystem;

require 'src/boot/start.php';

if(!file_exists(LOG_PATH) || !file_exists(PROGRESS_PATH)) {
    echo json_encode(['notFound' => true]);
} else {

    $log = file_get_contents(LOG_PATH);
    $response = json_decode(file_get_contents(PROGRESS_PATH), true);
    $response['log'] = $log;

    if(isset($response['stopPolling']) && $response['stopPolling'] === true) {
        $files = new Filesystem();
        $files->cleanDirectory(STORAGE_PATH);
    }

    echo json_encode($response);

}
