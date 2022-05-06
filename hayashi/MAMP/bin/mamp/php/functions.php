<?php

	function get_http() {
		$result = (string) 'http';

		if (isset($_SERVER['HTTPS']) === true && $_SERVER['HTTPS'] === 'on') {
			$result = 'https';
		} elseif ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) === true && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') || isset($_SERVER['HTTP_X_FORWARDED_SSL']) === true && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') {
			$result = 'https';
		}

		return $result;
	}

	function check_mysql_running() {
		global $configuration;
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, get_http().'://'.$_SERVER['HTTP_HOST'].dirname(strip_tags($_SERVER['PHP_SELF'])).'/'.$configuration['check_mysql_running_path']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		$mysql_running = (bool) curl_exec($curl);
		curl_close ($curl);

		return $mysql_running;
	}

	function download_latest_version_info() {
		$make_update = (bool) true;

		$path = (string) 'js/mamp-mamp-pro-latest-version.json';
		if (file_exists($path) === true) {
			if (filemtime($path) > (time() - 86400)) { // 1 day
				$make_update = false;
			}
		}

		if ($make_update === true) {
			$url = (string) 'https://www.mamp.info/application/MAMP-MAMP-PRO/mamp-mamp-pro-latest-version.json';

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);				
			$json = curl_exec($curl);
			curl_close($curl);
		
			if ($json !== '') {
				file_put_contents('js/mamp-mamp-pro-latest-version.json', $json);
			}
		}

		unset($path, $url);
	}

	function get_latest_version_info() {
		global $configuration;
		$path = (string) 'js/mamp-mamp-pro-latest-version.json';

		if (file_exists($path) === true) {
			$latest_version_info = (array) json_decode(file_get_contents($path), true);
			if (isset($latest_version_info[$configuration['os']][str_replace(' ', '', $configuration['app_name'])]) === true) {
				return $latest_version_info[$configuration['os']][str_replace(' ', '', $configuration['app_name'])];
			}
		} else {
			return null;
		}
	}

	// Checks if user has bought MAMP PRO
	function is_bought() {
		global $configuration;

		if ($configuration['app_name'] === 'MAMP') {
			return false;
		}

		$bought = (bool) false;
		if (file_exists('bought') === true) {
			$bought = (bool) file_get_contents('bought');
		}
		return $bought;
	}

	// Checks if user has bought MAMP Cloud
	function is_cloud_bought() {
		global $configuration;
		
		if ($configuration['app_name'] === 'MAMP PRO') {
			return true;
		}

		$bought = (bool) false;
		if (file_exists('boughtc') === true) {
			$bought = boolval(file_get_contents('boughtc'));
		}
		return $bought;
	}

?>