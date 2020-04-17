<?php


namespace FOSBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOSBundle\Entity\Amitie;

class ProfileUserController  extends Controller
{

    public function afficherProfileAction(Request $request,$id){
        $em=$this->getDoctrine()->getManager();
        $Profile=$em->getRepository("FOSBundle:User")->findOneBy(array('id'=>$id));
        $Amie=$em->getRepository("FOSBundle:Amitie")->findAll();
        return $this->render('@FOS/Default/profile.html.twig',
            array('Profile'=>$Profile,
                'Amie'=>$Amie,
            ));
    }

    public function sendRequestAction(Request $request,$id)
    {
        $Amitie = new Amitie();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $reciver=$em->getRepository('FOSBundle:User')->findOneBy(array('id'=>$id));
        $Amitie->setIduser1($user);
        $Amitie->setIduser2($reciver);
        $Amitie->setSenderid($user);
        $Amitie->setEtat(0);
        $Amitie->setBlockid(0);

        $em->persist($Amitie);
        $em->flush();
        return $this->redirectToRoute('profile',array(
            'id'=>$id,
            )
        );

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
        $Invitations=$em->getRepository("FOSBundle:Amitie")->findBy(array('iduser2'=>$user->getId(),'etat'=>0));
        return $this->render('@FOS/Default/invitations.html.twig',
            array('Invitations'=>$Invitations));

    }

    public function afficherFriendsAction(){
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $Friends1=$em->getRepository("FOSBundle:Amitie")->findBy(array('iduser1'=>$user->getId(),'etat'=>1));
        $Friends2=$em->getRepository("FOSBundle:Amitie")->findBy(array('iduser2'=>$user->getId(),'etat'=>1));

        return $this->render('@FOS/Default/friends.html.twig',
            array('Friends1'=>$Friends1,
                'Friends2'=>$Friends2,
                ));

    }

}