<?php

/**
 * Scanner interface to support different data sources
 */
interface DataScanner
{
    //Start and apply filter to the data source
    public function start($source, $filter);

    //iterate and process the data from the source
    public function process($iterator);
}