<?php

namespace Swinburne\Legacy;

// require_once('get_ip_country.php');
// use Slim\Router;
// use Slim\Flash\Messages as FlashMessages;
// use Slim\Views\PhpRenderer;
// use Respect\Validation\Validator as v;
// use Respect\Validation\Exceptions\NestedValidationException;
// use Monolog;
// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;
use Interop\Container\ContainerInterface;
// use Dotenv\Dotenv;


// use Upload;

class Form extends \Base\BaseForm
{
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

    public function newLegacyForm(Request $request, Response $response)
    {
        $request_data = $request->getParsedBody();
        if (!$request_data) {
            $this->view->render($response, 'templates/public/header.php', $this->data);
            $this->view->render($response, 'form.php', $this->data);
            $this->view->render($response, 'templates/public/footer.php', $this->data);
        } else {
            echo "Process the form";
        }
    }

} // End of Class
