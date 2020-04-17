<?php


namespace CompetitionBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManagerInterface;

class CalendarEventListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // The original request so you can get filters from the calendar
        // Use the filter in your query for example

        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');


        // load events using your custom logic here,
        // for instance, retrieving events from a repository

        $competition = $this->entityManager->getRepository('CompetitionBundle:Competition')
            ->createQueryBuilder('event')
            ->where('event.datedebut BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();
        $comp = $this->entityManager->getRepository('CompetitionBundle:Competition')->findBy(array('datedebut'=>$startDate, 'datefin'=> $endDate));
        // $companyEvents and $companyEvent in this example
        // represent entities from your database, NOT instances of EventEntity
        // within this bundle.
        //
        // Create EventEntity instances and populate it's properties with data
        // from your own entities/database values.
        $now=new \DateTime("now", new \DateTimeZone('+0100'));
        foreach($competition as $companyEvent) {



            $eventEntity = new EventEntity($companyEvent->getTitre(), $companyEvent->getDatedebut(), null, true);


            //$eventEntity->setCssClass('.calendar-day-event'); // a custom class you may want to apply to event labels
            $eventEntity->setUrl('/detailuser/'.$companyEvent->getIdcompetition()); // url to send user to when event label is clicked


            //finally, add the event to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($eventEntity);
        }
    }
}