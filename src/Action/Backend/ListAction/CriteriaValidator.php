<?php

namespace LabCoding\Feedback\Action\Backend\ListAction;

use LabCoding\Feedback\Domain\Feedback;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use T4web\Crud\Validator\BaseFilter;

class CriteriaValidator extends BaseFilter
{
    public function __construct()
    {
        $this->inputFilter = new InputFilter();

        $id = new Input('id');
        $id->setRequired(false);
        $id->getValidatorChain()
            ->attachByName('Digits');
        $this->inputFilter->add($id);

        $message = new Input('message_like');
        $message->setRequired(false);
        $message->getFilterChain()
            ->attachByName('StringTrim');
        $message->getValidatorChain()
            ->attachByName('StringLength', ['min' => 0, 'max' => 250]);
        $this->inputFilter->add($message);

        $status = new Input('status_equalTo');
        $status->setRequired(false);
        $status->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName('InArray', [
                'haystack' => array_keys(Feedback::$statuses)
            ]);
        $this->inputFilter->add($status);

        $createdDtLessThen = new Input('createdDt_lessThan');
        $createdDtLessThen->setRequired(false);
        $this->inputFilter->add($createdDtLessThen);

        $createdDtGreaterThan = new Input('createdDt_greaterThan');
        $createdDtGreaterThan->setRequired(false);
        $this->inputFilter->add($createdDtGreaterThan);

        $limit = new Input('limit');
        $limit->setRequired(false);
        $limit->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName('GreaterThan', ['min' => 0]);
        $this->inputFilter->add($limit);

        $page = new Input('page');
        $page->setRequired(false);
        $page->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName('GreaterThan', ['min' => 0]);
        $this->inputFilter->add($page);

    }
}