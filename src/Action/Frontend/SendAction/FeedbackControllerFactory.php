<?php

namespace LabCoding\Feedback\Action\Frontend\SendAction;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LabCoding\Feedback\ViewModel\JsonViewModel;
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
        $inputFilter = $serviceLocator->get(SendInputFilter::class);
        $repository = $serviceLocator->get('Feedback\Infrastructure\Repository');
        $viewModel = $serviceLocator->get(JsonViewModel::class);
        $eventManager = new EventManager();

        return new FeedbackController($request, $inputFilter, $repository, $viewModel, $eventManager);
    }
}