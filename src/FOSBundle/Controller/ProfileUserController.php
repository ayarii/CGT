<?php


namespace FOSBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOSBundle\Entity\Amitie;

class ProfileUserController  extends Controller
{



    public function sendRequestAction(Request $request,$id)
    {
        $Amitie = new Amitie();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $reciver=$em->getRepository('FOSBundle:User')->findOneBy(array('id'=>$id));
        $Amitie->setIdme($user);
        $Amitie->setIduser($reciver);
        $Amitie->setSenderid($user);
        $Amitie->setEtat(0);
        $Amitie->setBlockid(0);

        $em->persist($Amitie);
        $em->flush();

        return $this->redirectToRoute('visit_profile',array('id_user'=>$id));

    }


    public function acceptRequestAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $amitie=$em->getRepository('FOSBundle:Amitie')->findOneBy(array('idamitie'=>$id));
        $amitie->setEtat(1);
        $em->persist($amitie);
        $em->flush();
        return $this->redirectToRoute('afficherInvitation');
    }

    public function supprimerRequestAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $Amitie = $em->getRepository("FOSBundle:Amitie")->findOneBy(array('idamitie'=>$id));
        $em->remove($Amitie);
        $em->flush();
        return $this->redirectToRoute('afficherInvitation');
    }


    public function afficherRequestAction(){
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $Invitations=$em->getRepository("FOSBundle:Amitie")->findBy(array('iduser'=>$user->getId(),'etat'=>0));
        return $this->render('@FOS/Default/invitations.html.twig',
            array('Invitations'=>$Invitations));

    }



}