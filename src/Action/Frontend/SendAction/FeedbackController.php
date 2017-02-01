<?php

namespace LabCoding\Feedback\Action\Frontend\SendAction;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\RequestInterface;
use Zend\InputFilter\InputFilterInterface;
use T4webDomainInterface\ServiceInterface;
use LabCoding\Feedback\ViewModel\JsonViewModel;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use LabCoding\Feedback\Domain\Feedback;
use LabCoding\Feedback\Event\FeedbackEvent;

class FeedbackController extends AbstractActionController
{

    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var ServiceInterface
     */
    protected $serviceCreator;

    /**
     * @var JsonViewModel
     */
    protected $viewModel;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * FeedbackController constructor.
     *
     * @param RequestInterface $request
     * @param InputFilterInterface $inputFilter
     * @param ServiceInterface $serviceCreator
     * @param JsonViewModel $viewModel
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        RequestInterface $request,
        InputFilterInterface $inputFilter,
        ServiceInterface $serviceCreator,
        JsonViewModel $viewModel,
        EventManagerInterface $eventManager
    )
    {
        $this->request = $request;
        $this->inputFilter = $inputFilter;
        $this->serviceCreator = $serviceCreator;
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
        $this->inputFilter->setData($data);
        if (!$this->inputFilter->isValid($data)) {
            $this->viewModel->setErrors($this->inputFilter->getMessages());

            return $this->viewModel;
        }

        $result = $this->serviceCreator->handle([], $this->inputFilter->getValues());

        if ($result instanceof Feedback) {
            $event = new FeedbackEvent(
                FeedbackEvent::EVENT_NEW_FEEDBACK,
                $this,
                [
                    'entity' => $result,
                ]
            );

            $this->eventManager->trigger($event);
        }

        $this->viewModel->setResult($result);

        return $this->viewModel;
    }
}