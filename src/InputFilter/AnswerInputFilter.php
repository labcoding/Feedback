<?php

namespace LabCoding\Feedback\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Db\NoRecordExists;
use Zend\InputFilter\Input;
use LabCoding\Feedback\Domain\Feedback;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class AnswerInputFilter extends InputFilter
{

    public function __construct()
    {

        $dbValidator = new NoRecordExists(
            [
                'table' => 'feedback',
                'field' => 'id',
                'adapter' => $this->getAdapter(),
                'exclude' => 'status = ' . Feedback::STATUS_ANSWERED,
                'messages' => [
                    NoRecordExists::ERROR_RECORD_FOUND => 'You already sent answer'
                ],
            ]
        );

        $id = new Input('id');
        $id->getValidatorChain()
            ->attachByName('Digits')
            ->attach($dbValidator, true);
        $this->add($id);

        $answer = new Input('answer');
        $answer->getFilterChain()
            ->attachByName('HtmlEntities')
            ->attachByName('StripTags')
            ->attachByName('StringTrim');
        $answer->getValidatorChain()
            ->attachByName(
                'StringLength',
                [
                    'min' => 1,
                    'max' => 500,
                ]
            );
        $this->add($answer);
    }

    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    private function getAdapter()
    {
        return GlobalAdapterFeature::getStaticAdapter();
    }
}