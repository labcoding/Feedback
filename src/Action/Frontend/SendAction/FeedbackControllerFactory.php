<?php

namespace LabCoding\Feedback\Action\Frontend\SendAction;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;

class FeedbackControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();

        $request = $serviceLocator->get('Request');
        $inputFilter = $serviceLocator->get('LabCoding\Feedback\InputFilter\SendInputFilter');
        $serviceCreator = $serviceLocator->get('Feedback\Service\Creator');
        $viewModel = $serviceLocator->get('LabCoding\Feedback\ViewModel\JsonViewModel');
        $eventManager = new EventManager();

        return new FeedbackController($request, $inputFilter, $serviceCreator, $viewModel, $eventManager);
    }
}