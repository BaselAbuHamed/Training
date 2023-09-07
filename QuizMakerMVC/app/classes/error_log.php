<?php
/*The logError function you've provided is indeed useful for logging error messages
 and debugging PHP code by printing values to a file. You can use this function
 to log any information you want during debugging to help you trace issues
in your PHP application.*/
function logError($message) {

    $logFile = '../../src/error_log.txt';
    $timestamp = date('Y-m-d H:i:s');

    // Create a log entry by combining the timestamp and the provided error message.
    $errorLogEntry = "[$timestamp] ==> $message\n";

    // Append the error message to the log file
    // (FILE_APPEND flag ensures appending rather than overwriting).
    file_put_contents($logFile, $errorLogEntry, FILE_APPEND);
}