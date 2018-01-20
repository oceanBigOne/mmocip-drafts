<?php
/**
 * Site
 *
 */
namespace Site;



use Illuminate\Database\Capsule\Manager as Capsule;
use Site\Twig\Extension\PathOfController;
use Site\Twig\Extension\Session;
use Site\Twig\Extension\I18n;
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


               // var_dump($vars);
              if(isset($vars["extension"])){
                if($vars["extension"]=="json"){
                    header('Content-Type: application/json');
                    $path="fr-fr/json.html.twig";
                }
              }
                //todo : redirection 301 sur les changements de noms dans les liens
                /*if($this->getPathOf($handler,$vars)!=$uri){
                    header("Status: 301 Moved Permanently", false, 301);
                    header("Location: ".$this->getPathOf($handler,$vars));
                }*/
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
            if(is_array($routeMethod)){
                $routeMethod=$route[0][0];
            }
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
            $dirstmp= explode("/",$regex);
            $dirs=[];
            foreach($dirstmp as $dir) {
                if(strstr($dir,".")) {
                    $n=0;
                    $dirstmppoint=explode(".",$dir);
                    foreach($dirstmppoint as $dirpoint){
                        if($n==count($dirstmppoint)){
                            array_push($dirs,$dirpoint);
                        }else{
                            array_push($dirs,$dirpoint.".");
                        }
                        $n++;
                    }

                }else{
                    array_push($dirs,$dir);
                }
            }
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
                        if($value!=="" && $match ){
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

