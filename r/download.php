<?php

/**
 * Safe file downloads + image resizing script
 * All requests to /files are sent to this script, which serves them safely as a download
 * Requests to /files/small/file.jpg or /files/medium/file.jpg are resized and cached in /cache
 * 
 * @author Tim
 */

require_once("../repository/resources/config/config.php");
$myfiles = $config['install']['file_upload_dir'];

// Get verbose feedback for debugging
$debug = true;

// Extract proper file name
$url = $_GET['f'];
$path_parts = pathinfo($myfiles.$url);
$ext = $path_parts['extension'];
$filename = $path_parts['filename'];

// 404 not found if file doesn't exist
if ( !file_exists($myfiles."$filename.$ext") ) {
	if ( $debug ) 
		die("File does not exist");
	else
		header("Location: /error/pageNotFound");
}

// Which size have we requested?
switch ( basename($path_parts['dirname']) ) {
	case 'files':
		// Simple download
		$file = $myfiles."$filename.$ext";
		break;
	case 'small':
		// Small thumbnail
		
		$file = "../cache/small/$filename.$ext";
		if ( !file_exists($file) ) {
			require_once("../phpThumb/phpthumb.class.php");
			$phpThumb = new phpThumb();
			$phpThumb->setSourceFilename($myfiles."$filename.$ext");
			$phpThumb->setParameter('w', 100);
			$phpThumb->setParameter('h', 100);
			$phpThumb->setParameter('zc', 'C');
			$phpThumb->setParameter('q', 100);
			if ( !$phpThumb->GenerateThumbnail() || !$phpThumb->RenderToFile($file) ) {
				if ($debug) {
					print_r($phpThumb->debugmessages);
					die("RESIZE ERROR");
				}
				$file = "cji/img/Kruisje.png";
			}
		}
		
		break;
	case 'medium':
		// Medium thumbnail
		
		$file = "../cache/medium/$filename.$ext";
		if ( !file_exists($file) ) {
			require_once("../phpThumb/phpthumb.class.php");
			$phpThumb = new phpThumb();
			$phpThumb->setSourceFilename($myfiles."$filename.$ext");
			$phpThumb->setParameter('h', 190);
			$phpThumb->setParameter('w', 210);
			$phpThumb->setParameter('zc', 'C');
			$phpThumb->setParameter('q', 100);
			if ( !$phpThumb->GenerateThumbnail() || !$phpThumb->RenderToFile($file) ) {
				if ($debug) {
					print_r($phpThumb->debugmessages);
					die("RESIZE ERROR");
				}
				$file = "cji/img/Kruisje.png";
			}
		}
		
		break;
	case 'large':
		// Medium thumbnail
		
		$file = "../cache/large/$filename.$ext";
		if ( !file_exists($file) ) {
			require_once("../phpThumb/phpthumb.class.php");
			$phpThumb = new phpThumb();
			$phpThumb->setSourceFilename($myfiles."$filename.$ext");
			$phpThumb->setParameter('h', 500);
			$phpThumb->setParameter('w', 929);
			$phpThumb->setParameter('zc', 'C');
			$phpThumb->setParameter('q', 100);
			if ( !$phpThumb->GenerateThumbnail() || !$phpThumb->RenderToFile($file) ) {
				if ($debug) {
					print_r($phpThumb->debugmessages);
					die("RESIZE ERROR");
				}
				$file = "cji/img/Kruisje.png";
			}
		}
		
		break;
	default:
		header("Location: /error/pageNotFound");
		die();
}

// Send the file to the browser

// Determine mime-type
$finfo = new finfo();
$fileinfo = $finfo->file($file, FILEINFO_MIME);

// Determine file name
$path_parts = pathinfo($file);
$ext = $path_parts['extension'];
$filename = $path_parts['filename'];

// Set headers
header("Content-type: $fileinfo");
header("Content-Disposition: attachment; filename=\"$filename.$ext\"");

// Send data
echo file_get_contents($file);

?>