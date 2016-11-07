<?php

include(dirname(__FILE__) . '/settings.php');
include(dirname(__FILE__) . '/writers/FileDataWriter.php');

/**
 * Instructions that uses the scanner to read the data and push it to the queue
 **/

//Initial memory usage
$before_memory = memory_get_usage();

//Start time
$before        = microtime(true);
$before = microtime(true);

//Run the writer
$vdw    = new FileDataWriter();
$vdw->write($config['file_path_valid'], $config['valid_queue']);

//End time
$after = microtime(true);
echo "End time: " . date('H:i:s', $after) . "\n";
echo "Time Taken: " . ($after - $before) . "\n";

//End memory usage and total used memory
echo "Memory Used: " . (memory_get_usage() - $before_memory) . "\n";
