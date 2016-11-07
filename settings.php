<?php

/**
 * Settings that includes filter for the data validation and queues
 */

//Global configuration variable, ini file could in addition to this be used as per the need
global $config;

//define valid queue id
define('VALID_QUEUE', 21671);
//define invalid queue id
define('INVALID_QUEUE', 21672);

//File path for the input file
$config['file_path']    = 'clips.csv';
//Delimeter for the input file
$config['delimiter']    = ',';
//Filter for validation
$config['valid_filter'] = array(
    'privacy' => array(
        'value' => 'anybody',
        'condition' => '=='
    ),
    'total_likes' => array(
        'value' => 10,
        'condition' => '>'
    ),
    'total_plays' => array(
        'value' => 200,
        'condition' => '>'
    ),
    'title' => array(
        'length' => 30,
        'condition' => '<'
    )
);

//File path for valid output
$config['file_path_valid']   = 'valid.csv';
//File path for invalid output
$config['file_path_invalid'] = 'invalid.csv';

//valid  queue
$config['valid_queue']   = VALID_QUEUE;
//Invalid queue
$config['invalid_queue'] = INVALID_QUEUE;