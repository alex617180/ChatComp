<?php

use app\View;
use app\lib\Db;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use League\Plates\Engine;

class Router
{
    protected $ContainerBuilder;
    protected $handler;
    protected $vars;

    public function __construct()
    {
        $this->ContainerBuilder = new DI\ContainerBuilder();
    }

    private function DefinitionsDI()
    {
        return [
            Engine::class => function () {
                return new Engine('../app/views');
            },
            Auth::class => function () {
                $pdo = Db::getInstance();
                $db = $pdo->db;
                return new Auth($db);
            },
            QueryFactory::class => function () {
                return new QueryFactory('mysql');
            },
            Db::class => function () {
                return Db::getInstance();
            }
        ];
    }

    public function getRout()
    {
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $dispatcher = require '../app/config/routes.php';
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                View::errorCode(404);
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                View::errorCode(403);
                break;
            case FastRoute\Dispatcher::FOUND:
                $this->handler = $routeInfo[1];
                $this->vars = $routeInfo[2];
                break;
        }
    }

    public function run()
    {
        $this->getRout();
        $DefinitionsDI = $this->DefinitionsDI();
        $this->ContainerBuilder->addDefinitions($DefinitionsDI);
        $container = $this->ContainerBuilder->build();
        // d($container);die;        
        // ... call $handler with $vars
        $container->call($this->handler, $this->vars);
    }
}
