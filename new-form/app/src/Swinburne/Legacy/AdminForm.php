<?php
namespace Swinburne\Legacy;

use Interop\Container\ContainerInterface;

/**
 * all functions related to admin task
 */

class AdminForm extends \Base\BaseAdminForm
{
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

} // End of Class
