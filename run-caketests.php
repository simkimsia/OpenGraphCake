<?php
$coverageMin = 5;

// flag on whether we should run the coverage-checker.php
$weShouldRunCheck = false;
if (isset($argv[1]) ) {
	$run			= $argv[1];
	$weShouldRunCheck = ($run == 'run');
	if ($weShouldRunCheck && isset($argv[2])) {
		// check php version
		$version = phpversion();
		$version = explode('.', $version);

		$majorMinorVersion = $version[0] . '.' . $version[1];
		$runInWhichVersion	= $argv[2];
		$weShouldRunCheck = ($runInWhichVersion == $majorMinorVersion);
	}
}


if ($weShouldRunCheck) {
	$consoleCakeCloverParams = '--coverage-clover ../cakephp/app/tmp/logs/clover.xml --configuration plugins/OpenGraphCake/phpunit.dist.xml';
	exec('./lib/Cake/Console/cake test OpenGraphCake AllTests --stderr '. $consoleCakeCloverParams);
	exec('php plugins/OpenGraphCake/coverage-checker.php ../cakephp/app/tmp/logs/clover.xml '.$coverageMin.' '.$run.' ' . $runInWhichVersion);
} else {
	$consoleCakeCloverParams = '';
	echo "Coverage Checker NOT executed.";
	exec('./lib/Cake/Console/cake test OpenGraphCake AllTests --stderr ');
}