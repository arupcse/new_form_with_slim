<?php
// Route configuration

$app->map(['GET', 'POST'], '/form', 'Swinburne\Legacy\Form:legacyForm') ->setName('renderer');   // Added by Arup
$app->get('/Thankyou', 'Swinburne\Legacy\Form:thankYou') ->setName('thankyou');   // Added by Arup

$app->get('/emailError', 'Swinburne\Legacy\Form:emailError') ->setName('emailError');   // Added by Arup

$app->map(['GET', 'POST'], '/admin', 'Swinburne\Legacy\AdminForm:adminForm');   // Added by Arup
$app->get('/AdminThankyou', 'Swinburne\Legacy\AdminForm:adminThankYou') ->setName('adminthankyou');   // Added by Arup

$app->get('/showall', 'Swinburne\Legacy\Form:showAllRecords')->setName('showall');
$app->map(['GET', 'POST'], '/form/{id:[0-9]+}/view', 'Swinburne\Legacy\Form:viewForm') ->setName('view-form');   // Added by Arup
$app->map(['GET', 'POST'], '/form/{id:[0-9]+}/edit', 'Swinburne\Legacy\Form:editForm') ->setName('edit-form');   // Added by Arup
$app->map(['GET', 'POST'], '/form/{id:[0-9]+}/delete', 'Swinburne\Legacy\Form:deleteForm') ->setName('delete-form');   // Added by Arup

// $app->get('/dbselect', 'Swinburne\Legacy\MedooDatabaseTest:testSelect')->setName('dbselect');
$app->get('/dbinsert', 'Swinburne\Legacy\MedooDatabaseTest:testInsert');
$app->get('/dbdelete', 'Swinburne\Legacy\MedooDatabaseTest:testDelete');
