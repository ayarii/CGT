<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Article;
use BlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{

    public function ajouterArticleAction(Request $request)
    {
        $Article = new Article();
        $form = $this->createForm(ArticleType::class, $Article);
        $form->add('photo', FileType::class, [

            'mapped' => false,
            'required' => false,
            'constraints' => [
                new \Symfony\Component\Validator\Constraints\File([
                    'maxSize' => '1024M',
                    'mimeTypesMessage' => 'Please upload a valid document',
                ])
            ],
        ]);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $Article->setDatecreation(new \DateTime("now", new \DateTimeZone('+0100')));
            $srcFile = $form->get('photo')->getData();
            if ($srcFile) {
                $originalFilename = pathinfo($srcFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $srcFile->guessExtension();

                try {
                    $srcFile->move('uploads/' . $Article->getPhoto(), $newFilename);
                } catch (FileException $e) {
                    print $e->getMessage();
                }
                $Article->setPhoto($newFilename);

            }


            $em->persist($Article);
            $em->flush();
            $this->get('session')->getFlashBag()->add('succes', " Ajout d'un nouveau Article avec succées !!!");
            return $this->redirectToRoute('afficherBlogAdmin');
        }


        return $this->render('@Blog/Blog/ajouterBlog.html.twig', array(
            'Article' => $Article,
            'form' => $form->createView(),

        ));
    }

    public function afficheArticleAction()
    {
        $em = $this ->getDoctrine()->getManager();
        $Article = $em->getRepository("BlogBundle:Article")->findAll();
        return $this->render('@Blog/Blog/afficherBlogAdmin.html.twig', array( 'Article'=>$Article ));

    }
    public function afficheArticleUserAction()
    {
        $em = $this ->getDoctrine()->getManager();
        $Article = $em->getRepository("BlogBundle:Article")->findAll();

        $Comment = $em->getRepository("BlogBundle:Comment")->findAll();
        return $this->render('@Blog/Blog/afficherBloguSER.html.twig', array( 'Article'=>$Article,
            'Comment'=>$Comment
            ));

    }

    public function detailBlogAdminAction($id)
    {
    $em = $this ->getDoctrine()->getManager();
        $Article = $em->getRepository("BlogBundle:Article")->findOneBy(array('id'=>$id));
        $Comment = $em->getRepository("BlogBundle:Comment")->findBy(array('idArticle'=>$id));
    return $this->render('@Blog/Blog/detailBlogAdmin.html.twig', array( 'article'=>$Article,
    'Comment'=>$Comment
    ));

    }

    public function detailBlogUserAction($id)
    {
        $em = $this ->getDoctrine()->getManager();
        $Article = $em->getRepository("BlogBundle:Article")->findOneBy(array('id'=>$id));
        $Comment = $em->getRepository("BlogBundle:Comment")->findBy(array('idArticle'=>$id));
        return $this->render('@Blog/Blog/detailBlogUser.html.twig', array( 'article'=>$Article,
            'Comment'=>$Comment
        ));

    }

    public function modifierArticleAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Article = $em->getRepository("BlogBundle:Article")->findOneBy(array('id'=>$id));
        $form = $this->createForm(ArticleType::class, $Article);

        $form->add('photo', FileType::class, [

            'mapped' => false,
            'required' => false,
            'constraints' => [
                new \Symfony\Component\Validator\Constraints\File([
                    'maxSize' => '1024M',
                    'mimeTypesMessage' => 'Please upload a valid document',
                ])
            ],
        ]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $srcFile = $form->get('photo')->getData();

            if ($srcFile) {
                $originalFilename = pathinfo($srcFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $srcFile->guessExtension();

                try {
                    $srcFile->move('uploads/' . $Article->getPhoto(), $newFilename);
                } catch (FileException $e) {
                    print $e->getMessage();
                }
                $Article->setPhoto($newFilename);

            }
            $em->persist($Article);
            $em->flush();
            return $this->redirectToRoute('afficherBlogAdmin');
        }
        return $this->render('@Blog/Blog/modifierBlog.html.twig', array(
            'form' => $form->createView(),

            'Article'=>$Article,
        ));
    }

    public function supprimerArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $Article = $em->getRepository("BlogBundle:Article")->find($id);
        $em->remove($Article);
        $em->flush();
        return $this->redirectToRoute('afficherBlogAdmin');
    }


}
