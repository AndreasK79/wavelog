<?php

// Function to check if a PHP extension is installed
function isExtensionInstalled($extensionName) {
	return in_array($extensionName, get_loaded_extensions());
}

// function to switch the language based on the user selection
function switch_lang($new_language) {
	global $gt_conf;
	setcookie($gt_conf['lang_cookie'], $new_language);
}

// check if page is called with https or not
function is_https() {
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
		return true;
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
		return true;
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') {
		return true;
	}
	return false;
}

// Folder permission checks
function is_really_writable($path) {

	// Check if the folder exists
	if (!file_exists($path)) {
		log_message('error', 'is_really_writable(): File "'.$path.'" does not exist.');
		return false;
	}

	// Check if the folder is writable
	try {
		if (is_writable($path)) {
			// Check if the subdirectories are writable (recursive check)
			$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
			foreach ($iterator as $item) {
				if ($item->isDir() && basename($item->getPathName()) != '..') {
					if (!is_writable($item->getRealPath())) {
						return false;
					}
				}
			}

			return true;
		}
	} catch (Exception $e) {
		log_message('error', 'is_really_writable(): Something went wrong while testing write permissions.');
		return false;
	}

	return false;
}

function verify_log() {
    global $logfile;

    if (!file_exists($logfile)) {
        if (touch($logfile)) {
            if(is_writable($logfile)) {
				$log_header = "Wavelog Installer Debug Log\n-------\n\n";
				file_put_contents($logfile, $log_header, FILE_APPEND);
				return true;
			} else {
				return false;
			}
        } else {
            return false;
        }
    } else {
        return is_writable($logfile);
    }
}

// Function to read the debug logfile
function read_logfile() {
	if (verify_log()) {
		global $logfile;
		$file_content = file_get_contents($logfile);
		echo $file_content;
	} else {
        echo "Log file is not available.";
    }
}

// Function to log messages in the installer logfile
function log_message($level, $message) {
	if (verify_log()) {
		global $logfile;
		$level = strtoupper($level);
		$timestamp = date("Y-m-d H:i:s");
		$logMessage = $level . " - " . $timestamp . " --> " . $message . PHP_EOL;
		file_put_contents($logfile, $logMessage, FILE_APPEND);
	} else {
        echo "Log file is not available or not writable.";
    }
}

// Custom error handler
function customError($errno, $errstr, $errfile, $errline) {
    $message = "[$errno] $errstr in $errfile on line $errline";
    log_message('error', $message);
}