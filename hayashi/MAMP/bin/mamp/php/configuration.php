<?php
	mb_internal_encoding('UTF-8');

	$configuration = (array) json_decode(file_get_contents('mamp.conf.json'));
	$configuration['webstart_version'] = (string) '7';
	$configuration['os'] = (string) (mb_strtolower(substr(PHP_OS, 0, 3)) === 'win' ? 'win' : 'mac');
	$configuration['app_name'] = (string) (strpos(__FILE__, '/Library/') !== false) ? 'MAMP PRO' : 'MAMP';

	$configuration['language'] = (string) 'en';
	if (isset($_REQUEST['language']) === true) {
		switch ($_REQUEST['language']) {
			case 'English':
				$configuration['language'] = 'en';
				break;
			case 'German':
					$configuration['language'] = 'de';
					break;
			}
	}

	$configuration['remote_help_entry_point'] = (string) '';
	$configuration['app_website'] = (string) 'https://www.mamp.info';
	$configuration['check_mysql_running_path'] = (string) 'js/ajax-check-mysql-running.php';
	
	$website_language = (string) 'en';
	if (in_array($configuration['language'], (array) array((string) 'de', (string) 'en')) === true) {
		$website_language = $configuration['language'];
	}

	switch ($configuration['app_name']) {
		case 'MAMP PRO':
			switch ($configuration['os']) {
				case 'mac':
					$configuration['remote_help_entry_point'] = 'RHR_5_';
					$configuration['app_website'] = 'https://www.mamp.info/'.$website_language.'/mamp-pro/mac/';
					break;
				case 'win':
					$configuration['remote_help_entry_point'] = 'RHR_11_';
					$configuration['app_website'] = 'https://www.mamp.info/'.$website_language.'/mamp-pro/windows/';
					break;
			}
			break;
		case 'MAMP':
			switch ($configuration['os']) {
				case 'mac':
					$configuration['remote_help_entry_point'] = 'RHR_10_';
					$configuration['app_website'] = 'https://www.mamp.info/'.$website_language.'/mamp/mac/';
					break;
				case 'win':
					$configuration['remote_help_entry_point'] = 'RHR_12_';
					$configuration['app_website'] = 'https://www.mamp.info/'.$website_language.'/mamp/windows/';
					break;
			}
			break;
	}

?>