<?php

class Routing
{

    public static function buildRoute() {

        /* Контроллер и action по умолчанию */
        define("CONTROLLER_PATH", ROOT_DIR. "controllers/");
        $controllerName = "IndexController";
        $modelName = "IndexModel";
        $action = "index";

        $route = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $i = count($route)-1;

        while($i>0) {
            if($route[$i] != '') {
                if(is_file(CONTROLLER_PATH . ucfirst($route[$i]) . "Controller.php") || !empty($_GET)) {
                    $controllerName = ucfirst($route[$i]) . "Controller";
                    $modelName =  ucfirst($route[$i]) . "Model";
                    break;
                } else {
                     $action = $route[$i];
                }
            }
            $i--;
        }

        $controller = new $controllerName();
		    $controller->$action();

    }

    public function errorPage() {

    }

}
