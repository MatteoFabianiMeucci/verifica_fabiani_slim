<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/DocentiController.php';
require __DIR__ . '/controllers/ScuoleController.php';

$app = AppFactory::create();

//SCUOLE

$app->get('/scuole', "ScuoleController:index");

$app->get('/scuole/{id:\d+}', "ScuoleController:show");

$app->post('/scuole', "ScuoleController:create");

$app->put('/scuole/{id:\d+}', "ScuoleController:update");

$app->delete('/scuole/{id:\d+}', "ScuoleController:destroy");

//DOCENTI

$app->get('/scuole/{scuola_id}/docenti', "DocentiController:index");

$app->get('/scuole/{scuola_id}/docenti/{id:\d+}', "DocentiController:show");

$app->post('/scuole/{scuola_id}/docenti', "DocentiController:create");

$app->put('/scuole/{scuola_id}/docenti/{docente_id:\d+}', "DocentiController:update");

$app->delete('/docenti/{id:\d+}', "DocentiController:destroy");

$app->run();
