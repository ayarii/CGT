<?php

namespace FOSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    public function redirectAction()
    {
        $user=$this->getUser();
        if($user)
        {
            if(!($user->isSuperAdmin()))
            {

                if ($user->getTypecompte()=='Chasseur du talent')
                    return $this->redirectToRoute('affichercompetition');
                else if ($user->getTypecompte()=='Simple Utilisateur')
                {
                    return $this->redirectToRoute('affichercompetitionUser');
                }
            }
            else if (($user->isSuperAdmin()))
            {
                return $this->redirectToRoute('affichercompetitionAdmin');
            }


        }



        return $this->redirectToRoute('fos_user_security_login');
    }

}
