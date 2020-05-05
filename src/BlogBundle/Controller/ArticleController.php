<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Article;
use BlogBundle\Entity\ReactBlog;
use BlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
        $React1= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('type'=>1));
        $React2= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('type'=>2));
        $React3= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('type'=>3));
        $React4= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('type'=>4));
        $React5= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('type'=>5));
        $React6= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('type'=>6));
        $React7= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('type'=>7));
        $React8= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('type'=>8));

        $Comment = $em->getRepository("BlogBundle:Comment")->findAll();
        return $this->render('@Blog/Blog/afficherBloguSER.html.twig', array( 'Article'=>$Article,
            'Comment'=>$Comment,
            'React1'=>$React1,
            'React2'=>$React2,
            'React3'=>$React3,
            'React4'=>$React4,
            'React5'=>$React5,
            'React6'=>$React6,
            'React7'=>$React7,
            'React8'=>$React8,
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
        $user=$this->getUser();
        $React1= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('idblog'=>$id,'type'=>1));
        $React2= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('idblog'=>$id,'type'=>2));
        $React3= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('idblog'=>$id,'type'=>3));
        $React4= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('idblog'=>$id,'type'=>4));
        $React5= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('idblog'=>$id,'type'=>5));
        $React6= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('idblog'=>$id,'type'=>6));
        $React7= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('idblog'=>$id,'type'=>7));
        $React8= $em->getRepository("BlogBundle:ReactBlog")->findBy(array('idblog'=>$id,'type'=>8));
        $Reactuser= $em->getRepository("BlogBundle:ReactBlog")->findOneBy(array('idblog'=>$id,'iduser'=>$user));
        $Article = $em->getRepository("BlogBundle:Article")->findOneBy(array('id'=>$id));
        $Comment = $em->getRepository("BlogBundle:Comment")->findBy(array('idArticle'=>$id));
        return $this->render('@Blog/Blog/detailBlogUser.html.twig', array( 'article'=>$Article,
            'Comment'=>$Comment,
            'React1'=>$React1,
            'React2'=>$React2,
            'React3'=>$React3,
            'React4'=>$React4,
            'React5'=>$React5,
            'React6'=>$React6,
            'React7'=>$React7,
            'React8'=>$React8,
            'Reactuser'=>$Reactuser,
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
                $newFilename = $safeFilename.'-'.uniqid().'.'.$srcFile->guessExtension();



                try {
                    $srcFile->move('uploads/' , $newFilename);
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

    public function AddReactAction($id,$type)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $userManager = $this->get('fos_user.user_manager');
        $userall = $userManager->findUsers();
        $Article = $em->getRepository("BlogBundle:Article")->find($id);
        $Exist= $em->getRepository("BlogBundle:ReactBlog")->findOneBy(array('iduser'=>$user,'idblog'=>$id));
        if($Exist)
        {



            $Exist->setType($type);

            $manager2 = $this->get('mgilet.notification');
            $notif=$manager2->createNotification($Exist->getIduser()->getImguser() ,$Exist->getType(),'/detailBlogUser/'.$id);


            foreach ($userall as $u)
            {
                if ($u->getId()!=$user->getId())
                {
                    $manager2->addNotification(array($u), $notif, true);
                }

            }

            $em->persist($Exist);
            $em->flush();
        }
        else
        {


            $React = new ReactBlog();
            $React->setIduser($user);
            $React->setIdblog($Article);
            $React->setType($type);


            $manager2 = $this->get('mgilet.notification');
            $notif=$manager2->createNotification($React->getIduser() ,$React->getType(),$React->getIduser()->getImguser());

            foreach ($userall as $u)
            {
                $manager2->addNotification(array($u), $notif, true);
            }

            $em->persist($React);
            $em->flush();

        }

        return $this->redirectToRoute('detailBlogUser',array('id'=>$id));
    }



}
