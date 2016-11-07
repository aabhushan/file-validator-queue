<?php

include(dirname(__FILE__) . '/settings.php');
include(dirname(__FILE__) . '/scanners/FileScanner.php');

/**
 * Instructions that uses scanner to read the data and push it to the queue
 **/

//Initial memory usage
$before_memory = memory_get_usage();

//Start time
$before        = microtime(true);

//Run the scanner
$sc            = new FileScanner();
$sc->start($config['file_path'], $config['valid_filter']);

//End time
$after = microtime(true);
echo "Time Taken: " . ($after - $before) . "\n";

//End memory usage and total used memory
echo "Memory Used: " . (memory_get_usage() - $before_memory) . "\n";
