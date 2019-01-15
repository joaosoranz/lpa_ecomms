<?php

set_exception_handler('globalExceptionHandler');
set_error_handler('globalErrorHandler');

function globalExceptionHandler($exception) {
    writeLog("Exception!!! Message: [".$exception->getMessage()."]. Stack trace: [".$exception->getTraceAsString()."]. File: [".$exception->getFile()."]. Line: [".$exception->getLine()."].");

    throw $exception; 
}

function globalErrorHandler($errno, $errstr, $errfile, $errline) {
    //throw $exception; 
}

?>
