<?php

namespace LabCoding\Feedback\Action\Backend\AnswerAction;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;

class AnswerActionControllerFactory implements FactoryInterface
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

        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();
        $id = (int)$routeMatch->getParam('id');

        $request = $serviceLocator->get('Request');
        $inputFilter = $serviceLocator->get('LabCoding\Feedback\InputFilter\AnswerInputFilter');
        $repository = $serviceLocator->get('Feedback\Infrastructure\Repository');
        $viewModel = $serviceLocator->get('LabCoding\Feedback\ViewModel\JsonViewModel');
        $eventManager = new EventManager();

        return new AnswerActionController($id, $request, $inputFilter, $repository, $viewModel, $eventManager);
    }
}