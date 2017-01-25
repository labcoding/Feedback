<?php

namespace LabCoding\Feedback\Action\Backend\AnswerAction;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\RequestInterface;
use Zend\InputFilter\InputFilterInterface;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use LabCoding\Feedback\ViewModel\JsonViewModel;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use LabCoding\Feedback\Domain\Feedback;
use LabCoding\Feedback\Event\FeedbackEvent;

class AnswerActionController extends AbstractActionController
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var JsonViewModel
     */
    protected $viewModel;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * AnswerActionController constructor.
     *
     * @param $id
     * @param RequestInterface $request
     * @param InputFilterInterface $inputFilter
     * @param RepositoryInterface $repository
     * @param JsonViewModel $viewModel
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        $id,
        RequestInterface $request,
        InputFilterInterface $inputFilter,
        RepositoryInterface $repository,
        JsonViewModel $viewModel,
        EventManagerInterface $eventManager
    )
    {
        $this->id = $id;
        $this->request = $request;
        $this->inputFilter = $inputFilter;
        $this->repository = $repository;
        $this->viewModel = $viewModel;
        $this->eventManager = $eventManager;

        $this->eventManager->setIdentifiers('Feedback');
    }

    /**
     * @param MvcEvent $e
     * @return JsonViewModel
     * @throws \Exception
     */
    public function onDispatch(MvcEvent $e)
    {
        if ($this->request->isPost() == false) {
            throw new \Exception("Allowed only POST method", 405);
        }

        $e->setResult($this->viewModel);

        $data = $this->request->getPost()->toArray();
        $data['id'] = $this->id;

        $this->inputFilter->setData($data);
        if (!$this->inputFilter->isValid($data)) {
            $this->viewModel->setErrors($this->inputFilter->getMessages());

            return $this->viewModel;
        }

        /** @var Feedback $entity */
        $entity = $this->repository->findById($this->id);
        $entity->populate($this->inputFilter->getValues());
        $entity->setAnswered();

        $this->repository->add($entity);

        $event = new FeedbackEvent(
            FeedbackEvent::EVENT_SEND_ANSWER,
            $this,
            [
                'entity' => $entity,
            ]
        );

        $this->eventManager->trigger($event);

        $this->viewModel->setResult($event);

        return $this->viewModel;
    }
}