<?php

namespace MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirectToRoute('fos_user_security_login');
    }
}
