<?php 




date_default_timezone_set('UTC');



require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload



$test = new \Async_CodeCoverage;


$newCoverage = unserialize(file_get_contents("/tmp/coverageDataSerialized_new.bin"));
$newCoverage->reProcessData();


$randValue = uniqid('report', true);

// // $writer = new \PHP_CodeCoverage_Report_Clover;
// // $writer->process($newCoverage, __DIR__.'/Report/coverage_'.$randValue.'.xml');

$writer = new \PHP_CodeCoverage_Report_HTML;
$writer->process($newCoverage,  __DIR__.'/Report/coverage_html_'.$randValue);