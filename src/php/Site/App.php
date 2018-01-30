<?php
/**
 * Site
 *
 */
namespace Site;



use Illuminate\Database\Capsule\Manager as Capsule;
use Site\Twig\Extension\OnloadMessage;
use Site\Twig\Extension\PathOfController;
use Site\Twig\Extension\Session;
use Site\Twig\Extension\I18n;
use Site\Twig\Extension\Trans;
use Twig\TwigFilter as Twig_Filter;
use Site\Service\Route as Route;

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
     * @var \FastRoute\RouteCollector
     */
    private $routeCollector=null;

    /**
     * @var \FastRoute\Dispatcher
     */
    private $routeDispatcher=null;

    /**
     * @var array
     */
    private $routeInfo=[];

    /**
     * App constructor.
     *
     * Initialise l'ensemble des routes
     */
    public function __construct()
    {



    }

    /**
     *  définis et parse les routes de l'application
     */
    public function parseRoute($routes){

        $this->routes=$routes;

        $this->routeDispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r)  {
            foreach($this->routes as $route){
                $r->addRoute($route[0], $route[1], $route[2]);
            }
            $this->routeCollector=$r;
        });


        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        //selectionne la route
        $this->routeInfo=$this->routeDispatcher->dispatch($httpMethod, $uri);
    }

    /**
     * Renvoi le tableau contenant les éléments de la route
     * @return array route info [0]= code de retour, [1]= nom du controlleur, [2]= array avec les paramètres
     */
    public function getRouteInfo(){
        return $this->routeInfo;
    }

    /**
     * Run
     *
     * Selectionne le contoleur et le template twig à afficher
     */
    public function run($config_bdd,$locale,$defaultLocale){

        //bdd
        $capsule = new Capsule;
        $DB=$capsule->getDatabaseManager();

        $capsule->addConnection($config_bdd);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $DB->enableQueryLog();

        // Fetch method and URI from somewhere
        $routeInfo= $this->getRouteInfo();

        //TWIG
        $loader = new \Twig_Loader_Filesystem('../src/template');
        $twig = new \Twig_Environment($loader, array(
            'cache' =>false,
        ));
        //FLITRES TWIG
        $twig->addFilter(new Twig_Filter('toPath', 'Site\Twig\Filter\FormatString::toPath'));
        $twig->addExtension( new PathOfController());
        $twig->addExtension( new Session());
        $twig->addExtension(new I18n());
        $twig->addExtension(new Trans());
        $twig->addExtension(new OnloadMessage());


        if(isset($routeInfo[1])){
            $twig->addGlobal("controller",$routeInfo[1]);
        }
        $twig->addGlobal("locale",$locale);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                header("HTTP/1.0 404 Not Found");

                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                header("HTTP/1.0 405 Method Not Allowed");
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $controller= $this->loadController($handler);

                if(count($_POST)>0){
                    $vars=array_merge($vars,$_POST);
                }
                $data=$controller->run($vars);
                $path= $locale."/".$handler.".html.twig";

                //301

                if($_SERVER['REQUEST_URI']!=$controller->getUri() && $controller->getUri()!=""){
                    //echo $_SERVER['REQUEST_URI']."=".$controller->getUri();
                    header("Status: 301 Moved Permanently", false, 301);
                    header("Location: ".$controller->getUri());

                }


               // var_dump($vars);
              if(isset($vars["extension"])){
                if($vars["extension"]=="json"){
                    header('Content-Type: application/json');
                    $path="fr-fr/json.html.twig";
                }
              }





               try{
                    echo $twig->render($path,$data);
                }catch(\Twig_Error_Loader $e){
                   try{
                       $path= $defaultLocale."/".$handler.".html.twig";
                       echo $twig->render($path,$data);
                   }catch(\Twig_Error_Loader $e){
                       //$dataUrl=$vars;
                       //$dataUrl["lang"]="fr";
                       // $urlFR=$this->getPathOf($handler,$dataUrl);
                       // echo "Undefined route ... Maybe try another language : <a href='".$urlFR."'>$urlFR</a>";
                       //var_dump($vars);
                       //echo $e;
                        header("HTTP/1.0 404 Not Found");
                   }
                }
                break;
        }
        if(isset($_GET["debugsql"])){
            dd($DB->getQueryLog());
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
                $classname .= '\\' . Route::dir2Class($dir);
                if (class_exists($classname)) {

                    $controller = new $classname;
                    return $controller;
                }
            }


        }
        return null;


    }


    /**
     * Renvoi les routes enregistrés pour l'application
     * @return array
     */
    public function getRoutes():array{
        return $this->routes;
    }


    /**
     * Renvoi la route d'un controlleur spécifique
     * @param string $controller nom du controlleur
     * @param string $method (GET|POST) methode du lien
     * @param array $parameters tableau des paramètres du lien
     * @return string
     */
    public function getPathOf(string $controller,array $parameters,string $method="get"):string{

        //se place à la racine du namespace
        $controller=str_replace('Site\\Controller\\','',$controller);
        $method=strtolower($method);
        $revertedRoutes=[];
        $path="/";
        $out="/";

        foreach($this->routes as $route){
            $routeMethod=$route[0];
            if(is_array($routeMethod)){
                $routeMethod=null;
                foreach($route[0] as $routeByMethod){
                    if(strtolower($routeByMethod)==$method){
                        $routeMethod=$routeByMethod;
                    }
                }
            }
            $routePattern=$route[1];
            $routeController=$route[2];
            if( $routeController == $controller && (  strtolower($routeMethod)==$method  )){
                $revertedRoutes[]=[$method,$routePattern];
            }
        }
        $stringToReplace=[];
        $varsToReplace=[];
        $values=[];
        $vars=[];



        foreach($revertedRoutes as $route){
            $bIsGoodRoute=true;
            $path=$route[1];

            //supprime ce qui est optionnel
            preg_match_all('#\[(.*)\]#isU',$path,$vars);
            $stringToDelete=$vars[0];
            foreach($stringToDelete as $string){
               $path=str_replace($string,"",$path);
            }

            //identifie les éléments à remplacer dans la route
            preg_match_all('#{(.*)}#isU',$path,$vars);
            $stringToReplace=$vars[0];

            //identifie le nom des variables
            preg_match_all('#{(.*)(:|})#isU', $path,$vars);
            $varsToReplace=$vars[1];

            //identifie les valeurs possibles
            $n=0;
            foreach($stringToReplace as $pattern){
                if(isset($parameters[$varsToReplace[$n]])) {
                    $value = $parameters[$varsToReplace[$n]];
                    preg_match_all('#:(.*)}#isU', $pattern, $vars);
                    if (isset($vars[1][0])) {
                        $tmp = explode("|", $vars[1][0]);
                        $matchRegex = false;
                        foreach ($tmp as $possibility) {
                            if (strstr($possibility, "+") || strstr($possibility, "\\")) {
                                $matchRegex = preg_match('`' . $possibility . '`isU', $value);
                            }
                        }
                    } else {
                        $matchRegex = true;
                    }
                    // echo "[".$varsToReplace[$n]."=".$parameters[$varsToReplace[$n]]."]";
                    if (in_array($parameters[$varsToReplace[$n]], $tmp) || $matchRegex) {
                        $path = str_replace($pattern, $value, $path);

                    } else {
                        $bIsGoodRoute = false;
                    }
                }
                $n++;
            }
            if($bIsGoodRoute){
                $out=$path;
            }

        }
        return $out;
    }




}

