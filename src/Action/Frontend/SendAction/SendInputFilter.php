<?php

namespace LabCoding\Feedback\Action\Frontend\SendAction;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

class SendInputFilter extends InputFilter
{

    public function __construct()
    {
        $name = new Input('name');
        $name->setRequired(false);
        $name->getFilterChain()
            ->attachByName('HtmlEntities')
            ->attachByName('StringTrim');
        $name->getValidatorChain()
            ->attachByName('StringLength', [
                'max' => 255,
            ]);
        $this->add($name);

        $email = new Input('email');
        $email->setRequired(false);
        $email->getFilterChain()
            ->attachByName('StripTags')
            ->attachByName('StringTrim');
        $email->getValidatorChain()
            ->attachByName('EmailAddress')
            ->attachByName('StringLength', [
                'max' => 255,
            ]);
        $this->add($email);

        $message = new Input('message');
        $message->getFilterChain()
            ->attachByName('HtmlEntities')
            ->attachByName('StringTrim');
        $message->getValidatorChain()
            ->attachByName('StringLength', [
                'max' => 300,
            ]);
        $this->add($message);
    }
}