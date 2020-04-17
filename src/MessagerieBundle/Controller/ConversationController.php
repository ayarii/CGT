<?php

namespace MessagerieBundle\Controller;
use MessagerieBundle\Entity\Conversation;
use MessagerieBundle\Form\ConversationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConversationController extends Controller
{

    public function AjoutConversationAction(Request $request)
    {
        $Conversation = new Conversation();
        $form = $this->createForm( ConversationType::class ,$Conversation);
        $form->handleRequest($request);
        $form1= $form->createView();
        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Conversation);
            $em->flush();
            return $this->redirectToRoute('affichC');
        }
        return $this->render('@Messagerie/Messagerie/affichConversation.html.twig',array('form'=>$form1));
    }



    public function affichConversationAction()
    {

        $em=$this->getDoctrine()->getManager();
        $user = $this->getUser();

        $Conversation =$em->getRepository("MessagerieBundle:Conversation")->findBy(array('idMe'=>$user->getId()));

      $users=$em->getRepository("FOSBundle:User")->findAll();


          $Message = $em->getRepository("MessagerieBundle:Message")->findAll();

          return $this->render('@Messagerie/Messagerie/affichConversation.html.twig', array('Conversation' => $Conversation,
              'Message' => $Message,
              'users' => $users,
          ));

    }



    public function suppConversationAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $Conversation=$em->getRepository(Conversation::class)->find($id);
        $em->remove($Conversation);
        $em->flush();
        return $this->redirectToRoute('affichC');
    }

    public function updateConversationAction (Request $request, $id)
    {
        $Conversation = new Conversation();
        $Conversation=$this->getDoctrine()->getRepository(Conversation::class )->find($id);
        $form = $this->createFormBuilder($Conversation)
            ->add('Nom')
            ->add('DateCreation')
            ->add('idMe')
            ->add('idUFriend')
            ->add('modifier',SubmitType::class)->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affichC');
        }

        return $this->render('@Messagerie/Messagerie/updateConversation.html.twig',array('f'=>$form->createView()));

    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $user = $this->getUser();
        $posts =  $em->getRepository('MessagerieBundle:Conversation')->findEntitiesByString($requestString);
        if(!$posts) {
            $result['posts']['error'] = "Conversation Not found :( ";
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($posts){
        foreach ($posts as $posts){
            $realEntities[$posts->getIdConversation()] = [$posts->getNom()];

        }
        return $realEntities;
    }
}
