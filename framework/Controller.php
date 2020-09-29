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


  public function CheckAdmin()
  {
    return ($this->request->getSession()->getAttribut("admin") == 1);

  }

  public function setRequest(Request $request) {
    $this->request = $request;
  }
   
  public function View($template, $data = [])
  {  
    $racineWeb = Configuration::get("racineWeb", "/");
    $data['racineWeb'] = $racineWeb;
    if($this->request->getSession()->existAttribut('login'))
    {
      $user = $this->request->getSession()->getAttribut('login');
      $data['user'] = $user ;
    }
    echo $this->twig->render($template, $data);
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