<?php

namespace LabCoding\Feedback\ViewModel;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class JsonViewModelFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = [
            'response' => $serviceLocator->get('Application')->getMvcEvent()->getResponse(),
        ];

        return new JsonViewModel([], $options);
    }
}
