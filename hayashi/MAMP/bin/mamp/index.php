<?php
	include_once 'php/configuration.php';
	include_once 'php/functions.php';
	include_once 'php/strings/'.$configuration['language'].'.php';

	// same in "js/ajax-check-mysql-running.php"
	if ($configuration['os'] === 'win') {
		include_once '../phpMyAdmin/config.inc.php';
	} else {
		if ($configuration['app_name'] === 'MAMP') {
			include_once '/Applications/MAMP/bin/phpMyAdmin/config.inc.php';
		} else {
			include_once '/Library/Application Support/appsolute/MAMP PRO/phpMyAdmin/config.inc.php';
		}
	}

	$mysql_running = (bool) check_mysql_running();

	download_latest_version_info();
	$latest_version_info = get_latest_version_info();

	if (@fsockopen('www.mamp.info', 80, $errno, $errstr, 10) === false) {
		$online = (bool) false;
	} else {
		$online = (bool) true;
	}
?>
<!doctype html>
<html lang="<?php echo $configuration['language']; ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/fonts.css">
		<link rel="stylesheet" href="css/prism.css">
		<link rel="stylesheet" href="css/custom.css">
		<link rel="icon" type="img/ico" href="images/favicon.ico">
		<link rel="shortcut icon" href="images/favicon.ico">
		<title><?php echo $configuration['app_name']; ?></title>
	</head>
	<body>
		<div class="container-fluid bg-light pt-2 pb-2">
			<div class="container">
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse mt-lg-2" id="navbarNavDropdown">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTools" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $GLOBALS['strings']['_s27_']; ?></a>
								<div class="dropdown-menu mt-lg-3" aria-labelledby="navbarDropdownTools">
									<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-phpinfo">phpInfo</a>

									<?php if (version_compare(PHP_VERSION, '5.5.0', '>=') === true): ?>
										<a class="dropdown-item phpmyadmin-link" href="/phpMyAdmin/?lang=<?php echo $configuration['language']; ?>" target="_blank"<?php echo($mysql_running === false ? ' class="disabled"' : ''); ?>>phpMyAdmin<?php echo($mysql_running === false ? ' ('.$GLOBALS['strings']['_s53_'].')' : ''); ?></a>
									<?php else: ?>
										<a class="dropdown-item disabled" href="#">phpMyAdmin (<?php echo $GLOBALS['strings']['_s29_']; ?>)</a>
									<?php endif; ?>

									<?php if (version_compare(PHP_VERSION, '5.4.0', '>=') && version_compare(PHP_VERSION, '7.3.9', '<=')): ?>
										<a class="dropdown-item" href="/phpLiteAdmin/" target="_blank">phpLiteAdmin</a>
									<?php else: ?>
										<a class="dropdown-item disabled" href="#">phpLiteAdmin (<?php echo $GLOBALS['strings']['_s30_']; ?>)</a>
									<?php endif; ?>

									<div class="dropdown-divider"></div>

									<?php
										if (extension_loaded('apc') === true) {
											printf('<a class="dropdown-item" href="apc.php" target="_blank">APC</a>');
										} else if (extension_loaded('apcu') === true) {
											printf('<a class="dropdown-item" href="apc-8.php" target="_blank">APC</a>');
										} else {
											printf('<a class="dropdown-item disabled" href="#">APC (' . $GLOBALS['strings']['_s31_'] . ')</a>');
										}
									?>

									<?php if (extension_loaded('eAccelerator') === true): ?>
										<a class="dropdown-item" href="eaccelerator.php" target="_blank">eAccelerator</a>
									<?php else: ?>
										<a class="dropdown-item disabled" href="#">eAccelerator (<?php echo $GLOBALS['strings']['_s31_']; ?>)</a>
									<?php endif; ?>

									<?php if (extension_loaded('XCache') === true): ?>
										<a class="dropdown-item" href="xcache-admin/" target="_blank">XCache</a>
									<?php else: ?>
										<a class="dropdown-item disabled" href="#">XCache (<?php echo $GLOBALS['strings']['_s31_']; ?>)</a>
									<?php endif; ?>

									<?php if (extension_loaded('Zend OPcache') === true): ?>
										<a class="dropdown-item" href="opcache.php" target="_blank">OPcache</a>
									<?php else: ?>
										<a class="dropdown-item disabled" href="#">OPcache (<?php echo $GLOBALS['strings']['_s31_']; ?>)</a>
									<?php endif; ?>

								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownHelp" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $GLOBALS['strings']['_s32_']; ?></a>
								<div class="dropdown-menu mt-lg-3" aria-labelledby="navbarDropdownHelp">
									<a class="dropdown-item" href="https://apps.mamp.info/remote-help/?ref=<?php echo $configuration['remote_help_entry_point']; ?>&amp;language=<?php echo $configuration['language']; ?>" target="_blank"><?php echo $GLOBALS['strings']['_s33_']; ?></a>
									<a class="dropdown-item" href="http://www.mamp.tv" target="_blank"><?php echo $GLOBALS['strings']['_s34_']; ?></a>
									<a class="dropdown-item" href="https://bugs.mamp.info" target="_blank"><?php echo $GLOBALS['strings']['_s35_']; ?></a>
								</div>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo $configuration['app_website']; ?>" target="_blank"><?php echo $configuration['app_name'], ' ', $GLOBALS['strings']['_s36_']; ?></a>
							</li>
							<?php
								if ($configuration['app_name'] === 'MAMP') {
									echo '<li class="nav-item">';
									echo '<a class="nav-link" href="'.get_http().'://'.$_SERVER['HTTP_HOST'].'" target="_blank">'.$GLOBALS['strings']['_s51_'].'</a>';
									echo '</li>';
								}
							?>
							<?php $myFavLink=''; ?>
							<?php echo ($myFavLink != '' ? '<li class="nav-item"><a class="nav-link" href="'.$myFavLink.'" target="_blank">'.$GLOBALS['strings']['_s37_'].'</a></li>' : ''); ?>
						</ul>
						<?php
							if (is_bought() === false) {
								echo '<a href="https://www.mamp.info/'.$configuration['os'].'store" target="_blank" class="btn btn-success btn-sm" role="button">'.$GLOBALS['strings']['_s6_'].'</a>';
							}
						?>
					</div>
				</nav>
			</div>
		</div>
		<div class="container-fluid text-center text-white bg-<?php echo ($configuration['app_name'] === 'MAMP PRO' ? 'mamppro' : 'mamp'); ?> pt-5 pb-4">
			<h1 class="display-4"><?php echo $GLOBALS['strings']['_s1_'], ' ', $configuration['app_name']; ?></h1>
			<p class="lead">
				<?php
					echo $GLOBALS['strings']['_s2_'], ' ', $configuration['version'];
					if (is_null($latest_version_info) === false && version_compare($latest_version_info, $configuration['version'], '>') === true) {
						echo '&nbsp;&rarr;&nbsp;<a href="'.$GLOBALS['strings']['_s5_'].'" class="text-white">'.$GLOBALS['strings']['_s4_'].' '.$latest_version_info.'</a>';
					} else {
						echo ' ', $GLOBALS['strings']['_s3_'];
					}
				?>				
			</p>
		</div>

		<div class="container mt-5">
			<div class="row row-cols-1 row-cols-lg-3">

				<?php
					if (is_bought() === false || $configuration['app_name'] === 'MAMP') {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-info">'.$GLOBALS['strings']['_s6_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.$GLOBALS['strings']['_s7_'].'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s8_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '			<a href="'.$GLOBALS['strings']['_s10_'].'" target="_blank" class="btn btn-info btn-sm btn-block" role="button">'.$GLOBALS['strings']['_s9_'].'</a>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					} else {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-info">'.$GLOBALS['strings']['_s11_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.($configuration['app_name'] === 'MAMP PRO' ? $GLOBALS['strings']['_s52_'] : $GLOBALS['strings']['_s12_']).'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s13_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '			<a href="http://www.mamp.tv" target="_blank" class="btn btn-info btn-sm btn-block" role="button">'.$GLOBALS['strings']['_s14_'].'</a>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					}

					/* ---------- */

					if ($configuration['app_name'] === 'MAMP PRO') {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-info">'.$GLOBALS['strings']['_s15_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.$GLOBALS['strings']['_s16_'].'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s17_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '			<a href="https://appsolute.zendesk.com/" target="_blank" class="btn btn-info btn-sm btn-block" role="button">'.$GLOBALS['strings']['_s18_'].'</a>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					} else if (is_cloud_bought() === false) {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-info">'.$GLOBALS['strings']['_s19_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.$GLOBALS['strings']['_s20_'].'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s21_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '			<a href="'.$GLOBALS['strings']['_s22_'].'" target="_blank" class="btn btn-info btn-sm btn-block" role="button">'.$GLOBALS['strings']['_s9_'].'</a>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					} else {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-info">'.$GLOBALS['strings']['_s11_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.($configuration['app_name'] === 'MAMP PRO' ? $GLOBALS['strings']['_s52_'] : $GLOBALS['strings']['_s12_']).'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s13_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '			<a href="http://www.mamp.tv" target="_blank" class="btn btn-info btn-sm btn-block" role="button">'.$GLOBALS['strings']['_s14_'].'</a>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					}

					/* ---------- */

					echo '<div class="col mb-4">';
					echo '	<div class="card border-0 h-100">';
					echo '		<div class="card-header p-0 border-0 bg-white">';
					echo '			<h2 class="card-title mb-0 text-center text-twitter">'.$GLOBALS['strings']['_s23_'].'</h2>';
					echo '		</div>';
					echo '		<div class="card-body p-0 mt-3">';
					echo '			<p class="card-text lead text-muted text-center hm mt-2">'.$GLOBALS['strings']['_s24_'].'</p>';
					echo '			<p class="card-text text-center pt-3"><i class="fab fa-twitter fa-5x text-twitter mb-2"></i></p>';
					echo '		</div>';
					echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
					echo '			<a href="https://twitter.com/mamp_en" target="_blank" class="btn btn-twitter btn-sm btn-block" role="button">'.$GLOBALS['strings']['_s25_'].'</a>';
					echo '		</div>';
					echo '	</div>';
					echo '</div>';
				?>

  		</div>
		</div>

		<div class="container mt-4">	
			<div class="row">
				<div class="<?php echo ($online === true ? 'col-12 col-lg-8' : 'col-12'); ?>">
					<div class="accordion mb-4" id="accordion-1">
						<div class="card">
							<div class="card-header position-relative" id="heading-php">
								<div class="float-left">
									<h2 class="mb-0">
										<a href="#" class="text-info font-weight-light stretched-link" data-toggle="collapse" data-target="#collapse-php" aria-expanded="true" aria-controls="collapse-php">
											PHP
										</a>
									</h2>
								</div>
								<div class="float-right text-black-50 pt-1">
									<i class="fab fa-php fa-2x"></i>
								</div>
							</div>
							<div id="collapse-php" class="collapse show" aria-labelledby="heading-php" data-parent="#accordion-1">
								<div class="card-body pb-0">
									<h3 class="text-secondary font-weight-light">phpinfo</h3>
									<p><?php printf($GLOBALS['strings']['_s48_'], '<a href="phpinfo.php" target="_blank">', '</a>', $_SERVER['HTTP_HOST']); ?></p>
									<h3 class="text-secondary font-weight-light">PHP-Caches</h3>
									<ul>
										<?php
											if (extension_loaded('apc') === true) {
												printf('<li><a target="_blank" href="apc.php">APC</a></li>');
											} else if (extension_loaded('apcu') === true) {
												printf('<li><a target="_blank" href="apc-8.php">APC</a></li>');
											} else {
												printf('<li>APC (' . $GLOBALS['strings']['_s31_'] . ')');
											}
										?>

										<?php if (extension_loaded('eAccelerator') === true): ?>
											<li><a target="_blank" href="eaccelerator.php">eAccelerator</a></li>
										<?php else: ?>
											<li>eAccelerator (<?php echo $GLOBALS['strings']['_s31_']; ?>)</li>
										<?php endif; ?>

										<?php if (extension_loaded('XCache') === true): ?>
											<li><a target="_blank" href="xcache-admin/">XCache</a></li>
										<?php else: ?>
											<li>XCache (<?php echo $GLOBALS['strings']['_s31_']; ?>)</li>
										<?php endif; ?>

										<?php if (extension_loaded('Zend OPcache') === true): ?>
											<li><a target="_blank" href="opcache.php">OPcache</a></li>
										<?php else: ?>
											<li>OPcache (<?php echo $GLOBALS['strings']['_s31_']; ?>)</li>
										<?php endif; ?>
									</ul>
								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-header position-relative" id="heading-mysql">
								<div class="float-left">
									<h2 class="mb-0">
										<a href="#" class="text-info font-weight-light stretched-link" data-toggle="collapse" data-target="#collapse-mysql" aria-expanded="true" aria-controls="collapse-mysql">
											MySQL
										</a>
									</h2>
								</div>
								<div class="float-right text-black-50">
									<i class="fas fa-database fa-2x"></i>
								</div>
							</div>
							<div id="collapse-mysql" class="collapse" aria-labelledby="heading-mysql" data-parent="#accordion-1">
								<div class="card-body">
									<p>
										<?php
											if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
												printf($GLOBALS['strings']['_s38_'], '<a href="/phpMyAdmin/?lang='.$configuration['language'].'" class="btn btn-link px-0 py-0 align-baseline phpmyadmin-link'.($mysql_running === false ? ' disabled' : '').'" target="_blank">', ($mysql_running === false ? ' ('.$GLOBALS['strings']['_s53_'].')' : ''), '</a>');
											} else {
												printf($GLOBALS['strings']['_s38_'], '', '', '');
											}
										?>
									</p>
									<p><?php echo $GLOBALS['strings']['_s39_']; ?></p>
									<table class="table table-hover">
										<tr>
											<th style="width:20%"><?php echo $GLOBALS['strings']['_s40_']; ?></th>
											<td><code><?php echo $cfg['Servers'][1]['host'] . " / 127.0.0.1 " . $GLOBALS['strings']['_s_localhostInfo_']; ?></code></td>
										</tr>
										<tr>
											<th><?php echo $GLOBALS['strings']['_s41_']; ?></th>
											<td><code><?php echo $cfg['Servers'][1]['port'] ? $cfg['Servers'][1]['port'] : '3306'; ?></code></td>
										</tr>
										<tr>
											<th><?php echo $GLOBALS['strings']['_s42_']; ?></th>
											<td><code><?php echo $cfg['Servers'][1]['user']; ?></code></td>
										</tr>
										<tr>
											<th><?php echo $GLOBALS['strings']['_s43_']; ?></th>
											<td><code><?php echo $cfg['Servers'][1]['password']; ?></code></td>
										</tr>
										<?php if ($configuration['os'] === 'mac'): ?>
										<tr>
											<th><?php echo $GLOBALS['strings']['_s44_']; ?></th>
											<td><code>/Applications/MAMP/tmp/mysql/mysql.sock</code></td>
										</tr>
										<?php endif; ?>
									</table>
									<h3 class="text-secondary font-weight-light"><?php echo $GLOBALS['strings']['_s45_']; ?></h3>
									<ul class="nav nav-tabs nav-fill mt-3" id="mysql-examples" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="mysql-example-1-tab" data-toggle="tab" href="#mysql-example-1" role="tab" aria-controls="mysql-example-1" aria-selected="true">PHP</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="mysql-example-2-tab" data-toggle="tab" href="#mysql-example-2" role="tab" aria-controls="mysql-example-2" aria-selected="false">Python</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="mysql-example-3-tab" data-toggle="tab" href="#mysql-example-3" role="tab" aria-controls="mysql-example-3" aria-selected="false">Perl</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="mysql-example-4-tab" data-toggle="tab" href="#mysql-example-4" role="tab" aria-controls="mysql-example-4" aria-selected="false">Ruby</a>
										</li>
									</ul>
									<div class="tab-content" id="mysql-examples-content">
										<div class="tab-pane border-left border-bottom border-right show active" id="mysql-example-1" role="tabpanel" aria-labelledby="mysql-example-1-tab">
<?php if ($configuration['os'] === 'mac'): ?>
<h4 class="bg-white text-secondary font-weight-light px-3 pt-3 pb-0"><?php echo $GLOBALS['strings']['_s47_']; ?></h4>
<pre class="language-php"><code class="language-php"><?php echo htmlentities('<?php', ENT_QUOTES, 'UTF-8'); ?>

  $db_host = 'localhost';
  $db_user = '<?php echo $cfg['Servers'][1]['user']; ?>';
  $db_password = '<?php echo $cfg['Servers'][1]['password']; ?>';
  $db_db = 'information_schema';
 
  $mysqli = @new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
  );
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '&lt;br&gt;';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }

  echo 'Success: A proper connection to MySQL was made.';
  echo '&lt;br&gt;';
  echo 'Host information: '.$mysqli->host_info;
  echo '&lt;br&gt;';
  echo 'Protocol version: '.$mysqli->protocol_version;

  $mysqli->close();
<?php echo htmlentities('?>', ENT_QUOTES, 'UTF-8'); ?></code></pre>
<?php endif; ?>
<h4 class="bg-white text-secondary font-weight-light px-3 pt-4 pb-0"><?php echo $GLOBALS['strings']['_s46_']; ?></h4>
<pre class="language-php"><code class="language-php"><?php echo htmlentities('<?php', ENT_QUOTES, 'UTF-8'); ?>

  $db_host = '127.0.0.1';
  $db_user = '<?php echo $cfg['Servers'][1]['user']; ?>';
  $db_password = '<?php echo $cfg['Servers'][1]['password']; ?>';
  $db_db = 'information_schema';
  $db_port = <?php echo $cfg['Servers'][1]['port'] ? $cfg['Servers'][1]['port'] : "3306" ?>;

  $mysqli = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db,
	$db_port
  );
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '&lt;br&gt;';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }

  echo 'Success: A proper connection to MySQL was made.';
  echo '&lt;br&gt;';
  echo 'Host information: '.$mysqli->host_info;
  echo '&lt;br&gt;';
  echo 'Protocol version: '.$mysqli->protocol_version;

  $mysqli->close();
<?php echo htmlentities('?>', ENT_QUOTES, 'UTF-8'); ?></code></pre>
										</div>
										<div class="tab-pane border-left border-bottom border-right" id="mysql-example-2" role="tabpanel" aria-labelledby="mysql-example-2-tab">
<?php if ($configuration['os'] === 'mac'): ?>
<h4 class="bg-white text-secondary font-weight-light px-3 pt-3 pb-0"><?php echo $GLOBALS['strings']['_s47_']; ?></h4>
<pre class="language-python"><code class="language-python">#!/usr/bin/env /Applications/MAMP/Library/bin/python

import mysql.connector

config = {
  'user': '<?php echo $cfg['Servers'][1]['user']; ?>',
  'password': '<?php echo $cfg['Servers'][1]['password']; ?>',
  'host': 'localhost',
  'unix_socket': '/Applications/MAMP/tmp/mysql/mysql.sock',
  'database': 'test',
  'raise_on_warnings': True
}

cnx = mysql.connector.connect(**config)

cursor = cnx.cursor(dictionary=True)

cursor.execute('SELECT `id`, `name` FROM `test`')

results = cursor.fetchall()

for row in results:
  id = row['id']
  title = row['name']
  print '%s | %s' % (id, title)

cnx.close()
</code></pre>
<?php endif; ?>
<h4 class="bg-white text-secondary font-weight-light px-3 pt-4 pb-0"><?php echo $GLOBALS['strings']['_s46_']; ?></h4>
<pre class="language-python"><code class="language-python">#!/usr/bin/env /Applications/MAMP/Library/bin/python

import mysql.connector

config = {
  'user': '<?php echo $cfg['Servers'][1]['user']; ?>',
  'password': '<?php echo $cfg['Servers'][1]['password']; ?>',
  'host': '127.0.0.1',
  'port': <?php echo $cfg['Servers'][1]['port'] ? $cfg['Servers'][1]['port'] : "3306" ?>,
  'database': 'test',
  'raise_on_warnings': True
}

cnx = mysql.connector.connect(**config)

cursor = cnx.cursor(dictionary=True)

cursor.execute('SELECT `id`, `name` FROM `test`')

results = cursor.fetchall()

for row in results:
  id = row['id']
  title = row['name']
  print '%s | %s' % (id, title)

cnx.close()
</code></pre>
										</div>
										<div class="tab-pane border-left border-bottom border-right" id="mysql-example-3" role="tabpanel" aria-labelledby="mysql-example-3-tab">
<?php if ($configuration['os'] === 'mac'): ?>
<h4 class="bg-white text-secondary font-weight-light px-3 pt-3 pb-0"><?php echo $GLOBALS['strings']['_s47_']; ?></h4>
<pre class="language-perl"><code class="language-perl">#!/Applications/MAMP/Library/bin/perl
use strict;
use warnings;
use DBI;

print &quot;Content-type: text/html\n\n&quot;;

my $source = 'DBI:mysql:database=test;host=localhost;mysql_socket=/Applications/MAMP/tmp/mysql/mysql.sock';
my $user = 'root';
my $password = 'root';

my $attr = {
  PrintError =&gt; 0, # turn off error reporting via warn()
  RaiseError =&gt; 1, # turn on error reporting via die()
};

my $dbc = DBI-&gt;connect($source, $user, $password, $attr)
or die &quot;Unable to connect to mysql: $DBI::errstr\n&quot;;

my $sql = $dbc-&gt;prepare(&quot;SELECT `id`, `name` FROM `test`&quot;);
my $out = $sql-&gt;execute()
or die &quot;Unable to execute sql: $sql-&gt;errstr&quot;;

while ((my $id, my $name) = $sql-&gt;fetchrow_array()) {
  print &quot;id: $id / name: $name&lt;br&gt;\n&quot;;
}

$dbc-&gt;disconnect();
</code></pre>
<?php endif; ?>
<h4 class="bg-white text-secondary font-weight-light px-3 pt-4 pb-0"><?php echo $GLOBALS['strings']['_s46_']; ?></h4>
<pre class="language-perl"><code class="language-perl">#!/Applications/MAMP/Library/bin/perl
use strict;
use warnings;
use DBI;

print &quot;Content-type: text/html\n\n&quot;;

my $source = 'DBI:mysql:database=test;host=localhost;port=<?php echo $cfg['Servers'][1]['port'] ? $cfg['Servers'][1]['port'] : "3306" ?>';
my $user = 'root';
my $password = 'root';

my $attr = {
  PrintError =&gt; 0, # turn off error reporting via warn()
  RaiseError =&gt; 1, # turn on error reporting via die()
};

my $dbc = DBI-&gt;connect($source, $user, $password, $attr)
or die &quot;Unable to connect to mysql: $DBI::errstr\n&quot;;

my $sql = $dbc-&gt;prepare(&quot;SELECT `id`, `name` FROM `test`&quot;);
my $out = $sql-&gt;execute()
or die &quot;Unable to execute sql: $sql-&gt;errstr&quot;;

while ((my $id, my $name) = $sql-&gt;fetchrow_array()) {
  print &quot;id: $id / name: $name&lt;br&gt;\n&quot;;
}

$dbc-&gt;disconnect();
</code></pre>
										</div>
										<div class="tab-pane border-left border-bottom border-right" id="mysql-example-4" role="tabpanel" aria-labelledby="mysql-example-4-tab">
<?php if ($configuration['os'] === 'mac'): ?>
<h4 class="bg-white text-secondary font-weight-light px-3 pt-3 pb-0"><?php echo $GLOBALS['strings']['_s47_']; ?></h4>
<pre class="language-ruby"><code class="language-ruby">#!/Applications/MAMP/Library/bin/ruby

require &quot;mysql2&quot;

@db_host = &quot;localhost&quot;
@db_socket = &quot;/Applications/MAMP/tmp/mysql/mysql.sock&quot;
@db_user = &quot;root&quot;
@db_pass = &quot;root&quot;
@db_name = &quot;test&quot;

client = Mysql2::Client.new(
  :host =&gt; @db_host,
  :socket =&gt; @db_socket,
  :username =&gt; @db_user,
  :password =&gt; @db_pass,
  :database =&gt; @db_name
)

result = client.query(&quot;SELECT * from `test`&quot;)

result.each do |row|
  puts row[&quot;id&quot;].to_s() + &quot; | &quot; + row[&quot;name&quot;].to_s()
end

client.close
</code></pre>
<?php endif; ?>
<h4 class="bg-white text-secondary font-weight-light px-3 pt-4 pb-0"><?php echo $GLOBALS['strings']['_s46_']; ?></h4>
<pre class="language-ruby"><code class="language-ruby">#!/Applications/MAMP/Library/bin/ruby

require &quot;mysql2&quot;

@db_host = &quot;localhost&quot;
@db_port = <?php echo $cfg['Servers'][1]['port'] ? $cfg['Servers'][1]['port'] : "3306" ?></br>
@db_user = &quot;root&quot;
@db_pass = &quot;root&quot;
@db_name = &quot;test&quot;

client = Mysql2::Client.new(
  :host =&gt; @db_host,
  :port =&gt; @db_port,
  :username =&gt; @db_user,
  :password =&gt; @db_pass,
  :database =&gt; @db_name
)

result = client.query(&quot;SELECT * from `test`&quot;)

result.each do |row|
  puts row[&quot;id&quot;].to_s() + &quot; | &quot; + row[&quot;name&quot;].to_s()
end

client.close
</code></pre>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php if ($configuration['app_name'] === 'MAMP PRO' && $configuration['os'] === 'mac'): ?>
							<div class="card">
								<div class="card-header position-relative" id="heading-redis">
									<div class="float-left">
										<h2 class="mb-0">
											<a href="#" class="text-info font-weight-light stretched-link" data-toggle="collapse" data-target="#collapse-redis" aria-expanded="true" aria-controls="collapse-redis">
												Redis
											</a>
										</h2>
									</div>
									<div class="float-right text-black-50">
										<i class="fas fa-database fa-2x"></i>
									</div>
								</div>
								<div id="collapse-redis" class="collapse" aria-labelledby="heading-redis" data-parent="#accordion-1">
									<div class="card-body">
										<h3 class="text-secondary font-weight-light"><?php echo $GLOBALS['strings']['_s45_']; ?></h3>
										<ul class="nav nav-tabs nav-fill mt-3" id="redis-examples" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="redis-example-1-tab" data-toggle="tab" href="#redis-example-1" role="tab" aria-controls="redis-example-1" aria-selected="true">PHP<br><small><?php echo $GLOBALS['strings']['_s47_']; ?></small></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="redis-example-2-tab" data-toggle="tab" href="#redis-example-2" role="tab" aria-controls="redis-example-2" aria-selected="false">PHP<br><small><?php echo $GLOBALS['strings']['_s46_']; ?></small></a>
											</li>
										</ul>
										<div class="tab-content" id="redis-examples-content">
											<div class="tab-pane border-left border-bottom border-right show active" id="redis-example-1" role="tabpanel" aria-labelledby="redis-example-1-tab">
<pre class="language-php"><code class="language-php">// Connecting to Redis server on localhost
$redis = new Redis();

$redis->connect('/Applications/MAMP/tmp/redis.sock');

// Check whether server is running or not
echo 'Redis is running: ' . $redis->ping() . '&lt;br&gt;';

// Set the value of a key
$key = 'product';
$redis->set($key, 'MAMP PRO');

// Get the value of a key
echo 'Key "' . $key . '" has the value "' . $redis->get($key) . '"' . '&lt;br&gt;';

// Store data in redis list
$redis->lPush('list', 'MAMP PRO');
$redis->lPush('list', 'Apache');
$redis->lPush('list', 'MySQL');
$redis->lPush('list', 'Redis');

// Get the list data
$list = $redis->lRange('list', 0, 3);
echo '&lt;br&gt;';
echo 'Stored list:';
echo '&lt;pre&gt;';
print_r($list);
echo '&lt;/pre&gt;';

// Clean up
if ($redis->exists([$key, 'list']) === 2) {
  $redis->del($key);
  $redis->del('list');
}
</code></pre>
											</div>
											<div class="tab-pane border-left border-bottom border-right" id="redis-example-2" role="tabpanel" aria-labelledby="redis-example-2-tab">
<pre class="language-php"><code class="language-php">// Connecting to Redis server on localhost
$redis = new Redis();

$redis->connect('127.0.0.1', 6379);

// Check whether server is running or not
echo 'Redis is running: ' . $redis->ping() . '&lt;br&gt;';

// Set the value of a key
$key = 'product';
$redis->set($key, 'MAMP PRO');

// Get the value of a key
echo 'Key "' . $key . '" has the value "' . $redis->get($key) . '"' . '&lt;br&gt;';

// Store data in redis list
$redis->lPush('list', 'MAMP PRO');
$redis->lPush('list', 'Apache');
$redis->lPush('list', 'MySQL');
$redis->lPush('list', 'Redis');

// Get the list data
$list = $redis->lRange('list', 0, 3);
echo '&lt;br&gt;';
echo 'Stored list:';
echo '&lt;pre&gt;';
print_r($list);
echo '&lt;/pre&gt;';

// Clean up
if ($redis->exists([$key, 'list']) === 2) {
  $redis->del($key);
  $redis->del('list');
}
</code></pre>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>



					  <div class="card">
							<div class="card-header position-relative" id="heading-sqlite">
								<div class="float-left">
									<h2 class="mb-0">
										<a href="#" class="text-info font-weight-light stretched-link" data-toggle="collapse" data-target="#collapse-sqlite" aria-expanded="true" aria-controls="collapse-sqlite">
											SQLite
										</a>
									</h2>
								</div>
								<div class="float-right text-black-50">
									<i class="fas fa-database fa-2x"></i>
								</div>
							</div>
							<div id="collapse-sqlite" class="collapse" aria-labelledby="heading-sqlite" data-parent="#accordion-1">
								<div class="card-body">
									<?php if (version_compare(PHP_VERSION, '5.4.0', '>=') === true && version_compare(PHP_VERSION, '7.3.9', '<=') === true): ?>
										<p><?php printf($GLOBALS['strings']['_s50_'], '<a href="/phpLiteAdmin/" target="_blank">', '</a>'); ?></p>
									<?php else: ?>
										<p>phpLiteAdmin <?php echo $GLOBALS['strings']['_s30_']; ?>.</p>
									<?php endif; ?>
									<h3 class="text-secondary font-weight-light"><?php echo $GLOBALS['strings']['_s45_']; ?></h3>
									<ul class="nav nav-tabs nav-fill mt-3" id="sqlite-examples" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="sqlite-example-1-tab" data-toggle="tab" href="#sqlite-example-1" role="tab" aria-controls="sqlite-example-1" aria-selected="true">PHP<br><small><?php echo $GLOBALS['strings']['_s55_']; ?></small></a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="sqlite-example-2-tab" data-toggle="tab" href="#sqlite-example-2" role="tab" aria-controls="sqlite-example-2" aria-selected="false">PHP<br><small><?php echo $GLOBALS['strings']['_s56_']; ?></small></a>
										</li>
									</ul>
									<div class="tab-content" id="sqlite-examples-content">
										<div class="tab-pane border-left border-bottom border-right show active" id="sqlite-example-1" role="tabpanel" aria-labelledby="sqlite-example-1-tab">
<pre class="language-php"><code class="language-php">&lt;?php
  $db = new SQLite3('/Applications/MAMP/db/sqlite/mydb.db');
  $db-&gt;exec(&quot;CREATE TABLE items(id INTEGER PRIMARY KEY, name TEXT)&quot;);
  $db-&gt;exec(&quot;INSERT INTO items(name) VALUES('Name 1')&quot;);
  $db-&gt;exec(&quot;INSERT INTO items(name) VALUES('Name 2')&quot;);

  $last_row_id = $db-&gt;lastInsertRowID();

  echo 'The last inserted row ID is '.$last_row_id.'.';

  $result = $db-&gt;query('SELECT * FROM items');

  while ($row = $result-&gt;fetchArray()) {
    echo '&lt;br&gt;';
    echo 'id: '.$row['id'].' / name: '.$row['name'];
  }

  $db-&gt;exec('DELETE FROM items');

  $changes = $db-&gt;changes();

  echo '&lt;br&gt;';
  echo 'The DELETE statement removed '.$changes.' rows.';
?&gt;</code></pre>
										</div>
										<div class="tab-pane border-left border-bottom border-right" id="sqlite-example-2" role="tabpanel" aria-labelledby="sqlite-example-2-tab">
<pre class="language-php"><code class="language-php">&lt;?php
  $db = new SQLite3(':memory:');
  $db-&gt;exec(&quot;CREATE TABLE items(id INTEGER PRIMARY KEY, name TEXT)&quot;);
  $db-&gt;exec(&quot;INSERT INTO items(name) VALUES('Name 1')&quot;);
  $db-&gt;exec(&quot;INSERT INTO items(name) VALUES('Name 2')&quot;);

  $last_row_id = $db-&gt;lastInsertRowID();

  echo 'The last inserted row ID is '.$last_row_id.'.';

  $result = $db-&gt;query('SELECT * FROM items');

  while ($row = $result-&gt;fetchArray()) {
    echo '&lt;br&gt;';
    echo 'id: '.$row['id'].' / name: '.$row['name'];
  }

  $db-&gt;exec('DELETE FROM items');

  $changes = $db-&gt;changes();

  echo '&lt;br&gt;';
  echo 'The DELETE statement removed '.$changes.' rows.';
?&gt;</code></pre>
										</div>
									</div>
								</div>
							</div>
						</div>	





					</div>
				</div>
				<?php if ($online === true): ?>
					<div class="col-12 col-lg-4">
						<a class="twitter-timeline" data-theme="light" data-tweet-limit="5" href="https://twitter.com/mamp_en?ref_src=twsrc%5Etfw"></a>
						<script async src="https://platform.twitter.com/widgets.js"></script>
						<script>
							let customizeTwitterFrame = function () {
								let twitterFrameFound = false;
								
								for (let i = 0; i < frames.length; i++) {
									try {
										if (frames[i].frameElement.id == 'twitter-widget-0') {
											twitterFrameFound = true;

											let head = frames[i].document.getElementsByTagName('head')[0];

											let linkFonts = frames[i].document.createElement('link');
											linkFonts.href = 'css/fonts.css';
											linkFonts.rel = 'stylesheet';
											linkFonts.type = 'text/css';
											head.appendChild(linkFonts);

											let linkTwitter = frames[i].document.createElement('link');
											linkTwitter.href = 'css/twitter.css';
											linkTwitter.rel = 'stylesheet';
											linkTwitter.type = 'text/css';
											head.appendChild(linkTwitter);
										}
									} catch(e) {
										/*console.log(e);*/
									}
								}

								if (twitterFrameFound == false) {
									setTimeout(function() {
										customizeTwitterFrame();
									}, 150);
								}
							}

							customizeTwitterFrame();
						</script>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<footer class="border-top pt-3 text-center">
			<p>&copy; 2013 - 2021 <a href="https://www.mamp.info" target="_blank">MAMP GmbH</a></p>
		</footer>
		<script src="js/jquery-3.5.1.slim.min.js"></script>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script defer src="js/fontawesome.js"></script>
		<script>
			window.FontAwesomeConfig = {
				searchPseudoElements: true
			}
		</script>
		<script>
			['php', 'mysql', 'redis', 'sqlite'].forEach(function(item) {
				$('#collapse-'+item).on('shown.bs.collapse', function () {
					document.getElementById('heading-'+item).scrollIntoView({
						behavior: 'smooth'
					});
				});
			});
		</script>
		<script src="js/prism.js"></script>

		<div class="modal fade" id="modal-phpinfo" tabindex="-1" role="dialog" aria-labelledby="modal-phpinfo-label" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modal-phpinfo-label">phpInfo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body p-0">
						<iframe id="modal-phpinfo-iframe" src="about:blank" style="width: 100%; border: 0;"></iframe>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $GLOBALS['strings']['_s28_']; ?></button>
					</div>
				</div>
			</div>
		</div>
		<script>
			$('#modal-phpinfo').on('show.bs.modal', function (e) {
				document.getElementById('modal-phpinfo-iframe').src = 'phpinfo.php';
				document.getElementById('modal-phpinfo-iframe').style.height = (window.innerHeight - 70*2 - 30*2).toString() + 'px';
			});
		</script>

		<script>
			const checkMySQLRunning = function() {
				const url = '<?php echo $configuration['check_mysql_running_path']; ?>';
				const options = {
					method: 'GET',
					cache: 'no-cache'
				};
				window.setInterval(function() {
					fetch(url, options)
						.then(async (data) => {
							if (data.ok) {
								data = await data.json();
								document.querySelectorAll('.phpmyadmin-link').forEach(function(element) {
									element.classList.remove('disabled');
									element.text = 'phpMyAdmin';
								
									if (data == 0) {
										element.classList.add('disabled');
										element.text = 'phpMyAdmin (<?php echo $GLOBALS['strings']['_s53_']; ?>)';
									}
								});
							}
						}).catch(e => console.log('<?php echo $GLOBALS['strings']['_s54_']; ?>', e))
				}, 5000);
			}
			
			if (document.readyState === 'complete' || (document.readyState !== 'loading' && !document.documentElement.doScroll)) {
				checkMySQLRunning();
			} else {
				document.addEventListener('DOMContentLoaded', checkMySQLRunning);
			}
		</script>
	</body>
</html>