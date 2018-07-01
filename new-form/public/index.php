<?php

// /vhost/www.swinburne.edu.au
// Do not include trailing slash
define('DOCROOT', $_SERVER["DOCUMENT_ROOT"]);
define('APPPATH', DOCROOT.'/app/web-demo/asarker/legacy-form-demo');
define('LIBPATH', DOCROOT.'/app/web-demo/asarker/legacy-form-demo');


if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

// All file paths relative to root
//chdir(dirname(__DIR__));

require LIBPATH . '/vendor/autoload.php';
require LIBPATH . '/vendor/phpdotenv/vendor/autoload.php';
// require LIBPATH . '/vendor/UserAgentParser/vendor/autoload.php';
require LIBPATH . '/vendor/whichbrowser/vendor/autoload.php';
// require LIBPATH . '/medoo-a/vendor/autoload.php';


$loader = new \Composer\Autoload\ClassLoader();
//$loader->addPsr4('Bookshelf\\', APPPATH . '/app/src/Bookshelf');
$loader->addPsr4('Swinburne\\Legacy\\', APPPATH . '/app/src/Swinburne/Legacy');
$loader->addPsr4('Medoo\\', DOCROOT . '/app/web-lib/medoo/1.4.5');
$loader->register();

session_save_path('/tmp/app-web-demo-asarker/');
session_start();

/**
* Load dotenv file variables
*/
$dotenv = new Dotenv\Dotenv(APPPATH.'/app', 'dbinfo.env');
$dotenv->load();


/*
if (file_exists( APPPATH . '/app/settings.php')) {
    $settings = require APPPATH .'/app/settings.php';
} else {
    $settings = require APPPATH .'/app/settings.php.dist';
}
*/

//settings

// if (file_exists( APPPATH . '/app/settings.php') && file_exists( APPPATH . '/app/validation_rules.php') && file_exists( APPPATH . '/app/Emailconfig.php')) {
if (file_exists( APPPATH . '/app/settings.php') && file_exists( APPPATH . '/app/validation_rules.php')) {
    $settings          = require APPPATH . '/app/settings.php';
	$validation_rules  = require APPPATH . '/app/validation_rules.php';
    $email_settings    = require APPPATH . '/app/settings.email.php';
    $upload_settings   = require APPPATH . '/app/settings_upload.php';
    $log_settings      = require APPPATH . '/app/settings_log.php';
    $admin_settings    = require APPPATH . '/app/settings_admin.php';
	// $email_headers    = require APPPATH . '/app/Emailconfig.php';

	$settings = Zend\Stdlib\ArrayUtils::merge($settings, $validation_rules);
    $settings = Zend\Stdlib\ArrayUtils::merge($settings, $email_settings);
    $settings = Zend\Stdlib\ArrayUtils::merge($settings, $upload_settings);
    $settings = Zend\Stdlib\ArrayUtils::merge($settings, $log_settings);
    $settings = Zend\Stdlib\ArrayUtils::merge($settings, $admin_settings);

	//$settings = array_merge($settings, $validation_rules);
}
else
{
	echo "Error: Can't load settings";
	exit;
}


// Instantiate Slim
$app = new \Slim\App($settings);

require APPPATH .'/app/src/dependencies.php';
require APPPATH .'/app/src/middleware.php';

// Register the routes
require APPPATH .'/app/src/routes.php';



// Register the database connection with Eloquent
//$capsule = $app->getContainer()->get('capsule');
//$capsule->bootEloquent();

$app->run();
