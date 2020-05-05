<?php

namespace CompetitionBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CompetitionBundle\Entity\Competition;
use CompetitionBundle\Form\CompetitionType;
use evenementBundle\Form\evenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class CompetitionController extends Controller
{


    public function ajoutercompetitionAction(Request $request)
    {

        $Competition = new Competition();
        $user = $this->getUser();

        #$Competition->setIduser( $user->getId());
        $form = $this->createForm(CompetitionType::class, $Competition);
        $form->add('imagec', FileType::class, [

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
        $em = $this->getDoctrine()->getManager();
        #affichage de TOP 3 #
        #$louay = $em->getRepository('CompetitionBundle:Competition')->findBy(array(), array('cout'=>'DESC'), 3);#
        #$louay = $em->getRepository('CompetitionBundle:Competition')->findAll();#
        $louay = $em->getRepository('CompetitionBundle:Competition')->findBy(array('iduser' => $user->getId()));
        $Participation=$em->getRepository("CompetitionBundle:Participation")->findAll();

        if ($form->isSubmitted() && $form->isValid()) {



            $srcFile = $form->get('imagec')->getData();
            if ($srcFile) {
                $originalFilename = pathinfo($srcFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$srcFile->guessExtension();

                try {
                    $srcFile->move('uploads/' . $Competition->getImagec(), $newFilename);
                } catch (FileException $e) {
                    print $e->getMessage();
                }
                $Competition->setImagec($newFilename);

            }
            $Competition->setIduser($user);
            //$Competition->upload();

            $em->persist($Competition);
            $em->flush();



            $userManager = $this->get('fos_user.user_manager');
            $userall = $userManager->findUsers();

            $manager2 = $this->get('mgilet.notification');

            $notif=$manager2->createNotification($Competition->getIduser()->getImguser() ,$Competition->getIduser().'a ajouté une nouvelle Competition intitulé '.$Competition->getTitre(),'/affichercompetitionUser');


            foreach ($userall as $u)
            {
                if ($u->getId()!=$user->getId())
                {
                    $manager2->addNotification(array($u), $notif, true);
                }

            }

            //  return $this->redirectToRoute('evenement_show', array('id_evenement' => $evenement->getId_evenement()));
            $this->get('session')->getFlashBag()->add('succes'," Ajout d'une nouvelle Competition avec succées !!!");
            return $this->redirectToRoute('affichercompetition');
        }


        return $this->render('@Competition/Competition/ajouterCompetition.html.twig', array(
            'Competition'=>$Competition,
            'form' => $form->createView(),
            'louay'=>$louay,
            'Participation'=>$Participation,
        ));

    }

    public function afficherCompetitionAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $Competition=$em->getRepository("CompetitionBundle:Competition")->findAll();

        $Participation=$em->getRepository("CompetitionBundle:Participation")->findAll();

        $users=$em->getRepository("FOSBundle:User")->findAll();
        $now=(new \DateTime('now'));
        $Trending=$em->getRepository("CompetitionBundle:Competition")->findBy(array('datedebut'=>$now), array('datedebut'=>'DESC'), 3);


        /**
         * @var $paginator \Knp\Component\\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $Competition=$paginator ->paginate(
            $Competition, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)

        /*limit per page*/
        );

        return $this->render('@Competition/Competition/afficherCompetition.html.twig',
            array('Competition'=>$Competition,
                'Participation'=>$Participation,
                'users'=>$users,
                'Trending'=>$Trending,
                'now'=>$now,
            ));

    }

    public function afficherCompAction(){
        $em=$this->getDoctrine()->getManager();
        $louay=$em->getRepository("CompetitionBundle:Competition")->findAll();
        return $this->render('@Competition/Competition/ajouterCompetition.html.twig',
            array('louay'=>$louay));

    }

    public function afficherCompetitionUserAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $Competition=$em->getRepository("CompetitionBundle:Competition")->findAll();
        $user = $this->getUser();
        $Ticket =$em->getRepository("CompetitionBundle:Ticket")->findBy(array('iduser'=>$user->getId()));
        $Participation=$em->getRepository("CompetitionBundle:Participation")->findAll();

        /**
         * @var $paginator \Knp\Component\\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $Competition=$paginator ->paginate(
            $Competition, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)

        /*limit per page*/
        );


        foreach ($Competition as $evt) {

            $participations = $em->getRepository('CompetitionBundle:Participation')->findBy(array('idcompetition' => $evt->getIdcompetition(),'iduser' => $user->getId()));


            if ((count($participations) > 0) ) {
                $evt->setParticipe(true);
            } else {
                $evt->setParticipe(false);
            }


        }
        $now=(new \DateTime('now'));
        $Trending=$em->getRepository("CompetitionBundle:Competition")->findBy(array('datedebut'=>$now), array('datedebut'=>'DESC'), 3);
        foreach ($Trending as $evt) {

            $participations = $em->getRepository('CompetitionBundle:Participation')->findBy(array('idcompetition' => $evt->getIdcompetition(), 'iduser' => $user->getId()));


            if ((count($participations) > 0)) {
                $evt->setParticipe(true);
            } else {
                $evt->setParticipe(false);
            }
        }

        return $this->render('@Competition/Competition/afficherCompetitionUser.html.twig',
            array('Competition'=>$Competition,
                'Trending'=>$Trending,
                'now'=>$now,
                'Ticket'=>$Ticket,
                'Participation'=>$Participation,
            ));
    }

    public function afficherCompetitionAdminAction(){
        $em=$this->getDoctrine()->getManager();
        $Competition=$em->getRepository("CompetitionBundle:Competition")->findAll();
        $louay = $em->getRepository('CompetitionBundle:Competition')->findBy(array(), array('datedebut'=>'DESC'), 3);




        return $this->render('@Competition/Competition/afficherCompetitionAdmin.html.twig',
            array('Competition'=>$Competition,
                'louay'=>$louay



            ));
    }


    public function afficherTrendingCompetitionAction(){
        $em=$this->getDoctrine()->getManager();
        $now=(new \DateTime('now'));
        $user=$this->getUser();
        $Trending=$em->getRepository("CompetitionBundle:Competition")->findBy(array('datedebut'=>$now), array('datedebut'=>'DESC'), 3);

        foreach ($Trending as $evt) {

            $participations = $em->getRepository('CompetitionBundle:Participation')->findBy(array('idcompetition' => $evt->getIdcompetition(), 'iduser' => $user->getId()));


            if ((count($participations) > 0)) {
                $evt->setParticipe(true);
            } else {
                $evt->setParticipe(false);
            }
        }



        return $this->render('@Competition/Competition/afficherCompetitionAdmin.html.twig',
            array('Trending'=>$Trending,
            ));
    }





    public function supprimerCompetitionAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $Competition = $em->getRepository("CompetitionBundle:Competition")->find($id);
        $em->remove($Competition);
        $em->flush();
        return $this->redirectToRoute('affichercompetition');
    }

    public function supprimerCompetitionAdminAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $Competition = $em->getRepository("CompetitionBundle:Competition")->find($id);
        $em->remove($Competition);
        $em->flush();
        return $this->redirectToRoute('affichercompetitionAdmin');
    }

    public function modifiercompetitionAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $Competition = $em->getRepository("CompetitionBundle:Competition")->find($id);
        $form = $this->createForm(CompetitionType::class, $Competition);
        $louay = $em->getRepository('CompetitionBundle:Competition')->findBy(array('iduser' => $user->getId()));
        $Participation=$em->getRepository("CompetitionBundle:Participation")->findAll();

        $form->add('imagec', FileType::class, [

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

            $srcFile = $form->get('imagec')->getData();

            if ($srcFile) {
                $originalFilename = pathinfo($srcFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$srcFile->guessExtension();

                try {
                    $srcFile->move('uploads/' . $Competition->getImagec(), $newFilename);
                } catch (FileException $e) {
                    print $e->getMessage();
                }
                $Competition->setImagec($newFilename);

            }
            $em->persist($Competition);
            $em->flush();
            return $this->redirectToRoute('affichercompetition');
        }
        return $this->render('@Competition/Competition/modifierCompetition.html.twig', array(
            'form' => $form->createView(),
            'louay'=> $louay,
            'Participation'=>$Participation,
        ));
    }

    public function detailuserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Competition = $em->getRepository('CompetitionBundle:Competition')->find($id);
        $Participation=$em->getRepository("CompetitionBundle:Participation")->findAll();



        return $this->render('@Competition/Competition/detailComp.html.twig', array(
            'Competition' => $Competition,
            'Participation'=>$Participation,

        ));
    }
    public function canAction(Request $request)
    {
        return $this->render('@Competition/Competition/can.html.twig');
    }





    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $competition = $em->getRepository('CompetitionBundle:Competition')->findEntitiesByString($requestString);
        if (!$competition) {
            $result['Competition']['error'] = "Competition Not found :( ";
        } else {
            $result['Competition'] = $this->getRealEntities($competition);
        }
        return new Response(json_encode($result));
    }




    public function getRealEntities($competition)
    {
        foreach ($competition as $competition) {
            $realEntities[$competition->getIdcompetition()] = [$competition->getImagec(), $competition->getTitre()];

        }
        return $realEntities;
    }



    public function pieAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();

        $Competition = $em->getRepository("CompetitionBundle:Competition")->findAll();

        $note1 = $em->getRepository("CompetitionBundle:Competition")->findBy(array('typedetalent'=>"Dance"));
        $note2 = $em->getRepository("CompetitionBundle:Competition")->findBy(array('typedetalent'=>"Beatbox"));
        $note3 = $em->getRepository("CompetitionBundle:Competition")->findBy(array('typedetalent'=>"Musique"));
        $note4 = $em->getRepository("CompetitionBundle:Competition")->findBy(array('typedetalent'=>"Comédie"));

        $total=count($Competition);

        $total1=count($note1);
        $total2=count($note2);
        $total3=count($note3);
        $total4=count($note4);


        $data= array();
        $stat=['Type de talent', '%'];
        $nb=0;
        array_push($data,$stat);

        $stat=array();
        $nb1=($total1 *100)/$total;
        array_push($stat,'Dance',($nb1));
        $stat=['Dance',$nb1];
        array_push($data,$stat);

        $stat=array();
        $nb2=($total2 *100)/$total;
        array_push($stat,'Beatbox',($nb2));
        $stat=['Beatbox',$nb2];
        array_push($data,$stat);

        $stat=array();
        $nb3=($total3 *100)/$total;
        array_push($stat,'Musique',($nb3));
        $stat=['Musique',$nb3];
        array_push($data,$stat);

        $stat=array();
        $nb4=($total4 *100)/$total;
        array_push($stat,'Comédie',($nb4));
        $stat=['Comédie',$nb4];
        array_push($data,$stat);




        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des compétition
        par type de talent ');
        $pieChart->getOptions()->setHeight(600);
        $pieChart->getOptions()->setWidth(1200);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);





        return $this->render('@Competition/Competition/pie.html.twig',
            array('piechart' => $pieChart

            ));
    }







}
