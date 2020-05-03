<?php

namespace PublicationBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use PublicationBundle\Entity\Media;
use PublicationBundle\Entity\Post;
use PublicationBundle\Entity\reaction;
use PublicationBundle\Entity\Vote;
use PublicationBundle\Form\MediaType;
use PublicationBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CompetitionBundle\Entity\Competition;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PostController extends Controller
{
    public function DeletePostAction($id_post,Request $request)
    {
        $user = $this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Post')->find($id_post);

        if ($publication && ($publication->getIdauthor()->getId() == $user->getId() || $user->isSuperAdmin() )   ) {
            $em->getRepository('PublicationBundle:commentaire')->deletePostCommentaire($id_post);
            $em->getRepository('PublicationBundle:reaction')->removePostreaction($id_post);
            $em->getRepository('PublicationBundle:Vote')->removePostVote($id_post);
            $em->getRepository('PublicationBundle:Media')->removePostMedia($id_post);
            $em->remove($publication);
            $em->flush();
        }

        return $this->redirectToRoute("publication_homepage");
    }
    public function ModifierPostAction($id_post,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post= $em->getRepository('PublicationBundle:Post')->find($id_post);

        if($request->isXmlHttpRequest())
        {
            $contenu= $request->request->get('contenudupubmodif');
            $titre=$request->request->get('titredupubmodif');
            $lenght=$request->request->get('number');
            for ($i = 0; $i < $lenght; $i++) {
                $srcFile= $request->files->get('file'.$i);
                if ($srcFile) {
                    $originalFilename = pathinfo($srcFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $srcFile->guessExtension();

                    try {
                        $srcFile->move('uploads/' . $post->getType(), $newFilename);
                    } catch (FileException $e) {
                        print $e->getMessage();
                    }
                    $m = json_decode($request->request->get('media' . $i), true);
                    $media = new Media();
                    $media->setType("post");
                    $media->setMediatype($m['mediatype']);
                    $media->setSource($newFilename);
                    $post->addmedia($media);
                    $media->setIdpost($post);
                    $em->persist($media);
                }
            }
            $post->setTitre($titre);
            $post->setSrcPublication($contenu);
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('publication_homepage');
        }
        else{
        $editform = $this->createForm('PublicationBundle\Form\PostType', $post);

        $editform->add('contenue', FileType::class, [
            'label' => 'Content(video, text, image)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new \Symfony\Component\Validator\Constraints\File([
                    'maxSize' => '1024M',

                    'mimeTypesMessage' => 'Please upload a valid document',
                ])
            ],
        ]);
        $editform->handleRequest($request);
        if($editform->isSubmitted()&&$editform->isValid())
        {

            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('publication_homepage');
        }

        $comments=$em->getRepository('PublicationBundle:commentaire')->findBy(array());
        $reactions=$em->getRepository('PublicationBundle:reaction')->findBy(array());
        $votes=$em->getRepository('PublicationBundle:Vote')->findby(array());
       return $this->render('@Publication/Posts/edit-post.html.twig',array('editform'=>$editform->createView(),'post'=>$post,'comments'=>$comments,'reactions'=>$reactions));


    }
    }
    /**
     * Creates a form to delete a publication entity.
     *
     * @param Post $post
     *
     * @return Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publication_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
    public function affichagePostAction()
    {   $em=$this->getDoctrine()->getManager();
        $User=$this->getUser();
        $posts = $em->getRepository('PublicationBundle:Post')->findBy(array(), array('date'=>'DESC'));
        $comments=$em->getRepository('PublicationBundle:commentaire')->findBy(array());
        $reactions=$em->getRepository('PublicationBundle:reaction')->findBy(array());
        $votes=$em->getRepository('PublicationBundle:Vote')->findBy(array());
        $medias=$em->getRepository('PublicationBundle:Media')->findBy(array('idUser'=>$User->getId()));
        return $this->render('@Publication/Posts/newsfeed.html.twig',array('medias'=>$medias,'user'=>$User,'posts'=>$posts,'comments'=>$comments,'reactions'=>$reactions,'votes'=>$votes));
    }
    public function VoteAction($id_post,Request $request,$slug )
    {
        $user = $this->getUser() ;

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('PublicationBundle:Post')->find($id_post);
        $vote = $em->getRepository('PublicationBundle:Vote')->findOneBy(array('post'=>$id_post, 'idUser'=>$user->getId()));

        if ($post && !$vote ) {
            $vote = new Vote();
            $vote->setPost($post);
            $vote->setIdUser($user);
            $vote->setDate(new \DateTime("now", new \DateTimeZone('+0100')));
            $vote->setValeur($slug);
            $em->persist($vote);
            $em->flush();
            $post->setVotesPost($post->getVotespost($id_post) + $slug);
            $em->flush();
            $manager = $this->get('mgilet.notification');
            $phrase=$user->getUsername();
            $notif = $manager->createNotification($phrase);
            $notif->setMessage('a voté votre Publication');
            $notif->setLink("/showonepost/$id_post");
            $manager->addNotification(array($post->getIdauthor()), $notif, true);

        }

        elseif($post&&$vote)
        {
            if($vote->getValeur()==$slug)
            {
                $em->remove($vote);
                $em->flush();
                $post->setVotesPost($post->getVotespost($id_post) - $slug);
                $em->flush();
            }
            else
            {   $anc=$vote->getValeur();
                $vote->setValeur($slug);
                $em->persist($vote);
                $em->flush();
                $post->setVotesPost($post->getVotespost($id_post) + ($slug-$anc));
                $em->flush();
            }
        }

        return $this->redirectToRoute("publication_homepage");
    }
    public function ReactAction($id_post,Request $request,$type)
{
    $user = $this->getUser() ;

    $em = $this->getDoctrine()->getManager();
    $post = $em->getRepository('PublicationBundle:Post')->find($id_post);
    $react= $em->getRepository('PublicationBundle:reaction')->findOneBy(array('post'=>$id_post, 'idUser'=>$user->getId()));
    if ($post && !$react ) {
        $react = new reaction();
        $react->setPost($post);
        $react->setIdUser($user);
        $react->setDate(new \DateTime("now", new \DateTimeZone('+0100')));
        $react->setType($type);
        $em->persist($react);
        $em->flush();
        $post->setReactionPost($post->getReactionPost($id_post) + 1);
        $em->flush();
        $manager = $this->get('mgilet.notification');
        $phrase=$user->getUsername();
        $notif = $manager->createNotification($phrase);
        $notif->setMessage('a reagi a votre Publication');
        $notif->setLink("/showonepost/$id_post");
        $manager->addNotification(array($post->getIdauthor()), $notif, true);

    }

    elseif($post&&$react)
    {
        if($react->getType()==$type)
        {
            $em->remove($react);
            $em->flush();
            $post->setReactionPost($post->getReactionPost($id_post) - 1);
            $em->flush();
        }
        else
        {
            $react->setType($type);
            $em->persist($react);
            $em->flush();
            $post->setReactionPost($post->getReactionPost($id_post));
            $em->flush();
        }
    }

    return $this->redirectToRoute("publication_homepage");
}
    public function showoneAction(Request $request,$id_post)
  {
      $em=$this->getDoctrine()->getManager();
      $post = $em->getRepository('PublicationBundle:Post')->find($id_post);
      $medias=$em->getRepository('PublicationBundle:Media')->findBy(array('idpost'=>$id_post));
      foreach ($medias as $med)
      {
          $mediacontent[]=array(
              'idmedia'=>$med->getId(),
              'source'=>$med->getSource(),
              'type'=>$med->getType(),
              'Legende'=>$med->getDescription()
          );
      }
      if($request->isXmlHttpRequest())
      return $this->json(['medias'=>$mediacontent,'titre' => $post->getTitre(),'contenue'=>$post->getcontenue(),'type'=>$post->getType()]);
      else
         return new Response("");
  }
    public function visitprofileAction($id_user)
  {
      $em=$this->getDoctrine()->getManager();
      $User=$this->getUser();
      $utilisateur=$em->getRepository('FOSBundle:User')->findOneBy(array('id'=>$id_user));
      $posts = $em->getRepository('PublicationBundle:Post')->findBy(array('idauthor'=>$id_user), array('date'=>'DESC'));
      $comments=$em->getRepository('PublicationBundle:commentaire')->findBy(array());
      $reactions=$em->getRepository('PublicationBundle:reaction')->findBy(array());
      $votes=$em->getRepository('PublicationBundle:Vote')->findBy(array());
      $medias=$em->getRepository('PublicationBundle:Media')->findBy(array('idUser'=>$id_user));
      return $this->render('@Publication/Posts/profileview.html.twig',array('medias'=>$medias,'user'=>$User,'utilisateur'=>$utilisateur,'posts'=>$posts,'comments'=>$comments,'reactions'=>$reactions,'votes'=>$votes));

  }
    public function shareoneAction(Request $request,$id_post)
    {
        $em=$this->getDoctrine()->getManager();
        $post = $em->getRepository('PublicationBundle:Post')->find($id_post);
        $user=$em->getRepository('FOSBundle:User')->find($post->getIdauthor());
        if($request->isXmlHttpRequest())
            return $this->json(['imguser'=>$user->getImguser(),'nameuser'=>$user->getusername(),'titre' => $post->getTitre(),'contenue'=>$post->getcontenue(),'type'=>$post->getType()]);
        else
            return new Response("");
    }
    public function addpostajAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $User=$this->getUser();
        $post=new Post();
        $post->setIdauthor($User);
        $post->setDate(new \DateTime("now", new \DateTimeZone('+0100')));
        $post->setReactionPost(0);
        $post->setVotesPost(0);
        $post->setNbcomments(0);
        $post->setType("shared");
        if($request->isXmlHttpRequest())
        {   $contenue=$request->request->get("contenue");
            $post->setSrcPublication($contenue);
            $titre=$request->request->get("titre");
            $post->setTitre($titre);
            $em->persist($post);
            $em->flush();

        }

        return new Response("");
    }
    public function showPost1Action($id_post,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post= $em->getRepository('PublicationBundle:Post')->find($id_post);
        $posts=$em->getRepository('PublicationBundle:Post')->findAll();
        $comments=$em->getRepository('PublicationBundle:commentaire')->findBy(array());
        $reactions=$em->getRepository('PublicationBundle:reaction')->findBy(array());
        $votes=$em->getRepository('PublicationBundle:Vote')->findby(array());
        $medias=$em->getRepository('PublicationBundle:Media')->findBy(array('idpost'=>$id_post));
        if($post->getId()!=null)
        return $this->render('@Publication/Posts/onepost.html.twig',array('medias'=>$medias,'post'=>$post,'comments'=>$comments,'reactions'=>$reactions,'votes'=>$votes,'posts'=>$posts));
        else
            return $this->redirectToRoute('publication_homepage');


    }
    public function showPostforadminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $posts=$em->getRepository('PublicationBundle:Post')->findAll();
        $medias=$em->getRepository('PublicationBundle:Media')->findAll();
        $top3=$em->getRepository('PublicationBundle:Post')->findBy(array(), array('votesPost'=>'DESC'), 3);
        return $this->render('@Publication/Posts/adminPostside.html.twig',array('tp3'=>$top3,'user'=>$user,'posts'=>$posts,'medias'=>$medias));

    }
    public function showPost1AdiminAction($id_post,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $post= $em->getRepository('PublicationBundle:Post')->find($id_post);
        $posts=$em->getRepository('PublicationBundle:Post')->findAll();
        $comments=$em->getRepository('PublicationBundle:commentaire')->findBy(array());
        $reactions=$em->getRepository('PublicationBundle:reaction')->findBy(array());
        $votes=$em->getRepository('PublicationBundle:Vote')->findby(array());
        $medias=$em->getRepository('PublicationBundle:Media')->findAll();
        $top3=$em->getRepository('PublicationBundle:Post')->findBy(array(), array('votesPost'=>'DESC'), 3);
        if($post->getId()!=null)
            return $this->render('@Publication/Posts/view1postadmin.html.twig',array('medias'=>$medias,'tp3'=>$top3,'user'=>$user,'post'=>$post,'comments'=>$comments,'reactions'=>$reactions,'votes'=>$votes,'posts'=>$posts));
         else
             $this->redirectToRoute('show_Admin_posts');


    }
    public function DeletePostadAction($id_post,Request $request)
    {
        $user = $this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Post')->find($id_post);

        if ($publication && ($publication->getIdauthor()->getId() == $user->getId() || $user->isSuperAdmin() )   ) {
            $em->getRepository('PublicationBundle:commentaire')->deletePostCommentaire($id_post);
            $em->getRepository('PublicationBundle:reaction')->removePostreaction($id_post);
            $em->getRepository('PublicationBundle:Vote')->removePostVote($id_post);
            $em->getRepository('PublicationBundle:Media')->removePostmedia($id_post);
            $em->remove($publication);
            $em->flush();
        }

        return $this->redirectToRoute("show_Admin_posts");
    }
    public function chatbotcompAction(Request $request,$id_user)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository('FOSBundle:User')->find($id_user);
        $Comp=$em->getRepository("CompetitionBundle:Competition")->findOneBy(array('typedetalent'=>$user->getTypetalent()));
        if($request->isXmlHttpRequest()&&$Comp!=null)
        {
            return $this->json(['imgC'=>$Comp->getImagec(),'nameuser'=>$user->getusername(),'cout' => $Comp->getCout(),'datef'=>$Comp->getDatefin(),]);
        }
        else
        {
            return $this->json(['imgC'=>null,'nameuser'=>null,'cout' => null,'datef'=>null,]);
        }
      return new Response("");
    }
    public function tooop1Action(Request $request,$id_user)
    {
        $em = $this->getDoctrine()->getManager();
        $top = $em->getRepository('PublicationBundle:Post')->findOneBy(array('idauthor' => $id_user));
        if ($request->isXmlHttpRequest()) {
            return $this->json(['titre' => $top->getTitre(), 'contenue' => $top->getcontenue(), 'Votes' => $top->getVotesPost()]);
        }
    }
    public function newaddMixedPostAction(Request $req)
    {
        $User = $this->getUser();
        $post = new Post();
        $post->setIdauthor($User);
        $post->setDate(new \DateTime("now", new \DateTimeZone('+0100')));
        $post->setReactionPost(0);
        $post->setVotesPost(0);
        $post->setNbcomments(0);
        $post->setType("Mixed");
        $em = $this->getDoctrine()->getManager();

        // $medias=$req->request->get('mediacontainer');
        if($req->isXmlHttpRequest()){
        $contenue = $req->request->get("contenudupub");
        $titre = $req->request->get('titredupub');
        $lenght=$req->request->get('number');

        for ($i = 0; $i < $lenght; $i++) {
            $srcFile= $req->files->get('file'.$i);
            if ($srcFile) {
                $originalFilename = pathinfo($srcFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $srcFile->guessExtension();

                try {
                    $srcFile->move('uploads/' . $post->getType(), $newFilename);
                } catch (FileException $e) {
                    print $e->getMessage();
                }
                $m = json_decode($req->request->get('media' . $i), true);
                $media = new Media();
                $media->setIdUser($User);
                $media->setType("post");
                $media->setMediatype($m['mediatype']);
                $media->setSource($newFilename);
                $post->addmedia($media);
                $media->setIdpost($post);
                $em->persist($media);
            }
        }
        /*     foreach ($medias as $m) {
                 $media = new Media();
                 $media->setIdUser($User);
                 $media->setType("post");
                 $media->setMediatype($m['mediatype']);

                 $post->addmedia($media);
                 $media->setIdpost($post);
                 $em->persist($media);

                 }*/

        $post->setSrcPublication($contenue);
        $post->setTitre($titre);
        $em->persist($post);
        $em->flush();
    }


            return $this->redirectToRoute('publication_homepage');

    }


}


