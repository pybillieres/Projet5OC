<?php
namespace Framework;
use Framework\Controller;

abstract class SecureController extends Controller
{

    public function executeAction($action)
    {
        if ($this->request->getSession()->existAttribut("userId")) {
            parent::executeAction($action);
        }
        else {
            //a voir
        }
    }

}

