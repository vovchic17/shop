<?php

class NotFound extends Exception
{
}

class Router
{
    private static function dispatch($url)
    {
        $path = explode("?", $url)[0];
        $routes = explode("/", $path);
        $controller_name = $routes[1] ? $routes[1] : 'main';
        $controller_path = "app/controllers/$controller_name.php";
        $controller_class_name = ucfirst($controller_name) . "Controller";
        $model_path = "app/models/$controller_name.php";
        $action_name = $routes[2] ?? "index";
        if (file_exists($controller_path))
            include_once $controller_path;
        else
            throw new NotFound();
        if (file_exists($model_path))
            include_once $model_path;
        $controller = new $controller_class_name;
        if (method_exists($controller, $action_name))
            $controller->$action_name();
        else
            throw new NotFound();
    }

    public static function start()
    {
        // Попытка найти controller и action, если таких нет - 404
        try {
            Router::dispatch(
                $_SERVER["REQUEST_URI"]
            );
        } catch (NotFound $e) {
            // Код ответа - 404
            header(
                $_SERVER["SERVER_PROTOCOL"] . " 404 Not Found",
                true,
                404
            );
            include_once "app/controllers/page404.php";
            $controller = new Page404Controller();
            $controller->index();
            exit();
        }
    }
}