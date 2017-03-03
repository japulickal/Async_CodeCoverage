<?php



use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class Async_SendReport {
	public static function send(Async_CodeCoverage $codeCoverage) {
		$url = 'http://localhost:8124/upload.php';
		// $data = array('data' => base64_encode(serialize($codeCoverage)));

		// where are we posting to?

		// what post fields?
		$fields = array('data' => base64_encode(serialize($codeCoverage)));

		// build the urlencoded data
		$postvars = http_build_query($fields);

		// open connection
		$ch = curl_init();

		// set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);

		// execute post
		$result = curl_exec($ch);

		// close connection
		curl_close($ch);

		echo "Completed";

	}
}