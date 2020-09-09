<?php
namespace Framework;

abstract class Controller
{
    private $action;
    protected $request;
    protected $twig;

  function __construct()
  {
    $loader = new \Twig\Loader\FilesystemLoader('View');
    $this->twig = new \Twig\Environment($loader, [
    'cache' => FALSE,
    ]);


  }

  public function checkSession()
  {
   return $this->request->getSession()->existAttribut("userId");
  }

    public function setRequest(Request $request) {
      $this->request = $request;
    }
   
    protected function redirect($controller, $action='', $id='')
 {
  $racineWeb = Configuration::get("racineWeb", "/");
  header('Location: ' . $racineWeb . $controller . '/' . $action . '/'.$id);
 }
    public function executeAction($action) {
      if (method_exists($this, $action)) {
        $this->action = $action;
        $this->{$this->action}();
      }
      else {
        $controllerClass = get_class($this);
        throw new \Exception("Action '$action' non définie dans la classe $controllerClass");
      }
    }

   
}