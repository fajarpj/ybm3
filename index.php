<?php

use CodeIgniter\Boot;
use Config\Paths;

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */

$minPhpVersion = '8.2'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION,
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;

    exit(1);
}

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// LOAD OUR PATHS CONFIG FILE
// Support both local CI4 structure and InfinityFree-style deployments
// where only `public` contents are placed in `htdocs` and the core
// project lives in a sibling directory such as `yayasan-core`.
$pathsConfigCandidates = [
    FCPATH . '../app/Config/Paths.php',
    FCPATH . '../yayasan-core/app/Config/Paths.php',
    FCPATH . '../core/app/Config/Paths.php',
];

$pathsConfig = null;

foreach ($pathsConfigCandidates as $candidate) {
    if (is_file($candidate)) {
        $pathsConfig = $candidate;
        break;
    }
}

if ($pathsConfig === null) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Unable to locate app/Config/Paths.php. Pastikan folder inti project berada di samping folder public/htdocs.';
    exit(1);
}

require $pathsConfig;

$paths = new Paths();

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';

exit(Boot::bootWeb($paths));
