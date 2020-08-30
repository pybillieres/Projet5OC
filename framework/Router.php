<?php

namespace Framework;
use Framework\Request;
use Controller\MovieController;
use Controller\ReviewController;
use Controller\ApiController;
use Controller\ConnectionController;



class Router {

    public function routeRequest() {
      try {
        $request = new Request(array_merge($_GET, $_POST));
        $controller = $this->createController($request);
        $action = $this->createAction($request);
        $controller->executeAction($action);
      }
      catch (\Exception $e) {
        $this->manageError($e);
      }
    }

  

    private function createController(Request $request) {
      $controller = "Movie";
      if ($request->existParameter('controller')) {
        $controller = $request->Parameter('controller');
        $controller = ucfirst(strtolower($controller));
      }
      $controllerClass = $controller . 'Controller';
      $controllerClassNamespace =  '\\Controller\\'.$controllerClass;
        $controller = new $controllerClassNamespace;
        $controller->setRequest($request);
        return $controller;
    }
  

    private function createAction(Request $request) {
      $action = "index";
      if ($request->existParameter('action')) {
        $action = $request->Parameter('action');
      }
      return $action;
    }
  

    private function manageError(\Exception $exception) {
    }
  }

