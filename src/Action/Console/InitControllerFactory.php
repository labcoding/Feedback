<?php

namespace LabCoding\Feedback\Action\Console;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InitControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        return new InitController(
            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('Config')
        );
    }
}
