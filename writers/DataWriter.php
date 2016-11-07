<?php

/**
 * Writer interface to obtain data from a queue and write to the destination
 **/
interface DataWriter
{
    //read the data off the queue and write it to the destination
    public function write($destination, $queue);
    
}