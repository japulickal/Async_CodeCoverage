<?php

class Async_SendReport {
	public static function send(Async_CodeCoverage $codeCoverage, $url) {
		echo __DIR__ . "../../../../../.";die();
		$fields = array('data' =>  base64_encode(serialize($codeCoverage)), 'Async_SendReport_Dir' => __DIR__);
		$postvars = http_build_query($fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
		$result = curl_exec($ch);
		curl_close($ch);
	}

	public static function zipDirectory() {
		// Get real path for our folder
		$rootPath = realpath(__DIR__ . "../../../../../.");

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open('file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();
	}
}