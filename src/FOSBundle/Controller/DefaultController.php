<?php

namespace FOSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FOSBundle:Default:index.html.twig');
    }
}
