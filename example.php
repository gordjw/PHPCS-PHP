<?php

//Simulate autoload
require_once( dirname( __FILE__ ) . '/lib/phpcs.php' );

$phpcs = new PHPCS();
$report = $phpcs->generate_report();
$report->show_all_files();
