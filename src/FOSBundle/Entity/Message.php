<?php

namespace FOSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Entity\Message as BaseMessage;
use FOS\MessageBundle\Model\MessageMetadata;

/**
* @ORM\Entity
  @ORM\Table(name="fos_message")
 */
class Message extends BaseMessage
{
/**
* @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;

/**
* @ORM\ManyToOne(
*   targetEntity="FOSBundle\Entity\Thread",
*   inversedBy="messages"
* )
* @var \FOS\MessageBundle\Model\ThreadInterface
*/
protected $thread;

/**
* @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
* @var \FOS\MessageBundle\Model\ParticipantInterface
*/
protected $sender;

/**
* @ORM\OneToMany(
*   targetEntity="FOSBundle\Entity\MessageMetadata",
*   mappedBy="message",
*   cascade={"all"}
* )
* @var MessageMetadata[]|Collection
*/
protected $metadata;
}