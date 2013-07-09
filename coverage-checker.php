<?php
// flag on whether we should run the coverage-checker.php
$weShouldRunCheck = false;
if (isset($argv[3]) ) {
	$run			= $argv[3];
	$weShouldRunCheck = ($run == 'run');
	if ($weShouldRunCheck && isset($argv[4])) {
		// check php version
		$version = phpversion();
		$version = explode('.', $version);

		$majorMinorVersion = $version[0] . '.' . $version[1];
		$runInWhichVersion	= $argv[4];
		$weShouldRunCheck = ($runInWhichVersion == $majorMinorVersion);
	}
}

if (!$weShouldRunCheck) {
	echo "Coverage Checker NOT executed.";
	exit(0);
}

// coverage-checker.php
$inputFile  = $argv[1];
$percentage = min(100, max(0, (int) $argv[2]));
 
if (!file_exists($inputFile)) {
    throw new InvalidArgumentException('Invalid input file provided');
}
 
if (!$percentage) {
    throw new InvalidArgumentException('An integer checked percentage must be given as second parameter');
}
 
$xml             = new SimpleXMLElement(file_get_contents($inputFile));
$metrics         = $xml->xpath('//metrics');
$totalElements   = 0;
$checkedElements = 0;
 
foreach ($metrics as $metric) {
    $totalElements   += (int) $metric['elements'];
    $checkedElements += (int) $metric['coveredelements'];
}
 
$coverage = ($checkedElements / $totalElements) * 100;
 
if ($coverage < $percentage) {
    echo 'Code coverage is ' . $coverage . '%, which is below the accepted ' . $percentage . '%' . PHP_EOL;
    exit(1);
}
 
echo 'Code coverage is ' . $coverage . '% - OK!' . PHP_EOL;