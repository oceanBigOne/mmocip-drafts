<?php
/**
 * Site
 *
 */
namespace Site;



use Illuminate\Database\Capsule\Manager as Capsule;
use Site\TwigExtension\PathOfController;
use Twig\TwigFilter as Twig_Filter;

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
     * App constructor.
     *
     * Initialise l'ensemble des routes
     */
    public function __construct()
    {

        $this->routes[]=['GET','/{lang:en|fr}[/]','home'];

        $this->routes[]=['GET','/{lang:fr}/debats[/]','debats'];
        $this->routes[]=['GET','/{lang:en}/debates[/]','debats'];

        $this->routes[]=['GET','/{lang:fr}/debat/{id:\d+}/{name}[/]','debat'];
        $this->routes[]=['GET','/{lang:en}/debate/{id:\d+}/{name}[/]','debat'];

        $this->routes[]=['GET','/{lang:fr}/utilisateurs[/]','users'];
        $this->routes[]=['GET','/{lang:en}/users[/]','users'];

    }

    /**
     * Run
     *
     * Selectionne le contoleur et le template twig à afficher
     */
    public function run($CONFIG){

        //bdd
        $capsule = new Capsule;
        $DB=$capsule->getDatabaseManager();

        $capsule->addConnection($CONFIG["bdd"]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $DB->enableQueryLog();



        //parse toutes les routes
        $this->routeDispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r)  {
            foreach($this->routes as $route){
                $r->addRoute($route[0], $route[1], $route[2]);
            }
            $this->routeCollector=$r;
        });

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);


        //TWIG
        $loader = new \Twig_Loader_Filesystem('../src/template');
        $twig = new \Twig_Environment($loader, array(
            'cache' =>false,
        ));
        //FLITRES TWIG
        $twig->addFilter(new Twig_Filter('toPath', 'Site\TwigFilter\FormatString::toPath'));
        $twig->addExtension( new PathOfController());


        //selectionne la route
        $routeInfo =  $this->routeDispatcher->dispatch($httpMethod, $uri);

        if(isset($routeInfo[1])){
            $twig->addGlobal("controller",$routeInfo[1]);
        }

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
               // echo "Undefined route ...";
                header("HTTP/1.0 404 Not Found");

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

                //todo : redirection 301 sur les changements de noms dans les liens
                /*if($this->getPathOf($handler,$vars)!=$uri){
                    header("Status: 301 Moved Permanently", false, 301);
                    header("Location: ".$this->getPathOf($handler,$vars));
                }*/
               try{
                    echo $twig->render($path,$data);
                }catch(\Twig_Error_Loader $e){
                   //$dataUrl=$vars;
                   //$dataUrl["lang"]="fr";
                  // $urlFR=$this->getPathOf($handler,$dataUrl);
                  // echo "Undefined route ... Maybe try another language : <a href='".$urlFR."'>$urlFR</a>";
                   header("HTTP/1.0 404 Not Found");

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


    /**
     * Renvoi les routes enregistrés pour l'application
     * @return array
     */
    public function getRoutes():array{
        return $this->routes;
    }

    /**
     * Renvoi la route d'un controlleur spécifique
     * @return string
     */
    public function getPathOf(string $controller,$parameters):string{

        $revertedRoutes=[];
        foreach($this->routes as $route){
            $routeMethod=$route[0];
            $routeRegex=$route[1];
            $routeController=$route[2];
            if( $routeController == $controller && ( strtolower($routeMethod)=="get" || strtolower($routeMethod)=="post" )){
                $revertedRoutes[]=$routeRegex;
            }
        }
        $goodRegex="";
        $out="";
        $match=true;
        foreach( $revertedRoutes as $regex){
            $out="";
            $match=true;
            $regex=str_replace('[/]','',$regex);
            $dirs=explode("/",$regex);
            foreach($dirs as $dir){

                if(strstr($dir,"{")){
                    $dir=str_replace(['{','}'],['',''],$dir);
                    $param=explode(":",$dir);
                    $field=$param[0];
                    if(isset($parameters[$field])){
                        if(count($param)>1){
                            $values=explode("|",$param[1]);
                        }else{
                            $values=["\*"];
                        }
                        $value="";
                        if(count($values)>1){
                            foreach($values as $val){

                                if(preg_match("#".$val."#",$parameters[$field])==1){
                                    $value=$val;
                                }

                            }
                        }else{

                            if (preg_match("#" . $values[0] . "#", $parameters[$field]) == 1 || $values[0] == "\*") {
                                $value = $parameters[$field];
                            }

                        }
                        if($value!="" && $match ){
                            $out.=$value."/";

                        }else{
                            $match=false;
                        }
                    }else{
                        $match=false;
                    }

                }else{
                    if($match){
                        $out.=$dir."/";

                    }

                }
            }

            if($match){
                $goodRegex=$regex;
                break;
            }
        }
        if($out==""){
            $out="#";
        }
        if(substr($goodRegex,-1)!="/"){
            $out=substr($out,0,-1);
        }
        return $out;
    }




}

