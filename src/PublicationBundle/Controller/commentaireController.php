<?php

namespace PublicationBundle\Controller;

use http\Env\Response;
use PublicationBundle\Entity\commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class commentaireController extends Controller
{
    public function AjouterCommentAction(Request $request, $post_id)
    {
        $user = $this->getUser();
        $commentaire = new commentaire();
        $em = $this->getDoctrine()->getManager();
        $formcom = $this->createForm('PublicationBundle\Form\commentaireType', $commentaire);
        $post = $em->getRepository('PublicationBundle:Post')->find($post_id);
        $formcom->handleRequest($request);
            $nbcom=$post->getNbcomments();
            $commentaire->setPost($post);
            $commentaire->setIdUser($user);
            $commentaire->setDate(new \DateTime("now", new \DateTimeZone('+0100')));
            $contenue=$request->query->get("contenue");
            $commentaire->setContenue($contenue);
            $post->setNbcomments($nbcom+1);
            $em->persist($commentaire);
            $em->flush();
            $manager = $this->get('mgilet.notification');
            $phrase=$user->getUsername();
            $notif = $manager->createNotification($phrase);
            $notif->setMessage('a Commenté votre Publication');
            $notif->setLink("/showonepost/$post_id");
            $manager->addNotification(array($post->getIdauthor()), $notif, true);
            return  $this->redirectToRoute("publication_homepage");


    }

    public function editCommentAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire= $em->getRepository('PublicationBundle:commentaire')->find($id);
        $editFormcom = $this->createForm('PublicationBundle\Form\commentaireType', $commentaire);
        $editFormcom->handleRequest($request);
        if($request->isXmlHttpRequest())
        {$contenue=$request->request->get("contenue");
        echo "$contenue";
        $commentaire->setContenue($contenue);}
        $em->persist($commentaire);
        $em->flush();
        return  $this->redirectToRoute("publication_homepage");
    }
    public function deleteCommentAction($id_com,Request $request)
    {
        $user = $this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('PublicationBundle:commentaire')->find($id_com);
        if ($commentaire && ($commentaire->getpost()->getIdauthor()->getId() == $user->getId() || $user->isSuperAdmin()) ) {
            $nbcom=$commentaire->getpost()->getNbcomments();
            $commentaire->getpost()->setNbcomments($nbcom-1);
            $em->remove($commentaire);
            $em->flush();
        }
   return  $this->redirectToRoute("publication_homepage");
    }
    /**
     * Creates a form to delete a commentaire entity.
     *
     * @param Commentaire $commentaire The commentaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commentaire $commentaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentaire_delete', array('id' => $commentaire->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
    public function AffichierCommentsAction(Commentaire $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);

        return $this->render('commentaire/show.html.twig', array(
            'commentaire' => $commentaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function AfficheCommentsParPubAction($id_post)
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository('PublicationBundle:Commentaire')->findBy(array("Publication_id"=>$id_post));

        return $this->render('@Publication/Posts/Acceuil.html.twig', array(
            'comments' => $commentaires,
        ));
    }

    public function deleteCommentAAction($id_com,Request $request)
    {
        $user = $this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('PublicationBundle:commentaire')->find($id_com);
        if ($commentaire && ($commentaire->getpost()->getIdauthor()->getId() == $user->getId() || $user->isSuperAdmin()) ) {
            $nbcom=$commentaire->getpost()->getNbcomments();
            $commentaire->getpost()->setNbcomments($nbcom-1);
            $em->remove($commentaire);
            $em->flush();
        }
        return  $this->redirectToRoute("show_Admin_post");
    }
    public function AjouterCommentadAction(Request $request, $post_id)
    {
        $user = $this->getUser();
        $commentaire = new commentaire();
        $em = $this->getDoctrine()->getManager();
        $formcom = $this->createForm('PublicationBundle\Form\commentaireType', $commentaire);
        $post = $em->getRepository('PublicationBundle:Post')->find($post_id);
        $formcom->handleRequest($request);
        $nbcom=$post->getNbcomments();
        $commentaire->setPost($post);
        $commentaire->setIdUser($user);
        $commentaire->setDate(new \DateTime("now", new \DateTimeZone('+0100')));
        $contenue=$request->query->get("contenue");
        $commentaire->setContenue($contenue);
        $post->setNbcomments($nbcom+1);
        $em->persist($commentaire);
        $em->flush();
        $manager = $this->get('mgilet.notification');
        $phrase=$user->getUsername();
        $notif = $manager->createNotification($phrase);
        $notif->setMessage('Admin a Commenté votre Publication');
        $notif->setLink("/showonepost/$post_id");
        $manager->addNotification(array($post->getIdauthor()), $notif, true);
        return  $this->redirectToRoute("show_Admin_post");


    }
}