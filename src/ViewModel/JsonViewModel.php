<?php

namespace LabCoding\Feedback\ViewModel;

use Zend\View\Model\JsonModel;
use Zend\Stdlib\ResponseInterface;
use T4webDomain\Entity;

class JsonViewModel extends JsonModel
{

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->getOption('response');
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->setVariable('errors', $errors);
    }

    /**
     * @param $result
     */
    public function setResult($result)
    {
        if ($result instanceof Entity) {
            $result = $result->extract(['name', 'email', 'message']);
        }

        $this->setVariable('result', $result);
    }

    /**
     * @return array
     */
    public function prepare()
    {
        $result = parent::getVariable('result', null);
        $errors = parent::getVariable('errors', null);

        if (!empty($errors)) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_400);
        }

        return [
            'result' => $result,
            'errors' => $errors,
        ];
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return json_encode($this->prepare());
    }
}