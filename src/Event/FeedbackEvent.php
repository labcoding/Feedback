<?php

namespace LabCoding\Feedback\Event;

use Zend\EventManager\Event;
use T4webDomainInterface\EntityInterface;
use ArrayAccess;

class FeedbackEvent extends Event
{
    /**#@+
     * Events triggered by eventmanager
     */
    const EVENT_NEW_FEEDBACK = 'new.feedback';
    const EVENT_SEND_ANSWER = 'send.answer';
    /**#@-*/

    /**
     * Feedback entity
     *
     * @var EntityInterface
     */
    protected $entity;

    /**
     * Constructor
     *
     * Accept a target and its parameters.
     *
     * @param  string $name Event name
     * @param  string|object $target
     * @param  array|ArrayAccess $params
     */
    public function __construct($name = null, $target = null, $params = null)
    {
        parent::__construct($name, $target, $params);

        if (!isset($params['entity']) || !$params['entity'] instanceof EntityInterface) {
            throw new \RuntimeException('Bad param "entity"');
        }

        $this->entity = $params['entity'];
    }

    /**
     * Feedback entity
     * @return EntityInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param EntityInterface $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}
