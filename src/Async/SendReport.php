<?php

class Async_SendReport {
	public static function send(Async_CodeCoverage $codeCoverage, $url) {

		$randZipPathValue = uniqid('report', true);

		$zipFilePath = "/tmp/file_".$randZipPathValue.".zip"

		zipDirectory($zipFilePath)

		$zipData = file_get_contents($zipFilePath);


		$fields = array('data' =>  base64_encode(serialize($codeCoverage)), 'application_base_dir' => __DIR__ . "/../../../../../.", 'code_zip' => base64_encode($zipData));
		$postvars = http_build_query($fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
		$result = curl_exec($ch);
		curl_close($ch);
	}

	public static function zipDirectory($zipFilePath) {
		// Get real path for our folder
		$rootPath = realpath(__DIR__ . "/../../../../../.");

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

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

		        if (strpos($filePath, ".php") != false) {
		        // Add current file to archive
		        	$zip->addFile($filePath, $relativePath);
		       	}
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();
	}
}