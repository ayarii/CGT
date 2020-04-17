<?php

namespace MessagerieBundle\Controller;

use http\Env\Response;
use MessagerieBundle\Entity\Message;
use MessagerieBundle\Form\MessageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
    public function indextAction(Request $request , $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $Conversation=$em->getRepository("MessagerieBundle:Conversation")->findBy(array('idConversation'=>$id));
        $Message=$em->getRepository("MessagerieBundle:Message")->findBy(array('idConversation'=>$id));
        $users=$em->getRepository("FOSBundle:User")->findAll();


        return $this->render('@Messagerie/Messagerie/affichMessage.html.twig',
            array('Conversation'=>$Conversation,
                'Message'=>$Message,
                'users'=>$users,

            ));
      }


    public function AjoutAction(Request $request, $id)
    {
        $Message = new Message();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm( MessageType::class ,$Message);
        $Conversation=$em->getRepository("MessagerieBundle:Conversation")->find(array('idConversation'=>$id));
        $form->handleRequest($request);
        if($form->isSubmitted())
        {


            $Message->setIdSender($user);

            $Message->setDateMessage(new \DateTime("now"));
            $Message->setEtat("NotSeen");
            $em->persist($Message);
            $em->flush();
            $this->get('session')->getFlashBag()->add('succes'," envoie de Message avec succées !!!");
            return $this->affichAction($request,$id);
        }

        return $this->affichAction($request,$id);
    }

   /* public function newAction(Request $request, $publication_id)
    {
        $user = $this->getUser() ;
        $commentaire = new Commentaire();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('PublicationBundle\Form\CommentaireType', $commentaire);
        $publication = $em->getRepository('PublicationBundle:Publication')->find($publication_id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setPublicationId($publication);
            $commentaire->setUserIdPublication($user);
            $commentaire->setDateCommentaire(new \DateTime("now", new \DateTimeZone('+0100')));
            $em->persist($commentaire);
            $em->flush();
            return new Response($commentaire->getId());
        }

        return new Response("");

        /*return $this->render('commentaire/new.html.twig', array(
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ));
            return $this->render('@Messagerie/Messagerie/ajout.html.twig',
            array('form' => $form->createView() ,
                'Message'=> $Message ,
                'Conversation'=>$Conversation));
        }

        */









    public function affichAction(Request $request , $id)
    {

        $em=$this->getDoctrine()->getManager();
        $Conversation=$em->getRepository("MessagerieBundle:Conversation")->findBy(array('idConversation'=>$id));
        $Message=$em->getRepository("MessagerieBundle:Message")->findBy(array('idConversation'=>$id));
        $users=$em->getRepository("FOSBundle:User")->findAll();



        $user = $this->getUser();


        return $this->render('@Messagerie/Messagerie/affichMessage.html.twig',
            array('Conversation'=>$Conversation,
                'Message'=>$Message,
                'users'=>$users,

            ));

            }
    public function suppAction(Request $request ,$id ,$id1)
    {
        $em=$this->getDoctrine()->getManager();
        $Conversation=$em->getRepository("MessagerieBundle:Conversation")->findBy(array('idConversation'=>$id1));
        $Message=$em->getRepository(Message::class)->find($id);
        $em->remove($Message);
        $em->flush();
        $this->get('session')->getFlashBag()->add('succes'," Supprisson de message avec succées !!!");

        return $this->affichAction($request,$id1);
    }

    public function updateAction (Request $request, $id, $id1)
    {
        $Message = new Message();
        $Message= $this->getDoctrine()->getRepository(Message::class )->find($id);

        $Message->setEtat("Seen");

            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->affichAction($request,$id1);
    }




}
