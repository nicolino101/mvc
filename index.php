<?php
require_once __DIR__.'/autoloader.php';

if(!defined('ROOT_DIR'))
    define('ROOT_DIR', '/phpunit');
if(!defined('APP_PATH'))
    define('APP_PATH', __DIR__.'/app');
    
$routes = ['/' => '/index.php',
           '/ftests' => '/ftests/index.php',
           '/index' => '/index.php',
           '/ftests/index' => '/ftests/index.php',
           '/ftests/test' => '/ftests/test.php',
           '/home' => ['page' => '/Controllers/Index.php', 
                       'controller' => '\App\Controllers\Index', 
                       'action' => 'index', 
                       'params' => []
           ],
            '/user' => ['page' => '/Controllers/Index.php',
                        'controller' => '\App\Controllers\Index',
                        'action' => 'user',
                        'params' => ['firstName' => "Frank", 'lastName' => 'Kennedy', 'email' => 'frank@yahoo.com']
            ]
    
           
];

require_once __DIR__.'/vendor/mvc/Router.php';
use Mvc\Router;
Router::route($routes); 