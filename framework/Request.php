<?php

namespace Framework;

use Framework\Session;

class Request
{

  private $parameters;
  private $session;

  public function __construct($parameters)
  {
    $this->parameters = $parameters;
    $this->session =  new Session;
  }


  public function existParameter($name)
  {
    return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
  }

  public function getSession()
  {
    return $this->session;
  }

  public function Parameter($name)
  {
    if ($this->existParameter($name)) {
      return $this->parameters[$name];
    } else
      throw new \Exception;
  }
}
