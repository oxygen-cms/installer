<?php

$debug = isset($_REQUEST['debug']);
if ($debug) {
    ini_set('display_errors', 1);
    error_reporting(1);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

set_error_handler('handleError');
register_shutdown_function('handleFatalError');

function handleError($errorLevel, $errorMessage, $errorFile, $errorLine, $errorContext) {
    switch ($errorLevel) {
        case E_ERROR:
        case E_CORE_ERROR:
        case E_COMPILE_ERROR:
        case E_PARSE:
            $type = 'Fatal';
            break;
        case E_USER_ERROR:
        case E_RECOVERABLE_ERROR:
            $type = 'Error';
            break;
        case E_WARNING:
        case E_CORE_WARNING:
        case E_COMPILE_WARNING:
        case E_USER_WARNING:
            $type = 'Warn';
            break;
        case E_NOTICE:
        case E_USER_NOTICE:
            $type = 'Info';
            break;
        case E_STRICT:
            $type = 'Debug';
            break;
        default:
            $type = 'Unknown';
    }

    displayError($errorMessage, $errorFile, $errorLine, $type);
}

function handleFatalError() {
    $error = error_get_last();
    if($error['type'] == 1) {
        displayError($error['message'], $error['file'], $error['line'], 'Fatal');
    }
}

function displayError($message, $file, $line, $type) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    $message = htmlspecialchars_decode(strip_tags($message));
    echo $message . ' in file <code>' . $file . '</code> on line <code>' . $line . '</code> (Type: ' . $type . ')';
    exit;
}