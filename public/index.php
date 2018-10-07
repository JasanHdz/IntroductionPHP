<?php
ini_set('display_errors', 1);
ini_set('display_starup_error', 1);

error_reporting(E_ALL);

use Aura\Router\RouterContainer;

require '../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'cursophp',
    'username'  => 'root',
    'password'  => 'hasanazael',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
// Nos permite hacer todo como si estuviera en el contexto Global
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Nos va a servir para inicializar el ORM.
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
  $_SERVER,
  $_GET,
  $_POST,
  $_COOKIE,
  $_FILES
);

$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();
$map->get('index', '/introductionPHP/', [
  'controller' => 'App\Controllers\IndexController',
  'action' => 'indexAction'
]);
$map->get('addJobs', '/introductionPHP/jobs/add', '../addJob.php');

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);
if(!$route) {
  echo 'No route';
} else {
  $handlerData = $route->handler;
  $actionName = $handlerData['action'];
  $controllerName = $handlerData['controller'];
  // Creamos una nueva instancia del string handlerData de su posición controller que 
  // tiene como valor la declaración de la clase IndexData, por lo tanto estamos creando
  // una instancia directa de IndexController
  // $controller = new $handlerData['controller'];
  $controller = new $controllerName;
  // El objeto controller es un objeto de Tipo IndexController.
  // Ahora mandamos a llamar a la action del objeto IndexController.
  // Debemos poner parentesis al actionName para que mande a llamar a la function
  $controller->$actionName();


  // var_dump($route->handler);
}

// Si si encontraste esa ruta quiero que me digas cual es el manejador de esa ruta.
// var_dump($route->handler);

// $route = $_GET['route'] ?? '/';

// if($route == '/') {
//   require_once '../index.php';
// } elseif($route == 'addJob') {
//   require_once '../addJob.php';
// }
