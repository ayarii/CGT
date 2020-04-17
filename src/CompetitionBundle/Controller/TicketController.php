<?php

namespace CompetitionBundle\Controller;


use CompetitionBundle\Entity\Competition;
use CompetitionBundle\Entity\Ticket;
use CompetitionBundle\Form\CompetitionType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TicketController extends Controller
{

    public function ajouterTicketAction(Request $request , $id,$type)
    {

        $Ticket = new Ticket();
        $Ticket->setDateemission(new \DateTime("now", new \DateTimeZone('+0100')));
        $user = $this->getUser();

        $random = random_int(1000, 1000000);
        $Ticket->setMotDePasse($random);
        $Ticket->setIduser($user);





        $em = $this->getDoctrine()->getManager();
        $idc=$em->getRepository('CompetitionBundle:Competition')->find($id);
        $Ticket->setIdcompetition($idc);
        $em->persist($Ticket);
        $em->flush();
        return $this->redirectToRoute('Ticket', array(
            'id' => $id,
            'type'=>$type,

        ));

        //  return $this->redirectToRoute('evenement_show', array('id_evenement' => $evenement->getId_evenement()));



    }

    public function afficherTicketAction(Request $request , $id,$type){
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $comp=$em->getRepository("CompetitionBundle:Competition")->findBy(array('idcompetition'=>$id));
        $Ticket=$em->getRepository("CompetitionBundle:Ticket")->findBy(array('idcompetition'=>$id,'iduser'=>$user->getId()));
        $users=$em->getRepository("FOSBundle:User")->findAll();
        $comptype=$em->getRepository("CompetitionBundle:Competition")->findBy(array('typedetalent'=>$type));
        $Participation=$em->getRepository("CompetitionBundle:Participation")->findAll();

        foreach ($comptype as $x)
        {

            $participations = $em->getRepository('CompetitionBundle:Participation')->findBy(array('idcompetition' => $x->getIdcompetition(),'iduser' => $user->getId()));

            if ((count($participations) > 0) ) {
                $x->setParticipe(true);
            } else {
                $x->setParticipe(false);
            }

        }



        $user = $this->getUser();
        foreach ($comp as $c)
        {
            foreach ($users as $u)
            {
                $participations = $em->getRepository('CompetitionBundle:Participation')->findBy(array('idcompetition' => $c->getIdcompetition(),'iduser' => $u->getId()));

            }

        }

        return $this->render('@Competition/Competition/Ticket.html.twig',
            array('Ticket'=>$Ticket,
                'comp'=>$comp,
                'Participation'=>$participations,
                'comptype'=>$comptype,
                'participation'=>$Participation,

            ));
    }

    public function supprimerTicketAction($id,$id1)
    {
        $em = $this->getDoctrine()->getManager();

        $Ticket = $em->getRepository("CompetitionBundle:Ticket")->findOneBy(array('idcompetition'=>$id,'iduser'=>$id1));
        $em->remove($Ticket);
        $em->flush();
        return $this->redirectToRoute('affichercompetitionUser');
    }

    public function pdfAction($id,Request $request)

    {

        $em=$this->getDoctrine()->getManager();
        $ticket = $em->getRepository('CompetitionBundle:Ticket')->find($id);
        // $ id tu vas recuperer la ticket mel base get doctrime findby
        // Configure Dompdf according to your needs
        $options = new Options();
        // Pour simplifier l'affichage des images, on autorise dompdf à utiliser
        // des  url pour les nom de  fichier
        $options->set('isRemoteEnabled', true);
        // On crée une instance de dompdf avec  les options définies
        $dompdf = new Dompdf($options);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('@Competition/Competition/TicketPDF.html.twig', array(

            'ticket'=>$ticket,


        ));


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'


        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        return new Response ($dompdf->stream());

    }




}
