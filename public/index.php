<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;

$router = new Router();
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/year/{y}', [HomeController::class, 'year']);
$router->dispatch();
