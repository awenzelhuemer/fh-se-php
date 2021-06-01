<?php

namespace Presentation\MVC;

use Exception;

final class MVC
{
    public function __construct(
        private string $viewPath = 'views/',
        private string $controllerNamespace = 'Presentation\\Controllers',
        private string $defaultController = 'Home',
        private string $defaultAction = 'Index',
        private string $controllerParameterName = 'c',
        private string $actionParameterName = 'a',
        private string $errorController = "Error404"
    )
    {
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }

    public function getControllerParameterName(): string
    {
        return $this->controllerParameterName;
    }

    public function getActionParameterName(): string
    {
        return $this->actionParameterName;
    }

    public function buildActionLink(?string $controller = null, ?string $action, array $params = []): string
    {
        $res = '?' . $this->controllerParameterName . '=' . rawurlencode($controller ?? $this->defaultController) . '&' . $this->actionParameterName . '=' . rawurlencode($action ?? $this->defaultAction);
        foreach ($params as $name => $value) {
            $res .= '&' . rawurlencode($name) . '=' . rawurlencode($value);
        }
        return $res;
    }

    public function handleRequest(\ServiceProvider $serviceProvider): void
    {
        // determine controller class
        $controllerName = $_REQUEST[$this->controllerParameterName] ?? $this->defaultController;
        $controller = $this->controllerNamespace . "\\$controllerName";
        // determine HTTP method and action
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_REQUEST[$this->actionParameterName] ?? $this->defaultAction;
        // instanciate controller and call according action method
        $m = $method . '_' . $action;

        $controllerObject = null;
        try {
            $controllerObject = $serviceProvider->resolve($controller);

            if (!method_exists($controllerObject, $m)) {
                throw new Exception("Method does not exist!");
            }
        } catch (\Exception) { // fallback to error404
            $controller = $this->controllerNamespace . "\\$this->errorController";
            $controllerObject = $serviceProvider->resolve($controller); // resolve with error controller
            $m = "GET_" . $this->defaultAction; // set action to index
        }

        $res = $controllerObject->$m();

        if (!is_a($res, ActionResult::class)) {
            throw new Exception("Return value of controller action '$controllerName:$m' is not an instance of ActionResult.");
        }

        // handle result
        $res->handle($this);
    }
}
