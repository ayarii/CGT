<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Form\CommentType;

class CommentController extends Controller
{

    public function AjouterCommentAction(Request $request, $id)
    {
        $user=$this->getUser();
        $Comment= new Comment();
        $em = $this->getDoctrine()->getManager();
        $Article= $em->getRepository('BlogBundle:Article')->find($id);
        $Comment->setDatecreation(new \DateTime("now", new \DateTimeZone('+0100')));
        $Comment->setIdUser($user);
        $Comment->setIdArticle($Article);
        $text=$request->query->get("text");
        $Comment->setText($text);





            $em->persist($Comment);
            $em->flush();
            return $this->redirectToRoute('detailBlogUser',array('id'=>$id));




    }

    public function afficherCommentAction($id)
    {
        $em = $this ->getDoctrine()->getManager();
        $Comment = $em->getRepository("BlogBundle:Comment")->findBy(array('idArticle'=>$id));
        return $this->render('@Blog/Blog/detailBlogUser.html.twig', array( 'Comment'=>$Comment ));

    }



    public function modifierCommentAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Comment = $em->getRepository("BlogBundle:Comment")->findOneBy(array('id'=>$id));
        $form = $this->createForm(CommentType::class, $Comment);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($Comment);
            $em->flush();
            return $this->redirectToRoute('detailBlogUser');
        }
        return $this->render('@Blog/Blog/detailBlogUser.html.twig', array(
            'form' => $form->createView(),

            'Comment'=>$Comment,
        ));
    }


    public function supprimerCommentAction($id,$id2)
    {
        $em = $this->getDoctrine()->getManager();

        $Comment = $em->getRepository("BlogBundle:Comment")->find($id);
        $em->remove($Comment);
        $em->flush();

        return $this->redirectToRoute('detailBlogUser',array('id'=>$id2));

    }


}
