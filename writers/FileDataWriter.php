<?php

include(dirname(__FILE__) . '/DataWriter.php');

/**
 * Writer that accesses data from a queue and write it to a file
 **/
class FileDataWriter implements DataWriter
{
    //read the data off the queue and write it to a file
    public function write($destination, $queue)
    {
        $data_queue   = msg_get_queue($queue);
        $msg_type     = NULL;
        $msg          = NULL;
        $max_msg_size = 4096;
        if (file_exists($destination)) {
            $file = new SplFileObject($destination, "a");
        } else {
            $file = new SplFileObject($destination, "w");
        }
        
        //Check if file is writable
        if ($file->isWritable()) {
            while (msg_receive($data_queue, 1, $msg_type, $max_msg_size, $msg, true)) {
                echo "Data polled from queue: {$msg} \n";
                try {
                    $written = $file->fwrite($msg . "\n");
                }
                catch (Exception $ex) {
                    echo "Error writing to the file: {$ex} \n";
                }
                $msg_type = NULL;
                $msg      = NULL;
            }
        } else {
            echo "The file is not writable \n";
        }
    }
}