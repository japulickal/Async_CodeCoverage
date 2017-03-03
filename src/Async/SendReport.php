<?php



use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class Async_SendReport {
	public static function send(Async_CodeCoverage $codeCoverage, String $url) {
		$url = 'http://localhost:8124/upload.php';
		$fields = array('data' => base64_encode(serialize($codeCoverage)));
		$postvars = http_build_query($fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
		$result = curl_exec($ch);
		curl_close($ch);
	}
}