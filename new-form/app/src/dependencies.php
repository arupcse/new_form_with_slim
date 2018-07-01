<?php

// DIC configuration
$container = $app->getContainer();

// Database

$container['capsule'] = function ($c) {
  //    $capsule = new Illuminate\Database\Capsule\Manager;
  //    $capsule->addConnection($c['settings']['db']);
  //    return $capsule;
};



// View
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig($c['settings']['view']['template_path'], $c['settings']['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $c['request']->getUri()));
    $view->addExtension(new Twig_Extension_Debug());
    $view->addExtension(new Bookshelf\TwigExtension($c['flash']));

    return $view;
};

// CSRF guard
$container['csrf'] = function ($c) {
    $guard = new \Slim\Csrf\Guard();
    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute("csrf_status", false);
        return $next($request, $response);
    });
    return $guard;
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// setting the upload dir
// $container['storage'] = function ($c) {
//     return new \Upload\Storage\FileSystem(UPLOADDIR);
// };

// setting for monolog
$container['monolog'] = function ($c) {
    $log = new Monolog\Logger($c['settings']['logger']['title']);

    $file_name = $c['settings']['logger']['directory']. '/'. $c['settings']['logger']['filename']. '_'. date('Y-m-d') . ".log";

    //  Default formatter

    if (!file_exists($file_name)){
        $new_file_name = fopen($file_name, "w+");  //creates new file if not exists
        $log_obj = $log -> pushHandler(new \Monolog\Handler\StreamHandler($new_file_name, $c['settings']['level']));
    }else{
        $log_obj = $log -> pushHandler(new \Monolog\Handler\StreamHandler($file_name, $c['settings']['level']));
    }

    // Customizing the log format

    // the default date format is "Y-m-d H:i:s"
    // $dateFormat = "Y n j, g:i a";

    // $dateFormat = "Y-m-d H:i:s";
    // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
    // $output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
    // $output = "%datetime% > %level_name% > %message% %context% %extra%\n";
    // finally, create a formatter
    // $formatter = new \Monolog\Formatter\LineFormatter($output, $dateFormat);

    // For stream file handler
    // if (!file_exists($file_name)){
    //     $new_file_name = fopen($file_name, "w+");   //creates new file if not exists

    //     $stream  = new \Monolog\Handler\StreamHandler($new_file_name, $c['settings']['level']);
    // }else{
    //     $stream  = new \Monolog\Handler\StreamHandler($file_name, $c['settings']['level']);
    // }

    // $formated_stream = $stream-> setFormatter($formatter);
    // $log_obj = $log -> pushHandler($formated_stream);

    // for rotating file handler
    // $rotating_stream  = new \Monolog\Handler\RotatingFileHandler($file_name, 1, $c['settings']['level']);
    // $formated_stream = $rotating_stream-> setFormatter($formatter);
    // $log_obj = $log -> pushHandler($formated_stream);

    // SwiftMailerHandler


    return $log_obj;

};


$container['Swinburne\Legacy\BaseForm'] = function ($c) {
    // return new Swinburne\Legacy\Form($c['renderer'], $c['router'], $c['flash'], $c['settings'], $c['monolog']);
    return new Swinburne\Legacy\BaseForm($c);
};

$container['Swinburne\Legacy\BaseAdminForm'] = function ($c) {
    // return new Swinburne\Legacy\Form($c['renderer'], $c['router'], $c['flash'], $c['settings'], $c['monolog']);
    return new Swinburne\Legacy\BaseAdminForm($c);
};

$container['Swinburne\Legacy\Form'] = function ($c) {
    // return new Swinburne\Legacy\Form($c['renderer'], $c['router'], $c['flash'], $c['settings'], $c['monolog']);
    return new Swinburne\Legacy\Form($c);
};


$container['Swinburne\Legacy\AdminForm'] = function ($c) {
    return new Swinburne\Legacy\AdminForm($c);
};


$container['renderer'] = function ($c) {
    // return new Slim\Views\PhpRenderer($c['view'], $c['router'], $c['flash']);
    return new \Slim\Views\PhpRenderer($c['settings']['renderer']['template_path']);
};

$container['medoo'] = function ($c) {
    //   $medoo = new Medoo\Medoo;
    //   $medoo($c['settings']['db']);
    //   return $medoo;
    try {
        // $env_variables = $c['dotenv'];
        //
        // $c['settings']['db']['username']  = getenv('DB_USERNAME');
        // $c['settings']['db']['password']  = getenv('DB_PASSWORD');

        return new Medoo\Medoo($c['settings']['db']);
    } catch (Exception $e) {
        $c['monolog'] -> debug("DB connection error:", [$e->getMessage()]);
    }


};

//DB Controller for tesing only
$container['Swinburne\Legacy\MedooDatabaseTest'] = function ($c) {
    //return new Swinburne\Legacy\MedooDatabaseTest($c['renderer'], $c['router'], $c['flash'], $c['settings'], $c['monolog'], $c['MedooDatabaseTestModel']);
    return new Swinburne\Legacy\MedooDatabaseTest($c);
};

//DB Model
$container['FormInsertModel'] = function ($c) {
    return new Swinburne\Legacy\MedooFormModel($c);
};

//Admin DB Model
$container['adminModel'] = function ($c) {
    return new Swinburne\Legacy\MedooAdminModel($c);
};

// $container['MedooDatabaseTestModel'] = function ($c) {
//     return new Swinburne\Legacy\MedooDatabaseTestModel($c);
// };

// File upload class
$container['fileUpload'] = function ($c) {
    return new Swinburne\Legacy\FileUpload($c['settings']);
};

// Email (Send) class
$container['sendEmail'] = function ($c) {
    return new Swinburne\Legacy\Email($c['settings'], $c['monolog']);

};

// PHPDotenv
// $container['dotenv'] = function ($c) {
//     $dotenv = new Dotenv\Dotenv(APPPATH.'/app', 'dbinfo.env');
//     return $dotenv->load();
// };
