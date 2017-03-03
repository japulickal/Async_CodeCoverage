
<?php


date_default_timezone_set('UTC');
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'jose', 'jose');
$channel = $connection->channel();


echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg){
  echo " [x] Received Serialized object processing data\n";
echo "=========" . strlen($msg->body). "=====\n";
  $newCoverage = unserialize($msg->body);
$newCoverage->reProcessData();


$randValue = uniqid('report', true);

// // $writer = new \PHP_CodeCoverage_Report_Clover;
// // $writer->process($newCoverage, __DIR__.'/Report/coverage_'.$randValue.'.xml');

$writer = new \PHP_CodeCoverage_Report_HTML;
$writer->process($newCoverage,  __DIR__.'/Report/coverage_html_'.$randValue);




  echo " [x] Done", "\n";
//  $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue_jose', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();