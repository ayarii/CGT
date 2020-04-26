<?php

namespace PublicationBundle\Controller;

use Nexmo\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller
{
    function DeletemediaAction(Request $request,$id_media)
    {
        $em=$this->getDoctrine()->getManager();
        $m=$em->getRepository('PublicationBundle:Media')->find($id_media);
        $em->remove($m);
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("");
    }
    function editMediaAction(Request $request,$id_media)
    {   $em=$this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest())
        {   $legende=$request->request->get('mediatype');
            $type=$request->request->get('mediatype');
            $media=$em->getRepository('PublicationBundle:Media')->find($id_media);
            $media->setType($type);
            $media->setDescription($legende);
            $em->persist($media);
            $em->flush();
        }
        return new \Symfony\Component\HttpFoundation\Response("");
    }
}
