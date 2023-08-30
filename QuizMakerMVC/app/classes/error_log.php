<?php

function logError($message) {

    $logFile = '../../src/error_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $errorLogEntry = "[$timestamp] ==> $message\n";
    // Append the error message to the log file

    file_put_contents($logFile, $errorLogEntry, FILE_APPEND);
}

