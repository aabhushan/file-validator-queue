<?php

include(dirname(__FILE__) . '/../filters/DataFilterIterator.php');
include(dirname(__FILE__) . '/DataScanner.php');

/**
 * Data Scanner for files that support filtering and offering to the queue
 **/
class FileScanner implements DataScanner
{
    
    private $valid_queue;
    private $invalid_queue;
    private $config;
    
    
    public function __construct()
    {
        $this->config = $GLOBALS['config'];
    }
    
    //start the scanner by initating the file source and filter
    public function start($source, $filter)
    {
        try {
            $filter    = $this->config['valid_filter'];
            $delimiter = $this->config['delimiter'];
            $itr       = new SplFileObject($source);
            $itr->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
            $itr->setCsvControl($delimiter);
            if ($itr->isReadable()) {
                $header = $itr->fgetcsv();
                $file   = new DataFilterIterator($itr, $filter, $header);
                $this->process($file);
            } else {
                echo "The file is not readable \n";
            }
        }
        catch (Exception $ex) {
            echo "Error scanning the file: {$ex} \n";
        }
    }
    
    //scanner function that iterates and processes the data from the file
    public function process($iterator)
    {
        while (!$iterator->eof()) {
            $line    = $iterator->fgetcsv();
            $message = $line[0];
            if ($iterator->accept()) {
                $this->offerValid($message);
            } else {
                $this->offerInvalid($message);
            }
        }
    }
    
    //offer data column to the invalid queue
    public function offerInvalid($message)
    {
        $this->invalid_queue = msg_get_queue($this->config['invalid_queue']);
        try {
            if (msg_send($this->invalid_queue, 1, $message)) {
                echo "Data offered to invalid queue: {$message} \n";
                msg_stat_queue($this->invalid_queue);
            } else {
                echo "Could not add data to the invalid queue \n";
            }
        }
        catch (Exception $ex) {
            echo "Error sending the data to the invalid queue: {$ex} \n";
        }
    }
    
    //offer data column to the invalid queue
    public function offerValid($message)
    {
        $this->valid_queue = msg_get_queue($this->config['valid_queue']);
        try {
            if (msg_send($this->valid_queue, 1, $message)) {
                echo "Data offered to valid queue: {$message}\n";
                msg_stat_queue($this->valid_queue);
            } else {
                echo "Could not add data to the valid queue \n";
            }
        }
        catch (Exception $ex) {
            echo "Error sending the data to the valid queue: {$ex} \n";
        }
    }
}