#Data Filter Application#
A PHP solution to validate data from a file using a filter and writing valid and invalid outputs to a file. It uses the PHP Semaphores (message queue) to handle read and write asynchronously.

###Components###

1. File scanner job
	`read_job.php` reads the file and filters valid and invalid ids to two queues. It can be a setup using cron to run continuously/in intervals or just once as per the data feed situation.

2. Valid File writer job
	`valid_write_job.php` takes the valid ids from the valid queue and writes them to the valid data file. It can be setup using cron to run continuously/in intervals or just once until the queue is empty as per the data feed situation.

3. Invalid File writer job
	`invalid_write_job.php` takes the invalid ids from the invalid queue and writes them to the invalid data file. It can be setup using cron to run continuously/in intervals or just once until the queue is empty as per the data feed situation.

###Demo Example###

1. Open three terminals and `cd` to the `file-validator-queue` directory i.e the directory containing the component files.

2. Run the two writer jobs in separate terminals using `php  -f valid_write_job.php` and `php -f invalid_write_job.php`.

3. Run the reader job in the third terminal using `php -f read_job.php`.

5. End the running writer job using `Ctrl + C` while they are waiting to get more messages in the queue. They can be kept running in case the data file is being appended continuously and the reader job is running repeatedly.

6. The output file of valid data is `valid.csv` and for invalid data is `invalid.csv`. Check the demo video: `demo/execution_demo.mov`

###Next improvements###
* Write tests
* Data in the queue could be data objects in situations where output is more than just 1 column. Eg. A case where output is not just 'id' but 'title' or more columns of `clips.csv` data.
* Test with massive data sets (Currently tested with about 10MB file).
* Code could have improvements. Yet to go deeper into implementation details and time complexities for PHP.
