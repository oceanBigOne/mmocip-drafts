<?php
/**
 * Site
 *
 */
namespace Site;


use FastRoute\Route;

/**
 * Class App
 * @package Site
 */
class App
{


    /**
     * Liste des routes du site
     * @var array
     */
    private $routes=[];

    /**
     * App constructor.
     *
     * Initialise l'ensemble des routes
     */
    public function __construct()
    {

        $this->routes[]=['GET','/','home'];
        $this->routes[]=['GET','/{lang:en|fr}/','home'];

    }

    /**
     * Run
     *
     * Selectionne le contoleur et le template twig à afficher
     */
    public function run(){
        $routes=$this->routes;
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) use($routes) {
            foreach($routes as $route){
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        });

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);



        $loader = new \Twig_Loader_Filesystem('../src/template');
        $twig = new \Twig_Environment($loader, array(
            'cache' =>false,
        ));// '../cache' for cache

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                echo "Route non définie ...";
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $controller= $this->loadController($handler);
                $data=$controller->run($vars);
                if(!isset($vars["lang"])){
                    $vars["lang"]="fr"; //todo detecter langue navigateur ?
                }
                $path= $vars["lang"]."/".$handler.".html.twig";
                echo $twig->render($path,$data);
                break;
        }
    }

    /**
     * Charge un controlleur à partir d'une route
     * @param string $url route chargée
     * @return null|Controller
     */
    public function loadController(string $url)
    {
        $path = explode("/", parse_url($url, PHP_URL_PATH));

        $classname = "Site\\Controller";
        foreach ($path as $dir) {
            if ($dir != "") {
                $classname .= '\\' . $this->dir2Class($dir);
                if (class_exists($classname)) {

                    $controller = new $classname;
                    return $controller;
                }
            }


        }
        return null;


    }

    /**
     * Traduction du nom de dossier en nom de classe
     *
     * renvoi un nom de dossier sous forme de nom de classes controller
     * le caractère - délimite les mots dans le nom de dossier
     * les majuscules délimitent les mots dans les noms des classes Controller
     *
     * @param string $dir nom du dossier
     * @return string nom de la class
     */
    private function dir2Class(string $dir): string
    {
        $words = explode("-", $dir);
        $classname = "";
        foreach ($words as $word) {
            if ($word) {
                $classname .= ucfirst($word);
            }
        }
        return $classname;
    }


    /**
     * Traduction du nom de class en nom de dossier
     *
     * renvoi un nom de classe controller sous forme de nom de dossier
     * le caractère - délimite les mots dans le nom de dossier
     * les majuscules délimitent les mots dans les noms des classes Controller
     *
     * @param string $classname nom de la class
     * @return string nom de dossier
     */
    private function class2Dir(string $classname): string
    {
        $words = preg_split('/(?=[A-Z])/', $classname, -1, PREG_SPLIT_NO_EMPTY);
        $dir = "";
        foreach ($words as $word) {
            if ($word) {
                $dir .= "-" . strtolower($word);
            }
        }
        if ($dir == "") {
            $dir = strtolower($classname);
        }
        return substr($dir, 1);
    }




}

